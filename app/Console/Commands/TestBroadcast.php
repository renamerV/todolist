<?php

namespace App\Console\Commands;

use App\Events\TasksUpdated;
use App\Models\Task;
use Illuminate\Console\Command;

class TestBroadcast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:br';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $task = new Task();



        $task->fill(['name' => 'test', 'description' => 'test Desc']) ;
        $task->description = 'test Desc';

//        dd($task->toArray());
        $task->save();


//        dd($task);

        TasksUpdated::dispatch($task);
        return 0;
    }
}
