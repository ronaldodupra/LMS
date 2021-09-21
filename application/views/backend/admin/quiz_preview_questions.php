<?php

   
   
   $system_name        =   $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
   $system_email       =   $this->db->get_where('settings' , array('type'=>'system_email'))->row()->description;
   $running_year       =   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
   $phone              =   $this->db->get_where('settings' , array('type'=>'phone'))->row()->description;
   
   $online_quiz_details = $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $online_quiz_id))->row_array();
   
   $exam_name          =   $this->db->get_where('exam' , array('exam_id' => $online_quiz_details['semester_id']))->row()->name;

   $subject_info = $this->db->get_where('subject', array('subject_id' => $online_quiz_details['subject_id']))->row_array();
   
   $subject_image = $subject_info['icon'];
   
   if($subject_image <> '' || $subject_image <> null){
     $subject_image = base_url()."uploads/subject_icon/". $subject_image;
   }else{
     $subject_image = base_url()."uploads/subject_icon/default_subject.png";
   }

   $class_name = $this->db->get_where('class' , array('class_id' => $online_quiz_details['class_id']))->row()->name;
   
   $section_name = $this->db->get_where('section' , array('section_id' => $online_quiz_details['section_id']))->row()->name;
   
   $semester = $this->db->get_where('exam' , array('exam_id' => $online_quiz_details['semester_id']))->row()->name;
   
   $class_id = $online_quiz_details['class_id'];
   $section_id = $online_quiz_details['section_id'];
   

   $question_array = $this->db->query("SELECT * from tbl_question_bank_quiz where online_quiz_id = '$online_quiz_id'")->result_array();
   
   $multiple_choice_questions = $this->db->query("SELECT * from tbl_question_bank_quiz where online_quiz_id = '$online_quiz_id' and type='multiple_choice'");
   
   $true_or_false = $this->db->query("SELECT * from tbl_question_bank_quiz where online_quiz_id = '$online_quiz_id' and type='true_false'");
   
   $fill_in_the_blanks = $this->db->query("SELECT * from tbl_question_bank_quiz where online_quiz_id = '$online_quiz_id' and type='fill_in_the_blanks'");

   $identification = $this->db->query("SELECT * from tbl_question_bank_quiz where online_quiz_id = '$online_quiz_id' and type='identification'");

   $enumeration = $this->db->query("SELECT * from tbl_question_bank_quiz where online_quiz_id = '$online_quiz_id' and type='enumeration'");
   
   $essay = $this->db->query("SELECT * from tbl_question_bank_quiz where online_quiz_id = '$online_quiz_id' and type='essay'");
   
   $image = $this->db->query("SELECT * from tbl_question_bank_quiz where online_quiz_id = '$online_quiz_id' and type='image'");
   
   
   $total_mark = $this->crud_model->get_total_mark_quiz($online_quiz_id);
   
   ?>
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>style/cms/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>style/cms/css/main.css?version=3.3" rel="stylesheet">
<style>
   * {
   -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
   color-adjust: exact !important;                 /*Firefox*/
   }
</style>
<div class="content-w">
   <div class="content-i">
      <div class="content-box">
         <div class="element-wrapper">
            <div class="rcard-wy" id="print_area">
               <div class="rcard-w">
                  <!-- HEADER -->
                  <div class="row">
                     <div class="col-md-2"> 
                        <img width="100px"  src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" title="<?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>">
                     </div>
                     <div class="col-md-10"> 
                        <div style="width: 100%; margin-top:4%;">
                         <h3 style="text-align: center;"><?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></h3>
                     </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-2"> 
                        
                     </div>
                     <div class="col-md-10"> 
                        <div class="rcard-heading mb-1" style=" ;margin-top: -7%; margin-bottom: -20px;">
                
                           <p class="h5" style="text-align: center"><?php echo $online_quiz_details['title'].' in'.' '.strtoupper($subject_info['name']); ?><br>
                              
                           </p>
                          <p class="h6" style="text-align: center"><?php echo $class_name;?></p>
                        </div>
                     </div>
                  </div>
                  <hr>
                  <!-- HEADER -->
                  <!-- Multiple Choices -->
                  <?php if($multiple_choice_questions->num_rows() > 0){ ?>
                     <?php 
                        $direction = $this->db->query("SELECT * from tbl_quiz_directions where question_type = 'multiple_choice' and online_quiz_id = '$online_quiz_id'");
                        
                        if($direction->num_rows() > 0){
                         echo '<b>MULTIPLE CHOICES:</b><br>'.$direction->row()->directions;
                        }else{
                         echo '<b>MULTIPLE CHOICES:</b><br>';
                        }      
                        ?>
                     <div class="col-md-12 row">
                        <ol>
                           <?php $counter = 0;  foreach ($multiple_choice_questions->result_array() as $row): $counter++;
                              $correct_answers  = $this->crud_model->get_correct_answer_quiz($question['question_bank_id']);
                                            
                              $options_json = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'options');
                              
                              $number_of_options = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'number_of_options');
                              
                              if($options_json != '' || $options_json != null)
                                
                                  $options = json_decode($options_json);
                                
                                else $options = array();
                                
                              if ($row['correct_answers'] != "" || $row['correct_answers'] != null) {
                              
                              $correct_options = json_decode($row['correct_answers']);
                              
                              $c = '';
                              
                              for ($i = 0; $i < count($correct_options); $i++) {
                              
                                $x = $correct_options[$i];
                              
                                $c .= $options[$x-1].',';
                              
                              }
                              
                              } else {
                              
                              $correct_options = array();
                              
                              $c = get_phrase('none_of_them.');
                              
                              }
                              
                              ?>
                           <li style="line-height: 18px;">
                              <?php $img = $row['image'];
                                 if($img <> ''){ ?>
                              <img src="<?php echo base_url('uploads/online_quiz/'.$row['image']);?>" class="img-fluid img-responsive img-thumbnail" width="80px;">
                              <?php }else{ ?>
                              <?php } ?>
                              <p><?php echo $row['question_title']; ?></p>
                              <ul>
                                 <?php 
                                    if($options_json != '' || $options_json != null)
                                    $options = json_decode($options_json);
                                    
                                    else $options = array();
                                    
                                    ?>
                                 <?php for ($i = 0; $i < $number_of_options; $i++): $count = $i + 1;?>
                                 <li class="text-left"><small><b><?php echo $options[$i]; ?></b></small></li>
                                 <?php endfor; ?>
                              </ul>
                           </li>
                           <?php endforeach; ?>  
                        </ol>
                     </div>
                  <?php } ?>
                  <!-- Multiple Choices -->
                  <!-- True or false -->
                  <?php if($true_or_false->num_rows() > 0){ ?>
                     <?php 
                        $direction = $this->db->query("SELECT * from tbl_quiz_directions where question_type = 'true_false' and online_quiz_id = '$online_quiz_id'");
                        
                        if($direction->num_rows() > 0){
                         echo '<b> True or False:</b><br>'.$direction->row()->directions;
                        }else{
                         echo '<b>True or False:</b><br>';
                        }      
                        
                        ?>
                     <div class="col-md-12 row">
                        <ol>
                           <?php $counter = 0;  foreach ($true_or_false->result_array() as $row): $counter++;
                              ?>
                           <li style="line-height: 18px;">
                              <?php $img = $row['image'];
                                 if($img <> ''){ ?>
                              <img src="<?php echo base_url('uploads/online_quiz/'.$row['image']);?>" class="img-fluid img-responsive img-thumbnail" width="80px;">
                              <?php }else{ ?>
                              <?php } ?>
                              <p><?php echo $row['question_title']; ?></p>
                           </li>
                           <?php endforeach; ?>  
                        </ol>
                     </div>
                  <?php } ?>
                  <!-- True or False -->
                  <!-- Fill in the blanks -->
                  <?php if($fill_in_the_blanks->num_rows() > 0){ ?>
                     <?php 
                        $direction = $this->db->query("SELECT * from tbl_quiz_directions where question_type = 'fill_in_the_blanks' and online_quiz_id = '$online_quiz_id'");
                        
                        if($direction->num_rows() > 0){
                         echo '<b> Fill in the blanks:</b><br>'.$direction->row()->directions;
                        }else{
                         echo '<b> Fill in the blanks:</b><br>';
                        }      
                        
                        ?>
                     <div class="col-md-12 row">
                        <ol>
                           <?php $counter = 0;  foreach ($fill_in_the_blanks->result_array() as $row): $counter++;
                              ?>
                           <li style="line-height: 18px;">
                              <?php $img = $row['image'];
                                 if($img <> ''){ ?>
                              <img src="<?php echo base_url('uploads/online_quiz/'.$row['image']);?>" class="img-fluid img-responsive img-thumbnail" width="80px;">
                              <?php }else{ ?>
                              <?php } ?>
                              <p><?php echo $row['question_title']; ?></p>
                           </li>
                           <?php endforeach; ?>  
                        </ol>
                     </div>
                  <?php } ?>
                  <!-- Fill in the blanks -->
                  <!-- Identification -->
                  <?php if($identification->num_rows() > 0){ ?>
                     <?php 
                        $direction = $this->db->query("SELECT * from tbl_quiz_directions where question_type = 'identification' and online_quiz_id = '$online_quiz_id'");
                        
                        if($direction->num_rows() > 0){
                         echo '<b> Identification:</b><br>'.$direction->row()->directions;
                        }else{
                         echo '<b> Identification:</b><br>';
                        }      
                        
                        ?>
                     <div class="col-md-12 row">
                        <ol>
                           <?php $counter = 0;  foreach ($identification->result_array() as $row): $counter++;
                              ?>
                           <li style="line-height: 18px;">
                              <?php $img = $row['image'];
                                 if($img <> ''){ ?>
                              <img src="<?php echo base_url('uploads/online_quiz/'.$row['image']);?>" class="img-fluid img-responsive img-thumbnail" width="80px;">
                              <?php }else{ ?>
                              <?php } ?>
                              <p><?php echo $row['question_title']; ?></p>
                           </li>
                           <?php endforeach; ?>  
                        </ol>
                     </div>
                  <?php } ?>
                  <!-- Identification -->
                  <!-- Enumeration -->
                  <?php if($enumeration->num_rows() > 0){ ?>
                     <?php 
                        $direction = $this->db->query("SELECT * from tbl_quiz_directions where question_type = 'enumeration' and online_quiz_id = '$online_quiz_id'");
                        
                        if($direction->num_rows() > 0){
                         echo '<b> Enumeration:</b><br>'.$direction->row()->directions;
                        }else{
                         echo '<b> Enumeration:</b><br>';
                        }      
                        
                        ?>
                     <div class="col-md-12 row">
                        <ol>
                           <?php $counter = 0;  foreach ($enumeration->result_array() as $row): $counter++;
                              ?>
                           <li style="line-height: 18px;">
                              <?php $img = $row['image'];
                                 if($img <> ''){ ?>
                              <img src="<?php echo base_url('uploads/online_quiz/'.$row['image']);?>" class="img-fluid img-responsive img-thumbnail" width="80px;">
                              <?php }else{ ?>
                              <?php } ?>
                              <p><?php echo $row['question_title']; ?></p>
                           </li>
                           <?php endforeach; ?>  
                        </ol>
                     </div>
                  <?php } ?>
                  <!-- Enumeration -->
                  <!-- Essay -->
                  <?php if($essay->num_rows() > 0){ ?>
                     <?php 
                        $direction = $this->db->query("SELECT * from tbl_quiz_directions where question_type = 'essay' and online_quiz_id = '$online_quiz_id'");
                        
                        if($direction->num_rows() > 0){
                         echo '<b> Essay:</b><br>'.$direction->row()->directions;
                        }else{
                         echo '<b> Essay:</b><br>';
                        }      
                        
                        ?>
                     <div class="col-md-12 row">
                        <ol>
                           <?php $counter = 0;  foreach ($essay->result_array() as $row): $counter++;
                              ?>
                           <li style="line-height: 18px;">
                              <?php $img = $row['image'];
                                 if($img <> ''){ ?>
                              <img src="<?php echo base_url('uploads/online_quiz/'.$row['image']);?>" class="img-fluid img-responsive img-thumbnail" width="80px;">
                              <?php }else{ ?>
                              <?php } ?>
                              <p><?php echo $row['question_title']; ?></p>
                           </li>
                           <?php endforeach; ?>  
                        </ol>
                     </div>
                  <?php } ?>
                  <!-- Essay-->
                  <!-- Image -->
                  <?php if($image->num_rows() > 0){ ?>
                     <?php 
                        $direction = $this->db->query("SELECT * from tbl_quiz_directions where question_type = 'image' and online_quiz_id = '$online_quiz_id'");
                        
                        if($direction->num_rows() > 0){
                         echo '<b> Image:</b><br>'.$direction->row()->directions;
                        }else{
                         echo '<b> Image:</b><br>';
                        }      
                        
                        ?>
                     <div class="col-md-12 row">
                        <ol>
                           <?php $counter = 0;  foreach ($image->result_array() as $row): $counter++;
                              $options_json = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'options');
                              
                              ?>
                           <li style="line-height: 18px;">
                              <?php $img = $row['image'];
                                 if($img <> ''){ ?>
                              <img src="<?php echo base_url('uploads/online_quiz/'.$row['image']);?>" class="img-fluid img-responsive img-thumbnail" width="80px;">
                              <?php }else{ ?>
                              <?php } ?>
                              <p><?php echo $row['question_title']; ?></p>
                              <?php $number_of_options = $this->crud_model->get_question_details_by_id_quiz($row['question_bank_id'], 'number_of_options');
                                 if($options_json != '' || $options_json != null)
                                 
                                   $options = json_decode($options_json);
                                 
                                 else $options = array();
                                 
                                 ?>
                              <ul>
                                 <?php for ($i = 0; $i < $number_of_options; $i++): ?>
                                 <li><img width="80px" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_question_image/<?php echo $options[$i];?>');" style="margin:10px;" src="<?php echo base_url();?>uploads/online_quiz/<?php echo rtrim(trim($options[$i]), ',');?>"></li>
                                 <?php endfor; ?>
                              </ul>
                           </li>
                           <?php endforeach; ?>  
                        </ol>
                     </div>
                  <?php } ?>
                  <!-- Image-->
                  <div class="rcard-footer">
                     <div class="rcard-logo">
                        <img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"><span><?php echo $system_name;?></span>
                     </div>
                     <div class="rcard-info">
                        <span>Prepared by:</span><span><?php  echo $this->crud_model->get_name('teacher', $online_quiz_details['uploader_id']); ?></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <button class="btn btn-info btn-rounded" onclick="printDiv('print_area')"><?php echo get_phrase('print');?></button>
      </div>
   </div>
</div>
<script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
<script>
   function printDiv(nombreDiv) 
   {
       var contenido= document.getElementById(nombreDiv).innerHTML;
       var contenidoOriginal= document.body.innerHTML;
       document.body.innerHTML = contenido;
       window.print();
       document.body.innerHTML = contenidoOriginal;
   }
</script>
<style type="text/css">
   /*td:nth-child(2) {line-height: 1px;}*/
</style>