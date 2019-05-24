<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include 'Header.php';
$token=$_GET['token'];
$email=$_GET['email'];
?>

<div class="row">
           
<div class="col-md-4 list-group" style="margin:auto;">

    <br>
   
<h4 class="list-group-item active"> Reset your password </h4>
<div class="list-group-item">

    <div class="panel-body">
<form method="post" action="Script.php" >
      <input type="hidden" name="frm_reset_password" value="true"/>
      <input type="hidden" name="token" value="<?php echo $token ?>"/>  
      Email
<input type="text" name="email" readonly="" placeholder="Enter your Email" class="form-control" value="<?php echo $email; ?>">
<br>
 New Password
<input type="password" name="password" placeholder="Enter your new Password" class="form-control" value="">

  <br>
<input type="submit" class="btn btn-primary" value="Reset">
<br> 
<?php 

?>
</form>
</div>
  
</div>
</div>

</div>
</form>
</div> 
 </div>