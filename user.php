<?php

session_start();

$email = "";
$password = "";
$confirmPassword = "";
$fistName = "";
$lastName = "";

$errors = array();

$db = mysqli_connect('localhost', 'root', '', 'login');

//User registration
if (isset($_POST['register'])) {
    $email = mysqli_real_escape_string($db, $_POST['r-email']);
    $fistName = mysqli_real_escape_string($db, $_POST['r-firstname']);
    $lastName = mysqli_real_escape_string($db, $_POST['r-lastname']);
    $password = mysqli_real_escape_string($db, $_POST['r-password']);
    $confirmPassword = mysqli_real_escape_string($db, $_POST['rc-password']);

    if ($password == $confirmPassword) {
        $password = md5($password);
        $sql_insert = "INSERT INTO `login`(`FirstName`, `LastName`, `Email`, `Password`) 
                        VALUES ('$fistName','$lastName','$email','$password')";

        if(mysqli_query($db,$sql_insert)){
            $_SESSION['email'] = $email;
            echo "<script>alert('Registration Successfull');</script>";
            echo "<script>setTimeout(\"location.href='../home.php';\",100);</script>";
            
        } else {
            echo "<script>alert('There was some problem, Please try again');</script>";
            echo "<script>setTimeout(\"location.href='../signInSignup.php';\",100);</script>";
        }
    } else {
        array_push($errors, "Password did not match");
    }
}


//user login
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($db, $_POST['s-email']);
    $password = mysqli_real_escape_string($db, $_POST['s-password']);

    if (empty($password) || empty($email)) {
        array_push($errors, "Enter the username and password");
       //header('location: ../signInSignup.php');
    } else {
        $password = md5($password);
        $sql_check = "SELECT * FROM `login` WHERE `Email` = '$email' AND `Password` = '$password'";

        $results = mysqli_query($db,$sql_check);

        if(mysqli_num_rows($results) == 1){
            $_SESSION['email'] = $email;
            echo "<script>alert('Log In Successfull');</script>";
            echo "<script>setTimeout(\"location.href='../home.php';\",100);</script>";
           
        } else {
            echo "<script>alert('There was some problem, Please try again');</script>";
            echo "<script>setTimeout(\"location.href='../signInSignup.php';\",100);</script>";
        }
    }
}


?>