$(function () { 
    // Validator download from https://jqueryvalidation.org/
    $( document ).ready( function () {
        $( "#profile-form" ).validate( {
            rules: {
                firstname: "required",
                lastname: "required",
                userrole: "required",
                email: {
                    required: true,
                    email: true
                },
            },
            messages: {
                firstname: "Please enter your firstname",
                lastname: "Please enter your lastname",
                userrole: "Please enter your lastname",
                email: "Please enter a valid email address"
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
    $('#profile-form').on('submit', function (e) {

        // if the validator does not prevent form submit
        if (!e.isDefaultPrevented()) {
            var url = document.location.origin + "/php/profile.php";

            // POST values in the background the the script URL
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data)
                {   

                        // we recieve the type of the message: success x danger and apply it to the
                        var messageAlert = 'alert-' + data.type;
                        var messageText = data.message;

                        // let's compose Bootstrap alert box HTML
                        var alertBox = '<div class="alert-fixed"><div class="icon-wrapper"><i class="fa fa-thumbs-up fa-4x"></i></div></div>';
                        // If we have messageAlert and messageText
                        if (messageAlert && messageText) {
                            // inject the alert to .messages div in our form
                            $('#profile-form').find('.messages').html(alertBox);
                            // empty the form
                            $('#profile-form')[0].reset();
                        }
                        if (data.type === 'success') {
                        window.location.replace("/");
                    }
                }
            });
            return false;
        }
    })
});
$('#profile-pic').on('submit', function (e) {

    // if the validator does not prevent form submit
    if (!e.isDefaultPrevented()) {
        var url = document.location.origin + "/php/profile-pic.php";

        // POST values in the background the the script URL
        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (data)
            {

                // we recieve the type of the message: success x danger and apply it to the
                var messageAlert = 'alert-' + data.type;
                var messageText = data.message;
                if(data.type === 'success') {
                    window.location.replace("/");
                }
                // let's compose Bootstrap alert box HTML
                var alertBox = '<div class="ml-5 alert alert-dismissible d-inline alert-'+data.type+'">'+messageText+'</div>';
                // If we have messageAlert and messageText
                if (messageAlert && messageText) {
                    // inject the alert to .messages div in our form
                    $('#profile-pic').find('.messages').html(alertBox);
                    // empty the form
                }

            }
        });
        return false;
    }
});
$(function () {
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
});
$(function () {
    $('#opening_date').datetimepicker({
        format: 'YYYY-MM'
    });
});