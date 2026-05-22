<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Blog Management System</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Arial, sans-serif;
            background:#f4f4f4;
        }

        /* ======================
           NAVBAR
        ====================== */

        .navbar{
            background:#222;
            padding:15px 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            position:sticky;
            top:0;
            z-index:1000;
        }

        .logo{
            color:white;
            font-size:28px;
            font-weight:bold;
        }

        .logo span{
            color:#007bff;
        }

        /* ======================
           MENU BUTTON
        ====================== */

        .menu-btn{
            display:none;
            font-size:30px;
            color:white;
            cursor:pointer;
        }

        /* ======================
           NAV LINKS
        ====================== */

        .nav-links{
            display:flex;
            align-items:center;
            gap:15px;
        }

        .nav-links a{
            color:white;
            text-decoration:none;
            padding:10px 16px;
            border-radius:5px;
            transition:0.3s;
            font-size:15px;
        }

        .nav-links a:hover{
            background:#007bff;
        }

        /* ======================
           CONTAINER
        ====================== */

        .container{
            width:90%;
            margin:auto;
            padding:30px 0;
        }

        /* ======================
           MOBILE RESPONSIVE
        ====================== */

        @media(max-width:768px){

            .navbar{
                flex-direction:column;
                align-items:flex-start;
            }

            .menu-btn{
                display:block;
                position:absolute;
                right:20px;
                top:15px;
            }

            .nav-links{
                display:none;
                flex-direction:column;
                width:100%;
                margin-top:20px;
            }

            .nav-links.show{
                display:flex;
            }

            .nav-links a{
                width:100%;
                background:#333;
            }

        }

    </style>

</head>
<body>

<!-- ======================
     NAVBAR
====================== -->

<nav class="navbar">

    <div class="logo">
        My<span>Blog</span>
    </div>

    <!-- MOBILE MENU BUTTON -->

    <div class="menu-btn">
        ☰
    </div>

    <!-- NAVIGATION LINKS -->

    <div class="nav-links">

        <a href="index.php">Home</a>

        <a href="search.php">Search</a>

        <?php if(isset($_SESSION['user'])){ ?>

            <a href="dashboard.php">Dashboard</a>

            <a href="add_post.php">Add Post</a>

            <a href="manage_posts.php">Manage Posts</a>

            <a href="logout.php">Logout</a>

        <?php } else { ?>

            <a href="login.php">Login</a>

            <a href="register.php">Register</a>

        <?php } ?>

    </div>

</nav>

<!-- ======================
     MAIN CONTAINER
====================== -->

<div class="container">