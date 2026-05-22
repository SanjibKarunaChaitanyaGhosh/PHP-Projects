<?php
include 'config/db.php';

$result = mysqli_query($conn, "SELECT * FROM posts");
?>

<table border="1">

<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <td><?php echo $row['id']; ?></td>

    <td><?php echo $row['title']; ?></td>

    <td>
        <a href="edit_post.php?id=<?php echo $row['id']; ?>">
            Edit
        </a>

        <a href="delete_post.php?id=<?php echo $row['id']; ?>">
            Delete
        </a>
    </td>
</tr>

<?php } ?>

</table>