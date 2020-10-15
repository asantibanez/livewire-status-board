<?php

namespace Asantibanez\LivewireStatusBoard\Tests\Stubs;

use Asantibanez\LivewireStatusBoard\LivewireStatusBoard;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class SampleLivewireStatusBoard extends LivewireStatusBoard
{
    use WithFaker;

    public $recordClicked = false;
    public $statusSortedCalled = false;
    public $statusChangedCalled = false;

    public function statuses(): Collection
    {
        return collect([
            [
                'id' => 'todo',
                'title' => 'To Do',
            ],
            [
                'id' => 'completed',
                'title' => 'Completed',
            ],
        ]);
    }

    public function records(): Collection
    {
        $this->setUpFaker();

        return collect([
            [
                'id' => Uuid::uuid4()->toString(),
                'status' => 'todo',
                'title' => $this->faker->name,
                'clicked' => false,
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'status' => 'completed',
                'title' => $this->faker->name,
                'clicked' => false,
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'status' => 'completed',
                'title' => $this->faker->name,
                'clicked' => false,
            ],
        ]);
    }

    public function onRecordClick($recordId)
    {
        $this->recordClicked = true;
    }

    public function onStatusSorted($recordId, $statusId, $orderedIds)
    {
        $this->statusSortedCalled = true;
    }

    public function onStatusChanged($recordId, $statusId, $fromOrderedIds, $toOrderedIds)
    {
        $this->statusChangedCalled = true;
    }
}
