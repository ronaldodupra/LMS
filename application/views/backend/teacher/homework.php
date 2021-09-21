<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php $class_info = $this->db->get('class')->result_array(); ?>
<?php $info = base64_decode($data);
   $ex = explode('-', $info);
   ?>
<?php $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
   foreach($sub as $row):
   ?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="cursos cta-with-media" style="background: #<?php echo $row['color'];?>;">
         <div class="cta-content">
            <div class="user-avatar">
               <img alt="" src="<?php echo base_url();?>uploads/subject_icon/<?php echo $row['icon'];?>" style="width:60px;">
            </div>
            <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo get_phrase('activities');?></small></h3>
            <small style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"</small>
         </div>
      </div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo get_phrase('dashboard');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/online_exams/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_exams');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/online_quiz/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0678_pen_writting_fontain"></i><span><?php echo get_phrase('online_quiz');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>teacher/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('activity');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/video_link/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i><span><?php echo get_phrase('video_links');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/live_class/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo get_phrase('live_classroom');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/upload_marks/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span>Grades</span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                  <div id="newsfeed-items-grid">
                     <div class="element-wrapper">
                        <div class="element-box-tp">
                           <h5 class="element-header">
                              <?php echo get_phrase('activities');?>
                              <div style="margin-top:auto;float:right;">
                                 <a href="#" data-target="#new_homework" data-toggle="modal" class="text-white btn btn-control btn-grey-lighter btn-success mr-5">
                                    <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                    <div class="ripple-container"></div>
                                 </a>
                              </div>
                           </h5>
                           <div class="os-tabs-w">
                            <div class="os-tabs-controls">
                               <ul class="navs navs-tabs upper">
                                  <?php 
                                     $active = 0;
                                     $query = $this->db->query("SELECT * from exam ORDER BY exam_id ASC"); 
                                     if ($query->num_rows() > 0):
                                     $sections = $query->result_array();
                                     foreach ($sections as $rows): $active++;
                                     $status= $rows['status']; 
                                     $sems = explode(" ", $rows['name']);
                                  ?>
                                  <li class="navs-item">
                                     <a class="navs-links <?php if($status == 1) echo "active";?>" data-toggle="tab" href="#tab<?php echo $rows['exam_id'];?>"><?php echo $sems[0];?></a>
                                  </li>
                                  <?php endforeach;?>
                                  <?php endif;?>
                               </ul>
                            </div>
                          </div>
                           <div class="tab-content">
                              
                              <?php 
                                 //$query = $this->db->get_where('section' , array('class_id' => $class_id));
                                 $query1 = $this->db->query("SELECT * from exam ORDER BY exam_id ASC");
                                 if ($query1->num_rows() > 0):
                                 $semesters = $query1->result_array();
                                 
                                 foreach ($semesters as $row_s): 
                                 $semester_id = $row_s['exam_id'];
                                 $status= $row_s['status']; ?>
                              <div class="tab-pane <?php if($status == 1) echo "active";?>" id="tab<?php echo $row_s['exam_id'];?>">
                                 <?php //echo $row_s['exam_id'];?>
                                 <div class="table-responsive" style="margin-top: -2%;">
                                    <table class="table table-padded">
                                       <thead>
                                          <tr>
                                             <th><?php echo get_phrase('status');?></th>
                                             <th><?php echo get_phrase('title');?></th>
                                             <th><?php echo get_phrase('activity');?></th>
                                             <th><?php echo get_phrase('type');?></th>
                                             <th><?php echo get_phrase('allow_homework_deliveries');?></th>
                                             <th><?php echo get_phrase('options');?></th>
                                          </tr>
                                       </thead>
                                       <tbody id="results">
                                          <?php
                                             $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                                             $subject_id = $row['subject_id'];
                                             $class_id = $row['class_id'];
                                             
                                             $homeworks = $this->db->query("SELECT t2.`name` AS semester_name, t1.* FROM homework t1 LEFT JOIN exam t2 ON t1.`semester_id` = t2.`exam_id`
                                              where year = '$year' and subject_id = '$subject_id' and class_id = '$class_id' and section_id = $ex[1] and semester_id = '$semester_id' order by homework_id asc");
                                             if ($homeworks->num_rows() > 0):
                                             foreach($homeworks->result_array() as $hm):
                                             ?>
                                          <tr>
                                             <td>
                                                <?php if($hm['status'] == 1):?>
                                                <span class="status-pill green"></span> <span><?php echo get_phrase('published');?></span>
                                                <?php else:?>
                                                <span class="status-pill red"></span><span><?php echo get_phrase('no_published');?></span>
                                                <?php endif;?>
                                             </td>
                                             <td><span><?php echo $hm['title'];?></span></td>
                                             <td>

                                                <?php 
                                                   
                                                   $cat_id = $hm['category'];
                                                   
                                                   $category =  $this->db->query("SELECT * from tbl_act_category where id = '$cat_id'")->row()->category;

                                                   $activity_id = $hm['activity_type'];

                                                   $activity_type =  $this->db->query("SELECT * from tbl_act_type where id = '$activity_id'")->row()->activity_type;

                                                ?>

                                                <span><?php echo '<b>'.get_phrase('Category').':</b> '.$category.'<br>'.'<b>'.get_phrase('Type').':</b> '.$activity_type;?>
                                                </span>
                                             
                                             </td>
                                             <td>
                                                <?php if($hm['type'] ==1):?>
                                                <span class="badge badge-success"><?php echo get_phrase('online_text');?></span>
                                                <?php endif;?>
                                                <?php if($hm['type'] == 2):?>
                                                <span class="badge badge-info"><?php echo get_phrase('files');?></span>
                                                <?php endif;?>
                                             </td>
                                             <td><?php echo $hm['date_end'];?></td>
                                             <td class="bolder">

                                                <a href="<?php echo base_url();?>teacher/homeworkroom/<?php echo $hm['homework_code'];?>" class="btn btn-success btn-sm"> <?php echo get_phrase('details');?></a><br>

                                                <a onclick="delete_q('<?php echo $hm['homework_code']; ?>','<?php echo $data;?>')" class="btn btn-danger btn-sm" href="#"><?php echo get_phrase('delete');?></a>
                                                
                                             </td>
                                          </tr>
                                          <?php endforeach;
                                             else:?>
                                          <tr>
                                             <td colspan="5"> No data Found...</td>
                                          </tr>
                                          <?php endif;?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <?php endforeach;?>
                              <?php endif;?>
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
<div class="modal" id="new_homework" tabindex="" role="dialog" aria-labelledby="new_homework" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
      <div class="modal-content">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
         </a>
         <div class="modal-body">
            <div class="ui-block-title" style="background-color:#00579c">
               <h6 class="title" style="color:white"><?php echo get_phrase('new_activity');?></h6>
            </div>
            <div class="ui-block-content">
               <?php echo form_open(base_url() . 'teacher/homework/create/', array('enctype' => 'multipart/form-data')); ?>
               <div class="row">
                  <input type="hidden" value="<?php echo $ex[0];?>" name="class_id"/>
                  <input type="hidden" value="<?php echo $ex[1];?>" name="section_id"/>
                  <input type="hidden" value="<?php echo $ex[2];?>" name="subject_id"/>
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
                           <select name="semester_id" id="semester_id">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php $cl = $this->db->get('exam')->result_array();
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
                        <input type='text' class="datepicker-here" data-position="bottom left" data-language='en' name="date_end" data-multiple-dates-separator="/"/>
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-6 col-sm-6 col-12">
                     <div class="form-group label-floating">
                        <label class="control-label"><?php echo get_phrase('time');?></label>
                        <!-- <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                           <input type="text" required="" name="time_end" class="form-control" value="09:30">
                        </div> -->
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
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('description');?></label>
                        <!-- <textarea class="form-control" id="ckeditor1" name="description"></textarea> -->
                        <textarea class="form-control" id="mymce" name="description"></textarea>
                     </div>
                  </div>
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('file');?></label>
                        <input type="hidden" name="folder_name" id="folder_name" value="homework"/>

                        <div class="form-group text-center">

                           <span id="uploaded_image"></span>

                           <input type="file" name="file" id="file" class="inputfile inputfile-3" style="display:none"/>
                           
                           <ul>
                              <li>
                                 <a href="#"><i class="os-icon picons-thin-icon-thin-0042_attachment hide_control"></i> 
                                 <span class="hide_control" onclick="$('#file').click();"><?php echo get_phrase('upload_file');?>...</span></a>
                                 
                              </li>
                              <li><span class="hide_control os-icon picons-thin-icon-thin-0189_window_alert_notification_warning_error text-danger"></span>
                                 <small class="text-danger hide_control"> Maximum file size is 10mb.</small>
                              </li>
                           </ul>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-buttons-w text-right">
                  <center><button class="btn btn-rounded btn-success" type="submit"><?php echo get_phrase('save');?></button></center>
               </div>
               <?php echo form_close();?>        
            </div>
         </div>
      </div>
   </div>
</div>
<?php endforeach;?>
<script type="text/javascript">
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
    }
   });

}
</script>