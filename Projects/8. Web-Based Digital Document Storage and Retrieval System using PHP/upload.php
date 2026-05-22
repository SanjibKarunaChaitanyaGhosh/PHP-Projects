<?php

include "db.php";

$title = $_POST['title'];

$file = $_FILES['file']['name'];

$temp = $_FILES['file']['tmp_name'];

$folder = "uploads/".$file;

$allowed = array("pdf","docx","txt","jpg","png");

$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

if(in_array($ext,$allowed))
{

    if(move_uploaded_file($temp,$folder))
    {

        $query = "INSERT INTO documents(title,filename)
        VALUES('$title','$file')";

        mysqli_query($conn,$query);

        echo "
        <script>
        alert('Document Uploaded Successfully');
        window.location.href='view.php';
        </script>
        ";

    }

}
else
{

    echo "
    <script>
    alert('Invalid File Type');
    window.location.href='index.php';
    </script>
    ";

}

?>