<?php echo form_open(base_url() . 'teacher/manage_online_exam_question/'.$online_exam_id.'/add/image' , array('enctype' => 'multipart/form-data'));?>

<!-- <form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault();">  -->
<input type="hidden" value="<?php echo $online_exam_id; ?>" name="online_exam_id" id="online_exam_id">

<input type="hidden" name="type" value="<?php echo $question_type;?>">
<div class="form-group">
   <label class="col-sm-3 control-label"><?php echo get_phrase('points');?></label>
   <div class="col-sm-12">
      <input type="number" class="form-control" name="mark" required="" min="0"/>
   </div>
</div>
<div class="form-group">
   <label class="col-sm-3 control-label"><?php echo get_phrase('question');?></label>
   <div class="col-sm-12">
      <textarea name="question_title" class="form-control" id="question_title" rows="8" cols="80"></textarea>
   </div>
</div>

<!-- image input -->
 <div class="form-group">
     <label class="col-sm-3 control-label"><?php echo get_phrase('Add image');?></label>
     <div class="col-sm-12">
        <div class="form-group text-center">
          <span id="uploaded_image"></span>
        </div>

         <div class="form-group text-center">
            <input type="file" name="file" id="file" class="inputfile inputfile-3" style="display:none"/>
            <label style="font-size:15px;" title="Maximum upload is 10mb">
               <i class="os-icon picons-thin-icon-thin-0042_attachment hide_control"></i> 
               <span class="hide_control" onclick="$('#file').click();"><?php echo get_phrase('upload_image');?>...</span>
               <p>
                  <span class="hide_control os-icon picons-thin-icon-thin-0189_window_alert_notification_warning_error text-danger"></span>
                  <small class="text-danger hide_control"> <?php echo $date_today; ?> Maximum file size is 10mb.</small>
               </p>

            </label>

         </div>

     </div>
  </div> 
<!-- image input -->

<div class="form-group" id='multiple_choice_question'>
   <label class="col-sm-6 control-label"><?php echo get_phrase('options_number');?></label>
   <div class="col-sm-12">
      <div class="form-group with-icon label-floating is-empty">
         <label class="control-label"><?php echo get_phrase('options_number');?></label>
         <input class="form-control" type="number"  name="number_of_options" id = "number_of_options" required="" min="0">
         <button type="button" class = 'btn btn-sm' name="button" onclick="showOptions(jQuery('#number_of_options').val())" style="border-radius: 0px; background-color: #fff; margin-top:-10px;"><i class="picons-thin-icon-thin-0154_ok_successful_check" style="margin-top:-35px;"></i></button>
      </div>
   </div>
</div>

<div class="form-group">
   <div class="col-sm-12">
      <button type="submit" onclick="save_image();" class="btn btn-success btn-block"><?php echo get_phrase('save');?></button>
   </div>
</div>
<?php echo form_close();?>
<!-- </form> -->
<script type="text/javascript">
   function showOptions(number_of_options){
          $.ajax({
              type: "POST",
              url: "<?php echo base_url();?>teacher/manage_image_options",
              data: {number_of_options : number_of_options},
              success: function(response){
                  console.log(response);
                  jQuery('.options').remove();
                  jQuery('#multiple_choice_question').after(response);
              }
          });
      }
</script>
<script>

    function save_image(){

    var online_exam_id = $('#online_exam_id').val();

    $.ajax({

          url:'<?php echo base_url();?>teacher/manage_online_exam_question/'+online_exam_id+'/add/image',
          method:'POST',
          data:$("form#form").serialize(),
          cache:false,
          success:function(data)
          {
            window.location.href = '<?php echo base_url();?>teacher/examroom/'+online_exam_id;
          }

        });

  }

  </script>

  <script type="text/javascript">
    
  $(document).ready(function(){

   $("#file").change(function() {
    var name = document.getElementById("file").files[0].name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
    {
     alert("Invalid Image File");
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("file").files[0]);
    var f = document.getElementById("file").files[0];
    var fsize = f.size||f.fileSize;
    if(fsize > 10000000)
    {
     //alert("Image File Size is very big");

     swal('error','Image File Size is very big atleast 10mb','error');

    }
    else
    {
     form_data.append("file", document.getElementById('file').files[0]);
     $.ajax({
      url:"<?php echo base_url(); ?>admin/up_image",
      method:"POST",
      data: form_data,
      contentType: false,
      cache: false,
      processData: false,
      beforeSend:function(){
       $('.hide_control').css('display','none');
       $('#uploaded_image').html('<center><img src="<?php echo base_url();?>assets/images/preloader.gif" /> </span> <br> Uploading...');
       $('#file').val('');
      },
      success:function(data)
      {
        $('.hide_control').css('display','none');
        $('.view_control').css('display','inline');
       $('#uploaded_image').html(data);
      }
     });
    }
   });

  });

  function remove_file(){

   var file_loc = $('#question_title').val();
   var folder_name = $('#folder_name').val();
   $.ajax({
    url:"<?php echo base_url(); ?>admin/remove_image",
    method:"POST",
    data: {file_loc:file_loc,folder_name:folder_name},
    cache: false,
    beforeSend:function(){
     $('#uploaded_image').html('<center><img src="<?php echo base_url();?>assets/images/preloader.gif" /> </span> <br> Removing Image...');
     $('#file').val('');
    },   
    success:function(data)
    {
      $('#uploaded_image').html("");
      $('#file').val('');
      $('.hide_control').css('display','inline');
    }
   });

  }

  </script>