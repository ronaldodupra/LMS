<?php
   //$class_name         =   $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
   
   $system_name        =   $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
   $system_email       =   $this->db->get_where('settings' , array('type'=>'system_email'))->row()->description;
   $running_year       =   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
   $phone              =   $this->db->get_where('settings' , array('type'=>'phone'))->row()->description;
   
   $online_exam_details = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();
   
   $subject_info = $this->db->get_where('subject', array('subject_id' => $online_exam_details['subject_id']))->row_array();
   
   $exam_name          =   $this->db->get_where('exam' , array('exam_id' => $online_exam_details['semester_id']))->row()->name;

   $subject_image = $subject_info['icon'];
   
   if($subject_image <> '' || $subject_image <> null){
     $subject_image = base_url()."uploads/subject_icon/". $subject_image;
   }else{
     $subject_image = base_url()."uploads/subject_icon/default_subject.png";
   }

   $class_name = $this->db->get_where('class' , array('class_id' => $online_exam_details['class_id']))->row()->name;
   
   $section_name = $this->db->get_where('section' , array('section_id' => $online_exam_details['section_id']))->row()->name;
   
   $semester = $this->db->get_where('exam' , array('exam_id' => $online_exam_details['semester_id']))->row()->name;
   
   $class_id = $online_exam_details['class_id'];
   $section_id = $online_exam_details['section_id'];
   
   $total_mark = $this->crud_model->get_total_mark($online_exam_id);
   
   ?>
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>style/cms/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>style/cms/css/main.css?version=3.3" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>
   * {
   -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
    color-adjust: exact !important;                 /*Firefox*/
   }

   .row {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
      flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px; }

  .text_underline{
    text-decoration: underline;
  }

</style>
<div class="content-w">
   <div class="content-i">
      <div class="content-box">
         <div class="element-wrapper">
            <div class="rcard-wy" id="print_area">
               <div class="rcard-w">
                  <!-- HEADER -->
                  <div class="col-md-12 text-center">
                      <img width="100px"  src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" title="<?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>">
                      <p style="font-size: 20px;">
                        <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?>
                      </p>
                  </div>
                   <hr>
                   <div class="col-md-12 text-center">
                     <p class="h5" style="text-align: center"><?php echo $online_exam_details['title'].' in'.' '.strtoupper($subject_info['name']); ?><br>
                              
                           </p>
                          <p class="h6" style="text-align: center"><?php echo $class_name;?></p>
                   </div>
                  <!-- HEADER -->
                  <!-- BODY -->

                  <div class="col-sm-12" style="margin: 0 auto; font-size: 12px;">
                   <?php

                      $param2 = $online_exam_id;

                      $result_details = $this->db->get_where('online_exam_result', array('online_exam_id' => $param2, 'student_id' => $student_id))->row_array();
                      $answer_script_array = json_decode($result_details['answer_script'], true); ?>        
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
                      
                          $total_marks += $question['mark']; ?>
                        <div class="container-fluid">
                            <table>
                              <tr>
                                <td style="width: 70%;"><strong>Student Name: </strong> &nbsp; <?php echo $this->crud_model->get_name('student', $student_id); ?></td>
                                <td style="float: right;width: 40%;"> <strong>Points:</strong>&nbsp;<span id="total_grade"></span>/<?php echo $total_mark;?></td>
                              </tr>
                              <tr>
                                <td style="width: 100%;"><strong>Class - Section: </strong> &nbsp; <?php echo $class.' - '.$section; ?></td>
                              </tr>
                            </table>
                        </div>
                        
                   <?php
                      $count = 1; 
                      foreach ($submitted_answer_script as $row):
                      $question_type = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'type');
                      $question_title = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'question_title');
                      $mark = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'mark');
                      $submitted_answer = "";
                   ?>
                   
                   <!-- ELEMENT -->

                    <element class="col-sm-6">
                      <div class="container-fluid" style="margin-top: -10px; margin-bottom: -20px;"> 
                        
                         <p><?php echo $count++;?>.) <?php echo $question_type == 'fill_in_the_blanks' ? str_replace('_', '__________', $question_title) : $question_title;?></p>
                         <?php 
                            if($mark > 1){
                             $point = 'Points';
                            }else{
                             $point = 'Point';                           
                            } 
                            if($question_type == 'enumeration' || $question_type == 'fill_in_the_blanks'){
                               echo 'Point(s) per item.';
                            }else{
                               echo $point; 
                            }?>: <?php echo number_format($mark,0);?>
                         <!-- Enumeration Script-->
                         <?php 
                            $id_q = $row['question_bank_id'];
                            
                          if($question_type == 'enumeration'){ ?>
                         <p class="float-right text-success" id="q_id-<?php echo $id_q ?>"> </p>
                         <?php }?>
                         <script type="text/javascript">
                            load_points_enumeration('<?php echo $param2 ?>','<?php echo $id_q ?>','<?php echo $student_id ?>');
                            
                            function load_points_enumeration(online_exam_quiz_id,question_bank_id,student_id){
                            
                               var type = 'exam';
                            
                               $.ajax({
                            
                                url:'<?php echo base_url();?>teacher/load_enumeration_points',
                                method:'POST',
                                data:{online_exam_quiz_id:online_exam_quiz_id,question_bank_id:question_bank_id,student_id:student_id,type:type},
                                cache:false,
                                success:function(data)
                                {
                                  $('#q_id-'+question_bank_id).html('Total Points: ' + data);
                                }
                              });
                            
                            }
                            
                         </script>
                         <script type="text/javascript">
                            load_e_options('<?php echo $param2 ?>','<?php echo $id_q ?>','<?php echo $student_id ?>');
                            
                            function load_e_options(online_exam_quiz_id,question_bank_id,student_id){
                            
                              var item_points = <?php echo $mark; ?>;
                              var type = 'exam';
                              $.ajax({
                            
                                url:'<?php echo base_url();?>teacher/load_e_options',
                                method:'POST',
                                data:{online_exam_quiz_id:online_exam_quiz_id,question_bank_id:question_bank_id,student_id:student_id,type:type},
                                cache:false,
                                dataType:"JSON",
                                success:function(result)
                                {
                            
                                  var html='';
                                  if(result.length > 0){
                                    for(var count = 0; count < result.length; count++)
                                    {
                                      var points =  result[count].points;
                                      //alert()
                                      html += '<li class="list-group-item">';
                                      html += result[count].answer +' - &nbsp;' ;
                                      if(points == 0.00){
                                       html += '<span id="e_correct-'+question_bank_id+'" class="badge badge-danger"> &#10006';
                                      }else{
                                       
                                       html += '<span id="e_correct-'+question_bank_id+'" class="badge badge-success "> &#10004';
                                      }
                                      html += '</li>';
                            
                                    }
                                  }else{
                                    html += '<li>No answer</li>';
                                  }
                                  $('#load_e_options-'+question_bank_id).html(html);
                            
                                }
                            
                              });
                            
                            }
                            
                         </script>
                         <!-- Enumeration Script-->
                         <!-- Multiple Choices -->
                         <?php if ($question_type == 'multiple_choice'):
                            $options_json = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'options');
                            
                            $number_of_options = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'number_of_options');
                            
                            $correct_answers = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'correct_answers');
                            
                            $correct_answer = json_decode($correct_answers);
                            
                            $submitted_answer = json_decode($row['submitted_answer']);
                            
                            
                            if($options_json != '' || $options_json != null)
                              $options = json_decode($options_json);
                            else $options = array(); ?>
                         
                            <p class="text-danger"><span class="fa fa-info-circle"></span> The underline item is the submitted answer by the student.</p> 
                            
                            <ul class="text-left">
                             <?php for ($i = 0; $i < $number_of_options; $i++): ?>
                              
                              <li <?php if($i + 1 == $submitted_answer[0] ) echo 'class="text-primary text_underline"' ?>>
                                <?php echo $options[$i];?>

                              </li>
                             <?php endfor; ?>
                           </ul>
                           <!-- Status -->
                           <?php if ($row['submitted_answer'] != "" || $row['submitted_answer'] != null) 
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

                                  $ans = rtrim(trim($r), ',');
                                  $c_ans = rtrim(trim($c), ',');

                                  if($ans == $c_ans){
                                  
                                    echo "<p><span class='badge badge-success'>&#10004</span></p>";
                                  }else{
                                  
                                     echo "<p><span class='badge badge-danger'>&#10006</span></p>";
                                  }
                            ?>
                           <!-- STATUS -->
                           
                            <strong>Correct Answer:</strong> <?php echo rtrim(trim($c), ',');?>
                          
                         <!-- multiple choice -->
                         <!--Enumeration && fill_in_the_blanks-->
                         <?php elseif($question_type == 'enumeration' || $question_type == 'fill_in_the_blanks' || $question_type == 'matching_type'):
                            if ($row['submitted_answer'] != "" || $row['submitted_answer'] != " ") {
                                $submitted_answer = implode(',', json_decode($row['submitted_answer']));
                            }else{
                                $submitted_answer = get_phrase('no_reply');
                            }
                            
                            $suitable_words   = implode(',', json_decode($row['correct_answers']));
                            
                            if($question_type == 'enumeration'){
                              $p_title = 'Answer Keys: ';
                            }elseif ($question_type == 'fill_in_the_blanks') {
                              $p_title = 'Answers in chronological order: ';
                            }elseif($question_type == 'matching_type'){

                            $matching_type = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'matching_type');

                            $matching_type_answer = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'matching_type_answer');

                            $number_of_options = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'number_of_options');

                            if ($matching_type != '' || $matching_type != null)
                            $options = json_decode($matching_type);
                            else
                            $options = array();

                            if ($matching_type_answer != '' || $matching_type_answer != null)
                            $options2 = json_decode($matching_type_answer);
                            else
                            $options2 = array(); ?>

                            <table class="table table-sm">
                            
                            <tr>
                                <td><label class="text-primary">Question</label></td>
                                <td><label class="text-primary">Correct Answer</label></td>
                            </tr>
                           
                               <?php for ($i = 0; $i < $number_of_options; $i++){ ?>
                                <tr>
                                  <td>
                                     <p> <?php echo $i+1 .').'.$options[$i];?> </p>
                                  </td>
                                  <td>
                                     <p> <?php echo $options2[$i];?> </p>
                                  </td>
                                </tr>
                               <?php } ?>
                            
                            </table>
                        <?php } ?>
                        
                          <?php if($question_type == 'enumeration' || $question_type == 'fill_in_the_blanks'){ ?>
                           <h5><?php echo $p_title.'&nbsp;'.$row['correct_answers']; ?></h5>
                        <?php } ?>
                         <ul class="list-group" id="load_e_options-<?php echo $row['question_bank_id'] ?>">
                         </ul>
                         <!--Enumeration && fill_in_the_blanks-->
                         <!-- identification -->
                         <?php elseif($question_type == 'identification'):
                            if ($row['submitted_answer'] != "" || $row['submitted_answer'] != " ") {
                                $submitted_answer = implode(',', json_decode($row['submitted_answer']));
                            }
                            else{
                                $submitted_answer = get_phrase('no_reply');
                            }
                            
                            $suitable_words   = implode(',', json_decode($row['correct_answers'])); ?>
                         <div class="row">
                            <div class="col-md-9">
                               <div class="container">
                                  <strong>Submitted Answer:</strong> <?php echo $submitted_answer;?> &nbsp; - <?php 
                                  $ans = $submitted_answer;
                                  
                                  $c_ans = $suitable_words;
                                  
                                  if(trim(strtolower($ans)) == trim(strtolower($c_ans))){
                                  
                                    echo "<span class='badge badge-success'>&#10004;</span>";
                                  
                                  }else{ 
                                    
                                    $q_bank_id = $row['question_bank_id'];
                                    
                                    $check_duplicate = $this->db->query("SELECT * from tbl_exam_mark_as_check where question_bank_id = '$q_bank_id' and online_exam_id = '$param2' and student_id = '$student_id'")->num_rows(); 
                                  
                                    $points_obtained = $this->db->query("SELECT points from tbl_exam_mark_as_check where question_bank_id = '$q_bank_id' and online_exam_id = '$param2' and student_id = '$student_id'")->row()->points;
                                  
                                    if($check_duplicate > 0){ ?>
                               <span class='badge badge-success'> Marked as Check.&nbsp;</span>
                               <span class="badge badge-primary">Points: <?php echo number_format($points_obtained,0);?></span>
                               <?php }else{ ?>
                               <span class='badge badge-danger'>&#10006;</span>
                               <?php }
                                  } ?><br>
                                  <strong class="text-left">Correct Answer:</strong> <?php echo $suitable_words;?>
                               </div>
                            </div>
                         </div>
                         <!-- identification -->
                         <!--true_false -->
                         <?php elseif($question_type == 'true_false'):
                            if ($row['submitted_answer'] != "") {
                                $submitted_answer = $row['submitted_answer'];
                            }
                            else{
                                $submitted_answer = get_phrase('no_reply');
                            }
                            
                            ?>
                         <div class="row">
                            <div class="col-md-10">
                               <div class="container">
                                  <strong>Submitted Answer:</strong> <?php echo strtoupper($submitted_answer);?> - &nbsp;

                                  <?php 
                                  $ans = $submitted_answer;
                                  
                                  $c_ans = $row['correct_answers'];
                                  
                                  if($ans == $c_ans){
                                  
                                    echo "<span class='badge badge-success'>&#10004;</span>";
                                  }else{
                                  
                                     echo "<span class='badge badge-danger'>&#10006;</span>";
                                  }
                                  ?>

                                  <br>
                                  <strong class="text-left">Correct Answer:</strong> <?php echo strtoupper($row['correct_answers']);?>  
                               </div>
                            </div>
                            <div class="col-md-2">
                               
                            </div>
                         </div>
                         <?php elseif($question_type == 'essay'):
                            if ($row['submitted_answer'] != "" || $row['submitted_answer'] != " ") {
                            
                                 $submitted_answer =  implode(',', json_decode($row['submitted_answer']));
                            }else{
                                $submitted_answer = get_phrase('no_reply');
                            }
                            
                            $max_mark = $this->db->get_where('question_bank', array('question_bank_id' => $row['question_bank_id']))->row()->mark;
                            
                            $q_id = $row['question_bank_id'];
                            
                            $grade_saved = $this->db->query("SELECT grade FROM tbl_exam_essay_grade where student_id = '$student_id' and online_exam_id = '$param2' and question_id = '$q_id'")->row()->grade;
                            
                            $id = $this->db->query("SELECT id FROM tbl_exam_essay_grade where student_id = '$student_id' and online_exam_id = '$param2' and question_id = '$q_id'")->row()->id;
                            
                            ?>  
                         <script type="text/javascript">
                            function check_grade_val(question_id,points){
                               $.ajax({
                                 url:'<?php echo base_url();?>teacher/check_grade_val',
                                 method:'POST',
                                 data:{question_id:question_id,points:points},
                                 cache:false,
                                 beforeSend: function() {
                                      $('#btn_update_points').prop('disabled',true);
                                  },
                                 success:function(data)
                                 {
                                   $('#'+question_id).val(data);
                                   $('#btn_update_points').prop('disabled',false);
                                 }
                               });
                            }
                         </script>
                         <div class="row">
                            <div class="col-md-10">
                               <div class="container">
                                  <strong>Submitted Answer:</strong> 
                                  <h5><?php echo $submitted_answer;?></h5>
                               </div>
                            </div>
                            <div class="col-md-2 text-center">
                               <p> <?php echo number_format($grade_saved,0); ?></p>
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

                         <!--chronological order -->
                        <?php elseif($question_type == 'chronological_order'):
                           if ($row['submitted_answer'] != "") {
                               $submitted_answer = implode('<br> ', json_decode($row['submitted_answer']));
                           }
                           else{
                               $submitted_answer = get_phrase('no_reply');
                           }
                           
                           ?>
     
                           <div class="row">
                           
                              <div class="col-md-10">
                                
                                <div class="container">
                                  
                                   <small>Submitted Answer:</small> <p><?php echo strtoupper($submitted_answer);?></p>
                              
                                </div>

                              </div>

                              <div class="col-md-2">
                                    
                                  <?php 
                                    $ans = $submitted_answer;
                                    
                                    $c_ans = implode('<br> ', json_decode($row['correct_answers']));
                                    
                                    if($ans == $c_ans){
                                      
                                        echo "<span class='badge badge-success float-right'><span class='fa fa-lg fa-check'></span> ". get_phrase('correct')."</span>"; ?>
                                         <input class="point_class" type="hidden" value = '<?php echo number_format($mark,0)?>'>
                                    <?php }else{
                                    
                                       echo "<span class='badge badge-danger float-right'><span class='fa fa-lg fa-times'></span> ". get_phrase('wrong')."</span>";
                                    }
                                  ?>

                              </div>
                           </div>
                        <hr>
                        <div class="col-md-12">     
                           <small class="text-left">Correct Answer:</small> <p><?php echo strtoupper($c_ans);?></p>
                        </div>
                     <!--chronological order -->  
                         <?php endif; ?>
                          </div>
                      </element>
                      <hr>
                   <!-- ELEMENT -->

                   <?php
                      ?>
                   <?php endforeach;?>

                   <input type="hidden" id="exam_id" name="exam_id" value="<?php echo $param2?>">
                   <input type="hidden" id="stud_id" name="stud_id" value="<?php echo $student_id?>">
                  </div>

                  <!-- BODY -->
                  <div class="rcard-footer">
                     <div class="rcard-logo">
                        <img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"><span><?php echo $system_name;?></span>
                     </div>
                     <div class="rcard-info">
                        <?php $teacher_id = $this->db->get_where('subject', array('subject_id' => $online_exam_details['subject_id']))->row()->teacher_id; ?>

                        <span>Prepared by:</span><span><?php  echo $this->crud_model->get_name('teacher', $teacher_id); ?></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <button class="btn btn-info btn-rounded" onclick="printDiv('print_area')"><?php echo get_phrase('print');?></button>
      </div>
   </div>

</div>
<script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
<script>
   function printDiv(nombreDiv) 
   {
       var contenido= document.getElementById(nombreDiv).innerHTML;
       var contenidoOriginal= document.body.innerHTML;
       document.body.innerHTML = contenido;
       window.print();
       document.body.innerHTML = contenidoOriginal;
   }


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
load_points();

</script>