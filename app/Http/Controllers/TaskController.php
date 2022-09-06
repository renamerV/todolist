<?php

namespace App\Http\Controllers;

use App\Events\TasksUpdated;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

final class TaskController extends Controller
{
    public function index(): array
    {
        return Task::getAll();
    }

    public function store(TaskRequest $request): Task
    {
        return Task::addTask($request->validated());
    }

    public function update(TaskRequest $request, int $id): Task
    {
        return Task::updateTask($id, $request->validated());
    }

    public function destroy(int $id): string
    {
        return Task::deleteTask($id);
    }

    public function findByName(Request $request): array
    {
        return Task::findTaskByName($request->query()['search']);
    }
}
