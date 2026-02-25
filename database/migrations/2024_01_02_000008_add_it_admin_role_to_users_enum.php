<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'hr', 'it_admin') NOT NULL DEFAULT 'hr'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'hr') NOT NULL DEFAULT 'hr'");
    }
};
