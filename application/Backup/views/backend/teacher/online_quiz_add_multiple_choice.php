


<?php //echo form_open(base_url() . 'teacher/manage_online_quiz_question/'.$online_quiz_id.'/add/multiple_choice' , array('enctype' => 'multipart/form-data'));?>
<form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault();"> 

<input type="hidden" value="<?php echo $online_quiz_id; ?>" name="online_quiz_id" id="online_quiz_id">
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
        <textarea onkeyup="changeTheBlankColor()" name="question_title" class="form-control" id="question_title" rows="8" cols="80"></textarea>
    </div>
</div>
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
        <button type="submit" onclick="save_multiple();" class="btn btn-success btn-block"><?php echo get_phrase('save');?></button>
    </div>
</div>
<?php //echo form_close();?>
</form>
<script type="text/javascript">
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
<script type="text/javascript">
  function save_multiple(){

    var online_quiz_id = $('#online_quiz_id').val();

    $.ajax({

          url:'<?php echo base_url();?>teacher/manage_online_quiz_question/'+online_quiz_id+'/add/multiple_choice',
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
