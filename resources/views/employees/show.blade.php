@extends('layouts.app')

@section('title', $employee->full_name)

@section('content')
<div class="mb-8">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('employees.index') }}" class="hover:text-gray-700">Employees</a></li>
            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></li>
            <li class="font-medium text-gray-900">{{ e($employee->full_name) }}</li>
        </ol>
    </nav>
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ e($employee->full_name) }}</h1>
            <p class="mt-1 text-sm text-gray-500">{{ e($employee->position) }}
                @if($employee->department)
                &mdash; {{ e($employee->department->name) }}
                @endif
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-x-3">
            <a href="{{ route('employees.edit', $employee) }}"
               class="inline-flex items-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z"/>
                </svg>
                Edit
            </a>
            @can('delete', $employee)
            <form method="POST" action="{{ route('employees.destroy', $employee) }}"
                  onsubmit="return confirm('Are you sure you want to delete this employee?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 transition">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5z" clip-rule="evenodd"/>
                    </svg>
                    Delete
                </button>
            </form>
            @endcan
        </div>
    </div>
</div>

{{-- Tabbed Layout --}}
<div x-data="{ activeTab: '{{ request('tab', 'details') }}' }">
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button @click="activeTab = 'details'" :class="activeTab === 'details' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium transition">
                Details
            </button>
            <button @click="activeTab = 'notes'" :class="activeTab === 'notes' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium transition">
                Notes <span class="ml-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $employee->notes->count() }}</span>
            </button>
            <button @click="activeTab = 'documents'" :class="activeTab === 'documents' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium transition">
                Documents <span class="ml-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $employee->documents->count() }}</span>
            </button>
            <button @click="activeTab = 'history'" :class="activeTab === 'history' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium transition">
                History
            </button>
        </nav>
    </div>

    {{-- Details Tab --}}
    <div x-show="activeTab === 'details'" x-cloak>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900">Personal Information</h2>
                </div>
                <dl class="divide-y divide-gray-100">
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Full name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ e($employee->full_name) }}</dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ e($employee->email) }}</dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ e($employee->phone) ?: '—' }}</dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $employee->date_of_birth ? $employee->date_of_birth->format('F j, Y') : '—' }}</dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ e($employee->address) ?: '—' }}</dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Emergency Contact</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            @if($employee->emergency_contact)
                            {{ e($employee->emergency_contact) }}
                            @if($employee->emergency_phone)
                            <span class="text-gray-500">({{ e($employee->emergency_phone) }})</span>
                            @endif
                            @else
                            —
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900">Job Information</h2>
                </div>
                <dl class="divide-y divide-gray-100">
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Position</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ e($employee->position) }}</dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Department</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            @if($employee->department)
                            <a href="{{ route('departments.show', $employee->department) }}" class="text-indigo-600 hover:text-indigo-500">{{ e($employee->department->name) }}</a>
                            @else
                            <span class="text-gray-400">Unassigned</span>
                            @endif
                        </dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Salary</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 sm:col-span-2 sm:mt-0">{{ number_format($employee->salary, 2) }} DH</dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $employee->hire_date->format('F j, Y') }}</dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Contract End</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                            @if($employee->contract_end_date)
                            <span class="{{ $employee->contract_end_date->isPast() ? 'text-red-600 font-medium' : ($employee->contract_end_date->diffInDays(now()) <= 90 ? 'text-amber-600 font-medium' : 'text-gray-900') }}">
                                {{ $employee->contract_end_date->format('F j, Y') }}
                                @if($employee->contract_end_date->isPast())
                                (Expired)
                                @elseif($employee->contract_end_date->diffInDays(now()) <= 90)
                                ({{ $employee->contract_end_date->diffForHumans() }})
                                @endif
                            </span>
                            @else
                            <span class="text-gray-400">No end date</span>
                            @endif
                        </dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 sm:col-span-2 sm:mt-0">
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $employee->status === 'active' ? 'bg-green-50 text-green-700 ring-1 ring-green-600/20' : 'bg-red-50 text-red-700 ring-1 ring-red-600/20' }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2 sm:mt-0">{{ $employee->created_at->format('M d, Y H:i') }} by {{ e($employee->creator->name ?? 'System') }}</dd>
                    </div>
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Last updated</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2 sm:mt-0">{{ $employee->updated_at->format('M d, Y H:i') }} by {{ e($employee->updater->name ?? 'System') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    {{-- Notes Tab --}}
    <div x-show="activeTab === 'notes'" x-cloak>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-base font-semibold text-gray-900">Internal Notes</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($employee->notes as $note)
                        <div class="px-6 py-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-x-2 mb-1">
                                        <span class="text-sm font-medium text-gray-900">{{ e($note->creator->name ?? 'System') }}</span>
                                        <span class="text-xs text-gray-400">{{ $note->created_at->diffForHumans() }}</span>
                                        @if($note->is_private)
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20">Private</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ e($note->content) }}</p>
                                </div>
                                @if($note->created_by === auth()->id() || auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('employees.notes.destroy', [$employee, $note]) }}"
                                      onsubmit="return confirm('Delete this note?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 ml-3">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-8 text-center text-sm text-gray-500">No notes yet. Add the first note below.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-base font-semibold text-gray-900">Add Note</h2>
                    </div>
                    <form method="POST" action="{{ route('employees.notes.store', $employee) }}" class="p-6">
                        @csrf
                        <div class="mb-4">
                            <textarea name="content" rows="4" required maxlength="2000" placeholder="Write an internal note..."
                                      class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('content') ring-red-300 @enderror"></textarea>
                            @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-x-2 text-sm text-gray-600">
                                <input type="checkbox" name="is_private" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                Private note
                            </label>
                            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition">
                                Add Note
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Documents Tab --}}
    <div x-show="activeTab === 'documents'" x-cloak>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-base font-semibold text-gray-900">Documents</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($employee->documents as $document)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-x-3">
                                <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ e($document->title) }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ strtoupper($document->file_type) }} &middot; {{ number_format($document->file_size / 1024, 1) }} KB
                                        &middot; {{ $document->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-x-2">
                                <a href="{{ route('employees.documents.download', [$employee, $document]) }}"
                                   class="text-gray-400 hover:text-indigo-600" title="Download">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('employees.documents.destroy', [$employee, $document]) }}"
                                      onsubmit="return confirm('Delete this document?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-8 text-center text-sm text-gray-500">No documents uploaded yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-base font-semibold text-gray-900">Upload Document</h2>
                    </div>
                    <form method="POST" action="{{ route('employees.documents.store', $employee) }}" enctype="multipart/form-data" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" required maxlength="255"
                                   class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                            @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category" id="category"
                                    class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                <option value="contract">Contract</option>
                                <option value="id_document">ID Document</option>
                                <option value="certificate">Certificate</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File <span class="text-red-500">*</span></label>
                            <input type="file" name="file" id="file" required
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-gray-500">PDF, JPG, PNG, DOC, DOCX. Max 5MB.</p>
                            @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition">
                            Upload
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- History Tab --}}
    <div x-show="activeTab === 'history'" x-cloak>
        <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900">Change History</h2>
            </div>
            <div class="flow-root px-6 py-4">
                <ul role="list" class="-mb-4">
                    @forelse($auditLogs as $log)
                    <li class="pb-4">
                        <div class="relative flex gap-x-3">
                            <div class="relative flex h-6 w-6 flex-none items-center justify-center">
                                @if($log->action === 'created')
                                <div class="h-2 w-2 rounded-full bg-green-500 ring-2 ring-green-100"></div>
                                @elseif($log->action === 'updated')
                                <div class="h-2 w-2 rounded-full bg-blue-500 ring-2 ring-blue-100"></div>
                                @elseif($log->action === 'deleted')
                                <div class="h-2 w-2 rounded-full bg-red-500 ring-2 ring-red-100"></div>
                                @else
                                <div class="h-2 w-2 rounded-full bg-gray-400 ring-2 ring-gray-100"></div>
                                @endif
                            </div>
                            <div class="flex-auto">
                                <p class="text-xs text-gray-600">
                                    <span class="font-medium text-gray-900">{{ e($log->user->name ?? 'System') }}</span>
                                    {{ $log->action }} this record
                                </p>
                                <time class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</time>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="py-4 text-center text-sm text-gray-500">No history available.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
