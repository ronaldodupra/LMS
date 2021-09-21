<?php 
$login_id = $this->session->userdata('login_user_id');
?>
<style type="text/css">
    
    #show_btn{
        display: none;
    }

    #image_div:hover #show_btn{
        display: inline;
        margin-top: -5%;
    }

    .border_1px_solid{
        border-bottom:1px solid;
    }

</style>
<div class="full-chat-middle">
  <?php echo form_open(base_url() . 'student/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>
   <div class="chat -head">
      <div class="row">
         <div class="col-sm-12">
            
            <div class="form-group label-floating is-select">
               <label class="control-label"><?php echo get_phrase('receiver');?></label>
               <div class="select">
                  <select name="reciever" id="slct" required="">
                     <option value=""><?php echo get_phrase('select');?></option>
                     <optgroup label="<?php echo get_phrase('admins');?>">
                        <?php
                           $admins = $this->db->get('admin')->result_array();
                           foreach ($admins as $row):
                           ?>
                        <?php if($this->session->userdata('login_user_id') != $row['admin_id']):?>
                        <option value="admin-<?php echo $row['admin_id']; ?>" <?php if($usertype == 'admin' && $user_id == $row['admin_id']) echo 'selected';?>>
                           <?php echo $this->db->get_where('admin', array('admin_id' => $row['admin_id']))->row()->first_name." ".$this->db->get_where('admin', array('admin_id' => $row['admin_id']))->row()->last_name; ?>
                        </option>
                        <?php endif;?>
                        <?php endforeach; ?>
                     </optgroup>
                     <optgroup label="<?php echo get_phrase('teachers');?>">
                        <?php

                           $class_id = $this->db->query("SELECT t1.* FROM enroll t1 where student_id = '$login_id'")->row()->class_id;

                           $teachers = $this->db->query("SELECT t1.* FROM teacher t1
                                                                RIGHT JOIN section t2 ON t1.`teacher_id` = t2.`teacher_id`
                                                                WHERE t2.`class_id` = '$class_id' order by t1.last_name asc
                                                                ")->result_array();

                           foreach ($teachers as $row):
                           
                           ?>
                        <option value="teacher-<?php echo $row['teacher_id']; ?>" <?php if($usertype == 'teacher' && $user_id == $row['teacher_id']) echo 'selected';?>>
                           <?php echo $this->db->get_where('teacher', array('teacher_id' => $row['teacher_id']))->row()->first_name." ".$this->db->get_where('teacher', array('teacher_id' => $row['teacher_id']))->row()->last_name; ?>
                        </option>
                        <?php endforeach; ?>
                     </optgroup>
                     <optgroup label="<?php echo get_phrase('parents');?>">
                        <?php

                           $parents = $this->db->query("SELECT t1.* FROM parent t1
                                                        RIGHT JOIN student t2 ON t1.`parent_id` = t2.`parent_id`
                                                        WHERE t2.`student_id` = '$login_id'");

                        foreach ($parents->result_array() as $row):

                        if($parents->num_rows() > 0){ ?>

                            <option value="parent-<?php echo $row['parent_id']; ?>" <?php if($usertype == 'parent' && $user_id == $row['parent_id']) echo 'selected';?>>
                               <?php echo $this->db->get_where('parent', array('parent_id' => $row['parent_id']))->row()->first_name." ".$this->db->get_where('parent', array('parent_id' => $row['parent_id']))->row()->last_name; ?>
                            </option>

                        <?php }else{ ?>
                            <option disabled="" style="color:red;">No parent Found!</option>
                        <?php } ?>

                        
                        <?php endforeach; ?>
                     </optgroup>
                     <optgroup label="<?php echo get_phrase('students');?>">
                        <?php

                           $section_id = $this->db->query("SELECT t1.* FROM enroll t1 where student_id = '$login_id'")->row()->section_id;

                           $students = $this->db->query("SELECT t1.* FROM student t1
                                                        RIGHT JOIN enroll t2 ON t1.`student_id` = t2.`student_id`
                                                        WHERE t2.`section_id` = '$section_id' AND t1.`student_id` != 'login_id' order by t1.last_name asc")->result_array();

                           foreach ($students as $row):
                           ?>
                        <option value="student-<?php echo $row['student_id']; ?>" <?php if($usertype == 'student' && $user_id == $row['student_id']) echo 'selected';?>>
                           <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->first_name." ".$this->db->get_where('student', array('student_id' => $row['student_id']))->row()->last_name; ?>
                        </option>
                        <?php endforeach; ?>
                     </optgroup>
                  </select>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="chat-content-w">
      <div class="chat-content">
      </div>
   </div>
   <div class="chat-controls b-b">
      <div class="chat-input">
         <input placeholder="<?php echo get_phrase('write_message');?>..." type="text" name="message" required="">
      </div>
      <div class="chat-input-extra">

            <div class="chat-extra-actions">
                <input type="file" name="file" id="file" class="inputfile inputfile-3" style="display:none"/>
                <span id="uploaded_image"></span>
                <ul>
                    <li>
                        <a onclick="$('#file').click();" href="javascript:void"><i class="os-icon picons-thin-icon-thin-0042_attachment hide_control"></i> 
                        <span class="hide_control" ><?php echo get_phrase('send_file');?>...</span>
                        </a>
                    </li>
                    <li><span class="hide_control os-icon picons-thin-icon-thin-0189_window_alert_notification_warning_error text-danger"></span>
                    <small class="text-danger hide_control"> Maximum file size is 10mb.</small>
                    </li>
                </ul>
            </div>
            <div class="chat-btn">
                <button class="btn btn-rounded btn-primary" type="submit"><?php echo get_phrase('send');?></button>
            </div>

        </div>
   </div>
   <?php echo form_close();?>
</div>

<script type="text/javascript">
    
$(document).ready(function(){

 $("#file").change(function() {
  var name = document.getElementById("file").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg','pdf','xlsx','xls','doc','docx','ppt','pptx','accdb','one','txt','pub']) == -1) 
  {
   swal('error','Invalid File Type','error');
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 10000000)
  {
   //alert("Image File Size is very big");

   swal('error','File Size is very big atleast 10mb','error');

  }
  else
  {
   form_data.append("file", document.getElementById('file').files[0]);
   $.ajax({
    url:"<?php echo base_url(); ?>admin/upload_file_message",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('.hide_control').css('display','none');
     $('#uploaded_image').html('<center><img src="<?php echo base_url();?>assets/images/preloader.gif" /> </span> <br> Uploading...');
     $('#file').val('');
     $('#btn_publish').prop('disabled',true);
    },
    success:function(data)
    {
      $('#message_div').addClass('border_1px_solid');
      $('#btn_publish').prop('disabled',false);
      $('.hide_control').css('display','none');
      $('.view_control').css('display','inline');
     $('#uploaded_image').html(data);
    }
   });
  }
 });

});

function remove_file(){

   var file_loc = $('#file_loc').val();
   var folder_name = $('#folder_name').val();
   $.ajax({
    url:"<?php echo base_url(); ?>admin/remove_image",
    method:"POST",
    data: {file_loc:file_loc,folder_name:folder_name},
    cache: false,
    beforeSend:function(){
     $('#uploaded_image').html('<center><img src="<?php echo base_url();?>assets/images/preloader.gif" /> </span> <br> Removing file...');
     $('#file').val('');
     $('#btn_publish').prop('disabled',true);
    },   
    success:function(data)
    {  
      $('#message_div').removeClass('border_1px_solid');
       $('#btn_publish').prop('disabled',false);
      $('#uploaded_image').html("");
      $('#file').val('');
      $('.hide_control').css('display','inline');
      $('.view_control').css('display','none');
    }
   });

}

</script>