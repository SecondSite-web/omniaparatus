$(document).ready(function(){
    $('#btnSubmit').click(function(e) {
        e.preventDefault();
        if ($('form').smkValidate()) {
            if( $.smkEqualPass('#pass1', '#pass2') ) {
                // Code here
                $.smkAlert({
                    text: 'Validate!',
                    type: 'success'
                });
            }
        }
    });

    // Form Clear
    $('#btnClear').click(function(e) {
        e.preventDefault();
        $('form').smkClear();
    });
});