<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include 'Header.php';

?>

<div class="row">
           
<div class="col-md-4 list-group" style="margin:auto;">

    <br>
   
<h4 class="list-group-item active"> Sign Up </h4>
<div class="list-group-item">

    <div class="panel-body">
<form method="post" action="Script.php" >
      <input type="hidden" name="frm_signup_2" value="true"/>
       Full Name
       <input type="text" name="fullname" placeholder="Your Full Name" class="form-control" value="<?php echo $_SESSION['user_fullname']; ?>">

 Email
<input type="text" name="email" placeholder="Email" class="form-control" value="<?php echo $_SESSION['user_email']; ?>">
 
  Password
<input type="password" class="form-control"  name="password" placeholder="password">
 Confirm Password
<input type="password" class="form-control"  name="confirmpassword" placeholder="Confirm password">
  <br>
<input type="submit" class="btn btn-primary" value="Sign up">

<?php 

error_reporting(E_ALL);
if(isset($_SESSION['info_signup2'])) {
  echo  '<hr><div class="alert alert-danger" role="alert">'.$_SESSION['info_signup2'].'</div>';
  $_SESSION['info_signup2']=null;
}

?>
</form>
</div>
  
</div>
</div>

</div>
</form>
</div> 
 </div>