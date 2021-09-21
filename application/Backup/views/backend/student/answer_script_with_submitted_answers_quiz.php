<?php
    $online_quiz_info = $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $param2))->row();

    $class = $this->db->get_where('class', array('class_id' => $online_quiz_info->class_id))->row()->name;

    $section = $this->db->get_where('section', array('section_id' => $online_quiz_info->section_id))->row()->name;

    $subject = $this->db->get_where('subject', array('subject_id' => $online_quiz_info->subject_id))->row()->name;

    $questions = $this->db->get_where('tbl_question_bank_quiz', array('online_quiz_id' => $param2))->result_array();

    $answers = "answers";

    $total_marks = 0;

    $total_mark = $this->crud_model->get_total_mark_quiz($param2);

    $submitted_answer_script_details = $this->db->get_where('tbl_online_quiz_result', array('online_quiz_id' => $param2, 'student_id' => $this->session->userdata('login_user_id')))->row_array();

    $submitted_answer_script = json_decode($submitted_answer_script_details['answer_script'], true);

    foreach ($questions as $question)
        $total_marks += $question['mark'];
?>

<div class="row alert alert-info">

    <div class="col-sm-3 text-center">
 
      <div class="user-w">
         <div class="user-avatar-w">
            <div class="user-avatar">
               <img width="80px" alt="" src="<?php echo $this->crud_model->get_image_url('student', $this->session->userdata('login_user_id')); ?>">
            </div>
         </div>
         <div class="user-name">
            <h6 class="user-title">
               <?php echo strtoupper($this->db->get_where('student' , array('student_id' => $this->session->userdata('login_user_id')))->row()->last_name.", ".$this->db->get_where('student' , array('student_id' => $this->session->userdata('login_user_id')))->row()->first_name); ?>
            </h6>
            
         </div>
          <a href="<?php echo base_url();?>student/online_quiz/<?php echo base64_encode($online_quiz_info->class_id.'-'.$online_quiz_info->section_id.'-'.$online_quiz_info->subject_id);?>/" class="btn btn-sm btn-primary"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i> BACK</a> 
      </div>

    </div>
    <div class="col-md-9 text-left">

     <h3 class="text-dark"><?php echo get_phrase('quiz');?>: <b><?php echo $online_quiz_info->title;?></b></h3>
     <h5><?php
        $query = $this->db->get_where('tbl_online_quiz_result', array('online_quiz_id' => $param2, 'student_id' => $this->session->userdata('login_user_id')));
        if ($query->num_rows() > 0){
        
        $query_result = $query->row_array();
        $obt_mark = $query_result['obtained_mark'];
        if($query_result['obtained_mark'] == ''){
        $obt_mark = 0;
        }else{
        $obt_mark = $query_result['obtained_mark'];
        }
        
        $total_points = $obt_mark + $query_result['essay_mark']; ?></h5>
     <h5>Points: <span class="badge badge-success"><b><?php echo $total_points; ?></b>/<?php echo $total_mark; ?></span> </h5>
     <?php }
        else {
        echo '';
        }
        ?>
     <h5><?php
        echo 'Passing Rate: ' . '<span class="badge badge-success">'.$online_quiz_info->minimum_percentage .'%' . '</span>';
        ?></h5>

    </div>
    
  </div>

    <?php
        $count = 1; foreach ($submitted_answer_script as $row):
        $question_type = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'type');
        $question_title = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'question_title');
        $mark = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'mark');
        $submitted_answer = "";
    ?>
      <element class="col-sm-6 col-aligncenter">
        <div class="pipeline white lined-primary">            
          <div class="pipeline-header">
            <h5>
              <b><?php echo $count++;?>.) <?php echo $question_type == 'fill_in_the_blanks' ? str_replace('^', '__________', $question_title) : $question_title;?></b>
            </h5>
            <span><?php echo get_phrase('points');?>: <?php echo $mark;?></span>
          </div>
          <?php if ($question_type == 'multiple_choice'):
            //multiple choice
            $options_json = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'options');
            $number_of_options = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'number_of_options');
            if($options_json != '' || $options_json != null)
              $options = json_decode($options_json);
            else $options = array();
          ?>
            <ul>
              <?php for ($i = 0; $i < $number_of_options; $i++): ?>
                <li><?php echo $options[$i];?></li>
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
                }
              } else {
                $submitted_answer = array();
                $r = get_phrase('no_reply');
              }
            ?>
            <i><strong>[<?php echo get_phrase('answer');?> - <?php echo rtrim(trim($r), ',');?>]</strong></i>
            <br>
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
            <i><strong>[<?php echo get_phrase('correct_answer');?> - <?php echo rtrim(trim($c), ',');?>]</strong></i>
            <br>
            <strong>
              <?php 
              $ans = rtrim(trim($r), ',');
              $c_ans = rtrim(trim($c), ',');

              if($ans == $c_ans){
                echo "<span class='badge badge-success'><span class='fa fa-check'></span> ". get_phrase('correct')."</span>";
              }else{
                 echo "<span class='badge badge-danger'><span class='fa fa-times'></span> ". get_phrase('wrong')."</span>";
              }
              ?>
            </strong>
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
          
              <i><strong>[<?php echo get_phrase('answer');?> - <?php echo $submitted_answer;?>]</strong></i><br/>
              <i><strong>[<?php echo get_phrase('correct_answer');?> - <?php echo $suitable_words;?>]</strong></i>
              <br>
            <strong>
              <?php 
              $ans = $submitted_answer;
              $c_ans = $suitable_words;

              if($ans == $c_ans){
                echo "<span class='badge badge-success'><span class='fa fa-check'></span> ". get_phrase('correct')."</span>";
              }else{
                 echo "<span class='badge badge-danger'><span class='fa fa-times'></span> ". get_phrase('wrong')."</span>";
              }
              ?>
            </strong>
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
              <i><strong>[<?php echo get_phrase('answer');?> - <?php echo $submitted_answer;?>]</strong></i><br>
              <i><strong>[<?php echo get_phrase('correct_answer');?> - <?php echo $row['correct_answers'];?>]</strong></i>
              <br>
            <strong>
              <?php 
              $ans = $submitted_answer;
              $c_ans = $row['correct_answers'];

              if($ans == $c_ans){
                echo "<span class='badge badge-success'><span class='fa fa-check'></span> ". get_phrase('correct')."</span>";
              }else{
                 echo "<span class='badge badge-danger'><span class='fa fa-times'></span> ". get_phrase('wrong')."</span>";
              }
              ?>
            </strong>

            <?php elseif($question_type == 'essay'):
              if ($row['submitted_answer'] != "" || $row['submitted_answer'] != " ") {
                  $submitted_answer = str_replace("]","",str_replace("[","",str_replace("\"", "", $row['submitted_answer'])));
              }
              else{
                  $submitted_answer = get_phrase('no_reply');
              }
              $suitable_words   = implode(',', json_decode($row['correct_answers']));

              $max_mark = $this->db->get_where('tbl_question_bank_quiz', array('question_bank_id' => $row['question_bank_id']))->row()->mark;

              $q_id = $row['question_bank_id'];
              $student_id = $this->session->userdata('login_user_id');
              $grade_saved = $this->db->query("SELECT grade FROM tbl_quiz_essay_grade where student_id = '$student_id' and online_quiz_id = '$param2' and question_id = '$q_id'")->row()->grade;

            ?>  
           <div class="row">
             
              <div class="col-md-10">
                <p><strong><?php echo get_phrase('answer');?> - <?php echo $submitted_answer;?></strong></p>
              </div>
              <div class="col-md-2">
                <center></center><input style="background: #fff;" readonly="" type="text" value="<?php echo number_format($grade_saved,0); ?>" class="form-control task">
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
              <li><img width="40px" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo $options[$i];?>/quiz');" style="margin:10px;" src="<?php echo base_url();?>uploads/online_quiz/<?php echo rtrim(trim($options[$i]), ',');?>"></li>
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
           <strong><?php echo get_phrase('answer');?> - <img width="30px" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo rtrim(trim($r), ',');?>/quiz');" src="<?php echo base_url();?>uploads/online_quiz/<?php echo rtrim(trim($r), ',');?>"></strong>
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
            <?php echo get_phrase('correct_answer');?> - <img width="30px" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo rtrim(trim($r), ',');?>/quiz');" src="<?php echo base_url();?>uploads/online_quiz/<?php echo rtrim(trim($r), ',');?>">
           </strong><br>
           <?php 
              if($ans == $c_ans){
                 echo "<span class='badge badge-success'><span class='fa fa-check'></span> ". get_phrase('correct')."</span>";
              }else{
                 echo "<span class='badge badge-danger'><span class='fa fa-times'></span> ". get_phrase('wrong')."</span>";
              }
              ?>
           <?php endif; ?>
             <!--true_false -->
        </div>
      </element>

<?php endforeach;?>