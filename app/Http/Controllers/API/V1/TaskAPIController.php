<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\{
    StoreTaskRequest,
    GetTasksRequest,
    UpdateTaskRequest,
    UpdateTaskStatusRequest
};
use App\Http\Resources\V1\{
    TaskResource,
    TaskCollection
};


class TaskAPIController extends Controller
{
    public function __construct(
        private TaskService $taskServiceInstance
    ) {}



    // Retrieve All/Filtered Tasks
    public function index(GetTasksRequest $request) {
        $tasks = $this->taskServiceInstance->getFilteredTasks($request->validated());

        return new TaskCollection($tasks);
    }

    public function store(StoreTaskRequest $request) {
        $task = $this->taskServiceInstance->createTask($request->validated());

        return new TaskResource($task);
    }

    public function show(Task $id) { // Route Model Binding
        return new TaskResource($id); // $id is an instance of the Task model due to Route Model Binding
    }

    public function update(UpdateTaskRequest $request, Task $id) {
        try {
            $updatedTask = $this->taskServiceInstance->updateTask($id, $request->validated()); // $id is an instance of the Task model due to Route Model Binding
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()], 400
            );
        }


        return new TaskResource($updatedTask);
    }



    public function updateStatus(UpdateTaskStatusRequest $request, Task $id) {
        try {
            $updatedStatusTask = $this->taskServiceInstance->updateTaskStatus($id, $request->validated()); // $id is an instance of the Task model due to Route Model Binding
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()], 400
            );
        }


        return new TaskResource($updatedStatusTask);
    }

    public function getUserAssignedTasks() {
        $userTasks = $this->taskServiceInstance->getUserTasks(Auth::id());

        return new TaskCollection($userTasks);
    }

}
