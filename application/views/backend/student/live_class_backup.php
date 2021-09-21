<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php $info = base64_decode($data); $ex = explode('-', $info); ?>
<?php $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
foreach($sub as $rows):
?>
<div class="content-w">
  <div class="conty">
  <?php $info = base64_decode($data);?>
  <?php $ids = explode("-",$info);?>
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
    <div class="cursos cta-with-media" style="background: #<?php echo $rows['color'];?>;">
      <div class="cta-content">
        <div class="user-avatar">
          <img alt="" src="<?php echo base_url();?>uploads/subject_icon/<?php echo $rows['icon'];?>" style="width:60px;">
        </div>
        <h3 class="cta-header"><?php echo $rows['name'];?> - <small><?php echo get_phrase('live_classroom');?></small></h3>
        <small style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"</small>
      </div>
    </div>   
    <div class="os-tabs-w menu-shad">
      <div class="os-tabs-controls">
        <ul class="navs navs-tabs upper">
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/subject_dashboard/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo get_phrase('dashboard');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/online_exams/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_exams');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/online_quiz/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_quiz');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('homework');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/video_link/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i><span><?php echo get_phrase('video_links');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links active" href="<?php echo base_url();?>student/live_class/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo get_phrase('live_classroom');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/subject_marks/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('marks');?></span></a>
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
                    </h6>
                  <div class="table-responsive">
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

                      <tbody>
                      <?php
                        $student_id = $this->session->userdata('login_user_id');
                        $fname = $this->db->get_where('student', array('student_id' => $student_id))->row()->first_name;
                        $lname = $this->db->get_where('student', array('student_id' => $student_id))->row()->last_name;

                        $sname = $fname . ' ' . $lname;
                      ?>
                      <?php
        		            $this->db->order_by('timestamp', 'desc');
        		            $live_class_info = $this->db->get_where('tbl_live_class', array('class_id' => $ids[0], 'section_id' => $ids[1], 'subject_id' => $ids[2]))->result_array();

        		            foreach ($live_class_info as $row):
                          $live_id = $row['live_id'];
                          $teacher_id = $row['teacher_id'];
                          $room_name = sha1($row['title'].'-'.$row['timestamp']);
        	            ?>   
                        <tr>
                          <td><?php echo $row['title']; ?></td>
                          <td><?php echo $row['start_date']; ?></td>
                          <td><?php echo $row['start_time']; ?></td>
                          <td><?php if ($row['host_id'] == 1) { echo 'Zoom'; } else { echo 'Jitsi Meet'; } ?></td>
                          <td><?php echo $row['description']; ?></td>              
                          <td class="text-center bolder"> 

                            <?php if($row['host_id'] == 1): 
                              $meeting_id=$this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->zoom_id; 
                              $zoom_pass=$this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->zoom_password;

                              $string_to_encrypt=$zoom_pass;
                              $pass="password";
                              $zoom_password=openssl_decrypt($string_to_encrypt,"AES-128-ECB",$pass);
                            ?>
                      
                              <a style="color:grey;" title="For Laptop User" href="<?php echo base_url();?>CDN/index.php?data=<?php echo $meeting_id.'-'.$zoom_password.'-'.$sname;?>" target="_blank"><i class="picons-thin-icon-thin-0324_computer_screen">
                              </i></a>

                                <a style="color:grey;" title="For Mobile/Tablet users" href="https://us04web.zoom.us/j/<?php echo $meeting_id;?>?pwd=<?php echo $zoom_password?>" target="_blank"><i class="picons-thin-icon-thin-0191_window_application_cursor"></i></a>

                            <?php else: 

                            ?>

                              <a style="color:grey;" title="For Laptop User" href="<?php echo base_url();?>jitsi_meet/client.php?data=<?php echo $room_name.'-'.$sname;?>" target="_blank"><i class="picons-thin-icon-thin-0324_computer_screen" ></i>
                              </a>

                              <a title="For Mobile/Tablet users" style="color:grey;" href="https://meet.jit.si/<?php echo $room_name?>" target="_blank"><i class="picons-thin-icon-thin-0191_window_application_cursor"></i>
                              </a>

                            <?php endif; ?>

                            <!--  <a style="color:grey;" href="<?php //echo base_url();?>student/live_class_video/<?php //echo $row['live_id'];?>/<?php //echo $row['teacher_id'];?>" target="_blank"><i class="picons-thin-icon-thin-0324_computer_screen"></i>
                            </a> -->

                            <!-- <a style="color:grey;" href="<?php //echo base_url();?>student/live_class_video/<?php //echo $row['live_id'];?>" target="_blank"><i class="picons-thin-icon-thin-0324_computer_screen"></i>
                            </a> -->

                            <!-- <a style="color:grey;" href="<?php //echo base_url();?>CDN/index.php?mid=<?php //echo $row['meeting_id']?>&pwd=<?php //echo $row['password']?>" target="_blank"><i class="picons-thin-icon-thin-0324_computer_screen"></i></a> -->

                            <!-- <a onclick="showAjaxModal('<?php //echo base_url();?>modal/popup/modal_live_class/<?php //echo $row['live_id'];?>');" href="javascript:void(0);" style="color:gray;"><i class="picons-thin-icon-thin-0324_computer_screen"></i></a> -->

                            <!-- <a style="color:grey;" href="<?php //echo base_url();?>CDN/index.php?mid=<?php //echo $row['meeting_id']?>&pwd=<?php //echo $row['password']?>&sname=<?php //echo $fname.' '.$lname; ?>" target="_blank"><i class="picons-thin-icon-thin-0324_computer_screen"></i></a> -->
                          </td>
                        </tr>
                      <?php endforeach;?> 
                      </tbody>
                    </table>
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