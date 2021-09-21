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
            <div class="col-sm-10" style="margin: 0 auto;">
               <?php

                  $result_details = $this->db->get_where('tbl_online_quiz_result', array('online_quiz_id' => $param2, 'student_id' => $student_id))->row_array();
               
                  $answer_script_array = json_decode($result_details['answer_script'], true);    

                  $online_quiz_info = $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $param2))->row();
                  
                  $class = $this->db->get_where('class', array('class_id' => $online_quiz_info->class_id))->row()->name;
                  
                  $section = $this->db->get_where('section', array('section_id' => $online_quiz_info->section_id))->row()->name;
                  
                  $subject = $this->db->get_where('subject', array('subject_id' => $online_quiz_info->subject_id))->row()->name;
                  
                  $questions = $this->db->get_where('tbl_question_bank_quiz', array('online_quiz_id' => $param2))->result_array();
                  
                  $answers = "answers";
                  
                  $total_mark = $this->crud_model->get_total_mark_quiz($param2);
                  
                  $total_marks = 0;
                  
                  $submitted_answer_script_details = $this->db->get_where('tbl_online_quiz_result', array('online_quiz_id' => $param2, 'student_id' => $student_id))->row_array();

                  $submitted_answer_script = json_decode($submitted_answer_script_details['answer_script'], true);
                  
                  foreach ($questions as $question)
                  
                      $total_marks += $question['mark']; ?>
                  <div class="container">
                      <div class="row pipeline white lined-primary">
                          <div class="col-sm-3 text-center">
                             <div class="user-w">
                                <div class="user-avatar-w">
                                   <div class="user-avatar">
                                      <img width="80px" alt="" src="<?php echo $this->crud_model->get_image_url('student', $student_id); ?>">
                                   </div>
                                </div>
                                <div class="user-name">
                                   <h6 class="user-title">
                                      <?php echo $this->crud_model->get_name('student', $student_id); ?>
                                  </h6>
                                </div>
                                <a href="<?php echo base_url();?>teacher/quiz_results/<?php echo $param2;?>/" class="btn btn-sm btn-primary"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i> BACK</a> 
                             </div>
                          </div>
                          <div class="col-md-9 text-left" style="border-left: 2px solid #1b55e2;">
                            <h3 class="text-dark"><b><?php echo $online_quiz_info->title;?></b></h3>
                            <h6> <?php echo strtoupper($class .' - '.$section.' ( ' .$subject.' )'); ?></h6>
                            <h5>Points: <span class="badge badge-success"><span id="total_grade"></span>/<?php echo $total_mark; ?></span> 
                            <span class="ml-3">Passing Rate: <span class="badge badge-primary"> <?php echo $online_quiz_info->minimum_percentage .'%'; ?> </span></span>
                            </h5>

                            <h3 style="display: none;">Points: <span id="point_multi"></span></h3>
                            <button class="btn float-right btn-info" id="btn_update_points_multi" onclick="update_points();"> Update Points </button>
                        </div>
                     </div>
                  </div>
               
               <?php
                  $count = 1; 
                  foreach ($submitted_answer_script as $row):
                  $question_type = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'type');
                  $question_title = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'question_title');
                  $mark = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'mark');
                  $submitted_answer = "";
               ?>
               <element class="col-sm-6 col-aligncenter">
                  <div class="pipeline white lined-primary">
                     <div class="pipeline-header">
                        <h5>
                           <b>
                           <?php echo $count++;?>.) 
                           <?php echo $question_type == 'fill_in_the_blanks' ? str_replace('_', '__________', $question_title) : $question_title;?>
                           </b>
                        </h5>

                         <h6 class="text-primary"><span class="fa fa-thumbtack"></span> <strong><?php echo strtoupper(str_replace('_', ' ', $question_type)); ?></strong>
                           </h6>

                        <span class="badge badge-primary">
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
                           }?>:<?php echo number_format($mark,0);?>
                        </span>
                        <!-- Enumeration Script-->
                        <?php 
                         $id_q = $row['question_bank_id'];
                        
                         if($question_type == 'enumeration'){ ?>
                           
                           <h5 class="float-right text-success" id="q_id-<?php echo $id_q ?>"> </h5>

                         <?php }?>
                        
                        <script type="text/javascript">

                           load_points_enumeration('<?php echo $param2 ?>','<?php echo $id_q ?>','<?php echo $student_id ?>');

                           function load_points_enumeration(online_exam_quiz_id,question_bank_id,student_id){

                              var type = 'quiz';

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

                           function mac_enumeration(id,online_exam_quiz_id,question_bank_id,student_id,status,points){

                              var type = 'quiz';
                               $.ajax({

                                url:'<?php echo base_url();?>teacher/update_enumeration_status',
                                method:'POST',
                                data:{id:id,status:status,online_exam_quiz_id:online_exam_quiz_id,student_id:student_id,type:type,question_bank_id:question_bank_id},
                                cache:false,
                                success:function(data)
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
                                  load_e_options(online_exam_quiz_id,question_bank_id,student_id);
                                  load_points_enumeration(online_exam_quiz_id,question_bank_id,student_id);
                                  load_points();
                                }

                                });

                           }

                        </script>

                        <script type="text/javascript">

                          load_e_options('<?php echo $param2 ?>','<?php echo $id_q ?>','<?php echo $student_id ?>');

                          function load_e_options(online_exam_quiz_id,question_bank_id,student_id){

                            var item_points = <?php echo $mark; ?>;
                            var type = 'quiz';
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

                                    html += '<li class="list-group-item">';
                                    html += count+1 + '.) ' + result[count].answer ;
                                    if(points == 0.00){
                                     html += '<span id="e_correct-'+question_bank_id+'" class="badge badge-danger float-right" onclick="mac_enumeration('+result[count].id+','+online_exam_quiz_id+','+question_bank_id+','+student_id+',1,'+item_points+');"><span class="fa fa-times" title="Mark as Correct"></span> ';
                                    }else{
                                     
                                     html += '<span id="e_correct-'+question_bank_id+'" class="badge badge-success float-right " onclick="mac_enumeration('+result[count].id+','+online_exam_quiz_id+','+question_bank_id+','+student_id+',0,'+item_points+');"><span class="fa fa-check" title="Mark as wrong"></span> ';
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
                        
                     </div>
                     <!-- Enumeration Script-->

                     <!-- Multiple Choices -->
                     <?php if ($question_type == 'multiple_choice'):
               
                        $options_json = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'options');
                        
                        $number_of_options = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'number_of_options');

                        $correct_answers = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'correct_answers');
                        

                        $correct_answer = json_decode($correct_answers);

                        $submitted_answer = json_decode($row['submitted_answer']);


                        if($options_json != '' || $options_json != null)
                          $options = json_decode($options_json);
                        else $options = array(); ?>
                          
                          <div class="col-md-12">
                            <strong class="text-danger"><span class="fa fa-info-circle"></span> The checked item is the submitted answer by the student.</strong> 
                          </div><br>
                          <div class="row">
                              
                            <div class="col-md-10">
                                
                                <?php for ($i = 0; $i < $number_of_options; $i++): ?>
                          
                              <div class="col-sm-12">
                                <label class="containers"> <?php echo $options[$i];?>
                                    <input disabled="" <?php if($i + 1 == $submitted_answer[0] ) echo 'checked';?>  type="checkbox" value="<?php echo $i + 1;?>">
                                    <span class="checkmark"></span>
                                </label>    
                              </div>

                           <?php endfor; ?>

                          </div>

                          <div class="col-md-2">
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

                          <?php 
                              $ans = rtrim(trim($r), ',');
                              
                              $c_ans = rtrim(trim($c), ',');
                              
                              if($ans == $c_ans){ 
                                 echo "<span class='btn btn-success float-right'><span class='fa fa-lg fa-check'></span> ". get_phrase('correct')."</span>";
                                ?>
                                <input class="point_class" type="hidden" value = '<?php echo number_format($mark,0)?>'>
                               
                              <?php }else{
                              
                                 echo "<span class='btn btn-danger float-right'><span class='fa fa-lg fa-times'></span> ". get_phrase('wrong')."</span>";
                              }
                          ?>

                          </div>
                          
                          <div class="col-md-12">
                               <hr>
                            <div class="container">
                              <strong>Correct Answer:</strong> <h5><?php echo rtrim(trim($c), ',');?></h5>
                            </div>
                         
                                  
                          </div>

                      </div>

                     <!-- multiple choice -->

                     <!--Enumeration && fill_in_the_blanks && MATCHING TYPE-->
                      <?php elseif($question_type == 'enumeration' || $question_type == 'fill_in_the_blanks' || $question_type == 'matching_type' || $question_type == 'chronological_order'):

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
                        }elseif ($question_type == 'chronological_order') {
                          $p_title = 'Answers in chronological order: ';
                        }elseif($question_type == 'matching_type'){

                            $matching_type = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'matching_type');

                            $matching_type_answer = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'matching_type_answer');

                            $number_of_options = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'number_of_options');

                            if ($matching_type != '' || $matching_type != null)
                            $options = json_decode($matching_type);
                            else
                            $options = array();

                            if ($matching_type_answer != '' || $matching_type_answer != null)
                            $options2 = json_decode($matching_type_answer);
                            else
                            $options2 = array(); ?>

                            <table class="table table-responsive table-bordered table-striped">
                            
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
                        <?php }elseif($question_type == 'chronological_order'){ ?>
                            <h5><?php echo $p_title.'<br>'.implode('<br>', json_decode($row['submitted_answer'])); ?></h5>
                        <?php } ?>
                        
                        <ul class="list-group" id="load_e_options-<?php echo $row['question_bank_id'] ?>">
                           
                        </ul>

                     <!--Enumeration && fill_in_the_blanks && MATCHING TYPE-->

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
                            
                             <strong>Submitted Answer:</strong> <h5><?php echo $submitted_answer;?></h5>
                        
                          </div>

                        </div>

                        <div class="col-md-3">
                              
                           <?php 
                            $ans = $submitted_answer;
                            
                            $c_ans = $suitable_words;
                            
                            if(trim(strtolower($ans)) == trim(strtolower($c_ans))){ 
                              echo "<span class='badge badge-success'><span class='fa fa-check'></span> ". get_phrase('correct')."</span>"; ?>

                               <input class="point_class"  type="hidden" value = '<?php echo number_format($mark,0)?>'>
                            
                            <?php }else{ 
                              
                              $q_bank_id = $row['question_bank_id'];
                              
                              $check_duplicate = $this->db->query("SELECT * from tbl_quiz_mark_as_check where question_bank_id = '$q_bank_id' and online_quiz_id = '$param2' and student_id = '$student_id'")->num_rows(); 

                              $points_obtained = $this->db->query("SELECT points from tbl_quiz_mark_as_check where question_bank_id = '$q_bank_id' and online_quiz_id = '$param2' and student_id = '$student_id'")->row()->points;

                              if($check_duplicate > 0){ ?>

                                 <span class='btn btn-success btn-block float-right'><span class='fa fa-info fa-lg'></span> Marked as Check. </span><br>
                                 <span class="btn btn-primary btn-block float-right">Points: <?php echo number_format($points_obtained,0);?></span>

                                 <?php }else{ ?>

                                 <span class='btn btn-danger float-right'><span class='fa fa-lg fa-times'></span> Wrong</span>

                               <?php }

                              } ?>

                        </div>
                     </div>
                     <hr>
                     <div class="col-md-12">     
                        <strong class="text-left">Correct Answer:</strong> <h5><?php echo $suitable_words;?></h5>
                     </div>

                     <div class="col-md-12 row"> 
                        <?php if(strtolower($ans) <> strtolower($c_ans)){ ?>
                        <?php $q_bank_id = $row['question_bank_id'];
                           
                           $check_duplicate = $this->db->query("SELECT * from tbl_quiz_mark_as_check where question_bank_id = '$q_bank_id' and online_quiz_id = '$param2' and student_id = '$student_id'")->num_rows(); 

                           $max_mark = $this->db->get_where('tbl_question_bank_quiz', array('question_bank_id' => $row['question_bank_id']))->row()->mark;
                          
                           if($check_duplicate > 0){ ?>
                        <button class="btn btn-sm btn-warning float-right" onclick="mark_as_wrong('<?php echo $row['question_bank_id'] ?>')"><span class="fa fa-times"></span> Mark as Wrong</button>
                        <?php }else{ ?>
                        <button class="btn btn-sm btn-primary float-right" onclick="mark_as_correct('<?php echo $row['question_bank_id'] ?>','<?php echo $max_mark; ?>')"><span class="fa fa-check"></span> Mark as Correct</button>
                        <?php } ?>

                        <?php } ?>
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
                            
                             <strong>Submitted Answer:</strong> <h5><?php echo strtoupper($submitted_answer);?></h5>
                        
                          </div>

                        </div>

                        <div class="col-md-2">
                              
                            <?php 
                              $ans = $submitted_answer;
                              
                              $c_ans = $row['correct_answers'];
                              
                              if($ans == $c_ans){
                              
                                echo "<span class='btn btn-success float-right'><span class='fa fa-lg fa-check'></span> ". get_phrase('correct')."</span>"; ?>
                                 <input class="point_class" type="hidden" value = '<?php echo number_format($mark,0)?>'>
                              <?php }else{
                              
                                 echo "<span class='btn btn-danger float-right'><span class='fa fa-lg fa-times'></span> ". get_phrase('wrong')."</span>";
                              }
                            ?>

                        </div>

                     </div>
                     
                     <hr>
                     
                     <div class="col-md-12">     
                        <strong class="text-left">Correct Answer:</strong> <h5><?php echo strtoupper($row['correct_answers']);?></h5>
                     </div>
                     <?php elseif($question_type == 'essay'):
                        
                        if ($row['submitted_answer'] != "" || $row['submitted_answer'] != " ") {
                        
                             $submitted_answer =  implode(',', json_decode($row['submitted_answer']));
                        }else{
                            $submitted_answer = get_phrase('no_reply');
                        }
                        
                        $max_mark = $this->db->get_where('question_bank', array('question_bank_id' => $row['question_bank_id']))->row()->mark;
                        
                        $q_id = $row['question_bank_id'];
                        
                        $grade_saved = $this->db->query("SELECT grade FROM tbl_quiz_essay_grade where student_id = '$student_id' and online_quiz_id = '$param2' and question_id = '$q_id'")->row()->grade;
                        
                        $id = $this->db->query("SELECT id FROM tbl_quiz_essay_grade where student_id = '$student_id' and online_quiz_id = '$param2' and question_id = '$q_id'")->row()->id;
                        
                        ?>  

                        <script type="text/javascript">
                          function check_grade_val(question_id,points){
                             $.ajax({
                               url:'<?php echo base_url();?>teacher/check_grade_val_quiz',
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
                                
                                 <strong>Submitted Answer:</strong> <h5><?php echo $submitted_answer;?></h5>
                            
                              </div>

                            </div>

                            <div class="col-md-2">
                                  
                                <input min="0" type="number" oninput="check_grade_val('<?php echo $row['question_bank_id']; ?>',$(this).val());" name="<?php echo $id; ?>" id="<?php echo $row['question_bank_id']; ?>" value="<?php echo number_format($grade_saved,0); ?>" class="form-control task" placeholder="<?php echo get_phrase('enter_essay_grade');?>" max="<?php echo $max_mark ?>">

                            </div>

                         </div>

                     <?php elseif ($question_type == 'image'):
                        $options_json = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'options');
                        
                        $number_of_options = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'number_of_options');
                        
                        if($options_json != '' || $options_json != null)
                        
                          $options = json_decode($options_json);
                        
                        else $options = array();
                        
                        ?>
                     <ul>
                        <?php for ($i = 0; $i < $number_of_options; $i++): ?>
                        <li><img width="40px" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo $options[$i];?>');" style="margin:10px;" src="<?php echo base_url();?>uploads/online_quiz/<?php echo rtrim(trim($options[$i]), ',');?>"></li>
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
                     <strong><?php echo get_phrase('answer');?> - <img width="30px" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo rtrim(trim($r), ',');?>');" src="<?php echo base_url();?>uploads/online_quiz/<?php echo rtrim(trim($r), ',');?>"></strong>
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
                     <?php echo get_phrase('correct_answer');?> - <img width="30px" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo rtrim(trim($r), ',');?>');" src="<?php echo base_url();?>uploads/online_quiz/<?php echo rtrim(trim($r), ',');?>">
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

               <input type="hidden" id="quiz_id" name="quiz_id" value="<?php echo $param2?>">
               <input type="hidden" id="stud_id" name="stud_id" value="<?php echo $student_id?>">

               <?php $essay_count = $this->db->get_where('tbl_question_bank_quiz', array('online_quiz_id' => $param2, 'type' => 'essay'))->num_rows();
    
                if($essay_count > 0){ ?>

                    <div class="col-md-12 text-center">
                      <button class="btn btn-info" id="btn_update_points"> <span class="picons-thin-icon-thin-0336_disc_floppy_save_software"></span> Update Essay Points</button>
                   </div>

                <?php } ?>

                

            </div>
         </div>
      </div>
   </div>
   <a class="back-to-top" href="javascript:void(0);">
   <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
   </a>
   <a class="back-to-top" href="javascript:void(0);">
   <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
   </a>

   <div class="modal fade" id="update_points_modal" tabindex="-1" role="dialog" aria-labelledby="crearadmin" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document" style="width: 70%;">
      <div class="modal-content" style="margin-top:0px;">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-body">
            <div class="modal-header" style="background-color:#00579c">
               <h6 class="title" style="color:white"><?php echo get_phrase('Update Fill in the blanks points');?></h6>
            </div>
            <div class="ui-block-content">

               <form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault(); update_fill_in_the_blank();"> 
                  
                  <input type="hidden" id="question_bank_id" name="question_bank_id">

                  <div class="form-group">
                     <label>Points:</label>
                      <input min="0" type="number" name="point_fill" id="point_fill" class="form-control" placeholder="Enter fill in the blanks points">
                  </div>

                  <div class="form-group">
                     <div class="col-sm-12" style="text-align: center;">
                        <button type="submit" class="btn btn-success"><?php echo get_phrase('save');?></button>
                     </div>
                  </div>

               </form>
            </div>
         </div>
      </div>
   </div>
</div>
</div>

<script type="text/javascript">

  function update_points(){

    var point_multi = $('#point_multi').html();
    var quiz_id = $('#quiz_id').val();
    var stud_id = $('#stud_id').val();

    $.ajax({
         
         url:"<?php echo base_url();?>teacher/update_points_quiz_multi/",
         type:'POST',
         data:{point_multi:point_multi,quiz_id:quiz_id,stud_id:stud_id},
         beforeSend:function(){
          $('#btn_update_points_multi').prop('disabled',true);
          $('#btn_update_points_multi').text('Updating Points...');
          }, 
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
             $('#btn_update_points_multi').prop('disabled',false);
             $('#btn_update_points_multi').text('Update Points...');
         }});

  }

  points_total();

  function points_total(){
    var totalPoints = 0;
    $('.point_class').each(function(){
       totalPoints += parseInt($(this).val(), 10);
     });
    $('#point_multi').html(totalPoints);
  }

   $(document).ready(function() {
  
     $("#btn_update_points").click(function(){
   
       insert_update_points();
   
       var totalPoints = 0;
       var quiz_id = $('#quiz_id').val();
       var stud_id = $('#stud_id').val();
   
       $('.task').each(function(){
   
         totalPoints += parseInt($(this).val(), 10);
   
       });
   
       $.ajax({
         
         url:"<?php echo base_url();?>teacher/update_points_quiz/",
         type:'POST',
         data:{totalPoints:totalPoints,quiz_id:quiz_id,stud_id:stud_id},
         beforeSend:function(){
          $('#btn_update_points').prop('disabled',true);
          $('#btn_update_points').text('Updating Essay Points...');
          }, 
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
             $('#btn_update_points').prop('disabled',false);
             $('#btn_update_points').text('Update Essay Points...');
         }});
   
     });
   
     function insert_update_points(){
   
       var quiz_id = '';
       var stud_id = '';
   
       var question_id = '';
       var grade_val = ''; 
       var id = '';
       quiz_id = $('#quiz_id').val();
       stud_id = $('#stud_id').val();
   
       $('.task').each(function(){
   
           grade_val = $(this).val();
           question_id = $(this).attr("id");
           id = $(this).attr("name");
           $.ajax({
         
             url:"<?php echo base_url();?>teacher/insert_update_points_quiz/",
             type:'POST',
             data:{id:id,quiz_id:quiz_id,stud_id:stud_id,question_id:question_id,grade_val:grade_val},
             success:function(result)
             {
   
             }
   
           });
   
       });
   
     }
   
   });


   function load_points(){
   
     var quiz_id = $('#quiz_id').val();
     var stud_id = $('#stud_id').val();
   
     $.ajax({
         
       url:"<?php echo base_url();?>teacher/load_points_quiz/",
       type:'POST',
       data:{quiz_id:quiz_id,stud_id:stud_id},
       success:function(data)
       {
         $('#total_grade').html(data);
       }
   
     });
   
   }
   
</script>
<script type="text/javascript">
   load_points();
   
   function mark_as_correct(id,mark) {
    
      $('#update_points_modal').modal('show');
      $('#question_bank_id').val(id);
      $('#point_fill').val(mark);
      $('#point_fill').attr('max',mark);
    
   }

   function update_fill_in_the_blank(){

      swal({
           title: "Are you sure ?",
           text: "You want to update this data?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes",
          closeOnConfirm: true
      },
      function(isConfirm){
    
        if (isConfirm) 
        {          
            
         var quiz_id = $('#quiz_id').val();
          var stud_id = $('#stud_id').val();
          var question_bank_id = $('#question_bank_id').val();
          var points = $('#point_fill').val();
   
          $.ajax({
         
             url:"<?php echo base_url();?>teacher/mark_as_correct_quiz/",
             type:'POST',
             data:{question_bank_id:question_bank_id,quiz_id:quiz_id,stud_id:stud_id,points:points},
             success:function(result)
             {
              
              if(result == 1){
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
                window.location.href = '<?php echo base_url();?>teacher/online_quiz_result/' + quiz_id +'/'+ stud_id;
              }else{
                const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 8000
                }); 
                Toast.fire({
                type: 'error',
                title: 'Error on updating data'
                });
   
              }
   
             }
   
           });
   
        } 
        else 
        {
    
        }
    
      });

   }

   function mark_as_wrong(id) {
    
      swal({
           title: "Are you sure ?",
           text: "You want to mark this answer as wrong?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes",
          closeOnConfirm: true
      },
      function(isConfirm){
    
        if (isConfirm) 
        {          
            
          var quiz_id = $('#quiz_id').val();
          var stud_id = $('#stud_id').val();
   
          $.ajax({
         
             url:"<?php echo base_url();?>teacher/mark_as_wrong_quiz/",
             type:'POST',
             data:{id:id,quiz_id:quiz_id,stud_id:stud_id},
             success:function(result)
             {
              
              if(result == 1){
                const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 8000
                }); 
                Toast.fire({
                type: 'success',
                title: 'Data successfully removed.'
                });
                window.location.href = '<?php echo base_url();?>teacher/online_exam_result/' + quiz_id +'/'+ stud_id;
              }else{
                const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 8000
                }); 
                Toast.fire({
                type: 'error',
                title: 'Error on updating data'
                });
   
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

<style media="screen">
   .containers {
   display: block;
   position: relative;
   padding-left: 35px;
   margin-bottom: 12px;
   cursor: pointer;
   -webkit-user-select: none;
   -moz-user-select: none;
   -ms-user-select: none;
   user-select: none;
   }
   .containers input {
   position: absolute;
   opacity: 0;
   cursor: pointer;
   height: 0;
   width: 0;
   }
   .checkmark {
   position: absolute;
   top: 0; 
   left: 0;
   height: 20px;
   width: 23px;
   background-color: #eee;
   border:1px solid;
   outline-width: thick;
   }
   .containers:hover input ~ .checkmark {
   background-color: #ccc;
   }
   .containers input:checked ~ .checkmark {
   background-color: #2196F3;
   }
   .checkmark:after {
   content: "";
   position: absolute;
   display: none;
   }
   .containers input:checked ~ .checkmark:after {
   display: block;
   }
   .containers .checkmark:after {
   left: 9px;
   top: 5px;
   width: 5px;
   height: 10px;
   border: solid white;
   border-width: 0 3px 3px 0;
   -webkit-transform: rotate(45deg);
   -ms-transform: rotate(45deg);
   transform: rotate(45deg);
   }
</style>