<style type="text/css" media="screen">
	.red {
        color: #f44336;
    }
</style>
<div class="alert alert-success">
	<strong><?php echo get_phrase('instuctions');?>:</strong>
	 It is required to complete the question of type of spaces. When you need to insert a line, you can simply enter '_' to get a blank space.
</div>

<?php ///echo form_open(base_url() . 'teacher/manage_online_exam_question/'.$online_exam_id.'/add/fill_in_the_blanks' , array('enctype' => 'multipart/form-data'));?>

<form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault();"> 
<input type="hidden" value="<?php echo $online_exam_id; ?>" name="online_exam_id" id="online_exam_id">

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
        <textarea oninput="changeTheBlankColor()" name="question_title" class="form-control" id="question_title" rows="8" cols="80" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
    </div>
</div>

<div class="form-group" style="display: none;">
    <label class="col-sm-3 control-label"><?php echo get_phrase('preview');?>:</label>
    <div class="col-sm-12">
        <div  class="" id="preview"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-6 control-label"><?php echo get_phrase('correct_words');?></label>
    <div class="col-sm-12">
        <textarea name="suitable_words" class = "form-control" rows="8" cols="80" required placeholder="<?php echo get_phrase('enter_the_correct_words.');?>"></textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <button type="submit" onclick="save_fill_in_the_blanks()" class="btn btn-success btn-block"><?php echo get_phrase('save');?></button>
    </div>
</div>
<?php //echo form_close();?>
</form>
<script type="text/javascript">
	function changeTheBlankColor() {
        var alpha = ["_"];
        var res = "", cls = "";
        var t = $("#question_title").val();
        alert(t);
        for (i=0; i<t.length; i++) {
            for (j=0; j<alpha.length; j++) {
                if (t[i] == alpha[j])
                {
                    cls = "red";
                }
            }
            if (t[i] === "_") {
                res += "<span class='"+cls+"'>"+'__'+"</span>";
            }
            else{
                res += "<span class='"+cls+"'>"+t[i]+"</span>";
            }
            cls="";
        }
        $("#preview").html(res);
    }
</script>

<script>

    function save_fill_in_the_blanks(){

    var online_exam_id = $('#online_exam_id').val();

    $.ajax({

          url:'<?php echo base_url();?>admin/manage_online_exam_question/'+online_exam_id+'/add/fill_in_the_blanks',
          method:'POST',
          data:$("form#form").serialize(),
          cache:false,
          success:function(data)
          {
            window.location.href = '<?php echo base_url();?>admin/examroom/'+online_exam_id;
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