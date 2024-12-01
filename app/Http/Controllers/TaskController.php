<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{

    public function index(Project $project)
    {
        $tasks = $project->tasks()->paginate(6);
        
        return Inertia::render('Tasks/Index', [
            'project' => $project,
            'tasks' => $tasks
        ]);
    }

    public function create(Project $project)
    {
        return Inertia::render('Tasks/Create', [
            'project' => $project
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:10',
            'content' => 'nullable|string',
            'status' => 'boolean',
        ], [
            'title.required' => '標題是必填的。',
            'title.string' => '標題必須是字串。',
            'title.max' => '標題不能超過 :max 個字元。',
            'content.string' => '內容必須是字串。',
            'status.boolean' => '狀態必須是布林值。',
        ]);

        $task = $project->tasks()->create($validated);

        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project, Task $task)
    {
        return Inertia::render('Tasks/Show', [
            'project' => $project,
            'task' => $task
        ]);
    }

    public function edit(Project $project, Task $task)
    {
        return Inertia::render('Tasks/Edit', [
            'project' => $project,
            'task' => $task,
        ]);
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'boolean',
        ]);
    
        $task->update($validated);
    
        return redirect()->route('projects.show', $project)->with('success', 'Task updated successfully.');
    }

    public function complete(Request $request, Project $project, Task $task)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        if ($task->project_id !== $project->id) {
            return redirect()->back()->with('error', '這不是有效的任務！');
        }

        $task->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', '任務狀態已更新');
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return redirect()->back();
    }
}
