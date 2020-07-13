@extends('layouts.pay')

@section('content')
    <form action="" method="POST" id="paytm_form">
        @csrf
    </form>
@endsection


@push('js')
    <script>
        $(() => {
            let id = "{{ isset($userDetail) ? $userDetail->id : '' }}";
            let url = "{{ route('make.payment', ':id') }}";
            url = url.replace(":id", id);
            $("#paytm_form").attr("action", url);
            $("#paytm_form").submit();
        });
    </script>
@endpush
