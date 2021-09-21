<?php for($i = 1; $i <= $number_of_options; $i++): ?>
<div class="col-sm-12">
   <div class="form-group">
		<label class="control-label"><?php echo get_phrase('option_').$i;?></label>
		<textarea onkeyup="changeTheBlankColor()" name="options[]" class="form-control" id="question_option<?php echo $i; ?>" rows="8" cols="80"></textarea>
		<div class="custom-control custom-checkbox" style="margin-top:-40px;left:15px;    width: 10px;">
      <input type="checkbox" name="correct_answers[]" id="<?php echo $i; ?>" value="<?php echo $i; ?>" class="custom-control-input"> <label for="<?php echo $i; ?>" class="custom-control-label"></label>
    </div>
	</div>
</div>
<?php endfor; ?>

<script>
    (function () {
      new FroalaEditor("#question_option1, #question_option2, #question_option3, #question_option4",{key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==", 
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