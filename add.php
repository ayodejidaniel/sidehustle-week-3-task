<?php

include 'db_connect.php';

//write query
$sqli = ("SELECT * FROM todo ORDER BY id DESC");

//make query & get result
$result = mysqli_query($conn, $sqli);

//fetch the resulting rows as an array
$todo = mysqli_fetch_all($result, MYSQLI_ASSOC);

//free result from memory
mysqli_free_result($result);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $sql = "INSERT INTO todo(title) VALUES('$title')";
    $results = mysqli_query($conn, $sql);

    //save to db and check
    if (mysqli_query($conn, $sql)) {
        //success
        header('location: add.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
    //free result from memory
    mysqli_free_result($result);

    //close connection
    mysqli_close($conn);
}

if (isset($_GET['delete'])) {
    
    $id_to_delete = mysqli_real_escape_string($conn, $_GET['id_to_delete']);
    
    //make sql
    $query = "DELETE FROM todo WHERE id = $id_to_delete";

    if (mysqli_query($conn, $query)) {
        //sucess
        header('Location: add.php');
    } else {
        //failure
        echo 'query error: ' . mysqli_error($conn);
    }
}
?>

<html>
<head>
    <title>TO-DO List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class=" main-section">

    <div class="add-section">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <label>Create an activity:</label> 
            <input type="text" name="title" placeholder="this field is required">
            <button type="submit" name="submit" value="submit">Add &nbsp; <span>&#43;</span></button>            
        </form>
    </div> 

    <div class="todo-section">
        <?php if (count($todo) <= 0):  ?>
            <?php foreach($todo as $todos): ?> 
                <div class="card z-depth-0 todo-item">
                    <div class="card-content center">
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="GET">
                        <input type="hidden" name="id_to_delete" value="<?php echo $todos['id'] ?>">
                        <input type="submit" name="delete" value="x" class="remove-to-do">   
                    </form>
                    <input type="checkbox" data-todo-id ="<?php echo $todos['id']; ?>" class="check-box">
                        <h2><?php echo $todos['title'] ?></h2>
                        <br>
                    <small>created: <?php echo $todos['date_time'] ?></small> 
                    </div>
                </div>
            <?php endforeach; ?>
        <?php  else:  ?>
            <p>There are no activities on your TODO List</p>
        <?php endif ?>            
    </div>

</div>

</body>
</html>