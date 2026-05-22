<?php include "header.php"; ?>

<div class="container">

<h2>Upload Document</h2>

<form action="upload.php" method="POST" enctype="multipart/form-data">

<label>Document Title</label>

<input type="text" name="title" required>

<label>Select File</label>

<input type="file" name="file" required>

<input type="submit" value="Upload Document">

</form>

</div>

<?php include "footer.php"; ?>