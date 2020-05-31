
{{-- Injected variables $status, $styles --}}
<div class="{{ $styles['statusWrapper'] }}">
    <div class="{{ $styles['status'] }}" id="{{ $status['id'] }}">

        @include('livewire-status-board::status-header', [
            'status' => $status
        ])

        <div
            id="{{ $status['statusRecordsId'] }}"
            data-status-id="{{ $status['id'] }}"
            class="{{ $styles['statusRecords'] }}">

            @foreach($status['records'] as $record)
                @include('livewire-status-board::record', [
                    'record' => $record,
                ])
            @endforeach

        </div>

        @include('livewire-status-board::status-footer', [
            'status' => $status
        ])

    </div>
</div>
