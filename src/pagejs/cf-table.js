$(document).ready(function() {
    $('#dataTable').DataTable();
});
$('select').change(processForm);
function processForm(e) {
    e.preventDefault();
    var id=$(this).parent("form").attr('id');
    $.ajax( {
        type: 'POST',
        url: document.location.origin + '/php/change-cf-status.php',
        data: $('#'+ id).serialize(),
        success: function(data) {
            var messageAlert = 'alert-' + data.type;
            var messageText = data.message;
            var alertBox = '<div class="alert-fixed"><div class="icon-wrapper"><i class="fa fa-thumbs-up fa-4x"></i></div></div>';          if (messageAlert && messageText) {
                $(".card-body").find('.alerts').html(alertBox);
                $('#'+ id)[0].reset();
            }
            setTimeout(function(){
                window.location.replace("/contact-form-table.php");
            }, 200);
        }
    } );
}