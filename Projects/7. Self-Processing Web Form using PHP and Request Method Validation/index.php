<?php

// Initialize variables
$name = "";
$email = "";
$message = "";

$nameErr = "";
$emailErr = "";
$messageErr = "";


// Check if form submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    // Name validation
    if (empty($_POST["name"]))
    {
        $nameErr = "Name is required";
    }
    else
    {
        $name = htmlspecialchars($_POST["name"]);
    }


    // Email validation
    if (empty($_POST["email"]))
    {
        $emailErr = "Email is required";
    }
    else
    {
        $email = htmlspecialchars($_POST["email"]);
    }


    // Message validation
    if (empty($_POST["message"]))
    {
        $messageErr = "Message is required";
    }
    else
    {
        $message = htmlspecialchars($_POST["message"]);
    }

}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Self Processing PHP Form</title>

    <style>

        body
        {
            font-family: Arial;
            background: #f4f4f4;
        }

        .container
        {
            width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            margin-top: 50px;
            border-radius: 10px;
        }

        .error
        {
            color: red;
        }

    </style>

</head>

<body>

<div class="container">

<h2>Contact Form</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

Name:
<br>
<input type="text" name="name">
<span class="error"> <?php echo $nameErr; ?> </span>

<br><br>


Email:
<br>
<input type="text" name="email">
<span class="error"> <?php echo $emailErr; ?> </span>

<br><br>


Message:
<br>
<textarea name="message"></textarea>
<span class="error"> <?php echo $messageErr; ?> </span>

<br><br>


<input type="submit" value="Submit">

</form>


<?php

// Display data only if form submitted successfully

if ($_SERVER["REQUEST_METHOD"] == "POST"
    && $nameErr == ""
    && $emailErr == ""
    && $messageErr == "")
{

    echo "<h3>Your Submitted Data</h3>";

    echo "Name: " . $name . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Message: " . $message;

}

?>

</div>

</body>
</html>