<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/23
 * Time: 16:09
 */
require_once  'login.php';
$conn = new mysqli($db_hostname,$db_username,$db_password,$db_database);
if ($conn->connect_errno) die($conn->connect_error);


if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
{
    $un_temp = mysql_entities_fix_string($conn,$_SERVER['PHP_AUTH_USER']);
    $pw_temp = mysql_entities_fix_string($conn,$_SERVER['PHP_AUTH_PW']);

    $query = "SELECT * FROM users WHERE username='$un_temp'";
    $result = $conn->query($query);
    if (!$result) {
        die($conn->error);
    }
    elseif ($result->num_rows)
    {
        $row = $result->fetch_array(MYSQLI_NUM);

            $result->close();

        $salt1 = "qm&h*";
        $salt2 ="pg!@";
        $token = hash('ripemd128',"$salt1$pw_temp$salt2");
        if ($row[3] == $token)
        {
            session_start();
            $_SESSION['username'] = $un_temp;
            $_SESSION['password'] = $pw_temp;
            $_SESSION['forename'] = $row[0];
            $_SESSION['surname'] = $row[1];
            echo "$row[0] $row[1]:
            Hi $row[0],you are now logged in as '$row[2]'";
            die("<p><a href='continue.php'>Click here to continue</a></p>'");
        }
        else {die("Invalid username/password combination");
            }
    }
    else {die("Invalid username/password combination");
        }
}
else
{
    enter_pw();
}
$conn->close();

function enter_pw()
{
    header('WWW-Authenticate: Basic realm="Restricted Section"');
    header('HTTP/1.0 401 Unauthorized');
    $pwr = 0;
    die("please enter your username and password");
}

function mysql_entities_fix_string($conn,$string)
{
    return htmlentities(mysql_fix_string($conn,$string));
}

function mysql_fix_string($conn,$string)
{
    if(get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn->real_escape_string($string);
}
?>