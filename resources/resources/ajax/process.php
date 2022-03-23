<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/17/2019
 * Time: 7:19 AM
 */

$servername="localhost";
$username="root";
$password="";
$dbname="test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password']))
{

    $username=$_POST['username'];
    $password=$_POST['password'];

    $sql="SELECT * FROM user WHERE UserName='$username'";
    $result=mysqli_query($conn, $sql);
    $rows=mysqli_num_rows($result);

    if($rows>0)
    {
        echo "usernameexists";
    }
    else{
        $sql="INSERT INTO user (UserName,Password) VALUES('$username','$password')";
        $result=mysqli_query($conn, $sql);

        if ($result) {
            echo "success";
        }
    }
}