<!-- Js Plugins -->
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('dashboard/dist/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dashboard/dist/js/additional-methods.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
<script src="{{asset('js/jquery.zoom.min.js')}}"></script>
<script src="{{ asset('js/jquery.dd.min.js') }}"></script>
<script src="{{ asset('js/jquery.slicknav.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('dashboard/dist/js/toastr.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script>
    $(function() {
        $("#profile-dropdown").mouseover(() => {
            $(".dropdown-content").css("display", "block");
        });
        $(".dropdown-content").mouseover(() => {
            $(".dropdown-content").css("display", "block");
        });
        $(".dropdown-content").mouseout(() => {
            $(".dropdown-content").css("display", "none");
        });
        $("#profile-dropdown").mouseout(() => {
            $(".dropdown-content").css("display", "none");
        });
        $('.alert-danger').fadeIn().delay(5000).fadeOut();
        $('.alert-success').fadeIn().delay(5000).fadeOut();
    });

    getTotalWishlistRemove = () => {
        let count = 0;
        count = Number($("#icon_heart_alt").text());
        if(count) {
            $("#icon_heart_alt").text(--count);
        } else {
            count = "{{ count(json_decode(Cookie::get('wishlist'), true)) }}";
            $("#icon_heart_alt").text(--count);
        }
    }
    getTotalWishlistAdd = () => {
        let count = 0;
        count = Number($("#icon_heart_alt").text());
        if(count) {
            $("#icon_heart_alt").text(++count);
        } else {
            count = "{{ count(json_decode(Cookie::get('wishlist'), true)) }}";
            $("#icon_heart_alt").text(++count);
        }
    }
</script>
@stack('js')
</body>

</html>
