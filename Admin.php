<?php
$page="admin";
include 'Header.php';

?>

<style>
    .col-md-4{
        border-right: 1px solid skyblue;
    }
</style>

<br>
<div style="width: 80%;margin: auto;"> <h2> Administration Panel </h2> </div>
    
    <hr>
<div class="row" style="width: 80%;margin: auto;">
   
  
    
     <!--<h4>General system Settings</h4><hr>
        <a href="" class="btn btn-lg btn-primary">View System Log </a>
        <hr>
     Lab Privacy Mode: (STUDENT VERIFICATION)
        <hr>
    -->
    <div class="col-md-6">
       <h4> User account Management </h4><hr>
        
        <b>Lecturer / TA Accounts </b><br>
  
        
       
  
        
        
        <div class="container">
 <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Create New Account</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Existing Accounts</a>
    </li>
  
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="container tab-pane active"><br>
 
        <b>Create Lecturer/TA Accounts </b>
     <form method="post" action="Script.php">
                   <input type="hidden" name="frm_createlecturrer" value="true" required=""/>
 Full_Name
<input type="text" name="fullname" placeholder="Full Name" class="form-control" required="">
Email
<input type="text" name="email" placeholder="Email / Student Number" class="form-control" required="">
 
  Passport_Number / ID (Used as Intial Password)
<input type="text" class="form-control"  name="passport" placeholder="Passport No./ID" required="">
  <br> User Type : 
  <input type="radio" name="type" value="Lecturer" required=""> Lecturer
     <input type="radio" name="type" value="TA" required=""> T/A
  <input type="submit" class="btn btn-primary" value="Create"><br>
<?php 

error_reporting(E_ALL);
if(isset($_SESSION['info_Admin_Users'])) {
  echo  '<hr><div class="alert alert-info" role="alert">'.$_SESSION['info_Admin_Users'].'</div>';
  $_SESSION['info_Admin_Users']=null;
}
if(isset($_SESSION['info_Admin_Users'])) {
  echo  '<hr><div class="alert alert-info" role="alert">'.$_SESSION['info_Admin_Users'].'</div>';
  $_SESSION['info_Admin_Users']=null;
}

?>

        </form>
        
<hr>



  </div>
   
      
      <div id="menu1" class="container tab-pane fade"><br>
   


<table class="table-bordered" style="font-size: 10pt;">
    <tr style="font-size:10pt;">
        <th>ID</th>
		<th>Name</th>
        <th>Email</th>
            <th>Passport / ID </th>
               <th>Reset Password </th>
               <th>Block/Activate </th>
    </tr>
<?php

     $result = mysqli_query($con,
        "SELECT * FROM Users_Table  WHERE UserType in ('Lecturer','TA')");
  while($row = mysqli_fetch_assoc($result)) {
      $pass=$row['Passport_Number'];
     $btn="<button class='btn-primary' onclick=\"updatePass(".$row['User_ID'].",'$pass')\">Reset</button>";
     if($row['Status']=="Active")
     { $newstatus="Blocked";
      $btnBlock="<button class='btn-danger' onclick=\"blockUser(".$row['User_ID'].",'$newstatus')\">Block</button>";
     }else{
       $newstatus="Active";
      $btnBlock="<button class='btn-success' onclick=\"blockUser(".$row['User_ID'].",'$newstatus')\">Activate</button>";  
     }
     
      echo "<tr><td>".$row['User_ID']."</td><td>".$row['Full_Name']."</td><td>".$row['Email']."</td> <td>".$row['Passport_Number']."</td><td>$btn</td><td>$btnBlock</td></tr>";
  }
?></table>    
    
           
     </div>
   
      
  
  </div>
</div>
        
        
    </div>
    
    <div class="col-md-6">
        
        
        
           <div class="container">
 <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#menua">   Course Portal </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menub">Existing Courses</a>
    </li>
  
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="menua" class="container tab-pane active"><br>
        
        
        
      
     
        <hr>
        <b>Create new Portal </b>
		
		
		
		<form method="post" action="Script.php">
                   <input type="hidden" name="frm_createCourse" value="true" required=""/>
 Course Name
<input type="text" name="name" placeholder="Course Name" class="form-control" required="">

 Course Code
<input type="text" name="code" placeholder="Course Code" class="form-control" required="">

URL (Leave blank to use Course Name)
<input type="text" name="url" placeholder="Choose Custom URL " class="form-control" required="">

Academic Year
<input type="text" name="academic" placeholder="Academic Year" class="form-control" required="">
 
 Faculty <br>
<input type="text" name="faculty" placeholder="Faculty" class="form-control" required="">
 
  Assign Lecturer
<br>

<select name="lecturer" class="form-control">
 <?php 
 $result = mysqli_query($con,"SELECT * FROM Users_Table WHERE UserType='Lecturer'");
 if(mysqli_num_rows($result)==0)
    {} else { while($row = mysqli_fetch_assoc($result)) {
			$id=$row['User_ID'];
			$name=$row['Full_Name'];
		   echo "<option value='$id'> $name </option>";
		}}?>

</select>










Assigned T/A <br> 
  <select name="ta" class="form-control">
 <?php 
 $result = mysqli_query($con,"SELECT * FROM Users_Table WHERE UserType='TA'");
 if(mysqli_num_rows($result)==0)
    {} else { while($row = mysqli_fetch_assoc($result)) {
			$id=$row['User_ID'];
			$name=$row['Full_Name'];
		   echo "<option value='$id'> $name </option>";
		}}?>

</select>
 
Verify Joining Students
<input type="radio" name="verify" value="1"> Yes
<input type="radio" name="verify" value="0" checked=""> No

	 <br>
  <input type="submit" class="btn btn-primary" value="Create Portal"><br>
  
  </form>
	
        
        
        <?php 

error_reporting(E_ALL);
if(isset($_SESSION['info_Admin_Courses'])) {
  echo  '<hr><div class="alert alert-info" role="alert">'.$_SESSION['info_Admin_Courses'].'</div>';
  $_SESSION['info_Admin_Courses']=null;
}
if(isset($_SESSION['info_Admin_Courses'])) {
  echo  '<hr><div class="alert alert-info" role="alert">'.$_SESSION['info_Admin_Courses'].'</div>';
  $_SESSION['info_Admin_Courses']=null;
}

?>
        
        
        
		
		
	  </div>
   
      
      <div id="menub" class="container tab-pane fade"><br>
   	
		
		
        <b> Existing Course Portals </b>
        <hr>
        <table class="table-bordered" style="font-size: 10pt;">
            <tr> <th>Course  Name </th> <th> Faculty </th> <th>Lecturer </th> <th>TAs</th>  <th>Assign new TA </th> </tr>
         <?php 
 $result = mysqli_query($con,"SELECT `Course_ID`, `Course_Name`, `Academic_Year`, `Faculty`, `Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members`   , users_table.Full_Name  FROM `courses_table` INNER JOIN users_table ON users_table.User_ID=courses_table.Lecturer_User_ID");
 if(mysqli_num_rows($result)==0)
    {} else { while($row = mysqli_fetch_assoc($result)) {
			$name=$row['Course_Name'];
                        $code=$row['Course_Code'];
                         $faculty=$row['Faculty'];	
                         $lecturer=$row['Full_Name'];
                          $academic=$row['Academic_Year'];
                          $c_id=$row['Course_ID'];
                          
                          
                          
                          $resultTA = mysqli_query($con,"SELECT `Course_ID`, `TA`,users_table.Full_Name as TA_NAME FROM `course_ta`
INNER JOIN users_table on users_table.User_ID=course_ta.TA
where course_ta.Course_ID=$c_id");  
                    
                    $ta="";
                    while($rowTA = mysqli_fetch_assoc($resultTA)) {
                        $ta=$ta."  - ".$rowTA['TA_NAME'];
                    }
                    
                          
                          
                          
                         
                echo"  
                          <tr> <td>$code - $name</td>  <td>$faculty </td> <td>$lecturer</td><td>$ta</td>  <td><form method='get' action='Script.php'> <select name='ta' class=''>";
                              


 $resultx = mysqli_query($con,"SELECT * FROM Users_Table WHERE UserType='TA'");
 if(mysqli_num_rows($resultx)==0)
    {} else { while($row = mysqli_fetch_assoc($resultx)) {
			$id=$row['User_ID'];
			$name=$row['Full_Name'];
		   echo "<option value='$id'> $name </option>";
		}}
                

echo "</select>  <input type='hidden' name='assignTA' value='true'> <input type='hidden' name='id' value='$c_id'>  <input type='submit' value='assign'></form> </td></tr>
                         ";
                         
                         
                         
		}}?>
        
        </table>
        
        </div>
   
    </div>
    
    
</div>
    
    
    
    
    
    <script>
    function updatePass(id,pass)
    {
      if(!confirm('Are you to Reset User Password'))
      {
        return;  
      }

            window.location.href="\Script.php\?action=passchange&uid="+id+"&pass="+pass;
    }
    
      function blockUser(id,status)
    {
          if(!confirm('Are you to change User Status'))
      {
        return;  
      }
    window.location.href="\Script.php\?action=statuschange&uid="+id+"&status="+status;
    }
    </script>