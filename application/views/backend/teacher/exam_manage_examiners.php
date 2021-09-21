<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php
   $online_exam_details = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();
    $class_id = $online_exam_details['class_id'];
    $section_id = $online_exam_details['section_id'];
    $running_year = $online_exam_details['running_year'];

   $students_array = $this->db->query("SELECT t1.* FROM enroll t1 
                    LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                    where t1.class_id = '$class_id' and t1.section_id = '$section_id' and t1.year = '$running_year'
                    ORDER BY t2.`sex` DESC, t2.`last_name` ASC")->result_array();

   $subject_info = $this->crud_model->get_subject_info($online_exam_details['subject_id']);
   $total_mark = $this->crud_model->get_total_mark($online_exam_id);

   $failed = $this->db->query("SELECT * from online_exam_result where online_exam_id = '$online_exam_id' and result = 'fail'")->num_rows();

   $passed = $this->db->query("SELECT * from online_exam_result where online_exam_id = '$online_exam_id' and result = 'pass'")->num_rows();

   $total_students = $this->db->query("SELECT t1.* FROM enroll t1 
                    LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                    where t1.class_id = '$class_id' and t1.section_id = '$section_id' and t1.year = '$running_year'
                    ORDER BY t2.`sex` DESC, t2.`last_name` ASC")->num_rows();

   $no_action = $total_students - $failed - $passed;

   ?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/examroom/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span><?php echo get_phrase('exam_details');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>teacher/manage_examiner/<?php echo $online_exam_id;?>/"><i class="fa fa-users fa-2x"></i><span><?php echo get_phrase('Manage_allowed_examiners');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/exam_results/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i><span><?php echo get_phrase('results');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>teacher/exam_edit/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span><?php echo get_phrase('edit');?></span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <div class="col-sm-12">
                  <div class="pipeline white lined-primary">
                     <div class="pipeline-header">
                        <h4>
                           <span class="fa fa-users"></span> <?php echo get_phrase('Manage_allowed_examiners for');?> <?php echo $online_exam_details['title']; ?>
                        </h4>
                     </div>
                     <div class="row">
                       <div class="col-sm-8">
                          <div class="form-group">
                          <input class="form-control" style="height: 17px;" id="filter" placeholder="<?php echo get_phrase('search_students');?>..." type="text" name="search_key">
                           </div>
                       </div>
                       <div class="col-sm-4">
                         <button class="btn btn-danger" id="btn_retake"><span class="fa fa-check"></span> Update</button>
                       </div>
                     </div>
                     
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

                                $query = $this->db->get_where('online_exam_result', array('online_exam_id' => $online_exam_id, 'student_id' => $row['student_id']));
                                $student_id = $row['student_id'];
                                ?>
                                 <td>
                                  <?php 

                                  $chk_student = $this->db->query("SELECT * from tbl_allowed_examiners where student_id = '$student_id' and online_exam_id = '$online_exam_id'")->num_rows();

                                  if($chk_student > 0){ ?>

                                    <input type="checkbox" checked="" onclick="count_check_subs();" name="id[]" class="select_subs" value="<?php echo $row['student_id'] ?>"/>

                                  <?php }else{ ?>
                                     <input type="checkbox" onclick="count_check_subs();" name="id[]" class="select_subs" value="<?php echo $row['student_id'] ?>"/>
                                  <?php } ?>

                                 </td>
                                 <td>
                                  <?php 
                                  $student_details = $this->crud_model->get_student_info_by_id($row['student_id']); 
                                  echo $counter.'.) &nbsp;'.$student_details['last_name'].", ".$student_details['first_name']; ?>
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
</div>
<script type="text/javascript">

   $(document).ready(function() {

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

    $('#btn_retake').click(function(){

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

          $.ajax({
            url:'<?php echo base_url();?>teacher/save_update_examiner/<?php echo $online_exam_id; ?>',
            method:'POST',
            data:{id:id},
            cache:false,
            // beforeSend:function(){
            // document.getElementById('btn_retake').disabled= true;
            // $('#results').html("<td colspan='5' class='text-center'><img src='<?php echo base_url();?>assets/images/preloader.gif' /><br><b> Please wait updating data...</b></td>");
            // },  
            success:function(data)
            {

            if(data == ''){

               swal("LMS", "Selected Data successfully updated.", "success");
               window.location.href = '<?php echo base_url();?>teacher/manage_examiner/<?php echo $online_exam_id; ?>';
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

   window.onload=function(){      
   $("#filter").keyup(function() {
   
     var filter = $(this).val(),
       count = 0;
   
     $('#results tr').each(function() {
   
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