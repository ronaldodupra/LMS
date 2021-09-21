<?php 
  $con_id = $param2; 
  $query = $this->db->query("SELECT * from tbl_live_consultation where consultation_id = '$con_id'")->row_array();
?>
<div class="modal-body">
<div class="ui-block-title" style="background-color:#00579c">
  <h6 class="title" style="color:white"><span class="fa fa-edit"></span> <?php echo get_phrase('update_live_consultation');?></h6>
</div>
<div class="ui-block-content">
  <!-- <?php //echo form_open(base_url() . 'admin/live_consultation/update/'.$con_id  , array('enctype' => 'multipart/form-data'));?><?php //echo form_close();?> -->
  <form enctype="multipart/form-data" id="live_con" onsubmit="event.preventDefault();">
    <div class="row">
      <input type="hidden" value="<?php echo $con_id;?>" name="con_id"/>
      <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
          <label class="control-label"><?php echo get_phrase('title');?></label>
          <input class="form-control" required="" name="title" type="text" value="<?php echo $query['title']?>">
        </div>
      </div>
      <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
          <label class="control-label"><?php echo get_phrase('date');?></label>
          <input type='text' required="" class="datepicker-here" data-position="top left" data-language='en' name="live_class_date" data-multiple-dates-separator="/" value="<?php echo $query['start_date']?>" />
        </div>
      </div>
      <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
          <label class="control-label"><?php echo get_phrase('start_time');?></label>
          <input type="time" required="" name="start_time" class="form-control" value="<?php echo $query['start_time']?>"> 
        </div>
      </div>
      <div class="col col-lg-12 col-md-12 col-sm-12 col-12" id="con_host">
        <div class="form-group">
          <label class="control-label"><?php echo get_phrase('select_host');?></label>
          <div class="select">
            <select name="host_id" id="host_id">
              <option value=""><?php echo get_phrase('select');?></option>
              <?php if ($query['host_id'] == 1): ?>
              <option value="1" selected><?php echo get_phrase('Zoom');?></option>
              <option value="2"><?php echo get_phrase('Jitsi Meet');?></option>
              <?php elseif ($query['host_id'] == 2): ?>
              <option value="1"><?php echo get_phrase('Zoom');?></option>
              <option value="2" selected><?php echo get_phrase('Jitsi Meet');?></option>
              <?php endif ?>
            </select>
          </div>
        </div>
      </div>
      <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
          <label class="control-label"><?php echo get_phrase('description');?></label>
          <textarea class="form-control" rows="2" name="description"><?php echo $query['description']; ?></textarea>
        </div>
      </div>
      <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
          <label class="control-label"><?php echo get_phrase('result');?></label>
          <textarea name="result" class="form-control" id="result" rows="5" cols="80"><?php echo $query['result'];?></textarea>
        </div>
      </div>
      <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
          <div class="form-buttons-w text-right">
            <center><button type="submit" class="btn btn-rounded btn-success btn-lg" onclick="save_live_con('<?php echo $con_id;?>');"><?php echo get_phrase('update');?></button></center>
          </div>
        </div>
      </div>      
    </div>
  </form>
</div>

<script type="text/javascript">
  function save_live_con($param){
    //alert($param +' '+ $exam_id);

    $.ajax({
      url:'<?php echo base_url();?>admin/live_consultation/update/' + $param,
      method:'POST',
      data:$("form#live_con").serialize(),
      cache:false,
      success:function(data)
      {
        window.location.href = '<?php echo base_url();?>admin/live_consultation/';
      }
    });
  }
</script>

<script>
  (function () {
    new FroalaEditor("#result",{key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==", 
    attribution: false,
    htmlAllowedTags:   ['.*'],
    htmlAllowedAttrs: ['.*'],
    toolbarButtons:{
      'moreText': {
        'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
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
   
             var test = $('#result').val();
             //alert(test);
   
             e.preventDefault()
           })
         }
       }
     })
   })()
</script>