<?php
   $question_details = $this->db->get_where('question_bank', array('question_bank_id' => $param2))->row_array();
   if ($question_details['options'] != "" || $question_details['options'] != null) {
       $options = json_decode($question_details['options']);
   } else {
       $options = array();
   }
   if ($question_details['correct_answers'] != "" || $question_details['correct_answers'] != null) {
       $correct_answers= json_decode($question_details['correct_answers']);
   } else {
       $correct_answers = array();
   }
   
   $online_exam_details = $this->db->get_where('online_exam', array('online_exam_id' => $question_details['online_exam_id']))->row_array();
   
   $added_question_info = $this->db->get_where('question_bank', array('online_exam_id' => $online_exam_details['online_exam_id']))->result_array();
   if($question_details['type'] == 'fill_in_the_blanks') {
       $suitable_words = implode(',', json_decode($question_details['correct_answers']));
   }
   ?>
<div class="modal-body">
   <div class="modal-header" style="background-color:#00579c">
      <h6 class="title" style="color:white"><?php echo get_phrase('update_question');?></h6>
   </div>
   <div class="ui-block-content">
      <div class="row">
         <div class="col-md-12">
            <!-- <?php //echo form_open(base_url() . 'teacher/update_online_exam_question/'.$param2.'/update'.'/'.$question_details['online_exam_id'] , array('enctype' => 'multipart/form-data'));?> <?php //echo form_close();?> -->

            <form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault();">
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('points');?></label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" name="mark" required min="0" value="<?php echo $question_details['mark']; ?>"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('question');?></label>
                  <div class="col-sm-12">
                    <textarea name="question_title" class = "form-control" id = "question_title" rows="5" cols="80" required <?php if($question_details['type'] == 'fill_in_the_blanks') echo "onkeyup='changeTheBlankColor()'"; ?>><?php echo $question_details['question_title']; ?></textarea>
                  </div>
              </div>

              <!-- image input -->
              <div class="form-group">
                 <label class="col-sm-12 control-label"><?php echo get_phrase('Update image');?> <br><span class="text-danger"> Once you delete the image you will not be able to restore it. </span> </label>
                 <div class="col-sm-12">
                    <div class="form-group text-center">
                      <span id="uploaded_image"></span>
                    </div>
                     <div class="form-group text-center">
                        <input type="file" name="file" id="file" class="inputfile inputfile-3" style="display:none"/>
                        <label style="font-size:15px;" title="Maximum upload is 10mb">
                            
                                <span id="with_image">
                                    <input type="hidden" id="file_n" value="<?php echo $question_details['image'] ?>">
                                    <img src="<?php echo base_url('uploads/online_exam/'.$question_details['image']);?>" class="img-fluid img-responsive img-thumbnail" width="150px;"><br> <button onclick="remove_file_2();" class="btn btn-sm btn-danger view_control"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i> Remove</button>
                                </span>
                        
                                <span id="without_image">
                                    <i class="os-icon picons-thin-icon-thin-0042_attachment hide_control"></i>
                                    <span class="hide_control" onclick="$('#file').click();"><?php echo get_phrase('upload_image');?>...</span>
                                    <p >
                                      <span class="hide_control os-icon picons-thin-icon-thin-0189_window_alert_notification_warning_error text-danger"></span>
                                      <small class="text-danger hide_control"> <?php echo $date_today; ?> Maximum file size is 10mb.</small>
                                   </p>
                                </span>
                                
                        </label>

                     </div>

                 </div>
              </div>
              <!-- image input -->

              <?php if ($question_details['type'] == 'multiple_choice'): ?>
              <div class="form-group" id = 'multiple_choice_question'>
                 <label class="col-sm-6 control-label"><?php echo get_phrase('options_number');?></label>
                 <div class="col-sm-12">
                    <div class="form-group with-icon label-floating">
                       <label class="control-label"><?php echo get_phrase('options_number');?></label>
                       <input class="form-control" type="number"  name="number_of_options" id = "number_of_options" required="" min="0" value="<?php echo $question_details['number_of_options']; ?>">
                       <button type="button" class = 'btn btn-sm' name="button" onclick="showOptions(jQuery('#number_of_options').val())" style="border-radius: 0px; background-color: #fff; margin-top:-10px;"><i class="picons-thin-icon-thin-0154_ok_successful_check" style="margin-top:-35px;"></i></button>
                    </div>
                 </div>
              </div>
              <?php for ($i = 0; $i < $question_details['number_of_options']; $i++):?>
              <div class="col-sm-12">
                 <div class="form-group">
                    <label class="control-label"><?php echo get_phrase('option_').($i+1);?></label>
                    <textarea name="options[]" class="form-control" id="option_<?php echo $i+1; ?>" rows="5" cols="80" required <?php if($question_details['type'] == 'fill_in_the_blanks') echo "onkeyup='changeTheBlankColor()'"; ?>><?php echo $options[$i]; ?></textarea>
                    <!--  <input type="text" class="form-control" name="" id="option_<?php echo $i+1; ?>" required value="<?php echo $options[$i]; ?>"> -->
                    <div class="custom-control custom-checkbox" style="margin-top:-37px;left:15px; width: 10px;">
                       <input type="checkbox" name="correct_answers[]" id="<?php echo $i; ?>" value="<?php echo ($i+1); ?>" class="custom-control-input" <?php if(in_array(($i+1), $correct_answers)) echo 'checked'; ?>><label for="<?php echo $i; ?>" class="custom-control-label"></label>
                    </div>
                 </div>
              </div>
              <?php endfor;?>
              <?php endif; ?>
              <?php if ($question_details['type'] == 'true_false'): ?>
              <div class="row"  style="margin-top: 10px; text-align: left;">
                 <div class="col-sm-8 col-sm-offset-3">
                    <p>
                       <input type="radio" id="true" name="true_false_answer" value="true" <?php if($question_details['correct_answers'] == 'true') echo 'checked';  ?>>
                       <label for="true"><?php echo get_phrase('true');?></label>
                    </p>
                 </div>
                 <div class="col-sm-8 col-sm-offset-3">
                    <p>
                       <input type="radio" id="false" name="true_false_answer" value="false" <?php if($question_details['correct_answers'] == 'false') echo 'checked';  ?>>
                       <label for="false"><?php echo get_phrase('false');?></label>
                    </p>
                 </div>
              </div>
              <?php endif; ?>
              <?php if ($question_details['type'] == 'fill_in_the_blanks'): ?>
              <div class="form-group">
                 <label class="col-sm-3 control-label"><?php echo get_phrase('preview');?>:</label>
                 <div class="col-sm-12">
                    <div class="" id = "preview"></div>
                 </div>
              </div>
              <div class="form-group">
                 <label class="col-sm-3 control-label"><?php echo get_phrase('correct_words');?></label>
                 <div class="col-sm-12">
                    <textarea name="suitable_words" class = "form-control" rows="5" cols="80" placeholder="<?php echo get_phrase('correct_words_message');?>" ><?php echo $suitable_words; ?></textarea>
                 </div>
              </div>
              <?php endif; ?>
              <div class="form-group">
                 <div class="col-sm-12">
                    <button type="submit" class="btn btn-success btn-block" onclick="update_multiple_choices('<?php echo $param2;?>','<?php echo $question_details['online_exam_id'];?>');"><?php echo get_phrase('Update');?></button>
                 </div>
              </div>
            </form>
         </div>
      </div>
   </div>
</div>
<style media="screen">
   [type="radio"]:checked,
   [type="radio"]:not(:checked) {
   position: absolute;
   left: -9999px;
   }
   [type="radio"]:checked + label,
   [type="radio"]:not(:checked) + label
   {
   position: relative;
   padding-left: 28px;
   cursor: pointer;
   line-height: 20px;
   display: inline-block;
   color: #666;
   }
   [type="radio"]:checked + label:before,
   [type="radio"]:not(:checked) + label:before {
   content: '';
   position: absolute;
   left: 0;
   top: 0;
   width: 18px;
   height: 18px;
   border: 1px solid #ddd;
   border-radius: 100%;
   background: #fff;
   }
   [type="radio"]:checked + label:after,
   [type="radio"]:not(:checked) + label:after {
   content: '';
   width: 12px;
   height: 12px;
   background: #2aa1c0;
   position: absolute;
   top: 3px;
   left: 3px;
   border-radius: 100%;
   -webkit-transition: all 0.2s ease;
   transition: all 0.2s ease;
   }
   [type="radio"]:not(:checked) + label:after {
   opacity: 0;
   -webkit-transform: scale(0);
   transform: scale(0);
   }
   [type="radio"]:checked + label:after {
   opacity: 1;
   -webkit-transform: scale(1);
   transform: scale(1);
   }
   .red {
   color: #f44336;
   }
</style>
<script type="text/javascript">

  $(document).ready(function(){

    // image update

    check_image();

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




    function remove_file_2(){

       var file_n = $('#file_n').val();
       var folder_name = $('#folder_name').val();
       var question_bank_id = <?php echo $param2; ?>;
       $.ajax({
        url:"<?php echo base_url(); ?>admin/remove_image_2",
        method:"POST",
        data: {file_n:file_n,folder_name:folder_name,question_bank_id:question_bank_id},
        cache: false,  
        success:function(data)
        {
          check_image();
        }

       });

      }

      function check_image(){

       var question_bank_id = <?php echo $param2; ?>;

       $.ajax({
        url:"<?php echo base_url(); ?>admin/check_image_exam",
        method:"POST",
        data: {question_bank_id:question_bank_id},
        cache: false,  
        success:function(data)
        {
          if(data == 1){
            $('#with_image').css('display','inline');
            $('#without_image').css('display','none');
          }else{
            $('#with_image').css('display','none');
            $('#without_image').css('display','inline');
          }
        }
        
       });

   }

   // image update
  
   jQuery(document).ready(function($) {
       changeTheBlankColor();
   });

   function update_multiple_choices($param, $exam_id){
      //alert($param +' '+ $exam_id);

      $.ajax({
         url:'<?php echo base_url();?>teacher/update_online_exam_question/'+$param+'/update/'+$exam_id,
         method:'POST',
         data:$("form#form").serialize(),
         cache:false,
         success:function(data)
         {
         window.location.href = '<?php echo base_url();?>teacher/examroom/'+$exam_id;
         }
      });
   }
   
  function showOptions(number_of_options){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>teacher/manage_multiple_choices_options",
      data: {number_of_options : number_of_options},
      success: function(response){
        console.log(response);
        jQuery('.options').remove();
        jQuery('#multiple_choice_question').after(response);
      }
    });
  }
   
  function changeTheBlankColor(){
    var alpha = ["^"];
    var res = "", cls = "";
    var t = jQuery("#question_title").val();
   
    for (i=0; i<t.length; i++) {
      for (j=0; j<alpha.length; j++) {
       if (t[i] == alpha[j])
       {
           cls = "red";
       }
      }
      if (t[i] === "^") {
        res += "<span class='"+cls+"'>"+'__'+"</span>";
      }
      else{
         res += "<span class='"+cls+"'>"+t[i]+"</span>";
      }
      cls="";
    }
      jQuery("#preview").html(res);
  }
</script>
<script>
   (function () {
     new FroalaEditor("#question_title",{key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==", 
     attribution: false,
     htmlAllowedTags:   ['.*'],
     htmlAllowedAttrs: ['.*'],
     toolbarButtons:{
     'moreText': {
       'buttons': ['wirisEditor', 'wirisChemistry','bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
     },
     'moreParagraph': {
       'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
     },
     'moreRich': {
       'buttons': ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
     },
     'moreMisc': {
       'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'help']
     }
   },
     enter: FroalaEditor.ENTER_P,
       placeholderText: null,
       events: {
         initialized: function () {
           const editor = this
           this.el.closest('form').addEventListener('submit', function (e) {
             console.log(editor.$oel.val())
   
             var test = $('#question_title').val();
             //alert(test);
   
             e.preventDefault()
           })
         }
       }
     })
   })()
</script>
<script>
   (function () {
     new FroalaEditor("#option_1, #option_2, #option_3, #option_4",{key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==", 
     attribution: false,
     htmlAllowedTags:   ['.*'],
     htmlAllowedAttrs: ['.*'],
     toolbarButtons:{
     'moreText': {
       'buttons': ['wirisEditor', 'wirisChemistry','bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
     }
   },
     enter: FroalaEditor.ENTER_P,
       placeholderText: null,
       events: {
         initialized: function () {
           const editor = this
           this.el.closest('form').addEventListener('submit', function (e) {
             console.log(editor.$oel.val())
   
             var test = $('#question_title').val();
             //alert(test);
   
             e.preventDefault()
           })
         }
       }
     })
   })()
</script>