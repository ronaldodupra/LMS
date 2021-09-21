<?php $video_tutorial = $this->db->get_where('settings' , array('type' => 'Enumeration Tutorial'))->row()->description;?>
<style type="text/css" media="screen">
   .red {
   color: #f44336;
   }
</style>
<form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault(); save_enumeration();">

   <input type="hidden" value="<?php echo $online_quiz_id; ?>" name="online_quiz_id" id="online_quiz_id">
   <input type="hidden" name="type" value="<?php echo $question_type;?>">
   <input type="hidden" name="folder_name" id="folder_name" value="online_quiz"/>

   <div class="col-sm-12">

    <div class="form-group">
        <a href="<?php echo $video_tutorial; ?>" target="_blank" class="btn btn-block btn-primary"><span class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie fa-lg"></span>Watch Video Tutorial </a>
    </div>

   </div>

   <div class="form-group">
      <label class="col-sm-12 control-label"><?php echo get_phrase('question');?> <small class="text-danger">( * This field is required.)</small><br>
        <label class="text-primary"> E.g. Enumerate even numbers from 1 to 10?  </label>
      </label>
      <div class="col-sm-12">
         <textarea name="question_title" class="form-control" id="question_title" rows="8" cols="80" required=""></textarea>
      </div>
   </div>

   <div class="form-group">
      <label class="col-sm-12 control-label">Points Per item <small class="text-danger">( * This field is required.)</small></label>
      <div class="col-sm-12">
         <input type="number" class="form-control" name="mark" required="" min="0" value="1"/>
      </div>
   </div>

   <div class="form-group">
      <label class="col-sm-12 control-label"> Total Items <small class="text-danger">( * This field is required.)</small></label>
      <div class="col-sm-12">
         <input type="number" class="form-control" name="total_items" required="" min="0"/>
      </div>
   </div>
   <div class="form-group">
      <label class="col-sm-12 control-label">Correct Answers:<br> <label class="text-primary"> Enter correct answer separated by comma(,) e.g &nbsp;<em>A, B, C, D</em> </label></label>
      <div class="col-sm-12">
         <textarea style="font-size: 18px" name="suitable_words" class = "form-control" rows="5" cols="80" required placeholder="<?php echo get_phrase('correct_words_message');?>"></textarea>
      </div>
   </div>
   <div class="form-group">
      <div class="col-sm-12">
         <button type="submit" id="btn_save" class="btn btn-success btn-block"><?php echo get_phrase('save');?></button>
      </div>
   </div>
</form>
<script>
   function save_enumeration(){
   
   var online_quiz_id = $('#online_quiz_id').val();
   
   $.ajax({
   
         url:'<?php echo base_url();?>teacher/manage_online_quiz_question/'+online_quiz_id+'/add/enumeration',
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
       'buttons': ['insertLink', 'insertImage', 'insertVideo','insertTable',, 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
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