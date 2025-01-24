<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\StoreTaskRequest;
use App\Services\TaskService;
use App\Http\Resources\V1\TaskResource;
use App\Http\Resources\V1\TaskCollection;
use App\Models\Task;

class TaskAPIController extends Controller
{
    public function __construct(
        private TaskService $taskServiceInstance
    ) {}



    public function index() {

    }

    public function store(StoreTaskRequest $request) {
        $task = $this->taskServiceInstance->createTask($request->validated());


        return response()->json([
            'message' => 'Task created successfully!',
            'task'    => new TaskResource($task)
        ], 201); // 201 Created
    }

    public function show(Task $id) { // Route Model Binding
        return new TaskResource($id); // $id is an instance of the Task model because of Route Model Binding
    }

    public function update() {

    }
}
