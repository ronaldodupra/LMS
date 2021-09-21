<?php $data_details = $this->db->get_where('tbl_video_link', array('link_id' => $param2))->row_array();
   ?>
<div class="modal-body">
   <div class="modal-header" style="background-color:#00579c">
      <h6 class="title" style="color:white"><?php echo get_phrase('copy_video_link_to:');?></h6>
   </div>
   <div class="ui-block-content">
      <div class="row">
         <div class="col-md-12">
            <?php //echo form_open(base_url() . 'admin/online_quiz/copy_quiz/'.$data, array('enctype' => 'multipart/form-data')); ?>
            <form enctype="multipart/form-data" id="section_update" onsubmit="event.preventDefault(); copy_data();">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="col-form-label" for=""><?php echo get_phrase('select_class_&_section');?></label>
                        <div class="select">
                           <select id="sec_id" required="" name="sec_id" onchange="subject_holder(this.value);">
                              <option value="0"><?php echo get_phrase('select');?></option>
                              <?php 
                                 $teacher_id =  $this->session->userdata('login_user_id');
                                  
                                  $class = $this->db->query("SELECT t2.`section_id`,t1.`name` AS class, t2.`name` AS section FROM class t1 LEFT JOIN section t2 ON t1.`class_id` = t2.`class_id` ORDER BY t1.`class_id` ASC")->result_array();
                                 
                                 foreach($class as $row):
                                 ?>
                              <option value="<?php echo $row['section_id'];?>"><?php echo $row['class'].' - '. $row['section'];?></option>
                              <?php endforeach;?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="col-form-label" for=""><?php echo get_phrase('select_subject');?></label>
                        <div class="select">
                           <select name="sub_id" required id="sub_holder">
                              <option value=""><?php echo get_phrase('select');?></option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="col-form-label" for=""><?php echo get_phrase('description');?></label>
                        <textarea class="form-control" rows="2" name="description"><?php echo $data_details['description'];?></textarea>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="col-form-label" for=""><?php echo get_phrase('Select Host');?></label>
                        <div class="select">
                           <select name="host_name" required="" disabled="">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php $cl = $this->db->get('tbl_hostnames')->result_array();
                                 foreach($cl as $row):
                                 ?>
                              <option value="<?php echo $row['id'];?>" <?php if($data_details['video_host_id'] == $row['id']) echo 'selected';?>><?php echo $row['hostname'];?></option>
                              <?php endforeach;?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="col-form-label"><?php echo get_phrase('select_semester');?></label>
                        <div class="select">
                           <select name="semester_id" id="semester_id">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php $ex = $this->db->get('exam')->result_array();
                                 foreach($ex as $row):
                                 ?>
                              <option value="<?php echo $row['exam_id'];?>" <?php if($data_details['semester_id'] == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                              <?php endforeach;?>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="form-group">
                     <label class="control-label"><?php echo get_phrase('instructional_video_link');?></label>
                     <input class="form-control" disabled="" name="link_name" type="text" value="<?php echo $data_details['link_name'] ?>">
                  </div>
               </div>
               <input type="hidden" name="link_id" id="link_id" value="<?php echo $param2; ?>">
               <div class="form-group">
                  <div class="col-sm-12" style="text-align: center;">
                     <button type="submit" class="btn btn-success"><?php echo get_phrase('copy');?></button>
                  </div>
               </div>
            </form>
            <?php //echo form_close();?>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   function copy_data()
   {
     $.ajax({
       url:'<?php echo base_url();?>admin/copy_video_link',
       method:'POST',
       data:$("form#section_update").serialize(),
       cache:false,
       success:function(data)
       {
         if(data == 1){
         swal("LMS", "Video Link successfully copied.", "success");
         $('#exampleModal').modal('hide');
         }else{
         swal("LMS", "Error on adding data", "error");
         } 
       }
     });
   }
   
   function subject_holder(section_id) 
   {
     $.ajax({
       url: '<?php echo base_url();?>admin/get_subjectss/' + section_id ,
       success: function(response)
       {
       $('#sub_holder').html(response);
       }
     });
   }
</script>