$( document ).ready( function () {
// when the form is submitted
    $('#profile-form').on('submit', function (e) {

        // if the validator does not prevent form submit
        if (!e.isDefaultPrevented()) {
            var url = document.location.origin + "/php/add.php";

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
                        window.location.replace("/add-new-user.php");
                    }
                }
            });
            return false;
        }
    })
});

