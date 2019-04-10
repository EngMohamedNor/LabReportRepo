
<?php
$page='Submit LAB+';
include 'Header.php';
?>


<div class='row' style='width:80%;margin:auto;'> 
 <?php 
       
         
                     echo    "  <div class='alert' style='margin-left:20px;border-bottom:2px solid #1D91EF;'> <a href='~\..\Courses.php?course=$url'>
  LRRS > Visitor Portal  > Public Lab Reports
   <br> <span style='font-size:8pt'> </span>
</a></div>
 ";
         
 $result = mysqli_query($con,"SELECT `Submission_ID`, `Submission_Date`, lab_report_submissions.Student_id,
     `Attachment1`, `Notes`, `Attachment2`, `Attachment3`, `Attachment4`, `Marks`, `Title`, `Visibility` ,
     users_table.Full_Name,course_groups_table.Group_Name
FROM `lab_report_submissions`
left join users_table on users_table.Student_ID=lab_report_submissions.Student_id
left JOIN course_groups_table on course_groups_table.Course_Group_id=lab_report_submissions.Course_Group_id
WHERE Visibility='Public' ");
 if(mysqli_num_rows($result)==0)
    {} else { while($row = mysqli_fetch_assoc($result)) {
			 $att1=$row['Attachment1'];
                              $att2=$row['Attachment2'];
                              
                              $sdate=$row['Submission_Date'];
                                   $att3=$row['Attachment3'];
                                    $att4=$row['Attachment4'];
                                     $labid=$row['Lab_Report_ID'];
                                     $title=$row['Title'];
                                     
                                     $submitted_std=$row['Student_id'];
                                     $submitted_group=$row['Course_Group_id'];
                                     $Submission_ID=$row['Submission_ID'];
                                     $sname=$row['Full_Name'];
                                       $gname=$row['Group_Name'];
                                          $Visibility=$row['Visibility'];
                                          
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
                                
                                
                echo"  
               
                        <div class='btn btn-default'> 
  $title  <small>by $gname $sname </small>
   <br> <span style='font-size:8pt'>Submission Date :$sdate  &nbsp;&nbsp; &nbsp;  Files : $full_link </span>
</div>
                        ";
   
              }}?>
  </div>

