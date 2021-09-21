<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php $info = base64_decode($data);
   $ex = explode('-', $info);
   ?>
<?php $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
   foreach($sub as $row):
   ?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="cursos cta-with-media" style="background: #<?php echo $row['color'];?>;">
         <div class="cta-content">
            <div class="user-avatar">
               <img alt="" src="<?php echo base_url();?>uploads/subject_icon/<?php echo $row['icon'];?>" style="width:60px;">
            </div>
            <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo get_phrase('online_quizzes');?></small></h3>
            <small style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"</small>
         </div>
      </div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo get_phrase('dashboard');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/online_exams/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_exams');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>teacher/online_quiz/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0678_pen_writting_fontain"></i><span><?php echo get_phrase('online_quiz');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('activity');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/video_link/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i><span><?php echo get_phrase('video_links');?></span></a>
                </li>
                <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/live_class/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo get_phrase('live_classroom');?></span></a>
                </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/upload_marks/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span>Grades</span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                  <div id="newsfeed-items-grid">
                     <div class="element-wrapper">
                        <div class="element-box-tp">
                           <h5 class="element-header">
                              <?php echo get_phrase('online_quizzes');?>
                              <div style="margin-top:auto;float:right;">
                                 <a href="#new_quiz_modal" data-toggle="modal" class="text-white btn btn-control btn-grey-lighter btn-success mr-5">
                                    <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                    <div class="ripple-container"></div>
                                 </a>
                              </div>
                           </h5>

                          <div class="os-tabs-w">
                            <div class="os-tabs-controls">
                               <ul class="navs navs-tabs upper">
                                  <?php 
                                     $active = 0;
                                     $query = $this->db->query("SELECT * from exam ORDER BY exam_id ASC"); 
                                     if ($query->num_rows() > 0):
                                     $sections = $query->result_array();
                                     foreach ($sections as $rows): $active++;
                                     $status= $rows['status']; 
                                     $sems = explode(" ", $rows['name']);
                                  ?>
                                  <li class="navs-item">
                                     <a class="navs-links <?php if($status == 1) echo "active";?>" data-toggle="tab" href="#tab<?php echo $rows['exam_id'];?>"><?php echo $sems[0];?></a>
                                  </li>
                                  <?php endforeach;?>
                                  <?php endif;?>
                               </ul>
                            </div>
                          </div> 

                          <div class="tab-content">

                              <?php 
                              //$query = $this->db->get_where('section' , array('class_id' => $class_id));
                              $query1 = $this->db->query("SELECT * from exam ORDER BY exam_id ASC");
                              if ($query1->num_rows() > 0):
                              $semesters = $query1->result_array();

                              foreach ($semesters as $row_s): 
                              $semester_id = $row_s['exam_id'];
                              $status= $row_s['status']; 
                                ?>

                              <div class="tab-pane <?php if($status == 1) echo "active";?>" id="tab<?php echo $row_s['exam_id'];?>">
                              <div class="table-responsive" style="margin-top: -2%;">
                                
                                <table class="table table-padded">
                                   <thead>
                                      <tr>
                                         <th><?php echo get_phrase('status');?></th>
                                         <th><?php echo get_phrase('title');?></th>
                                         <th><?php echo get_phrase('date');?></th>
                                         <th><?php echo get_phrase('options');?></th>
                                      </tr>
                                   </thead>
                                   <tbody id="results">
                                      <?php
                                         $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                                         $subject_id = $row['subject_id'];
                                         $class_id = $row['class_id'];
             
                                         $online_quizzes = $this->db->query("SELECT * from tbl_online_quiz 
                                          where running_year = '$year' and subject_id = '$subject_id' and class_id = '$class_id' and section_id = $ex[1] and semester_id = '$semester_id' order by online_quiz_id asc");
                                         if ($online_quizzes->num_rows() > 0):
                                         foreach($online_quizzes->result_array() as $row):
                                         ?>
                                      <tr>
                                         <td>
                                            <button class="btn btn-<?php echo $row['status'] == 'published' ? 'success' : 'warning'; ?> btn-sm"><?php if($row['status'] == "published") echo get_phrase('published'); else if($row['status'] == "pending") echo get_phrase('pending'); else echo get_phrase('expired');?></button>
                                         </td>
                                         <td><span><?php echo $row['title'];?></span></td>
                                          <td><span><?php echo '<b>'.get_phrase('date').':</b> '.date('M d, Y', $row['quiz_date']).'<br>'.'<b>'.get_phrase('hour').':</b> '.date('g:i A', strtotime($row['time_start'])).' - '.date('g:i A', strtotime($row['time_end']));?></span></td>
                                         <td class="bolder">

                                            <a href="<?php echo base_url();?>teacher/quizroom/<?php echo $row['online_quiz_id'];?>" class="btn btn-success btn-sm"> <?php echo get_phrase('details');?></a>

                                            <?php if ($row['status'] == 'pending'): ?>
                                            <a onclick="publish_data('<?php echo $row['online_quiz_id'];?>','<?php echo $data;?>')" href="#" class="btn btn-info btn-sm"><?php echo get_phrase('publish');?></a><br>

                                            <?php elseif ($row['status'] == 'published'): ?>
                                            <a onclick="mark_expired_data('<?php echo $row['online_quiz_id'];?>','<?php echo $data;?>')" href="#" class="btn btn-primary btn-sm"> <?php echo get_phrase('mark_as_expired');?></a><br>

                                            <?php elseif($row['status'] == 'expired'): ?>
                                            <a href="#" class="btn btn-warning btn-sm"> <?php echo get_phrase('expired');?></a><br>

                                            <?php endif; ?>

                                            <?php 

                                            if ($row['is_view'] == 0){ ?>

                                              <a href="#" onclick="enable_result('<?php echo $row['online_quiz_id'] ?>','<?php echo $data;?>');" class="btn btn-success  btn-sm"> <?php echo get_phrase('enable_result');?></a>

                                            <?php }else{ ?>

                                              <a href="#" onclick="disable_result('<?php echo $row['online_quiz_id'] ?>','<?php echo $data;?>');" class="btn btn-danger btn-sm"> <?php echo get_phrase('disable_result');?></a>

                                            <?php } ?>

                                            <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_copy_quiz_details/<?php echo $row['online_quiz_id'];?>')" class="btn btn-primary btn-sm"><i class="fa fa-copy" aria-hidden="true"></i> <?php echo get_phrase('copy');?></a>

                                            <a onclick="delete_quiz('<?php echo $row['online_quiz_id'];?>','<?php echo $data;?>')" class="btn btn-danger btn-sm" href="#"><?php echo get_phrase('delete');?></a>

                                         </td>
                                      </tr>

                                      <?php endforeach;

                                      else:?>
                                        <tr><td colspan="4"> No data Found...</td></tr>
                                      <?php endif;?>
                                   </tbody>
                                </table>
                             </div>

                             </div>

                            <?php endforeach;?>
                            <?php endif;?>

                          </div>

                        </div>
                     </div>
                  </div>
               </main>
            </div>
         </div>
      </div>
   </div>
</div>
<?php endforeach;?>
<div class="modal fade" id="new_quiz_modal" tabindex="-1" role="dialog" aria-labelledby="crearadmin" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document" style="width: 70%;">
      <div class="modal-content" style="margin-top:0px;">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-body">
            <div class="modal-header" style="background-color:#00579c">
               <h6 class="title" style="color:white"><?php echo get_phrase('new_quiz');?></h6>
            </div>
            <div class="ui-block-content">
               <div class="row">
                  <div class="col-md-12">
                      <?php echo form_open(base_url() . 'teacher/create_online_quiz/'.$data, array('enctype' => 'multipart/form-data')); ?>
                     <div class="row">
                        <div class="col-md-8">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('title');?></label>
			      <div class="input-group">
                                 <input type="text" class="form-control" name="quiz_title">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('date');?></label>
			      <input type='date' class="form-control"  value="<?php echo date('yy-m-d'); ?>" name="quiz_date"/>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('start_time');?></label>
                              <input type="time" required="" name="time_start" class="form-control" value="08:00">
                              <!-- <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                 <input type="text" required="" name="time_start" class="form-control" value="00:00">
                              </div> -->
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('end_time');?></label>
                              <input type="time" required="" name="time_end" class="form-control" value="08:00">
                              <!-- <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                 <input type="text" required="" name="time_end" class="form-control" value="00:00">
                              </div> -->
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('minimum_percentage');?></label>
                              <div class="input-group">
                                 <input type="number" class="form-control" min="0" max="100" placeholder="0 to 100" name="minimum_percentage">
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="row">

                       <div class="col-md-4">

                          <div class="form-group">

                             <label class="col-form-label" for=""><?php echo get_phrase('select_semester');?></label>
                               
                               <div class="select">

                                  <select name="semester_id" id="semester_id">

                                     <option value=""><?php echo get_phrase('select');?></option>
                                     <?php $cl = $this->db->get('exam')->result_array();
                                        foreach($cl as $row):
                                        ?>
                                     <option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
                                     <?php endforeach;?>

                                  </select>

                               </div>

                          </div>

                       </div>

                       <div class="col-md-8">

                         <div class="form-group">

                          <label class="col-form-label" for=""><?php echo get_phrase('description');?></label>

                          <div class="input-group">

                             <textarea class="form-control" name="instruction" rows="4"></textarea>
                             
                          </div>

                         </div>

                       </div>

                     </div>

                     <input type="hidden" value="<?php echo $ex[0];?>" name="class_id">
                     <input type="hidden" value="<?php echo $ex[1];?>" name="section_id">
                     <input type="hidden" value="<?php echo $ex[2];?>" name="subject_id">

                     <div class="form-group">
                        <div class="col-sm-12" style="text-align: center;">
                           <button type="submit" class="btn btn-success"><?php echo get_phrase('save');?></button>
                        </div>
                     </div>
                     <?php echo form_close();?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">

   function publish_data(id,data) {
   
     swal({
          title: "Are you sure ?",
          text: "You want to publish this data?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#5bc0de",
         confirmButtonText: "Yes, publish",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
   
         $('#results').html('<td colspan="4"> Publising data... </td>');
         window.location.href = '<?php echo base_url();?>teacher/manage_online_quiz_status/' + id + '/published/' + data +'/';
   
       } 
       else 
       {
   
       }
   
     });
   
   }

   function mark_expired_data(id,data) {
   
     swal({
         title: "Are you sure ?",
         text: "You want to mark the quiz expired?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#00579d",
         confirmButtonText: "Yes, mark as expired",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
   
         $('#results').html('<td colspan="4"> marking as expired data... </td>');
         window.location.href = '<?php echo base_url();?>teacher/manage_online_quiz_status/' + id + '/expired/' + data +'/';
   
       } 
       else 
       {
   
       }
   
     });
   
   }

   function delete_quiz(id,data) {
   
     swal({
          title: "Are you sure ?",
          text: "You want to delete the quiz?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#e65252",
         confirmButtonText: "Yes, delete",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
   
         $('#results').html('<td colspan="4"> Deleting data... </td>');
         window.location.href = '<?php echo base_url();?>teacher/manage_quiz/delete/' + id +'/'+ data;
  
       } 
       else 
       {
   
       }
   
     });
   
   }
   
</script>
<script type="text/javascript">
  
function enable_result(exam_id,data){

  swal({
          title: "Are you sure ?",
          text: "You want to enable to view this quiz?",
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
       window.location.href = '<?php echo base_url();?>teacher/manage_quiz/enable/' + exam_id +'/'+ data;
 
     } 
     else 
     {
 
     }
 
   });

}

function disable_result(exam_id,data){

  swal({
          title: "Are you sure ?",
          text: "You want to disable to view this quiz?",
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
       window.location.href = '<?php echo base_url();?>teacher/manage_exams/disable/' + exam_id +'/'+ data;
 
     } 
     else 
     {
 
     }
 
   });

}

</script>
