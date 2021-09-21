<textarea spellcheck="false" readonly="" contenteditable="false" class="form-control" name="document" id="contenteditable_update"><?php echo $question; ?></textarea>
<script>
    (function () {
     new FroalaEditor("#contenteditable_update",{key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==", 
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

<script type="text/javascript" src="<?php echo base_url();?>style/froala_bg/beyond-grammar-plugin.js"></script>