<?php

include "db.php";

include "header.php";

?>

<div class="container">

<h2>Stored Documents</h2>

<form method="GET" class="search-box">

<input type="text" name="search" placeholder="Search document title">

<input type="submit" value="Search">

</form>

<table>

<thead>

<tr>

<th>ID</th>
<th>Title</th>
<th>Filename</th>
<th>Date</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php

if(isset($_GET['search']))
{

$search = $_GET['search'];

$query = "SELECT * FROM documents
WHERE title LIKE '%$search%'";

}
else
{

$query = "SELECT * FROM documents";

}

$result = mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td data-label="ID">
<?php echo $row['id']; ?>
</td>

<td data-label="Title">
<?php echo $row['title']; ?>
</td>

<td data-label="Filename">
<?php echo $row['filename']; ?>
</td>

<td data-label="Date">
<?php echo $row['upload_date']; ?>
</td>

<td data-label="Action">

<a class="download-btn"
href="download.php?file=<?php echo $row['filename']; ?>">
Download
</a>

|

<a class="delete-btn"
href="delete.php?id=<?php echo $row['id']; ?>">
Delete
</a>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

<?php include "footer.php"; ?>