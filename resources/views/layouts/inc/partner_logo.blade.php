   <!-- Partner Logo Section Begin -->
   <div class="partner-logo">
    <div class="container">
        <div class="logo-carousel owl-carousel">
            @if (isset($logos))
                @foreach ($logos as $logo)
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{ asset(env('APP_URL').'/uploads/admin/partnerlogo/'.$logo->logo) }}" alt="{{ $logo->title ?? '' }}">
                    </div>
                </div>  
                @endforeach
            @endif
            {{-- <div class="logo-item">
                <div class="tablecell-inner">
                    <img src="{{ asset('img/logo-carousel/logo-2.png') }}" alt="">
                </div>
            </div>
            <div class="logo-item">
                <div class="tablecell-inner">
                    <img src="{{ asset('img/logo-carousel/logo-3.png') }}" alt="">
                </div>
            </div>
            <div class="logo-item">
                <div class="tablecell-inner">
                    <img src="{{ asset('img/logo-carousel/logo-4.png') }}" alt="">
                </div>
            </div>
            <div class="logo-item">
                <div class="tablecell-inner">
                    <img src="{{ asset('img/logo-carousel/logo-5.png') }}" alt="">
                </div>
            </div> --}}
        </div>
    </div>
</div>
<!-- Partner Logo Section End -->
