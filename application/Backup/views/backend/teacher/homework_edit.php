<?php 
   $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; 
   
   $activity_id =  $this->db->query("SELECT * from homework where homework_code = '$homework_code'")->row()->activity_type;
   
   $activity_type =  $this->db->query("SELECT * from tbl_act_type where id = '$activity_id'")->row()->activity_type;

   $cat_id =  $this->db->query("SELECT * from homework where homework_code = '$homework_code'")->row()->category;

   $category = $this->db->query("SELECT * from tbl_act_category where id = '$cat_id'")->row()->category;
   
   ?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/homeworkroom/<?php echo $homework_code;?>/"><i class="os-icon picons-thin-icon-thin-0014_notebook_paper_todo"></i><span><?php echo $activity_type .' details';?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/homework_details/<?php echo $homework_code;?>/"><i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i><span><?php echo get_phrase('deliveries');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>teacher/homework_edit/<?php echo $homework_code;?>/"><i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span><?php echo get_phrase('edit');?></span></a>
               </li>
            </ul>
         </div>
      </div>
      <?php $info = $this->db->get_where('homework', array('homework_code' => $homework_code))->result_array();
         foreach($info as $row):
         ?>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <div class="col-sm-8">

                  <?php echo form_open(base_url() . 'teacher/homework/update/' . $homework_code, array('enctype' => 'multipart/form-data')); ?>

                  <div class="pipeline white lined-primary">
                     <div class="pipeline-header">
                        <h5 class="pipeline-name"><?php echo 'Update '.$activity_type;?></h5>
                     </div>
                     
                     <div class="form-group">
                        <label for=""> <?php echo get_phrase('title');?></label><input class="form-control" required="" name="title" value="<?php echo $row['title'];?>" type="text">
                     </div>

                     <div class="row">
                        <div class="col-sm-4"> 
                           <div class="form-group label-floating is-select">
                              <label class="control-label"><?php echo get_phrase('select_semester');?></label>
                              <div class="select">
                                 <select name="semester_id" id="semester_id">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php $ex = $this->db->get('exam')->result_array();
                                       foreach($ex as $row1):
                                       ?>

                                    <option value="<?php echo $row1['exam_id'];?>" <?php if($row['semester_id'] == $row1['exam_id']) echo 'selected';?>><?php echo $row1['name'];?></option>
                                    <?php endforeach;?>

                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4"> 
                           <div class="form-group label-floating is-select">
                              <label class="control-label"><?php echo get_phrase('select_category');?></label>
                              <div class="select">
                                 <select name="category" id="category">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php $ex = $this->db->get('tbl_act_category')->result_array();
                                       foreach($ex as $row1):
                                       ?>

                                    <option value="<?php echo $row1['id'];?>" <?php if($row['category'] == $row1['id']) echo 'selected';?>><?php echo $row1['category'];?></option>
                                    <?php endforeach;?>

                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4"> 
                           <div class="form-group label-floating is-select">
                              <label class="control-label"><?php echo get_phrase('select_activity_type');?></label>
                              <div class="select">
                                 <select name="activity_type" id="activity_type">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php $ex = $this->db->get('tbl_act_type')->result_array();
                                       foreach($ex as $row1):
                                       ?>

                                    <option value="<?php echo $row1['id'];?>" <?php if($row['activity_type'] == $row1['id']) echo 'selected';?>><?php echo $row1['activity_type'];?></option>
                                    <?php endforeach;?>

                                 </select>
                              </div>
                           </div>
                        </div>

                     </div>

                     <div class="form-group">
                        <label> <?php echo get_phrase('description');?></label>
                        <textarea cols="80" id="ckeditor1" name="description" required rows="2"><?php echo $row['description'];?></textarea>
                        <!-- <textarea cols="80" id="mymce" name="description" required rows="2"><?php //echo $row['description'];?></textarea> -->
                        <!-- <textarea class="form-control" cols="80" id="mymce_news" name="description" required="" rows="2"><?php //echo $row['description'];?></textarea> -->
                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group">
                              <label for=""> <?php echo get_phrase('delivery_date');?></label>
                              <input type='text' class="datepicker-here" data-position="top left" data-language='en' name="date_end" data-multiple-dates-separator="/" value="<?php echo $row['date_end'];?>"/>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="col-sm-6">
                           <div class="form-group">
                              <label for=""> <?php echo get_phrase('limit_hour');?></label>

                              <input type="time" required="" name="time_end" class="form-control" value="<?php echo $row['time_end'];?>">
                           </div>
                        </div>
                        </div>
                     </div>
                     
                     <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="description-toggle">
                           <div class="description-toggle-content">
                              <div class="h6"><?php echo get_phrase('show_students');?></div>
                              <p><?php echo get_phrase('show_message');?>.</p>
                           </div>
                           <div class="togglebutton">
                              <label><input name="status" value="1" <?php if($row['status'] == 1) echo "checked"?> type="checkbox"></label>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                           <center><label class="control-label"><?php echo get_phrase('type');?></label></center>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-6 col-6">
                           <div class="custom-control custom-radio" style="float: right">
                              <input  type="radio" <?php if($row['type'] == 1) echo 'checked';?> name="type" id="1" value="1" class="custom-control-input"> <label for="1" class="custom-control-label"><?php echo get_phrase('online_text');?></label>
                           </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-6 col-6">
                           <div class="custom-control custom-radio">
                              <input  type="radio" <?php if($row['type'] == 2) echo 'checked';?> name="type" id="2" value="2" class="custom-control-input"> <label for="2" class="custom-control-label"><?php echo get_phrase('files');?></label>
                           </div>
                        </div>
                     </div>
                     <div class="form-buttons-w text-right">
                        <button class="btn btn-rounded btn-success" type="submit"><?php echo get_phrase('update');?></button>
                     </div>
                     
                  </div>
                  <?php echo form_close();?>
               </div>
               <div class="col-sm-4">
                  <div class="pipeline white lined-secondary">
                     <div class="pipeline-header">
                        <h5 class="pipeline-name">
                           <?php echo get_phrase('information');?>
                        </h5>
                     </div>
                     <div class="table-responsive">
                        <table class="table table-lightbor table-lightfont">
                           <tr>
                              <th>
                                 <?php echo get_phrase('activity');?>:
                              </th>
                              <td>
                                 <?php echo $activity_type;?>
                              </td>
                           </tr>
                           <tr>
                              <th>
                                 <?php echo get_phrase('category');?>:
                              </th>
                              <td>
                                 <?php echo $category;?>
                              </td>
                           </tr>
                           <tr>
                              <th>
                                 <?php echo get_phrase('subject');?>:
                              </th>
                              <td>
                                 <?php echo $this->crud_model->get_type_name_by_id('subject',$row['subject_id']);?>
                              </td>
                           </tr>
                           <tr>
                              <th>
                                 <?php echo get_phrase('class');?>:
                              </th>
                              <td>
                                 <?php echo $this->crud_model->get_type_name_by_id('class',$row['class_id']);?>
                              </td>
                           </tr>
                           <tr>
                              <th>
                                 <?php echo get_phrase('section');?>:
                              </th>
                              <td>
                                 <?php echo $this->crud_model->get_type_name_by_id('section',$row['section_id']);?>
                              </td>
                           </tr>
                           <tr>
                              <th>
                                 <?php echo get_phrase('total_students');?>:
                              </th>
                              <td>
                                 <a class="btn nc btn-rounded btn-sm btn-secondary" style="color:white"><?php $this->db->where('class_id', $row['class_id']); $this->db->where('section_id', $row['section_id']); echo $this->db->count_all_results('enroll');?></a>
                              </td>
                           </tr>
                           <tr>
                              <th>
                                 <?php echo get_phrase('delivered');?>:
                              </th>
                              <td>
                                 <a class="btn nc btn-rounded btn-sm btn-success" style="color:white"><?php $this->db->where('class_id', $row['class_id']); $this->db->where('section_id', $row['section_id']); $this->db->where('homework_code', $homework_code); echo $this->db->count_all_results('deliveries');?></a>
                              </td>
                           </tr>
                           <tr>
                              <th>
                                 <?php echo get_phrase('undeliverable');?>:
                              </th>
                              <td>
                                 <?php $this->db->where('class_id', $row['class_id']); $this->db->where('section_id', $row['section_id']); $all = $this->db->count_all_results('enroll');?>
                                 <?php $this->db->where('class_id', $row['class_id']); $this->db->where('section_id', $row['section_id']); $this->db->where('homework_code', $homework_code); $deliveries = $this->db->count_all_results('deliveries');?>
                                 <a class="btn nc btn-rounded btn-sm btn-danger" style="color:white"><?php echo $all - $deliveries; ?></a>
                              </td>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <div class="pipeline white lined-warning">
                     <div class="pipeline-header">
                        <h5 class="pipeline-name"><?php echo get_phrase('students');?></h5>
                     </div>
                     <div class="users-list-w">
                        <?php 

                        $students = $this->db->query("SELECT t1.* FROM enroll t1 
                              LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                              where t1.class_id = '$class_id' and t1.section_id = '$section_id' and t1.year = '$running_year'
                              ORDER BY t2.`last_name` ASC")->result_array();

                        // $students   =   $this->db->get_where('enroll' , array('class_id' => $row['class_id'], 'section_id' => $row['section_id'] , 'year' => $running_year))->result_array();
                           foreach($students as $row2):?>

                        <div class="user-w">
                           <div class="user-avatar-w">
                              <div class="user-avatar">
                                 <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row2['student_id']); ?>">
                              </div>
                           </div>
                           <div class="user-name">
                              <h6 class="user-title">
                                 <a href="javascript:void(0);" class="h6 notification-friend">

                                      <?php echo strtoupper($this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->last_name.", ".$this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->first_name); ?>
                                        
                                    </a>
                              </h6>
                              <div class="user-role">
                                 <?php echo get_phrase('roll');?>: <strong><?php echo $this->db->get_where('enroll' , array('student_id' => $row2['student_id']))->row()->roll; ?></strong>
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
      <?php endforeach;?>
   </div>
</div>