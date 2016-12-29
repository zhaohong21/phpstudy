<?php
require_once 'login.php';
$conn = new mysqli($db_hostname,$db_username,$db_password,$db_database);
if ($conn->connect_errno) die($conn->connect_error);
print_r($_POST);///////////////////////


if(isset($_POST['delete']) && isset($_POST['isbn']))
{
    $isbn = get_post($conn,'isbn');
    $query = "DELETE FROM classics WHERE isbn='$isbn'";
    $result = $conn->query($query);
    if(!$result) echo "DELECT failed:$query<br>";
}

if (isset($_POST['author']) &&
    isset($_POST['title']) &&
    isset($_POST['category']) &&
    isset($_POST['year']) &&
    isset($_POST['isbn']))
{
    $author = get_post($conn,'author');
    $title = get_post($conn,'title');
    $category = get_post($conn,'category');
    $year = get_post($conn,'year');
    $isbn = get_post($conn,'isbn');
    $query = "INSERT INTO classics (`author`, `title`, `category`, `year`, `isbn`) VALUES " . "('$author','$title','$category','$year','$isbn');";
    $result = $conn->query($query);
    if (!$result) echo "INSERT failed: $query<br>" .
        $conn->error . "<br><br>";
}

echo <<<_END
<form action="sqltest.php" method="post"><pre>
Author <input type="text" name="author">
Title<input type="text" name="title">
Category<input type="text" name="category">
Year<input type="text" name="year">
ISBN<input type="text" name="isbn">
    <input type="submit" value="ADD RECORD">
</pre></form>
_END;


$query = "SELECT * FROM classics";
$result = $conn->query($query);
if(!$result) die("Database access faild:" . $conn->connect_error);

$rows = $result->num_rows;

for($j=0;$j<$rows;++$j)
{
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    echo <<<_END
<pre>
  Author $row[author]
   Title $row[title]
Category $row[category]
    Year $row[year]
    ISBN $row[isbn]
</pre>
<form action="sqltest.php" method="post">
<input type="hidden" name="delete" value="yes">
<input type="hidden" name="isbn" value="$row[isbn]">
<input type="submit" value="DELETE RECORD"></form>
_END;
}
$result->close();
$conn->close();

function get_post($conn,$var)
{
    return $conn->real_escape_string($_POST[$var]);
}
?>
