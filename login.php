<?php
session_start();
include('commonMethods.php');


$debug = false;
$COMMON = new Common($debug);

$username = mysql_real_escape_string($_POST['tbUsername']);
$password = crypt($_POST['pfPassword'], "insecure_salt");

// function in COMMON class that does an sql query to see if a user exists
if ($COMMON->userExists($username, $_SERVER["login.php"]))
{
    // function that checks if a password matches username
    if ($COMMON->passwordMatch($username, $password, $_SERVER["login.php"]))
    {
        $user = $COMMON->userSearch($username, $_SERVER["login.php"]);
        if ($user['active'] != 0)
        {
            $_SESSION['user'] = $username;
            header("Location: userMain.php");
            exit;
        }
        else
        {
            echo("You have been blocked, please contact the admin.");
        }
    }
    else
    {
        echo("Invalid password");
    }
}
else
{
    echo("Account not found.");
}

?>
