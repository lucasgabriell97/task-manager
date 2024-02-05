<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreTaskRequest, UpdateTaskRequest};
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = $this->task->all();
        return response()->json($tasks, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $this->task->create($request->all());
        return response()->json(['msg' => 'A tarefa foi criada com sucesso!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = $this->task->find($id);

        if($task === null) {
            return response()->json(['erro' => 'Registro pesquisado não existe!'], 404);
        }
        
        return response()->json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->task->find($id);

        if($task === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe.'], 404);
        }

        $task->update($request->all());
        return response()->json(['msg' => 'A tarefa foi atualizada com sucesso!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = $this->task->find($id);

        if($task === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe.'], 404);
        }

        $task->delete();
        return response()->json(['msg' => 'A tarefa foi removida com sucesso!'], 200);
    }
}
