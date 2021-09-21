<?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;

$info = base64_decode($data); 
$ex = explode('-', $info);

$subject_data = $this->db->get_where('subject', array('subject_id' => $ex[2]))->row_array();

$dept = $this->db->query("SELECT b.`department_id` FROM subject a LEFT JOIN class b ON a.`class_id` = b.`class_id` WHERE a.`subject_id` = '$ex[2]'")->row()->department_id;

  if ($dept == 1 OR $dept == 2) {
    $categ = 1;
  }
  elseif ($dept == 3 OR $dept == 4) {
    $categ = 2;
  }

?>
<style type="text/css">                    
  .text_ellipsis{
    max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .display_none{
    display: none;
  }

</style>
<div class="content-w">
   <?php include 'fancy.php';?>
   <div class="header-spacer"></div>
   <div class="cursos cta-with-media" style="background: #<?php echo $subject_data['color'];?>;">
      <div class="cta-content">
         <div class="user-avatar">
            <?php 
               if($subject_data['icon'] != null || $subject_data['icon'] != ""){
                 $imgs = base_url()."uploads/subject_icon/". $subject_data['icon'];
               }else{
                 $imgs = base_url()."uploads/subject_icon/default_subject.png";
               }
               ?>
            <img alt="" src="<?php echo $imgs;?>" style="width:60px;">
         </div>
         <h3 class="cta-header"><?php echo $subject_data['name'];?> - <small>List of questions</small></h3>
         <small style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"</small>
      </div>
   </div>
   <div class="conty">
      <div class="all-wrapper no-padding-content solid-bg-all">
         <div class="layout-w">
            <div class="content-w">
               <div class="content-i">
                  <div class="content-box">
                     <div class="aec-full-message-w">
                        <div class="aec-full-message">
                           <div class="container-fluid" style="background-color: #f2f4f8;">
                              <br>
                              <div class="col-sm-12">
                                 <div class="row">
                                    <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                                       <div class="form-group label-floating is-select">
                                          <label class="control-label">Filter By Grading</label>
                                          <div class="select">
                                             <select name="semester_id" id="semester_id" oninput="load_exam_quiz_q2(); load_exam_quiz_questionnares();" onchange="load_exam_quiz_q2();">
                                              <option value="0" selected="">ALL</option>
                                                <?php $cl = $this->db->query("SELECT * FROM exam WHERE category = '$categ'")->result_array();
                                                   foreach($cl as $row):
                                                   ?>
                                                <option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
                                                <?php endforeach;?>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                                       <div class="form-group label-floating is-select">
                                          <label class="control-label">Filter By Exam/Quiz</label>
                                          <div class="select">
                                             <select name="exam_quiz_id" id="exam_quiz_id" onchange="load_exam_quiz_questionnares();">
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                       <div class="form-group label-floating is-select">
                                          <label class="control-label">Search Question</label>
                                          <input type="text" class="form-control" id="filter" name="" style="background: #fff;">
                                       </div>
                                    </div>
                                    <div class="col col-lg-2 col-md-6 col-sm-12 col-12">
                                       <button class="btn btn-success text-center btn-block" onclick="preview_questions();"><span class="fa fa-print"></span> Preview </button>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-12">
                                <div class="row mb-2">
                                  <div class="col-md-4">
                                    <button class="btn btn-primary btn-block mt-1" disabled="" onclick="load_exam_quiz_add_exists();" id="btn_add_exist"><span class="fa fa-plus fa-lg"></span> Add to Existing Online Exam or Quiz </button>
                                  </div>
                                  <div class="col-md-4">
                                    <button class="btn btn-secondary btn-block mt-1" disabled="" data-toggle="modal" data-target="#new_exam_modal" id="btn_add_new_exam"><span class="fa fa-plus fa-lg"></span> Create Online Exam using selected Questions </button>
                                  </div>
                                  <div class="col-md-4">
                                    <button class="btn btn-warning btn-block mt-1" data-toggle="modal" data-target="#new_quiz_modal" disabled="" id="btn_add_new_quiz"><span class="fa fa-plus fa-lg"></span> Create Online Quiz using selected Questions </button>
                                  </div>
                                </div>

                                <div class="row" style="display: none;" id="div_add_exist_q_to_exam_quiz">
                                    <div class="col-md-4">
                                      <div class="form-group label-floating is-select">
                                        <label class="control-label">Copy Selected questions to:</label>
                                        <div class="select">
                                          <select name="exam_quiz_id_copy" id="exam_quiz_id_copy"></select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <button class="btn btn-success btn-lg" id="btn_copy_questions"><span class="fa fa-copy fa-lg"></span> Copy Selected questions </button>
                                      <button class="btn btn-danger btn-lg" id="btn_cancel_copy"><span class="fa fa-times fa-lg"></span> Cancel </button>
                                    </div>
                                </div>
                              </div>
                              <!-- LOAD DATA -->
                              <input type="hidden" id="count_check" value="0">
                              <div class="col-sm-12">
                                  <div class="table table-responsive">
                                    <table class="table table-responsive table-hover table-striped">
                                        <thead class="text-white" style="background: #1b55e2;">
                                          <tr>
                                            <th style="width: 5%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="height: 16px" type="checkbox" id="check_all_q" title="Check All"></th>
                                            <th class="text-center">No.</th>
                                            <th>Semester</th>
                                            <th>Question</th>
                                            <th>Type</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody class="table-sm" id="tbl_questionnares"></tbody>
                                    </table>
                                  </div>
                              </div>
                              <!-- LOAD DATA -->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <a class="back-to-top" href="javascript:void(0);">
         <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
         </a>
         <div class="display-type"></div>
      </div>
   </div>
</div>

<input type="hidden" value="<?php echo $ex[0];?>" name="class_id" id="class_id">
<input type="hidden" value="<?php echo $ex[1];?>" name="section_id" id="section_id">
<input type="hidden" value="<?php echo $ex[2];?>" name="subject_id" id="subject_id">

<!-- ONLINE EXAM FORM -->
<div class="modal fade" id="new_exam_modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="crearadmin" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document" style="width: 70%;">
      <div class="modal-content" style="margin-top:0px;">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-body">
            <div class="modal-header" style="background-color:#00579c">
               <h6 class="title" style="color:white"><?php echo get_phrase('new_exam');?></h6>
            </div>
            <div class="ui-block-content">
               <div class="row">
                  <div class="col-md-12">
                     <form enctype="multipart/form-data" id="form_add_exam" onsubmit="event.preventDefault();">
                      
                      <div class="row">

                        <div class="col-md-6">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('title');?></label>
                              <div class="input-group">
                                 <input type="text" class="form-control" id="exam_title" name="exam_title">
                              </div>
                           </div>
                        </div>

                        <div class="col-md-3">
                          
                          <label class="col-form-label" for=""><?php echo get_phrase('enable_random_question?');?></label>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="defaultInline1" name="is_random" value="1" checked="">
                            <label class="custom-control-label" for="defaultInline1">Yes</label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="defaultInline2" name="is_random" value="0">
                            <label class="custom-control-label" for="defaultInline2">No</label>
                          </div>

                        </div>

                       <div class="col-md-3">

                          <div class="form-group">
                            
                             <label class="col-form-label" for="">Select Exam Type</label>
                               
                               <div class="select">

                                  <select name="exam_type" id="exam_type" required="" onchange="load_exam_type()">
                                     <option value="open" selected="">Open</option>
                                     <!-- <option value="strict" disabled="">Strict</option> -->
                                     <option value="flexi">Flexi</option>
                                  </select>

                               </div>

                          </div>

                       </div>
                        
                     </div>

                     <div class="row open">

                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('date');?></label>
                                 <input type='date' class="form-control" name="exam_date" id="exam_date" value="<?php echo date('Y-m-d'); ?>"/>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('start_time');?></label>

                                 <input type="time" required="" onchange="check_time_range();" id="time_start" name="time_start" class="form-control" value="<?php echo date('H:i'); ?>">
                             
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('end_time');?></label>
                              
                                 <input type="time" onchange="check_time_range();" required="" id="time_end" name="time_end" class="form-control" value="<?php echo date('H:i', strtotime('+1 hour')) ?>">
                            
                           </div>
                        </div>

                     </div>

                     <div class="row flexi display_none">
                        
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('start_date');?></label>
                                <input type='date' class="form-control" onchange="check_date_range();" id="start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>"/>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('start_time');?></label>
                                <input type='time' class="form-control" onchange="check_date_range();" id="start_time" name="start_time" value="<?php echo date('H:i'); ?>"/>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('end_date');?></label>
                                <input type='date' class="form-control" onchange="check_date_range();" id="end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>"/>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('end_time');?></label>
                                <input type='time' class="form-control" onchange="check_date_range();" id="end_time" name="end_time" value="<?php echo date('H:i', strtotime('+1 hour')) ?>"/>
                           </div>
                        </div>

                     </div>

                     <div class="col-md-3 flexi display_none">

                        <div class="form-group">

                        <label class="col-form-label" for=""><?php echo get_phrase('duration');?></label>

                            <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                              <input type="text" value="01:00" autocomplete="off" id="duration" name="duration" class="form-control">
                            </div>

                        </div>
                    </div>

                     <div class="row">

                      <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('minimum_percentage');?></label>
                              <div class="input-group">
                                 <input type="number" class="form-control" min="0" max="100" placeholder="0 to 100" name="minimum_percentage" value="50" id="minimum_percentage">
                              </div>
                           </div>
                        </div>

                       <div class="col-md-3">

                          <div class="form-group">
                            
                             <label class="col-form-label" for=""><?php echo get_phrase('select_semester');?></label>
                               <div class="select">
                                  <select name="semester_ide" id="semester_ide" required="">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php $cl = $this->db->query("SELECT * FROM exam WHERE category = '$categ'")->result_array();
                                      foreach($cl as $row):
                                      ?>
                                    <option <?php if($row['status'] == 1) echo 'selected'?>  value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
                                    <?php endforeach;?>
                                  </select>
                               </div>
                          </div>
                       </div>


                       <div class="col-md-6">

                         <div class="form-group">

                          <label class="col-form-label" for=""><?php echo get_phrase('description');?></label>

                          <div class="input-group">

                             <textarea class="form-control" id="instruction" name="instruction" rows="4"></textarea>

                          </div>

                         </div>

                       </div>

                     </div>

                     <div class="col-md-12" id="time_validator" style="display: none;">
                       <h5 class="text-center text-danger"> Please check your time range... </h5>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-12" style="text-align: center;">
                           <button type="submit" id="btn_create_online_exam" class="btn btn-success"><?php echo get_phrase('save');?></button>
                        </div>
                     </div>

                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- ONLINE EXAM FORM -->

<!-- ONLINE QUIZ FORM -->
<div class="modal fade" id="new_quiz_modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="crearadmin" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document" style="width: 70%;">
      <div class="modal-content" style="margin-top:0px;">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-body">
            <div class="modal-header" style="background-color:#00579c">
               <h6 class="title" style="color:white"><?php echo get_phrase('new_quiz');?></h6>
            </div>
            <div class="ui-block-content">
               <div class="row">
                  <div class="col-md-12">
                     <form enctype="multipart/form-data" id="form_add_quiz" onsubmit="event.preventDefault();">
                       <div class="row">
                          <div class="col-md-6">
                             <div class="form-group">
                                <label class="col-form-label" for=""><?php echo get_phrase('title');?></label>
                                <div class="input-group">
                                   <input type="text" required="" class="form-control" name="quiz_title">
                                </div>
                             </div>
                          </div>
                          <div class="col-md-3">
                             <label class="col-form-label" for=""><?php echo get_phrase('enable_random_question?');?></label>
                             <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="defaultInline1" name="is_random" value="1" checked="">
                                <label class="custom-control-label" for="defaultInline1">Yes</label>
                             </div>
                             <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="defaultInline2" name="is_random" value="0">
                                <label class="custom-control-label" for="defaultInline2">No</label>
                             </div>
                          </div>
                          <div class="col-md-3">
                             <div class="form-group">
                                <label class="col-form-label" for=""><?php echo get_phrase('date');?></label>
                                <input type='date' class="form-control"  value="<?php echo date('Y-m-d'); ?>" name="quiz_date"/>
                             </div>
                          </div>
                       </div>
                       <div class="row">
                          <div class="col-md-4">
                             <div class="form-group">
                                <label class="col-form-label" for=""><?php echo get_phrase('start_time');?></label>
                                <input type="time" required="" onchange="check_time_rangeq();" id="time_startq" name="time_startq" class="form-control" value="<?php echo date('H:i'); ?>">
                             </div>
                          </div>
                          <div class="col-md-4">
                             <div class="form-group">
                                <label class="col-form-label" for=""><?php echo get_phrase('end_time');?></label>
                                <input type="time" required="" onchange="check_time_rangeq();" id="time_endq" name="time_endq" class="form-control" value="<?php echo date('H:i', strtotime('+1 hour')) ?>">
                             </div>
                          </div>
                          <div class="col-md-4">
                             <div class="form-group">
                                <label class="col-form-label" for=""><?php echo get_phrase('minimum_percentage');?></label>
                                <div class="input-group">
                                   <input type="number" required="" class="form-control" min="0" max="100" placeholder="0 to 100" name="minimum_percentageq" id="minimum_percentageq" value="50">
                                </div>
                             </div>
                          </div>
                       </div>
                       <div class="row">
                          <div class="col-md-4">
                             <div class="form-group">
                                <label class="col-form-label" for=""><?php echo get_phrase('select_semester');?></label>
                                <div class="select">
                                   <select required="" name="semester_idq" id="semester_idq">
                                      <option value="">Select</option>
                                      <?php $cl = $this->db->get('exam')->result_array();

                                        $active_sem = $this->db->query("SELECT exam_id from exam where status = 1")->row()->exam_id;
                                         foreach($cl as $row):
                                         ?>
                                      <option <?php if($active_sem == $row['exam_id']) echo 'selected';?> value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
                                      <?php endforeach;?>
                                   </select>
                                </div>
                             </div>
                          </div>
                          <div class="col-md-8">
                             <div class="form-group">
                                <label class="col-form-label" for=""><?php echo get_phrase('description');?></label>
                                <div class="input-group">
                                   <textarea class="form-control" name="instructionq" id="instructionq" rows="4"></textarea>
                                </div>
                             </div>
                          </div>
                       </div>
                       <div class="col-md-12" id="time_validatorq" style="display: none;">
                          <h5 class="text-center text-danger"> Please check your time range... </h5>
                       </div>
                       <div class="form-group">
                          <div class="col-sm-12" style="text-align: center;">
                             <button type="submit" id="btn_create_online_quiz" class="btn btn-success"><span class="fa fa-save fa-lg"></span> Save</button>
                             <button class="btn btn-danger" data-dismiss="modal"> <span class="fa fa-times fa-lg"></span> Cancel </button>
                          </div>
                       </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- ONLINE QUIZ FORM -->

<!-- VIEW ACTUAL QUESTION MODAL-->
<div class="modal fade" id="view_question_data" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="crearadmin" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document" style="width: 70%;">
      <div class="modal-content" style="margin-top:0px;">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-body">
            <div class="modal-header" style="background-color:#00579c">
               <h6 class="title" style="color:white"><?php echo get_phrase('new_quiz');?></h6>
            </div>
            <div class="ui-block-content">
               <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('question');?></label>
                      <div class="col-sm-12" id="view_question_froala"></div>
                  </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
           <button class="btn btn-block btn-danger" data-dismiss="modal"> <span class="fa fa-times"> </span>  Close </button>
         </div>
      </div>
   </div>
</div>

<!-- ONLINE EXAM JS -->

<script type="text/javascript">
  
  function load_exam_type(){

    var exam_type = $('#exam_type').val();

    if(exam_type == 'open'){

      $('.open').removeClass('display_none');
      $('.flexi').addClass('display_none');
      $('.strict').addClass('display_none');

    }else if(exam_type == 'strict'){

      $('.strict').removeClass('display_none');
      $('.flexi').addClass('display_none');
      $('.open').addClass('display_none');
      

    }else if(exam_type == 'flexi'){

      $('.flexi').removeClass('display_none');
      $('.strict').addClass('display_none');
      $('.open').addClass('display_none');

    } 


  }

</script>

<script type="text/javascript">
  function check_time_range(){

    var time_in = $('#time_start').val();
    var time_out = $('#time_end').val();

    if(time_in > time_out){
      $('#btn_submit').prop('disabled',true);
      $('#time_validator').css('display','block');
      $('#time_end').css('background','#e65252');
      $('#time_end').css('color','#fff');
    }else{
      $('#btn_submit').prop('disabled',false);
      $('#time_validator').css('display','none');
      $('#time_end').css('background','transparent');
      $('#time_end').css('color','#000');
    }

  }

  $('#btn_create_online_exam').click(function(){

    var exam_title = $('[name=exam_title]').val();
    var is_random = $('[name=is_random]').val();
    var exam_type = $('[name=exam_type]').val();
    var exam_date = $('[name=exam_date]').val();
    var time_start = $('[name=time_start]').val();
    var time_end = $('[name=time_end]').val();
    var start_date = $('[name=start_date]').val();
    var start_time = $('[name=start_time]').val();
    var end_date = $('[name=end_date]').val();
    var end_time = $('[name=end_time]').val();
    var duration = $('[name=duration]').val();
    var minimum_percentage = $('[name=minimum_percentage]').val();
    var semester_id = $('#semester_ide').val();
    var instruction = $('[name=instruction]').val();
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject_id = $('#subject_id').val();

    var id = [];
    $(':checkbox:checked').each(function(i){
        id[i] = $(this).val();
    });


    var mydata = {id:id,exam_title:exam_title,is_random:is_random,exam_type:exam_type,exam_date:exam_date,time_start:time_start,time_end:time_end,start_date:start_date,start_time:start_time,end_date:end_date,end_time:end_time,duration:duration,minimum_percentage:minimum_percentage,semester_id:semester_id,instruction:instruction,class_id:class_id,section_id:section_id,subject_id:subject_id};

    $.ajax({
      url:'<?php echo base_url();?>teacher/create_online_exam_with_q',
      method:'POST',
      data:mydata,
      cache:false,
      beforeSend:function(){
        $('#btn_create_online_exam').prop('disabled',true);
        $('#btn_create_online_exam').html('<span class="fa fa-save fa-spin fa-lg"></span> Saving New Exam... please wait...');
      },
      success:function(data)
      {
        
        console.log(data);

        if(data == ''){

           const Toast = Swal.mixin({
             toast: true,
             position: 'top-end',
             showConfirmButton: false,
             timer: 8000
           }); 
           Toast.fire({
             type: 'success',
             title: 'New Exam successfully saved.'
           });
           load_exam_quiz_questionnares();
           $('#btn_create_online_exam').prop('disabled',false);
           $('#btn_create_online_exam').html('<span class="fa fa-save fa-lg"></span> Save');
           $('#form_add_exam')[0].reset();
           $('#new_exam_modal').modal('hide');
           $('#btn_add_exist').prop('disabled',true);
           
           $('#btn_add_new_exam').prop('disabled',true);
           $('#btn_add_new_exam').html('<span class="fa fa-plus fa-lg"></span>  Create Online Exam using selected Questions')
           $('#btn_add_new_quiz').html('<span class="fa fa-plus fa-lg"></span>  Create Online Quiz using selected Questions')
           $('#btn_add_new_quiz').prop('disabled',true);
           
           $('#check_all_q').prop('checked',false);


        }else{
          swal("LMS", "Error on updating data", "info");
        }

      }

    });

  });

</script>
<!-- ONLINE EXAM JS -->

<!-- ONLINE QUIZ JS -->
<script type="text/javascript">

  function check_time_rangeq(){

    var time_in = $('#time_startq').val();
    var time_out = $('#time_endq').val();

    if(time_in > time_out){
      $('#btn_create_online_quiz').prop('disabled',true);
      $('#time_validatorq').css('display','block');
      $('#time_endq').css('background','#e65252');
      $('#time_endq').css('color','#fff');
    }else{
      $('#btn_create_online_quiz').prop('disabled',false);
      $('#time_validatorq').css('display','none');
      $('#time_endq').css('background','transparent');
      $('#time_endq').css('color','#000');
    }

  }  

  $('#btn_create_online_quiz').click(function(){

    var quiz_title = $('[name=quiz_title]').val();
    var is_random = $('[name=is_random]').val();
    var quiz_date = $('[name=quiz_date]').val();
    var time_startq = $('[name=time_startq]').val();
    var time_endq = $('[name=time_endq]').val();
    var minimum_percentageq = $('[name=minimum_percentageq]').val();
    var semester_idq = $('[name=semester_idq]').val();
    var instructionq = $('[name=instructionq]').val();
    var class_id = $('[name=class_id]').val();
    var section_id = $('[name=section_id]').val();
    var subject_id = $('[name=subject_id]').val();

    var id = [];
    $(':checkbox:checked').each(function(i){
        id[i] = $(this).val();
    });

     var mydata = {id:id,quiz_title:quiz_title,is_random:is_random,quiz_date:quiz_date,time_startq:time_startq,time_endq:time_endq,minimum_percentageq:minimum_percentageq,semester_idq:semester_idq,instructionq:instructionq,class_id:class_id,section_id:section_id,subject_id:subject_id};

    $.ajax({
      url:'<?php echo base_url();?>teacher/create_online_quiz_with_q',
      method:'POST',
      data:mydata,
      cache:false,
      beforeSend:function(){
        $('#btn_create_online_quiz').prop('disabled',true);
        $('#btn_create_online_quiz').html('<span class="fa fa-save fa-spin fa-lg"></span> Saving New Quiz...please wait...');
      },
      success:function(data)
      {

        if(data == ''){

           const Toast = Swal.mixin({
             toast: true,
             position: 'top-end',
             showConfirmButton: false,
             timer: 8000
           }); 
           Toast.fire({
             type: 'success',
             title: 'New Quiz successfully saved.'
           });

           load_exam_quiz_questionnares();
           $('#btn_create_online_quiz').prop('disabled',false);
           $('#btn_create_online_quiz').html('<span class="fa fa-save fa-lg"></span> Save');
           $('#form_add_quiz')[0].reset();
           $('#new_quiz_modal').modal('hide');
           $('#btn_add_exist').prop('disabled',true);
           $('#btn_add_new_exam').prop('disabled',true);
           $('#btn_add_new_exam').html('<span class="fa fa-plus fa-lg"></span>  Create Online Exam using selected Questions')
           $('#btn_add_new_quiz').html('<span class="fa fa-plus fa-lg"></span>  Create Online Quiz using selected Questions')
           $('#btn_add_new_quiz').prop('disabled',true);
           $('#check_all_q').prop('checked',false);
           
        }else{
          swal("LMS", "Error on updating data", "info");
        }

      }

    });

  });

</script>
<!-- ONLINE QUIZ JS -->
<script type="text/javascript">
  
  load_exam_quiz_q2();
  load_exam_quiz_questionnares();

  window.onload=function(){    

    $("#filter").keyup(function() {
      var filter = $(this).val(),
      count = 0;
      $('#tbl_questionnares tr').each(function() {
        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
          $(this).hide();
        } else {
          $(this).show();
          count++;
        }
      });
    });

  }

  function load_exam_quiz_q2(){

    var class_id = <?php echo $ex[0]; ?>;
    var section_id = <?php echo $ex[1]; ?>;
    var subject_id = <?php echo $ex[2]; ?>;
    var semester_id = $('#semester_id').val();

    $.ajax({
      url:"<?php echo base_url();?>teacher/load_exam_quiz_q/",
      method:'POST',
      data:{semester_id:semester_id,class_id:class_id,section_id:section_id,subject_id:subject_id},
      success:function(result)
      {
        console.log(result);
        $('#exam_quiz_id').html(result);
      }
    });

  }

  function load_exam_quiz_questionnares(){
    var class_id = <?php echo $ex[0]; ?>;
    var section_id = <?php echo $ex[1]; ?>;
    var subject_id = <?php echo $ex[2]; ?>;
    var semester_id = $('#semester_id').val();
    var exam_quiz_id = $('#exam_quiz_id').val();
    $.ajax({
        url:"<?php echo base_url();?>teacher/load_exam_quiz_questionnares/",
        method:'POST',
        beforeSend:function(){
          $('#tbl_questionnares').html("<td colspan='6' class='text-center'> Loading questionnares ...  </td>");
        },
        data:{semester_id:semester_id,class_id:class_id,section_id:section_id,subject_id:subject_id,exam_quiz_id:exam_quiz_id},
        success:function(result)
        {
          console.log(result);
          $('#tbl_questionnares').html(result);
        }
    });
  } 

  $(document).ready(function() {
    $("#check_all_q").change(function() {
       if (this.checked) {
           $(".checkbox_q").each(function() {
              this.checked=true;
              document.getElementById('btn_add_exist').disabled= false;
              document.getElementById('btn_add_new_exam').disabled= false;
              document.getElementById('btn_add_new_quiz').disabled= false;
           });
           var chks = $('.checkbox_q').filter(':checked').length
           $('#count_check').val(chks);
           $('#btn_copy_questions').html('<span class="fa fa-copy fa-lg"></span> Copy '+chks+' Selected Questions');
           $('#btn_add_new_exam').html('<span class="fa fa-plus fa-lg"></span> Create Online Exam using '+chks+' selected Questions');
           $('#btn_add_new_quiz').html('<span class="fa fa-plus fa-lg"></span> Create Online Quiz using '+chks+' selected Questions');
       } else {
          var chks = $('.checkbox_q').filter(':checked').length
          $('#btn_copy_questions').html('<span class="fa fa-copy fa-lg"></span> Copy Selected Questions');
          $('#btn_add_new_exam').html('<span class="fa fa-plus fa-lg"></span> Create Online Exam using selected Questions');
          $('#btn_add_new_quiz').html('<span class="fa fa-plus fa-lg"></span> Create Online Quiz using selected Questions');
          $('#count_check').val(0);
          $(".checkbox_q").each(function() {
            this.checked=false;
            document.getElementById('btn_add_exist').disabled= true;
            document.getElementById('btn_add_new_exam').disabled= true;
            document.getElementById('btn_add_new_quiz').disabled= true;
          });
       }
    });
  });

  function load_exam_quiz_add_exists(){
    $('#div_add_exist_q_to_exam_quiz').show('slow');
    var class_id = <?php echo $ex[0]; ?>;
    var section_id = <?php echo $ex[1]; ?>;
    var subject_id = <?php echo $ex[2]; ?>;
    $.ajax({
      url:"<?php echo base_url();?>teacher/load_exam_quiz_add_exists/",
      type:'POST',
      data:{class_id:class_id,section_id:section_id,subject_id:subject_id},
      success:function(result)
      {
        console.log(result);
        $('#exam_quiz_id_copy').html(result);
      }
    });
  }

  $('#btn_copy_questions').click(function(){

    var online_exam_id = $('#exam_quiz_id_copy').val();

    var id = [];
    $(':checkbox:checked').each(function(i){
        id[i] = $(this).val();
    });

    $.ajax({
      url:'<?php echo base_url();?>teacher/copy_question_exam_quiz',
      method:'POST',
      data:{id:id,online_exam_id:online_exam_id},
      cache:false,
      beforeSend:function(){
        $('#btn_copy_questions').prop('disabled',false);
        $('#btn_copy_questions').html('<span class="fa fa-copy fa-spin fa-lg"></span> Copying Selected Questions...');
      },
      success:function(data)
      {

        if(data == ''){

           const Toast = Swal.mixin({
             toast: true,
             position: 'top-end',
             showConfirmButton: false,
             timer: 8000
           }); 
           Toast.fire({
             type: 'success',
             title: 'Selected data successfully copied.'
           });

           $('#btn_copy_questions').html('<span class="fa fa-copy fa-lg"></span> Copy Selected questions');
           $('#btn_copy_questions').prop('disabled',false);

           
           $('#btn_add_new_exam').prop('disabled',true);
           $('#btn_add_new_exam').html('<span class="fa fa-plus fa-lg"></span>  Create Online Exam using selected Questions')
           $('#btn_add_new_quiz').html('<span class="fa fa-plus fa-lg"></span>  Create Online Quiz using selected Questions')
           $('#btn_add_new_quiz').prop('disabled',true);
           $('#check_all_q').prop('checked',false);
           $('#btn_add_exist').prop('disabled',true);
           $('#div_add_exist_q_to_exam_quiz').hide('slow');
           load_exam_quiz_questionnares();

        }else{
          swal("LMS", "Error on updating data", "info");
        }

      }

    });

  });

  $('#btn_cancel_copy').click(function(){
    $('#div_add_exist_q_to_exam_quiz').hide('slow');
  });

  function preview_questions(){
    //alert(0);
    var exam_quiz_id = $('#exam_quiz_id').val();

    var arr = exam_quiz_id.split("-");
    
    var online_exam_quiz_id = arr[0];

    var category = arr[1];

    if(online_exam_quiz_id > 0){
      //alert(online_exam_quiz_id);
      if(category == 'exam'){

        var loc = '<?php echo base_url();?>teacher/exam_preview_questions/' + online_exam_quiz_id;
        window.open(loc, "_blank");

      }else{
        var loc = '<?php echo base_url();?>teacher/quiz_preview_questions/' + online_exam_quiz_id;
        window.open(loc, "_blank");
      }

    }else{
      swal("LMS","Please Select Online Exam/Quiz", "info");
    }

  }

  function display_actual_question(question_id,category){

    var question_id = question_id;
    var category = category

    $.ajax({
      url:'<?php echo base_url();?>teacher/display_actual_question',
      method:'POST',
      data:{question_id:question_id,category:category},
      cache:false,
      success:function(data)
      { 
        console.log(data);
        $('#view_question_data').modal('show');
        view_question_froala(data);
      }

    });

  }

  function view_question_froala(data){
    var question = data;
    $.ajax({
      url:'<?php echo base_url();?>teacher/load_question_view_froala',
      method:'POST',
      data:{question:question},
      cache:false,
      success:function(data)
      { 
        console.log(data);
        $('#view_question_froala').html(data);
        $('#view_question_froala').css('pointer-events','none');
      }
    });
  }

  function delete_single_question(id,category){
    var id = id;
    var category = category;
    swal({
      title: "Are you sure?",
      text: "You want to remove this question?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#e65252",
      confirmButtonText: "Yes",
      closeOnConfirm: true
    },
    function(isConfirm){

      if(isConfirm) 
      {  
        
        $.ajax({
          url:'<?php echo base_url();?>teacher/delete_single_question',
          method:'POST',
          data:{id:id,category:category},
          cache:false,
          success:function(data)
          { 

            if(data == ""){
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 8000
              }); 
              Toast.fire({
                type: 'success',
                title: 'Question successfully removed'
              });
            }
            load_exam_quiz_questionnares()
          }
        });
      }

    });

  }

</script>