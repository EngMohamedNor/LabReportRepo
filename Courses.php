


<?php


$page='Courses';
include 'Header.php';

$user_d=$_SESSION['user_id'];










 if( $_SESSION['user_type']=="Lecturer" || $_SESSION['user_type']=="TA")
        {
    ?>



<!--    FOR LECTURER-->


<div class="row" style="width:80%;margin:auto; text-align:left;">
   
  
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
 
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
<script>
    

    function extend_deadline(id) {
    
    var dropstudents=$("#dropstudents").html();
   
    try
    {
        

    $('<form id="frm" method="get" action="Script.php">\n\
    <input type="hidden" name="extenddeadline" value="true" >\n\
   <input type="hidden" name="id" value="'+id+'" > \n\
New Date/Time <br><input type="date" name="date" required=""> <input type="time" name="time" required=""> \n\
  \n\
<br><input type="radio" value="1" name="type" required=""> Extend for All<hr>  \n\
<input type="radio" value="2" name="type" required=""> Extend for these Individual Students \n\
 '+dropstudents+'   \n\
</form>').dialog({
  modal: true,
          title:'Extend Deadline',
  buttons: {
    'Submit': function () {
   $('#frm').submit();
     
      $(this).dialog('close');
    },
    'X': function () {
  
      $(this).dialog('close');
    }
   
  }
});

    }catch(e){ alert(e); }
}
    
    </script>
    

  <?php
  if(!empty($_GET["course"]))
  {
      $course_url=$_GET["course"];
 $result = mysqli_query($con,"SELECT `Course_ID`, `Course_Name`, `Academic_Year`, `Faculty`,"
         . " `Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members`  "
         . " , users_table.Full_Name  FROM `courses_table` INNER JOIN users_table"
         . " ON users_table.User_ID=courses_table.Lecturer_User_ID where URL='$course_url' ");
 
 if(mysqli_num_rows($result)==0)
    {} else { while($row = mysqli_fetch_assoc($result)) {
			$name=$row['Course_Name'];
                        $code=$row['Course_Code'];
                         $faculty=$row['Faculty'];	
                         $lecturer=$row['Full_Name'];
                          $academic=$row['Academic_Year'];
                                $url=$row['URL'];
                                  $id=$row['Course_ID'];
                          $course_id=$row['Course_ID'];
                echo    "  
                  
                        <div class='alert> <a href='~\..\Courses.php?course=$url'>   <div class='panel'>
  ($code) - $name 
   <br> <span style='font-size:8pt'>Faculty : $faculty  Year :   $academic  Lecturer  :$lecturer </span>
</div></a>
                        <hr></div></div> <div class='row' style='width:80%;margin:auto; text-align:left;'>
 ";
               
                 echo "<div class='col-md-5'>";
                 
                 
                 
             if( $_SESSION['user_type']=="Lecturer"){    
                echo "<h3> Post new Lab Assignment </h3><form method='post'   enctype='multipart/form-data' action='Script.php'>
                   <input type='hidden' name='frm_uploadlab' value='true' required=''/>
                      <input type='hidden' name='course_id' value='".$id."' required=''/>
                            <input type='hidden' name='url' value='".$course_url."' required=''/>
                     
 Dealine Date/Time
 <div class='row'> 
 <div class='col-md-7'><input type='date' id='date' name='deadlinedate' placeholder='' class='form-control' required=''> </div>
<div class='col-md-5'> <input type='time' class='form-control' name='deadlinetime'> </div> 
</div>

Title
<input type='text'  name='title' placeholder='Ttle' class='form-control' required=''>
 Instructions
<textarea  name='instructions' placeholder='Assignment Instructions' class='form-control' required=''></textarea>
Marks
<input type='text'  name='marks' placeholder='Marks' class='form-control' required=''>
 Attachment 1
<input type='file'  name='attachment1' placeholder='Attachment 1' class='form-control'>

 Attachment 2
<input type='file' name='attachment2' placeholder='Attachment 1' class='form-control'>

 Attachment 3
<input type='file'  name='attachment3' placeholder='Attachment 1' class='form-control' >


 Attachment 4
<input type='file'  name='attachment4' placeholder='Attachment 4' class='form-control' >
<br>
Submission Type  <input type='radio' name='type' value='Individual' required=''> Invidual

<input type='radio' name='type' value='Group' required=''> Group
<hr>
  <input type='submit' class='btn btn-primary' value='Post Lab Assignment'><br>
</form><br><br><br><br>
   ";
                
             }          
    }
    }      
       echo "</div>"; 
       
            echo "<div class='col-md-7'>  <h3> Lab Report Assignment list </h3>";  
                  
 error_reporting(0);
if (isset($_SESSION['info_courses'])) {
    echo '<hr><div class="alert alert-info" role="alert">' . $_SESSION['info_courses'] . '</div>';
    $_SESSION['info_courses'] = null;
}
if (isset($_SESSION['info_courses'])) {
    echo '<hr><div class="alert alert-info" role="alert">' . $_SESSION['info_courses'] . '</div>';
  $_SESSION['info_courses']=null;
}


            
              
            $result = mysqli_query($con," SELECT `Lab_Report_ID`,Type,Marks, `Course_ID`, `Posted_Date`, `Deadline`, `Instructions`, `Title`, `Attachment_link_1`, `Attachment_link_2`, `Attachment_link_3`, "
                    . "`Attachment_link_4` FROM `lab_reports_table` WHERE Course_ID=$id ORDER by Lab_Report_ID DESC");
 
            
             if( $_SESSION['user_type']=="TA")
        {
            echo "<b style='color:orange'>* Only Lecturers can Post new Lab report Assignments </b><br>";
        }
 if(mysqli_num_rows($result)==0)
    {
     echo "No assignments posted so far.";
     
    } else { while($row = mysqli_fetch_assoc($result)) {
	$marks=$row['Marks'];		
        $title=$row['Title'];
                        $ins=$row['Instructions'];
                         $posted=$row['Posted_Date'];	
                         $deadline=$row['Deadline'];
                          $att1=$row['Attachment_link_1'];
                              $att2=$row['Attachment_link_2'];
                                   $att3=$row['Attachment_link_3'];
                                    $att4=$row['Attachment_link_4'];
                                     $id=$row['Lab_Report_ID'];
                             $as_type=$row['Type'];
                                     $full_link="<a href='~\..\Lab_Report_Assignments\\$att1'>$att1</a>";      
                                     
                                     if($att2!=""){
                                       $full_link= $full_link." &nbsp|&nbsp <a href='~\..\Lab_Report_Assignments\\$att2'>$att2</a>";    
                                     }
                                      if($att3!=""){
                                       $full_link= $full_link." &nbsp|&nbsp <a href='~\..\Lab_Report_Assignments\\$att3'>$att3</a>";    
                                     }
                                     
                                      if($att4!=""){
                                       $full_link= $full_link." &nbsp; | &nbsp <a href='~\..\Lab_Report_Assignments\\$att4'>$att4</a>";    
                                     }
                                      
                                     
                              
                                     
                                  $resultx1 = mysqli_query($con,"Select Count(*) as cnt from lab_report_submissions where lab_report_submissions.Lab_Report_ID=$id");
     while($row = mysqli_fetch_assoc($resultx1)) {$count_subs=$row['cnt'];}    
                                     
            $resultx2 = mysqli_query($con,"Select COUNT(*) as cnt from lab_report_submissions where lab_report_submissions.Lab_Report_ID=$id and Marks is not null");
     if(mysqli_num_rows($resultx2)==0){$count_marked=0;} else { while($row = mysqli_fetch_assoc($resultx2)) {$count_marked =$row['cnt'];}}     
                            
                            
                $header="Courses > ".$name."($code) > Assignments > ".$title;
                                     
                echo "      <div class='break-word btn btn-default' style='word-wrap: break-word;border-color:grey;'>
  $title ($as_type) <br> $ins
   <br> <span style='font-size:8pt'>Posted : $posted  Deadline :  <b> $deadline </b> &nbsp; ($marks Marks)      &nbsp;    &nbsp; &nbsp; &nbsp; &nbsp;   "
                        . "<br>"

                        . "<span class='btn-default'> &nbsp;&nbsp; $count_subs Submissions ( $count_marked Marked ) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='~\..\Submissions.php?id=$id&header=$header&total=$marks' onclick=''> View </a>     &nbsp;&nbsp; |&nbsp;&nbsp;         <a href='#'  onclick='extend_deadline($id)'> Extend Deadline </a>  </span>         <hr> Attachments : $full_link </span>"
                                                    . "&nbsp;&nbsp;</div>
                        ";
                
               
                         
    }}
       echo "</div>";
      
      
       
       
       
         $resultx1 = mysqli_query($con,"SELECT course_students_table.Student_ID,users_table.Full_Name FROM 
`course_students_table`
INNER JOIN users_table on users_table.Student_ID=course_students_table.Student_ID
WHERE Course_ID=$course_id");
    
         
         echo "<span id='dropstudents' style='display:none;'> <select name='stdid'>";
         while($row = mysqli_fetch_assoc($resultx1)) 
        {
             $stdid=$row['Student_ID'];
             $stdname=$row['Full_Name'];
          
             echo "<option value='$stdid'> $stdname($stdid) </option> ";
        }  
      echo "</select><br>Reason <input type='text' name='reason'>"
        . "<input type='hidden' name='url' value='$course_url'>"
              . " </span>";
      
      
      
      
      return;

  }
  
  ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <div class="col-md-8">
         
         <?php 
         $user_name=$_SESSION['user_fullname'];
         
                     echo    "  <div class='alert' style='margin-left:20px;border-bottom:2px solid #1D91EF;'> <a href='~\..\Courses.php?course=$url'>
  Course Portal  > $user_name (Lecturer) > Course Listing
   <br> <span style='font-size:8pt'> </span>
</a></div>
 ";
   
                     
 $result = mysqli_query($con,"SELECT `Course_ID`, `Course_Name`, `Academic_Year`, `Faculty`, "
         . "`Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members`   , users_table.Full_Name  FROM `courses_table` INNER JOIN users_table ON users_table.User_ID=courses_table.Lecturer_User_ID where courses_table.Lecturer_User_ID=$user_d");
 
  if($_SESSION['user_type']=="TA")
 {
      $result = mysqli_query($con,"SELECT course_ta.Course_ID, `Course_Name`, 
          `Academic_Year`, `Faculty`, `Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members`   FROM `courses_table` 
INNER JOIN 
course_ta ON course_ta.Course_ID=courses_table.Course_ID where course_ta.TA=$user_d");

 }
 // $result = mysqli_query($con,"SELECT `Course_ID`, `Course_Name`, `Academic_Year`, `Faculty`, `Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members`   , users_table.Full_Name  FROM `courses_table` INNER JOIN users_table ON users_table.User_ID=courses_table.Lecturer_User_ID");

 
 if(mysqli_num_rows($result)==0)
    {} else { while($row = mysqli_fetch_assoc($result)) {
		$id=$row['Course_ID'];	
        $name=$row['Course_Name'];
                        $code=$row['Course_Code'];
                         $faculty=$row['Faculty'];	
                         $lecturer=$row['Full_Name'];
                          $academic=$row['Academic_Year'];
                                $url=$row['URL'];
                    
                    $resultTA = mysqli_query($con,"SELECT `Course_ID`, `TA`,users_table.Full_Name as TA_NAME FROM `course_ta`
INNER JOIN users_table on users_table.User_ID=course_ta.TA
where course_ta.Course_ID=$id");  
                    
                    $ta="";
                    while($rowTA = mysqli_fetch_assoc($resultTA)) {
                        $ta=$ta."  - ".$rowTA['TA_NAME'];
                    }
                    
                    
                                
                echo"  
                  
                         <a href='~\..\Courses.php?course=$url'>   <div class='btn btn-default'>
  ($code) - $name 
   <br> <span style='font-size:8pt'>Faculty : $faculty &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Year :  $academic  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Lecturer  :$lecturer  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  TA:$ta </span>
</div></a>
                        ";
   
              }}?>
  </div>
 <div class="col-md-4">
     <br>
     <b> Course Joining Requests </b>
     


<?php
$lecturer_id= $_SESSION['user_id'];
 $result = mysqli_query($con,"SELECT  course_students_table.ID,users_table.Full_Name,  courses_table.Course_ID, `Course_Name`, `Academic_Year`, `Faculty`, `Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members` FROM `courses_table` 
INNER JOIN course_students_table on  course_students_table.Course_ID=courses_table.Course_ID
INNER JOIN users_table on users_table.Student_ID=course_students_table.Student_ID
WHERE  Lecturer_User_ID=$lecturer_id and course_students_table.Status='Pending'");
 
 if(mysqli_num_rows($result)==0)
    {
     
     echo "<br>  <i class='fa fa-info-circle'></i> No Course joining request so far for all your courses <hr>";
    } else { while($row = mysqli_fetch_assoc($result)) {
	$id=$row['ID'];	
        		
        $name=$row['Course_Name'];
                        $code=$row['Course_Code'];
                         $faculty=$row['Faculty'];	
                         $std_name=$row['Full_Name'];
                          $academic=$row['Academic_Year'];
                          
                             echo "<div class='btn btn-default'>
 $std_name is Requesting to join <br> [($code) - $name ] &nbsp;&nbsp;&nbsp;&nbsp; <br><a href='~\..\Script.php?AcceptStudent=y&id=$id&rs=yes' class='btn-sm btn-success' onclick=return confirm(\"are you sure to join this course?\")' > Accept </a>
 &nbsp;&nbsp;<a href='~\..\Script.php?AcceptStudent=y&id=$id&rs=no' class='btn-sm btn-danger' onclick=return confirm(\"are you sure to join this course?\")' > Decline </a>                     
</div>";
                          
                          
                          
    }
    }
                          ?>





     
 <?php 
  if( $_SESSION['user_type']=="TA")
        {
            echo "<center>Only Lecturers can Post new Lab report Assignments</center>";
        }
 if( $_SESSION['user_type']=="Lecturer"){ ?>
     
 <b>Create new Course Portal </b>
		
<form method="post" action="Script.php">
 <input type="hidden" name="frm_createCourse" value="true" required=""/>
  <input type="hidden" name="l" value="l" required=""/>
 Course Name
<input type="text" name="name" placeholder="Course Name" class="form-control" required="">

 Course Code
<input type="text" name="code" placeholder="Course Code" class="form-control" required="">

URL (Leave blank to use Course Code & Year)
<input type="text" name="url" placeholder="Choose Custom URL " class="form-control">

Academic Year
<input type="text" name="academic" placeholder="Academic Year" class="form-control" required="">

 Faculty <br>
<input type="text" name="faculty" placeholder="Faculty" class="form-control" required="">


<input type="hidden" name="lecturer" value="<?php echo $_SESSION['user_id'];  ?>">


Verify Joining Students
<input type="radio" name="verify" value="1"> Yes
<input type="radio" name="verify" value="0" checked=""> No

	 <br>
  <input type="submit" class="btn btn-primary" value="Create Portal"><br>
  
  </form>
      
 <?php }  ?>
            
</div>
    
    
<!--   END LECTURER   -->

<?php 
        } 
        
       
        
        if( $_SESSION['user_type']=="Student")
        {
        ?>

























































































<!--STUDENT CODE-->
<div class="row" style="width:80%;margin:auto; text-align:left;">
    <div class="col-md-6">
    <br>  Course Portal > Students <br>
    <?php
    
     error_reporting(0);
if (isset($_SESSION['info_Courses_student'])) {
    echo '<hr><span class="alert alert-success" role="alert">' . $_SESSION['info_Courses_student'] . '</span>';
    $_SESSION['info_Courses_student'] = null;
}
?>
    <br><br>
    </div>
      <div class="col-md-6"></div>
</div>





<div class="row" style="width:80%;margin:auto; text-align:left;">
    <div class="col-md-6">
    

          
<?php 
error_reporting(0);
$student_id= $_SESSION['user_student_id'];
if(!empty($_GET["search"]) || !empty($_GET["faculty"]))
  {
      $search=$_GET["search"];
       $faculty=$_GET["faculty"];
    
       
      if($faculty=="")
      {
           echo "<h4> Search Results for  Code : $search</h4><hr>";
           $result = mysqli_query($con,"SELECT `Course_ID`, `Course_Name`, `Academic_Year`, `Faculty`,"
         . " `Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members`  "
         . " , users_table.Full_Name  FROM `courses_table` INNER JOIN users_table"
         . " ON users_table.User_ID=courses_table.Lecturer_User_ID where Course_Code='$search'  and courses_table.Course_ID not in (select course_id from course_students_table where Student_ID=$student_id)");
      } 
      else
      {
          echo "<h3> Find Courses under faculty $faculty</h3>";
           $result = mysqli_query($con,"SELECT `Course_ID`, `Course_Name`, `Academic_Year`, `Faculty`,
       `Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members` 
         , users_table.Full_Name  FROM `courses_table` INNER JOIN users_table
         ON users_table.User_ID=courses_table.Lecturer_User_ID where Faculty='$faculty'  and courses_table.Course_ID not in (select course_id from course_students_table where Student_ID=$student_id)");
      }
     

 if(mysqli_num_rows($result)==0)
    {
echo "No results found for your Search <hr>";

    } else { while($row = mysqli_fetch_assoc($result)) {
			$name=$row['Course_Name'];
                        $code=$row['Course_Code'];
                         $faculty=$row['Faculty'];	
                         $lecturer=$row['Full_Name'];
                          $academic=$row['Academic_Year'];
                          $url=$row['URL'];
                            $id=$row['Course_ID'];
                            $v=$row['Verify_New_Members'];
                            $msg2="Join this Course";
                            if($v>0)
                            {
                                $msg="<i class='fa fa-exclamation-circle'></i> Lecturer Verification required";
                                $msg2="Send Joining Request";
                            }
               
                                  echo "<div class='btn btn-default' style='word-wrap:break-word'>
  ($code) - $name <br>($url) <br>  <a href='~\..\Script.php?JoinCourse=y&id=$id&std=$student_id&joining=$v' class='btn-sm btn-success' onclick=return confirm(\"are you sure to join this course?\")' > $msg2 </a>
   <br> <span style='font-size:8pt'>Faculty : $faculty  Year :   $academic  Lecturer  :$lecturer </span><br>$msg</div>
                        ";
               
               
    }
    }
    
    
    
    
     }
     
     
     
     
     
     
     
     
     echo "<h4> My Courses </h4>";
          $result = mysqli_query($con,"SELECT users_table.Full_Name, course_students_table.Status, courses_table.Course_ID, `Course_Name`, `Academic_Year`, `Faculty`, `Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members` FROM `courses_table`
INNER JOIN users_table
          ON users_table.User_ID=courses_table.Lecturer_User_ID

INNER JOIN course_students_table on course_students_table.Course_ID=courses_table.Course_ID

                  where course_students_table.Student_ID=$student_id");
 
 if(mysqli_num_rows($result)==0)
    {
     echo "<i class='fa fa-exclamation-circle'></i> You are not Enrolled in any Course";
    } else { while($row = mysqli_fetch_assoc($result)) {
			$name=$row['Course_Name'];
                        $code=$row['Course_Code'];
                         $faculty=$row['Faculty'];	
                         $lecturer=$row['Full_Name'];
                          $academic=$row['Academic_Year'];
                          $url=$row['URL'];
                            $id=$row['Course_ID'];
                                $Status=$row['Status'];
                            
               if($Status=="Joined")
               {
                 echo "<a href='~\..\Course.php?url=$url'>   <div class='btn btn-default' style='word-wrap:break-word'>
  ($code) - $name <br>($url)       &nbsp;&nbsp;&nbsp; <i class='fa fa-check-circle'></i> $Status   &nbsp;&nbsp;&nbsp;&nbsp; <a href='~\..\Course.php?url=$url' class='btn-sm btn-primary'> Open</a>
   <br> <span style='font-size:8pt'>Faculty : $faculty  Year :   $academic  Lecturer  :$lecturer </span></div></a>
                        ";  
               }
                    else
                    {
                       echo "<div class='btn btn-default'>
  ($code) - $name  <i class='btn-sm btn-danger'> $Status</i>
   <br> <span style='font-size:8pt'>Faculty : $faculty  Year :   $academic  Lecturer  :$lecturer </span></div>
                        "; 
                    }
                                  
               
                                  
               
    }
    } 
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
   
    
    
    
    
    
    
    
    
    echo "</div><div class='col-md-6'>
    
        <form method='get' action='Courses.php'>
            <div class='row'> 
            <div class='col-md-10'> 
            <div class='row'><div class='col-md-6'> Find course by Code
            <input  type='text' class='form-control' name='search' placeholder='Enter Course Code'>
            </div><div class='col-md-6'>
List courses by faculty

<select name='faculty' class='form-control'>";
 $result = mysqli_query($con,"SELECT   DISTINCT(Faculty) as Faculty FROM `courses_table`");
 if(mysqli_num_rows($result)==0)
    {} else { while($row = mysqli_fetch_assoc($result)) {
			$fname=$row['Faculty'];
			
		   echo "<option value=''> Search by faculty </option> <option value='$fname'> $fname </option>";
		}}

echo "</select></div></div>

</div>
                 <div class='col-md-1'> <br>
            <input type='submit' class='btn btn-primary' value='Find'>
            </div>
       
        </div>
        </form>
        




    </div></div>"; 
    





















































        
        }
       
        ?>







    <style>
        
        .form-control{
            padding-top: 1px;
             padding-bottom:1px;
        }
        </style>
        
        
        
        
        
        
        
