<?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
   $year_now = date('Y');
   ?>
<div class="content-w">
   <?php include 'fancy.php';?>
   <div class="header-spacer"></div>
   <div class="conty">
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/academic_settings/"><i class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i><span><?php echo get_phrase('academic_settings'); ?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>admin/examination_statistics/"><i class="fa fa-chart-bar fa-2x"></i><span>Examination Statistics</span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/section/"><i class="os-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i><span><?php echo get_phrase('sections'); ?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/grade/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('grades'); ?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/semesters/"><i class="os-icon picons-thin-icon-thin-0007_book_reading_read_bookmark"></i><span><?php echo get_phrase('semesters'); ?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/student_promotion/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('student_promotion'); ?></span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="col-sm-12">
               <div class="element-box lined-primary shadow">
                  <h5 class="form-header"><?php echo get_phrase('Statistics');?></h5>
                  <?php echo form_open(base_url() . 'admin/examination_statistics/', array('class' => 'form m-b'));?>
                  <div class="row">
                     <div class="col col-lg-5 col-md-6 col-sm-12 col-12">
                        <div class="form-group label-floating is-select">
                           <label class="control-label"><?php echo get_phrase('filter_by_class');?></label>
                           <div class="select">
                              <select name="class_id" id="slct" onchange="sem_category(this.value);" oninput="sem_category(this.value);">
                                 <?php $cl = $this->db->get('class')->result_array();
                                    foreach($cl as $row):
                                    ?>
                                 <option value="<?php echo $row['class_id'];?>" <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                 <?php endforeach;?>
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
                        <div class="form-group label-floating is-select">
                           <label class="control-label"><?php echo get_phrase('semester_category');?></label>
                           <div class="select">
                              <!-- <select name="semester_category" id="semester_category" required="">
                                 <?php 

                                    // $grade_11_id = $this->db->query("SELECT * from class where name = 'Grade 11' or name = 'GRADE 11'")->row()->class_id;

                                    // if($grade_11_id >= $class_id){
                                    //    // $sem_cat = $this->db->get('tbl_semester_category')->result_array();
                                    //    $sem_cat = $this->db->query("SELECT * from tbl_semester_category where type = 'SHS'")->result_array();
                                    // }else{
                                    //    $sem_cat = $this->db->query("SELECT * from tbl_semester_category where type = 'ELEMENTARY and JHS'")->result_array();
                                    // }
                                    $sem_cat = $this->db->get('tbl_semester_category')->result_array();

                                    foreach($sem_cat as $row):
                                    ?>
                                 <option value="<?php echo $row['id'];?>" <?php if($semester_category == $row['id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                 <?php endforeach;?>
                              </select> -->
                              <select name="semester_category" id="semester_category" required="">
                                     
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col col-lg-2 col-md-6 col-sm-12 col-12">
                        <button class="btn btn-lg btn-primary"><span class="fa fa-filter"></span> Search</button>
                     </div>
                  </div>
                  <?php echo form_close();?>
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col col-xl-12 m-auto col-lg-12 col-md-12">
                           <div class="os-tabs-w">
                              <div class="os-tabs-controls">
                                 <ul class="navs navs-tabs upper">
                                    <?php 
                                       $active = 0;
                                       $query = $this->db->get_where('section' , array('class_id' => $class_id)); 
                                       if ($query->num_rows() > 0):
                                       $sections = $query->result_array();
                                       foreach ($sections as $rows): $active++;?>
                                    <li class="navs-item">
                                       <a class="navs-links <?php if($active == 1) echo "active";?>" data-toggle="tab" href="#tab<?php echo $rows['section_id'];?>"><?php echo $rows['name'];?></a>
                                    </li>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="aec-full-message-w" id="results">
                     <div class="aec-full-message">
                        <div class="container-fluid" style="background-color: #f2f4f8;">
                           <div class="tab-content">
                              <?php 
                                 $active2 = 0;
                                 $query = $this->db->get_where('section' , array('class_id' => $class_id));
                                 if ($query->num_rows() > 0):
                                 $sections = $query->result_array();
                                 foreach ($sections as $row): $active2++;?>
                              <div class="tab-pane <?php if($active2 == 1) echo "active";?>" id="tab<?php echo $row['section_id'];?>">
                                 <div class="row" id="result_data">
                                    <div class="table table-responsive">
                                       <table class="table table-sm table-responsive table-bordered table-hover">
                                          <thead >
                                             <tr>
                                                <th class="text-left">Subject</th>
                                                <th class="text-center" style="background: #00b050; color: #000000; font-size: 14px;">Passed</th>
                                                <th class="text-center" style="background: #ff0000; color: #000000; font-size: 14px;">Failed</th>
                                                <th class="text-center" style="background: #ffff00; color: #000000; font-size: 14px;">Waiting</th>
                                             </tr>
                                          </thead>
                                          <tbody id="results">
                                             <?php 
                                                $section_id  = $row['section_id'];
                                                
                                                $subject_array = $this->db->query("SELECT t1.`name`,t1.`class_id`,t1.`section_id`,t2.`online_exam_id`,t1.`subject_id` FROM subject t1 LEFT JOIN online_exam t2 ON t1.`subject_id` = t2.`subject_id` WHERE t1.class_id = '$class_id' and t1.section_id = '$section_id' AND t2.`online_exam_id` IS NOT NULL AND t2.`sem_category` = '$semester_category' and t2.semester_id = '$semester_id' GROUP BY t1.`subject_id` order by t1.name asc");
                                                
                                                if($subject_array->num_rows() > 0){

                                                      foreach ($subject_array->result_array() as $row2): $counter++; 
                                                      
                                                      $subject_id = $row2['subject_id'];
                                                      
                                                      $passed = $this->db->query("SELECT t2.`online_exam_result_id` FROM online_exam t1
                                                               LEFT JOIN online_exam_result t2 ON t1.`online_exam_id` = t2.`online_exam_id`
                                                               WHERE t1.section_id = '$section_id' and t1.`subject_id` = '$subject_id' AND t1.`semester_id` = '$semester_id' AND t2.`result` = 'pass' and t1.`sem_category` = '$semester_category'")->num_rows();
                                                      
                                                      $failed = $this->db->query("SELECT t2.`online_exam_result_id` FROM online_exam t1
                                                               LEFT JOIN online_exam_result t2 ON t1.`online_exam_id` = t2.`online_exam_id`
                                                               WHERE t1.section_id = '$section_id' and t1.`subject_id` = '$subject_id' AND t1.`semester_id` = '$semester_id' AND t2.`result` = 'fail' and t1.`sem_category` = '$semester_category'")->num_rows();
                                                      
                                                      $total_students = $this->db->query("SELECT t1.* FROM enroll t1 
                                                        LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                                                        where t1.class_id = '$class_id' and t1.section_id = '$section_id' and t1.year = '$running_year'
                                                        ORDER BY t2.`last_name` ASC")->num_rows();
                                                      
                                                      $no_action = $total_students - $failed - $passed;
                                                      $total_passed2 += $passed;
                                                      ?>
                                                   <tr>
                                                      <td> <a href="<?php echo base_url().'admin/exam_results/'.$row2['online_exam_id']; ?>" target="_blank"><?php echo $row['title']; ?><?php echo $row2['name'];?></a></td>
                                                      <td class="text-center"><?php echo $passed; ?></td>
                                                      <td class="text-center"><?php echo $failed; ?></td>
                                                      <td class="text-center"><?php echo $no_action; ?></td>
                                                   </tr>
                                                   <?php endforeach; ?>
                                                   <?php 
                                                      $total_passed = $this->db->query("SELECT t2.`online_exam_result_id` FROM online_exam t1 LEFT JOIN online_exam_result t2 ON t1.`online_exam_id` = t2.`online_exam_id`
                                                         WHERE t1.section_id = '$section_id' AND t1.`semester_id` = '$semester_id' AND t2.`result` = 'pass' AND t1.`sem_category` = '$semester_category'")->num_rows();
                                                      
                                                      $total_failed = $this->db->query("SELECT t2.`online_exam_result_id` FROM online_exam t1 LEFT JOIN online_exam_result t2 ON t1.`online_exam_id` = t2.`online_exam_id`
                                                         WHERE t1.section_id = '$section_id' AND t1.`semester_id` = '$semester_id' AND t2.`result` = 'fail' AND t1.`sem_category` = '$semester_category'")->num_rows();
                                                      
                                                      
                                                      $total_no_action = $total_students * $subject_array->num_rows() - $total_passed - $total_failed;
                                                      
                                                      ?>
                                                   <tr class="text-white" style="background:#00b0f0; font-size: 18px;">
                                                      <td>Total</td>
                                                      <td class="text-center passed"><?php echo $total_passed; ?></td>
                                                      <td class="text-center failed"><?php echo $total_failed; ?></td>
                                                      <td class="text-center waiting"><?php echo $total_no_action; ?></td>
                                                   </tr>

                                                <?php }else{ ?>

                                                   <tr><td colspan="4" class="text-center"> No data Found </td></tr>

                                                <?php } ?>

                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                              <?php endforeach;?>
                              <?php endif;?>    
                           </div>
                           <!-- TOTAL PER CLASS -->
                           <div class="row" id="result_data_percentage">
                              <div class="table table-responsive">
                                 <table class="table table-sm table-responsive table-bordered table-hover table-striped">
                                    <tbody>
                                       <tr>
                                          <td colspan="3" class="text-center" style="background: #0070c0; color: #fff;">TOTAL</td>
                                          <td colspan="3" class="text-center" style="background: #0070c0; color: #fff;">PERCENTAGE</td>
                                       </tr>
                                       <tr class="text-center">
                                          <td style="background: #00b050; color: #000000; font-size: 14px;">PASSED</td>
                                          <td style="background: #ff0000; color: #000000; font-size: 14px;">FAILED</td>
                                          <td style="background: #ffff00; color: #000000; font-size: 14px;">WAITING</td>
                                          <td style="background: #00b050; color: #000000; font-size: 14px;">PASSED</td>
                                          <td style="background: #ff0000; color: #000000; font-size: 14px;">FAILED</td>
                                          <td style="background: #ffff00; color: #000000; font-size: 14px;">WAITING</td>
                                       </tr>
                                       <tr class="text-center">
                                          <td>
                                             <h5 id="total_passed"></h5>
                                          </td>
                                          <td>
                                             <h5 id="total_failed"></h5>
                                          </td>
                                          <td>
                                             <h5 id="total_waiting"></h5>
                                          </td>
                                          <td>
                                             <h5 id="passed_percentage"></h5>
                                          </td>
                                          <td>
                                             <h5 id="failed_percentage"></h5>
                                          </td>
                                          <td>
                                             <h5 id="waiting_percentage"></h5>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <!-- TOTAL PER CLASS -->

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <input type="hidden" id="cl_id" value="<?php echo  $class_id ?>">
      <input type="hidden" id="sem_cat" value="<?php echo  $semester_category ?>">

      <a class="back-to-top" href="javascript:void(0);">
      <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
      </a>
   </div>
</div>
<script type="text/javascript">
    function sem_category(class_id) 
     {
       //alert(class_id);
       $.ajax({
         url: '<?php echo base_url();?>admin/get_sem_category/' + class_id,
         success: function(response)
         {
           $('#semester_category').html(response);
         }
       });
       
     }

     function load_selected_sem_category(){

       var semester_category = $('#sem_cat').val();
       var class_id = $('#cl_id').val();
       var mydata = 'class_id=' + class_id + '&semester_category=' + semester_category;

       $.ajax({

         url: '<?php echo base_url();?>admin/selected_sem_category',
         data:mydata,
         method:"POST",
         cache:false,
         success: function(data)
         {
           //alert(data);
           $('#semester_category').html(data);
         }

       });

     }

</script>

<script type="text/javascript">

   $(document).ready(function(){

      load_selected_sem_category();
      //Total Passed
      var pass = $(".passed");
   
      var total_passed = 0;
   
      for(var i = 0; i < pass.length; i++){
        total_passed += Number($(pass[i]).html());
        
        $('#total_passed').html(total_passed);
   
      }
      //Total Passed
      //Total Failed
      var fail = $(".failed");
   
      var total_failed = 0;
   
      for(var i = 0; i < fail.length; i++){
        total_failed += Number($(fail[i]).html());
        
        $('#total_failed').html(total_failed);
   
      }
      //Total Failed
      //Total Waiting
      var wait = $(".waiting");
   
      var total_waiting = 0;
   
      for(var i = 0; i < wait.length; i++){
        total_waiting += Number($(wait[i]).html());
        
        $('#total_waiting').html(total_waiting);
   
      }
      //Total Waiting
      
      //total passed percentage
   
      var total_passed_val = $('#total_passed').text();
      var total_failed_val = $('#total_failed').text();
      var total_waiting_val = $('#total_waiting').text();

      var total_passed_percentage = 0.0;
      var total_failed_percentage = 0.0;
      var total_waiting_percentage = 0.0;
   
      //total_passed_percentage
      total_passed_percentage = Number(total_passed_val) / (Number(total_passed_val) + Number(total_failed_val) + Number(total_waiting_val)) * 100;
   
      //total_passed_percentage
      total_failed_percentage = Number(total_failed_val) / (Number(total_passed_val) + Number(total_failed_val) + Number(total_waiting_val)) * 100;
   
      //total_waiting_percentage
      total_waiting_percentage = Number(total_waiting_val) / (Number(total_passed_val) + Number(total_failed_val) + Number(total_waiting_val)) * 100;
      
      if(total_passed_percentage.toFixed(2) == 'NaN'){
         $('#passed_percentage').html('---');
      }else{
         $('#passed_percentage').html(total_passed_percentage.toFixed(2));
      }

      if(total_failed_percentage.toFixed(2) == 'NaN'){
         $('#failed_percentage').html('---');
      }else{
         $('#failed_percentage').html(total_failed_percentage.toFixed(2));
      }
      
      if(total_waiting_percentage.toFixed(2) == 'NaN'){
         $('#waiting_percentage').html('---');
      }else{
         $('#waiting_percentage').html(total_waiting_percentage.toFixed(2));
      }
      
   });
   
</script>