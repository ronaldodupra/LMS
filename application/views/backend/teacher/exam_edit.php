<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/examroom/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span><?php echo get_phrase('exam_details');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/exam_results/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i><span><?php echo get_phrase('results');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>teacher/exam_edit/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span><?php echo get_phrase('edit');?></span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div>
               <div class="pipeline white lined-primary">
                  <?php
                     $online_exam = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();
                     $sections    = $this->db->get_where('section', array('class_id' => $online_exam['class_id']))->result_array();
                     $subjects    = $this->db->get_where('subject', array('class_id' => $online_exam['class_id']))->result_array();
                     ?>
                  <?php echo form_open(base_url() . 'teacher/online_exams/edit/', array('enctype' => 'multipart/form-data')); ?>
                  <div class="row">
                     <div class="col-sm-4">
                        <div class="form-group">
                           <label class="col-form-label" for=""><?php echo get_phrase('title');?></label>
                           <div class="input-group">
                              <input type="text" required="" class="form-control" name="exam_title" value="<?php echo $online_exam['title']; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="form-group">
                           <label class="col-form-label" for=""><?php echo get_phrase('date');?></label>
                           
                              <input type='date' required="" class="form-control" name="exam_date" value="<?php echo $online_exam['examdate']; ?>"/>
                         
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                           <label class="col-form-label" for=""><?php echo get_phrase('start_time');?></label>
                           <input type="time" required="" name="time_start" class="form-control" value="<?php echo $online_exam['time_start'];?>">
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                           <label class="col-form-label" for=""><?php echo get_phrase('end_time');?></label>
                           <input type="time" required="" name="time_end" class="form-control" value="<?php echo $online_exam['time_end'];?>">
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="form-group">
                           <label class="col-form-label" for=""><?php echo get_phrase('select_semester');?></label>
                           <div class="select">
                              <select name="semester_id" required="" id="semester_id">
                                 <option value=""><?php echo get_phrase('select');?></option>
                                 <?php $cl = $this->db->get('exam')->result_array();
                                    foreach($cl as $row):
                                    ?>
                                 <option value="<?php echo $row['exam_id'];?>" <?php if($online_exam['semester_id'] == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                 <?php endforeach;?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="form-group">
                           <label class="col-form-label" for=""><?php echo get_phrase('percentage_required');?></label>
                           <div class="input-group">
                              <input type="text" required="" class="form-control" name="minimum_percentage" value="<?php echo $online_exam['minimum_percentage']; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="form-group">
                           <label class="col-form-label" for=""><?php echo get_phrase('description');?></label>
                           <div class="input-group">
                              <textarea class="form-control" name="instruction" rows="5"><?php echo $online_exam['instruction']; ?></textarea>
                           </div>
                        </div>
                     </div>
                     <input type="hidden" value="<?php echo $online_exam['class_id'];?>" name="class_id">
                     <input type="hidden" value="<?php echo $online_exam['section_id'];?>" name="section_id">
                     <input type="hidden" value="<?php echo $online_exam['subject_id'];?>" name="subject_id">
                     <input type="hidden" name="online_exam_id" value="<?php echo $online_exam['online_exam_id']; ?>"/>
                     <div class="form-group">
                        <div class="col-sm-12" style="text-align: center;">
                           <button type="submit" class="btn btn-success"><?php echo get_phrase('update');?></button>
                        </div>
                     </div>
                  </div>
                  <?php echo form_close();?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>