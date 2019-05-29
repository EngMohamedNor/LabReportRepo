
<?php
$page='Courses+';
include 'Header.php';
  $student_id=$_SESSION["user_student_id"];
    $group_id=$_SESSION["user_group_id"];
  $c_date=  date("Y-m-d H:i");

 if(!empty($_GET["id"]))
  {
      $id=$_GET["id"];
      $course_id=$id;
  }
   if(!empty($_GET["header"]))
  {
      $header=$_GET["header"];
  }
  
    if(!empty($_GET["total"]))
  {
      $total=$_GET["total"];
  } else
  {
      $total=0;
  }
       
  
  $resultx1 = mysqli_query($con,"SELECT `Lab_Report_ID`,Title, `Course_ID`, `Posted_Date`, `Deadline`, `Marks`, `Type` FROM `lab_reports_table` WHERE Lab_Report_ID=$id");
     while($row = mysqli_fetch_assoc($resultx1)) {
        
      $Report_Type=$row['Type'];
         $c_id=$row['Course_ID'];
         $Report_Title=$row['Title'];
         
         
         
     }  
  
 
  
echo "<div class='alert' style='margin-left:20px;border-bottom:2px solid #1D91EF;'> <a href='#'>
 $header 
</a></div>
 ";
   
?>


<div class="row" style="width:80%;margin:auto; text-align:left;">
 
    
    
 
    
<!--    Lecture  CODE-->
<?php

if( $_SESSION['user_type']=="Lecturer" || $_SESSION['user_type']=="TA")
        {
    
?>

<div class="col-md-12">
    
    
    
         <?php 

error_reporting(0);

if(isset($_SESSION['info_Marking'])) {
  echo  '<hr><div class="alert alert-info" role="alert">'.$_SESSION['info_Marking'].'</div>';
  $_SESSION['info_Marking']=null;
}




$resultx1 = mysqli_query($con,"Select Count(*) as cnt from lab_report_submissions where lab_report_submissions.Lab_Report_ID=$id");
     while($row = mysqli_fetch_assoc($resultx1)) {$count_subs=$row['cnt'];}    
                                     
            $resultx2 = mysqli_query($con,"Select COUNT(*) as cnt from lab_report_submissions where lab_report_submissions.Lab_Report_ID=$id and Status='Marked'");
     if(mysqli_num_rows($resultx2)==0){$count_marked=0;} else { while($row = mysqli_fetch_assoc($resultx2)) {$count_marked =$row['cnt'];}}     
          
                 $resultx3 = mysqli_query($con,"Select COUNT(*) as cnt from lab_report_submissions where lab_report_submissions.Lab_Report_ID=$id and Status='Pending'");
     if(mysqli_num_rows($resultx3)==0){$count_unmarked=0;} else { while($row = mysqli_fetch_assoc($resultx3)) {$count_unmarked =$row['cnt'];}} 

 $resultx4 = mysqli_query($con,"Select COUNT(*) as cnt from lab_report_submissions where lab_report_submissions.Lab_Report_ID=$id and Status='Remarking'");
     if(mysqli_num_rows($resultx4)==0){$count_remark=0;} else { while($row = mysqli_fetch_assoc($resultx4)) {$count_remark =$row['cnt'];}} 

 
?>
   
    <b>Lab Report Submissions (<?php echo $count_subs;?>)</b>
    <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#menu1">Un-Marked Submissions<b> (<?php echo $count_unmarked;?>)</b></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#menu2">Marked Submissions <b>(<?php echo $count_marked;?>)</b></a>
    </li>
  
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#menu3">Re-Marking Requests <b>(<?php echo $count_remark;?>)</b></a>
    </li>
    
    
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#menu4"> View Course Groups</a>
    </li>
  </ul> 
      <div class="tab-content">
    <div id="menu1" class="container tab-pane active"><br>
        
 <?php

 
if($Report_Type=="Group")
{
   $result1 = mysqli_query($con,"SELECT `Submission_ID`, `Submission_Date`, lab_report_submissions.Lab_Report_ID,
    lab_report_submissions.Course_Group_id, `Attachment1`,
     `Notes`, `Attachment2`, `Attachment3`, `Attachment4`, `Marks`, lab_report_submissions.Status, 
     `Title`,course_groups_table.Group_Name
FROM `lab_report_submissions`
left JOIN course_groups_table on course_groups_table.Course_Group_id=lab_report_submissions.Course_Group_id
where Lab_Report_ID=$id and lab_report_submissions.Status='Pending'");
}
 else
 {
     $result1 = mysqli_query($con,"SELECT `Submission_ID`, `Submission_Date`, lab_report_submissions.Lab_Report_ID,
     lab_report_submissions.Student_id sub_std, lab_report_submissions.Course_Group_id, `Attachment1`,
     `Notes`, `Attachment2`, `Attachment3`, `Attachment4`, `Marks`, lab_report_submissions.Status, 
     `Title`,users_table.Full_Name,course_group_members_table.Student_ID
FROM `lab_report_submissions`
Left JOIN users_table  on users_table.Student_ID=lab_report_submissions.Student_id
left JOIN course_group_members_table on course_group_members_table.Course_Group_id=lab_report_submissions.Course_Group_id
where Lab_Report_ID=$id and lab_report_submissions.Status='Pending'");   
 }
 

 
 
 
   
if(mysqli_num_rows($result1)==0)
    {
     echo "No Un-Marked Submissions for this Lab Report.";
     
    } else { while($row = mysqli_fetch_assoc($result1)) {
			$title=$row['Title'];
                        $Marks=$row['Marks'];
                        //$ins=$row['Notes']; 
 $posted=$row['Submission_Date'];	
                         $deadline=$row['Deadline'];
                          $att1=$row['Attachment1'];
                              $att2=$row['Attachment2'];
                                   $att3=$row['Attachment3'];
                                    $att4=$row['Attachment4'];
                                     $labid=$row['Lab_Report_ID'];
                                     
                                     $submitted_std=$row['Student_id'];
                                     $submitted_group=$row['Course_Group_id'];
                                     $Submission_ID=$row['Submission_ID'];
                                     $names=$row['Full_Name'];
                                     $groupname=$row['Group_Name']; 
                                       $student_id=$row['sub_std'];
                                
                                      if($submitted_group==0)
                                      {
                                     $submitted_by= $names."(".$student_id.")";
                                      } else {
                                         $submitted_by="<i>(GROUP)</i> $groupname" ;
                                      }
                                       
                                     $full_link="<a href='~\..\Lab_Report_Submisions\\$att1'>$att1</a>";      
                                     
                                     if($att2!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Submisions\\$att2'>$att2</a>";    
                                     }
                                      if($att3!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Submisions\\$att3'>$att3</a>";    
                                     }
                                     
                                      if($att4!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Submisions\\$att4'>$att4</a>";    
                                     }
                echo "   <k href='#'>   <div class='btn btn-default break-word' style='dislay:block; word-wrap: break-word; border: 1px solid #F0F0F0;border-left: 4px solid #03407B;'>
  $title  <br> by : <b> $submitted_by </b>
   <br> <span style='font-size:8pt'>Submitted : $posted   <button class='btn-sm btn-info' style='margin-left:50px;' onclick='mark($Submission_ID,\"$title\",$total)'>  Mark Submission</button><br> Attachments : $full_link </span>  
</div></k>";
                
                                      }}
       echo "";
       ?>
    
    </div>
    
       <div id="menu2" class="container tab-pane"><br>
           
       
           
           
          <?php
          
          
if($Report_Type=="Group")
{
   $result = mysqli_query($con,"SELECT `Submission_ID`,Visibility, `Submission_Date`, lab_report_submissions.Lab_Report_ID,
    lab_report_submissions.Course_Group_id, `Attachment1`,
     `Notes`, `Attachment2`, `Attachment3`, `Attachment4`, `Marks`, lab_report_submissions.Status, 
     `Title`,course_groups_table.Group_Name
FROM `lab_report_submissions`
left JOIN course_groups_table on course_groups_table.Course_Group_id=lab_report_submissions.Course_Group_id
where Lab_Report_ID=$id and lab_report_submissions.Status='Marked'");
}
 else
 {
     $result = mysqli_query($con,"SELECT `Submission_ID`,Visibility, `Submission_Date`, lab_report_submissions.Lab_Report_ID,
     lab_report_submissions.Student_id sub_std, lab_report_submissions.Course_Group_id, `Attachment1`,
     `Notes`, `Attachment2`, `Attachment3`, `Attachment4`, `Marks`, lab_report_submissions.Status, 
     `Title`,users_table.Full_Name,course_group_members_table.Student_ID
FROM `lab_report_submissions`
Left JOIN users_table  on users_table.Student_ID=lab_report_submissions.Student_id
left JOIN course_group_members_table on course_group_members_table.Course_Group_id=lab_report_submissions.Course_Group_id
where Lab_Report_ID=$id and lab_report_submissions.Status='Marked'  Order by lab_report_submissions.Student_id Desc");   
 }
 
 if(mysqli_num_rows($result)==0)
    {
     echo "No Marked submissions for this lab";
     
    } else { 
        
        echo "<h3><a href='~\..\Script.php?exportgrade=true&lab=$id&lab_name=$Report_Title'><i class='fa fa-book'></i> Export Grade Sheet </a></h3>";
        
        while($row = mysqli_fetch_assoc($result)) {
			$title=$row['Title'];
                        $Marks=$row['Marks'];
                        //$ins=$row['Notes']; 
 $posted=$row['Submission_Date'];	
                         $deadline=$row['Deadline'];
                          $att1=$row['Attachment1'];
                              $att2=$row['Attachment2'];
                                   $att3=$row['Attachment3'];
                                    $att4=$row['Attachment4'];
                                     $labid=$row['Lab_Report_ID'];
                                     
                                     $submitted_std=$row['Student_id'];
                                     $submitted_group=$row['Course_Group_id'];
                                     $Submission_ID=$row['Submission_ID'];
                                     $names=$row['Full_Name'];
                                       $student_id=$row['sub_std'];
                                          $Visibility=$row['Visibility'];
                                       $notes=$row['Notes'];
                                
                                      if($submitted_group==0)
                                      {
                                     $submitted_by= $names."(".$student_id.")";
                                      } else {
                                         $submitted_by="<i>(GROUP)</i> Group X " ;
                                      }
                                       
                                     $full_link="<a href='~\..\Lab_Report_Submisions\\$att1'>$att1</a>";      
                                     
                                     if($att2!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Submisions\\$att2'>$att2</a>";    
                                     }
                                      if($att3!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Submisions\\$att3'>$att3</a>";    
                                     }
                                     
                                      if($att4!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Submisions\\$att4'>$att4</a>";    
                                     }
                echo "   <k href='#'>   <div class='btn btn-default break-word' style='dislay:block; word-wrap: break-word; border: 1px solid #F0F0F0;border-left: 4px solid #03407B;'>
  $title  <br> by : <b> $submitted_by  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; [ Marked $Marks ] </b>  &nbsp; Visibility : <b>$Visibility </b>  <button class='btn-sm btn-success' style='margin-left:50px;' onclick='updatev($Submission_ID)'>Update visibility</button> 
   <hr> Lecturer/TA notes : $notes<br> <span style='font-size:8pt'>Submitted : $posted        <b>  </b> <button class='btn-sm btn-info' style='margin-left:50px;' onclick='mark($Submission_ID,\"$title\",$total)'>  Re-Mark Submission</button><br> Attachments : $full_link </span>  
</div></k>";
                
               
                
                                      }}
       echo "";
       ?>
           
           
       </div>
          
          
          
          
          
          
                 <div id="menu3" class="container tab-pane"><br>
           
       
           
           
          <?php
          
          if($Report_Type=="Group")
{
 $resulty  = mysqli_query($con,"SELECT `Submission_ID`, `Submission_Date`, lab_report_submissions.Lab_Report_ID,
      lab_report_submissions.Course_Group_id, `Attachment1`,
     `Notes`, `Attachment2`, `Attachment3`, `Attachment4`, lab_report_submissions.Marks, lab_report_submissions.Status, 
     `Title`,course_groups_table.Group_Name
FROM `lab_report_submissions`

left JOIN course_groups_table on course_groups_table.Course_Group_id=lab_report_submissions.Course_Group_id
where Lab_Report_ID=$id and lab_report_submissions.Status='Remarking'");
} 
else
{
    $resulty  = mysqli_query($con,"SELECT `Submission_ID`, `Submission_Date`, lab_report_submissions.Lab_Report_ID, 
    lab_report_submissions.Remarking_Reason,
     lab_report_submissions.Student_id sub_std, lab_report_submissions.Course_Group_id, `Attachment1`,
     `Notes`, `Attachment2`, `Attachment3`, `Attachment4`, lab_report_submissions.Marks, lab_report_submissions.Status, 
     `Title`,users_table.Full_Name,course_group_members_table.Student_ID
FROM `lab_report_submissions`
Left JOIN users_table  on users_table.Student_ID=lab_report_submissions.Student_id
left JOIN course_group_members_table on course_group_members_table.Course_Group_id=lab_report_submissions.Course_Group_id
where Lab_Report_ID=$id and lab_report_submissions.Status='Remarking'"); 
}
 
 if(mysqli_num_rows($resulty)==0)
    {
     echo "No Remarking Request for this lab";
     
    } else { while($row = mysqli_fetch_assoc($resulty)) {
			$title=$row['Title'];
                        $Marks=$row['Marks'];
                        //$ins=$row['Notes']; 
 $posted=$row['Submission_Date'];	
                         $deadline=$row['Deadline'];

                          $att1=$row['Attachment1'];
                              $att2=$row['Attachment2'];
                                   $att3=$row['Attachment3'];
                                    $att4=$row['Attachment4'];
                                     $labid=$row['Lab_Report_ID'];
                                     
                     $remarking_reason=$row['Remarking_Reason'];

                                     $submitted_std=$row['Student_id'];
                                     $submitted_group=$row['Course_Group_id'];
                                     $Submission_ID=$row['Submission_ID'];
                                     $names=$row['Full_Name'];
                                       $student_id=$row['sub_std'];
                                            $gname=$row['Group_Name '];
                                
                                      if($submitted_group==0)
                                      {
                                     $submitted_by= $names."(".$student_id.")";
                                      } else {
                                         $submitted_by="<i>(GROUP)</i> $gname" ;
                                      }
                                       
                                     $full_link="<a href='~\..\Lab_Report_Submisions\\$att1'>$att1</a>";      
                                     
                                     if($att2!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Submisions\\$att2'>$att2</a>";    
                                     }
                                      if($att3!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Submisions\\$att3'>$att3</a>";    
                                     }
                                     
                                      if($att4!=""){
                                       $full_link= $full_link."| <a href='~\..\Lab_Report_Submisions\\$att4'>$att4</a>";    
                                     }
                echo "   <k href='#'>   <div class='btn btn-default break-word' style='dislay:block; word-wrap: break-word; border: 1px solid #F0F0F0;border-left: 4px solid #03407B;'>
  $title  <br> by : <b> $submitted_by  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; [ Marked $Marks ] </b> <br> Remarking Reason : <b>$remarking_reason </b>
   <hr> <span style='font-size:8pt'>Submitted : $posted        <b>  </b> "
                        . "<button class='btn-sm btn-info' style='margin-left:50px;' onclick='mark($Submission_ID,\"$title\",$total)'>  Re-Mark Submission</button>"
                        . " &nbsp; &nbsp;&nbsp;&nbsp;<a href='~\..\Script.php?ignoreremarking=yes&id=$id&subid=$Submission_ID&header=$header&total=$total&status=Marked' class='btn-sm btn-warning'>  Ignore Request </a>"
                        . "<br> Attachments : $full_link </span>  
</div></k>";
                
               
                
                                      }}
       echo "";
       ?>
           
           
       </div>
          
          
          
          
          
          
          
                <div id="menu4" class="container tab-pane"><br>
           
      <h3>Course Groups</h3>  
       
 
    
  
        <hr>
    <?php
   
    
     $result = mysqli_query($con,"  SELECT `Course_Group_id`, `Group_Name`, `Group_Leader`, `Course_id`,users_table.Full_Name
FROM `course_groups_table`
INNER JOIN users_table on users_table.Student_ID=course_groups_table.Group_Leader
WHERE Course_id=$c_id");
 
if(mysqli_num_rows($result)==0)
    {
     echo "You have no Group in this Course";
    } else { while($row = mysqli_fetch_assoc($result)) {
			$name=$row['Group_Name'];
                        $leader=$row['Full_Name']."(".$row['Group_Leader'].")";
                      $id= $row['Course_Group_id']; 
                        
                        
                        echo "<div  class='btn-default'><small> $name -  Leader : $leader </small></div>";
                        
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
    function mark(id,title,marks) {
    
   
    try
    {
       

    $('<form id="frm" method="get" action="Script.php">'+title+'('+marks+' marks) <input type="hidden" name="savemarks" value="true">\n\
 <input type="hidden" name="total" value="'+marks+'" > <input type="hidden" name="id" value="'+id+'" ><br> Marks <input type="text" name="marks">\n\
 Comments <textarea name="feedback"></textarea>  \n\
<input type="hidden" name="labid" value="<?php echo $course_id; ?>"> <input type="hidden" name="header" value="<?php echo $header; ?>">  </form>').dialog({
  modal: true,
          title:'Mark Submission',
  buttons: {
    'Submit Marking': function () {
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


    
    
    function updatev(id) {
    
   
    try
    {
        

    $('<form id="frm" method="get" action="Script.php"> <input type="hidden" name="updatevisibility" value="true">\n\
 <input type="hidden" name="id" value="'+id+'" > <br>\n\
Update Visibility<br><select name="status"> <option> Public </option><option>Private</option> </select>  \n\
<input type="hidden" name="labid" value="<?php echo $id; ?>"> <input type="hidden" name="total" value="<?php echo $total; ?>" > <input type="hidden" name="header" value="<?php echo $header; ?>">  </form>').dialog({
  modal: true,
          title:'Update Report Visibility',
  buttons: {
    'Update': function () {
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
    
