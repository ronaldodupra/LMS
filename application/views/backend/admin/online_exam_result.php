<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <style type="text/css">
         ul.inline li {
         display:inline;
         }
         table {
            table-layout: fixed ;
            width: 100% ;
          }
          td {
            width: 25% ;
          }
      </style>
      <div class="header-spacer"></div>
      <div class="content-i">
         <div class="content-box">
            <div class="col-sm-8" style="margin: 0 auto;">
               <?php
                  $result_details = $this->db->get_where('online_exam_result', array('online_exam_id' => $param2, 'student_id' => $student_id))->row_array();
                  
                  $answer_script_array = json_decode($result_details['answer_script'], true);
                  
                  ?>        
               <?php
                  $online_exam_info = $this->db->get_where('online_exam', array('online_exam_id' => $param2))->row();
                  
                  $class = $this->db->get_where('class', array('class_id' => $online_exam_info->class_id))->row()->name;
                  
                  $section = $this->db->get_where('section', array('section_id' => $online_exam_info->section_id))->row()->name;
                  
                  $subject = $this->db->get_where('subject', array('subject_id' => $online_exam_info->subject_id))->row()->name;
                  
                  $questions = $this->db->get_where('question_bank', array('online_exam_id' => $param2))->result_array();
                  
                  $answers = "answers";
                  
                  $total_mark = $this->crud_model->get_total_mark($param2);
                  
                  $total_marks = 0;
                  
                  $submitted_answer_script_details = $this->db->get_where('online_exam_result', array('online_exam_id' => $param2, 'student_id' => $student_id))->row_array();
                  
                  $submitted_answer_script = json_decode($submitted_answer_script_details['answer_script'], true);
                  
                  foreach ($questions as $question)
                  
                      $total_marks += $question['mark'];
                  
                  ?>
               <div class="row alert alert-info">
                  <div class="col-sm-3 text-center">
                     <div class="user-w">
                        <div class="user-avatar-w">
                           <div class="user-avatar">
                              <img width="80px" alt="" src="<?php echo $this->crud_model->get_image_url('student', $student_id); ?>">
                           </div>
                        </div>
                        <div class="user-name">
                           <h6 class="user-title">
                              <?php echo strtoupper($this->db->get_where('student' , array('student_id' => $student_id))->row()->last_name.", ".$this->db->get_where('student' , array('student_id' => $student_id))->row()->first_name); ?>
                           </h6>
                        </div>
                        <a href="<?php echo base_url();?>admin/exam_results/<?php echo $param2;?>/" class="btn btn-sm btn-primary"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i> BACK</a> 
                     </div>
                  </div>
                  <div class="col-md-9 text-left">
                     <h3 class="text-dark"><?php echo get_phrase('exam');?>: <b><?php echo $online_exam_info->title;?></b></h3>
                     <h5><?php
                        $query = $this->db->get_where('online_exam_result', array('online_exam_id' => $param2, 'student_id' => $student_id));
                        
                        if ($query->num_rows() > 0){
                        
                        
                        
                        $query_result = $query->row_array();
                        
                        $obt_mark = $query_result['obtained_mark'];
                        
                        if($query_result['obtained_mark'] == ''){
                        
                        $obt_mark = 0;
                        
                        }else{
                        
                        $obt_mark = $query_result['obtained_mark'];
                        
                        }
                        
                        
                        
                        $total_points = $obt_mark + $query_result['essay_mark']; ?></h5>
                     <h5>Points: <span class="badge badge-success"><b id="total_grade"></b>/<?php echo $total_mark; ?></span> </h5>
                     <?php }
                        else {
                        
                        echo '';
                        
                        }
                        
                        ?>
                     <h5><?php
                        echo 'Passing Rate: ' . '<span class="badge badge-success">'.$online_exam_info->minimum_percentage .'%' . '</span>';
                        
                        ?></h5>
                  </div>
               </div>
               <?php
                  $count = 1; 
                  
                  
                  
                  foreach ($submitted_answer_script as $row):
                  
                  
                  
                  $question_type = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'type');
                  
                  
                  
                  $question_title = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'question_title');
                  
                  
                  
                  $mark = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'mark');
                  
                  
                  
                  $submitted_answer = "";
                  
                  ?>
               <element class="col-sm-6 col-aligncenter">
                  <div class="pipeline white lined-primary">
                     <div class="pipeline-header">
                        <h5>
                           <b>
                           <?php echo $count++;?>.) 
                           <?php echo $question_type == 'fill_in_the_blanks' ? str_replace('^', '__________', $question_title) : $question_title;?>
                           </b>
                        </h5>
                        <span class="badge badge-primary">
                        <?php if($mark > 1){
                           $point = 'Points';
                           
                           }else{
                           
                           $point = 'Point';
                           
                           } echo $point;?>: <?php echo $mark;?></span>
                     </div>
                     <?php if ($question_type == 'multiple_choice'):
                        //multiple choice
                        
                        $options_json = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'options');
                        
                        $number_of_options = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'number_of_options');
                        
                        if($options_json != '' || $options_json != null)
                        
                          $options = json_decode($options_json);
                        
                        else $options = array();
                        
                        ?>
                     <table class="table table-responsive table-bordered" style="border: none;">
                        <tr>
                           <?php for ($i = 0; $i < $number_of_options; $i++): ?>
                           <td><?php echo $options[$i];?></td>
                           <?php endfor; ?>
                        </tr>
                     </table>
                     <?php
                        if ($row['submitted_answer'] != "" || $row['submitted_answer'] != null) 
                        
                        {
                        
                          $submitted_answer = json_decode($row['submitted_answer']);
                        
                          $r = '';
                        
                          for ($i = 0; $i < count($submitted_answer); $i++) 
                        
                          {
                        
                            $x = $submitted_answer[$i];
                        
                            $r .= $options[$x-1].',';
                        
                          }
                        
                        } else {
                        
                          $submitted_answer = array();
                        
                          $r = get_phrase('no_reply');
                        
                        }
                        
                        ?>
                     <?php
                        if ($row['correct_answers'] != "" || $row['correct_answers'] != null) {
                        
                        $correct_options = json_decode($row['correct_answers']);
                        
                        $c = '';
                        
                        for ($i = 0; $i < count($correct_options); $i++) {
                        
                          $x = $correct_options[$i];
                        
                          $c .= $options[$x-1].',';
                        
                        }
                        
                        } else {
                        
                        $correct_options = array();
                        
                        $c = get_phrase('none_of_them.');
                        
                        }
                        
                        ?>
                     <div class="row alert alert-info">
                        <div class="col-md-2 text-center">
                           <span class="badge badge-primary ">Answer:</span>
                        </div>
                        <div class="col-md-8 text-center">
                           <h5 class="text-dark "><?php echo rtrim(trim($r), ',');?></h5>
                        </div>
                        <div class="col-md-2 text-center">
                           <?php 
                              $ans = rtrim(trim($r), ',');
                              
                              $c_ans = rtrim(trim($c), ',');
                              
                              if($ans == $c_ans){
                              
                                echo "<span class='badge badge-success'><span class='fa fa-check'></span> ". get_phrase('correct')."</span>";
                              
                              }else{
                              
                                 echo "<span class='badge badge-danger'><span class='fa fa-times'></span> ". get_phrase('wrong')."</span>";
                              
                              }
                              
                              ?>
                        </div>
                     </div>
                     <div class="row alert alert-info">
                        <div class="col-md-2 text-center">
                           <span class="badge badge-primary">Correct Answer:</span>
                        </div>
                        <div class="col-md-8 text-center">
                           <h5 class="text-dark "><?php echo rtrim(trim($c), ',');?></h5>
                        </div>
                        <div class="col-md-2 text-center"></div>
                     </div>
                     <!-- multiple choice -->
                     <!--fill_in_the_blanks -->
                     <?php elseif($question_type == 'fill_in_the_blanks'):
                        if ($row['submitted_answer'] != "" || $row['submitted_answer'] != " ") {
                        
                            $submitted_answer = implode(',', json_decode($row['submitted_answer']));
                        
                        }
                        
                        else{
                        
                            $submitted_answer = get_phrase('no_reply');
                        
                        }
                        
                        $suitable_words   = implode(',', json_decode($row['correct_answers']));
                        
                        ?>
                     <div class="row alert alert-info">
                        <div class="col-md-2">
                           <span class="badge badge-primary">Answer:</span>
                        </div>
                        <div class="col-md-8">
                           <h5 class="text-dark text-center"><?php echo $submitted_answer;?></h5>
                        </div>
                        <div class="col-md-2 text-center">
                           <?php 
                              $ans = $submitted_answer;
                              
                              $c_ans = $suitable_words;
                              
                              
                              
                              if($ans == $c_ans){
                              
                                echo "<span class='badge badge-success'><span class='fa fa-check'></span> ". get_phrase('correct')."</span>";
                              
                              }else{
                              
                                 echo "<span class='badge badge-danger'><span class='fa fa-times'></span> ". get_phrase('wrong')."</span>";
                              
                              }
                              
                              ?>
                        </div>
                     </div>
                     <div class="row alert alert-info">
                        <div class="col-md-2 text-center">
                           <span class="badge badge-primary">Correct Answer:</span>
                        </div>
                        <div class="col-md-8 text-center">
                           <h5 class="text-dark"><?php echo $suitable_words;?></h5>
                        </div>
                        <div class="col-md-2 text-center"></div>
                     </div>
                     <!--fill_in_the_blanks -->
                     <!--true_false -->
                     <?php elseif($question_type == 'true_false'):
                        if ($row['submitted_answer'] != "") {
                            $submitted_answer = $row['submitted_answer'];
                        }
                        else{
                            $submitted_answer = get_phrase('no_reply');
                        }
                        
                        ?>
                     <div class="row alert alert-info">
                        <div class="col-md-2">
                           <span class="badge badge-primary">Answer:</span>
                        </div>
                        <div class="col-md-8">
                           <h5 class="text-dark text-center"><?php echo $submitted_answer;?></h5>
                        </div>
                        <div class="col-md-2 text-center">
                           <?php 
                              $ans = $submitted_answer;
                              
                              $c_ans = $row['correct_answers'];
                              
                              if($ans == $c_ans){
                              
                                echo "<span class='badge badge-success'><span class='fa fa-check'></span> ". get_phrase('correct')."</span>";
                              
                              }else{
                              
                                 echo "<span class='badge badge-danger'><span class='fa fa-times'></span> ". get_phrase('wrong')."</span>";
                              
                              }
                              
                              ?>
                        </div>
                     </div>
                     <div class="row alert alert-info">
                        <div class="col-md-2 text-center">
                           <span class="badge badge-primary">Correct Answer:</span>
                        </div>
                        <div class="col-md-8 text-center">
                           <h5 class="text-dark"><?php echo $row['correct_answers'];?></h5>
                        </div>
                        <div class="col-md-2 text-center"></div>
                     </div>
                     <?php elseif($question_type == 'essay'):
                        if ($row['submitted_answer'] != "" || $row['submitted_answer'] != " ") {
                        
                            $submitted_answer =  $submitted_answer = str_replace("]","",str_replace("[","",str_replace("\"", "", $row['submitted_answer'])));
                        
                        }
                        
                        else{
                        
                            $submitted_answer = get_phrase('no_reply');
                        
                        }
                        
                        $suitable_words   = implode(',', json_decode($row['correct_answers']));
                        
                        
                        
                         $max_mark = $this->db->get_where('question_bank', array('question_bank_id' => $row['question_bank_id']))->row()->mark;
                        
                        
                        
                        $q_id = $row['question_bank_id'];
                        
                        
                        
                        $grade_saved = $this->db->query("SELECT grade FROM tbl_exam_essay_grade where student_id = '$student_id' and online_exam_id = '$param2' and question_id = '$q_id'")->row()->grade;
                        
                        
                        
                        $id = $this->db->query("SELECT id FROM tbl_exam_essay_grade where student_id = '$student_id' and online_exam_id = '$param2' and question_id = '$q_id'")->row()->id;
                        
                        
                        
                        ?>  
                     <div class="row">
                        <div class="col-md-2">
                           <span class="badge badge-primary">Answer:</span>
                        </div>
                        <div class="col-md-8">
                           <h5 class="text-dark text-center"><?php echo $submitted_answer;?></h5>
                        </div>
                        <div class="col-md-2 text-center">
                           <center></center>
                           <input min="0" type="number" name="<?php echo $id; ?>" id="<?php echo $row['question_bank_id']; ?>" value="<?php echo number_format($grade_saved,0); ?>" class="form-control task" placeholder="<?php echo get_phrase('enter_essay_grade');?>" max="<?php echo $max_mark ?>">
                        </div>
                     </div>
                     <?php elseif ($question_type == 'image'):
                        $options_json = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'options');
                        
                        $number_of_options = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'number_of_options');
                        
                        if($options_json != '' || $options_json != null)
                        
                          $options = json_decode($options_json);
                        
                        else $options = array();
                        
                        ?>
                     <ul>
                        <?php for ($i = 0; $i < $number_of_options; $i++): ?>
                        <li><img width="40px" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo $options[$i];?>');" style="margin:10px;" src="<?php echo base_url();?>uploads/online_exam/<?php echo rtrim(trim($options[$i]), ',');?>"></li>
                        <?php endfor; ?>
                     </ul>
                     <?php
                        if ($row['submitted_answer'] != "" || $row['submitted_answer'] != null) 
                        
                        {
                        
                          $submitted_answer = json_decode($row['submitted_answer']);
                        
                          $r = '';
                        
                          for ($i = 0; $i < count($submitted_answer); $i++) 
                        
                          {
                        
                            $x = $submitted_answer[$i];
                        
                            $r .= $options[$x-1].',';
                        
                            $ans = $submitted_answer[$i];
                        
                          }
                        
                        } else {
                        
                          $submitted_answer = array();
                        
                          $r = get_phrase('no_reply');
                        
                        }
                        
                        ?>
                     <strong><?php echo get_phrase('answer');?> - <img width="30px" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo rtrim(trim($r), ',');?>');" src="<?php echo base_url();?>uploads/online_exam/<?php echo rtrim(trim($r), ',');?>"></strong>
                     <br>
                     <?php
                        if ($row['correct_answers'] != "" || $row['correct_answers'] != null) {
                        
                        $correct_options = json_decode($row['correct_answers']);
                        
                        $r = '';
                        
                        for ($i = 0; $i < count($correct_options); $i++) {
                        
                          $x = $correct_options[$i];
                        
                          $c_ans = $correct_options[$i];
                        
                          $r .= $options[$x-1].',';
                        
                        }
                        
                        } else {
                        
                        $correct_options = array();
                        
                        $r = get_phrase('none_of_them.');
                        
                        }
                        
                        ?>
                     <strong>
                     <?php echo get_phrase('correct_answer');?> - <img width="30px" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo rtrim(trim($r), ',');?>');" src="<?php echo base_url();?>uploads/online_exam/<?php echo rtrim(trim($r), ',');?>">
                     </strong><br>
                     <?php 
                        if($ans == $c_ans){
                        
                           echo "<span class='badge badge-success'><span class='fa fa-check'></span> ". get_phrase('correct')."</span>";
                        
                        }else{
                        
                           echo "<span class='badge badge-danger'><span class='fa fa-times'></span> ". get_phrase('wrong')."</span>";
                        
                        }
                        
                        ?>
                     <?php endif; ?>
                  </div>
               </element>
               <?php
                  ?>
               <?php endforeach;?>
               <input type="hidden" id="exam_id" name="exam_id" value="<?php echo $param2?>">
               <input type="hidden" id="stud_id" name="stud_id" value="<?php echo $student_id?>">
               <div class="col-md-12 text-center">
                  <button class="btn btn-info" id="btn_update_points"> <span class="picons-thin-icon-thin-0336_disc_floppy_save_software"></span> Update Essay Points</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   $(document).ready(function() {
   
   
   
     $("#btn_update_points").click(function(){
   
   
   
       insert_update_points();
   
   
   
       var totalPoints = 0;
   
       var exam_id = $('#exam_id').val();
   
       var stud_id = $('#stud_id').val();
   
   
   
       $('.task').each(function(){
   
   
   
         totalPoints += parseInt($(this).val(), 10);
   
   
   
       });
   
   
   
       $.ajax({
   
         
   
         url:"<?php echo base_url();?>teacher/update_points/",
   
         type:'POST',
   
         data:{totalPoints:totalPoints,exam_id:exam_id,stud_id:stud_id},
   
         success:function(result)
   
         {
   
             const Toast = Swal.mixin({
   
             toast: true,
   
             position: 'top-end',
   
             showConfirmButton: false,
   
             timer: 8000
   
             }); 
   
             Toast.fire({
   
             type: 'success',
   
             title: 'Data successfully updated.'
   
             });
   
             load_points();
   
         }});
   
   
   
     });
   
   
   
     function insert_update_points(){
   
   
   
       var exam_id = '';
   
       var stud_id = '';
   
   
   
       var question_id = '';
   
       var grade_val = ''; 
   
       var id = '';
   
       exam_id = $('#exam_id').val();
   
       stud_id = $('#stud_id').val();
   
   
   
       $('.task').each(function(){
   
   
   
           grade_val = $(this).val();
   
           question_id = $(this).attr("id");
   
           id = $(this).attr("name");
   
           $.ajax({
   
         
   
             url:"<?php echo base_url();?>teacher/insert_update_points/",
   
             type:'POST',
   
             data:{id:id,exam_id:exam_id,stud_id:stud_id,question_id:question_id,grade_val:grade_val},
   
             success:function(result)
   
             {
   
   
   
             }
   
   
   
           });
   
   
   
       });
   
   
   
     }
   
   
   
   });
   
   
   
   
   
   function load_points(){
   
   
   
     var exam_id = $('#exam_id').val();
   
     var stud_id = $('#stud_id').val();
   
   
   
     $.ajax({
   
         
   
       url:"<?php echo base_url();?>teacher/load_points/",
   
       type:'POST',
   
       data:{exam_id:exam_id,stud_id:stud_id},
   
       success:function(data)
   
       {
   
         $('#total_grade').html(data);
   
       }
   
   
   
     });
   
   
   
   }
   
   
   
</script>
<script type="text/javascript">
   load_points();
   
</script>