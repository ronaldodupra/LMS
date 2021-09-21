<?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;?>
<div class="content-w">
   <?php include 'fancy.php';?>
   <div class="header-spacer"></div>
   <div class="conty">
      <div class="all-wrapper no-padding-content solid-bg-all">
         <div class="layout-w">
            <div class="content-w">
               <div class="content-i">
                  <div class="content-box">
                     <div class="app-email-w">
                        <div class="app-email-i">
                           <div class="ae-content-w" style="background-color: #f2f4f8;">
                              <div class="top-header top-header-favorit">
                                 <div class="top-header-thumb">
                                    <img src="<?php echo base_url();?>uploads/bglogin.jpg" style="height:180px; object-fit:cover;">
                                    <div class="top-header-author">
                                       <div class="author-thumb">
                                          <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff; padding:10px">
                                       </div>
                                       <div class="author-content">
                                          <a href="javascript:void(0);" class="h3 author-name">
                                          <?php echo get_phrase('teachers');?> 
                                          </a>
                                          <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <br><br><br>
                              <div class="aec-full-message-w">
                                 <div class="aec-full-message">
                                    <div class="container-fluid" style="background-color: #f2f4f8;">
                                       <div class="tab-content">
                                          <div class="tab-pane active">
                                             <div class="row">
                                                <?php 

                                                   $n = 1;

                                                   $class_id     = $this->db->get_where('enroll', array('student_id' => $this->session->userdata('login_user_id')))->row()->class_id;

                                                   $section_id = $this->db->get_where('enroll', array('student_id' => $this->session->userdata('login_user_id')))->row()->section_id;

                                                   
                                                   $teacher_list = $this->db->query("SELECT * FROM subject where class_id = '$class_id' and section_id = '$section_id'")->result_array();
                                                   // $teacher_list = $this->db->get_where('subject', array('class_id' => $class_id ), array('section_id' => $section_id ))->result_array();

                                                   foreach($teacher_list as $row1):

                                                   ?>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                   <div class="ui-block list">
                                                      <div class="birthday-item inline-items">
                                                         <div class="author-thumb">
                                                            <img src="<?php echo $this->crud_model->get_image_url('teacher', $row1['teacher_id']);?>" class="avatars">
                                                         </div>
                                                         <div class="birthday-author-name">

                                                            <a href="javascript:void(0);" class="h6 author-name">

                                                            <?php echo $this->crud_model->get_name('teacher', $row1['teacher_id']);?>
                                                            (<?php 

                                                             $section_name = $this->db->get_where('subject', array('subject_id' => $row1['subject_id']))->row()->name;

                                                             

                                                                echo $section_name ?>)
                                                            </a>

                                                            <div class="birthday-date"><b><i class="picons-thin-icon-thin-0291_phone_mobile_contact"></i></b> <?php  echo $this->db->get_where('teacher', array('teacher_id' => $row1['teacher_id']))->row()->phone;?></div>

                                                            <div class="birthday-date"><b><i class="picons-thin-icon-thin-0321_email_mail_post_at"></i></b> <?php  echo $this->db->get_where('teacher', array('teacher_id' => $row1['teacher_id']))->row()->email;?></div>

                                                         </div>
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
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="display-type"></div>
      </div>
   </div>
</div>