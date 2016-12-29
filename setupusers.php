<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/23
 * Time: 14:42
 */
require_once  'login.php';
$conn = new mysqli($db_hostname,$db_username,$db_password,$db_database);
if ($conn->connect_errno) die($conn->connect_error);

$query = "CREATE TABLE IF NOT EXISTS users(
forename VARCHAR(32) NOT NULL ,
surname VARCHAR(32) NOT NULL ,
username VARCHAR(32) NOT NULL UNIQUE ,
password VARCHAR(32) NOT NULL
)";
$result = $conn->query($query);
if (!$result) die($conn->error);

$salt1 = "qm&h*";
$salt2 ="pg!@";

$forename = 'Bill';
$surname = 'smith';
$username = 'bsmith';
$password = 'mysecret';
$token = hash('ripemd128',"$salt1$password$salt2");

add_user($conn,$forename,$surname,$username,$token);

$forename = 'pauline';
$surname = 'Jones';
$username = 'pjones';
$password = 'acrobat';
$token = hash('ripemd128',"$salt1$password$salt2");

add_user($conn,$forename,$surname,$username,$token);

function add_user($conn,$fn,$sn,$un,$pw)
{
    $query = "INSERT INTO users VALUES('$fn','$sn','$un','$pw')";
    $result = $conn->query($query);
    if(!$result) die($conn->error);
}
?>