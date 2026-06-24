@if (session('success') || session('error') || session('info'))
    @php
        $icon = session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : 'info'));
        $title = session('success') ? 'Success' : (session('error') ? 'Error' : 'Information');
        $text = session('success') ?? (session('error') ?? session('info'));
    @endphp

    <script>
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "{{ $icon }}",
            title: "{{ $title }}",
            text: "{{ $text }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
