<div  class="content-w">
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
                            Grades</a>
                            <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                          </div>
                        </div>
                      </div>
                      <div class="profile-section">
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col col-xl-8 m-auto col-lg-8 col-md-12">
                              <div class="os-tabs-w">
                                <div class="os-tabs-controls">
                                  <ul class="navs navs-tabs upper">
                                    <?php 
                                      $for_adv = $this->db->get_where('teacher', array('teacher_id' => $this->session->userdata('login_user_id')))->row()->teaching_status;
                                      
                                      if ($for_adv == 1):
                                    ?>
                                    <li class="navs-item">
                                      <a class="navs-links active" data-toggle="tab" href="#CA">Advisory Class</a>
                                    </li>
                                    <li class="navs-item">
                                      <a class="navs-links" data-toggle="tab" href="#ST">Subject Teacher Class</a>
                                    </li>
                                    <?php elseif($for_adv == 2):?>
                                    <li class="navs-item">
                                      <a class="navs-links active" data-toggle="tab" href="#CA">Advisory Class</a>
                                    </li>
                                    <?php elseif($for_adv == 3): ?>
                                    <li class="navs-item">
                                      <a class="navs-links active" data-toggle="tab" href="#ST">Subject Teacher</a>
                                    </li>
                                    <?php else: ?>
                                    <li class="navs-item"></li>
                                    <?php endif;?>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="header-spacer"></div> -->
                    <div class="container-fluid" id="results">
                      <div class="aec-full-message-w">
                        <div class="aec-full-message">
                          <div class="container-fluid" style="background-color: #f2f4f8;">
                            <div class="tab-content">
                            <?php if ($for_adv == 1 || $for_adv == 2): ?>
                              <div class="tab-pane active" id="CA">
                                <div class="row" id="results">
                                  <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 margintelbot" >
                                    <div class="friend-item friend-groups create-group w3-hover-shadow" data-mh="friend-groups-item" style="min-height:250px;">
                                      <a href="javascript:void(0);" class="full-block"></a>
                                      <div class="content">
                                        <a href="#" class="text-white btn btn-control bg-success" onclick="add_section('<?php echo $this->session->userdata('login_user_id'); ?>')"><i class="icon-feather-plus"></i></a>
                                        <div class="author-content">
                                          <a href="javascript:void(0);" class="h5 author-name"><?php echo get_phrase('new_section');?></a>
                                          <div class="country"><?php echo get_phrase('create_new_section');?></div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php
                                    $tid = $this->session->userdata('login_user_id'); 
                                    //$this->db->group_by('class_id');
                                    // $classes = $this->db->get_where('subject', array('teacher_id' => $this->session->userdata('login_user_id')))->result_array();
                                    
                                    // $classes = $this->db->query("SELECT t2.`class_id`, t2.`name` AS class, t3.`section_id`, t3.`name` AS section, t4.`teacher_id`, CONCAT(t4.`last_name`,' ',t4.`first_name`) AS teacher_name FROM SUBJECT t1 LEFT JOIN class t2 ON t1.`class_id` = t2.`class_id` LEFT JOIN section t3 ON t1.`section_id` = t3.`section_id` LEFT JOIN teacher t4 ON t1.`teacher_id` = t4.`teacher_id` WHERE t1.`teacher_id` = $tid GROUP BY t2.`class_id` ORDER BY t2.`class_id` ASC")->result_array();
                                    
                                    $classes = $this->db->query("SELECT t1.`class_id`, t1.`name` AS class, t3.`teacher_id`, t2.`name`, CONCAT(t3.`first_name`,' ', t3.`last_name`) AS teacher_name, t2.`section_id` FROM class t1 LEFT JOIN section t2 ON t1.`class_id` = t2.`class_id` LEFT JOIN teacher t3 ON t2.`teacher_id` = t3.`teacher_id`WHERE t3.`teacher_id` = '$tid' GROUP BY class_id ORDER BY class_id ASC")->result_array();
                                    
                                    foreach($classes as $cl):
                                  ?>
                                  <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12" >
                                    <div class="ui-block" data-mh="friend-groups-item">
                                      <div class="friend-item friend-groups">
                                        <div class="friend-item-content">
                                          <div class="more">
                                            <i class="icon-feather-more-horizontal"></i>
                                            <ul class="more-dropdown">
                                              <li><a href="<?php echo base_url();?>teacher/cursos/<?php echo base64_encode($cl['class_id'].'-1');?>/"><?php echo get_phrase('my_subjects');?></a></li>
                                              <?php 
                                                $cl_id = $cl['class_id'];
                                                $chk_advisory = $this->db->query("SELECT * FROM section WHERE class_id = $cl_id AND teacher_id = $tid");
                                                
                                                if ($chk_advisory->num_rows() > 0):
                                                ?>
                                              <hr>
                                              <li><a href="<?php echo base_url();?>teacher/students_area/"><?php echo get_phrase('students');?></a></li>
                                              <li><a href="<?php echo base_url();?>teacher/class_routine_view/<?php echo base64_encode($cl['class_id'].'-'.$cl['section_id']);?>/"><?php echo get_phrase('schedule');?></a></li>
                                              <li><a href="<?php echo base_url();?>teacher/pending/<?php echo $cl['class_id'];?>/<?php echo $cl['teacher_id'];?>"><?php echo get_phrase('accept_user');?> (<?php echo $this->db->count_all_results('pending_users');?>)</a></li>
                                              <?php endif;?>
                                            </ul>
                                          </div>
                                          <div class="friend-avatar">
                                            <div class="author-thumb">
                                              <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" width="120px" style="background-color:#fff;padding:15px; border-radius:0px">
                                            </div>
                                            <div class="author-content">
                                              <a href="<?php echo base_url();?>teacher/cursos/<?php echo base64_encode($cl['class_id'].'-1');?>/" class="h5 author-name"><?php echo $this->db->get_where('class', array('class_id' => $cl['class_id']))->row()->name;?></a>
                                              <div class="country">
                                                <b><?php echo get_phrase('sections');?>:</b><!-- <?php //$sections = $this->db->get_where('section', array('class_id' => $cl['class_id']))->result_array(); foreach($sections as $sec):?><?php //echo $sec['name']." "."|";?><?php //endforeach;?> -->
                                                <?php echo $cl['name']; ?>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php endforeach;?>
                                </div>
                              </div>

                              <div class="tab-pane" id="ST">
                                <div class="row" id="results">
                                  <?php
                                    $section = $this->db->get_where('section', array('teacher_id' => $tid))->row()->section_id;
                                    
                                    if ($section == "" || $section == null) {
                                      $sec_id = 0;
                                    }
                                    else{
                                      $sec_id = $section;
                                    }
                                    
                                    $classes = $this->db->query("SELECT t2.`class_id`, t2.`name` AS class, t3.`teacher_id`, t4.`name`, CONCAT(t3.`first_name`,' ', t3.`last_name`) AS teacher_name FROM subject t1 LEFT JOIN class t2 ON t1.`class_id` = t2.`class_id` LEFT JOIN teacher t3 ON t1.`teacher_id` = t3.`teacher_id` LEFT JOIN section t4 ON t1.`section_id` = t4.`section_id` WHERE t3.`teacher_id` = '$tid' AND t1.`section_id` <> '$sec_id' GROUP BY class_id ORDER BY class_id ASC")->result_array();
                                    
                                    foreach($classes as $cl):
                                      $cl_id2 = $cl['class_id'];
                                  ?>
                                  <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12" >
                                    <div class="ui-block" data-mh="friend-groups-item">
                                      <div class="friend-item friend-groups">
                                        <div class="friend-item-content">
                                          <div class="more">
                                            <i class="icon-feather-more-horizontal"></i>
                                            <ul class="more-dropdown">
                                              <li><a href="<?php echo base_url();?>teacher/cursos/<?php echo base64_encode($cl['class_id'].'-2');?>/"><?php echo get_phrase('my_subjects');?></a></li>
                                            </ul>
                                          </div>
                                          <div class="friend-avatar">
                                            <div class="author-thumb">
                                              <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" width="120px" style="background-color:#fff;padding:15px; border-radius:0px">
                                            </div>
                                            <div class="author-content">
                                              <a href="<?php echo base_url();?>teacher/cursos/<?php echo base64_encode($cl_id2.'-2');?>/" class="h5 author-name"><?php echo $this->db->get_where('class', array('class_id' => $cl_id2))->row()->name;?></a>
                                              <div class="country"><b><?php echo get_phrase('sections');?>:</b>
                                                <?php $sections = $this->db->query("SELECT t1.`section_id`, t2.`name` FROM subject t1 LEFT JOIN section t2 ON t1.`section_id` = t2.`section_id` WHERE t1.`teacher_id` = '$tid' AND t1.`class_id` = '$cl_id2' AND t1.`section_id` <> '$sec_id' GROUP BY t1.`section_id`")->result_array(); foreach($sections as $sec):?> <?php echo $sec['name']." "."|";?><?php endforeach;?> 
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php endforeach;?>
                                </div>
                              </div>

                            <?php elseif($for_adv == 3): ?>
                              <div class="tab-pane active" id="ST">
                                <div class="row" id="results">
                                  <?php
                                    $tid = $this->session->userdata('login_user_id'); 
                                    $classes = $this->db->query("SELECT t2.`class_id`, t2.`name` AS class, t3.`teacher_id`, t4.`name`, CONCAT(t3.`first_name`,' ', t3.`last_name`) AS teacher_name FROM subject t1 LEFT JOIN class t2 ON t1.`class_id` = t2.`class_id` LEFT JOIN teacher t3 ON t1.`teacher_id` = t3.`teacher_id` LEFT JOIN section t4 ON t1.`section_id` = t4.`section_id`WHERE t3.`teacher_id` = '$tid' GROUP BY class_id ORDER BY class_id ASC")->result_array();
                                    
                                    foreach($classes as $cl):
                                      $cl_id3 = $cl['class_id'];
                                  ?>
                                  <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12" >
                                    <div class="ui-block" data-mh="friend-groups-item">
                                      <div class="friend-item friend-groups">
                                        <div class="friend-item-content">
                                          <div class="more">
                                            <i class="icon-feather-more-horizontal"></i>
                                            <ul class="more-dropdown">
                                              <li><a href="<?php echo base_url();?>teacher/cursos/<?php echo base64_encode($cl_id3.'-3');?>/"><?php echo get_phrase('my_subjects');?></a></li>
                                            </ul>
                                          </div>
                                          <div class="friend-avatar">
                                            <div class="author-thumb">
                                              <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" width="120px" style="background-color:#fff;padding:15px; border-radius:0px">
                                            </div>
                                            <div class="author-content">
                                              <a href="<?php echo base_url();?>teacher/cursos/<?php echo base64_encode($cl['class_id'].'-3');?>/" class="h5 author-name"><?php echo $this->db->get_where('class', array('class_id' => $cl_id3))->row()->name;?></a>
                                              <div class="country"><b><?php echo get_phrase('sections');?>:</b> <?php $sections = $this->db->query("SELECT t1.`section_id`, t2.`name` FROM subject t1 LEFT JOIN section t2 ON t1.`section_id` = t2.`section_id` WHERE t1.`teacher_id` = '$tid' AND t1.`class_id` = '$cl_id3' GROUP BY section_id")->result_array(); foreach($sections as $sec):?> <?php echo $sec['name']." "."|";?><?php endforeach;?>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php endforeach;?>
                                </div>
                              </div>

                            <?php else: ?>
                              <div class="alert alert-success" id="assess_alert">
                                <i></i>
                                <center>
                                  <p style="font-size: 30px;">
                                    Please update first your <b>Teaching Status</b> on your user account to view your class. To update:<br><br>
                                    <b>Go to My Account > Update Information > Select your prefered teaching status > Click Update</b>
                                  </p>
                                </center>
                              </div>
                            </div>
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
      <div class="display-type"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_section_modal" tabindex="-1" role="dialog" aria-labelledby="crearadmin" aria-hidden="true" style="top:10%;">
  <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
    <div class="modal-content">
      <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
      </a>
      <div class="modal-body">
        <div class="modal-header" style="background-color:#00579c">
          <h6 class="title" style="color:white"><?php echo get_phrase('new_section');?></h6>
        </div>
        <div class="ui-block-content">
          <?php echo form_open(base_url() . 'teacher/sections/add_modal');?>
          <div class="row">
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group label-floating is-select">
                <label class="control-label"><?php echo get_phrase('class');?></label>
                <!-- <input type="text" disabled="" id="class_name"> -->
                <div class="select">
                  <select name="class_id" required="">
                    <option value=""><?php echo get_phrase('select');?></option>
                    <?php 
                      $tid = $this->session->userdata('login_user_id');
                      $classes = $this->db->get('class')->result_array();
                      //$classes = $this->db->query("SELECT t1.`class_id`, t1.`name` FROM class t1 LEFT JOIN section t2 ON t1.`class_id` = t2.`class_id` WHERE t2.`teacher_id` = $tid GROUP BY t1.`class_id` ORDER BY t1.`class_id`")->result_array();
                      
                      foreach($classes as $row):
                      ?>
                    <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group label-floating is-select">
                <label class="control-label"><?php echo get_phrase('teacher');?></label>
                <!-- <input type="text" disabled="" id="teacher_name"> -->
                <div class="select">
                  <select name="teacher_id" required="">
                    <!-- <option value=""><?php echo get_phrase('select');?></option> -->
                    <?php
                      $tid = $this->session->userdata('login_user_id'); 
                      $teachers = $this->db->query("SELECT * from teacher where teacher_id = $tid order by last_name asc")->result_array();
                      foreach($teachers as $row):
                      ?>
                    <option value="<?php echo $row['teacher_id'];?>"><?php echo $row['last_name'].", ".$row['first_name'];?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group label-floating">
                <label class="control-label"><?php echo get_phrase('name');?></label>
                <input class="form-control" type="text" id="name" name="name" required="">
              </div>
            </div>
            <!--  <input type="hidden" id="class_id" name="class_id">
              <input type="hidden" id="teacher_id" name="teacher_id"> -->
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
              <button class="btn btn-rounded btn-success" type="submit"><?php echo get_phrase('save');?></button>
            </div>
          </div>
          <?php echo form_close();?>         
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function add_section(teacher_id){
    //alert(grade_id +' '+ grade_name +' '+ teacher_id);
  
    //$('#class_id').val(grade_id);
    //$('#class_name').val(grade_name);
    $('#teacher_id').val(teacher_id);
    $('#add_section_modal').modal('show');
  }
</script>