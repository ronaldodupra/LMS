<?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
   $teacher_id = $this->session->userdata('login_user_id');?>
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
                                          <?php echo get_phrase('students');?> <small></small></a>
                                          <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="profile-section" style="background-color: #fff;">
                                    <div class="control-block-button">
                                    </div>
                                 </div>
                              </div>
                              <div class="aec-full-message-w">
                                 <div class="aec-full-message">
                                    <div class="container-fluid" style="background-color: #f2f4f8;">
                                       <br>
                                       <div class="col-sm-12">
                                          <?php echo form_open(base_url() . 'teacher/students_area/', array('class' => 'form m-b'));?>
                                          <div class="form-group label-floating" style="background-color: #fff;">
                                             <label class="control-label"><?php echo get_phrase('search_students');?></label>
                                             <input class="form-control" name="last_name"  id="filter" type="text" required="">
                                          </div>
                                          <?php echo form_close();?>
                                          <div class="os-tabs-w">
                                             <div class="os-tabs-controls">
                                                <ul class="navs navs-tabs upper">
                                                   <?php 
                                                      $active = 0;
                                                      $query = $this->db->query("SELECT t1.`class_id`,t1.`section_id`,t3.`name` as sec_name,t4.`name` as class_name FROM enroll t1
                                                              RIGHT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                                                              RIGHT JOIN section t3 ON t1.`section_id` = t3.`section_id`
                                                              RIGHT JOIN class t4 ON t1.`class_id` = t4.`class_id`
                                                              WHERE t3.`teacher_id` = '$teacher_id' GROUP BY t1.`class_id` ORDER BY t1.`class_id` ASC"); 
                                                      if ($query->num_rows() > 0):
                                                      $sections = $query->result_array();
                                                      foreach ($sections as $rows): $active++;?>
                                                   <li class="navs-item">
                                                      <a class="navs-links <?php if($active == 1) echo "active";?>" data-toggle="tab" href="#tab<?php echo $rows['section_id'];?>"> <?php echo $rows['class_name'] . ' - ' . $rows['sec_name'];?></a>
                                                   </li>
                                                   <?php endforeach;?>
                                                   <?php endif;?>
                                                </ul>
                                             </div>
                                          </div>
                                          <div class="tab-content">
                                             <?php 
                                                $active2 = 0;
                                                $query = $this->db->query("SELECT t1.`class_id`,t1.`section_id`,t3.`name` as sec_name,t4.`name` as class_name FROM enroll t1
                                                         RIGHT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                                                         RIGHT JOIN section t3 ON t1.`section_id` = t3.`section_id`
                                                         RIGHT JOIN class t4 ON t1.`class_id` = t4.`class_id`
                                                         WHERE t3.`teacher_id` = '$teacher_id' GROUP BY t1.`class_id` ORDER BY t1.`class_id` ASC");
                                                if ($query->num_rows() > 0):
                                                $sections = $query->result_array();
                                                foreach ($sections as $row):
                                                $active2++; ?>
                                             <div class="tab-pane <?php if($active2 == 1) echo "active";?>" id="tab<?php echo $row['section_id'];?>">
                                                <div class="row" id="results">
                                                   <?php 
                                                      $cl_id = $row['class_id'];
                                                      $sec_id = $row['section_id']; 
                                                      
                                                      $students = $this->db->query("SELECT t1.year,t1.student_id,t2.`last_name`,t2.`first_name`,t3.`name`,t1.`enroll_id`,t1.`class_id`,t1.`section_id` FROM enroll t1
                                                         LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                                                         LEFT JOIN section t3 ON t1.`section_id` = t3.`section_id`
                                                         WHERE t3.`teacher_id` = '$teacher_id' and t1.class_id = '$cl_id' and t1.section_id = '$sec_id' and t1.year = '$running_year' ORDER BY t2.`last_name` ASC");
                                                      
                                                      if($students->num_rows() > 0): ?>
                                                   <?php 
                                                      foreach($students->result_array() as $row2):?>  
                                                   <div class="col-xl-4 col-md-6">
                                                      <div class="card-box widget-user ui-block list">
                                                         <div class="more" style="float:right;">
                                                            <i class="icon-options"></i>    
                                                            <ul class="more-dropdown">
                                                               <li><a href="<?php echo base_url();?>teacher/view_marks/<?php echo $row2['student_id'];?>"><?php echo get_phrase('marks');?></a></li>
                                                            </ul>
                                                         </div>
                                                         <div>
                                                            <img src="<?php echo $this->crud_model->get_image_url('student',$row2['student_id']);?>" class="img-responsive rounded-circle" alt="user">
                                                            <div class="wid-u-info">
                                                               <a href="<?php echo base_url();?>teacher/view_marks/<?php echo $row['student_id'];?>/" class="h6 author-name">
                                                                  <h5 class="mt-0 m-b-5"> <?php echo $this->crud_model->get_name('student', $row2['student_id']);?></h5>
                                                               </a>
                                                               <p class="text-muted m-b-5 font-13">
                                                               <p class="text-muted m-b-5 font-13"><b><i class="picons-thin-icon-thin-0291_phone_mobile_contact"></i></b> <?php echo $this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->phone;?><br>
                                                                  <b><i class="picons-thin-icon-thin-0321_email_mail_post_at"></i></b> <?php echo $this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->email;?><br>
                                                                  <span class="badge badge-primary" style="font-size:10px;"><?php echo $this->db->get_where('class', array('class_id' => $row2['class_id']))->row()->name;?> - <?php echo $this->db->get_where('section', array('section_id' => $row2['section_id']))->row()->name;?></span>
                                                               </p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <?php endforeach;?>
                                                   <?php else:?>
                                                   <div class="col-xl-12 col-md-12 bg-white">
                                                      <center><img src="<?php echo base_url();?>uploads/empty.png"></center>
                                                   </div>
                                                   <?php endif;?>
                                                </div>
                                             </div>
                                             <?php endforeach;?>
                                             <?php endif;?>
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
<script type="text/javascript">
   window.onload=function(){      
   $("#filter").keyup(function() {
   
     var filter = $(this).val(),
       count = 0;
   
     $('#results div').each(function() {
   
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