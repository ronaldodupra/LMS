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
            <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo get_phrase('online_exams');?></small></h3>
            <small style="font-size:0.90rem; color:#fff;"><?php echo $this->crud_model->get_name('student', $ex[3]);?> | <?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"</small>
         </div>
      </div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>parents/subject_dashboard/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo get_phrase('dashboard');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>parents/online_exams/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_exams');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>parents/online_quiz/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_quiz');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>parents/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('activity');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>parents/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>parents/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>parents/video_link/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i><span><?php echo get_phrase('video_links');?></span></a>
                </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>parents/subject_marks/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('marks');?></span></a>
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
                           <h5 class="element-header"><?php echo get_phrase('online_exams');?></h5>
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
                                 $query1 = $this->db->query("SELECT * from exam ORDER BY exam_id ASC");
                                 if ($query1->num_rows() > 0):
                                 $semesters = $query1->result_array();
                                 
                                 foreach ($semesters as $row_s): 
                                 $semester_id = $row_s['exam_id'];
                                 $status= $row_s['status'];?>
                              <div class="tab-pane <?php if($status == 1) echo "active";?>" id="tab<?php echo $row_s['exam_id'];?>">
                                 <div class="table-responsive" style="margin-top: -1.5%;">
                                    <table class="table table-padded">
                                       <thead>
                                          <tr>
                                             <th><?php echo get_phrase('title');?></th>
                                             <th><?php echo get_phrase('date');?></th>
                                             <th><?php echo get_phrase('options');?></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                             $list_of_exam = $this->db->query("SELECT * from online_exam where running_year = '$running_year' and class_id = '$ex[0]' and section_id = '$ex[1]' and subject_id = '$ex[2]' and status = 'published' and semester_id = '$semester_id' order by online_exam_id desc");
                                             
                                             if($list_of_exam->num_rows() > 0):
                                             
                                             foreach ($list_of_exam->result_array() as $row):
                                             
                                             $current_time = time();
                                             
                                             $exam_start_time = strtotime(date('Y-m-d', $row['exam_date']).' '.$row['time_start']);
                                             
                                             $exam_end_time = strtotime(date('Y-m-d', $row['exam_date']).' '.$row['time_end']);
                                             
                                             ?>
                                          <tr>
                                             <td><?php echo $row['title'];?></td>
                                             <td><?php echo '<b>'.get_phrase('date').':</b> '.date('M d, Y', $row['exam_date']).'<br>'.'<b>'.get_phrase('hour').':</b> '.date('g:i A', strtotime($row['time_start'])).' - '.$row['time_end'];?></td>
                                             <td class="bolder">
                                                <?php if ($this->crud_model->parent_check_availability_for_student($row['online_exam_id'], $ex[3]) != "submitted"): ?>
                                                <span class="btn btn-info btn-rounded"><?php echo get_phrase('waiting_information');?></span>
                                                <?php else: ?>
                                                <?php if($current_time > $exam_end_time): 
                                                   $is_view = $row['is_view'];
                                                   
                                                   if($is_view == 1){ ?>
                                                <a href="<?php echo base_url();?>parents/online_exam_result/<?php echo $row['online_exam_id'];?>/<?php echo $ex[3];?>/" class="btn btn-primary btn-rounded"><?php echo get_phrase('view_results');?></a>
                                                <?php }else{ ?>
                                                <a href="javascript:void(0);" class="btn btn-warning btn-rounded"><?php echo get_phrase('waiting_results');?></a>
                                                <?php } ?>
                                                <?php else: ?>
                                                <a href="javascript:void(0);" class="btn btn-warning btn-roundend"><?php echo get_phrase('waiting_results');?>.</a>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                             </td>
                                          </tr>
                                          <?php endforeach;
                                             else:?>
                                          <tr>
                                             <td colspan="5" class="text-center"> No data Found...</td>
                                          </tr>
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