 <div class="form-group">

    <?php 
    $student_id = $this->session->userdata('login_user_id');
    $answer = $this->db->query("SELECT answer from tbl_exam_temp_table where question_id = '$question_bank_id' and student_id = '$student_id'")->row()->answer;
    ?>

    <textarea spellcheck="false" contenteditable="false" class="form-control" name="<?php echo $question_bank_id.'[]'; ?>" id="<?php echo 'e-'.$question_bank_id ?>"><?php echo implode(',', json_decode($answer)); ?></textarea>
 </div>
      
<script type="text/javascript">
  (function () {
      new FroalaEditor('#e-<?php echo $question_bank_id ?>',{key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==", 
      attribution: false,
      htmlAllowedTags:   ['.*'],
      htmlAllowedAttrs: ['.*'],
      // bgOptions: {
      //               service: {
      //                   apiKey: 'E8FEF7AE-3F36-4EAF-A451-456D05E6F2A3'
      //               },
      //               grammar: {
      //                   languageFilter: ['en-US', 'en-GB'],
      //                   showContextThesaurus: true,
      //                   //disableDictionary: true,
      //               }
      //           },
      toolbarButtons:{
      'moreText': {
        'buttons': ['wirisEditor', 'wirisChemistry','insertImage']
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

               var test = $('#<?php echo $question_bank_id ?>').val();
              // //alert(test);

              // e.preventDefault()
            })
          }
        }
      })
    })()
</script>
<!-- <script type="text/javascript" src="<?php echo base_url();?>style/froala_bg/beyond-grammar-plugin.js"></script> -->