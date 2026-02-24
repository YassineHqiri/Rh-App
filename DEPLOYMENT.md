# AWS CI/CD Setup (GitHub -> EC2)

This project is prepared for:
- CI on GitHub Actions: `.github/workflows/ci.yml`
- CD to AWS EC2 over SSH: `.github/workflows/deploy-ec2.yml`

## 1) Initialize git locally

Run in project root:

```bash
git init
git add .
git commit -m "chore: prepare github actions ci/cd for aws ec2"
```

## 2) Create GitHub repository and push

```bash
git branch -M main
git remote add origin <YOUR_GITHUB_REPO_URL>
git push -u origin main
```

## 3) Prepare EC2 server (one-time)

On EC2:

1. Install required packages:
   - PHP 8.x + extensions
   - Composer
   - Node.js + npm (if building assets on server)
   - Git
2. Clone repo to your app path (example `/var/www/schoolpro`):

```bash
git clone <YOUR_GITHUB_REPO_URL> /var/www/schoolpro
cd /var/www/schoolpro
cp .env.example .env
php artisan key:generate
```

3. Configure `.env` for production database/app settings.
4. Ensure writable permissions for `storage` and `bootstrap/cache`.

## 4) Add GitHub Actions secrets

In GitHub repo -> Settings -> Secrets and variables -> Actions:

- `EC2_HOST` = public IP or DNS of EC2
- `EC2_USER` = ssh user (e.g. `ubuntu`, `ec2-user`)
- `EC2_SSH_KEY` = private key content (PEM) used for SSH
- `EC2_APP_PATH` = absolute app path on EC2 (e.g. `/var/www/schoolpro`)

## 5) Deployment flow

- Push to `main`
- CI job runs tests
- Deploy job SSHes into EC2 and executes `deployment/deploy.sh`

## Notes

- `deployment/deploy.sh` runs:
  - composer install (`--no-dev`)
  - npm build (if npm exists)
  - `php artisan migrate --force`
  - Laravel cache refresh
- If you use queues/workers, configure Supervisor/systemd separately.
