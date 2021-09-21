<script src="<?php echo base_url();?>style/js/jquery.twbsPagination.js"></script>
<style>
    .page {
    display: none;
    }
    .sactive a {
    background:#0084ff;
    color:#fff;
    }
    .page-active {
    display: block;
    }
</style>
<?php $questions_number = $this->db->get_where('tbl_question_bank_quiz', array('online_quiz_id' => $online_quiz_id))->num_rows();?>
<?php

    $current_timestamp = strtotime("now");
    
    $quizdate = $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $online_quiz_id))->row()->quizdate;

    $time_end = $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $online_quiz_id))->row()->time_end;

    $quiz_ends_timestamp = strtotime($quizdate .' ' .$time_end);

    $datainfo = base64_encode($this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $online_quiz_id))->row()->class_id.'-'.$this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $online_quiz_id))->row()->section_id.'-'.$this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $online_quiz_id))->row()->subject_id);
    
    $total_duration   = $quiz_ends_timestamp - $current_timestamp;
    
    $total_hour     =   intval($total_duration / 3600);
    $total_duration   -=  $total_hour * 3600;
    $total_minute     = intval($total_duration / 60);
    $total_second     = intval($total_duration % 60);
    
    $online_quiz_row = $quiz_info->row();

    $questions = $this->db->query("SELECT t1.* FROM tbl_question_bank_quiz t1 WHERE t1.`online_quiz_id` = '$online_quiz_id' ORDER BY TYPE,RAND() ASC")->result_array();

    $total_marks = 0;
    
    foreach ($questions as $row) {
      $total_marks += $row['mark'];
    }
    
    ?>
<div class="content-w">
    <div class="conty">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="ui-block responsive-flex1200">
            <div class="ui-block-title">
                <h4 style="text-transform: capitalize;"><?php echo $online_quiz_row->title;?></h4>

                <h4>
                  <b><?php echo get_phrase('duration');?></b>: 
                  <?php echo ($online_quiz_row->duration / 60).' '.get_phrase('minutes');?></h4>

                <div style="height:30px; font-size:25px; font-weight:200; color: #212121;" id="timer_value">
                    <span id="hour_timer"> 0 </span>
                    <span style="font-size:20px;"><?php echo get_phrase('hour');?> </span>
                    <span class="blink_text">:</span>
                    <span id="minute_timer"> 0 </span>
                    <span style="font-size:20px;"><?php echo get_phrase('minute');?> </span>
                    <span class="blink_text">:</span>
                    <span id="second_timer"> 0 </span>
                    <span style="font-size:20px;"><?php echo get_phrase('second');?> </span>
                </div>
                <h4>
                  <button class="btn btn-block btn-rounded btn-info text-center" id="btn_finish" onclick="submit_quiz();"><?php echo get_phrase('finish_quiz');?></button>
            </div>
        </div>
        <hr>
        <div class="content-i">
            <div class="content-box">
                <form class="" action="<?php echo base_url();?>student/submit_online_quiz/<?php echo $online_quiz_id;?>/" method="post" enctype="multipart/form-data" id="answer_script">
                    <div class="row">
                        <?php $var = 0; $id1 = 1; $id2 = 1; $id3=1; $id4 =1; $count = 1; foreach ($questions as $question): $var++; ?>
                        <element class="col-sm-6 col-aligncenter page " id="page<?php echo $var;?>">

                            <div class="pipeline white lined-primary">
                                <div class="alert alert-success">
                               Question Type: <strong><?php echo strtoupper(str_replace('_', ' ', $question['type'])); ?></strong> 
                            </div>
                                <div class="pipeline-header">
                                    <h5><b><?php echo $count++;?>.</b>  <?php echo ($question['type'] == 'fill_in_the_blanks') ? str_replace('^', '__________', $question['question_title']) : $question['question_title'];?> 
                                    </h5>
                                    <span><?php echo get_phrase('points');?>: <?php echo $question['mark'];?></span>
                                </div>
                                <?php if ($question['type'] == 'multiple_choice'): ?>
                                <?php
                                    if ($question['options'] != '' || $question['options'] != null)
                                    $options = json_decode($question['options']);
                                    else
                                    $options = array();
                                    for ($i = 0; $i < $question['number_of_options']; $i++):
                                    ?>
                                <div class="col-sm-12">
                                    <label class="containers"><?php echo $options[$i];?>
                                    <input type="checkbox" name="<?php echo $question['question_bank_id'].'[]'; ?>" value="<?php echo $i + 1;?>">
                                    <span class="checkmark"></span>
                                    </label>    
                                </div>
                                <?php endfor; endif;?>
                                <?php if ($question['type'] == 'true_false'): ?>
                                <div class="skills-item">
                                    <div class="skills-item-info">
                                        <span class="skills-item-title">
                                            <span class="radio">
                                                <h6><label>
                                                    <input type="radio" name="<?php echo $question['question_bank_id'].'[]'; ?>" value="true"><span class="circle"></span><span class="check"></span>
                                                    <?php echo get_phrase('true');?>
                                                    </label>
                                                </h6>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="skills-item">
                                    <div class="skills-item-info">
                                        <span class="skills-item-title">
                                            <span class="radio">
                                                <h6><label>
                                                    <input type="radio" name="<?php echo $question['question_bank_id'].'[]'; ?>" value="false"><span class="circle"></span><span class="check"></span>
                                                    <?php echo get_phrase('false');?>
                                                    </label>
                                                </h6>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if ($question['type'] == 'fill_in_the_blanks'): ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="<?php echo $question['question_bank_id'].'[]'; ?>" value="" class="form-control" placeholder="<?php echo get_phrase('answer');?>">
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if ($question['type'] == 'essay'): ?>
                                <div class="col-md-12">
                                   <div class="form-group">
                                      <textarea class="form-control" row="3"  name="<?php echo $question['question_bank_id'].'[]'; ?>" value="" placeholder="<?php echo get_phrase('answer');?>"></textarea>
                                   </div>
                                </div>
                                <?php endif; ?>
                                <?php if ($question['type'] == 'image'): ?>
                                <div class="row">
                                   <?php if ($question['options'] != '' || $question['options'] != null)
                                      $options = json_decode($question['options']);
                                      else
                                      $options = array();
                                      for ($i = 0; $i < $question['number_of_options']; $i++):
                                      ?>
                                   <div class="col-sm-4">
                                      <label class="containers">
                                      <img class="img-fluid img_style img-round" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo $options[$i];?>/quiz');" src="<?php echo base_url();?>uploads/online_quiz/<?php echo $options[$i];?>">
                                      <input type="radio" name="<?php echo $question['question_bank_id'].'[]'; ?>" value="<?php echo $i + 1;?>">
                                      <span class="checkmark"></span>
                                      </label>   
                                   </div>
                                   <?php endfor; ?>
                                </div>
                                <?php endif;?>  
                            </div>
                        </element>
                        <?php endforeach; ?>
                    </div>
                    <div class="container">
                        <ul id="pagination-demo" class="pagination justify-content-center"></ul>
                    </div>
                    <input type="hidden" value="<?php echo $datainfo;?>" name="datainfo">
                    <div class="col-sm-12 text-center">

                        <button style="display: none;" class="btn btn-rounded btn-success text-center" id="subbutton"><?php echo get_phrase('finish_quiz');?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
<script>
    $(document).ready(function () {
        $(".pagination").rPage();
    });
    $(document).on("keydown", ":input:not(textarea)", function(event) {
            if (event.key == "Enter") {
              //alert(1);
                event.preventDefault();
            }
    });
</script>
<script type="text/javascript">

        function submit_quiz(){

        swal({
          title: "Are you sure ?",
          text: "You want to finish this quiz?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#5bc0de",
         confirmButtonText: "Yes, Finish",
         closeOnConfirm: true
         },
         function(isConfirm){
       
           if (isConfirm) 
           {        
       
                $('#subbutton').click();
       
           } 
           else 
           {
       
           }
       
         });
       
    }

    $('#pagination-demo').twbsPagination({
      totalPages: <?php echo $questions_number;?>,
      startPage: 1,
      visiblePages: 5,
      initiateStartPageClick: true,
      href: false,
      hrefVariable: '{{number}}',
      first: 'First',
      prev: 'Previous',
      next: 'Next',
      last: 'Last',
      loop: false,
      onPageClick: function (event, page) {
        $('.page-active').removeClass('page-active');
        $('#page'+page).addClass('page-active');
      },
      paginationClass: 'pagination',
      nextClass: 'next',
      prevClass: 'prev',
      lastClass: 'last',
      firstClass: 'first',
      pageClass: 'pages',
      activeClass: 'active sactive',
      disabledClass: 'disabled'
    });

</script>
<script type="text/javascript">
    var timer_starting_hour   = <?php echo $total_hour;?>;
    document.getElementById("hour_timer").innerHTML = timer_starting_hour;
    var timer_starting_minute   = <?php echo $total_minute;?>;
    document.getElementById("minute_timer").innerHTML = timer_starting_minute;
    var timer_starting_second   = <?php echo $total_second;?>;
    document.getElementById("second_timer").innerHTML = timer_starting_second;
    var timer = timer_starting_second;
    var mytimer = setInterval(function () {run_timer()}, 1000);
    function run_timer() 
    {
      if (timer == 0 && timer_starting_minute == 0 && timer_starting_hour == 0) {
          $("#answer_script").submit();
      }
      else {
        timer--;
        if (timer < 0)
        {
          timer = 59;
          timer_starting_minute--;
          if (timer_starting_minute >= 0) {
            document.getElementById("minute_timer").innerHTML = timer_starting_minute;
          }
        }
        if (timer_starting_minute < 0)
        {
          timer_starting_minute = 59;
          document.getElementById("minute_timer").innerHTML = timer_starting_minute;
          timer_starting_hour--;
          document.getElementById("hour_timer").innerHTML = timer_starting_hour;
        }
        document.getElementById("second_timer").innerHTML = timer;
      }
    }
</script>
<style type="text/css">

    .img_style {
       width: 120px;
       height: 120px;
       object-fit: cover;
       }

    .col-aligncenter{float: none;margin: 0 auto;}
    .blink_text {
    -webkit-animation-name: blinker;
    -webkit-animation-duration: 1s;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    -moz-animation-name: blinker;
    -moz-animation-duration: 1s;
    -moz-animation-timing-function: linear;
    -moz-animation-iteration-count: infinite;
    animation-name: blinker;
    animation-duration: 1s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    }
    @-moz-keyframes blinker {
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
    100% { opacity: 1.0; }
    }
    @-webkit-keyframes blinker {
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
    100% { opacity: 1.0; }
    }
    @keyframes blinker {
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
    100% { opacity: 1.0; }
    }
</style>
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

