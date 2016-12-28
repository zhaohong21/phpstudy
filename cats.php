<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/21
 * Time: 11:36
 */
require_once 'login.php';
$conn = new mysqli($db_hostname,$db_username,$db_password,$db_database);
if($conn->connect_error) die($conn->connect_error);

$query = "CREATE TABLE IF NOT EXISTS cats (
id SMALLINT NOT NULL AUTO_INCREMENT,
family VARCHAR(32) NOT NULL,
name VARCHAR(32) NOT NULL,
age TINYINT NOT NULL,
PRIMARY KEY (id)
)";
$result = $conn->query($query);
if(!$result) die("Database access failed:" . $conn->error);

describe($conn,'cats');

function describe($conn,$ob)
{
    $query = "DESCRIBE $ob";
    $result = $conn->query($query);
    $rows = $result->num_rows;
    echo "<table><tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th></tr>";

    for($j=0;$j<$rows;++$j)
    {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_NUM);

        echo "<tr>";
        foreach ($row as $item) {
            echo "<td>$item</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>