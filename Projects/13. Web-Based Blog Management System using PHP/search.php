<?php
include 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Blogs</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .search-box{
            width:90%;
            margin:30px auto;
            text-align:center;
        }

        .search-box input{
            width:70%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:8px;
            font-size:16px;
        }

        .search-box button{
            padding:12px 20px;
            border:none;
            background:#007bff;
            color:white;
            border-radius:8px;
            cursor:pointer;
        }

        .search-box button:hover{
            background:#0056b3;
        }

        .container{
            width:90%;
            margin:auto;
            display:flex;
            flex-wrap:wrap;
            gap:20px;
            justify-content:center;
        }

        .card{
            width:300px;
            background:white;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .card img{
            width:100%;
            height:200px;
            object-fit:cover;
        }

        .card-content{
            padding:15px;
        }

        .card-content h2{
            margin-bottom:10px;
        }

        .card-content a{
            display:inline-block;
            margin-top:10px;
            text-decoration:none;
            background:#28a745;
            color:white;
            padding:8px 15px;
            border-radius:5px;
        }

        .card-content a:hover{
            background:#1e7e34;
        }

    </style>
</head>
<body>

<h1 style="text-align:center;">Search Blog Posts</h1>

<div class="search-box">

    <form method="GET">

        <input 
            type="text" 
            name="keyword" 
            placeholder="Search blog title..."
            value="<?php if(isset($_GET['keyword'])) echo $_GET['keyword']; ?>"
        >

        <button type="submit">
            Search
        </button>

    </form>

</div>

<div class="container">

<?php

if(isset($_GET['keyword'])){

    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);

    $query = "SELECT * FROM posts 
              WHERE title LIKE '%$keyword%' 
              OR content LIKE '%$keyword%'
              ORDER BY id DESC";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_assoc($result)){

?>

    <div class="card">

        <img src="uploads/<?php echo $row['image']; ?>">

        <div class="card-content">

            <h2><?php echo $row['title']; ?></h2>

            <p>
                <?php echo substr($row['content'],0,100); ?>...
            </p>

            <a href="post.php?id=<?php echo $row['id']; ?>">
                Read More
            </a>

        </div>

    </div>

<?php

        }

    } else {

        echo "<h2>No blogs found.</h2>";

    }

}

?>

</div>

</body>
</html>