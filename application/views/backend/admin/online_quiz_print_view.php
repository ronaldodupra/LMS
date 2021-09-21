<?php
   
   $system_name        =   $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
   $system_email       =   $this->db->get_where('settings' , array('type'=>'system_email'))->row()->description;
   $running_year       =   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
   $phone              =   $this->db->get_where('settings' , array('type'=>'phone'))->row()->description;

   $online_quiz_details = $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $online_quiz_id))->row_array();

   $subject_info = $this->db->get_where('subject', array('subject_id' => $online_quiz_details['subject_id']))->row_array();

   $subject_image = $subject_info['icon'];

   if($subject_image <> '' || $subject_image <> null){
     $image = base_url()."uploads/subject_icon/". $subject_image;
   }else{
     $image = base_url()."uploads/subject_icon/default_subject.png";
   }

   $class_name = $this->db->get_where('class' , array('class_id' => $online_quiz_details['class_id']))->row()->name;

   $section_name = $this->db->get_where('section' , array('section_id' => $online_quiz_details['section_id']))->row()->name;

   $semester = $this->db->get_where('exam' , array('exam_id' => $online_quiz_details['semester_id']))->row()->name;

   $class_id = $online_quiz_details['class_id'];
   $section_id = $online_quiz_details['section_id'];

   $students_array = $this->db->query("SELECT t1.* FROM enroll t1 
    LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
    where t1.class_id = '$class_id' and t1.section_id = '$section_id' and t1.year = '$running_year'
    ORDER BY t2.`last_name` ASC")->result_array();

   $total_mark = $this->crud_model->get_total_mark_quiz($online_quiz_id);

   $failed = $this->db->query("SELECT * from tbl_online_quiz_result where online_quiz_id = '$online_quiz_id' and result = 'fail'")->num_rows();

   $passed = $this->db->query("SELECT * from tbl_online_quiz_result where online_quiz_id = '$online_quiz_id' and result = 'pass'")->num_rows();

   $total_students = $this->db->query("SELECT t1.* FROM enroll t1 
                    LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                    where t1.class_id = '$class_id' and t1.section_id = '$section_id' and t1.year = '$running_year'
                    ORDER BY t2.`last_name` ASC")->num_rows();

   $no_action = $total_students - $failed - $passed;
   ?>
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>style/cms/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>style/cms/css/main.css?version=3.3" rel="stylesheet">
<style>
   * {
   -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
   color-adjust: exact !important;                 /*Firefox*/
   }
</style>
<div class="content-w">
   <div class="content-i">
      <div class="content-box">
         <div class="element-wrapper">
            <div class="rcard-wy" id="print_area">
               <div class="rcard-w">
                  <div class="infos">
                     <div class="info-1">
                        <div class="rcard-logo-w">
                           <img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>">
                        </div>
                        <div class="company-name"><?php echo $system_name;?></div>
                        <div class="company-address">Online Quiz Result</div>
                     </div>
                     <div class="info-2">
                        <div class="rcard-profile">
                           <img alt="" src="<?php echo $image;?>">
                        </div>
                        <div class="company-name"><?php echo $subject_info['name']; ?></div>
                        <div class="company-address">
                           <?php echo $class_name;?> - <?php echo $section_name;?>
                        </div>
                     </div>
                  </div>
                  <div class="rcard-heading">
                     <h5><?php echo strtoupper($online_quiz_details['title']);?></h5>
                     <div class="rcard-date"><?php echo $semester;?></div>
                  </div>
                  <div class="rcard-table table-responsive">
                     <table class="table">
                        <thead>
                            <tr class="text-center">
                              <th>Summary:</th>
                               <th colspan="5" class="text-center">
                                
                                   Passed: <span class="badge badge-success"><?php echo $passed; ?> </span> &nbsp; &nbsp;
                                   Failed: <span class="badge badge-danger"><?php echo $failed; ?> </span> &nbsp; &nbsp;
                                   Waiting:  <span class="badge badge-warning"><?php echo $no_action; ?> </span> &nbsp; &nbsp;
                              
                               </th>
                            </tr>
                         </thead>
                        <thead>
                           <tr>
                               <th>#</th>
                               <th>Student</th>
                               <th>Points obtained</th>
                               <th>Result</th>
                           </tr>
                        </thead>
                        <tbody id="results">
                              <?php $counter = 0;  foreach ($students_array as $row): $counter++;
                              $student_id = $row['student_id'];?>
                              <tr>
                                <?php   

                                $query = $this->db->get_where('tbl_online_quiz_result', array('online_quiz_id' => $online_quiz_id, 'student_id' => $row['student_id']));

                                ?>
                                 <td>

                                   <?php echo $counter.'.)' ?>
                                 </td>
                                 <td>
                                  <?php 
                                  $student_details = $this->crud_model->get_student_info_by_id($row['student_id']); 
                                  echo $student_details['last_name'].", ".$student_details['first_name']; ?>
                                 </td>
                                 <td>
                                    <?php 
                                      if($this->crud_model->obtained_points_quiz($online_quiz_id,$student_id) <> ''){
                                         echo $this->crud_model->obtained_points_quiz($online_quiz_id,$student_id).' / '.$total_mark;
                                      }else{ echo "---"; }
                                    ?>
                                 </td>
                                 <td>
                                    <?php 

                                    if ($query->num_rows() > 0){
                                    
                                        $query_result = $query->row_array();
                                       
                                        if($query_result['status'] == 'attended'){
                                          echo "<span class='badge badge-primary'> Taking Exam <span class='fas fa-spinner fa-pulse'></span></span>";
                                        }else{

                                          if(get_phrase($query_result['result']) == 'Pass'){
                                             echo "<span class='badge badge-success'>". get_phrase('passed')."</span>";
                                           }else{
                                              echo "<span class='badge badge-danger'>". get_phrase('failed')."</span>";
                                           }

                                        }

                                    }
                                    else {
                                       echo "<span class='badge badge-warning'>". get_phrase('waiting')."</span>";
                                    }
                                    ?>
                                 </td>
                        
                              </tr>
                              <?php endforeach; ?>
                           </tbody>
                     </table>
                  </div>
                  <div class="rcard-footer">
                     <div class="rcard-logo">
                        <img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"><span><?php echo $system_name;?></span>
                     </div>
                     <div class="rcard-info">
                        <span><?php echo $phone;?></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <button class="btn btn-info btn-rounded" onclick="printDiv('print_area')"><?php echo get_phrase('print');?></button>
      </div>
   </div>
</div>
<script>
   function printDiv(nombreDiv) 
   {
       var contenido= document.getElementById(nombreDiv).innerHTML;
       var contenidoOriginal= document.body.innerHTML;
       document.body.innerHTML = contenido;
       window.print();
       document.body.innerHTML = contenidoOriginal;
   }
</script>