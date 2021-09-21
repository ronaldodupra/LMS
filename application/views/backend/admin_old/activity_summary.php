<?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;?>
<style type="text/css">
                                               
  .text_ellipsis{
    max-width: 100px;
     overflow: hidden;
     text-overflow: ellipsis;
     white-space: nowrap;
  }

</style>
<div class="content-w">
   <?php include 'fancy.php';?>
   <div class="header-spacer"></div>
   <div class="conty">
      <div class="all-wrapper no-padding-content solid-bg-all">
         <div class="layout-w">
            <div class="content-w">
               <div class="content-i">
                  <div class="content-box">
                     <div class="app-email-w">
                        <div class="app-email-i">
                           <div class="ae-content-w" style="background-color: #f2f4f8;">
                              <div class="top-header top-header-favorit">
                                 <div class="top-header-thumb">
                                    <img src="<?php echo base_url();?>uploads/bglogin.jpg" style="height:180px; object-fit:cover;">
                                    <div class="top-header-author">
                                       <div class="author-thumb">
                                          <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff; padding:10px;">
                                       </div>
                                       <div class="author-content">
                                          <a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('Summary of Activities');?></a>
                                          <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="profile-section" style="background-color: #fff;">
                                    <div class="control-block-button">
                                    </div>
                                 </div>
                              </div>
                              <div class="aec-full-message-w">
                                 <div class="aec-full-message">
                                    <div class="container-fluid" style="background-color: #f2f4f8;">
                                       <br>
                                       <div class="col-sm-12">
                                          <?php echo form_open(base_url() . 'admin/activity_summary/', array('class' => 'form m-b'));?>
                                          <div class="row">
                                             <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating is-select">
                                                   <label class="control-label">Filter By Class</label>
                                                   <div class="select">
                                                      <select name="class_id" id="slct">
                                                         <option value="0"><?php echo get_phrase('All');?></option>
                                                         <?php $cl = $this->db->get('class')->result_array();
                                                            foreach($cl as $row):
                                                            ?>
                                                         <option value="<?php echo $row['class_id'];?>" <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                                         <?php endforeach;?>
                                                      </select>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col col-lg-2 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating is-select">
                                                   <label class="control-label">Filter By Year</label>
                                                   <div class="select">
                                                      <select name="year" id="year">
                                                         <?php 
                                                        
                                                          for ($i = date('Y'); $i >= 2020; $i--){ ?>

                                                           <option value="<?php echo $i;?>" <?php if($year_now == $i) echo 'selected';?>><?php echo $i;?></option>

                                                          <?php } ?>

                                                      </select>

                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating is-select">
                                                   <label class="control-label">Filter By Teacher</label>
                                                   <div class="select">
                                                      <select name="teacher_id">
                                                         <option value="0"><?php echo get_phrase('All');?></option>
                                                         <?php 

                                                         //$teacher = $this->db->get('teacher')->result_array();
                                                         $teacher = $this->db->query("SELECT * from teacher order by last_name asc")->result_array();
                                                         foreach($teacher as $row):
                                                            ?>
                                                         <option value="<?php echo $row['teacher_id'];?>" <?php if($teacher_id == $row['teacher_id']) echo 'selected';?>>
                                                         <?php echo strtoupper($row['last_name']. ', ' . $row['first_name']);?></option>
                                                         <?php endforeach;?>

                                                      </select>
                                                   </div>
                                                </div>
                                             </div>
                                             
                                             <div class="col col-lg-2 col-md-6 col-sm-12 col-12">
                                                <button class="btn btn-lg btn-primary"><span class="fa fa-filter"></span> Search</button>
                                             </div>

                                          </div>
                                          <?php echo form_close();?>
                                       </div>
                                       <?php //echo $class_id .' - ' . $teacher_id ?>
                                       <div class="col col-xl-12 m-auto col-lg-12 col-md-12">
                                          <div class="os-tabs-w">
                                             <div class="os-tabs-controls">
                                                <ul class="navs navs-tabs upper">
                                                   <?php 
                                                      $active = 0;
                                                      
                                                      for($m=1; $m<=12; ++$m){ 
                                                      
                                                      $month_val = date('m', mktime(0, 0, 0, $m, 1));
                                                      $month_name = date('M', mktime(0, 0, 0, $m, 1));
                                                      $month_now = date('m');
                                                      // QUERIES
                                                      
                                                      if($class_id == 0 and $teacher_id == 0){
                                                    
                                                       $online_exams = $this->db->query("SELECT * FROM online_exam WHERE MONTH(examdate) = '$month_val' and YEAR(examdate) = '$year_now' order by examdate desc");
                                                        
                                                       $online_quizzes = $this->db->query("SELECT * FROM tbl_online_quiz WHERE MONTH(quizdate) = '$month_val' and YEAR(quizdate) = '$year_now' order by quizdate desc");
                                                      
                                                       $activities = $this->db->query("SELECT * FROM homework WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");
                                                      
                                                       $forums = $this->db->query("SELECT * FROM forum WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now'  ORDER BY publish_date DESC");
                                                      
                                                       $study_materials = $this->db->query("SELECT * FROM document WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");
                                                      
                                                       $video_links = $this->db->query("SELECT * FROM tbl_video_link WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");
                                                      
                                                       $live_classes = $this->db->query("SELECT * FROM tbl_live_class WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");

                                                      }else if($class_id == 0 and $teacher_id > 0){

                                                         $online_exams = $this->db->query("SELECT * FROM online_exam WHERE MONTH(examdate) = '$month_val' and YEAR(examdate) = '$year_now' AND class_id = '$class_id' and uploader_id = '$teacher_id' order by examdate desc");
                                                      
                                                         $online_quizzes = $this->db->query("SELECT * FROM tbl_online_quiz WHERE MONTH(quizdate) = '$month_val' and YEAR(quizdate) = '$year_now' AND uploader_id = '$teacher_id' order by quizdate desc");
                                                        
                                                         $activities = $this->db->query("SELECT * FROM homework WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND uploader_id = '$teacher_id' ORDER BY publish_date DESC");
                                                        
                                                         $forums = $this->db->query("SELECT * FROM forum WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                        
                                                         $study_materials = $this->db->query("SELECT * FROM document WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                        
                                                         $video_links = $this->db->query("SELECT * FROM tbl_video_link WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                        
                                                         $live_classes = $this->db->query("SELECT * FROM tbl_live_class WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND teacher_id = '$teacher_id' ORDER BY publish_date DESC");

                                                      }else{
                                                      
                                                       $online_exams = $this->db->query("SELECT * FROM online_exam WHERE MONTH(examdate) = '$month_val' and YEAR(examdate) = '$year_now' AND class_id = '$class_id' and uploader_id = '$teacher_id' order by examdate desc");
                                                      
                                                       $online_quizzes = $this->db->query("SELECT * FROM tbl_online_quiz WHERE MONTH(quizdate) = '$month_val' and YEAR(quizdate) = '$year_now' AND class_id = '$class_id' and uploader_id = '$teacher_id' order by quizdate desc");
                                                      
                                                       $activities = $this->db->query("SELECT * FROM homework WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' and uploader_id = '$teacher_id' ORDER BY publish_date DESC");
                                                      
                                                       $forums = $this->db->query("SELECT * FROM forum WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' and teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                      
                                                       $study_materials = $this->db->query("SELECT * FROM document WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' and teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                      
                                                       $video_links = $this->db->query("SELECT * FROM tbl_video_link WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' and teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                      
                                                       $live_classes = $this->db->query("SELECT * FROM tbl_live_class WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' and teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                      
                                                      }
                                                      
                                                      $total_activities = $online_exams->num_rows() + $online_quizzes->num_rows() + $activities->num_rows() + $forums->num_rows() + $study_materials->num_rows() + $video_links->num_rows() + $live_classes->num_rows();
                                                      
                                                      $active++;

                                                      if($total_activities > 0){ ?>
                                                   <li class="navs-item">
                                                      <a class="navs-links <?php if($month_now == $month_val) echo "active";?>" data-toggle="tab" href="#tab<?php echo $month_val;?>"><?php echo $month_name;?> - <?php echo $total_activities; ?> 
                                                      </a>
                                                   </li>
                                                   <?php }
                                                      ?>
                                                   <?php } ?>
                                                </ul>
                                             </div>
                                          </div>
                                       </div>

                                       <div class="container-fluid" style="background-color: #f2f4f8;">

                                          <div class="tab-content">
                                            <?php 
                                            $active2 = 0;
                                                      
                                            for($m=1; $m<=12; ++$m){ 

                                               $month_val = date('m', mktime(0, 0, 0, $m, 1));

                                               $month_name = date('M', mktime(0, 0, 0, $m, 1));
                                               $month_name_full = date('F', mktime(0, 0, 0, $m, 1));
                                               $month_now = date('m');

                                               if($class_id == 0 and $teacher_id == 0){
                                            
                                                 $online_exams = $this->db->query("SELECT class_id,section_id,subject_id,uploader_id,online_exam_id,title,status,examdate FROM online_exam WHERE MONTH(examdate) = '$month_val' and YEAR(examdate) = '$year_now' order by examdate desc");
                                                
                                                 $online_quizzes = $this->db->query("SELECT class_id,section_id,subject_id,uploader_id,online_quiz_id,title,status,quizdate FROM tbl_online_quiz WHERE MONTH(quizdate) = '$month_val' and YEAR(quizdate) = '$year_now' order by quizdate desc");
                                                
                                                 $activities = $this->db->query("SELECT class_id,section_id,subject_id,uploader_id,homework_code,title,publish_date FROM homework WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");
                                                
                                                 $forums = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,post_code,title,publish_date FROM forum WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now'  ORDER BY publish_date DESC");
                                                
                                                 $study_materials = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,file_name,publish_date FROM document WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");
                                                
                                                 $video_links = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,description,publish_date FROM tbl_video_link WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");
                                                
                                                 $live_classes = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,description,publish_date FROM tbl_live_class WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");
                                                
                                                }else if($class_id == 0 and $teacher_id > 0){

                                                   $online_exams = $this->db->query("SELECT class_id,section_id,subject_id,uploader_id,online_exam_id,title,status,examdate FROM online_exam WHERE MONTH(examdate) = '$month_val' and YEAR(examdate) = '$year_now' AND uploader_id = '$teacher_id' order by examdate desc");
                                                
                                                   $online_quizzes = $this->db->query("SELECT class_id,section_id,subject_id,uploader_id,online_quiz_id,title,status,quizdate FROM tbl_online_quiz WHERE MONTH(quizdate) = '$month_val' and YEAR(quizdate) = '$year_now' AND uploader_id = '$teacher_id' order by quizdate desc");
                                                  
                                                   $activities = $this->db->query("SELECT class_id,section_id,subject_id,uploader_id,homework_code,title,publish_date FROM homework WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND uploader_id = '$teacher_id' ORDER BY publish_date DESC");
                                                  
                                                   $forums = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,post_code,title,publish_date FROM forum WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                  
                                                   $study_materials = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,file_name,publish_date FROM document WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                  
                                                   $video_links = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,description,publish_date FROM tbl_video_link WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                  
                                                   $live_classes = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,description,publish_date FROM tbl_live_class WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND teacher_id = '$teacher_id' ORDER BY publish_date DESC");

                                                }else{
                                                
                                                 $online_exams = $this->db->query("SELECT class_id,section_id,subject_id,uploader_id,online_exam_id,title,status,examdate FROM online_exam WHERE MONTH(examdate) = '$month_val' and YEAR(examdate) = '$year_now' AND class_id = '$class_id' and uploader_id = '$teacher_id' order by examdate desc");
                                                
                                                 $online_quizzes = $this->db->query("SELECT class_id,section_id,subject_id,uploader_id,online_quiz_id,title,status,quizdate FROM tbl_online_quiz WHERE MONTH(quizdate) = '$month_val' and YEAR(quizdate) = '$year_now' AND class_id = '$class_id' and uploader_id = '$teacher_id' order by quizdate desc");
                                                
                                                 $activities = $this->db->query("SELECT class_id,section_id,subject_id,uploader_id,homework_code,title,publish_date FROM homework WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' and uploader_id = '$teacher_id' ORDER BY publish_date DESC");
                                                
                                                 $forums = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,post_code,title,publish_date FROM forum WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' and teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                
                                                 $study_materials = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,file_name,publish_date FROM document WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' and teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                
                                                 $video_links = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,description,publish_date FROM tbl_video_link WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' and teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                
                                                 $live_classes = $this->db->query("SELECT class_id,section_id,subject_id,teacher_id,description,publish_date FROM tbl_live_class WHERE MONTH(publish_date) = '$month_val' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' and teacher_id = '$teacher_id' ORDER BY publish_date DESC");
                                                
                                                }

                                            ?>
                                            <div class="tab-pane <?php if($month_now == $month_val) echo "active";?>" id="tab<?php echo $month_val;?>">
                                              
                                              <!-- ONLINE EXAMS -->
                                             <?php if($online_exams->num_rows() > 0){ ?>
                                             <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="ui-block paddingtel" >
                                                   <div class="pipeline white lined-primary" >
                                                      <div class="element-wrapper" >
                                                         <h6 class="element-header">
                                                            <?php echo get_phrase('Online Examinations');?> <span class="badge badge-primary"> <?php echo $online_exams->num_rows(); ?> </span>
                                                            <span class="float-right badge badge-primary">
                                                            <?php echo $month_name_full;?> <?php echo $year_now;?>
                                                            </span>
                                                         </h6>
                                                         <div class="table-responsive">
                                                            <table class="table table-lightborder table-striped table-hover">
                                                               <thead class="table-dark">
                                                                  <tr>
                                                                     <th style="width: 40%;"><?php echo get_phrase('Title');?></th>
                                                                     <th style="width: 30%;">Details</th>
                                                                     <th style="width: 20%;">Teacher</th>
                                                                     <th style="width: 10%;">Date</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="tbl_exams">
                                                                  <?php 
                                                                     $counter = 0;  foreach ($online_exams->result_array() as $row): $counter++;
                                                                     
                                                                     $class_name = $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name;
                                                                     
                                                                     $section_name = $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
                                                                     
                                                                     $subject_name = $this->db->get_where('subject' , array('subject_id' => $row['subject_id']))->row()->name;
                                                                     
                                                                     $teacher_name = $this->crud_model->get_name('teacher', $row['uploader_id']);
                                                                     
                                                                     ?>
                                                                  <tr>
                                                                     <td class="text_ellipsis">
                                                                        <?php echo $counter.'.) '; ?><a href="<?php echo base_url().'admin/exam_results/'.$row['online_exam_id']; ?>" target="_blank"><?php echo $row['title']; ?><br>
                                                                        <?php 
                                                                           if($row['status'] == 'published'){
                                                                              echo '<span class="badge badge-success text-left">'.strtoupper($row['status']).'</span>';
                                                                           }elseif ($row['status'] == 'pending') {
                                                                              echo '<span class="badge badge-warning text-left">'.strtoupper($row['status']).'</span>';
                                                                           }else{
                                                                               echo '<span class="badge badge-danger text-left">'. strtoupper($row['status']).'</span>';
                                                                           } ?>
                                                                        </a>
                                                                     </td>
                                                                     <td><?php echo $class_name; ?><br><?php echo $section_name; ?><br><?php echo $subject_name; ?></td>
                                                                     <td><?php echo $teacher_name; ?></td>
                                                                     <td><?php echo $row['examdate']; ?></td>
                                                                
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                               </tbody>
                                                            </table>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } ?>
                                             <!-- ONLINE EXAMS -->
                                              <!-- ONLINE QUIZS -->
                                             <?php if($online_quizzes->num_rows() > 0){ ?>
                                             <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="ui-block paddingtel" >
                                                   <div class="pipeline white lined-primary" >
                                                      <div class="element-wrapper" >
                                                         <h6 class="element-header"><?php echo get_phrase('Online Quizzes');?> <span class="badge badge-primary"> <?php echo  $online_quizzes->num_rows(); ?> </span> 
                                                            <span class="float-right badge badge-primary">
                                                            <?php echo $month_name_full;?> <?php echo $year_now;?>
                                                            </span>
                                                         </h6>
                                                         <div class="table-responsive">
                                                            <table class="table table-lightborder table-striped table-hover">
                                                               <thead class="table-dark">
                                                                  <tr>
                                                                     <th style="width: 40%;"><?php echo get_phrase('Title');?></th>
                                                                     <th style="width: 30%;">Details</th>
                                                                     <th style="width: 20%;">Teacher</th>
                                                                     <th style="width: 10%;">Date</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="results">
                                                                  <?php 
                                                                     $counter = 0;  foreach ($online_quizzes->result_array() as $row): $counter++;
                                                                     
                                                                     $class_name = $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name;
                                                                     
                                                                     $section_name = $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
                                                                     
                                                                     $subject_name = $this->db->get_where('subject' , array('subject_id' => $row['subject_id']))->row()->name;
                                                                     
                                                                     $teacher_name = $this->crud_model->get_name('teacher', $row['uploader_id']);
                                                                     
                                                                     ?>
                                                                  <tr>
                                                                     <td class="text_ellipsis"><?php echo $counter.'.) '; ?><a href="<?php echo base_url().'admin/quiz_results/'.$row['online_quiz_id']; ?>" target="_blank"><?php echo $row['title']; ?>
                                                                        <br>
                                                                        <?php 
                                                                           if($row['status'] == 'published'){
                                                                              echo '<span class="badge badge-success text-left">'.strtoupper($row['status']).'</span>';
                                                                           }elseif ($row['status'] == 'pending') {
                                                                              echo '<span class="badge badge-warning text-left">'.strtoupper($row['status']).'</span>';
                                                                           }else{
                                                                               echo '<span class="badge badge-danger text-left">'. strtoupper($row['status']).'</span>';
                                                                           } ?>
                                                                        </a>
                                                                     </td>
                                                                     <td><?php echo $class_name; ?><br><?php echo $section_name; ?><br><?php echo $subject_name; ?></td>
                                                                     <td><?php echo $teacher_name; ?></td>
                                                                     <td><?php echo $row['quizdate']; ?></td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                               </tbody>
                                                            </table>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } ?>
                                             <!-- ONLINE QUIZS -->

                                             <!-- ACTIVITIES -->
                                             <?php if($activities->num_rows() > 0){ ?>
                                             <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="ui-block paddingtel" >
                                                   <div class="pipeline white lined-primary" >
                                                      <div class="element-wrapper" >
                                                         <h6 class="element-header"><?php echo get_phrase('Activities');?> <span class="badge badge-primary"> <?php echo  $activities->num_rows(); ?> </span> 
                                                            <span class="float-right badge badge-primary">
                                                            <?php echo $month_name_full;?> <?php echo $year_now;?>
                                                            </span>
                                                         </h6>
                                                         <div class="table-responsive">
                                                            <table class="table table-lightborder table-striped table-hover">
                                                               <thead class="table-dark">
                                                                  <tr>
                                                                     <th style="width: 40%;"><?php echo get_phrase('Title');?></th>
                                                                     <th style="width: 30%;">Details</th>
                                                                     <th style="width: 20%;">Teacher</th>
                                                                     <th style="width: 10%;">Date</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="results">
                                                                  <?php 
                                                                     $counter = 0;  foreach ($activities->result_array() as $row): $counter++;
                                                                     
                                                                     $class_name = $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name;
                                                                     
                                                                     $section_name = $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
                                                                     
                                                                     $subject_name = $this->db->get_where('subject' , array('subject_id' => $row['subject_id']))->row()->name;
                                                                     
                                                                     $teacher_name = $this->crud_model->get_name('teacher', $row['uploader_id']);
                                                                     
                                                                     ?>
                                                                  <tr>
                                                                     <td class="text_ellipsis"><?php echo $counter.'.) '; ?> <a href="<?php echo base_url().'admin/homework_details/'.$row['homework_code']; ?>" target="_blank"><?php echo $row['title']; ?> </a></td>
                                                                     <td><?php echo $class_name; ?><br><?php echo $section_name; ?><br><?php echo $subject_name; ?></td>
                                                                     <td><?php echo $teacher_name; ?></td>
                                                                     <td><?php echo date('Y-m-d h:i A',strtotime($row['publish_date'])); ?></td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                               </tbody>
                                                            </table>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } ?>
                                             <!-- ACTIVITIES -->
                                              <!-- FORUM -->
                                             <?php if($forums->num_rows() > 0){ ?>
                                             <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="ui-block paddingtel" >
                                                   <div class="pipeline white lined-primary" >
                                                      <div class="element-wrapper" >
                                                         <h6 class="element-header"><?php echo get_phrase('Forums');?> <span class="badge badge-primary"> <?php echo  $forums->num_rows(); ?> </span> 
                                                            <span class="float-right badge badge-primary">
                                                            <?php echo $month_name_full;?> <?php echo $year_now;?>
                                                            </span>
                                                         </h6>
                                                         <div class="table-responsive">
                                                            <table class="table table-lightborder table-striped table-hover">
                                                               <thead class="table-dark">
                                                                  <tr>
                                                                     <th style="width: 40%;"><?php echo get_phrase('Title');?></th>
                                                                     <th style="width: 30%;" >Details</th>
                                                                     <th style="width: 20%;" >Teacher</th>
                                                                     <th style="width: 10%;" >Date</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="results">
                                                                  <?php 
                                                                     $counter = 0;  foreach ($forums->result_array() as $row): $counter++;
                                                                     
                                                                     $class_name = $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name;
                                                                     
                                                                     $section_name = $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
                                                                     
                                                                     $subject_name = $this->db->get_where('subject' , array('subject_id' => $row['subject_id']))->row()->name;
                                                                     
                                                                     $teacher_name = $this->crud_model->get_name('teacher', $row['teacher_id']);
                                                                     
                                                                     ?>
                                                                  <tr>
                                                                     <td class="text_ellipsis"><?php echo $counter.'.) '; ?><a href="<?php echo base_url().'admin/forumroom/'.$row['post_code']; ?>" target="_blank"><?php echo $row['title']; ?></a></td>
                                                                     <td><?php echo $class_name; ?><br><?php echo $section_name; ?> <br><?php echo $subject_name; ?></td>
                                                                     <td><?php echo $teacher_name; ?></td>
                                                                     <td><?php echo date('Y-m-d h:i A',strtotime($row['publish_date'])); ?></td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                               </tbody>
                                                            </table>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } ?>
                                             <!-- FORUM -->
                                             <!-- Study Materials -->
                                             <?php if($study_materials->num_rows() > 0){ ?>
                                             <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="ui-block paddingtel" >
                                                   <div class="pipeline white lined-primary" >
                                                      <div class="element-wrapper" >
                                                         <h6 class="element-header"><?php echo get_phrase('Study Materials');?> <span class="badge badge-primary"> <?php echo  $study_materials->num_rows(); ?> </span> 
                                                            <span class="float-right badge badge-primary">
                                                            <?php echo $month_name_full;?> <?php echo $year_now;?>
                                                            </span>
                                                         </h6>
                                                         <div class="table-responsive">
                                                            <table class="table table-lightborder table-striped table-hover">
                                                               <thead class="table-dark">
                                                                  <tr>
                                                                     <th style="width: 40%"><?php echo get_phrase('Title');?></th>
                                                                     <th style="width: 30%">Details</th>
                                                                     <th style="width: 20%">Teacher</th>
                                                                     <th style="width: 10%">Date</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="results">
                                                                  <?php 
                                                                     $counter = 0;  foreach ($study_materials->result_array() as $row): $counter++;
                                                                     
                                                                     $class_name = $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name;
                                                                     
                                                                     $section_name = $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
                                                                     
                                                                     $subject_name = $this->db->get_where('subject' , array('subject_id' => $row['subject_id']))->row()->name;
                                                                     
                                                                     $teacher_name = $this->crud_model->get_name('teacher', $row['teacher_id']);
                                                                     
                                                                     ?>
                                                                  <tr>
                                                                     <td class="text_ellipsis" ><?php echo $counter.'.) '; ?>
                                                                        <a download="" href="<?php echo base_url().'uploads/document/'.$row['file_name']; ?>" style="color:gray;">
                                                                        <?php echo $row['description'];?><br>
                                                                        <span class="text-sm text-primary"><?php echo $row['file_name'];?><span class="smaller">(<?php echo $row['filesize'];?>)</span></span></a>
                                                                     </td>
                                                                     <td><?php echo $class_name; ?><br><?php echo $section_name; ?><br><?php echo $subject_name; ?></td>
                                                                     <td><?php echo $teacher_name; ?></td>
                                                                     <td><?php echo date('Y-m-d h:i A',strtotime($row['publish_date'])); ?></td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                               </tbody>
                                                            </table>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } ?>
                                             <!-- Study Materials -->
                                             <!-- Video Links -->
                                             <?php if($video_links->num_rows() > 0){ ?>
                                             <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="ui-block paddingtel" >
                                                   <div class="pipeline white lined-primary" >
                                                      <div class="element-wrapper" >
                                                         <h6 class="element-header"><?php echo get_phrase('Video Links');?> <span class="badge badge-primary"> <?php echo  $video_links->num_rows(); ?> </span> 
                                                            <span class="float-right badge badge-primary">
                                                            <?php echo $month_name_full;?> <?php echo $year_now;?>
                                                            </span>
                                                         </h6>
                                                         <div class="table-responsive">
                                                            <table class="table table-lightborder table-striped table-hover">
                                                               <thead class="table-dark">
                                                                  <tr>
                                                                     <th style="width: 40%"><?php echo get_phrase('Title & links');?></th>
                                                                     <th style="width: 30%">Details</th>
                                                                     <th style="width: 20%">Teacher</th>
                                                                     <th style="width: 10%">Date</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="results">
                                                                  <?php 
                                                                     $counter = 0;  foreach ($video_links->result_array() as $row): $counter++;
                                                                     
                                                                     $class_name = $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name;
                                                                     
                                                                     $section_name = $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
                                                                     
                                                                     $subject_name = $this->db->get_where('subject' , array('subject_id' => $row['subject_id']))->row()->name;
                                                                     
                                                                     $teacher_name = $this->crud_model->get_name('teacher', $row['teacher_id']);
                                                                     
                                                                     ?>
                                                                  <tr>
                                                                     <td class="text_ellipsis" title="<?php echo $row['description']; ?>">
                                                                        <?php echo $counter.'.) '; ?> <?php echo $row['description']; ?>
                                                                     </td>
                                                                     <td><?php echo $class_name; ?><br><?php echo $section_name; ?><br><?php echo $subject_name; ?></td>
                                                                     <td><?php echo $teacher_name; ?></td>
                                                                     <td><?php echo date('Y-m-d h:i A',strtotime($row['publish_date'])); ?></td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                               </tbody>
                                                            </table>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } ?>
                                             <!-- Video Links -->
                                             <!-- LIVE CLASSES -->
                                             <?php if($live_classes->num_rows() > 0){ ?>
                                             <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="ui-block paddingtel" >
                                                   <div class="pipeline white lined-primary" >
                                                      <div class="element-wrapper" >
                                                         <h6 class="element-header"><?php echo get_phrase('Live Classes');?> <span class="badge badge-primary"> <?php echo  $live_classes->num_rows(); ?> </span> 
                                                            <span class="float-right badge badge-primary">
                                                            <?php echo $month_name_full;?> <?php echo $year_now;?>
                                                            </span>
                                                         </h6>
                                                         <div class="table-responsive">
                                                            <table class="table table-lightborder table-striped table-hover">
                                                               <thead class="table-dark">
                                                                  <tr>
                                                                     <th style="width: 40%"><?php echo get_phrase('Title & links');?></th>
                                                                     <th style="width: 10%;">Host</th>
                                                                     <th style="width: 20%;">Details</th>
                                                                     <th style="width: 20%;">Teacher</th>
                                                                     <th style="width: 10%;">Date</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="results">
                                                                  <?php 
                                                                     $counter = 0;  foreach ($live_classes->result_array() as $row): $counter++;
                                                                     
                                                                     $class_name = $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name;
                                                                     
                                                                     $section_name = $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
                                                                     
                                                                     $subject_name = $this->db->get_where('subject' , array('subject_id' => $row['subject_id']))->row()->name;
                                                                     
                                                                     $teacher_name = $this->crud_model->get_name('teacher', $row['teacher_id']);
                                                                     
                                                                     ?>
                                                                  <tr>
                                                                     <td class="text_ellipsis" title="<?php echo $row['description']; ?>">
                                                                        <?php echo $counter.'.) '; ?> <?php echo $row['description']; ?>
                                                                     </td>
                                                                     <td>
                                                                        <?php 
                                                                           if($row['host_id'] == 1){
                                                                             echo 'ZOOM';
                                                                           }else{
                                                                             echo 'JITSI MEET';
                                                                           }
                                                                           
                                                                           ?>
                                                                     </td>
                                                                     <td><?php echo $class_name; ?><br> <?php echo $section_name; ?><br> <?php echo $subject_name; ?></td>
                                                                     <td><?php echo $teacher_name; ?></td>
                                                                     <td><?php echo date('Y-m-d h:i A',strtotime($row['publish_date'])); ?></td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                               </tbody>
                                                            </table>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } ?>
                                             <!-- LIVE CLASSES -->

                                            </div>

                                          <?php } ?>

                                          </div>

                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <a class="back-to-top" href="javascript:void(0);">
         <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
         </a>

         <div class="display-type"></div>

      </div>

   </div>

</div>
<script type="text/javascript">
  
  function load_examinations(argument) {
    // body...
  }

</script>