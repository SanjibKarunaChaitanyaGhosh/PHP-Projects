<?php
include 'includes/auth.php';
include 'config/db.php';

$message = "";

if(isset($_POST['submit'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $image = $_FILES['image']['name'];

    $tmp_name = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp_name, "uploads/".$image);

    $query = "INSERT INTO posts(title, content, image)
              VALUES('$title', '$content', '$image')";

    if(mysqli_query($conn, $query)){

        $message = "Blog post added successfully!";

    }else{

        $message = "Failed to add blog post.";

    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="form-container">

    <h1>Add New Blog Post</h1>

    <?php if($message != ""){ ?>

        <div class="alert">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">

            <label>Blog Title</label>

            <input 
                type="text" 
                name="title"
                placeholder="Enter blog title"
                required
            >

        </div>

        <div class="form-group">

            <label>Blog Content</label>

            <textarea 
                name="content"
                placeholder="Write your blog content..."
                required
            ></textarea>

        </div>

        <div class="form-group">

            <label>Upload Image</label>

            <input 
                type="file" 
                name="image"
                id="imageInput"
                required
            >

            <img 
                id="previewImage"
                style="
                    width:150px;
                    margin-top:15px;
                    border-radius:8px;
                    display:none;
                "
            >

        </div>

        <button type="submit" name="submit" class="btn">
            Publish Blog
        </button>

    </form>

</div>

<style>

.form-container{
    width:90%;
    max-width:700px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.form-container h1{
    text-align:center;
    margin-bottom:25px;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
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
    height:200px;
    resize:none;
}

.btn{
    width:100%;
    background:#007bff;
    color:white;
    padding:12px;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    background:#0056b3;
}

.alert{
    background:#28a745;
    color:white;
    padding:12px;
    border-radius:5px;
    margin-bottom:20px;
    text-align:center;
}

</style>

<?php include 'includes/footer.php'; ?>