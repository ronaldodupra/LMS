<form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault(); save_data();"> 

  <input type="hidden" value="<?php echo $online_quiz_id; ?>" name="online_quiz_id" id="online_quiz_id">
  <input type="hidden" name="folder_name" id="folder_name" value="online_quiz"/>
  <input type="hidden" name="type" value="<?php echo $question_type;?>">

  <div class="form-group">
      <label class="col-sm-12 control-label">Question <small class="text-danger">( * This field is required.)</small><br>
      </label>
       
      <div class="col-sm-12">
          <textarea name="question_title" class="form-control" id="question_title" rows="8" cols="80" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
      </div>
  </div>

  <div class="form-group">
    <label class="col-sm-12 control-label">Points Per item <small class="text-danger">( * This field is required.)</small></label>
    <div class="col-sm-12">
       <input type="number" class="form-control" name="mark" required="" min="0" value="1"/>
    </div>
  </div>

  <div class="field_wrapper">

      <div class="col-sm-12">
        <div class="form-group">
           <a href="javascript:void(0);" class="add_button" title="Add field"><span class="fa fa-plus fa-lg"></span> Add Item</a>
           <a href="javascript:void(0);" class="add_answer float-right" title="Add field"><span class="fa fa-plus fa-lg"></span> Add Answer Item</a>
        </div>
        <hr>
      </div>
      <div class="col-sm-12 text-center mb-2">
         <div class="row">
           <div class="col-sm-6 text-primary">Question</div>
           <div class="col-sm-6 text-primary">Answer</div>
         </div>
      </div>
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-6"><input type="text" class="form-control" required="" placeholder="Question" name="field_name[]" value=""/></div>
          <div class="col-sm-6"><input type="text" class="form-control" required="" placeholder="Answer" name="field_name2[]" value=""/></div>
        </div>
      </div>
  </div>

  <div class="col-sm-12 mt-3">
        <div class="form-group">
           <a href="javascript:void(0);" class="add_button" title="Add field"><span class="fa fa-plus fa-lg"></span> Add Item</a>
           <a href="javascript:void(0);" class="add_answer float-right" title="Add field"><span class="fa fa-plus fa-lg"></span> Add Answer Item</a>
        </div>
  </div>
  <hr>

  <div class="form-group">
      <div class="col-sm-12">
          <button type="submit" id="btn_save" class="btn btn-success btn-block"><?php echo get_phrase('save');?></button>
      </div>
  </div>

</form>

<script type="text/javascript">
$(document).ready(function(){
    var maxField = 20; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var addAnswer = $('.add_answer'); //Input field wrapper

    var fieldHTML = '<div class="col-sm-12 mt-2"><div class="row"><div class="col-sm-6"><input type="text" class="form-control" name="field_name[]" placeholder="Question" value=""/></div><div class="col-sm-5"><input type="text" class="form-control" name="field_name2[]" placeholder="Answer" value=""/></div><a href="javascript:void(0);" class="remove_button text-danger"><span class="fa fa-times fa-lg"></span></a></div></div>';

    var added_answer = '<div class="col-sm-12 mt-2"><div class="row"><div class="col-sm-6"> <span class="badge badge-danger">Added Options</span></div><div class="col-sm-5"><input type="text" class="form-control" name="field_name2[]" placeholder="Answer" value=""/></div><a href="javascript:void(0);" class="remove_button text-danger"><span class="fa fa-times fa-lg"></span></a></div></div>'

    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    $(addAnswer).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(added_answer); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>

<script>

  function save_data(){

  var online_quiz_id = $('#online_quiz_id').val();

  $.ajax({

        url:'<?php echo base_url();?>teacher/manage_online_quiz_question/'+online_quiz_id+'/add/matching_type',
        method:'POST',
        data:$("form#form").serialize(),
        cache:false,
        beforeSend:function(){
          $('#btn_save').prop('disabled', true);
          $('#btn_save').text('Saving question ...');
          $('#form').css('pointer-events','none');
        },
        success:function(data)
        {
          window.location.href = '<?php echo base_url();?>teacher/quizroom/'+online_quiz_id;
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
      'buttons': ['insertLink','insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
    },
    'moreMisc': {
      'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'help']
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
     swal('error','Image File Size is very big atleast 10mb','error');
    }
    else
    {
     form_data.append("file", document.getElementById('file').files[0]);
     $.ajax({
      url:"<?php echo base_url(); ?>admin/up_image_quiz",
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