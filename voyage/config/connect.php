<?php

  $conn = mysqli_connect('localhost', 'root', '', 'travel');

  if(!$conn ){
    echo 'connection error:' . mysqli_connect_error();
  }
?>