<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(CreateTaskRequest $request)
    {
        try {

            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'La tâche a été créée avec succès.',
                'data' => $task,
            ], 201);
        } catch (Exception $e) {
            return response()->json($e); 
        }
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = $request->status;

            $task->save();

            return response()->json([
                'success' => true,
                'message' => 'La tâche a été créée avec succès.',
                'data' => $task,
            ], 201);

        }
        catch(Exception $e){
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::find($id);
            if (!$task) {
                return response()->json([
                    "success" => false,
                    "message" => "Tâche introuvable.",
                ], 404);
            }

            $task->delete();

            return response()->json([
                "success"=> true,
                "message"=> "Tache suprrimee avec succes",
                "data"=>$task
            ],201);

        } catch(Exception $e){
            return  response()->json($e);
        }
        
    }
}
