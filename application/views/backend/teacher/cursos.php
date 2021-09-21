<div class="content-w">
  <?php 
    $data = base64_decode($class_id);
    $ex = explode('-', $data);
    
    $cl_id = $ex[0];
    $type = $ex[1];
    $tid = $this->session->userdata('login_user_id');
    $class_name = $this->db->get_where('class' , array('class_id' => $cl_id))->row()->name;
  ?>
  <script src="<?php echo base_url();?>jscolor.js"></script>
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
                            <a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('subjects');?> <small>(<?php echo $this->db->get_where('class', array('class_id' => $cl_id))->row()->name;?>)</small></a>
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
                                      $active = 0;
                                      
                                      if ($type == 1) {
                                        $query = $this->db->get_where('section' , array('teacher_id' => $tid));
                                      }
                                      elseif ($type == 2) {
                                        $section = $this->db->get_where('section', array('teacher_id' => $tid))->row()->section_id;
                                      
                                        if ($section == "" || $section == null) {
                                          $sec_id = 0;
                                        }
                                        else{
                                          $sec_id = $section;
                                        }
                                       
                                        $query = $this->db->query("SELECT t1.`section_id`, t2.`name` FROM subject t1 LEFT JOIN section t2 ON t1.`section_id` = t2.`section_id` WHERE t1.`teacher_id` = '$tid' AND t1.`class_id` = '$cl_id' AND t1.`section_id` <> '$sec_id' GROUP BY section_id ORDER BY section_id ASC");
                                      }
                                      else{
                                         $query = $this->db->query("SELECT t1.`section_id`, t2.`name` FROM subject t1 LEFT JOIN section t2 ON t1.`section_id` = t2.`section_id` WHERE t1.`teacher_id` = '$tid' AND t1.`class_id` = '$cl_id' GROUP BY section_id ORDER BY section_id ASC");
                                      }
                                      
                                      if ($query->num_rows() > 0):
                                        $sections = $query->result_array();
                                        foreach ($sections as $rows): $active++;
                                    ?>
                                    <li class="navs-item">
                                      <a class="navs-links <?php if($active == 1) echo "active";?>" data-toggle="tab" href="#tab<?php echo $rows['section_id'];?>"><?php //echo get_phrase('section');?> <?php echo $rows['name'];?></a>
                                    </li>
                                    <?php endforeach; endif;?>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-12">
                          <?php 
                            $tid = $this->session->userdata('login_user_id');  
                            $chk_advisory = $this->db->query("SELECT * FROM section WHERE class_id = $cl_id AND teacher_id = $tid");

                            if($chk_advisory->num_rows() > 0){ ?>

                              <a onclick="add_subject('<?php echo $cl_id; ?>','<?php echo $class_name; ?>')" href="javascript:void(0);" class="btn btn-success float-right"><span class="fa fa-plus"></span> <?php echo get_phrase('new_subject');?> </a><br>

                            <?php }else{ ?>

                            <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="aec-full-message-w">
                      <div class="aec-full-message">
                        <div class="container-fluid" style="background-color: #f2f4f8;">
                          <div class="tab-content">
                            <?php 
                              $active2 = 0;

                              if ($type == 1) {
                                $query = $this->db->get_where('section' , array('teacher_id' => $tid));
                              }
                              elseif ($type == 2) {
                                $section = $this->db->get_where('section', array('teacher_id' => $tid))->row()->section_id;
                              
                                if ($section == "" || $section == null) {
                                  $sec_id = 0;
                                }
                                else{
                                  $sec_id = $section;
                                }
                               
                                $query = $this->db->query("SELECT t1.`section_id`, t2.`name` FROM subject t1 LEFT JOIN section t2 ON t1.`section_id` = t2.`section_id` WHERE t1.`teacher_id` = '$tid' AND t1.`class_id` = '$cl_id' AND t1.`section_id` <> '$sec_id' GROUP BY section_id ORDER BY section_id ASC");
                              }
                              else{
                                 $query = $this->db->query("SELECT t1.`section_id`, t2.`name` FROM subject t1 LEFT JOIN section t2 ON t1.`section_id` = t2.`section_id` WHERE t1.`teacher_id` = '$tid' AND t1.`class_id` = '$cl_id' GROUP BY section_id ORDER BY section_id ASC");
                              }

                              if ($query->num_rows() > 0):
                                $sections = $query->result_array();
                                foreach ($sections as $row): $active2++;
                            ?>
                            <div class="tab-pane <?php if($active2 == 1) echo "active";?>" id="tab<?php echo $row['section_id'];?>">
                              <div class="row"> 
                                <?php
                                  $sec_id = $row['section_id'];

                                  //$this->db->order_by('subject_id', 'desc');
                                  //$subjects = $this->db->get_where('subject', array('section_id' => $sec_id, 'teacher_id' => $this->session->userdata('login_user_id')))->result_array();

                                  $subjects = $subjects = $this->db->query("SELECT * FROM subject WHERE section_id = '$sec_id' AND teacher_id = '$tid' ORDER BY subject_id ASC")->result_array();
                                  
                                  // if ($type == 1 || $type == 2) {
                                  //   $subjects = $this->db->query("SELECT * FROM subject WHERE class_id = '$cl_id' AND section_id = '$sec_id' ORDER BY subject_id ASC")->result_array();
                                  // }
                                  // else{
                                    
                                  // }

                                  foreach($subjects as $row2):
                                ?>
                                <?php //echo $cl_id.'-'.$sec_id; ?>
                                <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="ui-block" data-mh="friend-groups-item">
                                    <div class="friend-item friend-groups">
                                      <div class="friend-item-content">
                                        <div class="more">
                                          <i class="icon-feather-more-horizontal"></i>
                                          <ul class="more-dropdown">
                                            <li><a href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo base64_encode($row2['class_id']."-".$row['section_id']."-".$row2['subject_id']);?>/">Dashboard</a></li>
                                            <li><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_subject/<?php echo $row2['subject_id'];?>');"><?php echo get_phrase('edit');?></a></li>
                                            <li><a href="<?php echo base_url();?>teacher/students_enrolled/<?php echo base64_encode($row2['class_id'].'-'.$row2['section_id'].'-'.$row2['subject_id']);?>"><?php echo get_phrase('enrolled_student');?></a></li>
                                          </ul>
                                        </div>
                                        <div class="friend-avatar">
                                          <div class="author-thumb">
                                            <?php 
                                              if($row2['icon'] != null || $row2['icon'] != ""){
                                                $image = base_url()."uploads/subject_icon/". $row2['icon'];
                                              }else{
                                                $image = base_url()."uploads/subject_icon/default_subject.png";
                                              }
                                              
                                              ?>
                                            <a href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo base64_encode($row2['class_id']."-".$row['section_id']."-".$row2['subject_id']);?>/">
                                            <img src="<?php echo $image?>" width="120px" style="background-color:#<?php echo $row2['color'];?>;padding:30px;border-radius:0px;">
                                            </a>
                                          </div>
                                          <div class="author-content">
                                            <a href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo base64_encode($row2['class_id']."-".$row['section_id']."-".$row2['subject_id']);?>/" class="h5 author-name"><?php echo $row2['name'];?> - <?php echo $row['name'];?></a><br><br>
                                            <img src="<?php echo $this->crud_model->get_image_url('teacher', $row2['teacher_id']);?>" style="border-radius:50%;width:20px;"><span>  <?php echo $this->crud_model->get_name('teacher', $row2['teacher_id']);?></span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <?php endforeach;?>
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
      <div class="display-type"></div>
    </div>
  </div>
</div>
<div class="modal fade" id="addsubject" tabindex="-1" role="dialog" aria-labelledby="fav-page-popup" aria-hidden="true">
  <div class="modal-dialog window-popup fav-page-popup" role="document">
    <div class="modal-content">
      <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
      <div class="modal-header">
        <h6 class="title"><?php echo get_phrase('new_subject');?></h6>
      </div>
      <div class="modal-body">
        <?php echo form_open(base_url() . 'teacher/courses/create/'.$cl_id, array('enctype' => 'multipart/form-data')); ?>
        <div class="row">
          <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group label-floating">
              <label class="control-label"><?php echo get_phrase('name');?></label>
              <input class="form-control" placeholder="" name="name" type="text" required>
            </div>
          </div>
          <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <label class="control-label"><?php echo get_phrase('icon');?></label>
              <input class="form-control" name="userfile" type="file">
            </div>
          </div>
          <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group label-floating">
              <label class="control-label text-white"><?php echo get_phrase('color');?></label>
              <input class="jscolor" name="color" required value="0084ff">
            </div>
          </div>
          <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group label-floating is-select">
              <label class="control-label"><?php echo get_phrase('class');?></label>
              <div class="select">
                <select name="class_id" required="">
                  <option value=""><?php echo get_phrase('select');?></option>
                  <?php 
                    $class_info = $this->db->get('class')->result_array();
                    foreach ($class_info as $rowd) { ?>
                  <option value="<?php echo $rowd['class_id']; ?>" <?php if($cl_id == $rowd['class_id']) echo "selected";?>><?php echo $rowd['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group label-floating is-select">
              <label class="control-label"><?php echo get_phrase('section');?></label>
              <div class="select">
                <select name="section_id" required="">
                  <option value=""><?php echo get_phrase('select');?></option>
                  <?php 
                    $class_info = $this->db->get_where('section' , array('class_id' => $cl_id));
                    if ($class_info->num_rows() > 0):
                      $sections = $class_info->result_array();
                      foreach ($sections as $rowd) {?>
                  <option value="<?php echo $rowd['section_id']; ?>"><?php echo $rowd['name']; ?></option>
                  <?php };?>
                  <?php endif;?>
                </select>
              </div>
            </div>
          </div>
          <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group label-floating is-select">
              <label class="control-label"><?php echo get_phrase('teacher');?></label>
              <div class="select">
                <select name="teacher_id" required="">
                  <option value=""><?php echo get_phrase('select');?></option>
                  <?php 
                    $teachers = $this->db->query("SELECT * from teacher order by last_name asc")->result_array();
                    foreach($teachers as $row):
                       ?>
                  <option value="<?php echo $row['teacher_id'];?>"><?php echo $row['last_name'].", ".$row['first_name'];?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
          </div>
          <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
            <button class="btn btn-success btn-lg full-width" type="submit"><?php echo get_phrase('save');?></button>
          </div>
        </div>
      </div>
      <?php echo form_close();?>
    </div>
  </div>
</div>

<script type="text/javascript">
  
  function add_subject(class_id,class_name){
    $('#class_id').val(class_id);
    $('#class_name').val(class_name);
    $('#addsubject').modal('show');
  }

</script>