
{{-- Injected variables $status, $styles --}}
<div class="{{ $styles['statusWrapper'] }}">
    <div class="{{ $styles['status'] }}" id="{{ $status['id'] }}">

        @include($statusHeaderView, [
            'status' => $status
        ])

        <div
            id="{{ $status['statusRecordsId'] }}"
            data-status-id="{{ $status['id'] }}"
            class="{{ $styles['statusRecords'] }}">

            @foreach($status['records'] as $record)
                @include($recordView, [
                    'record' => $record,
                ])
            @endforeach

        </div>

        @include($statusFooterView, [
            'status' => $status
        ])

    </div>
</div>
