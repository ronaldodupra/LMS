<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php 
   $info = base64_decode($data);
   $ex = explode('-', $info);

   $dept = $this->db->query("SELECT b.`department_id` FROM subject a LEFT JOIN class b ON a.`class_id` = b.`class_id` WHERE a.`subject_id` = '$ex[2]'")->row()->department_id;

  if ($dept == 1 OR $dept == 2) {
    $categ = 1;
  }
  elseif ($dept == 3 OR $dept == 4) {
    $categ = 2;
  }
?>
<?php $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
   foreach($sub as $rows):
?>
<div class="content-w">
   <div class="conty">
      <?php $info = base64_decode($data);?>
      <?php $ids = explode("-",$info);?>
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="cursos cta-with-media" style="background: #<?php echo $rows['color'];?>;">
         <div class="cta-content">
            <div class="user-avatar">
               <?php 
                  if($row['icon'] != null || $row['icon'] != ""){
                    $imgs = base_url()."uploads/subject_icon/". $row['icon'];
                  }else{
                    $imgs = base_url()."uploads/subject_icon/default_subject.png";
                  }
               ?>
               <img alt="" src="<?php echo $imgs;?>" style="width:60px;">
            </div>
            <h3 class="cta-header"><?php echo $rows['name'];?> - <small><?php echo get_phrase('study_material');?></small></h3>
            <small style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"</small>
         </div>
      </div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>student/subject_dashboard/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo get_phrase('dashboard');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>student/online_exams/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_exams');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>student/online_quiz/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_quiz');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>student/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('activity');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>student/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>student/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>student/video_link/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i><span><?php echo get_phrase('video_links');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>student/live_class/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo get_phrase('live_classroom');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>student/upload_marks/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('marks');?></span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                  <div id="newsfeed-items-grid">
                     <div class="element-wrapper">
                        <div class="element-box-tp">
                           <h5 class="element-header"><?php echo get_phrase('study_material');?></h5>
                           <div class="os-tabs-w">
                              <div class="os-tabs-controls">
                                 <ul class="navs navs-tabs upper">
                                    <?php 
                                       $active = 0;
                                       $query = $this->db->query("SELECT * from exam WHERE category = '$categ' ORDER BY exam_id ASC"); 
                                       if ($query->num_rows() > 0):
                                       $sections = $query->result_array();
                                       foreach ($sections as $rows): $active++;
                                       $status= $rows['status']; 
                                       $sems = explode(" ", $rows['name']);
                                    ?>
                                    <li class="navs-item">
                                       <a class="navs-links <?php if($status == 1) echo "active";?>" data-toggle="tab" href="#tab<?php echo $rows['exam_id'];?>"><?php echo $sems[0];?></a>
                                    </li>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                 </ul>
                              </div>
                            </div>
                           <div class="tab-content">
                             
                              <?php 
                                 $query1 = $this->db->query("SELECT * from exam WHERE category = '$categ' ORDER BY exam_id ASC");
                                 if ($query1->num_rows() > 0):
                                 $semesters = $query1->result_array();
                                 
                                 foreach ($semesters as $row_s): 
                                 $semester_id = $row_s['exam_id'];
                                 
                                 $status= $row_s['status'];?>
                              <div class="tab-pane <?php if($status == 1) echo "active";?>" id="tab<?php echo $row_s['exam_id'];?>">
                                 <div class="table-responsive" style="margin-top: -1.5%;">
                                    <table class="table table-padded">

                                       <thead>
                                          <tr>
                                             <th style="width: 30%"><?php echo get_phrase('description');?></th>
                                             <th style="width: 30%"><?php echo get_phrase('file');?></th>
                                             <th style="width: 10%" class="text-center"><?php echo get_phrase('type');?></th>
                                             <th style="width: 15%" class="text-center"><?php echo get_phrase('options');?></th>
                                          </tr>
                                       </thead>

                                       <tbody>
                                          <?php
                                             $study_material = $this->db->query("SELECT * from document where class_id = '$ids[0]' and section_id = '$ids[1]' and subject_id = '$ids[2]' and semester_id = '$semester_id' order by document_id desc");
                                             
                                             if($study_material->num_rows() > 0):
                                             
                                             foreach ($study_material->result_array() as $row): ?>
                                          <tr>
                                             <td><?php echo $row['description']?></td>
                                             <td class="text-center cell-with-media">

                                                  <?php 

                                                    $test = explode('.', $row['file_name']);
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

                                                  <?php 

                                                  if($row['doc_type'] == 'online_text'){ ?>

                                                     <a target="_blank" href="<?php echo base_url();?>teacher/study_material_preview_data/<?php echo $row['document_id'];?>/" class="btn btn-sm btn-success text-center"><span class="fa fa-print"></span> View Online Text </a>

                                                  <?php }else{

                                                    if($row['file_name'] <> ''){ ?>

                                                      <!-- <a download="" href="<?php echo base_url().'uploads/document/'.$row['file_name']; ?>" style="color:gray;">
                                                      <?php echo $file_icon; ?>
                                                      <?php echo $row['file_name'];?></span><span class="smaller">(<?php echo $row['filesize'];?>)</span></a> -->
                                                      <a target="_blank" href="https://docs.google.com/viewerng/viewer?url=<?php echo base_url().'uploads/document/'.$row['file_name']; ?>" style="color:gray;">
                                                        <?php echo $file_icon; ?>
                                                        <?php echo $row['file_name'];?></span><span class="smaller">(<?php echo $row['filesize'];?>)</span>
                                                     </a>

                                                    <?php }else{ ?>

                                                      <small class="text-danger">No file Found!</small>

                                                    <?php } 

                                                  } ?>
                                                  
                                                </td>

                                             <td class="text-center">
                                                  <?php 

                                                    if($row['doc_type'] == 'online_text'){
                                                      echo '<span class="btn btn-sm  btn-success"> Online Text </span>';
                                                    }else{
                                                      echo '<span class="btn btn-sm  btn-info"> Files </span>';
                                                    }

                                                  ?>
                                                </td>

                                             <td class="text-center bolder">
                                              <a target="_blank" href="https://docs.google.com/viewerng/viewer?url=<?php echo base_url().'uploads/document/'.$row['file_name']; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i>
                                                 View</a>
                                                <a download="" onclick="download_file('<?php echo $ex[2]; ?>')" href="<?php echo base_url().'uploads/document/'.$row['file_name'];?>" class="btn btn-primary btn-sm"><i class="picons-thin-icon-thin-0121_download_file"></i> 
                                                 Download</a>
                                             </td>
                                          </tr>
                                          <?php endforeach;
                                             else:?>
                                          <tr>
                                             <td colspan="3" class="text-center"> No data Found...</td>
                                          </tr>
                                          <?php endif;?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <?php endforeach;?>
                              <?php endif;?>
                           </div>
                        </div>
                     </div>
                  </div>
               </main>
            </div>
         </div>
      </div>
   </div>
</div>
<?php endforeach;?>

<script type="text/javascript">
   
   function download_file(subject_id){

      var subject_id = subject_id;

      $.ajax({
         url:"<?php echo base_url();?>student/download_st",
         type:'POST',
         data:{subject_id:subject_id},
         success:function(result)
         {

         }});

   }

</script>