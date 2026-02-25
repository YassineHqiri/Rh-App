<div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
    <div>
        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <input type="text" name="name" id="name"
                   value="{{ old('name', $user->name ?? '') }}" required maxlength="255"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('name') ring-red-300 @enderror">
            @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <input type="email" name="email" id="email"
                   value="{{ old('email', $user->email ?? '') }}" required maxlength="255"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('email') ring-red-300 @enderror">
            @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="role" class="block text-sm font-medium leading-6 text-gray-900">Role <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <select name="role" id="role" required
                    class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('role') ring-red-300 @enderror">
                <option value="hr" {{ old('role', $user->role ?? 'hr') === 'hr' ? 'selected' : '' }}>HR</option>
                <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="it_admin" {{ old('role', $user->role ?? '') === 'it_admin' ? 'selected' : '' }}>IT Admin</option>
            </select>
            @error('role')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-end">
        <label class="inline-flex items-center gap-x-2 text-sm text-gray-700">
            <input type="checkbox" name="is_active" value="1"
                   {{ old('is_active', isset($user) ? (int) $user->is_active : 1) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
            Active account
        </label>
    </div>

    <div>
        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
            Password
            @if(!isset($user))
                <span class="text-red-500">*</span>
            @endif
        </label>
        <div class="mt-2">
            <input type="password" name="password" id="password"
                   {{ !isset($user) ? 'required' : '' }} minlength="8"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('password') ring-red-300 @enderror">
            @if(isset($user))
                <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password.</p>
            @endif
            @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password @if(!isset($user))<span class="text-red-500">*</span>@endif</label>
        <div class="mt-2">
            <input type="password" name="password_confirmation" id="password_confirmation"
                   {{ !isset($user) ? 'required' : '' }} minlength="8"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
        </div>
    </div>
</div>
