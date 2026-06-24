@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'ff-heading fw500 mb10']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-danger">*</span>
    @endif
</label>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("label[for]").forEach(function (label) {
            const inputId = label.getAttribute("for");
            const field = document.getElementById(inputId);

            if (field && field.hasAttribute("required")) {
                if (!label.innerHTML.includes('*')) {
                    label.innerHTML += ' <span class="text-danger">*</span>';
                }
            }
        });
    });
</script>