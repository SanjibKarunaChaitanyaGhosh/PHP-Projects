<?php
session_start();
include "../config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

$result = $conn->query("SELECT * FROM users");
?>

<h2>Admin Dashboard</h2>
<a href="logout.php">Logout</a>

<table border="1">
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Resume</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td><a href="../uploads/<?= $row['resume'] ?>" download>Download</a></td>
</tr>
<?php } ?>

</table>