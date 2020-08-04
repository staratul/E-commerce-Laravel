    @if(isset($weekdeal))
        <!-- Deal Of The Week Section Begin-->
        <section class="deal-of-week set-bg spad mb-4" data-setbg="{{ asset($weekdeal->image->url) }}">
            <div class="container">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h2>Deal Of The {{ Helper::dealType($weekdeal->deal_type) }}</h2>
                        <p>{!! $weekdeal->content !!} </p>
                        <div class="product-price">
                            ${{ $weekdeal->price }}.00
                            <span>/ {{ $weekdeal->deal_on }}</span>
                        </div>
                    </div>
                    <div class="countdown-timer" id="countdown">
                        <div class="cd-item">
                            <span id="days">0</span>
                            <p>Days</p>
                        </div>
                        <div class="cd-item">
                            <span id="hours">0</span>
                            <p>Hrs</p>
                        </div>
                        <div class="cd-item">
                            <span id="minutes">0</span>
                            <p>Mins</p>
                        </div>
                        <div class="cd-item">
                            <span id="seconds">0</span>
                            <p>Secs</p>
                        </div>
                    </div>
                    <p id="demo"></p>
                    <a href="#" class="primary-btn" id="shop_now_btn">Shop Now</a>
                </div>
            </div>
        </section>
        <!-- Deal Of The Week Section End -->
    @else
        <!-- Deal Of The Week Section Begin-->
        <section class="deal-of-week set-bg spad mb-4" data-setbg="img/time-bg.jpg">
            <div class="container">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h2>Deal Of The Week</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed<br /> do ipsum dolor sit amet,
                            consectetur adipisicing elit </p>
                        <div class="product-price">
                            $35.00
                            <span>/ HanBag</span>
                        </div>
                    </div>
                    <div class="countdown-timer" id="countdown">
                        <div class="cd-item">
                            <span>0</span>
                            <p>Days</p>
                        </div>
                        <div class="cd-item">
                            <span>0</span>
                            <p>Hrs</p>
                        </div>
                        <div class="cd-item">
                            <span>0</span>
                            <p>Mins</p>
                        </div>
                        <div class="cd-item">
                            <span>0</span>
                            <p>Secs</p>
                        </div>
                    </div>
                    <a href="javascript" class="primary-btn">EXPIRED</a>
                </div>
            </div>
        </section>
        <!-- Deal Of The Week Section End -->
    @endif

@push('js')
<script>
    var countDownDate = 0;
    let weekdeal = {!! isset($weekdeal) ? $weekdeal : '0' !!};
   // Set the date we're counting down to
   if(weekdeal) {
    countDownDate = new Date(weekdeal.to_date).getTime();
   }
    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    if(countDownDate !== 0){
        $("#days").text(days);
        $("#hours").text(hours);
        $("#minutes").text(minutes);
        $("#seconds").text(seconds);
    } else {
        $("#days").text('0');
        $("#hours").text('0');
        $("#minutes").text('0');
        $("#seconds").text('0');
    }
    // If the count down is finished, write some text
    if (distance < 0) {
        $.ajax({
            url: "{{ route('weekdeal.expired') }}",
            method: "GET",
            success: function(response) {
                clearInterval(x);
                $("#days").text('0');
                $("#hours").text('0');
                $("#minutes").text('0');
                $("#seconds").text('0');
                $("#shop_now_btn").text("EXPIRED");
                $("#shop_now_btn").attr("href", 'javascript:;');
            },
            error: function(reject) {
                console.log(reject);
            }
        });
    }
    }, 1000);
</script>
@endpush