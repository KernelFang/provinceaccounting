@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-danger mb-1 small ps-3']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
