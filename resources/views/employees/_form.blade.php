<div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
    <div>
        <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First Name <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <input type="text" name="first_name" id="first_name"
                   value="{{ old('first_name', $employee->first_name ?? '') }}" required maxlength="100"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('first_name') ring-red-300 @enderror">
            @error('first_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last Name <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <input type="text" name="last_name" id="last_name"
                   value="{{ old('last_name', $employee->last_name ?? '') }}" required maxlength="100"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('last_name') ring-red-300 @enderror">
            @error('last_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email Address <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <input type="email" name="email" id="email"
                   value="{{ old('email', $employee->email ?? '') }}" required maxlength="255"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('email') ring-red-300 @enderror">
            @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone</label>
        <div class="mt-2">
            <input type="text" name="phone" id="phone"
                   value="{{ old('phone', $employee->phone ?? '') }}" maxlength="20"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('phone') ring-red-300 @enderror">
            @error('phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="date_of_birth" class="block text-sm font-medium leading-6 text-gray-900">Date of Birth</label>
        <div class="mt-2">
            <input type="date" name="date_of_birth" id="date_of_birth"
                   value="{{ old('date_of_birth', isset($employee) && $employee->date_of_birth ? $employee->date_of_birth->format('Y-m-d') : '') }}"
                   max="{{ date('Y-m-d') }}"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('date_of_birth') ring-red-300 @enderror">
            @error('date_of_birth')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="department_id" class="block text-sm font-medium leading-6 text-gray-900">Department</label>
        <div class="mt-2">
            <select name="department_id" id="department_id"
                    class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('department_id') ring-red-300 @enderror">
                <option value="">— No Department —</option>
                @foreach($departments ?? [] as $dept)
                <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                    {{ e($dept->name) }}
                </option>
                @endforeach
            </select>
            @error('department_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="position" class="block text-sm font-medium leading-6 text-gray-900">Position <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <input type="text" name="position" id="position"
                   value="{{ old('position', $employee->position ?? '') }}" required maxlength="150"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('position') ring-red-300 @enderror">
            @error('position')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="salary" class="block text-sm font-medium leading-6 text-gray-900">Salary (DH) <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <input type="number" name="salary" id="salary" step="0.01" min="0"
                   value="{{ old('salary', $employee->salary ?? '') }}" required
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('salary') ring-red-300 @enderror">
            @error('salary')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="hire_date" class="block text-sm font-medium leading-6 text-gray-900">Hire Date <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <input type="date" name="hire_date" id="hire_date"
                   value="{{ old('hire_date', isset($employee) && $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '') }}" required
                   max="{{ date('Y-m-d') }}"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('hire_date') ring-red-300 @enderror">
            @error('hire_date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="contract_end_date" class="block text-sm font-medium leading-6 text-gray-900">Contract End Date</label>
        <div class="mt-2">
            <input type="date" name="contract_end_date" id="contract_end_date"
                   value="{{ old('contract_end_date', isset($employee) && $employee->contract_end_date ? $employee->contract_end_date->format('Y-m-d') : '') }}"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('contract_end_date') ring-red-300 @enderror">
            @error('contract_end_date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="status" class="block text-sm font-medium leading-6 text-gray-900">Status <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <select name="status" id="status" required
                    class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('status') ring-red-300 @enderror">
                <option value="active" {{ old('status', $employee->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $employee->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="emergency_contact" class="block text-sm font-medium leading-6 text-gray-900">Emergency Contact</label>
        <div class="mt-2">
            <input type="text" name="emergency_contact" id="emergency_contact"
                   value="{{ old('emergency_contact', $employee->emergency_contact ?? '') }}" maxlength="100"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('emergency_contact') ring-red-300 @enderror">
            @error('emergency_contact')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="emergency_phone" class="block text-sm font-medium leading-6 text-gray-900">Emergency Phone</label>
        <div class="mt-2">
            <input type="text" name="emergency_phone" id="emergency_phone"
                   value="{{ old('emergency_phone', $employee->emergency_phone ?? '') }}" maxlength="20"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('emergency_phone') ring-red-300 @enderror">
            @error('emergency_phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="sm:col-span-2">
        <label for="address" class="block text-sm font-medium leading-6 text-gray-900">Address</label>
        <div class="mt-2">
            <textarea name="address" id="address" rows="2" maxlength="500"
                      class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('address') ring-red-300 @enderror">{{ old('address', $employee->address ?? '') }}</textarea>
            @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
