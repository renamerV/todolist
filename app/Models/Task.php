<?php

namespace App\Models;

use App\Events\TasksUpdated;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    public string $name;
    public string $description;
    public bool $completed;

    protected $fillable = [
        'name',
        'description',
        'completed',
    ];


    // TODO: Лучше вынести следующие методы в репозиторий TaskRepository:
    static public function getAll(): array
    {
        return Task::orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public static function addTask(array $data): Task
    {
        $task = new Task();
        $task->fill($data);
        $task->save();

        self::fireEvent();

        return $task;
    }

    public static function updateTask(int $id, array $data): Task
    {
        $task = Task::findOrFail($id);

        $task->fill($data);
        $task->updated_at = Carbon::now();
        $task->save();

        self::fireEvent();

        return $task;
    }

    public static function deleteTask(int $id): string
    {
        $task = Task::findOrFail($id);

        $task->delete();

        self::fireEvent();

        return "Task deleted";
    }

    static public function findTaskByName(string|null $name): array
    {
        if ($name === '') {
            return self::getAll();
        }

        return Task::where('name', 'LIKE', '%' . $name . '%')
            ->get()
            ->toArray();
    }

    private static function fireEvent(): void
    {
        event(new TasksUpdated('task-updated'));
    }
}
