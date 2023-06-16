<?php

  $conn = mysqli_connect('localhost', 'sidali', 'Alger2001', 'travel');

  if(!$conn ){
    echo 'connection error:' . mysqli_connect_error();
  }
?>