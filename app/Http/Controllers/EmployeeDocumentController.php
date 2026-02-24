<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeDocumentController extends Controller
{
    public function store(Request $request, Employee $employee)
    {
        abort_unless($request->user()?->hasHrAccess(), 403);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:contract,id_document,certificate,other'],
            'file' => [
                'required',
                'file',
                'max:5120',
                'mimes:pdf,jpg,jpeg,png,doc,docx',
                'mimetypes:application/pdf,image/jpeg,image/png,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
        ]);

        $file = $request->file('file');
        $disk = config('filesystems.documents_disk', 'documents');
        $safeName = Str::uuid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = strtolower($file->getClientOriginalExtension());
        $path = $file->storeAs(
            "documents/{$employee->id}",
            "{$safeName}.{$extension}",
            $disk
        );

        $document = $employee->documents()->create([
            'title' => $request->input('title'),
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $extension,
            'file_size' => $file->getSize(),
            'category' => $request->input('category'),
            'uploaded_by' => $request->user()->id,
        ]);

        AuditService::logModelCreated($document);

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function download(Employee $employee, EmployeeDocument $document)
    {
        abort_unless(auth()->user()?->hasHrAccess(), 403);

        if ($document->employee_id !== $employee->id) {
            abort(404);
        }

        $disk = config('filesystems.documents_disk', 'documents');
        if (!Storage::disk($disk)->exists($document->file_path)) {
            return back()->with('error', 'File not found.');
        }

        AuditService::log(
            'document_downloaded',
            EmployeeDocument::class,
            $document->id
        );

        return Storage::disk($disk)->download($document->file_path, $document->file_name);
    }

    public function destroy(Employee $employee, EmployeeDocument $document)
    {
        abort_unless(auth()->user()?->hasHrAccess(), 403);

        if ($document->employee_id !== $employee->id) {
            abort(404);
        }

        if (!auth()->user()->isAdmin() && $document->uploaded_by !== auth()->id()) {
            abort(403, 'Only admins or the uploader can delete this document.');
        }

        $disk = config('filesystems.documents_disk', 'documents');
        Storage::disk($disk)->delete($document->file_path);

        AuditService::logModelDeleted($document);
        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}
