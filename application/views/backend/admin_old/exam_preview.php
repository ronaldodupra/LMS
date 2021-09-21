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

<?php $questions_number = $this->db->get_where('question_bank', array('online_exam_id' => $online_exam_id))->num_rows();?>
<?php

   $datainfo = base64_encode($this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row()->class_id.'-'.$this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row()->section_id.'-'.$this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row()->subject_id);
  
   $online_exam_row = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row();
   
   $questions = $this->db->query("SELECT t1.* FROM question_bank t1 WHERE t1.`online_exam_id` = '$online_exam_id' ORDER BY TYPE,RAND() ASC")->result_array();
   
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
            <h4><?php echo $online_exam_row->title;?> (Testing Exam)</h4>
            <a href="<?php echo base_url();?>admin/examroom/<?php echo $online_exam_id; ?>" class="btn btn-rounded btn-info text-center"><span class="fa fa-arrow-left"> </span> <?php echo get_phrase('Back');?></a>
         </div>
      </div>
      <hr>
      <div class="content-i">
         <div class="content-box">
            <form class="" action="<?php echo base_url();?>student/submit_online_exam/<?php echo $online_exam_id;?>/" method="post" enctype="multipart/form-data" id="answer_script">
               <div class="row">
                  <?php $var = 0; $id1 = 1; $id2 = 1; $id3=1; $id4 =1; $count = 1; foreach ($questions as $question): $var++; ?>
                  <element class="col-sm-12 col-aligncenter page " id="page<?php echo $var;?>">
                     <div class="pipeline white lined-primary">
                        <div class="pipeline white lined-info">
                           <h6 class="text-primary">Question Type: <strong><?php echo strtoupper(str_replace('_', ' ', $question['type'])); ?></strong>  </h6>
                           <h5 class="text-danger"><?php 
                              $q_type = $question['type'];
                              
                              $direction = $this->db->query("SELECT * from tbl_exam_directions where question_type = '$q_type' and online_exam_id = '$online_exam_id'");
                              
                              if($direction->num_rows() > 0){
                              echo 'Direction: '.$direction->row()->directions;
                              }else{
                              echo '';
                              }
                              
                              ?></h5>
                        </div>
                        <div class="pipeline-header">
                           <h5><b><?php echo $count++;?>.</b>  
                              <?php echo ($question['type'] == 'fill_in_the_blanks') ? str_replace('_', '__________', $question['question_title']) : $question['question_title']; ?>
                           </h5>
                           <p class="text-center">
                              <?php $img = $question['image'];
                                 if($img <> ''){ ?>
                              <img src="<?php echo base_url('uploads/online_exam/'.$question['image']);?>" class="img-fluid img-responsive img-thumbnail" width="100%;">
                              <?php }else{ ?>
                              <?php } ?>
                           </p>

                           <?php if ($question['type'] == 'enumeration' or $question['type'] == 'fill_in_the_blanks'){ ?>
                               <span>Point(s) per item: <?php echo number_format($question['mark']);?></span>
                           <?php }else{ ?>
                               <span>Points: <?php echo number_format($question['mark']);?></span>
                           <?php } ?>

                        </div>
                        <!-- Multiple Choices -->
                        <?php if ($question['type'] == 'multiple_choice'): ?>
                        <?php
                           $correct_answer = json_decode($question['correct_answers']);
                           
                           $a = range(0,$question['number_of_options']-1);
                           
                           shuffle($a);
                           
                           $array = array_slice($a, 0, $question['number_of_options']);
                           
                           if ($question['options'] != '' || $question['options'] != null)
                              $options = json_decode($question['options']);
                           else
                              $options = array();
                           
                           foreach($array as $value){ ?>
                        <div class="col-sm-12">
                           <label class="containers">  <b> <?php echo $options[$value];?></b>
                           <input type="checkbox" disabled="" <?php if($value == $correct_answer[0] - 1) echo 'checked';?> name="<?php echo $question['question_bank_id'].'[]'; ?>" value="<?php echo $value + 1;?>">
                           <span class="checkmark"></span>
                           </label>    
                        </div>
                        <?php } ?>
                        <?php endif;?>
                        <!-- Multiple Choices -->
                        <!-- True or False -->
                        <?php if ($question['type'] == 'true_false'): ?>
                        <div class="skills-item">
                           <div class="skills-item-info">
                              <span class="skills-item-title">
                                 <span class="radio">
                                    <h6><label>
                                       <input type="radio" <?php if($question['correct_answers'] == 'true') echo 'checked';?> name="<?php echo $question['question_bank_id'].'[]'; ?>" value="true"><span class="circle"></span><span class="check"></span>
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
                                       <input type="radio" <?php if($question['correct_answers'] == 'false') echo 'checked';?> name="<?php echo $question['question_bank_id'].'[]'; ?>" value="false"><span class="circle"></span><span class="check"></span>
                                       <?php echo get_phrase('false');?>
                                       </label>
                                    </h6>
                                 </span>
                              </span>
                           </div>
                        </div>
                        <?php endif; ?>
                        <!-- True or False -->
                        <!-- Fill in the blanks -->
                        <?php if ($question['type'] == 'fill_in_the_blanks'):?>
                        <div class="col-md-12">
                           <h5 class="text-primary">Answers in chronological order: <?php echo $question['options'] ?> </h5>
                        </div>
                        <?php endif; ?>
                        <!-- Fill in the blanks -->
                        <!-- Identification --> 
                        <?php if ($question['type'] == 'identification'): 
                           $suitable_words = implode(',', json_decode($question['correct_answers']));
                        ?>
                        <div class="col-md-12">
                           <h5 class="text-primary">Answer: <?php echo $suitable_words; ?> </h5>
                        </div>
                        <?php endif; ?>
                        <!-- Identification --> 
                        <!-- Image -->  
                        <?php if ($question['type'] == 'image'): ?>
                        <div class="row">
                           <?php 
                              $correct_answer = json_decode($question['correct_answers']);
                              
                              $a = range(0,$question['number_of_options']-1);
                              
                              shuffle($a);
                              
                              $array = array_slice($a, 0, $question['number_of_options']);
                              
                              if ($question['options'] != '' || $question['options'] != null)
                              $options = json_decode($question['options']);
                              else
                              $options = array();
                              foreach($array as $value){ ?>
                           <div class="col-sm-4">
                              <label class="containers">
                              <img class="img-fluid img-responsive img-thumbnail" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo $options[$value];?>');" src="<?php echo base_url();?>uploads/online_exam/<?php echo $options[$value];?>">
                              <input type="radio" disabled="" <?php if($value == $correct_answer[0] - 1) echo 'checked';?> name="<?php echo $question['question_bank_id'].'[]'; ?>" value="<?php echo $value + 1;?>">
                              <span class="checkmark"></span>
                              </label>   
                           </div>
                           <?php } ?>
                        </div>
                        <?php endif;?>
                        <!-- Image --> 
                        <!-- Enumeration --> 
                        <?php if ($question['type'] == 'enumeration'): ?>
                        <div class="col-md-12">
                           <h5 class="text-primary">Answer Keys: <?php echo $question['options'] ?> </h5>
                        </div>
                        <?php endif; ?>
                        <!-- Enumeration -->     
                     </div>
                  </element>
                  <?php endforeach; ?>
                  <div class="col-sm-12" style="margin-top: -40px;">
                     <ul id="pagination-demo" class="pagination justify-content-center"></ul>
                  </div>
               </div>
               <input type="hidden" value="<?php echo $datainfo;?>" name="datainfo">
               <div class="col-sm-12 text-center" style="display: none;">
                  <button class="btn btn-rounded btn-success text-center" id="subbutton"><?php echo get_phrase('finish_exam');?></button>
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
</script>
<script type="text/javascript">
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