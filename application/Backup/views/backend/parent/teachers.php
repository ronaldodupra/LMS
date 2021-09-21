<?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;?>
<div class="content-w">
    <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
  <div class="conty">
  <div class="content-i">
   <div class="content-box">
  <div class="os-tabs-w">
      <div class="os-tabs-controls">

        <ul class="navs navs-tabs upper">
          <?php 

          $n = 1;

          $children_of_parent = $this->db->get_where('student' , array('parent_id' => $this->session->userdata('parent_id')))->result_array();
          foreach ($children_of_parent as $row):
                    ?>
           <?php $active1 = $n++;?>
           <li class="navs-item">
              <a class="navs-links <?php if($active1 == 1) echo 'active';?>" data-toggle="tab" href="#<?php echo $row['username'];?>"><img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']);?>" width="25px" style="border-radius: 25px;margin-right:5px;"> <?php echo $this->crud_model->get_name('student', $row['student_id']);?></a>
          </li>
         <?php endforeach; ?>
        </ul>

      </div>
      </div>
        <div class="tab-content">
            <?php 
            $n = 1;
              $children_of_parent = $this->db->get_where('student' , array('parent_id' => $this->session->userdata('parent_id')))->result_array();
                foreach ($children_of_parent as $row2):
            ?>
          <?php $active = $n++;?>
      <div class="tab-pane <?php if($active == 1) echo 'active';?>" id="<?php echo $row2['username'];?>">
          
          <div class="row">
            <?php 
            $n = 1;
            
            $class_id     = $this->db->get_where('enroll', array('student_id' => $row2['student_id']))->row()->class_id;
            
            $teacher_list = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
            //echo $class_id;
            foreach($teacher_list as $row1):
                      ?>
            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="ui-block list">
                    <div class="birthday-item inline-items">
                        <div class="author-thumb">
                            <img src="<?php echo $this->crud_model->get_image_url('teacher', $row1['teacher_id']);?>" class="avatars">
                        </div>
                        <div class="birthday-author-name">
                            <a href="javascript:void(0);" class="h6 author-name"><?php echo $this->crud_model->get_name('teacher', $row1['teacher_id']);?></a>
                             <div class="birthday-date"><b><i class="picons-thin-icon-thin-0007_book_reading_read_bookmark"></i>
                              <?php  echo $this->db->get_where('subject', array('subject_id' => $row1['subject_id']))->row()->name;?></b> </div>
                            <div class="birthday-date"><b><i class="picons-thin-icon-thin-0291_phone_mobile_contact"></i></b> <?php  echo $this->db->get_where('teacher', array('teacher_id' => $row1['teacher_id']))->row()->phone;?></div>
                            <div class="birthday-date"><b><i class="picons-thin-icon-thin-0321_email_mail_post_at"></i></b> <?php  echo $this->db->get_where('teacher', array('teacher_id' => $row1['teacher_id']))->row()->email;?></div>

                        </div>                
                    </div>
                </div>
            </div>
            <?php endforeach;?>
          </div>
        </div>  
        <?php endforeach;?>
      </div>
    </div>
  </div>
</div>
</div>