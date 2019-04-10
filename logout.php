<?php



// Destory sessions & refiret to index

   session_destroy();   
    session_unset();
    // Start a new session
session_start();

// Generate a new session ID
session_regenerate_id(true);

// Then finally, make sure you pick up the new session ID
$session_id = session_id();
    
   
    unset( $_SESSION['user_id']);
    unset( $_SESSION['user_email']);
    unset( $_SESSION['user_type']);
    unset( $_SESSION['user_student_id']);
       unset( $_SESSION['user_fullname']); 
  header("Location: index.php");
