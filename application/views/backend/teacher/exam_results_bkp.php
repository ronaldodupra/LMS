<?php
  $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
  $online_exam_details = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();
  $class_id = $online_exam_details['class_id'];
  $section_id = $online_exam_details['section_id'];
  $subject_id = $online_exam_details['subject_id'];
  $exam_id = $online_exam_details['semester_id'];
  $department_id = $this->crud_model->get_department($subject_id);

  if($department_id == 4)
  {

    if ($exam_id == 5) {

      $students_array = $this->db->query("SELECT t2.`student_id`, t1.`class_id`, t1.`section_id`, t2.`last_name`, t4.`Id` FROM enroll t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN subject t3 ON t1.`class_id` = t3.`class_id` AND t1.`section_id` = t3.`section_id` LEFT JOIN tbl_stud_subject_exclusion t4 ON t1.`student_id` = t4.`student_id` AND t4.`subject_id` = t3.`subject_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t3.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' AND ISNULL(t4.`Id`) UNION SELECT t1.`student_id`, t3.`class_id`, t3.`section_id`, t2.`last_name`, t1.`Id` FROM tbl_students_subject t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN enroll t3 ON t2.`student_id` = t3.`student_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t1.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' ORDER BY last_name ASC");

    }
    else
    {

      $students_array = $this->db->query("SELECT t1.`student_id`, t3.`class_id`, t3.`section_id`, t2.`last_name`, t1.`Id` FROM tbl_students_subject t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN enroll t3 ON t2.`student_id` = t3.`student_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t1.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' ORDER BY last_name ASC");

    }
    
  }
  else
  {
    $students_array = $this->db->query("SELECT t2.`student_id`, t1.`class_id`, t1.`section_id`, t2.`last_name`, t4.`Id` FROM enroll t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN subject t3 ON t1.`class_id` = t3.`class_id` AND t1.`section_id` = t3.`section_id` LEFT JOIN tbl_stud_subject_exclusion t4 ON t1.`student_id` = t4.`student_id` AND t4.`subject_id` = t3.`subject_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t3.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' AND ISNULL(t4.`Id`) UNION SELECT t1.`student_id`, t3.`class_id`, t3.`section_id`, t2.`last_name`, t1.`Id` FROM tbl_students_subject t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN enroll t3 ON t2.`student_id` = t3.`student_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t1.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' ORDER BY last_name ASC");
  }
   
  $subject_info = $this->crud_model->get_subject_info($online_exam_details['subject_id']);
  $total_mark = $this->crud_model->get_total_mark($online_exam_id);

  $failed = $this->db->query("SELECT * from online_exam_result where online_exam_id = '$online_exam_id' and result = 'fail'")->num_rows();
   
  $passed = $this->db->query("SELECT * from online_exam_result where online_exam_id = '$online_exam_id' and result = 'pass'")->num_rows();

  $attended = $this->db->query("SELECT * from online_exam_result where online_exam_id = '$online_exam_id' and status = 'attended'")->num_rows();

  $no_action = $students_array->num_rows() - $failed - $passed - $attended_total;

  $total_questions = $this->db->get_where('question_bank', array('online_exam_id' => $online_exam_id))->num_rows();
  $added_question_info = $this->db->get_where('question_bank', array('online_exam_id' => $online_exam_id))->result_array();

?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/examroom/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span><?php echo get_phrase('exam_details');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/manage_examiner/<?php echo $online_exam_id;?>/"><i class="fa fa-users fa-2x"></i><span><?php echo get_phrase('Manage_allowed_examiners');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>teacher/exam_results/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i><span><?php echo get_phrase('results');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/exam_edit/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span><?php echo get_phrase('edit');?></span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <div class="col-md-12">
                  <div class="pipeline white lined-primary">
                     <div class="panel-heading">
                        <h5 class="panel-title"><?php echo get_phrase('exam_details');?> (<?php echo $online_exam_details['title']; ?>)
                           <a href="<?php echo base_url();?>teacher/online_exams/<?php echo base64_encode($online_exam_details['class_id']."-".$online_exam_details['section_id']."-".$online_exam_details['subject_id']);?>/" class="btn btn-sm btn-primary float-right"> <span class="fa fa-arrow-left"></span> Back</a>
                        </h5>
                     </div>
                     <div class="panel-body">
                        <div style="overflow-x:auto;">
                           <table  class="table table-bordered">
                              <tbody>
                                 <tr>
                                    <td>
                                       <?php if($online_exam_details['exam_type'] == 'open'){ ?>

                                          <b><?php echo get_phrase('date');?></b>: 
                                          <?php $start_date = date('Y-m-d',strtotime($online_exam_details['examdate']));
                                             echo $start_date;
                                             ?>
                                          <br>
                                          <b><?php echo get_phrase('Time');?></b>:
                                          <?php echo date('g:i A', strtotime($online_exam_details['time_start'])).' - '.date('g:i A', strtotime($online_exam_details['time_end'])); ?>

                                       <?php }elseif($online_exam_details['exam_type'] == 'flexi'){ ?>

                                          <b>Date</b>: <?php $start_date = date('Y-m-d',strtotime($online_exam_details['start_date']));
                                             $end_date = date('Y-m-d',strtotime($online_exam_details['end_date']));
                                             $start_time = date('h:i A',strtotime($online_exam_details['start_date']));
                                             $end_time = date('h:i A',strtotime($online_exam_details['end_date']));
                                             ?>
                                          <?php echo $start_date; ?> to <?php echo $end_date; ?>
                                          <br>
                                          <b>Time</b>: <?php echo $start_time.' - ' . $end_time; ?>

                                       <?php } ?>
                                          <br>
                                          <b>Exam Type</b>: <?php echo strtoupper($online_exam_details['exam_type']); ?>
                                    </td>
                                    <td>
                                       <b><?php echo get_phrase('teacher');?></b>: <br>
                                       <span class="btn btn-success btn-sm">
                                       <?php  echo $this->crud_model->get_name('teacher', $online_exam_details['uploader_id']); ?>
                                       </span>
                                    </td>
                                    <td><b><?php echo get_phrase('class & section');?></b>: <br><span class="btn btn-purple btn-sm"><?php echo $this->db->get_where('class', array('class_id' => $online_exam_details['class_id']))->row()->name; ?> - <?php echo $this->db->get_where('section', array('section_id' => $online_exam_details['section_id']))->row()->name; ?></span>
                                    </td>
                                    <td><b><?php echo get_phrase('subject');?></b>: <br>
                                       <span class="btn btn-primary btn-sm">
                                       <?php echo $this->db->get_where('subject', array('subject_id' => $online_exam_details['subject_id']))->row()->name; ?></span>
                                    </td>
                                    <td><b><?php echo get_phrase('percentage_required');?></b>: <br><?php echo $online_exam_details['minimum_percentage'].'%'; ?></td>
                                    <td>
                                       <b><?php echo get_phrase('total_questions');?></b> : <?php echo $total_questions; ?>
                                       <br>
                                       <b><?php echo get_phrase('total_points');?></b> :
                                       <?php 
                                          $total_mark = $this->crud_model->get_total_mark($online_exam_id);
                                          echo $total_mark; ?>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="pipeline white lined-primary">
                     <div class="pipeline-header">
                        <h4>
                           <span class="fa fa-list-ol"></span> <?php echo get_phrase('results_for');?> <?php echo $online_exam_details['title']; ?>
                           <a class="btn btn-primary float-right" target="_blank" href="<?php echo base_url();?>teacher/online_exam_print_view/<?php echo $online_exam_id;?>/"><span class="fa fa-print"></span> Preview</a>
                        </h4>
                     </div>
                     <div class="row">
                        <div class="col-sm-8">
                           <div class="form-group">
                              <input class="form-control" style="height: 40px;" id="filter" placeholder="<?php echo get_phrase('search_students');?>..." type="text" name="search_key">
                           </div>
                        </div>
                        <div class="col-sm-2">
                           <button class="btn btn-danger" disabled="" id="btn_retake"><span class="fa fa-sync"></span> Retake</button>
                        </div>
                     </div>
                     <div class="table-responsive">
                        <table class="table table-lightborder table-striped table-hover">
                           <thead>
                              <tr class="text-center">
                                 <th colspan="7">
                                    <h6> 
                                       Passed: <span class="badge badge-success"><?php echo $passed; ?> </span> &nbsp; &nbsp;
                                       Failed: <span class="badge badge-danger"><?php echo $failed; ?> </span> &nbsp; &nbsp;
                                       Taking Exam: <span class="badge badge-primary"><?php echo $attended; ?> </span> &nbsp; &nbsp;
                                       Waiting:  <span class="badge badge-warning"><?php echo $no_action; ?> </span> &nbsp; &nbsp;
                                    </h6>
                                 </th>
                              </tr>
                           </thead>
                           <thead class="table-dark">
                              <tr>
                                 <th># &nbsp;&nbsp;</th>
                                 <th><?php echo get_phrase('student');?></th>
                                 <th><?php echo get_phrase('points');?></th>
                                 <th class="text-center"><?php echo get_phrase('retake');?></th>
                                 <th><?php echo get_phrase('result');?></th>
                                 <th><?php echo get_phrase('answers');?></th>
                                 <th><?php echo get_phrase('date_taken');?></th>
                              </tr>
                           </thead>
                           <tbody id="results">
                              <?php $counter = 0;  foreach ($students_array ->result_array()as $row): $counter++;
                              $student_id = $row['student_id'];?>
                              <tr>
                                 <?php   
                                    $query = $this->db->get_where('online_exam_result', array('online_exam_id' => $online_exam_id, 'student_id' => $row['student_id']));
                                    
                                    ?>
                                 <td>
                                    <input type="checkbox" onclick="count_check_subs();" name="id[]" class="select_subs" value="<?php echo $row['student_id'] ?>"/>
                                 </td>
                                 <td>
                                    <?php 
                                       $student_details = $this->crud_model->get_student_info_by_id($row['student_id']); 
                                       echo $counter.'.) &nbsp;'.$student_details['last_name'].", ".$student_details['first_name']; ?>
                                 </td>
                                 <td>
                                    <?php 
                                      if($this->crud_model->obtained_points_exam($online_exam_id,$student_id) <> ''){
                                         echo $this->crud_model->obtained_points_exam($online_exam_id,$student_id).' / '.$total_mark;
                                      }else{ echo "---"; }
                                    ?>
                                 </td>
                                 <td class="text-center">
                                   <?php 

                                    $retakes = $this->db->query("SELECT * from tbl_exam_quiz_retake_info where student_id = '$student_id' and online_exam_quiz_id = '$online_exam_id' and type = 'exam'")->num_rows();

                                    if($retakes > 0){ ?>

                                       <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_student_retake_info/<?php echo $student_id ?>/<?php echo $online_exam_id ?>/exam')">
                      
                                          <span class="btn btn-sm btn-danger"><?php echo $retakes ?></span>

                                        </a>

                                    <?php }else{ ?>
                                      <span class="btn"><?php echo $retakes ?></span>
                                    <?php } ?>
                                 </td>
                                 <td>
                                    <?php 
                                       if ($query->num_rows() > 0){
                                       
                                           $query_result = $query->row_array();
                                          
                                           if($query_result['status'] == 'attended'){

                                             $date_now = date('Y-m-d');
                                             $time_now = date('H:i:s');
                                              
                                             $answer_script = $online_exam_details['answer_script'];

                                              if($query_result['answer_script'] <> ''){

                                                $status_data = "<span class='badge badge-success mt-1'> With Data</span>";

                                              }else{
                                                $status_data = "<span class='badge badge-danger mt-1'> No Data</span>";
                                              }
                                              
                                             if($date_now = $online_exam_details['examdate'] && $time_now >= $online_exam_details['time_start'] && $time_now <= $online_exam_details['time_end']){
                                       
                                               echo "<span class='badge badge-primary'> Taking Exam <span class='fas fa-spinner fa-pulse'></span></span>";
                                       
                                             }else{
                                       
                                               echo "<span class='badge badge-danger'> Taken but not submitted...<br> ".$status_data." </span>";
                                       
                                             }
                                             
                                           }else{
                                            
                                             if($query_result['result'] == "pass"){
                                                echo "<span class='badge badge-success'>". get_phrase('passed')."</span>";
                                              }else{
                                                 echo "<span class='badge badge-danger'>". get_phrase('failed')."</span>";
                                              }
                                       
                                           }
                                       
                                       }
                                       else {
                                          echo "<span class='badge badge-warning'>". get_phrase('not yet taken the exam')."</span>";
                                       }
                                       ?>
                                 </td>
                                 <td>
                                    <?php  
                                       if ($query->num_rows() > 0){
                                       
                                       if($query_result['status'] == 'attended'){
                                           echo "<span class='badge badge-warning'>". get_phrase('waiting')."</span>";
                                       }else{ ?>
                                    <a href="<?php echo base_url();?>teacher/online_exam_result/<?php echo $online_exam_id;?>/<?php echo $row['student_id'];?>/" class="btn btn-success btn-sm btn-rounded"><?php echo get_phrase('view_results');?></a>
                                    <?php }
                                       ?>
                                    <?php } 
                                       else echo "<span class='badge badge-warning'>". get_phrase('waiting')."</span>";
                                       ?>
                                 </td>
                                 <td>
                                    <?php  
                                       if ($query->num_rows() > 0){
                                       
                                         if($query_result['exam_endtime'] <> ''){
                                           $exam_date_end = ' <br> '.date('m/d/Y h:i A', $query_result['exam_endtime']);
                                         }else{
                                           $exam_date_end = '';
                                         }
                                       
                                       if($query_result['status'] == 'attended'){
                                           echo date('m/d/Y h:i A', $query_result['exam_started_timestamp']);
                                       }else{ ?>
                                    <?php echo date('m/d/Y h:i:A', $query_result['exam_started_timestamp']).$exam_date_end; ?>
                                    <?php }
                                       ?>
                                    <?php } 
                                       else echo "<span class='badge badge-warning'>". get_phrase('---')."</span>";
                                       ?>
                                 </td>
                              </tr>
                              <?php endforeach; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <a class="back-to-top" href="javascript:void(0);">
   <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
   </a>
</div>
<script type="text/javascript">
   function count_check_subs(){
     var chks = $('.select_subs').filter(':checked').length
   
     if(chks > 0){
       document.getElementById('btn_retake').disabled= false;
     }else{
       document.getElementById('btn_retake').disabled= true;
     }
   }
   
    $(document).ready(function(){
   
     $('#btn_retake').click(function(){
   
       swal({
         title: "Are you sure?",
         text: "You want to retake exam of the selected data?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#e65252",
         confirmButtonText: "Yes",
         closeOnConfirm: true
       },
       function(isConfirm){
   
         if(isConfirm) 
         {  
   
           var id = [];
           var user_type = [];
           
           $(':checkbox:checked').each(function(i){
               id[i] = $(this).val();
           });
   
           if(id.length === 0) //tell you if the array is empty
           {
             swal("LMS", "Please select atleast one checkbox", "info");
           }
           else
           {
   
             $.ajax({
               url:'<?php echo base_url();?>teacher/retake_examiner/<?php echo $online_exam_id; ?>',
               method:'POST',
               data:{id:id},
               cache:false, 
               success:function(data)
               {
   
               if(data == ''){
   
                  swal("LMS", "Selected Data successfully updated.", "success");
                  window.location.href = '<?php echo base_url();?>teacher/exam_results/<?php echo $online_exam_id; ?>';
               
               }else{
                 swal("LMS", "Error on updating data", "info");
   
               }
   
               }
   
             });
           }
   
         }else{
   
         }
   
       });
   
     });
   
   });
   
    window.onload=function(){      
    $("#filter").keyup(function() {
    
      var filter = $(this).val(),
        count = 0;
    
      $('#results tr').each(function() {
    
        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
          $(this).hide();
    
        } else {
          $(this).show();
          count++;
        }
      });
    });
    }
</script>