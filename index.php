
    

<?php
$page='Home';
include 'Header.php';

?>




<br><br><br>
<div class="row" style="width:80%;margin:auto;">

    <div class="col-md-4">
        <br><br>
        <img src="../logo_text.png" style="width">
        <h1> Lab Report Repository System  </h1>
        <br><br>
    </div>
    
    
    
<div class="col-md-4 list-group">

    <br>
   
<h4 class="list-group-item active"> Sign in </h4>
<div class="list-group-item">

    <div class="panel-body">
<form method="post" action="Script.php" name="frm_login">
       <input type="hidden" name="frm_login" value="true"/>
Student ID / Email
<input type="text" name="user" placeholder="Email / Student Number" class="form-control">
 
  Password
<input type="password" class="form-control"  name="password" placeholder="password">
  <br>
  <input type="submit" class="btn btn-primary" value="Login"><br>
<?php 

error_reporting(E_ALL);
if(isset($_SESSION['info_login'])) {
  echo  '<hr><div class="alert alert-danger" role="alert">'.$_SESSION['info_login'].'</div>';
  $_SESSION['info_login']=null;
}

?>
</form>
</div>
  
</div>
</div>
<div class="col-md-4 list-group">

    

    <br>
<h4 class="list-group-item active"> Student Sign up </h4>
<div class="list-group-item">

<form method="post" action="Script.php" name="frm_signup_1">
    <input type="hidden" name="frm_signup_1" value="true"/>
    
    Student ID
<input type="text" name="student_id" placeholder="Entre your Student ID" class="form-control">

Your Passport / National ID
  <input type="text" class="form-control"  name="passport" placeholder="Your Passport / National ID">
  <br>
  <input type="submit" class="btn btn-primary" value="Next"> <br>
<?php 

error_reporting(E_ALL);
if(isset($_SESSION['info_signup1'])) {
  echo  '<div class="alert alert-danger" role="alert">'.$_SESSION['info_signup1'].'</div>';
  $_SESSION['info_signup1']=null;
}

?>
  
</div>
</form>
</div>
</div>
</div>
















</body>
</html>