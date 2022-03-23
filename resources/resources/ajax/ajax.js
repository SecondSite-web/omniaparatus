$(document).ready(function(){
    $("#submit").click(function() {
        var username=$("#username").val();
        var password=$("#password").val();
        if(username.length==0 || password.length==0)
        {
            $("#submit").after ("<br><br><div class='alert alert-danger'>Please fill out the entries</div>");
        }
        else{
            $.post("process.php",{username:username,password:password},function(data){
                    if(data=="usernameexists")
                    {
                        $("#submit").after("<br><br><div class='alert alert-danger'>UserName already taken</div>");
                    }
                    if(data=="success")
                    {
                        $("#submit").after("<br><br><div class='alert alert-success'>You are successfully registered</div>");
                    }
                });
            }
        return false;
    });
});
