<?php 

$activity_details = $this->db->get_where('homework', array('homework_id' => $param2))->row_array();

?>

<div class="modal-body">
   <div class="modal-header" style="background-color:#00579c">
      <h6 class="title" style="color:white"><?php echo get_phrase('copy_activity_to:');?></h6>
   </div>
   <div class="ui-block-content">
      <div class="row">
         <div class="col-md-12">
            <?php //echo form_open(base_url() . 'admin/online_quiz/copy_quiz/'.$data, array('enctype' => 'multipart/form-data')); ?>
            <form enctype="multipart/form-data" id="copy_activity" onsubmit="event.preventDefault(); copy_activity();">
            
            <div class="row">

               <div class="col-md-4">

                <div class="form-group">

                     <label class="col-form-label" for=""><?php echo get_phrase('select_section');?></label>
                     
                     <div class="select">

                        <select id="sec_id" required="" name="sec_id" onchange="subject_holder(this.value);">
                           
                           <option value="0"><?php echo get_phrase('select');?></option>
                           <?php 
                           
                           $teacher_id =  $this->session->userdata('login_user_id');
                            
                           $class = $this->db->query("SELECT t3.`name` AS section,t2.`name` AS class,t1.`section_id` FROM subject t1 LEFT JOIN class t2 ON t1.`class_id` = t2.`class_id` LEFT JOIN section t3 ON t1.`section_id` = t3.`section_id` WHERE t1.`teacher_id` = '$teacher_id' GROUP BY t3.`section_id` ORDER BY class ASC")->result_array();

                           foreach($class as $row):
                           ?>

                           <option value="<?php echo $row['section_id'];?>"><?php echo $row['class'] . '-' .$row['section'] ;?></option>

                           <?php endforeach;?>

                        </select>

                     </div>

                </div>

               </div>

               <div class="col-md-8">

                <div class="form-group">

                     <label class="col-form-label" for=""><?php echo get_phrase('select_subject');?></label>
                     
                     <div class="select">
                        
                        <select name="sub_id" required="" id="sub_holder">
                                
                                <option value=""><?php echo get_phrase('select');?></option>
                            
                            </select>
                     
                     </div>
                
                </div>
               
               </div>
            
            </div>

            <div class="row">

               <div class="col-md-12">
                   <div class="form-group">
                        <label for=""> <?php echo get_phrase('title');?></label>
                        <input class="form-control" required="" name="title" value="<?php echo $activity_details['title'];?>" type="text">
                     </div>
               </div>
               
            </div>

            <div class="row">
                <div class="col-sm-4"> 
                   <div class="form-group label-floating is-select">
                      <label class="control-label"><?php echo get_phrase('select_semester');?></label>
                      <div class="select">
                         <select name="semester_id" required="" id="semester_id">
                            <option value=""><?php echo get_phrase('select');?></option>
                            <?php $ex = $this->db->get('exam')->result_array();
                               foreach($ex as $row1):
                               ?>

                            <option value="<?php echo $row1['exam_id'];?>" <?php if($activity_details['semester_id'] == $row1['exam_id']) echo 'selected';?>><?php echo $row1['name'];?></option>
                            <?php endforeach;?>

                         </select>
                      </div>
                   </div>
                </div>
                <div class="col-sm-4"> 
                   <div class="form-group label-floating is-select">
                      <label class="control-label"><?php echo get_phrase('select_category');?></label>
                      <div class="select">
                         <select name="category" required="" id="category">
                            <option value=""><?php echo get_phrase('select');?></option>
                            <?php $ex = $this->db->get('tbl_act_category')->result_array();
                               foreach($ex as $row1):
                               ?>

                            <option value="<?php echo $row1['id'];?>" <?php if($activity_details['category'] == $row1['id']) echo 'selected';?>><?php echo $row1['category'];?></option>
                            <?php endforeach;?>

                         </select>
                      </div>
                   </div>
                </div>
                <div class="col-sm-4"> 
                   <div class="form-group label-floating is-select">
                      <label class="control-label"><?php echo get_phrase('select_activity_type');?></label>
                      <div class="select">
                         <select name="activity_type" required="" id="activity_type">
                            <option value=""><?php echo get_phrase('select');?></option>
                            <?php $ex = $this->db->get('tbl_act_type')->result_array();
                               foreach($ex as $row1):
                               ?>

                            <option value="<?php echo $row1['id'];?>" <?php if($activity_details['activity_type'] == $row1['id']) echo 'selected';?>><?php echo $row1['activity_type'];?></option>
                            <?php endforeach;?>

                         </select>
                      </div>
                   </div>
                </div>

             </div>

             <div class="row">
                <div class="col-sm-4">
                   <div class="form-group">
                      <label for=""> <?php echo get_phrase('delivery_date');?></label>
                      <input type='text' placeholder="mm/dd/yyyy" required="" class="datepicker-here" data-position="top left" data-language='en' name="date_end" data-multiple-dates-separator="/" value="<?php echo $activity_details['date_end'];?>"/>
                   </div>
                </div>
                <div class="col-sm-4">
                  
                   <div class="form-group">
                      <label for=""> <?php echo get_phrase('limit_hour');?></label>

                      <input type="time" required="" name="time_end" class="form-control" value="<?php echo $activity_details['time_end'];?>">
                   </div>
                
                </div>
                <div class="col-sm-4">
                   <label class="col-form-label" for=""><?php echo get_phrase('show_students?');?></label><br>
                        <?php 

                        if($activity_details['status'] == 1){ ?>
                           
                           <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="defaultInline1" name="status" value="1" checked="">
                            <label class="custom-control-label" for="defaultInline1">Yes</label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="defaultInline2" name="status" value="0">
                            <label class="custom-control-label" for="defaultInline2">No</label>
                          </div>

                        <?php }else{ ?>
                          
                           <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="defaultInline1" name="status" value="1" >
                            <label class="custom-control-label" for="defaultInline1">Yes</label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="defaultInline2" name="status" value="0" checked="">
                            <label class="custom-control-label" for="defaultInline2">No</label>
                          </div>

                        <?php } ?>
                </div>
             </div>
            
            <input type="hidden" name="activity_id" id="activity_id" value="<?php echo $param2; ?>">
            <div class="form-group">
               <div class="col-sm-12" style="text-align: center;">
                  <button type="submit" class="btn btn-success" id="btn_submit"><?php echo get_phrase('save');?></button>
               </div>
            </div>
            </form>
            <?php //echo form_close();?>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">

    function copy_activity(){

        $.ajax({

              url:'<?php echo base_url();?>admin/copy_activity',
              method:'POST',
              data:$("form#copy_activity").serialize(),
              cache:false,
              beforeSend:function(){
              $('#btn_submit').html("Copying data... <span class='fa fa-spinner fa-spin'></span>");
              document.getElementById('btn_submit').disabled = true;
              },
              success:function(data)
              {

                if(data == 1){

                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 8000
                    }); 
                    Toast.fire({
                    type: 'success',
                    title: 'Activity successfully Copied.'
                    });

                  $('#exampleModal').modal('hide');

                }else{

                   swal("LMS", "Error on updating data", "error");

                } 

              }

            });
    }

    function subject_holder(section_id) 
         {
          //alert(section_id);

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

