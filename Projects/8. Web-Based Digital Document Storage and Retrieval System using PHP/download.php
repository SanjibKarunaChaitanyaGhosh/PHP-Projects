<?php

$file = $_GET['file'];

$path = "uploads/".$file;

if(file_exists($path))
{

header('Content-Description: File Transfer');

header('Content-Disposition: attachment; filename='.basename($file));

readfile($path);

exit;

}
else
{

echo "File not found";

}

?>