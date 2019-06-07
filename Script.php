<?php

/* 
 * This Contains  the main Server-side scripts for the project
 *   session_destroy();
 * 
 * 
 */

session_start();
  date_default_timezone_set('Asia/Shanghai');
// CONNeCTION
$con=mysqli_connect("localhost","mnc","123","lrr");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
else
{
//echo "Connected";
}








error_reporting(0);
if (!empty($_POST["frm_signup_1"])) {
     $student_id=mysqli_real_escape_string($con,$_POST["student_id"]);
     $passport=mysqli_real_escape_string($con,$_POST["passport"]);
    
    echo $student_id.' and '.$passport;

   $result = mysqli_query($con,
       "SELECT * FROM students_data WHERE student_id='$student_id' and (Passport_Number='$passport' or Passport_Number is null)");
     if(mysqli_num_rows($result)==0)
    {
        $_SESSION["info_signup1"]="Student Information could not be verified ! Plaese contact student Management Office.";
        header("Location: index.php");     
        return;		
    }
   
   
   
   $result98 = mysqli_query($con,
        "SELECT * FROM `users_table` WHERE Student_ID='$student_id'");
  
 
        if(mysqli_num_rows($result98)==0)
    {
         $_SESSION['user_passport']=$passport;
       $_SESSION['user_student_id']=$student_id;
      header("Location: signup.php");
	  return;
          
    }
    else
    { 
        $_SESSION["info_signup1"]="Student ID already Used ! Please contact student Management Office if you could not login to your account.";
        header("Location: index.php");
        return;		
    } 
  
  }

    
    
    
    
    
    
    
    
    
    
    
    
    
    // ############################### CREATE STUDENT USER ##################################
    if (!empty($_POST["frm_signup_2"])) {
     $email=mysqli_real_escape_string($con,$_POST["email"]);
     $password=mysqli_real_escape_string($con,$_POST["password"]);
      $confirmpassword=mysqli_real_escape_string($con,$_POST["confirmpassword"]);
    $fullname=mysqli_real_escape_string($con,$_POST["fullname"]);
         $student_id=$_SESSION['user_student_id'];   
    $passport= $_SESSION['user_passport'];
    $_SESSION['user_fullname']=$fullname;
    $_SESSION['user_type']="Student";
      $_SESSION['user_email']=$email;
    // check confirmed password
    if ( strcasecmp( $password, $confirmpassword ) != 0 ){
        $_SESSION['info_signup2']="Incorrect Password confirmation";
       header("Location: signup.php");
       return;
    }
   $containsLetter  = preg_match('/[a-zA-Z]/',    $password);
   $containsDigit   = preg_match('/\d/',          $password);
   $containsSpecial = preg_match('/[^a-zA-Z\d]/', $password);
   $containsAll = $containsLetter && $containsDigit && $containsSpecial;
 // check for strong password
     if($containsAll==false)
   {
      $_SESSION['info_signup2']="Password should contain Letters , Numbers and sepcial characters";
     header("Location: signup.php");
     return;
    }
   // check if email is taked
     $result = mysqli_query($con,
        "SELECT * FROM Users_Table WHERE email='$email'");
   if(mysqli_num_rows($result)!=0)
    {
        $_SESSION["info_signup2"]="Email adress : ".$email." is already used.";
        header("Location: signup.php"); 
        return;       
    }
    $sql= "INSERT INTO `users_table`(`Email`, `Password`, `Full_Name`, `UserType`, `Student_ID`, `Passport_Number`) VALUES "
            . "('$email','$password','$fullname','Student','$student_id','$passport')";
    
   if ($con->query($sql) === TRUE) {
   header("Location: Courses.php"); 
    
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
 }
    
    


// ################################ LOGIN  #####################################

if (!empty($_POST["frm_login"])) {
  $user=mysqli_real_escape_string($con,$_POST["user"]);
  $password=mysqli_real_escape_string($con,$_POST["password"]);
  $hashed_password=hash('sha512', $password);
 $result = mysqli_query($con,
     "SELECT * FROM Users_Table WHERE (email='$user' or Student_ID='$user') and HashPassword='$hashed_password'");
if(mysqli_num_rows($result)==0)
 {
     $_SESSION["info_login"]="Inavlid login Information.";
  
echo $_SESSION["info_login"];

header("Location: index.php");        
 }
 else 
 { 
     while($row = mysqli_fetch_assoc($result)) {
      $_SESSION['user_id']=$row['User_ID'];
     $_SESSION['user_email']=$row['Email'];
     $_SESSION['user_student_id']=$row['Student_ID'];
     $_SESSION['user_type']=$row['UserType'];
    $_SESSION['user_fullname']=$row['Full_Name'];
     
     if( $_SESSION['user_type']=="Student")
     {
       header("Location: Courses.php");
     }     

     if( $_SESSION['user_type']=="Lecturer")
     {
       header("Location: Courses.php");
     }
     
       if( $_SESSION['user_type']=="TA")
     {
       header("Location: Courses.php");
     }
      
     if( $_SESSION['user_type']=="Admin")
     {
       header("Location: Admin.php");
     }
    
     
    
 }
 }
}
 








// ################################ Recover Password  #####################################

if (!empty($_POST["frm_recover_password"])) {
  $email=mysqli_real_escape_string($con,$_POST["email"]);
 

 $result = mysqli_query($con,
     "SELECT * FROM Users_Table WHERE email='$email'");
if(mysqli_num_rows($result)==0)
 {
     $_SESSION["info_recover_password"]="Email address is not recognised.";
  

echo "Email address was not recognised";
return;
header("Location: recover_password.php");        
 }
 else 
 { 
     while($row = mysqli_fetch_assoc($result)) {

      $userid=$row['User_ID'];

     $email=urlencode($row['Email']);
     $pure_email=$row['Email'];
     $id=$row['Student_ID'];
    
     $token=$userid*$userid*$userid+$userid*0.00343;

    $name=$row['Full_Name'];
$link="<a href='http://118.25.96.118/nor/Reset_password.php?token=$token&email=$email'>Click Here (点击这里) </a>";
$msg=urlencode(" <h3>Lab Report Repository System - ZJNU</h3>  <br>  Hi <b>"
.$name. 
" </b> Here is your password recovery link , "
.$link.
"   to reset your password , <br> please ignore this message if you did not requested password recovery.<br><br> <hr><br><br>  
您好 $name, 这是你的密码恢复链接，点击上面的链接 重置你的密码，
如果您没有请求密码恢复，请忽略此消息。  <br><br><br><br><br> <small>LRR System by Mohamed Nor. </small><hr>");
    

$title=urlencode("Password recovery Request for LRR system - ZJNU ");


$url="http://sms.samesoftware.com/email/send/?Subject=$title&Body=$msg&ToAddress=$email&token=s1234";

//$response = file_get_contents($url);


$ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
  
    if(curl_errno($ch))
    echo 'Curl error: '.curl_error($ch);
curl_close ($ch); 



echo $data."<hr>";



$_SESSION["info_login"]="<br> Please check your Inbox & Junk folders for the recovery email , a reset link was sent to your email <b> $pure_email </b>";

header("Location: index.php");


     }
    }
  }








// ################################ RESET Password  #####################################

if (!empty($_POST["frm_reset_password"])) {
  $password=mysqli_real_escape_string($con,$_POST["password"]);
  $token=mysqli_real_escape_string($con,$_POST["token"]);
  $email=mysqli_real_escape_string($con,$_POST["email"]);
 $result = mysqli_query($con,
     "SELECT * FROM Users_Table WHERE email='$email'");
if(mysqli_num_rows($result)==0)
 {
    
echo "invalid email";
return;
       
 }
 else 
 { 
     while($row = mysqli_fetch_assoc($result)) {

      $userid=$row['User_ID'];

     $email=$row['Email'];
     $id=$row['Student_ID'];
    
     $user_token=$userid*$userid*$userid+$userid*0.00343;
if($user_token==$token)
{
// Password Update

  // Password Update
  $hashed_password=hash('sha512', $password);
		 $sql= "UPDATE users_table set HashPassword='$hashed_password' where User_ID=$userid;";
   if ($con->query($sql) === TRUE) {
       
       error_reporting(0);

	    $_SESSION["info_login"]=" Password changed successfully , you can login now with your new password ";
   header("Location: index.php");
                                   
	   }
	   else {
    echo "Error: " . $sql . "<br>" . $con->error;
}

} else
{
  echo "Invalid Token ";
}

    


     }
    }
  }






























    // ############################### CREATE Lecturer/TA USER ##################################
    if (!empty($_POST["frm_createlecturrer"])) {
     $email=mysqli_real_escape_string($con,$_POST["email"]);
     $passport=mysqli_real_escape_string($con,$_POST["passport"]);
     $fullname=mysqli_real_escape_string($con,$_POST["fullname"]);
       $type=mysqli_real_escape_string($con,$_POST["type"]);
       $password=$passport;
   // check if email is taked
     $result = mysqli_query($con,
        "SELECT * FROM Users_Table WHERE email='$email'");
   if(mysqli_num_rows($result)!=0)
    {
        $_SESSION["info_Admin_Users"]="Email adress : ".$email." is already used.";
        header("Location: Admin.php");        
    }
    $sql= "INSERT INTO `users_table`(`Email`, `Password`, `Full_Name`, `UserType`, `Passport_Number`) VALUES "
            . "('$email','$password','$fullname','$type','$passport')";
    
   if ($con->query($sql) === TRUE) {
         $_SESSION["info_Admin_Users"]=$type." user Created successfully : email ".$email." and $password as Password.";
   header("Location: Admin.php"); 
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 // #### FUNCTION CHECK FILE TYPES ////

function is_valid($file) {
 
 
   $allowed =  array('pdf', 'rtf', 'jpg','png', 'doc', 'docx', 'xls', 'xlsx','sql','txt','md','py','css','html',
   'cvc','c','class','cpp','h','java','sh','swift','zip','rar','ods','xlr','bak','ico','swf');
   
   
   
$filename = $_FILES[$file]['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);
  $result=in_array($ext,$allowed);

  return $result;
}
 
 
 
 
  // #### FUNCTION CREATE DIRECTORIES  ////
 
 function Create_dir($upPath)
{
 try {
 
  // full path 
$tags = explode('/' ,$upPath);            // explode the full path
$mkDir = "";

    foreach($tags as $folder) {          
        $mkDir = $mkDir . $folder ."/";   // make one directory join one other for the nest directory to make
       // echo '"'.$mkDir.'"<br/>';         // this will show the directory created each time
        if(!is_dir($mkDir)) {             // check if directory exist or not
          mkdir($mkDir, 0777);            // if not exist then make the directory
        }
    }	
 }
	 catch (Exception $e) {
 
  }
  return $upPath;
}
 
    





































// ############################### #Post Assignment ##################################
    if (!empty($_POST["frm_uploadlab"])) {
        
     
        
     $course_id=mysqli_real_escape_string($con,$_POST["course_id"]);
     $deadlinedate=$_POST["deadlinedate"];
     $deadlinetime=$_POST["deadlinetime"];
       $instructions=mysqli_real_escape_string($con,$_POST["instructions"]);
       $title=mysqli_real_escape_string($con,$_POST["title"]);
              $marks=mysqli_real_escape_string($con,$_POST["marks"]);
         $url=mysqli_real_escape_string($con,$_POST["url"]);
       
         $type=mysqli_real_escape_string($con,$_POST["type"]);
         
         
       $deadline=$deadlinedate." ".$deadlinetime;
      $date=  date("Y-m-d H:i");
            
       
       
 // GET UPLOADED FILES
       
       $target_dir =Create_dir("Lab_Report_Assignments/".$title."/");


       $rnd=rand(10,1000);
	   $rnd=""; // no more required , creating folder for each lab
         $targetfile = $target_dir.$rnd.$_FILES['attachment1']['name'];
           $targetfile2 = $target_dir.$rnd.$_FILES['attachment2']['name'];
             $targetfile3 = $target_dir.$rnd.$_FILES['attachment3']['name'];
              $targetfile4 = $target_dir.$rnd.$_FILES['attachment4']['name'];
             
          
         
              
            

//$curDateTime = date("Y-m-d H:i");
//$myDate = date("Y-m-d H:i", strtotime("2017-12-28 18:01"));
//if($curDateTime <= $myDate ){
//    echo "active ".+$curDateTime." mydate= ".$myDate;
//   
//}else{
//    echo "inactive c=".$curDateTime;
//}
//   

  $count=0;           
           
 
  if(!is_valid("attachment1") && $_FILES["attachment1"]["name"]!="")
  {
      echo "Invalid File Type for Attachment 1";
      return;
  }
    if(!is_valid("attachment2") && $_FILES["attachment2"]["name"]!="")
  {
      echo "Invalid File Type for Attachment 2";
      return;
  }
    if(!is_valid("attachment3") && $_FILES["attachment3"]["name"]!="")
  {
      echo "Invalid File Type for Attachment 3";
      return;
  }
  
  //if($_FILES["attachment1"]["error"] != 0) {
    //  echo "Error uploading the file ";
      //return;
//} 

// use 4 for missing file



  
  
  if (move_uploaded_file($_FILES['attachment1']['tmp_name'], $targetfile)) {
  $count++;
  } else { 
     echo $_FILES['attachment1']['error'];
  }
  
   if (move_uploaded_file($_FILES['attachment2']['tmp_name'], $targetfile2)) {
    $count++;
  } else { 
     echo $_FILES['attachment2']['error'];
  }
  
   if (move_uploaded_file($_FILES['attachment3']['tmp_name'], $targetfile3)) {
     $count++;
  } else { 
     echo $_FILES['attachment3']['error'];
  }
  
     if (move_uploaded_file($_FILES['attachment4']['tmp_name'], $targetfile4)) {
     $count++;
  } else { 
     echo $_FILES['attachment4']['error'];
  }
//}
       
     
  
  
  echo $count." File(s) uploaded";
  
  //CLEAN
        $targetfile="";
$targetfile2="";
   $targetfile3="";
      $targetfile4="";
      
  if($_FILES['attachment1']['name']!=""){ $targetfile="/".$title."/".$_FILES['attachment1']['name']; }
    if($_FILES['attachment2']['name']!=""){ $targetfile2="/".$title."/".$_FILES['attachment2']['name']; }
      if($_FILES['attachment3']['name']!=""){  $targetfile3= "/".$title."/".$_FILES['attachment3']['name']; }
        if($_FILES['attachment4']['name']!=""){   $targetfile4= "/".$title."/".$_FILES['attachment4']['name']; }
        
  
  
    
      
      
       

  
         
      //  return;
       
       
       
       $sql="INSERT INTO `lab_reports_table`(`Course_ID`, `Posted_Date`, `Deadline`, `Instructions`,
                     `Title`, `Attachment_link_1`, `Attachment_link_2`, `Attachment_link_3`, `Attachment_link_4`,Marks,Type) 
                     VALUES ('$course_id','$date','$deadline','$instructions','$title','$targetfile','$targetfile2','$targetfile3','$targetfile3',$marks,'$type')";
      
      
    
   if ($con->query($sql) === TRUE) {
       
       $_SESSION["info_courses"]=$type." Lab Report Assignment posted successfully.";
   header("Location: Courses.php?course=".$url); 
   
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
function checksize($file)
{
    $filename = $_FILES[$file]['name'];
    
      $result=$_FILES["$file"]['size']/1024/1024;
      
      
      
      //$max_upload = (int)(ini_get('upload_max_filesize'));
//$max_post = (int)(ini_get('post_max_size'));
//$memory_limit = (int)(ini_get('memory_limit'));
//$upload_mb = min($max_upload, $max_post, $memory_limit);
if($result>20)
{
    return FALSE;
}
  return TRUE;
}
 
 
 
 
 
 // ############################### Submit Assignment ##################################
    if (!empty($_POST["frm_submitlab"])) {
        
     
        
     $lab_id=mysqli_real_escape_string($con,$_POST["lab_id"]);
     $student_id=$_POST["student_id"];
        $group_id=$_POST["group_id"];
     

       $instructions=mysqli_real_escape_string($con,$_POST["instructions"]);
       $title=mysqli_real_escape_string($con,$_POST["title"]);
       
         $url=mysqli_real_escape_string($con,$_POST["url"]);
       
       
       $deadline=$deadlinedate." ".$deadlinetime;
      $date=  date("Y-m-d H:i");
            
       
       
 // GET UPLOADED FILES
       
     

         $labName = mysqli_query($con,"SELECT Title FROM `lab_reports_table` WHERE Lab_Report_ID=$lab_id");
     while($row = mysqli_fetch_assoc($labName)) {$lab_name=$row['Title'];} 


       $target_dir =Create_dir("Lab_Report_Submisions/".$student_id."/".$lab_name."/");
	   
	   
	   
         $targetfile = $target_dir.$_FILES['attachment1']['name'];
           $targetfile2 = $target_dir.$_FILES['attachment2']['name'];
             $targetfile3 = $target_dir.$_FILES['attachment3']['name'];
              $targetfile4 = $target_dir.$_FILES['attachment4']['name'];
             
          
         
              
            

//$curDateTime = date("Y-m-d H:i");
//$myDate = date("Y-m-d H:i", strtotime("2017-12-28 18:01"));
//if($curDateTime <= $myDate ){
//    echo "active ".+$curDateTime." mydate= ".$myDate;
//   
//}else{
//    echo "inactive c=".$curDateTime;
//}
//   

  $count=0;           
           
  
  

  //check zise
    if(!checksize("attachment1"))
  {
      echo "20 MB is the maximum file size allowed";
      return;
  }
    if(!checksize("attachment2") && $_FILES["attachment2"]["name"]!="")
  {
       echo "20 MB is the maximum file size allowed";
      return;
  }
    if(!checksize("attachment3") && $_FILES["attachment3"]["name"]!="")
  {
     echo "20 MB is the maximum file size allowed";
      return;
  }
  
  
  
  
  
  if(!is_valid("attachment1"))
  {
      echo "Invalid File Type for Attachment 1";
      return;
  }
    if(!is_valid("attachment2") && $_FILES["attachment2"]["name"]!="")
  {
      echo "Invalid File Type for Attachment 2";
      return;
  }
    if(!is_valid("attachment3") && $_FILES["attachment3"]["name"]!="")
  {
      echo "Invalid File Type for Attachment 3";
      return;
  }
  
  if($_FILES["attachment1"]["error"] != 0) {
      echo "Error uploading the file ";
      return;
} 

// use 4 for missing file



  
  
  if (move_uploaded_file($_FILES['attachment1']['tmp_name'], $targetfile)) {
  $count++;
  } else { 
     echo $_FILES['attachment1']['error'];
  }
  
   if (move_uploaded_file($_FILES['attachment2']['tmp_name'], $targetfile2)) {
    $count++;
  } else { 
     echo $_FILES['attachment2']['error'];
  }
  
   if (move_uploaded_file($_FILES['attachment3']['tmp_name'], $targetfile3)) {
     $count++;
  } else { 
     echo $_FILES['attachment3']['error'];
  }
  
     if (move_uploaded_file($_FILES['attachment4']['tmp_name'], $targetfile4)) {
     $count++;
  } else { 
     echo $_FILES['attachment4']['error'];
  }
//}
       
     
  
  
  echo $count." File(s) uploaded";
  
  //CLEAN
  $targetfile1="";
    $targetfile2="";
	  $targetfile3="";  
	  $targetfile4="";
  
  if(strlen($_FILES['attachment1']['name']) > 2 ) {
    $targetfile="/".$student_id."/".$lab_name."/".$_FILES['attachment1']['name'];
  }
      
	    if(strlen($_FILES['attachment2']['name']) > 2 ) {
		$targetfile2="/".$student_id."/".$lab_name."/".$_FILES['attachment2']['name']; }
		
		  if(strlen($_FILES['attachment3']['name']) > 2 ) {
		  $targetfile3= "/".$student_id."/".$lab_name."/".$_FILES['attachment3']['name'];}
		  
		    if(strlen($_FILES['attachment4']['name']) > 2 ) {
         $targetfile4= "/".$student_id."/".$lab_name."/".$_FILES['attachment4']['name'];
			}
	
  
         $sql1="Delete from  lab_report_submissions where Lab_Report_ID=$lab_id and Student_id=$student_id and Course_Group_id=$group_id";
        if ($con->query($sql1) === TRUE) {
        }
        
        if($group_id>0)
        {
         $student_id=0;   
        }
       
       $sql="INSERT INTO `lab_report_submissions`(`Submission_Date`, `Lab_Report_ID`, `Student_id`,"
               . " `Course_Group_id`, `Attachment1`, `Notes`, `Attachment2`, `Attachment3`, `Attachment4`, `Status`, `Title`,`Remarking_Reason`)"
               . " VALUES ('$date',$lab_id,$student_id,$group_id,'$targetfile','$instructions','$targetfile2','$targetfile3','$targetfile4',"
               . "'Pending','$title','')";
       
      
    
   if ($con->query($sql) === TRUE) {
       
       $_SESSION["info_courses"]=$type." Lab Report Assignment Submitted successfully.";
   header("Location: Course.php?url=".$url); 
   
} else {
    echo "Error: <br>" . $con->error;
}
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 // JOIN COURSE
 if (!empty($_GET["JoinCourse"])) {
	   
	   $id=$_GET["id"];
	    $student_id=$_GET["std"];
            $joining=$_GET["joining"];
		
            $status="Pending";
            
            if($joining==0){ $status="Joined";}
            
              $sql="INSERT INTO `course_students_table`(`Course_ID`, `Student_ID`,`Status`) VALUES 
              ('$id','$student_id','$status')";
    
     if ($con->query($sql) === TRUE) {
         
  
         if($joining==0)
         {
         $_SESSION["info_Courses_student"]="You enroll in this Course successfully.";
         }
 else {
      $_SESSION["info_Courses_student"]="Course enrollment request was sent to the lecturer.";
 }
         
         
         header("Location: Courses.php"); 
   
   
    
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
            
   }
 
 
 
 
 
 
 
 
   
   
   
   #MARK LAB REPORT
  
 if (!empty($_GET["savemarks"])) {
	   
	   $id=$_GET["id"];
	    $marks=$_GET["marks"];
             $total=$_GET["total"];
            $feedback=$_GET["feedback"];
		 $header=$_GET["header"];
                  $labid=$_GET["labid"];
            $status="Marked";
            
            if($marks>$total)
            {
                echo " Marks could not be greater than total";
                return;
            }
          $date=  date("Y-m-d H:i");
          $feedback="<br>@$date : ".$feedback;
        
              $sql="UPDATE `lab_report_submissions` SET `Marks`='$marks',`Status`='$status',"
                      . ""
                      . "Notes=if(Notes is null, ' ', concat(Notes, '$feedback'))"
                      . ""
                      . " WHERE Submission_ID=$id
              ";
    
     if ($con->query($sql) === TRUE) {
         
  
         $_SESSION["info_Marking"]="Lab Report Submission Marked";
          header("Location: Submissions.php?id=".$labid."&header=".$header."&total=".$total); 
  
    
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
            
   }
 
 
   
  
   
    #Update Report Visibility  
 if (!empty($_GET["updatevisibility"])) {
	   
	   $id=$_GET["id"];
           $marks=$_GET["marks"];
             $total=$_GET["total"];
            $status=$_GET["status"];
		 $header=$_GET["header"];
                  $labid=$_GET["labid"];
           
            
           
              $sql="UPDATE `lab_report_submissions` SET `Visibility`='$status' WHERE Submission_ID=$id
              ";
    
     if ($con->query($sql) === TRUE) {
        
         $_SESSION["info_Marking"]="Lab Report Visibility Updated";
          header("Location: Submissions.php?id=".$labid."&header=".$header."&total=".$total); 
  
    
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
            
   }
   
   
   
   #Remarking Request
  
 if (!empty($_GET["remarking"])) {
	   
	   $id=$_GET["id"];
	    $url=$_GET["url"];
           
            $status= $_GET["status"];
            $details=$_GET["details"];
           
              $sql="UPDATE `lab_report_submissions` SET `Status`='Remarking',Remarking_Reason='$details' WHERE Submission_ID=$id
              ";
    
     if ($con->query($sql) === TRUE) {
         
  
         $_SESSION["info_ReMarking"]="Remarking Request Sent";
          header("Location: Course.php?url=".$url); 
  
    
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
            
   }
 
 
 
    #Create Group Request
  
 if (!empty($_GET["creategroup"])) {
	   
	   $student_id=$_GET["student_id"];
	    $url=$_GET["url"];
               $id=$_GET["id"];
            $name= $_GET["name"];
            
           
              $sql="INSERT INTO `course_groups_table`(`Group_Name`, 
                  `Group_Leader`, `Course_id`) VALUES ('$name',$student_id,$id)";
 
              
              
             
            
            
     if ($con->query($sql) === TRUE) {
         
         
         $resultx1 = mysqli_query($con,"Select Max(Course_Group_id) as cnt from course_groups_table");
     while($row = mysqli_fetch_assoc($resultx1)) {$gid=$row['cnt'];} 
         
     
             $sql="INSERT INTO `course_group_members_table`( `Course_Group_id`, `Student_ID`, `Status`) 
                          VALUES ($gid,$student_id,'Created')";
   if ($con->query($sql) === TRUE) {
         $_SESSION["info_ReMarking"]="Course group Created";
          header("Location: Course.php?url=".$url); 
   } else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
  
    
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
            
   }  
   
   
   
   
   
   
       #Create Group Request
  
 if (!empty($_GET["groupinvite"])) {
	   
	   $student_id=$_GET["student_id"];
	    $url=$_GET["url"];
               $courseid=$_GET["courseid"];
                $groupid=$_GET["groupid"];
            
           
                
                   
                
   
             $sql="INSERT INTO `course_group_members_table`( `Course_Group_id`, `Student_ID`, `Status`) 
                          VALUES ($groupid,$student_id,'Invited')";
   if ($con->query($sql) === TRUE) {
         $_SESSION["info_ReMarking"]=$student_id . " was invited to the group";
          header("Location: Course.php?url=".$url); 
   } else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
  
}
 
   
   
   
   
      
       #Accept deny Group Invite
  
 if (!empty($_GET["acceptinvite"])) {
	   
	   $student_id=$_GET["student_id"];
	    $url=$_GET["url"];
               $action=$_GET["action"];
                $groupid=$_GET["groupid"];
            
                if($action==1)
                {
                     $sql="Update  `course_group_members_table` set Status='Joined' where  Course_Group_id =$groupid and student_id=$student_id 
                         ";  
                }
                else
                {
                     $sql="Delete from  `course_group_members_table`  where  Course_Group_id =$groupid and student_id=$student_id 
                         "; 
                }
          
   if ($con->query($sql) === TRUE) {
         $_SESSION["info_ReMarking"]=" Group Invite Updated";
          header("Location: Course.php?url=".$url); 
   } else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
  
}
 
   
   









 #Extend Deadline
  
 if (!empty($_GET["extenddeadline"])) {
	   
	   $id=$_GET["id"];
            $date=$_GET["date"];
               $time=$_GET["time"];
             $type=$_GET["type"];
             
               $stdid=$_GET["stdid"];
               $reason =$_GET["reason"];
                 $url =$_GET["url"];
                $deadline=$date." ".$time;
             
               if($type==1)
               {
                   
               }
               
               
            
            
            if($type==1)
                {
                     $sql="UPDATE `lab_reports_table` SET  `Deadline`='$deadline'  WHERE Lab_Report_ID=$id"; 
                          
                }
                else
                {
            $sql="INSERT INTO `extended_deadlines_table`(`Student_ID`, "
                    . "`Lab_Report_ID`, `Extended_Deadline_Date`,"
                    . " `ReasonsForExtension`) VALUES ($stdid,$id,'$deadline','$reason')";
                    
                  
                }
                
                
             
          
   if ($con->query($sql) === TRUE) {
        
          
              $_SESSION["info_courses"]=" Lab Report Deadline extended successfully.";
   header("Location: Courses.php?course=".$url);
          
   } else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
  
}
 









   
   
   
   
   
  
   
   
   #IGNORE Remarking Request
  
 if (!empty($_GET["ignoreremarking"])) {
	   
	
           $id=$_GET["id"];
	  $total=$_GET["total"];
             $header=$_GET["header"];
           
                $subid=$_GET["subid"];
            
           
              $sql="UPDATE lab_report_submissions SET Status='Marked' WHERE Submission_ID=$subid";
    
             
              
     if ($con->query($sql) === TRUE) {
         
  
        
             $_SESSION["info_Marking"]="Remarking Request Ignored , Submission Updated to 'Marked' status";
       header("Location: Submissions.php?id=".$id."&header=".$header."&total=".$total); 

    
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
            
   }
 
   
   
  
      
   
 
   
   
   
   
   
   #Assign TA
  
 if (!empty($_GET["assignTA"])) {
	   
	
           $id=$_GET["id"];
	  $ta=$_GET["ta"];
            
           
              $sql="INSERT INTO `course_ta`(`Course_ID`, `TA`) VALUES ($id,$ta)";
    
             
              
     if ($con->query($sql) === TRUE) {
         
  
          $_SESSION["info_Admin_Courses"]=$type." Course TA Assigned ";
   header("Location: Admin.php");
                                 
        

    
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
            
   }
 
   
   
   
   
   
   
   
   
   
   
    
 //ACCEPT STUDNTS JOINING COURSSS
 
   if (!empty($_GET["AcceptStudent"])) {
	   
	   $id=$_GET["id"];
	    $rs=$_GET["rs"];
         
             if($rs=="yes")
            {
                 $sql="Update  course_students_table set Status='Joined' Where ID=$id";
    
                
            } else {
               $sql="Delete FROM  course_students_table Where ID=$id";
       }
           
     if ($con->query($sql) === TRUE) {
         
  
         if($rs=="yes")
         {
         $_SESSION["info_courses"]="Course Joining request Approved.";
         }
 else {
      $_SESSION["info_courses"]="Course Joining request Declined & Removed.";
 }
   
            
            
            
         header("Location: Courses.php"); 
   
   
   }
    else {
    echo "Error: " . $sql . "<br>" . $con->error;
}

   }
   
   
   
   
   
   
   
   
   
     
              
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 //action=passchange&uid=1&pass=1929
 
   if (!empty($_GET["action"])) {
	   
	   $action=$_GET["action"];
	    $uid=$_GET["uid"];
		
		 $pass=$_GET["pass"];
		 $status=$_GET["status"];
		 
	   if($action=="passchange")
	   {
		 $sql= "UPDATE users_table set Password='$pass' where User_ID=$uid;";
   if ($con->query($sql) === TRUE) {
       
       error_reporting(0);
       
       echo "Password has been changed";
       return;
	    $_SESSION["info_Admin_Users"]=$type." User  Password was Reset to his/her Passport/ID successfully ";
   header("Location: Admin.php");
                                   }
	   }
	   else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
	   
	   if($action=="statuschange")
	   {
		   $sql= "UPDATE users_table set Status='$status' where User_ID=$uid;";
   if ($con->query($sql) === TRUE) {
	   
	       $_SESSION["info_Admin_Users"]=$type." user  Status updated successfully ";
		      header("Location: Admin.php");
   }
	   }else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
	   
	   
	   
   }
 
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
       
    // ############################### CREATE STUDENT USER ##################################
    if (!empty($_POST["frm_createCourse"])) {
     $name=mysqli_real_escape_string($con,$_POST["name"]);
     $academic=mysqli_real_escape_string($con,$_POST["academic"]);
       $lecturer=mysqli_real_escape_string($con,$_POST["lecturer"]);
          $ta=mysqli_real_escape_string($con,$_POST["ta"]);
            $faculty=mysqli_real_escape_string($con,$_POST["faculty"]);
               $code=mysqli_real_escape_string($con,$_POST["code"]);
                  $url=mysqli_real_escape_string($con,$_POST["url"]);  
                  $verify=mysqli_real_escape_string($con,$_POST["verify"]);
                       $who=mysqli_real_escape_string($con,$_POST["l"]);
                  
                       if($url=="")
                       {
                          $url= $code.$academic;
                       }
                       
                     
                       if($ta=="")
          {
              $ta=0;
          }
          
   // check if email is taked
//     $result = mysqli_query($con,
//        "SELECT * FROM courses_table WHERE Course_Name='$name'");
//   if(mysqli_num_rows($result)!=0)
//    {
//        $_SESSION["info_Admin_Courses"]="Course Name : ".$name." already used.";
//        header("Location: Admin.php");        
//    }
//    
  
      $sql="INSERT INTO `courses_table`(`Course_Name`, `Academic_Year`, `Faculty`, `Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members`) 
            VALUES ('$name','$academic','$faculty','$lecturer','$ta','$code','$url','$verify')";
    
    
   if ($con->query($sql) === TRUE) {
         $_SESSION["info_Admin_Courses"]="Course portal was Created successfully.";
 if($who=="l")
 {
  header("Location: Courses.php");    
 } else
 {
 header("Location: Admin.php"); 
 }
         
    
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
 }
 
 
 
 
 
 
 
 //exportgrade
 
   if (!empty($_GET["exportgrade"])) {
	   
	   $lab=$_GET["lab"];
     $lab_name=$_GET["lab_name"];
    
       
       
       error_reporting(0);
       
       $select = "SELECT lab_reports_table.Title as 'LAB_Report', lab_reports_table.Marks as Lab_Marks,
 `Submission_Date`, lab_report_submissions.Student_id, users_table.Full_Name as Student_Name,  lab_report_submissions.Marks,`Notes`
FROM `lab_report_submissions`

INNER JOIN lab_reports_table on lab_reports_table.Lab_Report_ID=lab_report_submissions.Lab_Report_ID

INNER JOIN users_table on users_table.Student_ID=lab_report_submissions.Student_id


WHERE lab_report_submissions.Lab_Report_ID=$lab";


          $export  = mysqli_query($con,$select);
       
       
       
       $fields = mysqli_num_fields ( $export );

     
for ( $i = 0; $i < $fields; $i++ )
{
    $header .= mysqli_fetch_field_direct( $export , $i )->name. "\t";
}


while( $row = mysqli_fetch_row( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$lab_name Garde Sheet.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
       

           
           
           

   }
   

