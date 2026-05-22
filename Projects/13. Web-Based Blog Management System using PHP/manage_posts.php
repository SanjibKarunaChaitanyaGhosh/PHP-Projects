<?php
include 'includes/auth.php';
include 'config/db.php';

$query = "SELECT * FROM posts ORDER BY id DESC";

$result = mysqli_query($conn, $query);
?>

<?php include 'includes/header.php'; ?>

<h1 style="text-align:center; margin-bottom:30px;">
    Manage Blog Posts
</h1>

<div class="table-container">

    <table>

        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Title</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)){ ?>

        <tr>

            <td>
                <?php echo $row['id']; ?>
            </td>

            <td>

                <img 
                    src="uploads/<?php echo $row['image']; ?>"
                    class="table-img"
                >

            </td>

            <td>
                <?php echo $row['title']; ?>
            </td>

            <td>
                <?php echo $row['created_at']; ?>
            </td>

            <td>

                <a 
                    href="edit_post.php?id=<?php echo $row['id']; ?>"
                    class="edit-btn"
                >
                    Edit
                </a>

                <a 
                    href="delete_post.php?id=<?php echo $row['id']; ?>"
                    class="delete-btn"
                >
                    Delete
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

<style>

.table-container{
    width:100%;
    overflow-x:auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    padding:15px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

table th{
    background:#007bff;
    color:white;
}

.table-img{
    width:80px;
    height:60px;
    object-fit:cover;
    border-radius:5px;
}

.edit-btn{
    background:#28a745;
    color:white;
    padding:8px 14px;
    text-decoration:none;
    border-radius:5px;
    margin-right:5px;
}

.edit-btn:hover{
    background:#1e7e34;
}

.delete-btn{
    background:#dc3545;
    color:white;
    padding:8px 14px;
    text-decoration:none;
    border-radius:5px;
}

.delete-btn:hover{
    background:#b52a37;
}

@media(max-width:768px){

    table{
        min-width:700px;
    }

}

</style>

<?php include 'includes/footer.php'; ?>