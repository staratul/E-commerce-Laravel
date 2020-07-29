{{-- Include Header Link --}}
@include('layouts.inc.header_link')

{{-- Include Top Header --}}
@include('layouts.inc.header_top')

<div id="image-loader" style="display: none"></div>

{{-- Content --}}
@yield('content')

{{-- Partners logo --}}
@include('layouts.inc.partner_logo')

{{-- Include Footer --}}
@include('layouts.inc.footer')

{{-- Include Footer Link --}}
@include('layouts.inc.footer_link')
