$(function () { 
    // Validator download from https://jqueryvalidation.org/
    $( document ).ready( function () {
        $( "#password-form" ).validate( {
            rules: {

                currpass: {
                    required: true
                },
                newpass: {
                    required: true,
                    minlength: 8
                },
                repeatnewpass: {
                    required: true,
                    minlength: 8,
                    equalTo: "#newpass"
                },
            },
            messages: {
                currpass: {
                    required: "Please provide a password"
                },
                newpass: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long"
                },
                repeatnewpass: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long",
                    equalTo: "Your Passwords do not match"
                },
            },
            errorElement: "p",
            errorPlacement: function ( error, element ) {
                // Add the `invalid-feedback` class to the error element
                error.addClass( "invalid-feedback" );

                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.next( "label" ) );
                } else {
                    error.insertAfter( element );
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            }
        });
    });

    // when the form is submitted
    $('#password-form').on('submit', function (e) {

        // if the validator does not prevent form submit
        if (!e.isDefaultPrevented()) {
            var url = document.location.origin + "dashboard/php/password.php";

            // POST values in the background the the script URL
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data)
                {
                    // data = JSON object that contact.php returns

                    // we recieve the type of the message: success x danger and apply it to the
                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;

                    // let's compose Bootstrap alert box HTML
                    var alertBox = '<div class="alert-fixed"><div class="icon-wrapper"><i class="fa fa-thumbs-up fa-4x"></i></div></div>';
                    // If we have messageAlert and messageText
                    if (messageAlert && messageText) {
                        // inject the alert to .messages div in our form
                        $('#password-form').find('.messages').html(alertBox);
                        // empty the form
                        $('#password-form')[0].reset();
                    }
                }
            });
            return false;
        }
    })
});