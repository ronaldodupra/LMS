<?php 
  $dept = $this->db->query("SELECT b.`department_id` FROM subject a LEFT JOIN class b ON a.`class_id` = b.`class_id` WHERE a.`subject_id` = '$subject_id'")->row()->department_id;
  
  if ($dept == 1 OR $dept == 2) {
    $categ = 1;
  }
  elseif ($dept == 3 OR $dept == 4) {
    $categ = 2;
  }
?>
<div class="content-w">
  <div class="conty">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
      <div class="content-box">
        <div class="row">
          <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
            <div id="newsfeed-items-grid">
              <div class="element-wrapper">
                <div class="element-box-tp">
                  <h5 class="element-header">
                    <?php echo get_phrase('add_activity');?>
                  </h5>
                  <div class="ui-block-content" style="background: #fff;">
                    <form enctype="multipart/form-data" id="form_activity" onsubmit="event.preventDefault(); save_activity();">
                      <input type="hidden" id="activity_data" value="<?php echo base64_encode($class_id.'-'.$section_id.'-'.$subject_id) ?>">
                      <input type="hidden" value="<?php echo $class_id; ?>" name="class_id" id="class_id">
                      <input type="hidden" name="section_id" value="<?php echo $section_id;?>">
                      <input type="hidden" name="subject_id" value="<?php echo $subject_id;?>">
                      <div class="row">
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                          <div class="form-group label-floating">
                            <label class="control-label"><?php echo get_phrase('title');?></label>
                            <input class="form-control" name="title" type="text" required="">
                          </div>
                        </div>
                        <div class="col col-lg-4 col-md-12 col-sm-12 col-12">
                          <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('select_semester');?></label>
                            <div class="select">
                              <select name="semester_id" id="semester_id" required="">
                                <option value=""><?php echo get_phrase('select');?></option>
                                <?php $cl = $this->db->query("SELECT * FROM exam")->result_array();
                                  foreach($cl as $row):
                                  ?>
                                <option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
                                <?php endforeach;?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col col-lg-4 col-md-12 col-sm-12 col-12">
                          <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('select_category');?></label>
                            <div class="select">
                              <select name="category" id="category">
                                <option value=""><?php echo get_phrase('select');?></option>
                                <?php $cl = $this->db->get('tbl_act_category')->result_array();
                                  foreach($cl as $row):
                                  ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['category'];?></option>
                                <?php endforeach;?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col col-lg-4 col-md-12 col-sm-12 col-12">
                          <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('select_activity_type');?></label>
                            <div class="select">
                              <select name="activity_type" required="" id="activity_type">
                                <option value=""><?php echo get_phrase('select');?></option>
                                <?php $cl = $this->db->get('tbl_act_type')->result_array();
                                  foreach($cl as $row):
                                  ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['activity_type'];?></option>
                                <?php endforeach;?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                          <label class="control-label"><?php echo get_phrase('type');?></label>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-6 col-6">
                          <center>
                            <div class="custom-control custom-radio" style="float: right">
                              <input  type="radio" checked="" name="type" id="1" value="1" class="custom-control-input"> <label for="1" class="custom-control-label"><?php echo get_phrase('online_text');?></label>
                            </div>
                          </center>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-6 col-6">
                          <div class="custom-control custom-radio">
                            <input  type="radio" name="type" id="2" value="2" class="custom-control-input"> <label for="2" class="custom-control-label"><?php echo get_phrase('file');?></label>
                          </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-6 col-12">
                          <div class="form-group label-floating">
                            <label class="control-label"><?php echo get_phrase('date');?></label>
                            <input type='text' required="" class="datepicker-here" data-position="bottom left" data-language='en' name="date_end" data-multiple-dates-separator="/"/>
                          </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-6 col-12">
                          <div class="form-group label-floating">
                            <label class="control-label"><?php echo get_phrase('time');?></label>
                            <input type="time" required="" name="time_end" class="form-control" value="08:00">
                          </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                          <div class="description-toggle">
                            <div class="description-toggle-content">
                              <div class="h6"><?php echo get_phrase('show_students');?></div>
                              <p><?php echo get_phrase('show_message');?></p>
                            </div>
                            <div class="togglebutton">
                              <label><input name="status" value="1" type="checkbox"></label>
                            </div>
                          </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12" id="activity_form">
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                          <div class="form-group">
                            <label class="control-label"><?php echo get_phrase('file');?></label>
                            <input type="hidden" name="folder_name" id="folder_name" value="homework"/>
                            <div class="form-group text-center">
                              <div align='center' class="col-md-12 col-sm-12" id="load_viewer"></div>
                              <span id="uploaded_image"></span>
                              <input type="file" name="file" id="file" class="inputfile inputfile-3" style="display:none"/>
                              <ul>
                                <li>
                                  <a href="javascript:void(0);"><i class="os-icon picons-thin-icon-thin-0042_attachment hide_control"></i> 
                                  <span class="hide_control" onclick="$('#file').click();"><?php echo get_phrase('upload_file');?>...</span></a>
                                </li>
                                <li><span class="hide_control os-icon picons-thin-icon-thin-0189_window_alert_notification_warning_error text-danger"></span>
                                  <small class="text-danger hide_control"> Maximum file size is 10mb.</small>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                          <button class="btn btn-rounded btn-success" id="btn_submit" type="submit"><?php echo get_phrase('save activity');?></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
      <a class="back-to-top" href="#">
      <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
      </a>
    </div>
  </div>
</div>
<script type="text/javascript">
  function save_activity(){
  
  var activity_data = $('#activity_data').val();
    
    console.log($("form#form_activity").serialize());

    $.ajax({
  
        url:'<?php echo base_url();?>teacher/homework/create/',
        method:'POST',
        data:$("form#form_activity").serialize(),
        cache:false,
        beforeSend:function(){
          $('#btn_submit').html('Saving data... <span class="fa fa-spin fa-spinner"></span>');
          $('#btn_submit').prop('disabled',true);
        },
        success:function(data)
        {
          window.location.href = '<?php echo base_url();?>teacher/homework/' + activity_data;
        }
  
      });
  
  }
  
   $(document).ready(function() 
    {
      $.ajax({
              url: '<?php echo base_url();?>teacher/load_homework_form_froala/'
          }).done(function(response) {
              $('#activity_form').html(response);
          });
    });
  
   function delete_q(id,data) {
   
     swal({
          title: "Are you sure ?",
          text: "You want to delete this data?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#e65252",
         confirmButtonText: "Yes, delete",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
         
          $.ajax({
        
            url:"<?php echo base_url();?>admin/check_homework/",
            type:'POST',
            data:{id:id},
            success:function(result)
            {
  
              if(result == 0){
                //alert('cannot be delete');
                swal('info','Homework cannot be delete','info');
  
              }else{
  
                 $('#results').html('<td colspan="5"> Deleting data... </td>');
                 window.location.href = '<?php echo base_url(); ?>teacher/homework/delete/' + id + '/' + data;
  
              }
  
            }
  
          });
  
       } 
       else 
       {
   
       }
   
     });
   
   }
  
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
    url:"<?php echo base_url(); ?>admin/upload_homework",
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
      $('#btn_publish').prop('disabled',false);
      $('.hide_control').css('display','none');
      $('.view_control').css('display','inline');
      $('#uploaded_image').html(data);
      
      // //alert(file_name);
      // var file_name  = $('#file_loc').val();
      // var file_ext = $('#file_ext').val();
  
      // if(file_ext == 'gif' || file_ext == 'png' || file_ext == 'jpg' || file_ext == 'jpeg' || file_ext == 'jpeg'){
        
      //   $('#load_viewer').css('display','none');
  
      // }else{
  
      //   $('#load_viewer').css('display','inline');
      //   $('#load_viewer').html('<iframe width="70%"" height="1020" align="top" style="border: none;" src="https://docs.google.com/viewerng/viewer?url=https://nelac-lms.online/uploads/homework/'+file_name+'&amp;embedded=true"></iframe>');
  
      // }
      
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
       $('#btn_publish').prop('disabled',false);
      $('#uploaded_image').html("");
      $('#file').val('');
      $('.hide_control').css('display','inline');
      $('.view_control').css('display','none');
      $('#load_viewer').html('');
    }
   });
  
  }
</script>