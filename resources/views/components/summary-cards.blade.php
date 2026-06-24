@props([
    'title' => 'Summary',
    'subtitle' => '',
    'showing' => null,
    'cards' => [], // array of ['label'=>'','value'=>'','unit'=>'','class'=>'']
])

<div class="ps-widget bg-white bdrs4 p20 mb20 overflow-hidden position-relative">
    <div class="d-flex align-items-start justify-content-between mb-3">
        <div>
            <h5 class="mb-1">{{ $title }}</h5>
            @if ($subtitle)
                <p class="text-muted mb-0">{{ $subtitle }}</p>
            @endif
        </div>
        @if (!is_null($showing))
            <div class="text-end">
                <small class="text-muted">Showing {{ $showing }} records</small>
            </div>
        @endif
    </div>

    <div class="row g-3">
        @foreach ($cards as $card)
            <div class="col-12 col-md-{{ $card['col'] ?? 3 }}">
                <div class="p-3 h-100 bdrs4 bg-light">
                    <small class="text-muted">{{ $card['label'] }}</small>
                    @php
                        $valueDisplay = (string) ($card['value'] ?? '');
                        $valueClass = $card['class'] ?? '';
                        if (trim($valueDisplay) !== '' && strpos(trim($valueDisplay), '-') === 0) {
                            if (stripos($valueClass, 'text-danger') === false) {
                                $valueClass = trim(($valueClass ? $valueClass . ' ' : '') . 'text-danger');
                            }
                        }
                    @endphp

                    <div class="h5 mb-0 {{ $valueClass }}">{{ $card['value'] }} @if (!empty($card['unit']))
                            <small class="text-muted">{{ $card['unit'] }}</small>
                        @endif
                    </div>
                    @if (!empty($card['note']))
                        <p class="mb-0 text-muted small">{{ $card['note'] }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
