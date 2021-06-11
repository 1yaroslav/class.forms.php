<?php
$id = $_GET['id'];
$stat = "SELECT id FROM articles WHERE id = $id";
$result = mysqli_query($conn, $stat);
if (mysqli_num_rows($result) > 0 ) {
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo  '<h2>'. $row['title'].' </h2><br>'. $row['date'].'<p><h4>' . $row['content'] . '</p></h4>';
	}
}
?>
