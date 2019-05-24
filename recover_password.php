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
   
<h4 class="list-group-item active"> Recover lost password </h4>
<div class="list-group-item">

    <div class="panel-body">
<form method="post" action="Script.php" >
      <input type="hidden" name="frm_recover_password" value="true"/>
     
 Email
<input type="text" name="email" placeholder="Enter your Email" class="form-control" value="<?php echo $_SESSION['user_email']; ?>">

  <br>
<input type="submit" class="btn btn-primary" value="Recover">
<br> * You will recieve email with recovery information
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