<?php

namespace Asantibanez\LivewireStatusBoard;

use Illuminate\Support\Collection;
use Livewire\Component;

/**
 * Class LivewireStatusBoard
 * @package Asantibanez\LivewireStatusBoard
 * @property string $statusBoardView
 */
class LivewireStatusBoard extends Component
{
    public $statusBoardView;

    public function mount($statusBoardView = null)
    {
        $this->statusBoardView = $statusBoardView ?? 'livewire-status-board::status-board';
    }

    public function statuses() : Collection
    {
        return collect();
    }

    public function records() : Collection
    {
        return collect();
    }

    public function isRecordInStatus($record, $status)
    {
        return $record['status'] == $status['id'];
    }

    public function onStatusSorted($dataId, $statusId, $orderedIds)
    {
        dd($dataId, $statusId, $orderedIds);
    }

    public function onStatusChanged($dataId, $statusId, $fromOrderedIds, $toOrderedIds)
    {
        dd($dataId, $statusId, $fromOrderedIds, $toOrderedIds);
    }

    public function render()
    {

        return view($this->statusBoardView)
            ->with([
                'componentId' => $this->id,
                'statuses' => $this->statuses(),
                'records' => $this->records(),
                'isRecordInStatus' => function($record, $status) {
                    return $this->isRecordInStatus($record, $status);
                }
            ]);
    }
}
