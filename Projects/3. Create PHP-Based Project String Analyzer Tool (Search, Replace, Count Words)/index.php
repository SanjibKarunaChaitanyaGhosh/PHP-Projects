<!DOCTYPE html>
<html>
<head>
    <title>String Analyzer Tool</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>String Analyzer Tool</h2>

<form method="post">

<textarea name="text" placeholder="Enter your text here" required></textarea>

<input type="text" name="search" placeholder="Enter word to search">

<input type="text" name="replace" placeholder="Enter replacement word">

<button name="action" value="search">Search Word</button>
<button name="action" value="replace">Replace Word</button>
<button name="action" value="count">Count Words</button>

</form>

<div class="result">

<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $text = $_POST['text'];
    $search = $_POST['search'];
    $replace = $_POST['replace'];
    $action = $_POST['action'];

    if($action == "search")
    {
        if(strpos($text, $search) !== false)
        {
            echo "Word found in the text.";
        }
        else
        {
            echo "Word not found.";
        }
    }

    elseif($action == "replace")
    {
        $newText = str_replace($search, $replace, $text);
        echo "Updated Text:<br><br>" . $newText;
    }

    elseif($action == "count")
    {
        $wordCount = str_word_count($text);
        echo "Total number of words: " . $wordCount;
    }
}

?>

</div>

</div>

</body>
</html>
