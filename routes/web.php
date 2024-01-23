<?php

use Illuminate\Support\Facades\Request; // Add this line to import Request class
use Illuminate\Support\Facades\Route;
use App\Models\Task;

Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'asc')->get();
    return view('tasks', [
        'tasks' => $tasks
    ]);
});

Route::post('/task', function () {
    $validator = Validator::make(Request::all(), [
        'name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task;
    $task->name = Request::input('name');
    $task->save();

    return redirect('/');
});
Route::delete('/task/{id}', function ($id) {
    Task::findOrFail($id)->delete();

    return redirect('/');
});