<?php $study_material_details = $this->db->get_where('document', array('document_id' => $param2))->row_array();

?>
<div class="modal-body">
   <div class="modal-header" style="background-color:#00579c">
      <h6 class="title" style="color:white"><?php echo get_phrase('copy_study_material_to:');?></h6>
   </div>
   <div class="ui-block-content">
      <div class="row">
         <div class="col-md-12">
            <?php //echo form_open(base_url() . 'admin/online_quiz/copy_quiz/'.$data, array('enctype' => 'multipart/form-data')); ?>
            <form enctype="multipart/form-data" id="section_update" onsubmit="event.preventDefault(); copy_section();">
            <div class="row">
               <div class="col-md-6">

                <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('select_class_&_section');?></label>
                     <div class="select">
                        <select id="sec_id" required="" name="sec_id" onchange="subject_holder(this.value);">
                           <option value="0"><?php echo get_phrase('select');?></option>
                           <?php 
                           $teacher_id =  $this->session->userdata('login_user_id');
                            
                            $class = $this->db->query("SELECT t2.`section_id`,t1.`name` AS class, t2.`name` AS section FROM class t1 LEFT JOIN section t2 ON t1.`class_id` = t2.`class_id` ORDER BY t1.`class_id` ASC")->result_array();

                           foreach($class as $row):
                           ?>
                           <option value="<?php echo $row['section_id'];?>"><?php echo $row['class'].' - '. $row['section'];?></option>
                           <?php endforeach;?>
                        </select>
                     </div>
                </div>
               </div>
               <div class="col-md-6">
                <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('select_subject');?></label>
                     <div class="select">
                        <select name="sub_id" required id="sub_holder">
                          <option value=""><?php echo get_phrase('select');?></option>
                        </select>
                     </div>
                </div>
               </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label"><?php echo get_phrase('description');?></label>
                    <textarea class="form-control" required="" rows="5" name="description"><?php echo $study_material_details['description'] ?></textarea>
                 </div>
              </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('select_semester');?></label>
                     <div class="select">
                        <select name="semester_id" id="sem_id">
                           <option value=""><?php echo get_phrase('select');?></option>
                                 <?php $cl = $this->db->get('exam')->result_array();
                                    foreach($cl as $row):
                                    ?>
                                 <option value="<?php echo $row['exam_id'];?>" <?php if($study_material_details['semester_id'] == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                 <?php endforeach;?>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-sm-8">
                  <div class="form-group">
                     <label class="col-form-label" for=""><?php echo get_phrase('Document');?></label>
                     <br>
                     <?php 

                       $test = explode('.', $study_material_details['file_name']);
                       $ext = strtolower(end($test));

                       if($ext == 'gif' or $ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'jpeg'){
                           $file_icon = '<i class="text-primary picons-thin-icon-thin-0082_image_photo_file" style="font-size:20px;"></i>';
                       }elseif($ext == 'doc' or $ext == 'docx'){
                           $file_icon = '<i class="text-primary picons-thin-icon-thin-0078_document_file_word_office_doc_text" style="font-size:20px;"></i>';
                       }
                       elseif($ext == 'xlsx' or $ext == 'xls'){
                           $file_icon = '<i class="text-primary picons-thin-icon-thin-0111_folder_files_documents" style="font-size:20px;"></i>';
                       }
                       elseif($ext == 'pdf'){
                           $file_icon = '<i class="text-primary picons-thin-icon-thin-0077_document_file_pdf_adobe_acrobat" style="font-size:20px;"></i>';
                       }else{
                           $file_icon = '<i class="text-primary picons-thin-icon-thin-0111_folder_files_documents" style="font-size:20px;"></i>';
                       }
                    ?>
                    <?php if($study_material_details['file_name'] <> ''){ ?>

                        <a download="" class="text-primary" href="<?php echo base_url().'uploads/document/'.$study_material_details['file_name']; ?>" target="_blank" style="color:gray;">
                        <?php echo $file_icon; ?>
                        <?php echo $study_material_details['file_name'];?>
                        <span class="smaller">(<?php echo $study_material_details['filesize'];?>)</span>
                       </a>

                    <?php }else{ ?>
                      <small class="text-danger">No file Found!</small>
                    <?php } ?>
                  </div>
               </div>
            </div>
            <input type="hidden" name="document_id" id="document_id" value="<?php echo $param2; ?>">
            <div class="form-group">
               <div class="col-sm-12" style="text-align: center;">
                  <button type="submit" class="btn btn-success"><?php echo get_phrase('copy');?></button>
               </div>
            </div>
            </form>
            <?php //echo form_close();?>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">

  function copy_section()
  {
    $.ajax({
      url:'<?php echo base_url();?>admin/copy_study_material',
      method:'POST',
      data:$("form#section_update").serialize(),
      cache:false,
      success:function(data)
      {
        if(data == 1){
        swal("LMS", "Study material successfully copied.", "success");
        $('#exampleModal').modal('hide');
        }else{
        swal("LMS", "Error on adding data", "error");
        } 
      }
    });
  }

  function subject_holder(section_id) 
  {
    $.ajax({
      url: '<?php echo base_url();?>admin/get_subjectss/' + section_id ,
      success: function(response)
      {
      $('#sub_holder').html(response);
      }
    });
  }
</script>