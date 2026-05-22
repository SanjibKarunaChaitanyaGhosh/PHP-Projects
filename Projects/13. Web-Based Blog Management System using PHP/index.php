<?php
include 'config/db.php';
include 'includes/header.php';
?>

<div class="hero">

    <h1>Welcome to My Blog Website</h1>

    <p>
        Read amazing blogs on technology, coding, AI, web development and more.
    </p>

    <a href="search.php" class="search-btn">
        Search Blogs
    </a>

</div>

<div class="blog-container">

<?php

$query = "SELECT * FROM posts ORDER BY id DESC";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

?>

    <div class="blog-card">

        <img 
            src="uploads/<?php echo $row['image']; ?>" 
            alt="Blog Image"
        >

        <div class="blog-content">

            <h2>
                <?php echo $row['title']; ?>
            </h2>

            <p>

                <?php
                echo substr($row['content'],0,120);
                ?>...

            </p>

            <a 
                href="post.php?id=<?php echo $row['id']; ?>"
                class="read-btn"
            >
                Read More
            </a>

        </div>

    </div>

<?php

    }

}else{

    echo "<h2>No blog posts available.</h2>";
}

?>

</div>

<style>

.hero{
    background:linear-gradient(135deg,#007bff,#6610f2);
    color:white;
    text-align:center;
    padding:70px 20px;
    border-radius:10px;
    margin-bottom:40px;
}

.hero h1{
    font-size:42px;
    margin-bottom:15px;
}

.hero p{
    font-size:18px;
    margin-bottom:25px;
}

.search-btn{
    display:inline-block;
    background:white;
    color:#007bff;
    padding:12px 25px;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
    transition:0.3s;
}

.search-btn:hover{
    background:#f1f1f1;
}

.blog-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:25px;
}

.blog-card{
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
    transition:0.3s;
}

.blog-card:hover{
    transform:translateY(-5px);
}

.blog-card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.blog-content{
    padding:20px;
}

.blog-content h2{
    margin-bottom:15px;
    color:#222;
}

.blog-content p{
    color:#555;
    line-height:1.6;
}

.read-btn{
    display:inline-block;
    margin-top:15px;
    background:#007bff;
    color:white;
    padding:10px 18px;
    text-decoration:none;
    border-radius:5px;
    transition:0.3s;
}

.read-btn:hover{
    background:#0056b3;
}

@media(max-width:768px){

    .hero h1{
        font-size:30px;
    }

    .hero p{
        font-size:16px;
    }

}

</style>

<?php include 'includes/footer.php'; ?>