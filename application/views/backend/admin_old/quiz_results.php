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
   
   ?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/quizroom/<?php echo $online_quiz_id;?>/"><i class="os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span><?php echo get_phrase('quiz_details');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>admin/quiz_results/<?php echo $online_quiz_id;?>/"><i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i><span><?php echo get_phrase('results');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/quiz_edit/<?php echo $online_quiz_id;?>/"><i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span><?php echo get_phrase('edit');?></span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <div class="col-sm-8">
                  <div class="pipeline white lined-primary">
                     <div class="pipeline-header">
                        <h5 class="pipeline-name">
                           <?php echo get_phrase('results_for');?> <?php echo $online_quiz_details['title']; ?>
                           <!-- <span class="float-right">Failed: <?php echo $total_mark; ?></span> -->
                        </h5>
                     </div>
                     <div class="table-responsive">
                        <table class="table table-lightborder">
                           <thead>
                              <tr>
                                 <th><?php echo get_phrase('student');?></th>
                                 <th><?php echo get_phrase('points_obtained');?></th>
                                 <th><?php echo get_phrase('result');?></th>
                                 <th><?php echo get_phrase('answers');?></th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php foreach ($students_array as $row):?>
                              <tr>
                                 <td>
                                  <?php 
                                    $student_details = $this->crud_model->get_student_info_by_id($row['student_id']); echo strtoupper($student_details['last_name'].", ".$student_details['first_name']); ?>
                                   
                                 </td>
                                 <td><?php $query = $this->db->get_where('tbl_online_quiz_result', array('online_quiz_id' => $online_quiz_id, 'student_id' => $row['student_id']));
                                    if ($query->num_rows() > 0){
                                        $query_result = $query->row_array();
                                        echo $query_result['obtained_mark'] + $query_result['essay_mark'] . ' / ' .  $total_mark;
                                    }
                                    else {
                                        echo 0;
                                    }?>
                                 </td>
                                 <td><?php $query = $this->db->get_where('tbl_online_quiz_result', array('online_quiz_id' => $online_quiz_id, 'student_id' => $row['student_id']));
                                    if ($query->num_rows() > 0){
                                    
                                        $query_result = $query->row_array();
                                    
                                        if(get_phrase($query_result['result']) == 'Pass'){
                                          echo "<span class='badge badge-success'>". get_phrase('passed')."</span>";
                                        }else{
                                           echo "<span class='badge badge-danger'>". get_phrase('failed')."</span>";
                                        }
                                    
                                    }
                                    else {
                                       echo "<span class='badge badge-warning'>". get_phrase('waiting')."</span>";
                                    }
                                    ?>
                                 </td>
                                 <td><?php  if ($query->num_rows() > 0){?>
                                    <a href="<?php echo base_url();?>admin/online_quiz_result/<?php echo $online_quiz_id;?>/<?php echo $row['student_id'];?>/" class="btn btn-success btn-sm btn-rounded"><?php echo get_phrase('view_results');?>
                                    </a><?php } 
                                       else echo "<span class='badge badge-warning'>". get_phrase('waiting')."</span>";?>
                                 </td>
                              </tr>
                              <?php endforeach; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="pipeline white lined-secondary">
                     <div class="pipeline-header">
                        <h5 class="pipeline-name">
                           <?php echo get_phrase('information');?>
                        </h5>
                     </div>
                     <div class="table-responsive">
                        <table class="table table-lightbor table-lightfont">
                           <tr>
                              <th>
                                 <?php echo get_phrase('date');?>:
                              </th>
                              <td>
                                 <?php echo date('d M, Y', $online_quiz_details['quiz_date']);?>
                              </td>
                           </tr>
                           <tr>
                              <th>
                                 <?php echo get_phrase('start');?>:
                              </th>
                              <td>
                                 <?php echo date('g:i A', strtotime($online_quiz_details['time_start']));?>
                              </td>
                           </tr>
                           <tr>
                              <th>
                                 <?php echo get_phrase('end');?>: 
                              </th>
                              <td>
                                 <?php echo date('g:i A', strtotime($online_quiz_details['time_end']));?>
                              </td>
                           </tr>
                           <tr>
                              <th>
                                 <?php echo get_phrase('percentage_required');?>:
                              </th>
                              <td>
                                 <a class="btn btn-rounded btn-sm btn-primary" style="color:white"><?php echo $online_quiz_details['minimum_percentage'];?>%</a>
                              </td>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <div class="pipeline white lined-warning">
                     <div class="pipeline-header">
                        <h5 class="pipeline-name">
                           <?php echo get_phrase('students');?>
                        </h5>
                     </div>
                     <div class="users-list-w">
                        <?php 

                        foreach($students_array as $row2):?>
                        <div class="user-w">
                           <div class="user-avatar-w">
                              <div class="user-avatar">
                                 <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row2['student_id']); ?>">
                              </div>
                           </div>
                           <div class="user-name">
                              <h6 class="user-title">
                                 <?php echo strtoupper($this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->last_name.", ".$this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->first_name); ?>
                              </h6>
                              <div class="user-role">
                                 <?php echo get_phrase('roll');?>: <strong><?php echo $this->db->get_where('enroll' , array('student_id' => $row2['student_id']))->row()->roll; ?></strong>
                              </div>
                           </div>
                        </div>
                        <?php endforeach;?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>