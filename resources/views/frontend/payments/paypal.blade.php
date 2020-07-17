@extends('layouts.pay')

@section('content')
    <form action="" method="GET" id="paytm_form">

    </form>
@endsection


@push('js')
    <script>
        $(() => {
            let id = "{{ isset($userDetail) ? $userDetail->id : '' }}";
            let typeId = "{{ isset($typeId) ? $typeId : '' }}";
            let url = "{{ url('/paypal-payment') }}/"+id+"/"+typeId;
            $("#paytm_form").attr("action", url);
            $("#paytm_form").submit();
        });
    </script>
@endpush
