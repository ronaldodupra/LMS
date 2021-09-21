<?php $data_details = $this->db->get_where('deliveries', array('id' => $answer_id))->row_array(); ?>

 <div class="col-md-1">
    <textarea spellcheck="false" contenteditable="false" class="form-control" name="document" id="contenteditable_update"><?php echo $data_details['homework_reply']; ?></textarea>
 </div>
      
<script>

    (function () {
      new FroalaEditor("#contenteditable_update",{key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==", 
      attribution: false,
      contenteditable:false,
      spellcheck: false,
      documentReady: true,
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
        'buttons': ['fullscreen','print','getPDF']
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