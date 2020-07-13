function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

(function( $ ){
        var PLUGIN_NS = 'paymentForm';
        var Plugin = function ( target, options )  {
            this.$T = $(target);
            this._init( target, options );
            this.options= $.extend(
                true,               // deep extend
                {
                    DEBUG: false
                },
                options
            );
            this._cardIcons = {
                "visa"          : "fa fa-cc-visa",
                "mastercard"    : "fa fa-cc-mastercard",
                "amex"          : "fa fa-cc-amex",
                "dinersclub"    : "fa fa-cc-diners-club",
                "discover"      : "fa fa-cc-discover",
                "jcb"           : "fa fa-cc-jcb",
                "default"       : "fa fa-credit-card-alt"
            };
            return this;
        }
        /** #### INITIALISER #### */
        Plugin.prototype._init = function ( target, options ) {
            var base = this;
            base.number = this.$T.find("[data-payment='cc-number']");
            base.exp = this.$T.find("[data-payment='cc-exp']");
            base.cvc = this.$T.find("[data-payment='cc-cvc']");
            base.name = this.$T.find("[data-payment='cc-name']");
            base.brand = this.$T.find("[data-payment='cc-brand']");
            // Set up all payment fields inside the payment form
            base.number.payment('formatCardNumber').data('payment-error-message', 'Please enter a valid credit card number.');
            base.exp.payment('formatCardExpiry').data('payment-error-message', 'Please enter a valid expiration date.');
            base.cvc.payment('formatCardCVC').data('payment-error-message', 'Please enter a valid CVC.');
            // Update card type on input
            base.number.on('input', function() {
                base.cardType = $.payment.cardType(base.number.val());
                var fg = base.number.closest('.form-group');
                fg.toggleClass('has-feedback', true);
                fg.find('.form-control-feedback').remove();
                if (base.cardType) {
                    base.brand.text(base.cardType);
                    // Also set an icon
                    var icon = base._cardIcons[base.cardType] ? base._cardIcons[base.cardType] : base._cardIcons["default"];
                    fg.append("<i class='" + icon + " fa-lg payment-form-icon form-control-feedback'></i>");
                } else {
                    $("[data-payment='cc-brand']").text("");
                }
            });

            // Validate card number on change
            base.number.on('change', function () {
                base._setValidationState($(this), !$.payment.validateCardNumber($(this).val()));
            });

            // Validate card expiry on change
            base.exp.on('change', function () {
                base._setValidationState($(this), !$.payment.validateCardExpiry($(this).payment('cardExpiryVal')));
            });

            // Validate card cvc on change
            base.cvc.on('change', function () {
                base._setValidationState($(this), !$.payment.validateCardCVC($(this).val(), base.cardType));
            });
        };
        /** #### PUBLIC API (see notes) #### */
        Plugin.prototype.valid = function () {
            var base = this;
            var num_valid = $.payment.validateCardNumber(base.number.val());
            var exp_valid = $.payment.validateCardExpiry(base.exp.payment('cardExpiryVal'));
            var cvc_valid = $.payment.validateCardCVC(base.cvc.val(), base.cardType);
            base._setValidationState(base.number, !num_valid);
            base._setValidationState(base.exp, !exp_valid);
            base._setValidationState(base.cvc, !cvc_valid);
            return num_valid && exp_valid && cvc_valid;
        }
        /** #### PRIVATE METHODS #### */
        Plugin.prototype._setValidationState = function(el, erred) {
            var fg = el.closest('.form-group');
            fg.toggleClass('has-error', erred).toggleClass('has-success', !erred);
            fg.find('.payment-error-message').remove();
            if (erred) {
                fg.append("<span class='text-danger payment-error-message'>" + el.data('payment-error-message') + "</span>");
            }
            return this;
        }
        /**
        * EZ Logging/Warning (technically private but saving an '_' is worth it imo)
        */
        Plugin.prototype.DLOG = function () {
            if (!this.DEBUG) return;
            for (var i in arguments) {
                console.log( PLUGIN_NS + ': ', arguments[i] );
            }
        }
        Plugin.prototype.DWARN = function () {
            this.DEBUG && console.warn( arguments );
        }
        $.fn[ PLUGIN_NS ] = function( methodOrOptions ) {
            if (!$(this).length) {
                return $(this);
            }
            var instance = $(this).data(PLUGIN_NS);
            // CASE: action method (public method on PLUGIN class)
            if ( instance
                    && methodOrOptions.indexOf('_') != 0
                    && instance[ methodOrOptions ]
                    && typeof( instance[ methodOrOptions ] ) == 'function' ) {
                return instance[ methodOrOptions ]( Array.prototype.slice.call( arguments, 1 ) );
            // CASE: argument is options object or empty = initialise
            } else if ( typeof methodOrOptions === 'object' || ! methodOrOptions ) {
                instance = new Plugin( $(this), methodOrOptions );    // ok to overwrite if this is a re-init
                $(this).data( PLUGIN_NS, instance );
                return $(this);
            // CASE: method called before init
            } else if ( !instance ) {
                $.error( 'Plugin must be initialised before using method: ' + methodOrOptions );
            // CASE: invalid method
            } else if ( methodOrOptions.indexOf('_') == 0 ) {
                $.error( 'Method ' +  methodOrOptions + ' is private!' );
            } else {
                $.error( 'Method ' +  methodOrOptions + ' does not exist.' );
            }
        };
})(jQuery);
/* Initialize validation */
var payment_form = $('#payment-stripe').paymentForm();
$('#validate').on('click', function(){
    var valid = $('#payment-stripe').paymentForm('valid');
    let name = $("#cc-name").val();
    if(name == "") {
        $("#cc-name-error").text("Please enter card holder name.");
        $("#cc-name").css("border", "1px solid red");
        return false;
    } else {
        $("#cc-name-error").text("");
        $("#cc-name").css("border", "");
    }
});

$("#cc-name").on("keypress", () => {
    $("#cc-name-error").text("");
    $("#cc-name").css("border", "");
});

let $form =  $('#payment-form');
let key = "{{ env('STRIPE_KEY') }}";
Stripe.setPublishableKey(key);
$form.on('submit', function(e) {
    e.preventDefault();
    $("#card_error_message").removeClass("alert alert-danger");
    $("#card_error_message").text("");
    $("#validate").attr('disabled', true);
    Stripe.card.createToken({
        number: $('#cc-number').val(),
        exp_month: Number($("#cc-exp").val().split('/')[0]),
        cvc: $('#cc-cvc').val(),
        exp_year: Number($("#cc-exp").val().split('/')[1]),
        name: $('#cc-cvc').val(),
    }, stripeResponseHandler);
    return false;
});

function stripeResponseHandler(status, response) {
    console.log(response);
    if (response.error) {
        $("#card_error_message").addClass("alert alert-danger");
        $("#card_error_message").text(response.error.message);
        $("#validate").attr('disabled', false);
    } else {
        /* token contains id, last4, and card type */
        var token = response['id'];
        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
        $form.get(0).submit();
    }
}
