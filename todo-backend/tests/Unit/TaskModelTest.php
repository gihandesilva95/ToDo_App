<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;

class TaskModelTest extends TestCase
{
    public function test_fillable_fields()
    {
        $task = new Task();
        $this->assertEquals(
            ['task_name', 'description', 'status'],
            $task->getFillable()
        );
    }
}

