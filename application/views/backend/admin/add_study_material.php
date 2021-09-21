 <?php //echo form_open(base_url() . 'teacher/study_material/create/'.$data, array('enctype' => 'multipart/form-data')); ?>
 <?php 
  $dept = $this->db->query("SELECT b.`department_id` FROM subject a LEFT JOIN class b ON a.`class_id` = b.`class_id` WHERE a.`subject_id` = '$subject_id'")->row()->department_id;

  if ($dept == 1 OR $dept == 2) {
    $categ = 1;
  }
  elseif ($dept == 3 OR $dept == 4) {
    $categ = 2;
  }
?>
 <form enctype="multipart/form-data" id="form_studymaterial" onsubmit="event.preventDefault(); save_study_material();">
   
 <div class="row">
    <input type="hidden" value="<?php echo $class_id;?>" name="class_id"/>
    <input type="hidden" value="<?php echo $section_id;?>" name="section_id"/>
    <input type="hidden" value="<?php echo $subject_id;?>" name="subject_id"/>
    <input type="hidden" value="<?php echo $data;?>" name="study_data" id="study_data"/>

    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
       <div class="form-group label-floating is-select">
          <label class="control-label"><?php echo get_phrase('select_document_type');?></label>
          <div class="select">
             <select name="doc_type" required="" id="doc_type" onchange="select_doc_type();" oninput="select_doc_type();">
                <option value="file_type"><?php echo get_phrase('file');?></option>
                <option value="online_text"><?php echo get_phrase('online_text');?></option>
             </select>
          </div>
       </div>
    </div>

    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">

       <div class="form-group" id="file_type">

          <label class="control-label"><?php echo get_phrase('description');?></label>
           <input type="text" name="description" required="">
       </div>

       <div class="form-group" id="online_text" style="display: none;">
          <label class="control-label"><?php echo get_phrase('Document');?></label>
          <textarea spellcheck="false" class="form-control" name="document" id="contenteditable" rows="8"></textarea>
       </div>
       <br>

    </div>
    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
       <div class="form-group label-floating is-select">
          <label class="control-label"><?php echo get_phrase('select_semester');?></label>
          <div class="select">
            <select name="semester_id" id="semester_id" required="">
              <option value=""><?php echo get_phrase('select');?></option>
              <?php $cl = $this->db->query("SELECT * FROM exam WHERE category = '$categ'")->result_array();
                foreach($cl as $row):
                ?>
              <option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
              <?php endforeach;?>
            </select>
          </div>
       </div>
    </div>
    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
      <label class="control-label"><?php echo get_phrase('file');?></label>
      <input type="hidden" name="folder_name" id="folder_name" value="document"/>

       <div class="form-group text-center">

          <span id="uploaded_image"></span>

          <input type="file" name="file" id="file" class="inputfile inputfile-3" style="display:none"/>
          
          <ul>
             <li>
                <a href="#"><i class="os-icon picons-thin-icon-thin-0042_attachment hide_control"></i> 
                <span class="hide_control" onclick="$('#file').click();"><?php echo get_phrase('upload_file');?>...</span></a>
                
             </li>
             <li><span class="hide_control os-icon picons-thin-icon-thin-0189_window_alert_notification_warning_error text-danger"></span>
                <small class="text-danger hide_control"> Maximum file size is 10mb.</small>
             </li>
          </ul>

       </div>
    </div>
 </div>
 <div class="form-buttons-w text-right">
    <center><button id="btn_submit_s" class="btn btn-rounded btn-success btn-lg" type="submit"><?php echo get_phrase('save');?></button></center>
 </div>
  </form>
 <?php //echo form_close();?>        
<script>

    $(document).ready(function(){

 $("#file").change(function() {
  var name = document.getElementById("file").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg','pdf','xlsx','xls','doc','docx','ppt','pptx','accdb','one','txt','pub','rar','zip']) == -1) 
  {
   swal('error','Invalid File Type','error');
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 10000000)
  {
   swal('error','File Size is very big atleast 10mb','error');
  }
  else
  {
   form_data.append("file", document.getElementById('file').files[0]);
   $.ajax({
    url:"<?php echo base_url(); ?>admin/upload_study_material",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('.hide_control').css('display','none');
     $('#uploaded_image').html('<center><img src="<?php echo base_url();?>assets/images/preloader.gif" /> </span> <br> Uploading...');
     $('#file').val('');
     $('#btn_submit_s').prop('disabled',true);
    },
    success:function(data)
    {
     $('#uploaded_image').html(data);

      var file_size = $('#file_size').val();

      if(file_size == 'NAN B'){

        $('.hide_control').css('display','inline');
        $('.view_control').css('display','none');
        $('#btn_submit_s').prop('disabled',true);
        $('#uploaded_image').html('<small class="text-danger">Error on uploading file. Try again.</span><br>');
        $('#file_loc').val('');
        $('#file_size').val('');

      }else{

        $('.hide_control').css('display','none');
        $('.view_control').css('display','inline');
        $('#btn_submit_s').prop('disabled',false);

      }

    }
   });
  }
 });

});

function remove_file(){

   var file_loc = $('#file_loc').val();
   var folder_name = $('#folder_name').val();
   $.ajax({
    url:"<?php echo base_url(); ?>admin/remove_image",
    method:"POST",
    data: {file_loc:file_loc,folder_name:folder_name},
    cache: false,
    beforeSend:function(){
     $('#uploaded_image').html('<center><img src="<?php echo base_url();?>assets/images/preloader.gif" /> </span> <br> Removing file...');
     $('#file').val('');
     $('#btn_publish').prop('disabled',true);
    },   
    success:function(data)
    {
       $('#btn_publish').prop('disabled',false);
      $('#uploaded_image').html("");
      $('#file').val('');
      $('.hide_control').css('display','inline');
      $('.view_control').css('display','none');
    }
   });

}

  function save_study_material(){

    var study_data = $('#study_data').val();
    $.ajax({

          url:'<?php echo base_url();?>admin/study_material/create/',
          method:'POST',
          data:$("form#form_studymaterial").serialize(),
          cache:false,
          success:function(data)
          {
            window.location.href = '<?php echo base_url();?>admin/study_material/' + study_data;
          }

    });

  }

    (function () {
      new FroalaEditor("#contenteditable",{key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==", 
      attribution: false,
      spellcheck: false,
      htmlAllowedTags:   ['.*'],
      htmlAllowedAttrs: ['.*'],
      toolbarButtons:{
      'moreText': {
        'buttons': ['BeyondGrammar','|','wirisEditor', 'wirisChemistry','bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
      },
      'moreParagraph': {
        'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
      },
      'moreRich': {
        'buttons': ['insertLink', 'insertImage', 'insertVideo','insertTable',, 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
      },
      'moreMisc': {
        'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'help', 'BeyondGrammar']
      }
  },
      enter: FroalaEditor.ENTER_P,
        placeholderText: null,
        events: {
          'image.beforeUpload': function (files) {
            const editor = this
            if (files.length) {
              var reader = new FileReader()
              reader.onload = function (e) {
                var result = e.target.result
                editor.image.insert(result, null, null, editor.image.get())
              }
              reader.readAsDataURL(files[0])
            }
            return false
          },
          initialized: function () {
            const editor = this
            this.el.closest('form').addEventListener('submit', function (e) {
              console.log(editor.$oel.val())

              var test = $('#contenteditable').val();
              //alert(test);

              e.preventDefault()
            })
          }
        }
      })
    })()
  </script>