<?php 

$teacher_id = $this->session->userdata('login_user_id');

$running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
//$semester_id = $this->db->get_where('exam' , array('status' => 1))->row()->exam_id;
$students_array = $this->db->query("SELECT t1.* FROM enroll t1 
                    LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                    where t1.class_id = '$class_id' and t1.section_id = '$section_id' and t1.year = '$running_year'
                    ORDER BY t2.`last_name` ASC")->result_array();

?>
<div class="content-w">
   <?php include 'fancy.php';?>
   <div class="header-spacer"></div>
   <div class="conty">
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                    <a class="navs-links active" href="<?php echo base_url();?>admin/manage_examiner_admin/"><i class="fa fa-users fa-2x"></i><span> Manage Allow Examiners</span></a> 
                    <?php //echo $class_id.' = '.$section_id.' '. $semester_id ?>
                </li>
            </ul>
         </div>
      </div>
      <input type="hidden" value="<?php echo $class_id; ?>" id="c_id" name="c_id">
      <div class="content-i">
         <div class="content-box">
            <div class="col-sm-12">
               <div class="row">
                  <div class="col-sm-12">
                     
                    <?php echo form_open(base_url() . 'teacher/manage_examiner_adviser/', array('class' => 'form m-b'));?>
                     <input type="hidden" value="<?php echo $section_id; ?>" id="sec_id" name="sec_id">
                      <div class="row">
                         <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                               <label class="control-label"><?php echo get_phrase('filter_by_class');?></label>
                               <div class="select">
                                  <select name="class_id" id="slct" required="" onchange="class_holder(this.value);">
                                    <option selected="" value="">Select Class</option>
                                     <?php 

                                     //$cl = $this->db->get('class')->result_array();
                                     
                                     $cl = $this->db->query("SELECT t1.`class_id`,t1.`name` FROM class t1
                                        LEFT JOIN section t2 ON t1.`class_id` = t2.`class_id`
                                        WHERE t2.`teacher_id` = '$teacher_id'")->result_array();

                                        foreach($cl as $row):
                                        ?>
                                     <option value="<?php echo $row['class_id'];?>" <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                     <?php endforeach;?>
                                  </select>
                               </div>
                            </div>
                         </div>
                         <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                               <label class="control-label"><?php echo get_phrase('select_section');?></label>
                               <div class="select">
                                  <select name="section_id" id="section_id" required="">
                                     
                                  </select>
                               </div>
                            </div>
                         </div>
                         <div class="col col-lg-2 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                               <label class="control-label"><?php echo get_phrase('semester');?></label>
                               <div class="select">
                                  <select name="semester_id" id="semester_id" required="">
                                    <option selected="" value="">Select Semester</option>
                                     <?php $exam = $this->db->get('exam')->result_array();
                                        foreach($exam as $row):
                                        ?>
                                     <option value="<?php echo $row['exam_id'];?>" <?php if($semester_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                     <?php endforeach;?>
                                  </select>
                               </div>
                            </div>
                         </div>
                         <div class="col col-lg-2 col-md-6 col-sm-12 col-12">
                            <button class="btn btn-lg btn-primary"><span class="fa fa-filter"></span> Search</button>
                         </div>
                         <?php echo form_close();?>
                         <div class="col col-lg-2 col-md-6 col-sm-12 col-12">
                            <span class="btn btn-success btn-lg float-right" id="btn_update"><span class="fa fa-check-circle"></span> Update</span>
                         </div>
                      </div>
                     
                  </div>
                 
                  <div class="col-sm-12">
                     
                    <div class="table-responsive">

                        <table class="table table-lightborder table-striped table-hover">
                          <thead class="table-dark">
                              <tr>
                                 <th>
                                    <div class="form-inline">
                                      <input type="checkbox" class="form-control" name="chk_subs" id="chk_subs" title="Check All">
                                    </div>
                                 </th>
                                 <th><?php echo get_phrase('student');?></th>
                                 <th><?php echo get_phrase('Contact');?></th>
                                 <th><?php echo get_phrase('address');?></th>
                                 <th><?php echo get_phrase('member_since');?></th>
                              </tr>
                           </thead>
                           
                           <tbody id="results">
                              <?php $counter = 0;  foreach ($students_array as $row): $counter++;?>
                              <tr>
                                <?php   

                                $student_id = $row['student_id'];
                                ?>
                                 <td>
                                  <?php 

                                  $chk_student = $this->db->query("SELECT * from tbl_allowed_examiners where student_id = '$student_id' and semester_id = '$semester_id' and class_id = '$class_id' and section_id = '$section_id'")->num_rows();

                                  if($chk_student > 0){ ?>

                                    <input type="checkbox" checked="" onclick="count_check_subs();" name="id[]" class="select_subs" value="<?php echo $row['student_id'] ?>"/>

                                  <?php }else{ ?>
                                     <input type="checkbox" onclick="count_check_subs();" name="id[]" class="select_subs" value="<?php echo $row['student_id'] ?>"/>
                                  <?php } ?>

                                 </td>
                                 <td>
                                  <?php 
                                  $student_details = $this->crud_model->get_student_info_by_id($row['student_id']); 
                                  echo $counter.'.) &nbsp;'.strtoupper($student_details['last_name'].", ".$student_details['first_name']); ?>
                                 </td>
                                 <td>
                                  <?php echo $student_details['phone'];?>
                                 </td>
                                 <td>
                                  <?php echo $student_details['address'];?>
                                 </td>
                                 <td>
                                  <?php echo $student_details['since'];?>
                                 </td>

                              </tr>
                              <?php endforeach; ?>
                           </tbody>
                        </table>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <a class="back-to-top" href="javascript:void(0);">
    <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
   </a>
</div>

<script type="text/javascript">

  function class_holder(class_id) 
  {
    
    $.ajax({
      url: '<?php echo base_url();?>teacher/get_sectionss_examiner/' + class_id,
      success: function(response)
      {
        $('#section_id').html(response);
      }
    });
  }

  function load_selected_section(){

    var section_id = $('#sec_id').val();
    var class_id = $('#c_id').val();

    var mydata = 'class_id=' + class_id + '&section_id=' + section_id;

    $.ajax({
      url: '<?php echo base_url();?>teacher/selected_section_examiner',
      data:mydata,
      method:"POST",
      cache:false,
      success: function(data)
      {
        //alert(data);
        $('#section_id').html(data);
      }
    });

  }

  $(document).ready(function() {

    load_selected_section();

    $("#chk_subs").change(function() {
        if (this.checked) {
            $(".select_subs").each(function() {
                this.checked=true;
            });
        } else {
            $(".select_subs").each(function() {
                this.checked=false;
            });
        }
    });

    $(".select_subs").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".select_subs").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#chk_subs").prop("checked", true);
            }     
        }
        else {
            $("#chk_subs").prop("checked", false);
        }
    });
});

$(document).ready(function(){
   
    $('#btn_update').click(function(){
   
      swal({
        title: "Are you sure?",
        text: "You want to allow selected data to take exam?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e65252",
        confirmButtonText: "Yes",
        closeOnConfirm: true
      },
      function(isConfirm){
   
        if(isConfirm) 
        {  
   
          var id = [];
          var user_type = [];
          // var user_type = [];
          $(':checkbox:checked').each(function(i){
              id[i] = $(this).val();
              //user_type[i] = $(this).attr("id");
          });
          
          var semester_id = $('#semester_id').val();
          var class_id = $('#slct').val();
          var section_id = $('#section_id').val();

          $.ajax({
            url:'<?php echo base_url();?>teacher/save_update_examiner_adviser',
            method:'POST',
            data:{id:id,semester_id:semester_id,class_id:class_id,section_id:section_id},
            cache:false,
            success:function(data)
            {
   
            if(data == ''){
   
               swal("LMS", "Selected Data successfully updated.", "success");
               //window.location.href = '<?php echo base_url();?>teacher/manage_examiner_adviser';
            }else{
              swal("LMS", "Error on updating data", "info");
            }
   
            }
   
          });
          
   
        }else{
   
        }
   
      });
   
    });
   
   });

</script>