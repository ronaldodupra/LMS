<?php $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description; ?>
<?php $info = base64_decode($data); $ex = explode('-', $info);?>
<?php $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();

$date_now = date('Y-m-d');
$time_now = date('H:i');

foreach ($sub as $row):
   ?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php'; ?>
      <div class="header-spacer">
      </div>
      <div class="cursos cta-with-media" style="background: #<?php echo $row['color']; ?>;">
         <div class="cta-content">
            <div class="user-avatar">
               <img alt="" src="<?php echo base_url(); ?>uploads/subject_icon/<?php echo $row['icon']; ?>" style="width:60px;">
            </div>
            <h3 class="cta-header">
               <?php echo $row['name']; ?> - 
               <small>
               <?php echo get_phrase('online_quizzes'); ?>
               </small>
            </h3>
            <small style="font-size:0.90rem; color:#fff;">
            <?php echo $this
               ->db
               ->get_where('class', array(
               'class_id' => $ex[0]
               ))->row()->name; ?> "
            <?php echo $this
               ->db
               ->get_where('section', array(
               'section_id' => $ex[1]
               ))->row()->name; ?>"
            </small>
         </div>
      </div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url(); ?>student/subject_dashboard/<?php echo $data; ?>/">
                  <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty">
                  </i>
                  <span>
                  <?php echo get_phrase('dashboard'); ?>
                  </span>
                  </a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url(); ?>student/online_exams/<?php echo $data; ?>/">
                  <i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done">
                  </i>
                  <span>
                  <?php echo get_phrase('online_exams'); ?>
                  </span>
                  </a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url(); ?>student/online_quiz/<?php echo $data; ?>/">
                  <i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done">
                  </i>
                  <span>
                  <?php echo get_phrase('online_quiz'); ?>
                  </span>
                  </a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url(); ?>student/homework/<?php echo $data; ?>/">
                  <i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing">
                  </i>
                  <span>
                  <?php echo get_phrase('activity'); ?>
                  </span>
                  </a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url(); ?>student/forum/<?php echo $data; ?>/">
                  <i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation">
                  </i>
                  <span>
                  <?php echo get_phrase('forum'); ?>
                  </span>
                  </a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url(); ?>student/study_material/<?php echo $data; ?>/">
                  <i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit">
                  </i>
                  <span>
                  <?php echo get_phrase('study_material'); ?>
                  </span>
                  </a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url(); ?>student/video_link/<?php echo $data; ?>/">
                  <i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie">
                  </i>
                  <span>
                  <?php echo get_phrase('video_links'); ?>
                  </span>
                  </a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url(); ?>student/live_class/<?php echo $data; ?>/">
                  <i class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer">
                  </i>
                  <span>
                  <?php echo get_phrase('live_classroom'); ?>
                  </span>
                  </a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url(); ?>student/subject_marks/<?php echo $data; ?>/">
                  <i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate">
                  </i>
                  <span>
                  <?php echo get_phrase('marks'); ?>
                  </span>
                  </a>
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
                           </h5>
                           <div class="os-tabs-w">
                              <div class="os-tabs-controls">
                                 <ul class="navs navs-tabs upper">
                                    <?php
                                       $active = 0;
                                       $query = $this
                                           ->db
                                           ->query("SELECT * from exam ORDER BY exam_id ASC");
                                       if ($query->num_rows() > 0):
                                           $sections = $query->result_array();
                                           foreach ($sections as $rows):
                                               $active++;
                                               $status = $rows['status'];
                                               $sems = explode(" ", $rows['name']);
                                       ?>
                                    <li class="navs-item">
                                       <a class="navs-links <?php if ($status == 1) echo "active"; ?>" data-toggle="tab" href="#tab<?php echo $rows['exam_id']; ?>">
                                       <?php echo $sems[0]; ?>
                                       </a>
                                    </li>
                                    <?php
                                       endforeach; ?>
                                    <?php
                                       endif; ?>
                                 </ul>
                              </div>
                           </div>
                           <div class="tab-content">
                              <?php
                                 $query1 = $this->db->query("SELECT * from exam ORDER BY exam_id ASC");
                                 if ($query1->num_rows() > 0):
                                     $semesters = $query1->result_array();
                                     foreach ($semesters as $row_s):
                                         $semester_id = $row_s['exam_id'];
                                         $status = $row_s['status']; ?>
                                      <div class="tab-pane <?php if ($status == 1) echo "active"; ?>" id="tab<?php echo $row_s['exam_id']; ?>">
                                         <div class="table-responsive" style="margin-top: -1.5%;">
                                            <table class="table table-padded">
                                               <thead>
                                                  <tr>
                                                     <th style="width: 25%;">
                                                        <?php echo get_phrase('title'); ?>
                                                     </th>
                                                     <th style="width: 30%;">
                                                        <?php echo get_phrase('options'); ?>
                                                     </th>
                                                     <th style="width: 20%;">
                                                        <?php echo get_phrase('date'); ?>
                                                     </th>
                                                     <th style="width: 20%;">
                                                        <?php echo get_phrase('score'); ?>
                                                     </th>
                                                  </tr>
                                               </thead>
                                               <tbody>
                                                  <?php
                                                     $student_id = $this->session->userdata('login_user_id');
                                                     $class_id = $this->db->get_where('enroll', array('student_id' => $student_id))->row()->class_id;
                                                     $section_id = $this->db->get_where('enroll', array('student_id' => $student_id))->row()->section_id;
                                                     $list_of_quiz = $this->db->query("SELECT * from tbl_online_quiz where running_year = '$running_year' and class_id = '$class_id' and section_id = '$section_id' and subject_id = '$ex[2]' and status = 'published' and semester_id = '$semester_id' order by quizdate desc");
                                                     if ($list_of_quiz->num_rows() > 0):
                                                         foreach ($list_of_quiz->result_array() as $row):
                                                         $current_time = time();
                                                         $quiz_start_time = strtotime(date('Y-m-d', $row['quiz_date']) . ' ' . $row['time_start']);
                                                         $quiz_end_time = strtotime(date('Y-m-d', $row['quiz_date']) . ' ' . $row['time_end']);

                                                         if($date_now == $row['quizdate'] AND $time_now >= $row['time_start'] AND $time_now <= $row['time_end']){
                                                            //quiz open
                                                            $quiz_status = 1;
                                                         }else{
                                                            //quiz closed
                                                            $quiz_status = 0;
                                                         }
                                                     ?>
                                                  <tr>

                                                     <td>
                                                        <?php echo $row['title']; ?>
                                                     </td>
                                                     <td class="bolder">
                                                        <?php 
                                                           if ($this->crud_model->check_availability_for_student_quiz($row['online_quiz_id']) != "submitted"): ?>

                                                            <?php if ($quiz_status == 1): ?>
                                                            <a href="<?php echo base_url(); ?>student/quizroom/<?php echo $row['code']; ?>/" class="btn btn-success btn-rounded">
                                                            <?php echo get_phrase('take_quiz'); ?>
                                                            </a>
                                                            <?php
                                                               else: ?>
                                                            <div class="btn btn-info btn-rounded">
                                                               <?php echo get_phrase('You_can_take_the_quiz_in_the_established_time'); ?>
                                                            </div>
                                                            <?php
                                                               endif; ?>
                                                            <?php
                                                               else: ?>
                                                            <?php if ($time_now > $row['time_end']): 
                                                               $is_view = $row['is_view'];
                                                               if($is_view == 1){ ?>
                                                            <a href="<?php echo base_url();?>student/online_quiz_result/<?php echo $row['online_quiz_id'];?>/" class="btn btn-success btn-rounded"><?php echo get_phrase('view_results');?></a>
                                                            <?php }else{ ?>
                                                            <a href="javascript:void(0);" class="btn btn-warning btn-rounded"><?php echo get_phrase('waiting_results');?></a>
                                                            <?php } ?>
                                                            <?php
                                                               else: ?>
                                                            <a href="javascript:void(0);" class="btn btn-warning btn-roundend">
                                                            <?php echo get_phrase('waiting_results'); ?>
                                                            </a>
                                                            <?php
                                                               endif; ?>

                                                            <?php
                                                               endif; ?>
                                                     </td>
                                                     <td>
                                                        <?php echo '<b>' . get_phrase('date') . ':</b> ' . date('M d, Y', $row['quiz_date']) . '<br>' . '<b>' . get_phrase('hour') . ':</b> ' . date('g:i A', strtotime($row['time_start'])) . ' - ' . date('g:i A', strtotime($row['time_end'])); ?>
                                                     </td>
                                                     <td style="font-size: 20px;">
                                                        <?php
                                                           $quiz_id = $row['online_quiz_id'];
                                                           $total_mark = $this->crud_model->get_total_mark_quiz($quiz_id);
                                                           $student_id = $this->session->userdata('login_user_id');
                                                           $quiz_id = $row['online_quiz_id'];
                                                           $student_id = $this->session->userdata('login_user_id');
                                                           $status = $this->db->query("SELECT result FROM tbl_online_quiz_result where student_id = '$student_id' and online_quiz_id = '$quiz_id'")->row()->result;
                                                           
                                                               $is_view = $row['is_view'];
                                                               if ($time_now > $row['time_end']){
                                                                if($is_view == 1){
                                                           
                                                                  if ($status == 'pass' or $status == 'fail')
                                                                       {
                                                                           $query = $this->db->get_where('tbl_online_quiz_result', array('online_quiz_id' => $quiz_id,
                                                                               'student_id' => $student_id
                                                                           ));
                                                                           if ($query->num_rows() > 0)
                                                                           {
                                                                               $query_result = $query->row_array();
                                                                               echo $query_result['obtained_mark'] + $query_result['essay_mark'] . ' / ' . $total_mark;
                                                                           }
                                                                           else
                                                                           {
                                                                               echo 0;
                                                                           }
                                                                       }
                                                                       else
                                                                       {
                                                                           echo "---";
                                                                       }
                                                           
                                                                }else{
                                                                  echo "---";
                                                                }
                                                              }else{
                                                                echo "---";
                                                              }
                                                          
                                                           ?>
                                                     </td>
                                                  </tr>
                                                  <?php
                                                     endforeach;
                                                     else: ?>
                                                  <tr>
                                                     <td colspan="5" class="text-center"> No data Found...
                                                     </td>
                                                  </tr>
                                                  <?php
                                                     endif; ?>
                                               </tbody>
                                            </table>
                                         </div>
                                      </div>
                              <?php
                                 endforeach; ?>
                              <?php
                                 endif; ?>
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
<?php
   endforeach; ?>