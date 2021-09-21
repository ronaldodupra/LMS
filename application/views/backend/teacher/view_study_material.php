<?php $document_details = $this->db->get_where('document', array('document_id' => $document_id))->row_array(); ?>

 <div class="col-md-12">
    <textarea spellcheck="false" class="form-control" name="document" id="contenteditable_update"><?php echo $document_details['document']; ?></textarea>
 </div>
      
<script>

    (function () {
      new FroalaEditor("#contenteditable_update",{key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==", 
      attribution: false,
      spellcheck: false,
      documentready:true,
      bgOptions: {
                    service: {
                        apiKey: 'E8FEF7AE-3F36-4EAF-A451-456D05E6F2A3'
                    },
                    grammar: {
                        languageFilter: ['en-US', 'en-GB'],
                        showContextThesaurus: true,
                        //disableDictionary: true,
                    }
                },
      htmlAllowedTags:   ['.*'],
      htmlAllowedAttrs: ['.*'],
      toolbarButtons:{
      'moreText': {
        'buttons': ['html','BeyondGrammar','|','wirisEditor', 'wirisChemistry','bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
      },
      'moreParagraph': {
        'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
      },
      'moreRich': {
        'buttons': ['insertLink', 'insertImage', 'insertVideo','insertTable',, 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
      },
      'moreMisc': {
        'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'help']
      },
      'moreMisc': {
        'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'help']
      }
      // '|', 'BeyondGrammar'
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
            // const editor = this
            // this.el.closest('form').addEventListener('submit', function (e) {
            //   console.log(editor.$oel.val())

            //   var test = $('#contenteditable_update').val();
            //   //alert(test);

            //   e.preventDefault()
            // })
          }
        }
      })
    })()
  </script>

<script type="text/javascript" src="<?php echo base_url();?>style/froala_bg/beyond-grammar-plugin.js"></script>