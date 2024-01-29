@if(session('alert'))
    <script>
        let alertinfo=@json(session('alert'));
        Swal.fire(
            alertinfo.title,
            alertinfo.message,
            alertinfo.icon
        )
    </script>
@endif
