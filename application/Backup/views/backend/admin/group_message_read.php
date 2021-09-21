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
   <div class="chat-head">
      <a class="back-to-index d-xl-none d-md-none megasize" href="<?php echo base_url();?>admin/group/"><i class="icon-feather-chevron-left"></i></a>          
      <div class="user-info">
         <h4><?php echo $this->db->get_where('group_message_thread', array('group_message_thread_code' => $current_message_thread_code))->row()->group_name; ?></h4>
         <a class="btn btn-success btn-sm" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/group_info/<?php echo $row['group_message_thread_code'];?>');"><?php echo get_phrase('group_members');?></a>
      </div>
   </div>
   <div class="chat-content-w mCustomScrollbar">
      <div class="chat-content">
         <?php
            $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $messages = $this->db->get_where('group_message', array('group_message_thread_code' => $current_message_thread_code))->result_array();
            foreach ($messages as $row):
            $sender = explode('-', $row['sender']);
            $sender_account_type = $sender[0];
            $sender_id = $sender[1];
            ?>
         <?php if($row['sender'] != $current_user):?>
         <?php $recievers = $row['sender'];?>
         <div class="chat-message">
            <div class="chat-message-content-w">
               <div class="chat-message-content">
                  <?php echo $row['message']; ?>
                  <?php if($row['attached_file_name'] != ""):?><br>
                  <a class="badge badge-primary" target="_blank" href="<?php echo base_url();?>uploads/group_messaging_attached_file/<?php echo $row['attached_file_name'];?>" style="color:white"><i class="picons-thin-icon-thin-0105_download_clipboard_box"></i>&nbsp;&nbsp;<?php echo $row['attached_file_name'];?></a>
                  <?php endif;?>
               </div>
            </div>
            <div class="chat-message-avatar">
               <img alt="" src="<?php echo $this->crud_model->get_image_url($sender_account_type, $sender_id); ?>">
            </div>
            <div class="chat-message-date">
               <span class="badge badge-primary"><?php echo $this->db->get_where($sender_account_type, array($sender_account_type . '_id' => $sender_id))->row()->first_name. " ".$this->db->get_where($sender_account_type, array($sender_account_type . '_id' => $sender_id))->row()->last_name; ?></span><br>
               <?php echo $row['timestamp'];?> 
            </div>
         </div>
         <?php endif;?>
         <?php if($row['sender'] == $current_user):?>
         <div class="chat-message self">
            <div class="chat-message-content-w">
               <div class="chat-message-content">
                  <?php echo $row['message']; ?>
                  <?php if($row['attached_file_name'] != ""):?><br>
                  <a class="badge badge-primary" target="_blank" href="<?php echo base_url();?>uploads/group_messaging_attached_file/<?php echo $row['attached_file_name'];?>" style="color:white"><i class="picons-thin-icon-thin-0105_download_clipboard_box"></i>&nbsp;&nbsp;<?php echo $row['attached_file_name'];?></a>
                  <?php endif;?>
               </div>
            </div>
            <div class="chat-message-date">
               <span class="badge badge-primary"><?php echo $this->db->get_where($sender_account_type, array($sender_account_type . '_id' => $sender_id))->row()->first_name. " ".$this->db->get_where($sender_account_type, array($sender_account_type . '_id' => $sender_id))->row()->last_name; ?></span>
               <br><?php echo $row['timestamp'];?> 
            </div>
            <div class="chat-message-avatar">
               <img alt="" src="<?php echo $this->crud_model->get_image_url($sender_account_type, $sender_id); ?>">
            </div>
         </div>
         <?php endif;?>
         <?php endforeach;?>
      </div>
   </div>
   <div class="chat-controls b-b">
      <?php echo form_open(base_url() . 'admin/group/send_reply/' . $current_message_thread_code, array('enctype' => 'multipart/form-data')); ?>
      <input type="hidden" name="reciever" value="<?php echo $recievers;?>">
      <div class="chat-input">
         <input placeholder="<?php echo get_phrase('write_message');?>..." required type="text" name="message">
      </div>
      <div class="chat-input-extra">
         <div class="chat-extra-actions">

        <input type="file" name="file" id="file" class="inputfile inputfile-3" style="display:none"/>
        <input type="hidden" id="folder_name" value="group_messaging_attached_file">
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

        <div class="chat-btn">
           <button class="btn btn-rounded btn-success" type="submit"><?php echo get_phrase('send');?></button>
        </div>
     </div>
      </div>
      <?php echo form_close();?>
   </div>
</div>
<div class="full-chat-right">
   <div class="user-intro">
      <div class="avatar">
         <img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="border-radius:0px;">
      </div>
      <div class="user-intro-info">
         <h5 class="user-name">
            <?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>
         </h5>
      </div>
   </div>
   <div class="chat-info-section">
      <div class="ci-header">
         <span><?php echo get_phrase('shared_files');?></span>
      </div>
      <div class="ci-content mCustomScrollbar">
         <div class="ci-file-list">
            <?php
               $this->db->where('attached_file_name !=', "");
               $this->db->where('group_message_thread_code',$current_message_thread_code);
               $files = $this->db->get('group_message');
               if($files->num_rows() > 0):
               ?>
            <ul>
               <?php foreach($files->result_array() as $file):?>
               <?php if($file['file_type'] != "png" && $file['file_type'] != "jpg" && $file['file_type'] != "JPEG" && $file['file_type'] != "GIF"):?>
               <li><a target="_blank" href="<?php echo base_url();?>uploads/group_messaging_attached_file/<?php echo $file['attached_file_name']; ?>"><?php echo $file['attached_file_name'];?></a></li>
               <?php endif;?>
               <?php endforeach;?>
            </ul>
            <?php else:?>
            <span><?php echo get_phrase('without_shared_files');?></span>
            <?php endif;?>
         </div>
      </div>
   </div>
   <div class="chat-info-section">
      <div class="ci-header">
         <span><?php echo get_phrase('shared_photos');?></span>
      </div>
      <div class="ci-content  mCustomScrollbar">
         <div class="ci-edu-list">
            <?php
               $this->db->where('attached_file_name !=', "");
               $this->db->where('group_message_thread_code',$current_message_thread_code);
               $imgs = $this->db->get('group_message');
               if($imgs->num_rows() > 0):
               ?>
            <ul class="w-last-photo js-zoom-gallery">
               <?php foreach($imgs->result_array() as $img):?>
               <?php if($img['file_type'] == "png" || $img['file_type'] == "jpg" || $img['file_type'] == "JPEG" || $img['file_type'] == "GIF"):?>
               <li>
                  <a href="<?php echo base_url();?>uploads/group_messaging_attached_file/<?php echo $img['attached_file_name']; ?>">
                  <img src="<?php echo base_url();?>uploads/group_messaging_attached_file/<?php echo $img['attached_file_name']; ?>" style="min-height: 50px; min-width: 50px; object-fit:cover;">
                  </a>
               </li>
               <?php endif;?>
               <?php endforeach;?>
            </ul>
            <?php else:?>
            <span><?php echo get_phrase('without_shared_photos');?></span>
            <?php endif;?>
         </div>
      </div>
   </div>
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
    url:"<?php echo base_url(); ?>admin/upload_file_group_message",
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