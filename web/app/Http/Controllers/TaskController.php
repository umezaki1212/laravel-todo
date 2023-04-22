<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Folder $folder)
    {
        $folders = Auth::user()->folders()->get();

        $tasks = $folder->tasks()->get();

        return view("tasks/index", [
            "folders" => $folders,
            "current_folder" => $folder,
            "tasks" => $tasks
        ]);
    }

    public function showCreateForm(Folder $folder)
    {
        return view("tasks/create", [
            "folder" => $folder
        ]);
    }

    public function create(Folder $folder, CreateTask $request): RedirectResponse
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);

        return redirect()->route("tasks.index", $folder);
    }

    public function showEditForm(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);

        return view("tasks/edit", [
            "task" => $task
        ]);
    }

    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $this->checkRelation($folder, $task);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route("tasks.index", $folder);
    }

    private function checkRelation(Folder $folder, Task $task)
    {
        if ($folder->id !== $task->folder_id) {
            abort(404);
        }
    }
}
