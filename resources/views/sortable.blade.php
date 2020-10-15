<script>
    window.onload = () => {
        @foreach($statuses as $status)
            Sortable.create(document.getElementById('{{ $status['statusRecordsId'] }}'), {
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
                        @this.call('onStatusSorted', recordId, fromStatusId, fromOrderedIds);
                        return;
                    }

                    const toStatusId = evt.to.dataset.statusId;
                    const toOrderedIds = [].slice.call(evt.to.children).map(child => child.id);

                    @this.call('onStatusChanged', recordId, toStatusId, fromOrderedIds, toOrderedIds);
                },
            });
        @endforeach
    }
</script>
