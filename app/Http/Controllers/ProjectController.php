<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(6);

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
        ]);
    }

    public function show(Project $project)
    {
        $tasks = $project->tasks()->paginate(6);

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:15',
            'label' => 'nullable|string|max:5',
            'importance' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string',
            'status' => 'required|boolean',
            'progress' => 'required|integer|min:0|max:100',
            'start_time' => 'nullable|date',
            'finish_time' => 'nullable|date|after_or_equal:start_time',
        ], [
            'title.required' => '標題為必填項目。',
            'title.string' => '標題必須為文字格式。',
            'title.max' => '標題不得超過 10 個字元。',
            'label.string' => '標籤必須為文字格式。',
            'label.max' => '標籤不得超過 5 個字元。',
            'importance.required' => '重要性為必填項目。',
            'importance.integer' => '重要性必須為數字。',
            'importance.min' => '重要性不得小於 1。',
            'importance.max' => '重要性不得大於 5。',
            'content.string' => '內容必須為文字格式。',
            'status.required' => '狀態為必填項目。',
            'status.boolean' => '狀態必須為布林值 (true 或 false)。',
            'progress.required' => '進度為必填項目。',
            'progress.integer' => '進度必須為數字。',
            'progress.min' => '進度不得小於 0。',
            'progress.max' => '進度不得大於 100。',
            'start_time.date' => '開始時間必須為有效日期格式。',
            'finish_time.date' => '結束時間必須為有效日期格式。',
            'finish_time.after_or_equal' => '結束時間必須大於或等於開始時間。',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index');
    }

    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', ['project' => $project]);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'label' => 'nullable|string',
            'importance' => 'required|integer',
            'content' => 'nullable|string',
            'status' => 'boolean',
            'progress' => 'required|integer',
        ], [
            'title.required' => '標題是必填的。',
            'title.string' => '標題必須是字串。',
            'title.max' => '標題的長度不能超過 255 個字元。',
            'label.nullable' => '標籤可以為空。',
            'label.string' => '標籤必須是字串。',
            'importance.required' => '重要性是必填的。',
            'importance.integer' => '重要性必須是整數。',
            'content.nullable' => '內容可以為空。',
            'content.string' => '內容必須是字串。',
            'status.boolean' => '狀態必須是布林值。',
            'progress.required' => '進度是必填的。',
            'progress.integer' => '進度必須是整數。',
        ]);

        $status = $validated['progress'] == 100 ? 1 : 0;

        $validated['status'] = $status;

        $project->update($validated);

        return redirect()->route('projects.index');
    }

    public function complete(Request $request, Project $project)
    {
        $request->validate([
            'status' => 'required|boolean',
            'progress' => 'required|numeric|min:0|max:100',
        ]);

        $status = $request->progress == 100 ? 1 : 0;

        $project->update([
            'status' => $status,
            'progress' => $request->progress,
        ]);

        return redirect()->back();
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }
}
