$(document).ready(function() {
    $('#dataTable').DataTable();
});
$('.status').change(processDel);
function processDel(e) {
    e.preventDefault();
    var id=$(this).parent("form").attr('id');
    $.ajax( {
        type: 'POST',
        url: document.location.origin + '/php/user-status.php',
        data: $('#'+ id).serialize(),
        success: function(data) {
            var messageAlert = 'alert-' + data.type;
            var messageText = data.message;
            var alertBox = '<div class="alert-fixed"><div class="icon-wrapper"><i class="fa fa-thumbs-up fa-4x"></i></div></div>';                    if (messageAlert && messageText) {
                $(".card-body").find('.alerts').html(alertBox);
                $('#'+ id)[0].reset();
            }
            setTimeout(function(){
                window.location.replace("/users-table.php");
            }, 200);
        }
    } );
}
$('.select').change(processForm);
function processForm(e) {
    e.preventDefault();
    var id=$(this).parent("form").attr('id');
    $.ajax( {
        type: 'POST',
        url: document.location.origin + '/php/change-userrole.php',
        data: $('#'+ id).serialize(),
        success: function(data) {
            var messageAlert = 'alert-' + data.type;
            var messageText = data.message;
            var alertBox = '<div class="alert-fixed"><div class="icon-wrapper"><i class="fa fa-thumbs-up fa-4x"></i></div></div>';                    if (messageAlert && messageText) {
                $(".card-body").find('.alerts').html(alertBox);
                $('#'+ id)[0].reset();
            }
            setTimeout(function(){
                window.location.replace("/users-table.php");
            }, 200);
        }
    } );
}
$( document ).ready( function () {
// when the form is submitted
    $('.profile-form').on('submit', function (e) {

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
                        window.location.replace("/users-table.php");
                    }
                }
            });
            return false;
        }
    })
    });
    $('.profile-pic').on('submit', function (e) {

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
                    window.location.replace("/users-table.php");
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