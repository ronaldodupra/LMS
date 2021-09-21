<?php 
  $material_details = $this->db->get_where('document', array('document_id' => $param2))->row_array();
?>
<div class="modal-body">
  <div class="ui-block-title" style="background-color:#00579c">
    <h6 class="title" style="color:white"><?php echo get_phrase('update_study_material');?></h6>
  </div>
  <div class="ui-block-content">
    <?php //echo form_open(base_url() . 'teacher/study_material/update/'.$data, array('enctype' => 'multipart/form-data')); ?>
    <form enctype="multipart/form-data" id="form" onsubmit="event.preventDefault(); ">
      <input type="hidden" name="folder_name" value="document">
      <div class="row">
        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="form-group">
            <label class="control-label"><?php echo get_phrase('description');?></label>
            <textarea class="form-control" required="" rows="5" name="description"><?php echo $material_details['description'] ?></textarea>
          </div>
        </div>
        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="form-group">
            <label class="col-form-label" for=""><?php echo get_phrase('select_semester');?></label>
            <div class="select">
              <select name="semester_id" id="sem_id" required="">
                <option value=""><?php echo get_phrase('select');?></option>
                <?php $cl = $this->db->get('exam')->result_array();
                  foreach($cl as $row):
                  ?>
                <option value="<?php echo $row['exam_id'];?>" <?php if($material_details['semester_id'] == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                <?php endforeach;?>
              </select>
            </div>
          </div>
        </div>
        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
          <!-- image input -->
          <div class="form-group">
            <label class="col-sm-12 control-label"><?php echo get_phrase('Update file');?> <br><span class="text-danger"> Once you delete the file you will not be able to restore it. </span> </label>
            <div class="col-sm-12">
              <div class="form-group text-center">
                <span id="uploaded_image2"></span>
              </div>
              <div class="form-group text-center">
                <input type="file" name="file" id="file2" class="inputfile inputfile-3" style="display: none;" />
                <label style="font-size:15px;" title="Maximum upload is 10mb">
                  <span id="with_image">
                  <input type="hidden" id="file_n" value="<?php echo $material_details['file_name'] ?>">
                  <?php 
                    $test = explode('.', $material_details['file_name']);
                    $ext = strtolower(end($test));
                    
                    if($ext == 'gif' or $ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'jpeg'){
                    
                        $file_icon = '<i class="picons-thin-icon-thin-0082_image_photo_file" style="font-size:20px; color:gray;"></i>';
                        
                    }elseif($ext == 'doc' or $ext == 'docx'){
                        $file_icon = '<i class="picons-thin-icon-thin-0078_document_file_word_office_doc_text" style="font-size:20px; color:gray;"></i>';
                    }
                    elseif($ext == 'xlsx' or $ext == 'xls'){
                        $file_icon = '<i class="picons-thin-icon-thin-0111_folder_files_documents" style="font-size:20px; color:gray;"></i>';
                    }
                    elseif($ext == 'pdf'){
                        $file_icon = '<i class="picons-thin-icon-thin-0077_document_file_pdf_adobe_acrobat" style="font-size:20px; color:gray;"></i>';
                    }else{
                    
                        $file_icon = '<i class="picons-thin-icon-thin-0111_folder_files_documents" style="font-size:20px; color:gray;"></i>';
                    
                    }
                       
                    ?>
                  <a href="<?php echo base_url().'uploads/document/'.$material_details['file_name']; ?>" style="color:gray;">
                  <?php echo $file_icon; ?>
                  <?php echo $material_details['file_name'];?><span class="smaller">(<?php echo $material_details['filesize'];?>)</span></a>
                  <br> 
                  <button onclick="remove_file_2();" class="btn btn-sm btn-danger view_control"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i> Remove</button>
                  </span>
                  <span id="without_image">
                    <i class="os-icon picons-thin-icon-thin-0042_attachment hide_control"></i>
                    <span class="hide_control" onclick="$('#file2').click();"><?php echo get_phrase('upload_file');?>...</span>
                    <p >
                      <span class="hide_control os-icon picons-thin-icon-thin-0189_window_alert_notification_warning_error text-danger"></span>
                      <small class="text-danger hide_control"> <?php echo $date_today; ?> Maximum file size is 10mb.</small>
                    </p>
                  </span>
                </label>
              </div>
            </div>
          </div>
          <!-- image input -->
        </div>
      </div>
      <div class="form-buttons-w text-right">
        <center><button onclick="save_udpate_study_material();" id="btn_submit_s" class="btn btn-rounded btn-success btn-lg"><?php echo get_phrase('save');?></button></center>
      </div>
    </form>
    <?php //echo form_close();?>        
  </div>
</div>
<script type="text/javascript">
  function save_udpate_study_material(){
      //alert(<?php echo $param2 ?>);
      
      $.ajax({
         url:'<?php echo base_url();?>admin/study_material/update/<?php echo $param2 ?>',
         method:'POST',
         data:$("form#form").serialize(),
         cache:false,
         success:function(data)
         {
         window.location.href = '<?php echo base_url();?>admin/study_material/<?php echo $param3 ?>';
         }
      });
   }
  
  $(document).ready(function(){
  
    // image update
  
    check_image();
  
   $("#file2").change(function() {
    var name = document.getElementById("file2").files[0].name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if(jQuery.inArray(ext, ['gif','png','jpg','jpeg','pdf','xlsx','xls','doc','docx','ppt','pptx','accdb','one','txt','pub','rar','zip']) == -1) 
    {
     alert("Invalid Image File");
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("file2").files[0]);
    var f = document.getElementById("file2").files[0];
    var fsize = f.size||f.fileSize;
    if(fsize > 10000000)
    {
     //alert("Image File Size is very big");
  
     swal('error','Image File Size is very big atleast 10mb','error');
  
    }
    else
    {
     form_data.append("file", document.getElementById('file2').files[0]);
     $.ajax({
      url:"<?php echo base_url(); ?>admin/upload_study_material",
      method:"POST",
      data: form_data,
      contentType: false,
      cache: false,
      processData: false,
      beforeSend:function(){
        $('#btn_submit_s').prop('disabled','true');
       $('.hide_control').css('display','none');
       $('#uploaded_image2').html('<center><img src="<?php echo base_url();?>assets/images/preloader.gif" /> </span> <br> Uploading...');
       $('#file2').val('');
      },
      success:function(data)
      {
  
        $('#uploaded_image2').html(data);
  
        var file_size = $('#file_size').val();
  
        if(file_size == 'NAN B'){
  
          $('.hide_control').css('display','inline');
          $('.view_control').css('display','none');
          $('#btn_submit_s').prop('disabled',true);
          $('#uploaded_image2').html('<small class="text-danger">Error on uploading file. Try again.</span><br>');
          $('#file_loc').val('');
          $('#file_size').val('');
  
        }else{
  
          $('.hide_control').css('display','none');
          $('.view_control').css('display','inline');
          $('#btn_submit_s').prop('disabled',false);
  
        }
  
      }
     });
    }
   });
  
  });   
  
    function remove_file(){
  
       var file_loc = $('#question_title').val();
       var folder_name = $('#folder_name').val();
  
       $.ajax({
  
        url:"<?php echo base_url(); ?>admin/remove_image",
        method:"POST",
        data:{file_loc:file_loc,folder_name:folder_name},
        cache: false,
        beforeSend:function(){
         $('#uploaded_image2').html('<center><img src="<?php echo base_url();?>assets/images/preloader.gif" /> </span> <br> Removing Image...');
         $('#file').val('');
        },   
        success:function(data)
        {
  
          $('#uploaded_image2').html("");
          $('#file').val('');
          $('.hide_control').css('display','inline');
          
        }
  
       });
  
    }
  
    function remove_file_2(){
  
       var file_n = $('#file_n').val();
       var folder_name = $('#folder_name').val();
       var document_id = <?php echo $param2; ?>;
  
       $.ajax({
        url:"<?php echo base_url(); ?>admin/remove_file_study_material",
        method:"POST",
        data: {file_n:file_n,folder_name:folder_name,document_id:document_id},
        cache: false,  
        success:function(data)
        {
          check_image();
        }
  
       });
  
      }
  
      function check_image(){
  
       var document_id = <?php echo $param2; ?>;
  
       $.ajax({
        url:"<?php echo base_url(); ?>admin/check_file_study_material",
        method:"POST",
        data: {document_id:document_id},
        cache: false,  
        success:function(data)
        {
          if(data == 1){
            $('#with_image').css('display','inline');
            $('#without_image').css('display','none');
          }else{
            $('#with_image').css('display','none');
            $('#without_image').css('display','inline');
          }
        }
        
       });
  
   }
  
   // image update
  
</script>