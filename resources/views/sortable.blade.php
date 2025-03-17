<div wire:ignore>
    @script
    <script>
        window.addEventListener('load', function () {
            @foreach($statuses as $status)

            const {{$status['id']}}Element = document.getElementById('{{ $status['statusRecordsId'] }}');

            Sortable.create({{$status['id']}}Element, {
                group: '{{ $sortableBetweenStatuses ? $status['group'] : $status['id'] }}',
                animation: 0,
                ghostClass: '{{ $ghostClass }}',

                setData: function (dataTransfer, dragEl) {
                    dataTransfer.setData('id', dragEl.id);
                },

                onEnd: function (evt) {
                    const sameContainer = evt.from === evt.to;
                    const orderChanged = evt.oldIndex !== evt.newIndex;

                    if (sameContainer && !orderChanged) {
                        return;
                    }

                    const recordId = evt.item.id;

                    const fromStatusId = evt.from.dataset.statusId;
                    const fromOrderedIds = [].slice.call(evt.from.children).map(child => child.id);

                    if (sameContainer) {
                        $wire.call('onStatusSorted', recordId, fromStatusId, fromOrderedIds);
                        return;
                    }

                    const toStatusId = evt.to.dataset.statusId;
                    const toOrderedIds = [].slice.call(evt.to.children).map(child => child.id);

                    $wire.call('onStatusChanged', recordId, toStatusId, fromOrderedIds, toOrderedIds);
                },
            });

            @endforeach
        });
    </script>
    @endscript
</div>
