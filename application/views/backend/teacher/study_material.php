<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php $info = base64_decode($data);?>
<?php $ex = explode("-",$info);?>
<?php $class_info = $this->db->get('class')->result_array(); ?>
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
            <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo get_phrase('study_material');?></small></h3>
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
                  <a class="navs-links" href="<?php echo base_url();?>teacher/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('activity');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>teacher/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
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
                              <?php echo get_phrase('study_material');?>
                              <div style="margin-top:auto;float:right;">
                                 <a href="#" data-target="#addmaterial" data-toggle="modal" class="text-white btn btn-control btn-grey-lighter btn-success mr-5">
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
                                 <div class="table-responsive" style="margin-top: -2%;">
                                    <table class="table table-padded">
                                       <thead>
                                          <tr>
                                             <th><?php echo get_phrase('description');?></th>
                                             <th><?php echo get_phrase('file');?></th>
                                             <th><?php echo get_phrase('options');?></th>
                                          </tr>
                                       </thead>
                                       <tbody id="results">

                                          <?php

                                             $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

                                             $subject_id = $row['subject_id'];

                                             $class_id = $row['class_id'];
                                             
                                             $study_material_info = $this->db->query("SELECT t2.`name` AS semester_name, t1.* FROM document t1 LEFT JOIN exam t2 ON t1.`semester_id` = t2.`exam_id`
                                              where subject_id = '$subject_id' and class_id = '$class_id' and section_id = $ex[1] and semester_id = '$semester_id' order by document_id desc ");

                                             if ($study_material_info->num_rows() > 0):

                                             foreach($study_material_info->result_array() as $row):

                                          ?>

                                          <tr>
                                                <td><?php echo $row['description']?></td>
                                                <td class="text-left cell-with-media ">

                                                  <?php 

                                                    $test = explode('.', $row['file_name']);
                                                     $ext = strtolower(end($test));

                                                     if($ext == 'gif' or $ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'jpeg'){

                                                         $file_icon = '<i class="picons-thin-icon-thin-0082_image_photo_file" style="font-size:20px; color:gray;"></i>';
                                                         
                                                     }elseif($ext == 'doc' or $ext == 'docx'){
                                                         $file_icon = '<i class="picons-thin-icon-thin-0078_document_file_word_office_doc_text" style="font-size:20px; color:gray;"></i>';
                                                     }
                                                     elseif($ext == 'xlsx' or $ext == 'xls'){
                                                         $file_icon = '<i class="picons-thin-icon-thin-0111_folder_files_documents" style="font-size:20px; color:gray;"></i>';
                                                     }
                                                     elseif($ext == 'pdf'){
                                                         $file_icon = '<i class="picons-thin-icon-thin-0077_document_file_pdf_adobe_acrobat" style="font-size:20px; color:gray;"></i>';
                                                     }else{

                                                         $file_icon = '<i class="picons-thin-icon-thin-0111_folder_files_documents" style="font-size:20px; color:gray;"></i>';

                                                     }

                                                  ?>

                                                  <?php if($row['file_name'] <> ''){ ?>

                                                      <a download="" href="<?php echo base_url().'uploads/document/'.$row['file_name']; ?>" style="color:gray;">
                                                      <?php echo $file_icon; ?>
                                                      <?php echo $row['file_name'];?></span><span class="smaller">(<?php echo $row['filesize'];?>)</span></a>

                                                  <?php }else{ ?>

                                                    <small class="text-danger">No file Found!</small>

                                                  <?php } ?>

                                                </td>
                                                <td class="text-left bolder">

                                                  <?php if($row['file_name'] <> ''){ ?>

                                                     <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_copy_study_material/<?php echo $row['document_id'];?>')" class="btn btn-primary btn-sm"><i class="fa fa-copy" aria-hidden="true"></i> <?php echo get_phrase('copy');?></a>

                                                     <a download="" href="<?php echo base_url().'uploads/document/'.$row['file_name']; ?>" class="btn btn-info btn-sm"><i class="picons-thin-icon-thin-0121_download_file"></i>&nbsp;Download
                                                     </a>

                                                  <?php }else{ ?>

                                                     <a href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fa fa-copy" aria-hidden="true"></i> <?php echo get_phrase('copy');?></a>

                                                     <a href="javascript:void(0)" class="btn btn-info btn-sm"><i class="picons-thin-icon-thin-0121_download_file"></i>&nbsp;Download
                                                     </a>

                                                  <?php } ?>

                                                   <br>

                                                   <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_study_material/<?php echo $row['document_id']?>/<?php echo $data?>')" class="btn btn-success btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> <?php echo get_phrase('edit');?></a>

                                                   <a class="btn btn-sm btn-danger" href="#" onclick="delete_studymat('<?php echo $row['document_id']?>','<?php echo $data;?>')">
                                                     <i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i> &nbsp;Delete
                                                   </a>

                                                </td>
                                             </tr>
                                          <?php endforeach;
                                             else:?>
                                          <tr>
                                             <td colspan="3"> No data Found...</td>
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
      </div>
   </div>
</div>
<div class="modal fade" id="addmaterial" tabindex="-1" role="dialog" aria-labelledby="addmaterial" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
      <div class="modal-content">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
         </a>
         <div class="modal-body">
            <div class="ui-block-title" style="background-color:#00579c">
               <h6 class="title" style="color:white"><?php echo get_phrase('upload_study_material');?></h6>
            </div>
            <div class="ui-block-content">
               <?php echo form_open(base_url() . 'teacher/study_material/create/'.$data, array('enctype' => 'multipart/form-data')); ?>
               <div class="row">
                  <input type="hidden" value="<?php echo $ex[0];?>" name="class_id"/>
                  <input type="hidden" value="<?php echo $ex[1];?>" name="section_id"/>
                  <input type="hidden" value="<?php echo $ex[2];?>" name="subject_id"/>
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('description');?></label>
                        <textarea class="form-control" required="" rows="5" name="description"></textarea>
                     </div>
                  </div>
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group label-floating is-select">
                        <label class="control-label"><?php echo get_phrase('select_semester');?></label>
                        <div class="select">
                           <select name="semester_id" required="" id="semester_id">
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
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                    <label class="control-label"><?php echo get_phrase('file');?></label>
                    <input type="hidden" name="folder_name" id="folder_name" value="document"/>

                     <div class="form-group text-center">

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
               <div class="form-buttons-w text-right">
                  <center><button id="btn_submit_s" class="btn btn-rounded btn-success btn-lg" type="submit"><?php echo get_phrase('save');?></button></center>
               </div>
               <?php echo form_close();?>        
            </div>
         </div>
      </div>
   </div>
</div>
<?php endforeach;?>
<script type="text/javascript">

   function delete_studymat(id,data) {

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
   
         $('#results').html('<td> Deleting data... </td>');
         window.location.href = '<?php echo base_url();?>teacher/study_material/delete/' + id + '/' + data;
  
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
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg','pdf','xlsx','xls','doc','docx','ppt','pptx','accdb','one','txt','pub','rar','zip']) == -1) 
  {
   swal('error','Invalid File Type','error');
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 10000000)
  {
   swal('error','File Size is very big atleast 10mb','error');
  }
  else
  {
   form_data.append("file", document.getElementById('file').files[0]);
   $.ajax({
    url:"<?php echo base_url(); ?>admin/upload_study_material",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('.hide_control').css('display','none');
     $('#uploaded_image').html('<center><img src="<?php echo base_url();?>assets/images/preloader.gif" /> </span> <br> Uploading...');
     $('#file').val('');
     $('#btn_submit_s').prop('disabled',true);
    },
    success:function(data)
    {

     $('#uploaded_image').html(data);

      var file_size = $('#file_size').val();

      if(file_size == 'NAN B'){

        $('.hide_control').css('display','inline');
        $('.view_control').css('display','none');
        $('#btn_submit_s').prop('disabled',true);
        $('#uploaded_image').html('<small class="text-danger">Error on uploading file. Try again.</span><br>');
        $('#file_loc').val('');
        $('#file_size').val('');

      }else{

        $('.hide_control').css('display','none');
        $('.view_control').css('display','inline');
        $('#btn_submit_s').prop('disabled',false);

      }

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