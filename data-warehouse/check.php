<?php
session_start();

// check if the user exist in the 'user' table
include  "inc_db.php";

$u_login = $_REQUEST['u_login'];
$u_password = $_REQUEST['u_password'];


$sql = "SELECT * FROM user WHERE u_login='$u_login' AND u_password='$u_password'";
// $sql = "SELECT * FROM user WHERE u_login=\"$u_login\" AND u_password=\"$u_password\"";
$result = $conn->query( $sql );
if( $result->num_rows > 0 ){
    $row = $result->fetch_array( MYSQLI_ASSOC ); // return one row from the query result
    $_SESSION['u_id'] = $row['u_id'];
    $_SESSION['u_pname'] = $row['u_pname'];
    $_SESSION['u_fname'] = $row['u_fname'];
    $_SESSION['u_owner'] = $row['u_owner'];

    /* for the test */
    $_SESSION['u_last_dt'] = $row['u_dt'];
    // update u_dt
    $u_id =  $row['u_id'];
    //$u_dt = date('Y-m-d h:i:s');// server time
    $u_dt = $_REQUEST['u_dt'];// client time
    $_SESSION['u_current_dt'] = $u_dt;

    $update = "UPDATE user SET u_dt='$u_dt' WHERE u_id=$u_id";
    $conn->query( $update );


    // redirect to main.php
    header("location:user.php");

} else {
    $_SESSION['err'] = "Login failed";
    header("location:login_form.php");
}