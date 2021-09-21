<?php //echo form_open(base_url() . 'teacher/manage_online_exam_question/'.$online_exam_id.'/add/multiple_choice' , array('enctype' => 'multipart/form-data'));?>

 <form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault(); save_multiple_choices();"> 
  <input type="hidden" value="<?php echo $online_exam_id; ?>" name="online_exam_id" id="online_exam_id">
  <input type="hidden" name="type" value="<?php echo $question_type;?>">
  <input type="hidden" name="folder_name" id="folder_name" value="online_exam"/>
  <div class="form-group">
     <label class="col-sm-12 control-label"><?php echo get_phrase('points');?> <small class="text-danger">( * This field is required.)</small></label>
     <div class="col-sm-12">
        <input type="number" class="form-control" name="mark" required="" min="0"/>
     </div>
  </div>

  <div class="form-group">
    <input type="file" name="file" id="file" class="inputfile inputfile-3" style="display:none"/>
    <label class="col-sm-12 control-label"><?php echo get_phrase('question');?> <small class="text-danger">( * This field is required.)</small></label>
    <div class="col-sm-12">
      <textarea onkeyup="changeTheBlankColor()" required="" name="question_title" class="form-control" id="question_title" rows="8" cols="80"></textarea>
    </div>
  </div>

  <!-- image input -->
  <div class="form-group">
     <label class="col-sm-12 control-label"><?php echo get_phrase('Add image');?> <small class="">(Optional)</small></label>
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
     <label class="col-sm-12 control-label"><?php echo get_phrase('options_number');?> <small class="text-danger">( * This field is required.)</small></label>
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
        <button type="submit" class="btn btn-success btn-block"><?php echo get_phrase('save');?></button>
     </div>
  </div>

 </form> 

<?php ///echo form_close();?>
<script type="text/javascript">

  // function question_type(){

  //   var q_type = $('#question_type').val();

  //   if(q_type == 1){

  //     $('#text_type').css('display','inline');
  //     $('#img_type').css('display','none');

  //   }else{

  //     $('#text_type').css('display','none');
  //     $('#img_type').css('display','inline');

  //   }

  // }

  function save_multiple_choices(){

    var online_exam_id = $('#online_exam_id').val();

    $.ajax({

          url:'<?php echo base_url();?>teacher/manage_online_exam_question/'+online_exam_id+'/add/multiple_choice',
          method:'POST',
          data:$("form#form").serialize(),
          cache:false,
          success:function(data)
          {
            window.location.href = '<?php echo base_url();?>teacher/examroom/'+online_exam_id;
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
        'buttons': ['insertLink', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
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