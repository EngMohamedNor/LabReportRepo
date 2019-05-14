
<?php
$page='Courses+';
include 'Header.php';
  $student_id=$_SESSION["user_student_id"];
    $group_id=$_SESSION["user_group_id"];
  $c_date=  date("Y-m-d H:i");

 if(!empty($_GET["url"]))
  {
      $course_url=$_GET["url"];
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
                                  $course_id=$row['Course_ID'];
                                    $id2=$row['Course_ID'];
                         
                echo    "  <div class='alert' style='margin-left:20px;border-bottom:2px solid #1D91EF;'> <a href='~\..\Courses.php?course=$url'>
  Courses > $name ($code) > Lab Reports
   <br> <span style='font-size:8pt'>Faculty : $faculty  Year :   $academic  Lecturer  :$lecturer  </span>
       

</a></div>
 ";
        
    }}
  }
?>
<div class="row" style='margin-left:20px;float:left'>
    
    <?php
    
                if (isset($_SESSION['info_ReMarking'])) {
    echo '<hr><div class="alert alert-info" role="alert" style="float:left;">' . $_SESSION['info_ReMarking'] . '</div>';
  $_SESSION['info_ReMarking']=null;
}
   
   if (isset($_SESSION['info_courses'])) {
    echo '<hr><div class="alert alert-info" role="alert" style="float:left;">' . $_SESSION['info_courses'] . '</div>';
  $_SESSION['info_courses']=null;
}
    ?>
    
</div>



<?php

if( $_SESSION['user_type']=="Student")
        {
    
    


?>
 <hr>

<div class="row" style="width:95%;margin:auto; text-align:left;">
   


<div class="col-md-9">
    
    <!-- Nav tabs -->
 <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#menu1">New Labs Reports</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu2">Missed Lab Reports </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu3">Submitted Lab Reports</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu4">Marked Submissions</a>
    </li>
  </ul>
    
 <div class="tab-content">
 <div id="menu1" class="container tab-pane active"><br>
        
 <?php

 // Get groups of this students
 $sql="SELECT course_group_members_table.Course_Group_id
FROM course_group_members_table inner join
course_groups_table  on course_group_members_table.Course_Group_id = course_groups_table.Course_Group_id
WHERE course_group_members_table.Student_ID=$student_id and course_groups_table.Course_id=$course_id";
 
 
 
$resultx1 = mysqli_query($con,$sql);
    
while($row = mysqli_fetch_assoc($resultx1)) {$group_id=$row['Course_Group_id'];}  
 
if($group_id==""){$group_id=-1;}

 


$var="SELECT Type,Lab_Report_ID,Marks, `Course_ID`, `Posted_Date`, `Deadline`, `Instructions`, lab_reports_table.Title, `Attachment_link_1`, `Attachment_link_2`, `Attachment_link_3`, `Attachment_link_4`
      FROM `lab_reports_table` WHERE Course_ID=$course_id  "
         . ""
         . "and (deadline > '$c_date' or Lab_Report_ID in (SELECT `Lab_Report_ID` FROM `extended_deadlines_table`"
         . " WHERE  Lab_Report_ID in (select Lab_Report_ID from lab_reports_table where Course_ID=$course_id) and Student_ID=$student_id and Extended_Deadline_Date > '$c_date')       ) "   
         . ""
         . ""
         . ""
         . ""
         . "and Lab_Report_ID not in (select Lab_Report_ID from lab_report_submissions"
         . " where (Student_id=$student_id or Course_Group_id=$group_id)  and Course_ID=$course_id)"
         . ""
         . " ORDER by Lab_Report_ID DESC";



 $result1 = mysqli_query($con,$var);
   
if(mysqli_num_rows($result1)==0)
    {
     echo "No Active assignments for this course so far.";
    } else { while($row = mysqli_fetch_assoc($result1)) {
			$title=$row['Title'];
                        $type=$row['Type'];
                        $Marks=$row['Marks'];
                        $ins=$row['Instructions'];
                         $posted=$row['Posted_Date'];	
                         $deadline=$row['Deadline'];
                          $att1=$row['Attachment_link_1'];
                              $att2=$row['Attachment_link_2'];
                                   $att3=$row['Attachment_link_3'];
                                    $att4=$row['Attachment_link_4'];
                                     $labid=$row['Lab_Report_ID'];
                                   
                                    $full_link="<a href='~\..\Lab_Report_Assignments\\$att1'>$att1</a>";      
                                     
                                     if($att2!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Assignments\\$att2'>$att2</a>";    
                                     }
                                      if($att3!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Assignments\\$att3'>$att3</a>";    
                                     }
                                     
                                      if($att4!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Assignments\\$att4'>$att4</a>";    
                                     }
                echo "   <k href='#'>   <div class='btn btn-default break-word' style='dislay:block; word-wrap: break-word; border: 1px solid #F0F0F0;border-left: 4px solid #03407B;'>
  $title ($type) <br> <span style='font-size:8pt'> $ins</span> 
   <br> <span style='font-size:8pt'>Posted : $posted &nbsp;&nbsp;&nbsp;&nbsp; Deadline :   $deadline   &nbsp;&nbsp;&nbsp;&nbsp;($Marks Marks)  &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;<a href='~\..\SubmitLab.php?id=$labid&url=$url' class='btn-sm btn-info' style='margin-left:50px;'> Submit Lab Report</a><br> Attachments : $full_link </span>  
</div></k>";
                
                                      }}
       echo "";
       ?>
    
    </div>
    
       <div id="menu2" class="container tab-pane"><br>
         <?php
      $result  = mysqli_query($con,"SELECT Lab_Report_ID,Marks, `Course_ID`, `Posted_Date`, `Deadline`, `Instructions`, lab_reports_table.Title, `Attachment_link_1`, `Attachment_link_2`, `Attachment_link_3`, `Attachment_link_4`
          FROM `lab_reports_table`
          where 
          




Lab_Report_ID not in 
          (select Lab_Report_ID from lab_report_submissions where (Student_id=$student_id or Course_Group_id=$group_id)  and Course_ID=$course_id      )
     and Course_ID=$course_id and deadline < '$c_date'    "
        . ""
              . ""
              . ""
              . ""
              . ""
              . ""
        . "ORDER by Lab_Report_ID DESC");



if(mysqli_num_rows($result)==0)
    {
     echo "You Missed no Lab reports in this course";
     
    } else { while($row = mysqli_fetch_assoc($result)) {
			$title=$row['Title'];
                        $marks=$row['Marks'];
                        $ins=$row['Instructions'];
                         $posted=$row['Posted_Date'];	
                         $deadline=$row['Deadline'];
                          $att1=$row['Attachment_link_1'];
                              $att2=$row['Attachment_link_2'];
                                   $att3=$row['Attachment_link_3'];
                                    $att4=$row['Attachment_link_4'];
                                     $id=$row['Lab_Report_ID'];
                             
                                     
                                     
                                  
                                     $full_link="<a href='~\..\Lab_Report_Assignments\\$att1'>$att1</a>";      
                                     
                                     if($att2!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Assignments\\$att2'>$att2</a>";    
                                     }
                                      if($att3!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Assignments\\$att3'>$att3</a>";    
                                     }
                                     
                                      if($att4!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Assignments\\$att4'>$att4</a>";    
                                     }
  ;   
   
           echo "   <k href='#'>   <div class='btn btn-default break-word' style='dislay:block; word-wrap: break-word; border: 1px solid #F0F0F0;border-left: 4px solid #03407B;'>
  $title <br> <span style='font-size:8pt'> $ins</span> 
   <br> <span style='font-size:8pt'>Posted : $posted  &nbsp; &nbsp; &nbsp; Deadline :   $deadline  &nbsp; &nbsp; &nbsp; ($marks Marks) &nbsp; &nbsp; <span class='btn-sm btn-warning' style='margin-left:50px;'><i class='fa fa-times-circle'></i>  Missed !</span><br> Attachments : $full_link </span>
</div></k>";
                
                                      }}
       echo "";
       ?>  
           
           
       </div>
   <div id="menu3" class="container tab-pane"><br>
         <?php
$resultx  = mysqli_query($con,"SELECT Lab_Report_ID,Marks, `Course_ID`, `Posted_Date`, `Deadline`, `Instructions`, lab_reports_table.Title, `Attachment_link_1`, `Attachment_link_2`, `Attachment_link_3`, `Attachment_link_4`
         FROM `lab_reports_table`
         
  where    Lab_Report_ID  in (select Lab_Report_ID from lab_report_submissions"
         . " where Status='Pending' and (Student_id=$student_id or Course_Group_id=$group_id)  and Course_ID=$course_id) ORDER by Lab_Report_ID DESC");
if(mysqli_num_rows($resultx)==0)
    {
     echo "You have  no Lab report submissions in this course";
     
    } else { while($row = mysqli_fetch_assoc($resultx)) {
			$title=$row['Title'];
                        $marks=$row['Marks'];
                        $ins=$row['Instructions'];
                         $posted=$row['Posted_Date'];	
                         $deadline=$row['Deadline'];
                          $att1=$row['Attachment_link_1'];
                              $att2=$row['Attachment_link_2'];
                                   $att3=$row['Attachment_link_3'];
                                    $att4=$row['Attachment_link_4'];
                                     $id=$row['Lab_Report_ID'];
                              
                                      if( $c_date < $deadline)
                                     {
                                         $submittedx="<a  href='~\..\SubmitLab.php?id=$id' class='btn-sm btn-default'><i class='fa fa-check-circle'></i> Re-Submit </a>";
                                     }
 else {
     
 }
                                     
                                     $full_link="<a href='~\..\Lab_Report_Assignments\\$att1'>$att1</a>";      
                                     
                                     if($att2!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Assignments\\$att2'>$att2</a>";    
                                     }
                                      if($att3!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Assignments\\$att3'>$att3</a>";    
                                     }
                                     
                                      if($att4!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Assignments\\$att4'>$att4</a>";    
                                     }
  ;   
   
           echo "   <k href='#'>   <div class='btn btn-default break-word' style='dislay:block; word-wrap: break-word; border: 1px solid #F0F0F0;border-left: 4px solid #03407B;'>
  $title <br> <span style='font-size:8pt'> $ins</span> 
   <br> <span style='font-size:8pt'>Posted : $posted  Deadline :   $deadline  ($marks Marks) &nbsp; &nbsp;  $submittedx&nbsp; <span class='btn-sm btn-success' style='margin-left:50px;'><i class='fa fa-Edit-circle'></i>  Submitted </span><br> Attachments : $full_link </span>
</div></k>";
                
                                      }}
       echo "";
       ?>  
           
           
       </div>        
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          <div id="menu4" class="container tab-pane"><br>
         <?php
      
$resultx  = mysqli_query($con,"SELECT `Submission_ID`, `Submission_Date`, lab_reports_table.`Lab_Report_ID`, `Student_id`, "
        . "`Course_Group_id`, `Notes`, lab_report_submissions.`Marks`, `Status`, lab_reports_table.Title Lab_Title,lab_reports_table.Marks Original_marks FROM `lab_report_submissions` "
        . "INNER JOIN lab_reports_table on lab_reports_table.Lab_Report_ID=lab_report_submissions.Lab_Report_ID "
        . "WHERE lab_report_submissions.Student_id='$student_id' and" 
        . ""
        . ""
        . ""
        . " lab_reports_table.Lab_Report_ID  in (select Lab_Report_ID from lab_report_submissions"
         . " where  (Status='Marked' or Status='Remarking') and (Student_id=$student_id)  and Course_ID=$course_id) ORDER by Submission_ID DESC");

    


if(mysqli_num_rows($resultx)==0)
    {
     echo "You have No Marked submissions in this course";
     
    } else { while($row = mysqli_fetch_assoc($resultx)) {
			$title=$row['Lab_Title'];
                        $marks=$row['Marks'];
                          $Originalmarks=$row['Original_marks'];
                        $ins=$row['Instructions'];
                         $posted=$row['Posted_Date'];	
                         $deadline=$row['Deadline'];
                          $att1=$row['Attachment_link_1'];
                              $att2=$row['Attachment_link_2'];
                                   $att3=$row['Attachment_link_3'];
                                    $att4=$row['Attachment_link_4'];
                                     $id=$row['Lab_Report_ID'];
                              $Submission_ID=$row['Submission_ID']; 
                              $notes=$row['Notes'];
                                $status= $row['Status'];
   
                              if($status=='Marked')
                              {
                                  $remarking="<a href='~\..\Script.php?remarking=yes&id=$Submission_ID&url=$url&status=Remarking' class='btn-sm btn-success'>  Request Remarking </a>";
                              }
                              if($status=='Remarking')
                              {
                                     $remarking="<span  style='color:orange'><i class='fa fa-info-circle'></i> Remarking Request sent </span>";
                              
                              }
                              
   
           echo "   <k href='#'>   <div class='btn btn-default break-word' style='dislay:block; word-wrap: break-word; border: 1px solid #F0F0F0;border-left: 4px solid #03407B;'>
  $title  <b> ($marks Marks out of $Originalmarks)</b><br><small> Lecturer Feedback : $notes </small> &nbsp; $remarking </div></k>";
                
                                      }}
       echo "";
       ?>  
           
           
       </div>      
          
          
          
          
          
          
          
          
          
          
          
          
       </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</div>
    
<div class="col-md-3">
    <h3>Class Groups</h3>  
       
    <?php
    $resultx1 = mysqli_query($con,"SELECT `Course_Group_id`  FROM `course_groups_table` WHERE  Course_id=$course_id");
     while($row = mysqli_fetch_assoc($resultx1)) {$count_groups=$row['Course_Group_id'];} 

     
         echo " <button onclick='CreateGroup()' class='btn btn-primary'> Create Group</button>";
    
    ?>
    
    
  
        <hr>
    <?php
    
     $result = mysqli_query($con,"  SELECT `ID`, course_group_members_table.Course_Group_id, `Student_ID`,
         `Status`,course_groups_table.Group_Name,course_groups_table.Course_id
FROM `course_group_members_table`  INNER JOIN course_groups_table on 
course_groups_table.Course_Group_id=course_group_members_table.Course_Group_id WHERE Student_id=$student_id and course_groups_table.Course_id=$course_id");
 
if(mysqli_num_rows($result)==0)
    {
     echo "You have no Group in this Course";
    } else { while($row = mysqli_fetch_assoc($result)) {
			$name=$row['Group_Name'];
                        $id=$row['Course_Group_id'];
                        $status=$row['Status'];
                        
                        
                            $extra=" -  <a href='#' class='' onclick='invite($id)'> Invite Others</a></small>";
                       
                            if($status=="Invited")
                            {
                                $extra2="   <a href='#' class='' onclick='accept($id,1)'>Accept</a></small>";  
                            $extra3="   <a href='#' class='' onclick='accept($id,0)'>Decline</a></small>"; 
                                
                            }
                        echo "<div  class='btn-default'><small> $name ($status)  $extra  $extra2  $extra3</small></div>";
                        
                        $rs2=mysqli_query($con,"SELECT `ID`, `Course_Group_id`, course_group_members_table.Student_ID, 
                            course_group_members_table.`Status`,users_table.Full_Name FROM `course_group_members_table` 
INNER JOIN users_table on users_table.Student_ID=course_group_members_table.Student_ID
where course_group_members_table.Course_Group_id=$id");
                        
                        while($row = mysqli_fetch_assoc($rs2)) {
			$name=$row['Full_Name'];
                        $id=$row['Course_Group_id'];
                        $status=$row['Status'];
                         $Student_ID=$row['Student_ID'];
                        
                        
                          echo "<li><small> $name-$Student_ID ($status)</small></li>";
                        
                        }
                        
                        
                        
                        
                        
                        
                        
    }
        }
                        ?>
    

    
  
    
</div>

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    </div>

<?php
        }
        include 'Footer.php';
        ?>


<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
 
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
<script>
    function CreateGroup() {
    
   
    try
    {
        

    $('<form id="frm" method="get" action="Script.php"><input type="hidden" name="creategroup" value="true">\n\
 <input type="hidden" name="student_id" value="<?php echo $student_id; ?>" > Group Name  <input type="text" name="name">\n\
<input type="hidden" name="url" value="<?php echo $url; ?>">  <input type="hidden" name="id" value="<?php echo $course_id; ?>">    </form>').dialog({
  modal: true,
          title:'Create Group',
  buttons: {
    'Create Group': function () {
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
    
    
    
    
        function invite(id) {
    
   
    try
    {
        

    $('<form id="frm" method="get" action="Script.php"><input type="hidden" name="groupinvite" value="true">\n\
 <input type="hidden" name="groupid" value="'+id+'" > Enter Student_ID to Invite  <input type="text" name="student_id">\n\
<input type="hidden" name="url" value="<?php echo $url; ?>">  <input type="hidden" name="courseid" value="<?php echo $course_id; ?>">    </form>').dialog({
  modal: true,
          title:'Invite Students to Group',
  buttons: {
    'Invite': function () {
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
  
  
  
  
  
  
  
  
      function accept(id,val) {
    
   
    try
    {
        

    $('<form id="frm" method="get" action="Script.php"><input type="hidden" name="acceptinvite" value="true">\n\
 <input type="hidden" name="groupid" value="'+id+'" > \n\  <input type="hidden" name="action" value="'+val+'" > \n\
\n\
 <input type="hidden" name="student_id" value="<?php echo $student_id; ?>" > \n\
<input type="hidden" name="url" value="<?php echo $url; ?>">  <input type="hidden" name="courseid" value="<?php echo $course_id; ?>">    </form>').dialog({
  modal: true,
          title:'Respond to Group Invite',
  buttons: {
    'Confirm': function () {
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
    
