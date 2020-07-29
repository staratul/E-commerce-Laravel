addToCart = (product_id,quantity,color,size) => {
    // Submit Form data using ajax
    $("#image-loader").css("display", "block");
    $.ajax({
        url: "/add-cart",
        method: "POST",
        data:{
            product_id,quantity,size,color
        },
        headers: {"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')},
        success: function(response) {
            let url;
            if(response) {
                $.ajax({
                    url: "/add-cart-notifications/"+response.cart.id,
                    method: "GET",
                    success: function(res) {
                        let totalPrice=0, count=0;
                        for(data in res.items) {
                            totalPrice += res.items[data].price;
                            count++;
                        }
                        $("#select-total-price").text('₹'+totalPrice);
                        $(".cart-price").text('₹'+totalPrice);
                        $("#icon_bag_total").text(count);
                        $("#image-loader").css("display", "none");
                    },
                    error: function(reject) {
                        console.log(reject);
                        $("#image-loader").css("display", "none");
                    }
                });
            }
            if(response) {
                $("#image-loader").css("display", "none");
                toastr.success(response.success);
            }
        },
        error: function(reject) {
            $("#image-loader").css("display", "none");
            $.each(reject.responseJSON.errors, function (key, item)
            {
                toastr.error(item);
            });
        }
    });
}

moveToCart = (product_id,quantity,color,size) => {
    addToCart(product_id,quantity,color,size);
    removeFromWishlist(product_id);
}

addToWishlist = (productId) => {
    let className = $(".heart_icon_"+productId).attr('class');
    if (className.indexOf("fa-heart-o") > -1) {
        $("#image-loader").css("display", "block");
        $(".heart_icon_"+productId).removeClass("fa-heart-o");
        $(".heart_icon_"+productId).addClass("fa-heart");
        $(".heart_icon_"+productId).addClass("text-danger");
        $.ajax({
            url: "/product-wishlist/"+"ADD",
            method: "POST",
            data:{ productId },
            headers: {"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                getTotalWishlistAdd();
                $("#image-loader").css("display", "none");
            },
            error: function(reject) {
                $("#image-loader").css("display", "none");
                $.each(reject.responseJSON.errors, function (key, item) {
                    toastr.error(item);
                });
            }
        });
    } else if(className.indexOf("fa-heart") > -1) {
        $("#image-loader").css("display", "block");
        $(".heart_icon_"+productId).removeClass("fa-heart");
        $(".heart_icon_"+productId).removeClass("text-danger");
        $(".heart_icon_"+productId).addClass("fa-heart-o");
        $.ajax({
            url: "/product-wishlist/"+"REMOVE",
            method: "POST",
            data:{ productId },
            headers: {"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                getTotalWishlistRemove();
                $("#image-loader").css("display", "none");
            },
            error: function(reject) {
                $("#image-loader").css("display", "none");
                $.each(reject.responseJSON.errors, function (key, item) {
                    toastr.error(item);
                });
            }
        });
    } else {
        return false;
    }
}

removeFromWishlist = (productId) => {
    $("#image-loader").css("display", "block");
    $.ajax({
        url: "/product-wishlist/"+"REMOVE",
        method: "POST",
        data:{ productId },
        headers: {"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')},
        success: function(response) {
            $("#image-loader").css("display", "none");
            location.reload();
        },
        error: function(reject) {
            $("#image-loader").css("display", "none");
            $.each(reject.responseJSON.errors, function (key, item) {
                toastr.error(item);
            });
        }
    });
}


