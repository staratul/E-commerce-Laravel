addToCart = (product_id,quantity,color,size) => {
    // Submit Form data using ajax
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
                    },
                    error: function(reject) {
                        console.log(reject);
                    }
                });
            }
            if(response) {
                toastr.success(response.success);
            }

        },
        error: function(reject) {
            $.each(reject.responseJSON.errors, function (key, item)
            {
                toastr.error(item);
            });
        }
    });
}
