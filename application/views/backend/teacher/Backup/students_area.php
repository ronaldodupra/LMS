<?php 
   $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
   $teacher_id = $this->session->userdata('login_user_id');
   $chk_advisory = $this->db->query("SELECT * FROM teacher WHERE teacher_id = '$teacher_id'")->row()->teaching_status;

   $teacher_section = $this->db->get_where('section', array('teacher_id' => $teacher_id))->row()->section_id;
?>
<div class="content-w">
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
                                       <div class="author-content">
                                          <a href="javascript:void(0);" class="h3 author-name">
                                          <?php echo get_phrase('students_list');?> <small></small></a>
                                          <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="profile-section" style="background-color: #fff;">
                                    <div class="control-block-button">
                                       <?php if($chk_advisory == 1 || $chk_advisory == 2):?> 
                                       <a data-toggle="modal" onclick="add_student('<?php echo $class_id;?>')" class="btn btn-control bg-purple" style="background:#0084ff; color: #fff;">
                                          <i class="picons-thin-icon-thin-0089_upload_file" title="<?php echo get_phrase('upload_from_excel');?>"></i>
                                          <!-- data-target="#bulkstudents" href="javascript:void(0);" -->
                                       </a>
                                       <a href="javascript:void(0);" onclick="export_student('<?php echo $class_id;?>')" class="btn btn-control bg-purple" style="background:#99bf2d; color: #fff;">
                                          <i class="picons-thin-icon-thin-0129_download" title="<?php echo get_phrase('export_students');?>"></i>
                                          <!--data-toggle="modal" data-target="#student_export"-->
                                       </a>
                                       <?php endif; ?>
                                    </div>
                                 </div>
                              </div>

                              <div class="aec-full-message-w">
                                 <div class="aec-full-message">
                                    <div class="container-fluid" style="background-color: #f2f4f8;">
                                       <br>
                                       <div class="row">
                                          <?php if($chk_advisory == 1 || $chk_advisory == 2):?>
                                          <div class="col col-lg-10 col-md-10 col-sm-12 col-12">
                                             <?php echo form_open(base_url() . 'teacher/students_area/', array('class' => 'form m-b'));?>
                                             <div class="form-group label-floating" style="background-color: #fff;">
                                                <label class="control-label"><?php echo get_phrase('search_students');?></label>
                                                <input class="form-control" name="last_name"  id="filter" type="text" required="">
                                             </div>
                                             <?php echo form_close();?>
                                          </div>
                                          <div class="col col-lg-2 col-md-2 col-sm-12 col-12">
                                             <button type="button" class="btn btn-danger" id="btn-reject" disabled="">
                                             <span class="fa fa-trash fa-lg"></span> Delete
                                             </button>
                                          </div>
                                          <?php else: ?>
                                          <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                             <?php echo form_open(base_url() . 'teacher/students_area/', array('class' => 'form m-b'));?>
                                             <div class="form-group label-floating" style="background-color: #fff;">
                                                <label class="control-label"><?php echo get_phrase('search_students');?></label>
                                                <input class="form-control" name="last_name"  id="filter" type="text" required="">
                                             </div>
                                             <?php echo form_close();?>
                                          </div>
                                          <?php endif; ?>
                                       </div>
                                       <div class="col-sm-12">
                                          <div class="os-tabs-w">
                                             <div class="os-tabs-controls">
                                                <ul class="navs navs-tabs upper">
                                                   <?php 
                                                      $active = 0;
                                                      $query = $this->db->query("SELECT t2.`class_id`, t2.`name` AS class, t3.`section_id`, t3.`name` FROM subject t1 LEFT JOIN class t2 ON t1.`class_id` = t2.`class_id` LEFT JOIN section t3 ON t1.`section_id` = t3.`section_id` WHERE t1.`teacher_id` = '$teacher_id' GROUP BY section_id ORDER BY class_id ASC");

                                                      if ($query->num_rows() > 0):
                                                      $sections = $query->result_array();
                                                      foreach ($sections as $rows): $active++;
                                                   ?>
                                                   <li class="navs-item">
                                                      <a class="navs-links <?php if($active == 1) echo "active";?>" data-toggle="tab" href="#tab<?php echo $rows['section_id'];?>"> <?php echo $rows['name'];?></a>
                                                   </li>
                                                   <?php endforeach;?>
                                                   <?php endif;?>
                                                </ul>
                                             </div>
                                          </div>

                                          <div class="tab-content" id="results">
                                             <?php 
                                                $query = $this->db->query("SELECT t2.`class_id`, t2.`name` AS class, t3.`section_id`, t3.`name` FROM subject t1 LEFT JOIN class t2 ON t1.`class_id` = t2.`class_id` LEFT JOIN section t3 ON t1.`section_id` = t3.`section_id` WHERE t1.`teacher_id` = '$teacher_id' GROUP BY section_id ORDER BY class_id ASC");

                                                if ($query->num_rows() > 0):
                                                   $active2 = 0;
                                                   $sections = $query->result_array();
                                                   foreach ($sections as $row): 
                                                   $active2++;
                                             ?>
                                             <div class="tab-pane <?php if($active2 == 1) echo "active";?>" id="tab<?php echo $row['section_id'];?>">
                                                <?php if ($row['section_id'] == $teacher_section): ?>
                                                <div class="form-group">
                                                   <input type="checkbox" class="form-control" name="chk_subs" id="chk_subs" onclick="check_all_subs();">
                                                   <small style="display: inline;">Check All</small>
                                                </div>
                                                <?php endif ?>
                                                <div class="row">
                                                   <?php 
                                                      $class_id = $row['class_id'];
                                                      $section_id = $row['section_id'];

                                                      $students = $this->db->query("SELECT t1.* FROM enroll t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t1.`year` = '$running_year' ORDER BY t2.`last_name` ASC");
                                                      
                                                      if($students->num_rows() > 0):
                                                       
                                                         foreach($students->result_array() as $row2):
                                                   ?>  
                                                   <div class="col-xl-4 col-md-6">
                                                      <div class="card-box widget-user ui-block list">
                                                         <?php if ($row2['section_id'] == $teacher_section): ?>
                                                         <div class="form-group" style="margin-bottom: 0px; margin-left: -8px; margin-top: -10px;">
                                                            <input type="checkbox" onclick="count_check_subs();" name="id[]" class="form-control select_subs" value="<?php echo $row2['student_id'];?>" />
                                                         </div>
                                                         
                                                         <div class="more" style="float:right;">
                                                            <i class="icon-options"></i>
                                                            <ul class="more-dropdown">
                                                               <li><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_estudiante/<?php echo $row2['student_id'];?>/<?php echo $class_id?>');"><?php echo get_phrase('edit');?></a></li>
                                                               <li><a href="<?php echo base_url();?>teacher/view_marks/<?php echo $row2['student_id'];?>"><?php echo get_phrase('marks');?></a></li>
                                                            </ul>
                                                         </div>
                                                         <?php else: ?>
                                                         <div class="more" style="float:right;">
                                                            <i class="icon-options"></i>
                                                            <ul class="more-dropdown">
                                                               <li><a href="<?php echo base_url();?>teacher/view_marks/<?php echo $row2['student_id'];?>"><?php echo get_phrase('marks');?></a></li>
                                                            </ul>
                                                         </div>
                                                         <?php endif; ?>
                                                         <div>
                                                            <img src="<?php echo $this->crud_model->get_image_url('student',$row2['student_id']);?>" class="img-responsive rounded-circle" alt="user">
                                                            <div class="wid-u-info">
                                                               <?php if ($row2['section_id'] == $teacher_section): ?>
                                                                  <a href="<?php echo base_url();?>teacher/student_portal/<?php echo $row2['student_id'];?>/<?php echo $class_id ?>/" class="h6 author-name">
                                                                  <h5 class="mt-0 m-b-5"> <?php echo $this->crud_model->get_name('student', $row2['student_id']);?></h5></a>
                                                               <?php else: ?>
                                                                  <h5 class="mt-0 m-b-5"> <?php echo $this->crud_model->get_name('student', $row2['student_id']);?></h5>
                                                               <?php endif; ?>
                                                              
                                                               <p class="text-muted m-b-5 font-13"><b><i class="picons-thin-icon-thin-0291_phone_mobile_contact"></i></b> <?php echo $this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->phone;?><br>
                                                                  <b><i class="picons-thin-icon-thin-0321_email_mail_post_at"></i></b> <?php echo $this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->email;?><br>
                                                                  <b><i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i></b> <span class="badge badge-primary" style="font-size:10px;"><?php echo $this->db->get_where('class', array('class_id' => $row2['class_id']))->row()->name;?> - <?php echo $this->db->get_where('section', array('section_id' => $row2['section_id']))->row()->name;?></span>
                                                               </p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <?php endforeach;?>
                                                   <?php else:?>
                                                   <div class="col-xl-12 col-md-12 bg-white">
                                                      <center><img src="<?php echo base_url();?>uploads/empty.png"></center>
                                                   </div>
                                                   <?php endif;?>
                                                </div>
                                             </div>
                                             <?php endforeach;?>
                                             <?php endif;?>
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
         </div>
         <div class="display-type"></div>
      </div>
   </div>
</div>

<div class="modal fade" id="student_export" tabindex="-1" role="dialog" aria-labelledby="student_export" aria-hidden="true" style="margin-top: 150px;">
   <div class="modal-dialog window-popup edit-widget edit-widget-twitter" role="document">
      <div class="modal-content">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-header" style="background-color:#00579c">
            <h6 class="title" style="color:white"><?php echo get_phrase('export_students');?></h6>
         </div>
         <div class="modal-body">
            <?php echo form_open(base_url() . 'admin/student_teacher/excel' , array('enctype' => 'multipart/form-data'));?>
            <div class="form-group label-floating is-select">
               <label class="control-label"><?php echo get_phrase('class');?></label>
               <div class="select">
                  <select name="class_id" id="cl_id" required="" onchange="get_class_sections(this.value);">
                     <option value=""><?php echo get_phrase('select');?></option>
                     <?php $classes = $this->db->get('class')->result_array();
                        foreach($classes as $row):
                        ?>
                     <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                     <?php endforeach;?>
                  </select>
               </div>
            </div>
            <div class="form-group label-floating is-select">
               <label class="control-label"><?php echo get_phrase('section');?></label>
               <div class="select">
                  <select name="section_id" required="" id="section_selector_holder">
                     <option value=""><?php echo get_phrase('select');?></option>
                  </select>
               </div>
            </div>
            <button class="btn btn-rounded btn-purple  btn-icon-left" type="submit"><i class="picons-thin-icon-thin-0129_download"></i> <?php echo get_phrase('export');?></button></center>
            <?php echo form_close();?>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="bulkstudents" tabindex="-1" role="dialog" aria-labelledby="bulkstudents" aria-hidden="true">
   <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
      <div class="modal-content">
         <?php echo form_open(base_url() . 'admin/student_teacher/bulk/'.$class_id , array('enctype' => 'multipart/form-data'));?>
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-header">
            <h6 class="title"><?php echo get_phrase('upload_students');?></h6>
         </div>
         <div class="modal-body">
            <div class="form-group label-floating is-select">
               <label class="control-label"><?php echo get_phrase('department');?></label>
               <div class="select">
                  <select name="department_id" required="">
                     <option value=""><?php echo get_phrase('select');?></option>
                     <?php $classes = $this->db->get('tbl_department')->result_array();
                        foreach($classes as $row):
                        ?>
                     <option value="<?php echo $row['Id'];?>"><?php echo $row['name'];?></option>
                     <?php endforeach;?>
                  </select>
               </div>
            </div>
            <div class="form-group label-floating is-select">
               <label class="control-label"><?php echo get_phrase('class');?></label>
               <div class="select">
                  <select name="class_id" id="cl_id2" required="" onchange="get_class_sections2(this.value);">
                     <option value=""><?php echo get_phrase('select');?></option>
                     <?php $classes = $this->db->get('class')->result_array();
                        foreach($classes as $row):
                        ?>
                     <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                     <?php endforeach;?>
                  </select>
               </div>
            </div>
            <div class="form-group label-floating is-select">
               <label class="control-label"><?php echo get_phrase('section');?></label>
               <div class="select">
                  <select name="section_id" required="" id="section_selector_holder2">
                     <option value=""><?php echo get_phrase('select');?></option>
                  </select>
               </div>
            </div>
            <div class="form-group with-button">
               <a href="<?php echo base_url();?>uploads/templates/students.xlsx"><input class="form-control " readonly value="<?php echo get_phrase('download_template');?>" type="text" style="cursor: default; color:#000: font-weight:bold">
               <button class="bg-primary"><i class="icon-feather-download"></i></button></a>
            </div>
            <div class="form-group">
               <input type="file" class="form-control" name="upload_student" required="">
            </div>
            <button type="submit" class="btn btn-rounded btn-success btn-lg full-width"><?php echo get_phrase('upload');?></button>
         </div>
         <?php echo form_close();?>
      </div>
   </div>
</div>

<script type="text/javascript">
   window.onload=function(){      
      $("#filter").keyup(function() {
      
        var filter = $(this).val(),
          count = 0;
      
        $('#results div').each(function() {
      
          if ($(this).text().search(new RegExp(filter, "i")) < 0) {
            $(this).hide();
      
          } else {
            $(this).show();
            count++;
          }
        });
      });
   }
</script>
<script type="text/javascript">
   function add_student(class_id)
   {
      $('#cl_id2').val(class_id);
      get_class_sections2(class_id);
      $('#bulkstudents').modal('show');
   }
   
</script>
<script type="text/javascript">
   function export_student(class_id)
   {
      $('#cl_id').val(class_id);
      get_class_sections(class_id);
      $('#student_export').modal('show');
   }
   
</script>
<script type="text/javascript">
   function get_class_sections(class_id) 
   {
       $.ajax({
           url: '<?php echo base_url();?>teacher/get_class_section/' + class_id ,
           success: function(response)
           {
               jQuery('#section_selector_holder').html(response);
           }
       });
   }
</script>
<script type="text/javascript">
   function get_class_sections2(class_id) 
   {
       $.ajax({
           url: '<?php echo base_url();?>teacher/get_class_section/' + class_id ,
           success: function(response)
           {
               jQuery('#section_selector_holder2').html(response);
           }
       });
   }
</script>
<script type="text/javascript">
   function count_check_subs(){
      var chks = $('.select_subs').filter(':checked').length
   
      if(chks > 0){
         document.getElementById('btn-reject').disabled= false;
      }else{
         document.getElementById('btn-reject').disabled= true;
      }
   }
   
   function check_all_subs() {
      if (document.getElementById('chk_subs').checked) {
         document.getElementById('btn-reject').disabled= false;
      } else {
         document.getElementById('btn-reject').disabled= true;
      }
   }
   
   $(document).ready(function(){
   
      $("#chk_subs").change(function(){
   
        if(this.checked){
          $(".select_subs").each(function(){
            this.checked=true;
          })       
        }else{
          $(".select_subs").each(function(){
            this.checked=false;
          })              
        }
      });
   
    $('#btn-reject').click(function(){
   
      swal({
        title: "Are you sure?",
        text: "You want to delete selected data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34464a",
        confirmButtonText: "Delete",
        closeOnConfirm: true
      },
      function(isConfirm){
   
        if (isConfirm) 
        {  
         var class_id = $('#cls_id').val();
         var id = [];
        // var user_type = [];
        $(':checkbox:checked').each(function(i){
            id[i] = $(this).val();
        });
   
        if(id.length === 0) //tell you if the array is empty
        {
          swal("LMS", "Please select atleast one user", "info");
        }
        else
        {
   
          $.ajax({
            url:'<?php echo base_url();?>teacher/delete_multiple_student/',
            method:'POST',
            data:{id:id},
            cache:false,
            beforeSend:function(){
            $('#results').html("<div class='text-center'><img src='<?php echo base_url();?>assets/images/preloader.gif' /><br><b> Please wait deleting data...</b></div>");
            }, 
            success:function(data)
            {
   
               if(data == 404){
                
                  swal("LMS", "Error on rejecting data", "info");
   
               }else{
   
                  swal("LMS", "Selected Data successfully deleted.", "success");
                  window.location.href = '<?php echo base_url();?>teacher/students_area/';
                  // setTimeout(function(){   
                  //      window.location.href = '<?php echo base_url();?>admin/pending';
                  //      },1000);
   
                  // $('#chk_subs').prop('checked',false);
                  // document.getElementById('btn-accept').disabled= true;
                  // document.getElementById('btn-reject').disabled= true;
                  // load_pending_users();
               }
   
            }
   
          });
   
        }
   
        }
   
      });
   
    });
   
   });
   
</script>