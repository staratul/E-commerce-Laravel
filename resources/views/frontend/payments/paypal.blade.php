@extends('layouts.pay')

@section('content')
    <form action="" method="GET" id="paytm_form">

    </form>
@endsection


@push('js')
    <script>
        $(() => {
            let url = "{{ route('payment') }}";
            $("#paytm_form").attr("action", url);
            $("#paytm_form").submit();
        });
    </script>
@endpush
