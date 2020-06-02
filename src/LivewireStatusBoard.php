<?php

namespace Asantibanez\LivewireStatusBoard;

use Illuminate\Support\Collection;
use Livewire\Component;

/**
 * Class LivewireStatusBoard
 * @package Asantibanez\LivewireStatusBoard
 * @property boolean $sortable
 * @property boolean $sortableBetweenStatuses
 * @property string $statusBoardView
 * @property string $statusView
 * @property string $statusHeaderView
 * @property string $statusFooterView
 * @property string $recordView
 * @property string $beforeStatusBoardView
 * @property string $afterStatusBoardView
 */
class LivewireStatusBoard extends Component
{
    public $sortable;
    public $sortableBetweenStatuses;

    public $statusBoardView;
    public $statusView;
    public $statusHeaderView;
    public $statusFooterView;
    public $recordView;
    public $beforeStatusBoardView;
    public $afterStatusBoardView;

    public function mount($sortable = false,
                          $sortableBetweenStatuses = false,
                          $statusBoardView = null,
                          $statusView = null,
                          $statusHeaderView = null,
                          $statusFooterView = null,
                          $recordView = null,
                          $beforeStatusBoardView = null,
                          $afterStatusBoardView = null)
    {
        $this->sortable = $sortable ?? false;
        $this->sortableBetweenStatuses = $sortableBetweenStatuses ?? false;

        $this->statusBoardView = $statusBoardView ?? 'livewire-status-board::status-board';
        $this->statusView = $statusView ?? 'livewire-status-board::status';
        $this->statusHeaderView = $statusHeaderView ?? 'livewire-status-board::status-header';
        $this->statusFooterView = $statusFooterView ?? 'livewire-status-board::status-footer';
        $this->recordView = $recordView ?? 'livewire-status-board::record';
        $this->beforeStatusBoardView = $beforeStatusBoardView ?? null;
        $this->afterStatusBoardView = $afterStatusBoardView ?? null;

        $this->afterMount();
    }

    public function afterMount()
    {
        //
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

    public function onStatusSorted($recordId, $statusId, $orderedIds)
    {
        //
    }

    public function onStatusChanged($recordId, $statusId, $fromOrderedIds, $toOrderedIds)
    {
        //
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

        $styles = $this->styles();

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
                'styles' => $styles,
            ]);
    }
}
