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
    public $sortable;
    public $sortableBetweenStatuses;

    public function mount($statusBoardView = null,
                          $sortable = false,
                          $sortableBetweenStatuses = false)
    {
        $this->statusBoardView = $statusBoardView ?? 'livewire-status-board::status-board';

        $this->sortable = $sortable ?? false;

        $this->sortableBetweenStatuses = $sortableBetweenStatuses ?? false;
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

    public function styles()
    {
        return [
            'wrapper' => 'w-full h-full flex space-x-4 overflow-x-auto',
            'statusWrapper' => 'h-full flex-1',
            'status' => 'bg-blue-200 rounded px-2 flex flex-col h-full',
            'statusHeader' => 'p-2 text-sm text-gray-700',
            'statusFooter' => '',
            'statusRecords' => 'space-y-2 p-2 flex-1 overflow-y-auto',
            'record' => 'shadow bg-white p-2 rounded border',
            'ghost' => 'bg-indigo-200',
        ];
    }

    public function render()
    {
        $statuses = $this->statuses();

        $records = $this->records();

        $statuses = $statuses
            ->map(function ($status) use ($records) {
                $status['group'] = $this->id;
                $status['statusRecordsId'] = "{$this->id}-{$status['id']}";
                $status['records'] = $records
                    ->filter(function ($record) use ($status) {
                        return $this->isRecordInStatus($record, $status);
                    });

                return $status;
            });

        return view($this->statusBoardView)
            ->with([
                'statuses' => $statuses,
                'styles' => $this->styles(),
            ]);
    }
}
