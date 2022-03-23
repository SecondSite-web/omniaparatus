<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 3:07 PM
 */

<?php

require "../../models/DB/Db.class.php";
$db = new Db();
$dbh = $db->getPurePodo();
include "../../models/PHPAuth/Config.php";
include "../../models/PHPAuth/Auth.php";
$config = new PHPAuth\Config($dbh);
$auth = new PHPAuth\Auth($dbh, $config);
$userhash = $auth->getSessionHash();
$uid = $auth->getSessionUID($userhash);
$result = $auth->getUser($uid);
$email = $result['email'];
$firstname = $result['firstName'];
$lastname = $result['Lastname'];
$username = $result['username'];
?>


<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UCSC VideoBay</title>


    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!--Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../../../public/css/form-elements.css">
    <link rel="stylesheet" href="../../../public/css/ucscvideobay.css">
    <link rel="stylesheet" href="../../../public/css/navbaruser.css">

    <!--<link rel="stylesheet" type="text/css" href="../../../public/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="../../../public/slick/slick-theme.css"/>

    <!-- Color Box -->
    <link rel="stylesheet" href="../../../public/css/colorbox.css" />

    <link rel="stylesheet" href="../../../public/css/animate.css">





</head>

<body>
<div class="wrapper">
    <div class="box">
        <div class="row row-offcanvas row-offcanvas-left">


            <div class="column col-sm-2 col-xs-1 sidebar-offcanvas" id="sidebar">

                <!-- side bar -->
                <?php
include '../../views/includes/sidebar.php';
?>
            </div>
            <!-- main right col -->
            <div class="column col-sm-10 col-xs-11" id="main">
                <?php
include '../includes/userhomenavbar.php';
?>


                <div class="full ">
                    <div class= "container-fluid">
                        <h3 class="text3">GENERAL ACCOUNT SETTINGS</h3>
                        <div class="col-sm-4 col-md-2 col-sm-offset-1 col-md-offset-1" style="padding-bottom: 10px">
                            <img src="../../../assets/images/user.png" class="img-rounded img-responsive" />
                        </div>
                        <div class="col-sm-6 col-md-8">
                            <div class="alert alert-info">
                                <h2>User Bio : </h2>
                                <div class="panel-body">
                                    <label class="control-label col-sm-8 col-md-6 text4"  for="email1">Name :</label>
                                    <label class="control-label col-sm-8 col-md-6 text4"  for="email1"><div id="nameLable"><?php
echo $firstname . " " . $lastname;
?>
</div></label>
                                    <label class="control-label col-sm-8 col-md-6 text4"  for="email1">email :</label>
                                    <label class="control-label col-sm-8 col-md-6 text4"  for="email1"><div id="EmailLabele"> <?php
echo $email;
?>
</div></label>
                                </div>
                            </div>
                        </div>


                        <div id = "setteingFeedback"class=" col-md-offset-1	col-md-10 col-sm-offset-1 col-sm-10 "></div>


                        <div class=" col-md-offset-1	col-md-10 col-sm-offset-1 col-sm-10 ">

                            <div class="panel-group" id="accordion">

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#name">Update Name</a>
                                        </h4>
                                    </div>
                                    <div id="name" class="panel-collapse collapse">
                                        <div class="panel-body">

                                            <form id="nameChange_form" class="horizontal">

                                                <div class="form-group" style="padding-bottom: 30px">
                                                    <label for="inputEmail3" class="col-sm-2 form-control-label">Firstname</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php
echo $firstname;
?>
" placeholder="First Name">
                                                    </div>
                                                </div>

                                                <div class="form-group " style="padding-bottom: 30px">
                                                    <label for="inputEmail3" class="col-sm-2 form-control-label">Lastname</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="LastName" name="LastName" value="<?php
echo $lastname;
?>
" placeholder="Last Name">
                                                    </div>
                                                </div>

                                                <button type="submit" id="nameChangeButton"  class="btn btn-default">Submit</button>
                                                <button type="button" data-toggle="collapse" data-parent="#accordion" href="#name" class="btn btn-default">Cancel</button>
                                             </form>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#email">Change Email address</a>
                                        </h4>
                                    </div>
                                    <div id="email" class="panel-collapse collapse">
                                        <div class="panel-body">


                                            <form id ="mailChangeForm" class="horizontal">
                                                <div class="form-group" style="padding-bottom: 30px;">
                                                    <label class="control-label col-sm-6"  for="email1">Current email </label>
                                                    <label class="control-label col-sm-6"  for="email1"><div id="currentEmail"><?php
echo $email;
?>
</div> </label>
                                                </div>
                                                <div class="form-group" style="padding-bottom: 30px;">
                                                    <label for="inputEmail3" class="col-sm-3 form-control-label">New email</label>
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" id="newemail" name="newemail" placeholder="New Email">
                                                    </div>
                                                </div>

                                                <div class="form-group" style="padding-bottom: 30px;">
                                                    <label for="inputEmail3" class="col-sm-3 form-control-label">Current password</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" id="currentPasswordEmail"  name="currentPasswordEmail" placeholder="password">
                                                    </div>
                                                </div>


                                                <button type="submit" id="change_email" class="btn btn-default">Submit</button>
                                                <button type="button" data-toggle="collapse" data-parent="#accordion" href="#email" class="btn btn-default">Cancel</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#password">Change password</a>
                                        </h4>
                                    </div>
                                    <div id="password" class="panel-collapse collapse">
                                        <div class="panel-body">

                                            <form id = "changePasswordForm" class="horizontal">
                                                <div class="form-group" style="padding-bottom: 30px;">
                                                    <label for="inputEmail3" class="col-sm-3 form-control-label">Current Password</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" id="currentPassword"  name="currentPassword" placeholder="password">
                                                    </div>
                                                </div>
                                                <div class="form-group " style="padding-bottom: 30px;">
                                                    <label for="inputEmail3" class="col-sm-3 form-control-label">New Password </label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" id="newPassword1" name="newPassword" placeholder="password">
                                                    </div>
                                                </div>

                                                <div class="form-group " style="padding-bottom: 30px;">
                                                    <label for="inputEmail3" class="col-sm-3 form-control-label">Confirm Password</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="password">
                                                    </div>
                                                </div>
                                                <button type="submit" id="changePassword" class="btn btn-default">Submit</button>
                                                <button type="button" data-toggle="collapse" data-parent="#accordion" href="#password" class="btn btn-default">Cancel</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>




                        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
                        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
                        <script src="../../../public/js/ucscvideobay.js"></script>
                        <script src="../../../assets/js/validation.js"></script>
                        <script src="../../../public/js/bootstrap-notify.min.js"></script>

                        <script src="../../../public/js/userhome.js"></script>



                        <script>
                            $(document).ready(function() {
                                $("#nameChangeButton").click(function() {
                                    $("#nameChange_form").validate({
                                        rules:{
                                            firstName:{
                                                required: true,
                                                nowhitespace: true,
                                                lettersonly: true

                                            },
                                            LastName: {
                                                required: true,
                                                nowhitespace: true,
                                                lettersonly: true
                                            }

                                        },


                                        //if form is valid do this
                                        submitHandler: function(form) {

                                            //get input field values data to be sent to server
                                            var m_data = new FormData();
                                            var firstname = document.getElementById("firstName" ).value;
                                            var lastname  = document.getElementById("LastName").value;

                                            m_data.append( 'firstName', firstname );
                                            m_data.append( 'LastName',lastname );
                                            m_data.append( 'uid', <?php
echo $uid;
?>
);

                                            //Ajax post data to server
                                            $.ajax({
                                                url: '../../controllers/usermanagement/testName.php',
                                                data: m_data,
                                                processData: false,
                                                contentType: false,
                                                type: 'POST',
                                                dataType:'json',
                                                success: function (response) {
                                                    //load json data from server and output message
                                                    if (response.type == "text") {
                                                        $("#setteingFeedback").hide().html(response.text).slideDown("slow");
                                                        $("#nameLable").html(firstname+" "+lastname ).slideDown("slow")

                                                    } else {
                                                        //$("#feedback").html(response.text);
                                                        $("#setteingFeedback").hide().html(response.text).slideDown("slow");

                                                    }
                                                }
                                            });

                                        }
                                    });

                                });


                            });
                        </script>

                        <script>
                            $(document).ready(function() {

                                $("#change_email").click(function() {

                                    $("#mailChangeForm").validate({
                                        rules:{
                                            newemail:{
                                                required: true,
                                                email: true

                                            },
                                            currentPasswordEmail:{
                                                required: true,
                                            }

                                        },


                                        //if form is valid do this
                                        submitHandler: function(form) {

                                            //get input field values data to be sent to server
                                            var m_data = new FormData();
                                            var email =  document.getElementById("newemail" ).value;
                                            m_data.append( 'newemail', email);
                                            m_data.append( 'currentPassword',  document.getElementById("currentPasswordEmail" ).value);
                                            m_data.append( 'uid', <?php
echo $uid;
?>
);


                                            //Ajax post data to server
                                            $.ajax({
                                                url: '../../controllers/usermanagement/testChangeEmail.php',
                                                data: m_data,
                                                processData: false,
                                                contentType: false,
                                                type: 'POST',
                                                dataType:'json',
                                                success: function (response) {
                                                    //load json data from server and output message
                                                    if (response.type == "text") {
                                                        $("#setteingFeedback").hide().html(response.text).slideDown("slow");
                                                        $("#EmailLabele").html(email).slideDown("slow");
                                                        $("#currentEmail").html(email).slideDown("slow");
                                                        document.getElementById("mailChangeForm").reset();

                                                    } else {
                                                        $("#setteingFeedback").hide().html(response.text).slideDown("slow");

                                                    }

                                                }
                                            });

                                        }
                                    });

                                });


                            });
                        </script>

                        <script>
                            $(document).ready(function() {

                                $("#changePassword").click(function() {

                                    $("#changePasswordForm").validate({
                                        rules:{
                                            currentPassword:{
                                                required: true,
                                                strongPassword: true

                                            },
                                            newPassword: {
                                                required: true,
                                                strongPassword: true
                                            },

                                            confirmPassword: {
                                                required: true,
                                                equalTo: "#newPassword1"
                                            }

                                        },


                                        //if form is valid do this
                                        submitHandler: function(form) {

                                            //get input field values data to be sent to server
                                            var m_data = new FormData();


                                            m_data.append( 'currentPassword',  document.getElementById("currentPassword" ).value);
                                            m_data.append( 'newPassword', document.getElementById("newPassword1").value);
                                            m_data.append( 'confirmPassword', document.getElementById("confirmPassword").value);
                                            m_data.append( 'uid', <?php
echo $uid;
?>
);


                                            //Ajax post data to server
                                            $.ajax({
                                                url: '../../controllers/usermanagement/testChangePassword.php',
                                                data: m_data,
                                                processData: false,
                                                contentType: false,
                                                type: 'POST',
                                                dataType:'json',
                                                success: function (response) {

                                                    //alert(response.text);
                                                    //load json data from server and output message
                                                    if (response.type == "text") {
                                                        $("#setteingFeedback").hide().html(response.text).slideDown("slow");
                                                        document.getElementById("changePasswordForm").reset();

                                                    } else {
                                                        $("#setteingFeedback").hide().html(response.text).slideDown("slow");


                                                    }

                                                }
                                            });

                                        }
                                    });

                                });


                            });
                        </script>
</body>
</html>

Top Functions | Top Classes | Documentation
PHP | C# (CSharp) | Java | Golang | C++ (Cpp) | Python
EN | RU | DE
