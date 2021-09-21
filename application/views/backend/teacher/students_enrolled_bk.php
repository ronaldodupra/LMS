<?php 
  $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
  $info = explode('-', base64_decode($data));

  $class_id = $info[0];
  $section_id = $info[1];
  $subject_id = $info[2];
  $exam_id = $info[3];
  
  $department_id = $this->db->query("SELECT b.`department_id` FROM subject a LEFT JOIN class b ON a.`class_id` = b.`class_id` WHERE a.`subject_id` = '$subject_id'")->row()->department_id;

  $param_data = base64_encode($class_id.'-'.$section_id.'-'.$subject_id.'-'.$exam_id);
?>
<input type="hidden" id="param" value="<?php echo $param_data; ?>">
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
                      <div class="profile-section"></div>
                    </div>
                    <div class="aec-full-message-w">
                      <div class="aec-full-message">
                        <div class="container-fluid" style="background-color: #f2f4f8;">
                          <br>
                          <input type="hidden" id="cls_id" value="<?php echo $class_id;?>">
                          <div class="col-sm-12">
                            <?php echo form_open(base_url() . 'teacher/students/', array('class' => 'form m-b'));?>
                            <div class="row">
                              <div class="col col-lg-9 col-md-9 col-sm-12 col-12">
                                <div class="form-group label-floating" style="background-color: #fff;">
                                  <label class="control-label"><?php echo get_phrase('search');?></label>
                                  <input class="form-control" id="filter" type="text" style="height:50px;" required="">
                                </div>
                              </div>
                              <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                <button type="button" class="btn btn-success" onclick="add_student('<?php echo $department_id;?>','<?php echo $class_id;?>','<?php echo $section_id;?>')"><span class="fa fa-plus fa-lg"></span> Add
                                </button>
                                <a class="btn btn-primary" target="_blank" href="<?php echo base_url();?>teacher/student_sheet_print/<?php echo $class_id?>/<?php echo $section_id?>/<?php echo $subject_id?>/<?php echo $exam_id?>" ><span class="fa fa-print fa-lg"></span> Print</a>
                                <button type="button" class="btn btn-danger" id="btn-reject" disabled="">
                                  <span class="fa fa-times fa-lg"></span> Exclude
                                </button>
                              </div>
                            </div>
                            <?php echo form_close();?>
                            <div class="row">
                              <?php
                                
                                if($department_id == 4)
                                {

                                  if ($exam_id == 5) {

                                    $students = $this->db->query("SELECT * FROM student_list_elem_hs WHERE class_id = '$class_id' AND section_id = '$section_id' AND subject_id = '$subject_id' AND status = '1' AND year = '$running_year' ");

                                  }
                                  else
                                  {

                                    $students = $this->db->query("SELECT * FROM student_list_coll WHERE subject_id = '$subject_id' AND status = '1' AND year = '$running_year'");

                                  }
                                  
                                }
                                else
                                {

                                  $students = $this->db->query("SELECT * FROM student_list_elem_hs WHERE class_id = '$class_id' AND section_id = '$section_id' AND subject_id = '$subject_id' AND year = '$running_year'");

                                }
                               
                                if($students->num_rows() > 0):
                                
                                  foreach($students->result_array() as $row2):
                              ?>
                              <div class="col-xl-4 col-md-6" id="results">
                                <div class="card-box widget-user ui-block list">
                                  <?php
                                    $stud_id = $row2['student_id'];

                                    $chk_stud_added = $this->db->query("SELECT student_id FROM tbl_students_subject WHERE student_id = '$stud_id' AND subject_id = '$subject_id'")->num_rows();
                                  ?>
                                  <?php if($chk_stud_added > 0): ?>
                                  <div class="more" style="float:right;">
                                    <i class="icon-options"></i>    
                                    <ul class="more-dropdown">
                                      <li><a href="javascript:void(0);" onclick="remove_student('<?php echo $row2['Id']; ?>','<?php echo $param_data; ?>')"><?php echo get_phrase('remove');?></a></li>
                                    </ul>
                                  </div>
                                  <?php else: ?>
                                  <div class="form-group" style="margin-bottom: 0px; margin-left: -8px; margin-top: -10px;">
                                    <input type="checkbox" onclick="count_check_subs();" name="id[]" class="form-control select_subs" value="<?php echo $row2['student_id'];?>" />
                                  </div>
                                  <?php endif; ?>
                                  <div>
                                    <img src="<?php echo $this->crud_model->get_image_url('student',$row2['student_id']);?>" class="img-responsive rounded-circle" alt="user">
                                    <div class="wid-u-info">
                                      <a class="h6 author-name"><h5 class="mt-0 m-b-5"> <?php echo $this->crud_model->get_name('student', $row2['student_id']);?></h5>
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
                              <?php endif; ?>
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
  <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document" style="width: 600px;">
    <div class="modal-content">
      <!-- <?php //echo form_open(base_url() . 'teacher/students_enrolled/Add/'.$param_data, array('enctype' => 'multipart/form-data'));?> --><!-- <?php //echo form_close();?> -->
      <form enctype="multipart/form-data" id="student_exclude" onsubmit="event.preventDefault();">
        <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
        <div class="modal-header">
          <h6 class="title"><?php echo get_phrase('add_students');?></h6>
        </div>
        <div class="modal-body">
          <?php if ($department_id == 4): ?>
          <label><?php echo get_phrase('student_lists :') ?></label>
          <div class="row">
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
              <input type="text" id="mem_id" name="mem_id">
              <div class="form-group" id="student">
                <div class="col-md-12" style="height: 400px; overflow: auto;" id="tbl_member_list"></div> 
              </div>
            </div>
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <div class="form-buttons-w text-right">
                  <center><button class="btn btn-rounded btn-success btn-lg full-width" onclick="add_subj_student('<?php echo $param_data; ?>');" type="submit"><?php echo get_phrase('add_student');?></button></center>
                </div>
              </div>
            </div>
          </div>

          <?php else: ?>

          <div class="form-group label-floating is-select">
            <div class="row">
              <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <label class="control-label"><?php echo get_phrase('class');?></label>
                <div class="select">
                  <select name="class_id" id="cl_id" required="" onchange="get_class_sections(this.value);">
                    <option value=""><?php echo get_phrase('select');?></option>
                    <?php 
                      $classes = $this->db->query("SELECT * FROM class WHERE department_id = '$department_id' ORDER BY nivel_id ASC")->result_array();
                      foreach($classes as $row):
                    ?>
                    <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                    <?php endforeach;?>
                  </select> 
                </div>
              </div>
              <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <label class="control-label"><?php echo get_phrase('section');?></label>
                <div class="select">
                  <select name="section_id" required="" id="section_selector" onchange="load_student_list(this.value);">
                    <option value=""><?php echo get_phrase('select');?></option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row" id="con_list">
            <label><?php echo get_phrase('student_lists :') ?></label>
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
              <input type="hidden" id="mem_id" name="mem_id">
              <div class="form-group" id="student">
                <div class="col-md-12" style="height: 400px; overflow: auto;" id="tbl_member_list"></div> 
              </div>
            </div>
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <div class="form-buttons-w text-right">
                  <center><button class="btn btn-rounded btn-success btn-lg full-width" onclick="add_subj_student('<?php echo $param_data; ?>');" type="submit"><?php echo get_phrase('add_student');?></button></center>
                </div>
              </div>
            </div>
          </div>

          <?php endif; ?>
        </div> 
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">

  function add_student(dept_id, class_id, section_id)
  {
    $("#con_list").hide('fast');
    if (dept_id == 4) {
      load_student_info(dept_id, class_id, section_id);
    }
    
    $('#bulkstudents').modal('show');
  }

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
    var dept_id = <?php echo $department_id; ?>;
    var class_id = $('#cl_id').val();

    $("#con_list").show('fast');
    load_student_info(dept_id, class_id, section_id)
  }

  function get_member_name(){
    var chkArray = [];
    
    /* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
    $("#tid_val input:checked").each(function() {
      chkArray.push($(this).val());
    });
    
    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join(','+' ');
    //alert(selected)
    $("#mem_id").val(selected);
  }

  function load_student_info(dept_id, cl_id, sec_id)
  {

    var mydata = 'dept_id=' + dept_id + '&c_id=' + cl_id + '&s_id=' + sec_id;

    $.ajax({
      url:"<?php echo base_url(); ?>teacher/load_student_list",
      data:mydata,
      method:"POST",
      dataType:"JSON",
      success:function(data){
        //console.log(data);
        var html='';

        if(data.length > 0){

          html += '<table class="table table-bordered table-striped" style="">';
          html += '<thead><tr>';
          html += '<th style="background-color:#00579c; color: #fff;"><?php echo get_phrase('select');?></th>';
          html += '<th style="background-color:#00579c; color: #fff;"><?php echo get_phrase('fullname');?></th>';
          html += '</tr></thead>';

          for(var count = 0; count < data.length; count++)
          {
            html += '<tr id="filter_search">';
            html += '<td width = "20%" id="tid_val"><input type="checkbox" onclick="get_member_name();" value="'+data[count].Id+'"></td>';
            html += '<td width = "80%">'+data[count].fullname+'</td>';
            html += '</tr>';
          }
          html += '</table>';

        }else{

          html += '<table class="table table-bordered table-striped" style="">';
          html += '<thead><tr>';
          html += '<th style="background-color:#99bf2d; color: #fff;"><?php echo get_phrase('select');?></th>';
          html += '<th style="background-color:#99bf2d; color: #fff;"><?php echo get_phrase('fullname');?></th>';
          html += '</tr></thead>';
          html += '<tr><td colspan="2"><center><?php echo get_phrase('no_data_found');?></center></td></tr>';
          html += '</table>';

        }

        $('#tbl_member_list').html(html);

      }
    });
  }

  function add_subj_student($param_data) {
    
    console.log($("form#student_exclude").serialize());
    
    $.ajax({
      url:'<?php echo base_url();?>teacher/students_enrolled/Add/' + $param_data,
      method:'POST',
      data:$("form#student_exclude").serialize(),
      cache:false,
      success:function(data)
      {
        //alert(data);
        if (data == 1) 
        {
          swal("LMS", "Student Successfully Added.", "success");
          setTimeout(function(){ location.reload(); }, 1000);
        }
        else
        {
          swal("LMS", "Something went wrong.", "error");
        }
      }
    });
  }

  function print_student_list() {
    
    $.ajax({
      url: '<?php echo base_url();?>teacher/tabulation_report/',
      success: function(response)
      {
        //jQuery('#section_selector').html(response);
      }
    });

  }

  $(document).ready(function(){

    $('#btn-reject').click(function(){

      swal({
        title: "Are you sure?",
         text: "You want to exclude selected students to your subject?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34464a",
        confirmButtonText: "Exclude",
        closeOnConfirm: true
      },
      function(isConfirm){

        if (isConfirm) 
        {  

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

          var class_id = <?php echo $class_id; ?>;
          var section_id = <?php echo $section_id; ?>;
          var subject_id = <?php echo $subject_id; ?>;
          var param = $('#param').val();

          $.ajax({
            url:'<?php echo base_url();?>teacher/multiple_exclude_student/',
            method:'POST',
            data:{id:id, class_id:class_id,section_id:section_id,subject_id:subject_id},
            cache:false,
            beforeSend:function(){
            // $('#results').html("<div class='text-center'><img src='<?php //echo base_url();?>assets/images/preloader.gif' /><br><b> Please wait deleting data...</b></div>");
            }, 
            success:function(data)
            {

              if(data == 404){
                
               swal("LMS", "Error on excluding data", "info");

              }else{

                swal("LMS", "Selected Data successfully excluded.", "success");
                window.location.href = '<?php echo base_url();?>teacher/students_enrolled/' + param;
                
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

  function remove_student($id, $param) {

    swal({
      title: "Are you sure?",
      text: "You want to remove this student to your list?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#8B0000",
      confirmButtonText: "Remove",
      closeOnConfirm: true
    },
    function(isConfirm){
  
      if (isConfirm) 
      {  

        var Id = $id;
        
        $.ajax({
          url:'<?php echo base_url();?>teacher/remove_student/',
          method:'POST',
          data:{Id:Id},
          cache:false, 
          success:function(data)
          {
            
            if(data == 1){

              swal("LMS", "Selected Data successfully removed.", "success");
              window.location.href = '<?php echo base_url();?>teacher/students_enrolled/' + $param;
  
            }else{
  
              swal("LMS", "Error on removing student", "info");

            }
  
          }
  
        });
  
      }

    });

  }  

</script>
