@extends('layouts.app')

@section('content')
    {{-- Include Banner --}}
    @include('layouts.inc.home_banner')
    {{-- Include Banner --}}
    @include('layouts.inc.banner')

    {{-- Include Deal Of Week --}}
    @include('layouts.inc.deal_of_week')

    {{-- Include Women Section --}}
    @include('layouts.inc.women_banner')

    {{-- Include Deal Of Week --}}
    @include('layouts.inc.kid_banner')

    {{-- Include Men Section --}}
    @include('layouts.inc.men_banner')

    {{-- Include Instagram Section --}}
    @include('layouts.inc.instagram')

    {{-- Include Blog Section --}}
    @include('layouts.inc.blog')
@endsection


