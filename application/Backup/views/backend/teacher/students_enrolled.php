<?php 
  $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
  $info = explode('-', base64_decode($data));

  $class_id = $info[0];
  $section_id = $info[1];
  $subject_id = $info[2];

  $param_data = base64_encode($class_id.'-'.$section_id.'-'.$subject_id);
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
                            <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff; padding:10px;">
                          </div>
                          <div class="author-content">
                            <a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('enrolled_students');?>
                            <small>(<?php echo $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->name ?>)</small></a>
                            <div class="country"> <?php if($class_id > 0) echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name.' | '.$this->db->get_where('section', array('section_id' => $section_id))->row()->name?></div>
                          </div>
                        </div>
                      </div>
                      <div class="profile-section" style="background-color: #fff;">
                        <div class="control-block-button">
                          <a href="javascript:void(0);" onclick="add_student('<?php echo $class_id; ?>','<?php echo $section_id; ?>')" class="btn btn-control bg-purple" style="background:#99bf2d; color: #fff;"><i class="picons-thin-icon-thin-0151_plus_add_new" title="<?php echo get_phrase('add_irregular_students');?>"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="aec-full-message-w">
                      <div class="aec-full-message">
                        <div class="container-fluid" style="background-color: #f2f4f8;">
                          <br>
                          <input type="hidden" id="cls_id" value="<?php echo $class_id;?>">
                          <div class="col-sm-12">
                            <?php echo form_open(base_url() . 'teacher/students/', array('class' => 'form m-b'));?>
                            <div class="row">
                              <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group label-floating" style="background-color: #fff;">
                                  <label class="control-label"><?php echo get_phrase('search');?></label>
                                  <input class="form-control" id="filter" type="text" required="">
                                </div>
                              </div>
                            </div>
                            <?php echo form_close();?>
                            <div class="row">
                              <?php 
                                $students = $this->db->query("SELECT t2.`student_id`, t1.`class_id`, t1.`section_id`, t2.`last_name` FROM enroll t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN subject t3 ON t1.`class_id` = t3.`class_id` AND t1.`section_id` = t3.`section_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t3.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' AND t2.`learning_status` = '1' UNION SELECT t1.`student_id`, t3.`class_id`, t3.`section_id`, t2.`last_name` FROM tbl_students_subject t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN enroll t3 ON t2.`student_id` = t3.`student_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t1.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' ORDER BY last_name ASC");
                                
                                if($students->num_rows() > 0):
                                
                                  foreach($students->result_array() as $row2):
                              ?>  
                              <div class="col-xl-4 col-md-6">
                                <div class="card-box widget-user ui-block list">
                                  <div class="more" style="float:right;">
                                    <i class="icon-options"></i>    
                                      <!-- <ul class="more-dropdown">
                                         <li><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_estudiante/<?php echo $row2['student_id'];?>/<?php echo $class_id?>');"><?php echo get_phrase('edit');?></a></li>
                                      </ul> -->
                                    <!-- <div class="form-group">
                                      <input type="checkbox" onclick="count_check_subs();" name="id[]" class="form-control select_subs" value="<?php echo $row2['student_id'];?>" />
                                    </div> -->
                                  </div>
                                  <div>
                                    <img src="<?php echo $this->crud_model->get_image_url('student',$row2['student_id']);?>" class="img-responsive rounded-circle" alt="user">
                                    <div class="wid-u-info">
                                      <a href="<?php echo base_url();?>teacher/student_portal/<?php echo $row2['student_id'];?>/<?php echo $class_id; ?>/" class="h6 author-name">
                                        <h5 class="mt-0 m-b-5"> <?php echo $this->crud_model->get_name('student', $row2['student_id']);?></h5>
                                      </a>
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

<div class="modal fade" id="bulkstudents" tabindex="-1" role="dialog" aria-labelledby="bulkstudents" aria-hidden="true">
  <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
    <div class="modal-content">
      <?php echo form_open(base_url() . 'teacher/students_enrolled/Add/'.$param_data, array('enctype' => 'multipart/form-data'));?>
      <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
      <div class="modal-header">
        <h6 class="title"><?php echo get_phrase('add_irregular_students');?></h6>
      </div>
      <div class="modal-body">
        <div class="form-group label-floating is-select">
          <label class="control-label"><?php echo get_phrase('class');?></label>
          <div class="select">
            <select name="class_id" id="cl_id" required="" onchange="get_class_sections(this.value);">
              <option value=""><?php echo get_phrase('select');?></option>
              <?php 
                $classes = $this->db->get('class')->result_array();
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
            <select name="section_id" required="" id="section_selector" onchange="load_student_list(this.value);">
              <option value=""><?php echo get_phrase('select');?></option>
            </select>
          </div>
        </div>

        <div class="form-group label-floating is-select">
          <label class="control-label"><?php echo get_phrase('student_list');?></label>
          <div class="select">
            <select name="stud_list" required="" id="stud_list_selector">
              <option value=""><?php echo get_phrase('select');?></option>
            </select>
          </div>
        </div>

        <button type="submit" class="btn btn-rounded btn-success btn-lg full-width"><?php echo get_phrase('Save');?></button>

      <?php echo form_close();?>
    </div>
  </div>
</div>
<script type="text/javascript">
  function add_student(class_id,section_id)
  {
    $('#cl_id').val(class_id);
    $('#section_selector').val(section_id);
    get_class_sections(class_id);
    load_student_list(section_id);
    $('#bulkstudents').modal('show');
  }
</script>
<script type="text/javascript">
  function get_class_sections(class_id) 
  {
    $.ajax({
      url: '<?php echo base_url();?>teacher/get_class_section/' + class_id ,
      success: function(response)
      {
        jQuery('#section_selector').html(response);
      }
    });
  }

  function load_student_list(section_id) 
  {
    var class_id = $('#cl_id').val();
    //alert(class_id+' '+section_id);

    $.ajax({
      url: '<?php echo base_url();?>teacher/get_student_list/' + class_id + '/' + section_id,
      success: function(response)
      {
        jQuery('#stud_list_selector').html(response);
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
               window.location.href = '<?php echo base_url();?>teacher/students/'+class_id+'/';
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
  function delete_student(id) {
  
    swal({
         title: "Are you sure ?",
         text: "You want to delete this user?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete",
        closeOnConfirm: true
    },
    function(isConfirm){
  
      if (isConfirm) 
      {        
     
        $.ajax({
       
           url:"<?php echo base_url();?>admin/check_student/",
           type:'POST',
           data:{id:id},
           success:function(result)
           {
  
             if(result == 0){
               //alert('cannot be delete');
               swal('info','Student cannot be delete','info');
  
             }else{
  
                $('#results').html('<div class="col-md-12 text-center"><img src="<?php echo base_url();?>assets/images/preloader.gif" /><br><b>deleting data..</b></div>');
  
                window.location.href = '<?php echo base_url();?>admin/delete_student/' + id;
  
                //swal('success','Student can be delete','success');
             }
  
           }
  
         });
  
      } 
      else 
      {
  
      }
  
    });
  
  }
  
</script>