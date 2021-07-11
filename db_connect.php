<?php 

$conn = mysqli_connect('localhost', 'ayodeji', 'olumide1', 'to_do_list');

//check connection
if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}

?>