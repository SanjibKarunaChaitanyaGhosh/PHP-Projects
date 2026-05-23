<!DOCTYPE html>
<html>
<head>
    <title>Resume Form</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateForm() {
            let email = document.forms["form"]["email"].value;
            let phone = document.forms["form"]["phone"].value;

            let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            let phonePattern = /^[0-9]{10}$/;

            if (!email.match(emailPattern)) {
                alert("Invalid Email");
                return false;
            }

            if (!phone.match(phonePattern)) {
                alert("Invalid Phone");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Resume Registration</h2>

    <form name="form" action="process.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <textarea name="skills" placeholder="Skills"></textarea>
        <input type="file" name="resume" required>
        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>