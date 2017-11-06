@if(session()->has('success'))
    <script>
        toastr.success("{{ session()->get('success') }}");
    </script>
@elseif(($errors->any()))
    <script>
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    </script>
@endif