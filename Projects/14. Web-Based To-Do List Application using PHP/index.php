<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>TASKR</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="container">

    <h1>TASKR</h1>

    <div class="form">

        <input type="text" id="taskText" placeholder="Enter task">

        <select id="priority">
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option>
        </select>

        <button onclick="addTask()">Add</button>

    </div>

    <div id="taskList"></div>

</div>

<script src="assets/js/app.js"></script>

</body>
</html>