<script>
    window.onload = () => {
        @foreach($statuses as $status)
        Sortable.create(document.getElementById('{{ $status['statusRecordsId'] }}'), {
            group: '{{ $sortableBetweenStatuses ? $status['group'] : $status['id'] }}',
            animation: 150,
            ghostClass: '{{ $styles['ghost'] }}',

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
                const fromOrderedIds = $(evt.from).children().map((index, child) => child.id).get();

                if (sameContainer) {
                @this.call('onStatusSorted', recordId, fromStatusId, fromOrderedIds);
                    return;
                }

                const toStatusId = evt.to.dataset.statusId;
                const toOrderedIds = $(evt.to).children().map((index, child) => child.id).get();

                @this.call('onStatusChanged', recordId, toStatusId, fromOrderedIds, toOrderedIds);
            },
        });
        @endforeach
    }
</script>
