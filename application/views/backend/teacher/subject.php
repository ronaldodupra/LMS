<?php
  $tid = $this->session->userdata('login_user_id'); 
  $data = $this->db->get_where('section', array('teacher_id' => $tid))->row_array();

  $cl_id = $data['class_id'];
  $section_id = $data['section_id'];

  $department_id = $this->db->query("SELECT department_id FROM class WHERE class_id = '$cl_id'")->row()->department_id;
?>
<div class="content-w">
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
                          <div class="author-content text-wrap">
                            <a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('my_subject_lists');?></a>
                            <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                          </div>
                        </div>
                      </div>
                      <div class="profile-section">
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col col-lg-2 col-md-2 col-sm-12 col-12 m-auto"></div>
                            <div class="col col-lg-8 col-md-8 col-sm-12 col-12 m-auto">
                              <div class="os-tabs-w">
                                <div class="os-tabs-controls">
                                  <ul class="navs navs-tabs upper">
                                    <?php 
                                      $active = 0;
                                      
                                      $query = $this->db->query("SELECT b.`department_id`, c.`name` FROM subject a LEFT JOIN class b ON a.`class_id` = b.`class_id` LEFT JOIN tbl_department c ON b.`department_id` = c.`Id` WHERE a.`teacher_id` = '$tid' GROUP BY department_id");
                                      
                                      if ($query->num_rows() > 0):
                                        $dept = $query->result_array();
                                        foreach ($dept as $rows): $active++;
                                    ?>
                                    <li class="navs-item">
                                      <a class="navs-links <?php if($active == 1) echo "active";?>" data-toggle="tab" href="#tab<?php echo $rows['department_id'];?>"> <?php echo $rows['name'];?></a>
                                    </li>
                                    <?php endforeach; endif;?>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <div class="col col-lg-2 col-md-2 col-sm-12 col-12 m-auto">
                              <a onclick="add_subject();" href="javascript:void(0);" class="btn btn-success float-right"><span class="fa fa-plus"></span> <?php echo get_phrase('new_subject');?> </a><br>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="aec-full-message-w">
                      <div class="aec-full-message">
                        <div class="container-fluid" style="background-color: #f2f4f8;">
                          <div class="tab-content">
                            <?php 
                              $active = 0;
                              
                              $query = $this->db->query("SELECT b.`department_id`, c.`name` FROM subject a LEFT JOIN class b ON a.`class_id` = b.`class_id` LEFT JOIN tbl_department c ON b.`department_id` = c.`Id` WHERE a.`teacher_id` = '$tid' GROUP BY department_id");
                              
                              if ($query->num_rows() > 0):
                                $dept = $query->result_array();
                                foreach ($dept as $rowd): $active2++;
                            ?>
                            <div class="tab-pane <?php if($active2 == 1) echo "active";?>" id="tab<?php echo $rowd['department_id'];?>">
                              <?php if ($rowd['department_id'] == 3): ?>
                                <?php echo form_open(base_url() . 'teacher/my_subjects/', array('class' => 'form m-b'));?>
                                <div class="row">
                                  <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select">
                                      <label class="control-label"><?php echo get_phrase('filter_by_semester');?></label>
                                      <div class="select">
                                        <select name="sem_id" id="slct" onchange="submit();">
                                          <?php $sem = $this->db->get_where('exam', array('category' => '2'))->result_array();
                                            foreach($sem as $row):
                                          ?>
                                          <option value="<?php echo $row['exam_id'];?>" <?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                          <?php endforeach;?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <?php echo form_close();?>
                              <?php endif ?>
                              <div class="row">
                                <?php 
                                  $dept_id = $rowd['department_id'];

                                  if ($dept_id == 3) {

                                    $subjects = $this->db->query("SELECT t1.*, t2.`department_id` FROM subject t1 LEFT JOIN class t2 ON t1.`class_id` = t2.`class_id` WHERE t1.`teacher_id` = '$tid' AND t2.`department_id` = '$dept_id' AND semester_id = '$exam_id' ORDER BY class_id, name ASC")->result_array();
                                  }
                                  else{

                                    $subjects = $this->db->query("SELECT t1.*, t2.`department_id` FROM subject t1 LEFT JOIN class t2 ON t1.`class_id` = t2.`class_id` WHERE t1.`teacher_id` = '$tid' AND t2.`department_id` = '$dept_id' ORDER BY class_id, name ASC")->result_array();
                                  }
                                  
                                  foreach($subjects as $row2):
                                ?>
                                <?php //echo $row2['class_id']."-".$row2['section_id']."-".$row2['subject_id']; ?>
                                <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="ui-block" data-mh="friend-groups-item">
                                    <div class="friend-item friend-groups">
                                      <div class="friend-item-content">
                                        <div class="more">
                                          <i class="icon-feather-more-horizontal"></i>
                                          <ul class="more-dropdown">
                                            <li><a href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo base64_encode($row2['class_id']."-".$row2['section_id']."-".$row2['subject_id']);?>/">Dashboard</a></li>
                                            <li><a href="<?php echo base_url();?>teacher/students_enrolled/<?php echo base64_encode($row2['class_id'].'-'.$row2['section_id'].'-'.$row2['subject_id']);?>"><?php echo get_phrase('enrolled_student');?></a>
                                            </li>
                                            <li><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_subject/<?php echo $row2['subject_id'];?>');"><?php echo get_phrase('edit');?></a>
                                            </li>
                                          </ul>
                                        </div>
                                        <div class="friend-avatar">
                                          <?php 
                                            if($row2['icon'] != null || $row2['icon'] != ""){
                                              $image = base_url()."uploads/subject_icon/". $row2['icon'];
                                            }else{
                                              $image = base_url()."uploads/subject_icon/default_subject.png";
                                            }
                                            
                                            ?>
                                          <div class="author-thumb">
                                            <a href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo base64_encode($row2['class_id']."-".$row2['section_id']."-".$row2['subject_id']);?>/">
                                            <img src="<?php echo $image;?>" width="120px" style="background-color:#<?php echo $row2['color'];?>;padding:30px;border-radius:0px;">
                                            </a>
                                          </div>
                                          <div class="author-content">
                                            <a href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo base64_encode($row2['class_id']."-".$row2['section_id']."-".$row2['subject_id']);?>/" class="h5 author-name"><?php echo $row2['name'];?></a><br><br>
                                            <span><?php echo $this->crud_model->get_class_name($row2['class_id']); ?> - <?php echo $this->crud_model->get_section_name($row2['section_id']); ?></span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <?php endforeach;?>
                              </div>
                            </div>
                            <?php endforeach; endif;?>
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
  <div class="modal-dialog window-popup fav-page-popup" role="document" style="width: 700px;">
    <div class="modal-content">
      <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
      <div class="modal-header">
        <h6 class="title"><?php echo get_phrase('new_subject');?></h6>
      </div>
      <div class="modal-body">
        <?php echo form_open(base_url() . 'teacher/courses/create/MS', array('enctype' => 'multipart/form-data')); ?>
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
          <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="form-group label-floating is-select">
              <label class="control-label"><?php echo get_phrase('class');?></label>
              <div class="select">
                <select name="class_id" required="" onchange="get_class_sections(this.value);">
                  <option value=""><?php echo get_phrase('select');?></option>
                  <?php 
                    $classes = $this->db->query("SELECT * FROM class ORDER BY nivel_id ASC")->result_array();
                    foreach($classes as $row):
                  ?>
                  <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
          </div>
          <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="form-group label-floating is-select">
              <label class="control-label"><?php echo get_phrase('section');?></label>
              <div class="select">
                <select name="section_id" required="" id="section_selector">
                  <option value=""><?php echo get_phrase('select');?></option>
                </select>
              </div>
            </div>
          </div>
          <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
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
          <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="form-group label-floating is-select">
              <label class="control-label"><?php echo get_phrase('select_semester');?></label>
              <div class="select">
                <select name="sem_id" required="">
                  <option value="0" selected=""><?php echo get_phrase('none');?></option>
                  <?php 
                    $sem = $this->db->query("SELECT * from exam WHERE category = '2' order by exam_id asc")->result_array();
                    foreach($sem as $row):
                  ?>
                    <option value="<?php echo $row['exam_id'];?>"><?php echo $row['name']; ?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
          </div>
          <!-- <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="form-group label-floating is-select">
              <label class="control-label"><?php echo get_phrase('select_category');?></label>
              <div class="select">
                <select name="categ_id" required="">
                  <option value="0" selected=""><?php echo get_phrase('none');?></option>
                  <option value="1"><?php echo get_phrase('core');?></option>
                  <option value="2"><?php echo get_phrase('applied');?></option>
                </select>
              </div>
            </div>
          </div> -->
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
  
  function add_subject(){
    $('#addsubject').modal('show');
  }

  function get_class_sections(class_id) 
  {
    $.ajax({
      url: '<?php echo base_url();?>teacher/get_class_section/' + class_id ,
      success: function(response)
      {
        jQuery('#section_selector').html(response);
      }
    });
  }

</script>