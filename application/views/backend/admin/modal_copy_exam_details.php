<?php 

$exam_details = $this->db->get_where('online_exam', array('online_exam_id' => $param2))->row_array();

?>

<div class="modal-body">
   <div class="modal-header" style="background-color:#00579c">
      <h6 class="title" style="color:white"><?php echo get_phrase('copy_exam_to:');?></h6>
   </div>
   <div class="ui-block-content">
      <div class="row">
         <div class="col-md-12">
            <?php //echo form_open(base_url() . 'admin/online_quiz/copy_quiz/'.$data, array('enctype' => 'multipart/form-data')); ?>
            <form enctype="multipart/form-data" id="section_update" onsubmit="event.preventDefault();">
            <div class="row">
               <div class="col-md-4">

                <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('select_section');?></label>
                     <div class="select">
                        <select id="sec_id" required="" name="sec_id" onchange="subject_holder(this.value);">
                           <option value="0"><?php echo get_phrase('select');?></option>
                           <?php 
                           $class = $this->db->get_where('section', array('class_id' => $exam_details['class_id']))->result_array();

                           foreach($class as $row):
                           ?>
                           <option value="<?php echo $row['section_id'];?>"><?php echo $row['name'];?></option>
                           <?php endforeach;?>
                        </select>
                     </div>
                </div>
               </div>
               <div class="col-md-8">
                <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('select_subject');?></label>
                     <div class="select">
                        <select name="sub_id" required id="sub_holder">
                                <option value=""><?php echo get_phrase('select');?></option>
                            </select>
                     </div>
                </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-8">
                  <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('title');?></label>
                     <div class="input-group">
                        <input type="text" class="form-control" id="exam_title" name="exam_title" value="<?php echo $exam_details['title']; ?>">
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('date');?></label>
                     <div class="input-group">
                        <input type='date' id="exam_date" name="exam_date"  value="<?php echo date('yy-m-d', $exam_details['exam_date']); ?>"/>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-3">
                  <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('start_time');?></label>
                     <input type="time" required="" id="time_start" name="time_start" class="form-control" value="<?php echo $exam_details['time_start']; ?>">
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('end_time');?></label>
                     <input type="time" required="" id="time_end" name="time_end" class="form-control" value="<?php echo $exam_details['time_end']; ?>">
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('minimum_percentage');?></label>
                     <div class="input-group">
                        <input type="number" min="0" max="100" id="minimum_percentage" required="" class="form-control" placeholder="0 to 100" name="minimum_percentage" value="<?php echo $exam_details['minimum_percentage']; ?>">
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('select_semester');?></label>
                     <div class="select">
                        <select name="semester_id" id="sem_id">
                           <option value=""><?php echo get_phrase('select');?></option>
                                 <?php $cl = $this->db->get('exam')->result_array();
                                    foreach($cl as $row):
                                    ?>
                                 <option value="<?php echo $row['exam_id'];?>" <?php if($exam_details['semester_id'] == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                 <?php endforeach;?>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="col-form-label" for=""><?php echo get_phrase('description');?></label>
               <div class="input-group">
                  <textarea class="form-control" name="instruction" rows="3"><?php echo $exam_details['instruction']; ?></textarea>
               </div>
            </div>
            <input type="hidden" name="online_exam_id" id="online_exam_id" value="<?php echo $param2; ?>">
            <div class="form-group">
               <div class="col-sm-12" style="text-align: center;">
                  <button type="submit" class="btn btn-success" onclick="copy_section();"><?php echo get_phrase('save');?></button>
               </div>
            </div>
            </form>
            <?php //echo form_close();?>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">

    function copy_section(){

        var sec_id = $('#sec_id').val();
        var exam_title = $('#exam_title').val();
        var exam_date = $('#exam_date').val();
        var time_start = $('#time_start').val();
        var time_end = $('#time_end').val();
        var minimum_percentage = $('#minimum_percentage').val();
        var semester_id = $('#sem_id').val();

        if(sec_id == 0){
            swal("LMS", "Please select Section", "info");
            $('#sec_id').focus();
        }else if(exam_title == ''){
            swal("LMS", "Please enter quiz title", "info");
            $('#exam_title').focus();
        }else if(exam_date == ''){
            swal("LMS", "Please enter quiz date", "info");
            $('#exam_date').focus();
        }else if(time_start == ''){
          swal("LMS", "Please enter time start", "info");
            $('#time_start').focus();
        }else if(time_end == ''){
          swal("LMS", "Please enter time end", "info");
            $('#time_end').focus();
        }else if(minimum_percentage == ''){
          swal("LMS", "Please enter minimum percentage", "info");
            $('#minimum_percentage').focus();
        }else if(semester_id == ''){
          swal("LMS", "Please enter semester", "info");
            $('#sem_id').focus();
        }else{

            $.ajax({

              url:'<?php echo base_url();?>admin/copy_exam',
              method:'POST',
              data:$("form#section_update").serialize(),
              cache:false,
              success:function(data)
              {

                if(data == 1){

                  swal("LMS", "Exam successfully copied.", "success");
                  $('#exampleModal').modal('hide');

                }else{

                   swal("LMS", "Error on adding data", "error");

                } 

              }

            });
        }
    }

    function subject_holder(section_id) 
         {
         $.ajax({
              url: '<?php echo base_url();?>admin/get_subjectss/' + section_id ,
              success: function(response)
              {
                $('#sub_holder').html(response);
                //jQuery('#sub_holder').html(response);
              }
          });
         }
</script>

