<div class="w-full h-full flex space-x-4 overflow-x-auto">

    @foreach($statuses as $status)
        <div class="min-w-full sm:min-w-0 bg-blue-200 rounded px-2 flex flex-col">
            <div class="p-2 text-sm text-gray-700">
                {{ $status['title'] }}
            </div>
            <div class="space-y-2 p-2 flex-1 overflow-y-auto"
                 data-status-id="{{ $status['id'] }}"
                 data-status-title="{{ $status['title'] }}"
                 id="{{ $componentId }}-{{ $status['id'] }}">

                @php
                    $statusRecords = $records
                        ->filter(function ($record) use ($isRecordInStatus, $status) {
                            return $isRecordInStatus($record, $status);
                        });
                @endphp

                @foreach($statusRecords as $record)
                    <div
                        id="{{ $record['id'] }}"
                        class="shadow bg-white p-2 rounded border">
                        {{ $record['title'] }}
                    </div>
                @endforeach
            </div>

        </div>
    @endforeach

    <div wire:ignore>
        <script>
            window.onload = () => {
                @foreach($statuses as $status)
                Sortable.create(document.getElementById('{{ $componentId }}-{{ $status['id'] }}'), {
                    group: '{{ $componentId }}',
                    animation: 150,
                    ghostClass: 'bg-indigo-200',
                    setData: function (dataTransfer, dragEl) {
                        dataTransfer.setData('id', dragEl.id);
                    },

                    onEnd: function (/**Event*/evt) {
                        const sameContainer = evt.from === evt.to;
                        const orderChanged = evt.oldIndex !== evt.newIndex;

                        if (sameContainer && !orderChanged) {
                            return;
                        }

                        const dataId = evt.item.id;

                        const fromStatusId = evt.from.dataset.statusId;
                        const fromOrderedIds = $(evt.from).children().map((index, child) => child.id).get();

                        if (sameContainer) {
                        @this.call('onStatusSorted', dataId, fromStatusId, fromOrderedIds);
                            return;
                        }

                        const toStatusId = evt.to.dataset.statusId;
                        const toOrderedIds = $(evt.to).children().map((index, child) => child.id).get();

                    @this.call('onStatusChanged', dataId, toStatusId, fromOrderedIds, toOrderedIds);
                    },
                });
                @endforeach
            }
        </script>
    </div>
</div>
