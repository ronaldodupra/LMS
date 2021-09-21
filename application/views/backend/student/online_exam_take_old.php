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
<?php

$online_exam_row = $exam_info->row();

$exam_ends_timestamp =  strtotime(date('d-M-Y', $online_exam_row->exam_date)." ".$online_exam_row->time_end);

$current_timestamp = strtotime("now");

$datainfo =  base64_encode($online_exam_row->class_id.'-'.$online_exam_row->section_id.'-'.$online_exam_row->subject_id);

$is_random = $online_exam_row->is_random;

$code = $online_exam_row->code;

$total_duration   = $exam_ends_timestamp - $current_timestamp;
$total_hour       =   intval($total_duration / 3600);
$total_duration   -=  $total_hour * 3600;
$total_minute     = intval($total_duration / 60);
$total_second     = intval($total_duration % 60);

$student_id = $this->session->userdata('login_user_id');

$total_marks = 0;

foreach ($questions as $row) {

  if($check_answer <> ''){
    $marks = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'mark');
    $total_marks += $marks;
  }else{
    $total_marks += $row['mark'];
  }
 
}

$total_questions = $this->db->get_where('question_bank', array('online_exam_id' => $online_exam_id))->num_rows();

$timer_saving_exam = $this->db->get_where('settings' , array('type' => 'timer_saving_exam'))->row()->description; 

$total_duration2   = number_format($timer_saving_exam);

?>
<div class="content-w">

   <div class="conty">

      <?php include 'fancy.php';?>

      <div class="header-spacer"></div>

      <div class="container ui-block ">

        <br>

        <div class="col-md-12 ">
          
          <div class="row ">
              
            <div class="col-md-8 ">
                <h4 class="text-left"><?php echo $online_exam_row->title;?><br>
                  <small>Duration: <?php echo ($online_exam_row->duration / 60).' minutes'?></small>
                </h4>
            </div>

            <div class="col-md-4 text-center">
              <div class="btn btn-group ">
                  <span class="btn btn-primary text-center" id="btn_save" onclick="btn_save_exam();"><span class="fa fa-save fa-lg"></span> Save Exam</span>
                  <button class="btn btn-success ml-1 text-center" id="btn_finish" onclick="finish_examination();"><span class="fa fa-check fa-lg"></span> Finish Exam</button>
              </div>
            </div>

          </div>

          <div class="col-md-12 text-center">
              
                <h3 style="font-weight:200; color: #212121;" id="timer_value">
                
                  <span id="hour_timer"> 0 </span>
                   <span style="font-size: 20px;">Hours</span>
                   <span class="blink_text">:</span>
                   <span id="minute_timer"> 0 </span>
                   <span style="font-size: 20px;">Minutes</span>
                   <span class="blink_text">:</span>
                   <span id="second_timer"> 0 </span>
                   <span style="font-size: 20px;">Seconds </span>

                </h3>
          </div>

        </div>

      </div>

      <div class="content-i" style="margin-top: -20px;">

         <div class="content-box" id="reload">
            <form class="" action="<?php echo base_url();?>student/submit_online_exam/<?php echo $online_exam_id;?>/" method="post" enctype="multipart/form-data" id="answer_script">
               <div class="container">

                  <?php $var = 0; $id1 = 1; $id2 = 1; $id3=1; $id4 =1; $count = 1; ?>
                    
                    <div class="os-tabs-w" style="display: none;">

                      <div class="os-tabs-controls">
                      
                         <ul class="navs navs-tabs upper">
                            
                              <?php foreach ($questions as $question): $var++; 

                                $question_bank_id = $question['question_bank_id'];

                                ?>
                                <li class="navs-item">
                                   <a class="navs-links <?php if($var == 1) echo "active";?>" data-toggle="tab" href="#tab<?php echo $var;?>"><?php echo $question_bank_id;?></a>
                                </li>
                              <?php endforeach; ?>

                         </ul>

                      </div>

                   </div>

                   <div class="aec-full-message-w" id="results">

                     <div class="aec-full-message">

                        <div class="container-fluid" style="background-color: #f2f4f8;">

                           <div class="tab-content">

                              <?php $active2 = 0; foreach ($questions as $row): $active2++;

                                  $previous_id = $active2; 
                                  $next_id = $active2 + 1;
                                  $prev_id = $active2 - 1;

                                  if($check_answer <> ''){
                                    $question_bank_id = $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'question_bank_id');
                                  }else{
                                    $question_bank_id = $question['question_bank_id'];
                                  }

                                 if($check_answer <> ''){
                                    
                                    $question_type            =  $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'type');

                                    $question_title           =  $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'question_title');

                                    $question_image           =  $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'image');

                                    $question_mark            =  $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'mark');

                                    $question_number_options  =  $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'number_of_options');

                                    $question_options         =  $this->crud_model->get_question_details_by_id($row['question_bank_id'], 'options');

                                  }else{
                                    
                                    $question_type            = $row['type'];

                                    $question_title           = $row['question_title'];

                                    $question_image           = $row['image'];

                                    $question_mark            = $row['mark'];

                                    $question_number_options  = $row['number_of_options'];

                                    $question_options         = $row['options'];

                                  }

                                  ?>

                                  <div class="tab-pane <?php if($active2 == 1) echo "active";?>" id="tab<?php echo $active2;?>">
                                     
                                    <div class="container">
                              
                                        <div class="pipeline white lined-primary">

                                             <h6 class="text-primary"><span class="fa fa-thumbtack"></span> <strong><?php echo strtoupper(str_replace('_', ' ', $question_type)); ?></strong>
                                             <span class="badge badge-danger float-right" >
                                              Questions: <?php echo $count++;?> / <?php echo $total_questions; ?></span>  </h6>

                                             <p class="text-danger">
                                              
                                              <?php 

                                                $direction = $this->db->get_where('tbl_exam_directions', array('online_exam_id' => $online_exam_id, 'question_type' => $question_type));
                                                
                                                if($direction->num_rows() > 0){
                                                  echo '<span class="fa fa-question-circle"></span> Direction: '.$direction->row()->directions;
                                                }else{
                                                  echo '';
                                                }
                                                
                                                ?>
                                              </p>

                                          <div class="pipeline-header">
                                             <?php echo ($question_type == 'fill_in_the_blanks') ? str_replace('^', '__________', $question_title) : $question_title; ?>
                                             </p>
                                             <p class="text-center">
                                                <?php $img = $question_image;
                                                   if($img <> ''){ ?>
                                                <img src="<?php echo base_url('uploads/online_exam/'.$question_image);?>" class="img-fluid img-responsive img-thumbnail" width="100%;">
                                                <?php }else{ ?>
                                                <?php } ?>
                                             </p>

                                             <?php if($question_mark > 1){
                                                $point = 'Points';
                                              }else{
                                                $point = 'Point';
                                              }
                                              if($question_type == 'enumeration'){
                                                echo 'Point(s) per item.';
                                              }else{
                                                echo $point; 
                                              }
                                              ?>: <?php echo $question_mark;?>
                                          </div>
                                          
                                          <?php if ($question_type == 'multiple_choice'): 

                                              $a = range(0,$question_number_options-1);
                                              shuffle($a);

                                              $array = array_slice($a, 0, $question_number_options);
                                              if ($question_options != '' || $question_options != null)
                                              $options = json_decode($question_options);
                                              else
                                              $options = array();
                                              foreach($array as $value){

                                               if($check_answer <> ''){ 

                                                  $submitted_answer = json_decode($row['submitted_answer']);

                                                ?>

                                                  <div class="col-sm-12">
                                                     <label class="containers">  <b> <?php echo $options[$value];?></b>
                                                     <input type="radio" <?php if($value + 1 == $submitted_answer[0] ) echo 'checked';?> name="<?php echo $row['question_bank_id'].'[]'; ?>" value="<?php echo $value + 1;?>">
                                                     <span class="checkmark"></span>
                                                     </label>    
                                                  </div>

                                                <?php }else{ ?>

                                                  <div class="col-sm-12">
                                                     <label class="containers">  <b> <?php echo $options[$value];?></b>
                                                     <input type="radio" name="<?php echo $row['question_bank_id'].'[]'; ?>" value="<?php echo $value + 1;?>">
                                                     <span class="checkmark"></span>
                                                     </label>    
                                                  </div>

                                                <?php } ?>

                                          <?php } endif;?>
                                          
                                          <?php if ($question_type == 'true_false'):?>

                                          <div class="skills-item">
                                             <div class="skills-item-info">
                                                <span class="skills-item-title">
                                                   <span class="radio">
                                                      <h6><label>

                                                        <?php if($check_answer <> ''){ 

                                                          $correct_answer = $row['submitted_answer'];

                                                        ?>

                                                          <input type="radio" <?php if($correct_answer == 'true') echo 'checked';?> name="<?php echo $row['question_bank_id'].'[]'; ?>" value="true">

                                                        <?php }else{ ?>

                                                          <input type="radio" name="<?php echo $row['question_bank_id'].'[]'; ?>" value="true">

                                                        <?php } ?>

                                                         <span class="circle"></span><span class="check"></span>
                                                         True
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
                                                         <?php if($check_answer <> ''){ 

                                                          $correct_answer = $row['submitted_answer'];
                                                          
                                                          ?>
                                                          <input type="radio" <?php if($correct_answer == 'false') echo 'checked';?> name="<?php echo $row['question_bank_id'].'[]'; ?>" value="false">
                                                        <?php }else{ ?>
                                                          <input type="radio" name="<?php echo $row['question_bank_id'].'[]'; ?>" value="false">
                                                        <?php } ?>
                                                         <span class="circle"></span><span class="check"></span>
                                                         False
                                                         </label>
                                                      </h6>
                                                   </span>
                                                </span>
                                             </div>
                                          </div>
                                          <?php endif; ?>
                                          <?php if ($question_type == 'fill_in_the_blanks'): ?>
                                          <div class="col-md-12">
                                             <div class="form-group">
                                                <input type="text" name="<?php echo $row['question_bank_id'].'[]'; ?>" value="<?php echo implode(',', json_decode($row['submitted_answer'])); ?>" class="form-control" placeholder="Answer...">
                                             </div>
                                          </div>
                                          <?php endif; ?> 
                                          <?php if ($question_type == 'essay'): ?>
                                          <div class="col-md-12" id="id-<?php echo $row['question_bank_id']; ?>"></div>
                                          <?php endif; ?>
                                          <?php if ($question_type == 'image'): ?>
                                          <div class="row">
                                             <?php 

                                                $a = range(0,$question_number_options-1);
                                                shuffle($a);
                                                $array = array_slice($a, 0, $question_number_options);

                                                if ($question_options != '' || $question_options != null)
                                                $options = json_decode($question_options);
                                                else
                                                $options = array();
                                                foreach($array as $value){?>

                                             <div class="col-sm-4">
                                                <label class="containers">
                                                <img class="img-fluid img_style img-round" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo $options[$value];?>');" src="<?php echo base_url();?>uploads/online_exam/<?php echo $options[$value];?>">
                                                <input type="radio" name="<?php echo $row['question_bank_id'].'[]'; ?>" value="<?php echo $value + 1;?>">
                                                <span class="checkmark"></span>
                                                </label>   
                                             </div>
                                             <?php } ?>
                                          </div>
                                          <?php endif;?>

                                          <script type="text/javascript">

                                            $( document ).ready(function() {

                                             $('.txt_enumeration-<?php echo $row['question_bank_id']; ?>').on('blur',function () {
                                                  var current_value = $(this).val().toLowerCase().trim();
                                                $(this).attr('value',current_value);
                                              console.log(current_value);
                                                  if(current_value == ''){

                                                  }else{

                                                    if ($('.txt_enumeration-<?php echo $row['question_bank_id']; ?>[value="' + current_value + '"]').not($(this)).length > 0 || current_value.length == 0 ) {
                                                      
                                                      $(this).focus();

                                                      $('#e_id-<?php echo $i?>').css('display','block');
                                                    
                                                    }else{

                                                      $('#e_id-<?php echo $i?>').css('display','none');

                                                    }
                                                    
                                                  }
                                                  
                                              });

                                            });

                                          </script>

                                          <?php if ($question_type == 'enumeration'): 
                                              $submitted_answer_script = json_decode($row['submitted_answer']);
                                            ?>

                                            <h5 id="e_id-<?php echo $i?>" class="text-danger text-center" style="display: none;"> Duplicate Entry </h5>

                                          <?php
                                          if ($question_options != '' || $question_options != null)
                                          $options = json_decode($question_options);
                                          else
                                          $options = array();
                                            for ($i = 0; $i < $question_number_options; $i++):
                                            ?>

                                            <div class="col-sm-12">
                                              <input type="text" placeholder="Enter Answer..." value="<?php echo $submitted_answer_script[$i]; ?>" class="form-control txt_enumeration-<?php echo $row['question_bank_id']; ?>" name="<?php echo $row['question_bank_id'].'[]'; ?>">
                                            </div>

                                            <?php 

                                            endfor;

                                          endif;?>

                                          <div class="container">

                                      <div class="row">
                                        
                                        <div id="prv<?php echo $active2;?>" class="" style="display: none;">
                                            
                                          <span id="btn_prev<?php echo $active2;?>" class="btn btn-primary  btn-block" onclick="prev('<?php echo 'tab'.$prev_id?>','<?php echo 'tab'.$previous_id?>','<?php echo $prev_id; ?>', '<?php echo $total_questions; ?>')">
                                            <span class="fa fa-arrow-left"></span> Previous
                                          </span>

                                        </div>

                                        <div class="col-md-12" id="nxt<?php echo $active2;?>">
                                            
                                          <span id="btn_next<?php echo $active2;?>" class="btn btn-primary btn-block" onclick="next('<?php echo 'tab'.$next_id?>','<?php echo 'tab'.$previous_id?>','<?php echo $next_id; ?>', '<?php echo $total_questions; ?>')">
                                            <span class="fa fa-arrow-right"></span> Next
                                          </span>

                                        </div>

                                      </div>

                                    </div>

                                   </div>

                                </div>

                              </div>

                              <?php endforeach;?>
                              
                           </div>

                        </div>

                     </div>

                  </div>

               </div>

               <input type="hidden" value="<?php echo $datainfo;?>" id="datainfo" name="datainfo">
               <div class="col-sm-12 text-center" style="display: none;">
                  <button class="btn btn-rounded btn-success text-center"  id="subbutton">Finish Exam</button>
               </div>

               <span style="display: none;" class="btn btn-success" id="btn_sub" onclick="btn_save();">Save</span>

            </form> 
         </div>
      </div>
   </div>
</div>

<?php foreach ($questions_essay as $question): ?>
<script type="text/javascript">
$(document).ready(function() 
 {
   $.ajax({
      
          url:"<?php echo base_url();?>student/view_essay_froala/<?php echo $question['question_bank_id']?>",
          type:'POST',
          beforeSend:function(){
           $('#id-<?php echo $question['question_bank_id']; ?>').html('<h3 class="text-danger text-center"> Please wait loading data...</h3>');
          },
          success:function(result)
          {
             
              $('#id-<?php echo $question['question_bank_id']; ?>').html(result);
           
          }

        });

 });
</script>
<?php endforeach; ?>

<script type="text/javascript">

  function btn_save_exam(){

    swal({
    title: "Are you sure ?",
    text: "You want to save this exam?",
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#5bc0de",
   confirmButtonText: "Yes, Save",
   closeOnConfirm: true
   },
   function(isConfirm){
 
     if (isConfirm) 
     {        
 
        auto_save();
 
     } 
     else 
     {
 
     }
 
   });

    

  }

  function finish_examination(){

    auto_save();
    submit_online_exam();

  }

  function next(next_id,previous_id,next_id_number,total_questions){

    if(Number(next_id_number) == Number(total_questions)){

      $('#btn_next'+next_id_number).addClass('btn-success');
      $('#btn_next'+next_id_number).html('<span class="fa fa-check"></span> Finish Exam');

    }

    if(Number(next_id_number) > Number(total_questions)){
      auto_save();
      submit_online_exam();
    }else{

      $('#'+previous_id+'').removeClass('active');
      $('#'+next_id+'').addClass('active');
      //$('html, body').animate({scrollTop:0}, '300');
      $('#prv'+next_id_number).css('display','inline');
      $('#prv'+next_id_number).addClass('col-md-6');

      $('#nxt'+next_id_number).removeClass('col-md-12');
      $('#nxt'+next_id_number).addClass('col-md-6');

      //auto_save();

    }

  }

  function prev(next_id,previous_id,next_id_number,total_questions){

    $('#'+next_id+'').addClass('active');
    $('#'+previous_id+'').removeClass('active');

    if(Number(next_id_number) == 1){

      $('#btn_prev'+next_id_number).css('display','none');
      $('#nxt'+next_id_number).removeClass('col-md-6');
      $('#nxt'+next_id_number).addClass('col-md-12');

    }

  }

function auto_save(){

  $.ajax({

        url:'<?php echo base_url();?>student/submit_online_exam/<?php echo $online_exam_id;?>',
        method:'POST',
        data:$("form#answer_script").serialize(),
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
         title: 'Exam successfully saved.'
         });
        }

  });

}

function submit_online_exam(){

swal({
    title: "Are you sure ?",
    text: "You want to finish this exam?",
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#5bc0de",
   confirmButtonText: "Yes, Finish",
   closeOnConfirm: true
   },
   function(isConfirm){
 
     if (isConfirm) 
     {        
 
        var datainfo = $('#datainfo').val();
        $.ajax({

              url:'<?php echo base_url();?>student/SubmitExam/<?php echo $online_exam_id;?>',
              method:'POST',
              data:{datainfo:datainfo},
              cache:false,
              success:function(data)
              {
                window.location="<?php echo base_url();?>student/online_exams/" + datainfo;
              }

        });
 
     } 
     else 
     {
 
     }
 
   });
}

</script>

<script>

   $(document).on("keydown", ":input:not(textarea)", function(event) {
     if (event.key == "Enter") {
       //alert(1);
       event.preventDefault();
     }
   });
   
</script>
<script type="text/javascript">
  
   function submit_exam(){
   
      swal({
        title: "Are you sure ?",
        text: "You want to finish this exam?",
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
 
</script>

<script type="text/javascript">

   var timer_starting_hour   = <?php echo $total_hour;?>;
   document.getElementById("hour_timer").innerHTML = timer_starting_hour;
   var timer_starting_minute   = <?php echo $total_minute;?>;
   document.getElementById("minute_timer").innerHTML = timer_starting_minute;
   var timer_starting_second   = <?php echo $total_second;?>;
   document.getElementById("second_timer").innerHTML = timer_starting_second;
   var timer = timer_starting_second;
  
   var mytimer = setInterval(function () {
    run_timer();
   }, 1000);

   function run_timer() 
   {
     if (timer == 0 && timer_starting_minute == 0 && timer_starting_hour == 0) {
         //$("#answer_script").submit();

        $('#btn_sub').click();

        clearTimeout(mytimer);

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

   function btn_save(){

    auto_save();

    var datainfo = $('#datainfo').val();

    $.ajax({

      url:'<?php echo base_url();?>student/SubmitExam/<?php echo $online_exam_id;?>',
      method:'POST',
      data:{datainfo:datainfo},
      cache:false,
      success:function(data)
      {
          window.location="<?php echo base_url();?>student/online_exams/" + datainfo;
      }

    });

   }

</script>

<script type="text/javascript">

   var timer2 =  <?php echo $total_duration2;?>;
  
   var startTime = setInterval(function () {

    //run_timer_save_exam();

   }, 1000);

   function run_timer_save_exam() 
   {

    console.log(timer2--);

    if(timer2 == 0){

      auto_save();

      timer2 = <?php echo $total_duration2; ?>;

      timer2 --;

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