<?php 
   $homework_reply =  $this->db->get_where('deliveries', array('homework_code' => $homework_code, 'student_id' => $this->session->userdata('login_user_id'), 'status' => 2))->row()->homework_reply; ?>
<textarea spellcheck="false" required="" class="form-control" name="reply" id="reply" rows="8" placeholder="Enter your answer here...."><?php echo $homework_reply; ?></textarea>
<script>
   (function () {
     new FroalaEditor("#reply",{key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==", 
     attribution: false,
     spellcheck: false,
     bgOptions: {
                   service: {
                       apiKey: 'E8FEF7AE-3F36-4EAF-A451-456D05E6F2A3'
                   },
                   grammar: {
                       languageFilter: ['en-US', 'en-GB'],
                       showContextThesaurus: true,
                   }
               },
     htmlAllowedTags:   ['.*'],
     htmlAllowedAttrs: ['.*'],
     toolbarButtons:{
     'moreText': {
       'buttons': ['fullscreen','insertImage','wirisEditor', 'wirisChemistry','bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting','undo', 'redo']
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