<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php
   $online_quiz_details = $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $online_quiz_id))->row_array();

   $class_id = $online_quiz_details['class_id'];
   $section_id = $online_quiz_details['section_id'];

   $students_array = $this->db->query("SELECT t1.* FROM enroll t1 
                    LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                    where t1.class_id = '$class_id' and t1.section_id = '$section_id' and t1.year = '$running_year'
                    ORDER BY t2.`last_name` ASC")->result_array();

   $subject_info = $this->crud_model->get_subject_info($online_quiz_details['subject_id']);
   
   $total_mark = $this->crud_model->get_total_mark_quiz($online_quiz_id);

   $failed = $this->db->query("SELECT * from tbl_online_quiz_result where online_quiz_id = '$online_quiz_id' and result = 'fail'")->num_rows();

   $passed = $this->db->query("SELECT * from tbl_online_quiz_result where online_quiz_id = '$online_quiz_id' and result = 'pass'")->num_rows();

   $total_students = $this->db->query("SELECT t1.* FROM enroll t1 
                    LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                    where t1.class_id = '$class_id' and t1.section_id = '$section_id' and t1.year = '$running_year'
                    ORDER BY t2.`last_name` ASC")->num_rows();

   $no_action = $total_students - $failed - $passed;
   
   ?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/quizroom/<?php echo $online_quiz_id;?>/"><i class="os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span><?php echo get_phrase('quiz_details');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>teacher/quiz_results/<?php echo $online_quiz_id;?>/"><i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i><span><?php echo get_phrase('results');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/quiz_edit/<?php echo $online_quiz_id;?>/"><i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span><?php echo get_phrase('edit');?></span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <div class="col-sm-12">
                  <div class="pipeline white lined-primary">
                     <div class="pipeline-header">
                        <h4>
                           <span class="fa fa-list-ol"></span> <?php echo get_phrase('results_for');?> <?php echo $online_quiz_details['title']; ?>
                        </h4>
                        <div class="table-responsive">
                          <table class="table table-lightborder table-striped">
                            <thead>
                              <thead>
                                <tr>
                                  <th>Start time</th>
                                  <th>End Time</th>
                                  <th>Duration</th>
                                  <th>Average Required</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><?php echo date('g:i A', strtotime($online_quiz_details['time_start']));?></td>
                                  <td><?php echo date('g:i A', strtotime($online_quiz_details['time_end']));?></td>
                                  <td> <?php $minutes = number_format($online_quiz_details['duration']/60,0); echo $minutes;?> <?php echo get_phrase('minutes');?>.</td>
                                  <td><a class="btn btn-rounded btn-sm btn-primary" style="color:white"><?php echo $online_quiz_details['minimum_percentage'];?>%</a></td>
                                </tr>
                              </tbody>
                            </thead>
                          </table>
                        </div>
                        <div class="row">
                           <div class="col-sm-8">
                              <div class="form-group">
                              <input class="form-control" id="filter" placeholder="<?php echo get_phrase('search_students');?>..." type="text" name="search_key">
                               </div>
                           </div>
                           <div class="col-sm-2">
                             <button class="btn btn-danger" disabled="" id="btn_retake"><span class="fa fa-sync"></span> Retake</button>
                           </div>
                        </div>
                     </div>
                     <div class="table-responsive">
                        <table class="table table-lightborder table-striped">
                          <thead>
                              <tr class="text-center">
                                 <th colspan="6">
                                   <h6> 
                                     Passed: <span class="badge badge-success"><?php echo $passed; ?> </span> &nbsp; &nbsp;
                                     Failed: <span class="badge badge-danger"><?php echo $failed; ?> </span> &nbsp; &nbsp;
                                     Waiting:  <span class="badge badge-warning"><?php echo $no_action; ?> </span> &nbsp; &nbsp;
                                   </h6>
                                 </th>
                              </tr>
                           </thead>
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th><?php echo get_phrase('student');?></th>
                                 <th><?php echo get_phrase('points_obtained');?></th>
                                 <th><?php echo get_phrase('result');?></th>
                                 <th><?php echo get_phrase('answers');?></th>
                                 <th><?php echo get_phrase('Date Quiz');?></th>
                              </tr>
                           </thead>
                           <tbody id="results">
                              <?php 
                              $counter=0;
                              foreach ($students_array as $row):
                                 $counter++;
                                 
                              $query = $this->db->get_where('tbl_online_quiz_result', array('online_quiz_id' => $online_quiz_id, 'student_id' => $row['student_id']));?>
                              <tr>
                                 <td>

                                  <input type="checkbox" onclick="count_check_subs();" name="id[]" class="select_subs" value="<?php echo $row['student_id'] ?>"/>

                                 </td>
                                 <td>
                                  <?php 
                                    $student_details = $this->crud_model->get_student_info_by_id($row['student_id']); 
                                    echo  strtoupper($student_details['last_name'].", ".$student_details['first_name']); ?>
                                   
                                 </td>
                                 <td><?php 

                                    if ($query->num_rows() > 0){
                                        $query_result = $query->row_array();
                                        echo $query_result['obtained_mark'] +  $query_result['essay_mark']. ' / ' .  $total_mark;
                                    }
                                    else {
                                        echo 0;
                                    }?>
                                 </td>
                                 <td>
                                    <?php 

                                    

                                    if ($query->num_rows() > 0){
                                    
                                        $query_result = $query->row_array();
                                       
                                        if($query_result['status'] == 'attended'){
                                          echo "<span class='badge badge-primary'> Taking Quiz <span class='fas fa-spinner fa-pulse'></span></span>";
                                        }else{

                                          if(get_phrase($query_result['result']) == 'Pass'){
                                             echo "<span class='badge badge-success'>". get_phrase('passed')."</span>";
                                           }else{
                                              echo "<span class='badge badge-danger'>". get_phrase('failed')."</span>";
                                           }

                                        }

                                    }
                                    else {
                                       echo "<span class='badge badge-warning'>". get_phrase('waiting')."</span>";
                                    }
                                    ?>
                                 </td>
                                 <td>
                                    <?php  
                                    if ($query->num_rows() > 0){
                                    if($query_result['status'] == 'attended'){
                                        echo "<span class='badge badge-warning'>". get_phrase('waiting')."</span>";
                                    }else{ ?>
                                        <a href="<?php echo base_url();?>teacher/online_quiz_result/<?php echo $online_quiz_id;?>/<?php echo $row['student_id'];?>/" class="btn btn-success btn-sm btn-rounded"><?php echo get_phrase('view_results');?></a>
                                    <?php }
                                    ?>

                                   <?php } 
                                       else echo "<span class='badge badge-warning'>". get_phrase('waiting')."</span>";
                                    ?>
                                 </td>
                                 <td>

                                    <?php  
                                    if ($query->num_rows() > 0){

                                      if($query_result['quiz_endtime'] <> ''){
                                        $quiz_date_end = ' - '.date('m/d/Y h:i A', $query_result['quiz_endtime']);
                                      }else{
                                        $quiz_date_end = '';
                                      }

                                    if($query_result['status'] == 'attended'){
                                        echo "<span class='badge badge-warning'>". get_phrase('waiting')."</span>";
                                    }else{ ?>
                                        <?php echo date('m/d/Y h:i:A', $query_result['quiz_started_timestamp']).$quiz_date_end; ?>
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
</div>

<!-- <script type="text/javascript">
   
   function retake_quiz(online_quiz_id,student_id,student_name) {

      swal({
          title: "Are you sure ?",
          text: "you want" +student_name+ "to take the quiz again?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#5bc0de",
         confirmButtonText: "Yes",
         closeOnConfirm: true
     },
      function(isConfirm){
    
        if (isConfirm) 
        {        
    
          $('#results').html('<td colspan="4"> Enabling data... </td>');
          window.location.href = '<?php echo base_url();?>teacher/manage_quiz/disable/' + exam_id +'/'+ data;
    
        } 
        else 
        {
    
        }
    
      });
   }

</script> -->

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
        text: "You want to retake quiz of the selected data?",
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
          // var user_type = [];
          $(':checkbox:checked').each(function(i){
              id[i] = $(this).val();
              //user_type[i] = $(this).attr("id");
          });

          if(id.length === 0) //tell you if the array is empty
          {
            swal("LMS", "Please select atleast one checkbox", "info");
          }
          else
          {

            $.ajax({
              url:'<?php echo base_url();?>teacher/retake_quiz/<?php echo $online_quiz_id; ?>',
              method:'POST',
              data:{id:id},
              cache:false,
              beforeSend:function(){
              document.getElementById('btn_retake').disabled= true;
              $('#results').html("<td colspan='5' class='text-center'><img src='<?php echo base_url();?>assets/images/preloader.gif' /><br><b> Please wait updating data...</b></td>");
              },  
              success:function(data)
              {

              if(data == ''){

                 swal("LMS", "Selected Data successfully updated.", "success");
                 window.location.href = '<?php echo base_url();?>teacher/quiz_results/<?php echo $online_quiz_id; ?>';
               
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
