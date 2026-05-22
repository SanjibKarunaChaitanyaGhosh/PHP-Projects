<?php
include 'config/db.php';

$id = $_GET['id'];

$query = "SELECT * FROM posts WHERE id=$id";
$result = mysqli_query($conn, $query);

$post = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $title = $_POST['title'];
    $content = $_POST['content'];

    // Check if new image uploaded
    if($_FILES['image']['name'] != ""){

        $image = $_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "uploads/".$image
        );

        $updateQuery = "UPDATE posts 
                        SET title='$title',
                            content='$content',
                            image='$image'
                        WHERE id=$id";

    } else {

        $updateQuery = "UPDATE posts 
                        SET title='$title',
                            content='$content'
                        WHERE id=$id";
    }

    mysqli_query($conn, $updateQuery);

    header("Location: manage_posts.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .form-container{
            width:90%;
            max-width:600px;
            margin:40px auto;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        .form-container h1{
            text-align:center;
            margin-bottom:20px;
        }

        .form-group{
            margin-bottom:20px;
        }

        .form-group input,
        .form-group textarea{
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:6px;
            font-size:16px;
        }

        .form-group textarea{
            height:180px;
            resize:none;
        }

        .form-group img{
            width:120px;
            margin-top:10px;
            border-radius:5px;
        }

        .btn{
            width:100%;
            padding:12px;
            background:#007bff;
            color:white;
            border:none;
            border-radius:6px;
            font-size:16px;
            cursor:pointer;
        }

        .btn:hover{
            background:#0056b3;
        }

    </style>

</head>
<body>

<div class="form-container">

    <h1>Edit Blog Post</h1>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">

            <input 
                type="text" 
                name="title"
                value="<?php echo $post['title']; ?>"
                required
            >

        </div>

        <div class="form-group">

            <textarea 
                name="content"
                required
            ><?php echo $post['content']; ?></textarea>

        </div>

        <div class="form-group">

            <p>Current Image:</p>

            <img src="uploads/<?php echo $post['image']; ?>">

        </div>

        <div class="form-group">

            <input type="file" name="image">

        </div>

        <button type="submit" name="update" class="btn">
            Update Post
        </button>

    </form>

</div>

</body>
</html>