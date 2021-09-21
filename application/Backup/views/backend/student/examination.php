<?php 
   $student_id = $this->session->userdata('login_user_id'); 
   $date_now = date('Y-m-d');
   $time_now = date('H:i');
   ?>
<main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
   <div id="newsfeed-items-grid">
      <div class="ui-block paddingtel">

         <div class="user-profile">
          <div class="up-controls">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="value-pair">
                          <div><?php echo $this->crud_model->get_name('student', $student_id);?></div>
                          <div class="value badge badge-pill badge-primary">
                            <?php echo get_phrase('name');?>
                          </div>
                      </div>
                      <div class="value-pair float-right">
                        <div>
                          <a class="btn btn-sm btn-success" href="<?php echo base_url();?>student/panel/"> Home </a>
                        </div>
                          <div class="value">
                            <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>login/logout/student"> Logout </a>
                          </div>
                         
                      </div>
                 
                  </div>
              </div>
            </div>
            <div class="ui-block">
               <div class="ui-block-title">
                  <h4 class="title"><?php echo get_phrase('Examination For Today');?>&nbsp;
                     <span class="badge badge-primary"> <span class="fa fa-calendar"></span> <?php echo $date_now; ?></span>
                  </h4>
                  <!-- <a class="btn btn-sm btn-danger float-right" href="<?php echo base_url();?>login/logout/student"> Logout </a> -->
               </div>
               <div class="ui-block-content">
                  <div class="row">
                     <?php 
                        $exam_list = $this->db->query("SELECT t2.`student_id`,t1.* FROM online_exam t1 LEFT JOIN enroll t2 ON t1.`section_id` = t2.`section_id`WHERE t1.`examdate` = '$date_now' AND t2.`student_id` = '$student_id' and t1.status = 'published' order by time_start asc");
                        
                        //echo $exam_list->num_rows();
                        
                        if($exam_list->num_rows() > 0){ 
                        
                            foreach($exam_list->result_array() as $row): 
                        
                            $subject_id = $row['subject_id'];
                            $section_id = $row['section_id'];
                        
                            $subject = $this->db->query("SELECT name from subject where subject_id = '$subject_id'")->row()->name;
                        
                            $subject_color = $this->db->query("SELECT color from subject where subject_id = '$subject_id'")->row()->color;
                        
                            $icon = $this->db->query("SELECT color from subject where subject_id = '$subject_id'")->row()->icon;
                        
                            $section = $this->db->query("SELECT name from section where section_id = '$section_id'")->row()->name;
                        ?>
                     <div class="col col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="ui-block" data-mh="friend-groups-item">
                           <div class="friend-item friend-groups">
                              <div class="friend-item-content">
                                 <div class="friend-avatar">
                                    <?php 
                                       if($icon <> ""){
                                         $image = base_url()."uploads/subject_icon/". $icon;
                                       }else{
                                         $image = base_url()."uploads/subject_icon/default_subject.png";
                                       }
                                       
                                       ?>
                                    <div class="author-thumb">
                                       <a href="javascript:void(0);">
                                       <img src="<?php echo $image;?>" width="120px" style="background-color:#<?php echo $subject_color;?>;padding:30px;border-radius:0px;">
                                       </a>
                                    </div>
                                    <?php 
                                       if($date_now == $row['examdate'] AND $time_now >= $row['time_start'] AND $time_now <= $row['time_end']){
                                          //quiz open
                                          $exam_status = 1;
                                       }else{
                                          //quiz closed
                                          $exam_status = 0;
                                       }
                                       
                                       ?>
                                    <div class="author-content">
                                       <p>
                                          <a href="#" class="h5 author-name"> 
                                          <?php echo $section . ' - '. $subject;?>
                                          <br>
                                          <strong class="h4" style="text-decoration: underline;"> <?php echo $row['title'] ?> </strong>
                                          </a>
                                       </p>
                                       <p>
                                          <span class="h6 text-white badge badge-danger"><span class="fa fa-user"></span> <?php echo $this->crud_model->get_name('teacher', $row['uploader_id']);?></span>
                                          <span class="h6 text-white badge badge-danger"><span class="fa fa-clock"></span>  <?php echo date('g:i A', strtotime($row['time_start'])) . ' - ' . date('g:i A', strtotime($row['time_end']));?></span>
                                       </p>
                                       <?php 
                                          if ($this->crud_model->check_availability_for_student($row['online_exam_id']) != "submitted"): ?>
                                       <?php if ($exam_status == 1): ?>
                                       <a href="<?php echo base_url(); ?>student/examroom/<?php echo $row['code']; ?>/" class="btn btn-success btn-rounded">
                                       <?php echo get_phrase('take_exam'); ?>
                                       </a>
                                       <?php
                                          else: ?>
                                       <div class="btn btn-info btn-rounded">
                                          <?php echo get_phrase('You_can_take_the_exam_in_the_established_time'); ?>
                                       </div>
                                       <?php
                                          endif; ?>
                                       <?php
                                          else: ?>
                                       <?php if ($time_now > $row['time_end']): 
                                          $is_view = $row['is_view'];
                                          if($is_view == 1){ ?>
                                       <a href="<?php echo base_url();?>student/online_exam_result/<?php echo $row['online_exam_id'];?>/" class="btn btn-success btn-rounded"><?php echo get_phrase('view_results');?></a>
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
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php endforeach; 
                        } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>