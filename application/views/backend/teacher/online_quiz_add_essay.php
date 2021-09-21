<style type="text/css" media="screen">
	.red {
        color: #f44336;
    }
</style>

<?php //echo form_open(base_url() . 'teacher/manage_online_quiz_question/'.$online_quiz_id.'/add/essay' , array('enctype' => 'multipart/form-data'));?>
<form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault();"> 
<input type="hidden" value="<?php echo $online_quiz_id; ?>" name="online_quiz_id" id="online_quiz_id">

<input type="hidden" name="type" value="<?php echo $question_type;?>">

<div class="form-group">

    <label class="col-sm-3 control-label"><?php echo get_phrase('points');?></label>
    
    <div class="col-sm-12">

        <input type="number" class="form-control" name="mark" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" min="0"/>

    </div>

</div>

<div class="form-group">

    <label class="col-sm-3 control-label"><?php echo get_phrase('question');?></label>

    <div class="col-sm-12">

        <textarea name="question_title" class="form-control" id="question_title" rows="8" cols="80" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>

    </div>

</div>

<div class="form-group">

    <label class="col-sm-3 control-label"><?php echo get_phrase('preview');?>:</label>
    
    <div class="col-sm-12">
       
        <div class="" id="preview"></div>
   
    </div>

</div>

<div class="form-group">

    <div class="col-sm-12">

        <button type="submit" onclick="save_essay();" class="btn btn-success btn-block"><?php echo get_phrase('save');?></button>
    
    </div>

</div>

</form>
<?php //echo form_close();?>

<script>

    function save_essay(){

    var online_quiz_id = $('#online_quiz_id').val();

    $.ajax({

          url:'<?php echo base_url();?>teacher/manage_online_quiz_question/'+online_quiz_id+'/add/essay',
          method:'POST',
          data:$("form#form").serialize(),
          cache:false,
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