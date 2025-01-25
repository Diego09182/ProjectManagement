<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download(File $file)
    {
        if (!Storage::disk('public')->exists($file->path)) {
            return redirect()->back()->with('error', '檔案不存在或已被刪除。');
        }

        return Storage::disk('public')->download($file->path, basename($file->path));
    }

    public function create(Project $project)
    {
        return inertia('Files/Create', [
            'project' => $project,
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'files.*' => 'required|file|max:4096',
            'project_id' => 'required|exists:projects,id',
        ], [
            'files.*.required' => '每個檔案都是必填的。',
            'files.*.file' => '每個上傳的檔案必須是有效的檔案。',
            'files.*.max' => '每個檔案的大小不能超過 4MB。',
            'project_id.required' => '專案 ID 是必填的。',
            'project_id.exists' => '指定的專案不存在。',
        ]);

        if ($request->hasFile('files')) {

            $existingFileCount = $project->files()->count();

            if ($existingFileCount >= 5) {
                return redirect()->back()->withErrors([
                    'files' => "此專案最多只能有 5 個檔案，目前已有 {$existingFileCount} 個檔案。",
                ])->withInput();
            }

            $uploadedFile = $request->file('files')[0];
            $path = $uploadedFile->store('uploads', 'public');
            $name = $uploadedFile->getClientOriginalName();

            $project->files()->create([
                'name' => $name,
                'path' => $path,
                'project_id' => $project->id,
            ]);
        }
        else
        {
            return redirect()->back()->withErrors([
                'files' => '請選擇要上傳的檔案。',
            ])->withInput();
        }

        return redirect()->route('projects.show', $project);
    }

    public function destroy(File $file)
    {
        $file->delete();

        return redirect()->back();
    }
}
