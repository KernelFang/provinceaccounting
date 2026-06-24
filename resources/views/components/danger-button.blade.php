<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'd-inline-block px-4 py-2 mb-4 ms-auto fw-bold text-center text-white bg-danger border-0 rounded-3 shadow pointer fs-6 active bg-danger']) }}>
    {{ $slot }}
</button>
