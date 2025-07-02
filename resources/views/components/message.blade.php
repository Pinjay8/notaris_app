@once
@if (session('success'))
<script>
    notyf().position('x', 'right').position('y', 'top').success("{{ session('success') }}");
</script>
@endif

@if (session('error'))
<script>
    notyf().position('x', 'right').position('y', 'top').error("{{ session('error') }}");
</script>
@endif
@endonce