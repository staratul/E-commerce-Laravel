   <!-- Hero Section Begin -->
   <section class="hero-section">
    <div class="hero-items owl-carousel">
        @foreach ($homeSliders as $slider)
            <div class="single-hero-items set-bg" data-setbg="{{ $slider->image->url }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span><b>{{ $slider->category->category }}</b> {{ $slider->tags }}</span>
                            <h1>{{ $slider->title }}</h1>
                            <p>{!! $slider->content !!}</p>
                            <a href="#" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>{{ $slider->offer }}%</span></h2>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- <div class="single-hero-items set-bg" data-setbg="img/hero-1.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <span>Bag,kids</span>
                        <h1>Black friday</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore</p>
                        <a href="#" class="primary-btn">Shop Now</a>
                    </div>
                </div>
                <div class="off-card">
                    <h2>Sale <span>50%</span></h2>
                </div>
            </div>
        </div>
        <div class="single-hero-items set-bg" data-setbg="img/hero-2.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <span>Bag,kids</span>
                        <h1>Black friday</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore</p>
                        <a href="#" class="primary-btn">Shop Now</a>
                    </div>
                </div>
                <div class="off-card">
                    <h2>Sale <span>50%</span></h2>
                </div>
            </div>
        </div> --}}
    </div>
</section>
<!-- Hero Section End -->
