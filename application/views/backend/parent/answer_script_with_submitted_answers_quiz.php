<?php
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
        $total_marks += $question['mark'];
?>
<div style="text-align: center;">
     <h3><?php echo get_phrase('results');?>: <b><?php echo $online_quiz_info->title;?></b></h3>
    <h5><?php
    $query = $this->db->get_where('tbl_online_quiz_result', array('online_quiz_id' => $param2, 'student_id' => $student_id));
      if ($query->num_rows() > 0){
          $query_result = $query->row_array();
          echo 'Points: ' .'<span class="badge badge-success">'.$query_result['obtained_mark'] . ' / ' .  $total_mark . '</span>';
      }
      else {
          echo '';
      }
     ?></h5>
     <h5><?php
      echo 'Passing Rate: ' . '<span class="badge badge-success">'.$online_quiz_info->minimum_percentage .'%' . '</span>';
      ?></h5>
</div>
<div class="back" style="margin-top:-20px;margin-bottom:10px">    
          <a href="<?php echo base_url();?>parents/online_quiz/<?php echo base64_encode($online_quiz_info->class_id.'-'.$online_quiz_info->section_id.'-'.$online_quiz_info->subject_id.'-'.$student_id);?>/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>  
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
            <span><?php echo get_phrase('mark');?>: <?php echo $mark;?></span>
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
                echo "<span class='badge badge-success'>". get_phrase('correct')."</span>";
              }else{
                 echo "<span class='badge badge-danger'>". get_phrase('wrong')."</span>";
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
                echo "<span class='badge badge-success'>". get_phrase('correct')."</span>";
              }else{
                 echo "<span class='badge badge-danger'>". get_phrase('wrong')."</span>";
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
                echo "<span class='badge badge-success'>". get_phrase('correct')."</span>";
              }else{
                 echo "<span class='badge badge-danger'>". get_phrase('wrong')."</span>";
              }
              ?>
            </strong>

             <?php endif; ?>
             <!--true_false -->
        </div>
      </element>
<?php endforeach;?>,