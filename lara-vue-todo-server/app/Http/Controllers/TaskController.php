<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    //Index
    public function index() {
        return Task::all();
    }

    //Show
    public function show($id) {
        return Task::find($id);
    }

    //Store to DB
    public function store(Request $request) {
        return Task::create($request->all());
    }

    //Update
    public function update(Request $request, $id) {
        $task = Task::findOrFail($id);
        $task->update($request->all());
    }

    //Delete
    public function delete(Request $request, $id) {
        $task= Task::findOrFail($id);
        $task->delete();

        return 204;
    }
}
