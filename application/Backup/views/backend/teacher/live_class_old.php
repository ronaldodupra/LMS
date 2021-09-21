<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php $info = base64_decode($data);?>
<?php $ex = explode("-",$info);?>
<?php $class_info = $this->db->get('class')->result_array(); ?>
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
            <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo get_phrase('live_classroom');?></small></h3>
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
                  <a class="navs-links" href="<?php echo base_url();?>teacher/online_quiz/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0678_pen_writting_fontain"></i><span><?php echo get_phrase('online_quiz');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('homework');?></span></a>
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
                  <a class="navs-links active" href="<?php echo base_url();?>teacher/live_class/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo get_phrase('live_classroom');?></span></a>
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
                           <h6 class="element-header">
                              <?php echo get_phrase('live_classroom_list');?>
                              <div style="margin-top:auto;float:right;">
                                 <a href="#" data-target="#addmaterial" data-toggle="modal" class="text-white btn btn-control btn-grey-lighter btn-success mr-5">
                                    <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                    <div class="ripple-container"></div>
                                 </a>
                              </div>
                           </h6>
                           <div class="ui-block">
                              <div class="os-tabs-w">
                                 <ul class="navs navs-tabs upper" style="padding-left:20px; padding-top:20px">
                                    <li class="navs-item" style="display:inline;">
                                       <a class="navs-link active" style="color:#000;" data-toggle="tab" href="#all"><?php echo get_phrase('all');?></a>
                                    </li>
                                    <?php 
                                       // $query = $this->db->get_where('section' , array('class_id' => $class_id)); 
                                       $query = $this->db->query("SELECT * from exam ORDER BY exam_id ASC");
                                       
                                       if ($query->num_rows() > 0):
                                       
                                       $sections = $query->result_array();
                                       
                                       foreach ($sections as $rows):
                                       
                                       $sems = explode(" ", $rows['name']);
                                         ?>
                                    <li class="navs-item ml-3">
                                       <a class="navs-link" style="color:#000;" data-toggle="tab" href="#tab<?php echo $rows['exam_id'];?>"> <?php echo $sems[0];?></a>
                                    </li>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                 </ul>
                              </div>
                           </div>
                           <div class="tab-content">
                              <div class="tab-pane active" id="all">
                                 <div class="table-responsive" style="margin-top: -2%;">
                                    <table class="table table-padded">
                                       <thead>
                                          <tr>
                                             <th><?php echo get_phrase('title');?></th>
                                             <th><?php echo get_phrase('date');?></th>
                                             <th><?php echo get_phrase('start_time');?></th>
                                             <th><?php echo get_phrase('host');?></th>
                                             <th><?php echo get_phrase('description');?></th>
                                             <th><?php echo get_phrase('options');?></th>
                                          </tr>
                                       </thead>
                                       <tbody id="results">
                                          <?php
                                             $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                                             
                                             $subject_id = $row['subject_id'];
                                             
                                             $class_id = $row['class_id'];
                                             
                                             $live_class_info = $this->db->query("SELECT t2.`name` AS semester_name, t1.*, t3.`zoom_id`, t3.`zoom_password` FROM tbl_live_class t1 LEFT JOIN exam t2 ON t1.`semester_id` = t2.`exam_id` LEFT JOIN teacher t3 ON t1.`teacher_id` = t3.`teacher_id` WHERE subject_id = '$subject_id' AND class_id = '$class_id' AND section_id = $ex[1] ORDER BY live_id DESC");
                                             
                                             if ($live_class_info->num_rows() > 0):
                                             
                                             foreach($live_class_info->result_array() as $row):
                                                $room = sha1($row['title'].'-'.$row['timestamp']);
                                             ?>
                                          <tr>
                                             <td><?php echo $row['title']; ?></td>
                                             <td><?php echo $row['start_date']; ?></td>
                                             <td><?php echo $row['start_time']; ?></td>
                                             <td><?php if ($row['host_id'] == 1) { echo 'Zoom'; } else { echo 'Jitsi Meet'; } ?></td>
                                             <td><?php echo $row['description']; ?></td>
                                             <td class="text-center bolder">
                                                <?php if ($row['host_id'] == 2):?>
                                                   <a style="color:grey;" href="<?php echo base_url();?>teacher/live_class_video/<?php echo $row['live_id'];?>" target="_blank"><i class="picons-thin-icon-thin-0324_computer_screen"></i></a>
                                                <?php endif ?>
                                               
                                                <a style="color:grey;" onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>teacher/live_class/delete/<?php echo $row['live_id']?>/<?php echo $data;?>"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                             </td>
                                          </tr>
                                          <?php endforeach;
                                             else:?>
                                          <tr>
                                             <td colspan="7"> No data Found...</td>
                                          </tr>
                                          <?php endif;?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <?php 
                                 //$query = $this->db->get_where('section' , array('class_id' => $class_id));
                                 $query1 = $this->db->query("SELECT * from exam ORDER BY name ASC");
                                 if ($query1->num_rows() > 0):
                                 $semesters = $query1->result_array();
                                 
                                 foreach ($semesters as $row_s): 
                                 $semester_id = $row_s['exam_id'];
                                   ?>
                              <div class="tab-pane" id="tab<?php echo $row_s['exam_id'];?>">
                                 <?php //echo $row_s['exam_id'];?>
                                 <div class="table-responsive" style="margin-top: -2%;">
                                    <table class="table table-padded">
                                       <thead>
                                          <tr>
                                             <th><?php echo get_phrase('title');?></th>
                                             <th><?php echo get_phrase('date');?></th>
                                             <th><?php echo get_phrase('start_time');?></th>
                                             <th><?php echo get_phrase('host');?></th>
                                             <th><?php echo get_phrase('details');?></th>
                                             <th><?php echo get_phrase('description');?></th>
                                             <th><?php echo get_phrase('options');?></th>
                                          </tr>
                                       </thead>
                                       <tbody id="results">
                                          <?php
                                             $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                                             
                                             $subject_id = $row['subject_id'];
                                             
                                             $class_id = $row['class_id'];
                                             
                                             $study_material_info = $this->db->query("SELECT t2.`name` AS semester_name, t1.* FROM tbl_live_class t1 LEFT JOIN exam t2 ON t1.`semester_id` = t2.`exam_id`
                                              where subject_id = '$subject_id' and class_id = '$class_id' and section_id = $ex[1] and semester_id = '$semester_id' order by live_id desc ");
                                             
                                             if ($study_material_info->num_rows() > 0):
                                             
                                             foreach($study_material_info->result_array() as $row):
                                             
                                             ?>
                                          <tr>
                                             <td><?php echo $row['title']; ?></td>
                                             <td><?php echo $row['start_date']; ?></td>
                                             <td><?php echo $row['start_time']; ?></td>
                                             <td><?php if ($row['host_id'] == 1) { echo 'Zoom'; } else { echo 'Jitsi Meet'; } ?></td>
                                             <td>
                                                <?php if ($row['host_id'] == 1) { echo $row['meeting_id'].' | '.$row['password']; } else { echo $row['room_name']; } ?>
                                             </td>
                                             <td><?php echo $row['description']; ?></td>
                                             <td class="text-center bolder">
                                                <a style="color:grey;" href="<?php echo base_url();?>teacher/live_class_video/<?php echo $row['live_id'];?>" target="_blank"><i class="picons-thin-icon-thin-0324_computer_screen"></i></a>

                                                <a style="color:grey;" onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>teacher/live_class/delete/<?php echo $row['live_id']?>/<?php echo $data;?>"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                             </td>
                                          </tr>
                                          <?php endforeach;
                                             else:?>
                                          <tr>
                                             <td colspan="7"> No data Found...</td>
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
<div class="modal fade" id="addmaterial" tabindex="-1" role="dialog" aria-labelledby="addmaterial" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
      <div class="modal-content">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
         </a>
         <div class="modal-body">
            <div class="ui-block-title" style="background-color:#00579c">
               <h6 class="title" style="color:white"><?php echo get_phrase('create_live_class');?></h6>
            </div>
            <div class="ui-block-content">
               <?php echo form_open(base_url() . 'teacher/live_class/create/'.$data, array('enctype' => 'multipart/form-data')); ?>
               <div class="row">
                  <input type="hidden" value="<?php echo $ex[0];?>" name="class_id"/>
                  <input type="hidden" value="<?php echo $ex[1];?>" name="section_id"/>
                  <input type="hidden" value="<?php echo $ex[2];?>" name="subject_id"/>

                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('title');?></label>
                        <input class="form-control" name="title" type="text">
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('select_semester');?></label>
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
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('select_host');?></label>
                        <div class="select">
                           <select name="host_id" id="host_id">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="1"><?php echo get_phrase('Zoom');?></option>
                              <option value="2"><?php echo get_phrase('Jitsi Meet');?></option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('date');?></label>
                        <input type='text' class="datepicker-here" data-position="top left" data-language='en' name="live_class_date" data-multiple-dates-separator="/"/>
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('start_time');?></label>
                        <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                           <input type="text" required="" name="start_time" class="form-control" value="00:00">
                        </div>
                     </div>
                  </div>

                  <!-- <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php //echo get_phrase('meeting_id');?></label>
                        <input class="form-control" name="meet_id" type="text">
                     </div>
                  </div> -->
                 <!--  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php //echo get_phrase('password');?></label>
                        <input class="form-control" name="meet_pwd" type="text">
                     </div>
                  </div> -->

                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('description');?></label>
                        <textarea class="form-control" rows="5" name="description"></textarea>
                     </div>
                  </div>
               </div>
               <div class="form-buttons-w text-right">
                  <center><button class="btn btn-rounded btn-success btn-lg" type="submit"><?php echo get_phrase('save');?></button></center>
               </div>
               <?php echo form_close();?>        
            </div>
         </div>
      </div>
   </div>
</div>
<?php endforeach;?>