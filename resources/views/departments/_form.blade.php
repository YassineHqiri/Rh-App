<div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Department Name <span class="text-red-500">*</span></label>
        <div class="mt-2">
            <input type="text" name="name" id="name"
                   value="{{ old('name', $department->name ?? '') }}" required maxlength="100"
                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('name') ring-red-300 @enderror">
            @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="sm:col-span-2">
        <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
        <div class="mt-2">
            <textarea name="description" id="description" rows="3" maxlength="500"
                      class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('description') ring-red-300 @enderror">{{ old('description', $department->description ?? '') }}</textarea>
            @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="sm:col-span-2">
        <label for="head_id" class="block text-sm font-medium leading-6 text-gray-900">Department Head</label>
        <div class="mt-2">
            <select name="head_id" id="head_id"
                    class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('head_id') ring-red-300 @enderror">
                <option value="">— No Head Selected —</option>
                @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ old('head_id', $department->head_id ?? '') == $employee->id ? 'selected' : '' }}>
                    {{ e($employee->full_name) }} — {{ e($employee->position) }}
                </option>
                @endforeach
            </select>
            @error('head_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
