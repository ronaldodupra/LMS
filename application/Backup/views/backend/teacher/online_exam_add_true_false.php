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
</style>

<?php //echo form_open(base_url() . 'teacher/manage_online_exam_question/'.$online_exam_id.'/add/true_false' , array('enctype' => 'multipart/form-data'));?>
<form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault(); save_true_false();"> 
<input type="hidden" value="<?php echo $online_exam_id; ?>" name="online_exam_id" id="online_exam_id">
<input type="hidden" name="type" value="<?php echo $question_type;?>">
<input type="hidden" name="folder_name" id="folder_name" value="online_exam"/>

<div class="form-group">
    <label class="col-sm-3 control-label"><?php echo get_phrase('points');?></label>
    <div class="col-sm-12">
        <input type="number" class="form-control" name="mark" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" min="0"/>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label"><?php echo get_phrase('question');?></label>
    <div class="col-sm-12">
        <textarea name="question_title" class="form-control" id="question_title" rows="8" cols="80" required></textarea>
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

<div class="row"  style="margin-top: 10px; text-align: left;">
    <div class="col-sm-12 col-sm-offset-3">
        <p>
            <input type="radio" id="true" name="true_false_answer" value="true" checked>
            <label for="true"><?php echo get_phrase('true');?></label>
        </p>
    </div>
    <div class="col-sm-12 col-sm-offset-3">
        <p>
            <input type="radio" id="false" name="true_false_answer" value="false">
            <label for="false"><?php echo get_phrase('false');?></label>
        </p>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-12">
        <button type="submit" class="btn btn-success btn-block"><?php echo get_phrase('save');?></button>
    </div>
</div>
<?php //echo form_close();?>
 </form> 
<script>

    function save_true_false(){

    var online_exam_id = $('#online_exam_id').val();

    $.ajax({

          url:'<?php echo base_url();?>teacher/manage_online_exam_question/'+online_exam_id+'/add/true_false',
          method:'POST',
          data:$("form#form").serialize(),
          cache:false,
          success:function(data)
          {
            window.location.href = '<?php echo base_url();?>teacher/examroom/'+online_exam_id;
          }

        });

  }

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