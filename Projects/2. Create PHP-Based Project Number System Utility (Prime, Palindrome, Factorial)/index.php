<!DOCTYPE html>
<html>
<head>
    <title>Number System Utility</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Number System Utility</h2>

<form action="process.php" method="post">

    Enter Number:
    <input type="number" name="number" required>

    <br><br>

    Select Operation:

    <select name="operation">
        <option value="prime">Check Prime</option>
        <option value="palindrome">Check Palindrome</option>
        <option value="factorial">Find Factorial</option>
    </select>

    <br><br>

    <input type="submit" value="Submit">

</form>

</body>
</html>