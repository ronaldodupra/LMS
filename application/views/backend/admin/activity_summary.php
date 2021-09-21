<?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;

$year_now = date('Y');

?>
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
                                             <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating" style="background-color: #fff;">
                                                   <label class="control-label"><?php echo get_phrase('search');?></label>
                                                   <input class="form-control" id="filter" type="text" required="">
                                                </div>
                                             </div>
                                             <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating is-select">
                                                   <label class="control-label"><?php echo get_phrase('filter_by_class');?></label>
                                                   <div class="select">
                                                      <select onchange="submit();" name="class_id" id="slct">
                                                         <option value=""><?php echo get_phrase('All');?></option>

                                                         <?php $cl = $this->db->get('class')->result_array();
                                                            foreach($cl as $row):
                                                            ?>
                                                         <option value="<?php echo $row['class_id'];?>" <?php if($n == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                                         <?php endforeach;?>
                                                      </select>
                                                   </div>
                                                </div>
                                             </div>

                                          </div>
                                          <?php echo form_close();?>
                                        
                                       </div>

                                       <div class="col-sm-12">
                                          <div class="row">
                                             <?php
                                                for ($i = 1; $i <= 12; $i++):
                                                
                                                if ($i == 1){ $m = get_phrase('january'); $ma = '1';}
                                                if ($i == 2) {$m = get_phrase('february'); $ma = '2';}
                                                if ($i == 3) {$m = get_phrase('march'); $ma = '3';}
                                                if ($i == 4) {$m = get_phrase('april'); $ma = '4';}
                                                if ($i == 5) {$m = get_phrase('may'); $ma = '5';}
                                                if ($i == 6) {$m = get_phrase('june'); $ma = '6';}
                                                if ($i == 7) {$m = get_phrase('july'); $ma = '7';}
                                                if ($i == 8) {$m = get_phrase('august'); $ma = '8';}
                                                if ($i == 9) {$m = get_phrase('september'); $ma = '9';}
                                                if ($i == 10) {$m = get_phrase('october'); $ma = '10';}
                                                if ($i == 11) {$m = get_phrase('november'); $ma = '11';}
                                                if ($i == 12) {$m = get_phrase('december');  $ma = '12';}

                                                // QUERIES


                                                if($class_id == 0){

                                                  $online_exams = $this->db->query("SELECT * FROM online_exam WHERE MONTH(examdate) = '$ma' and YEAR(examdate) = '$year_now' order by examdate desc");

                                                  $online_quizzes = $this->db->query("SELECT * FROM tbl_online_quiz WHERE MONTH(quizdate) = '$ma' and YEAR(quizdate) = '$year_now' order by quizdate asc");

                                                  $activities = $this->db->query("SELECT * FROM homework WHERE MONTH(publish_date) = '$ma' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");

                                                  $forums = $this->db->query("SELECT * FROM forum WHERE MONTH(publish_date) = '$ma' and YEAR(publish_date) = '$year_now'  ORDER BY publish_date DESC");

                                                  $study_materials = $this->db->query("SELECT * FROM document WHERE MONTH(publish_date) = '$ma' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");

                                                  $video_links = $this->db->query("SELECT * FROM tbl_video_link WHERE MONTH(publish_date) = '$ma' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");

                                                  $live_classes = $this->db->query("SELECT * FROM tbl_live_class WHERE MONTH(publish_date) = '$ma' and YEAR(publish_date) = '$year_now' ORDER BY publish_date DESC");

                                                }else{

                                                  $online_exams = $this->db->query("SELECT * FROM online_exam WHERE MONTH(examdate) = '$ma' and YEAR(examdate) = '$year_now' AND class_id = '$class_id' order by examdate desc");

                                                  $online_quizzes = $this->db->query("SELECT * FROM tbl_online_quiz WHERE MONTH(quizdate) = '$ma' and YEAR(quizdate) = '$year_now' AND class_id = '$class_id' order by quizdate asc");

                                                  $activities = $this->db->query("SELECT * FROM homework WHERE MONTH(publish_date) = '$ma' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' ORDER BY publish_date DESC");

                                                  $forums = $this->db->query("SELECT * FROM forum WHERE MONTH(publish_date) = '$ma' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' ORDER BY publish_date DESC");

                                                  $study_materials = $this->db->query("SELECT * FROM document WHERE MONTH(publish_date) = '$ma' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' ORDER BY publish_date DESC");

                                                  $video_links = $this->db->query("SELECT * FROM tbl_video_link WHERE MONTH(publish_date) = '$ma' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' ORDER BY publish_date DESC");

                                                  $live_classes = $this->db->query("SELECT * FROM tbl_live_class WHERE MONTH(publish_date) = '$ma' and YEAR(publish_date) = '$year_now' AND class_id = '$class_id' ORDER BY publish_date DESC");

                                                }
                                                
                                                $total_activities = $online_exams->num_rows() + $activities->num_rows() + $forums->num_rows() + $study_materials->num_rows() + $video_links->num_rows() + $live_classes->num_rows();

                                                ?>

                                             <?php  
                                             
                                             if($online_exams->num_rows() > 0 || $activities->num_rows() > 0 || $forums->num_rows() > 0 || $study_materials->num_rows() > 0 || $video_links->num_rows() > 0 || $live_classes->num_rows() > 0){ ?>

                                              <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="ui-block" style="background:#1b55e2;">
                                                   <div class="ui-block-title">
                                                      <h6 class="title text-white"><?php echo $m;?> <?php echo $year_now;?></h6>
                                                      <span class="badge badge-success text-white float-right">Total Items:  <?php echo number_format($total_activities) ?> </span>
                                                   </div>
                                                </div>
                                             </div>

                                             <?php } ?>
                                             
                                              
                                            <!-- ONLINE EXAMS -->
                                            <?php if($online_exams->num_rows() > 0){ ?>
                                              <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="ui-block paddingtel" >
                                                   <div class="pipeline white lined-primary" >
                                                      <div class="element-wrapper" >
                                                         <h6 class="element-header">
                                                          <?php echo get_phrase('Online Examinations');?> <span class="badge badge-primary"> <?php echo $online_exams->num_rows(); ?> </span>
                                                          <span class="float-right badge badge-primary">
                                                            <?php echo $m;?> <?php echo $year_now;?>
                                                          </span>
                                                         </h6> 
                                                           <div class="table-responsive">
                                                              <table class="table table-lightborder table-striped table-hover">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                       <th>#</th>
                                                                       <th><?php echo get_phrase('Title');?></th>
                                                                       <th><?php echo get_phrase('Class');?></th>
                                                                       <th><?php echo get_phrase('Section');?></th>
                                                                       <th><?php echo get_phrase('Subject');?></th>
                                                                       <th><?php echo get_phrase('Teacher');?></th>
                                                                       <th><?php echo get_phrase('Date');?></th>
                                                                    </tr>
                                                                 </thead>
                                                                 <tbody id="results">
                                                                    <?php 
                                                                    $counter = 0;  foreach ($online_exams->result_array() as $row): $counter++;

                                                                    $class_name = $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name;

                                                                    $section_name = $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;

                                                                    $subject_name = $this->db->get_where('subject' , array('subject_id' => $row['subject_id']))->row()->name;

                                                                    $teacher_name = $this->crud_model->get_name('teacher', $row['uploader_id']);

                                                                    ?>
                                                                    <tr>
                                                                      <td><?php echo $counter.'.) '; ?></td>
                                                                      <td>
                                                                        <a href="<?php echo base_url().'admin/exam_results/'.$row['online_exam_id']; ?>" target="_blank"><?php echo $row['title']; ?><br>
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
                                                                      <td><?php echo $class_name; ?></td>
                                                                      <td><?php echo $section_name; ?></td>
                                                                      <td><?php echo $subject_name; ?></td>
                                                                      <td><?php echo $teacher_name; ?></td>
                                                                      <td><?php echo $row['examdate']; ?></td>
                                                                      </a>
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
                                                            <?php echo $m;?> <?php echo $year_now;?>
                                                          </span>
                                                         </h6>      
                                                           <div class="table-responsive">
                                                              <table class="table table-lightborder table-striped table-hover">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                       <th>#</th>
                                                                       <th><?php echo get_phrase('Title');?></th>
                                                                       <th><?php echo get_phrase('Class');?></th>
                                                                       <th><?php echo get_phrase('Section');?></th>
                                                                       <th><?php echo get_phrase('Subject');?></th>
                                                                       <th><?php echo get_phrase('Teacher');?></th>
                                                                       <th><?php echo get_phrase('Date');?></th>
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
                                                                      <td><?php echo $counter.'.) '; ?></td>
                                                                      <td><a href="<?php echo base_url().'admin/quiz_results/'.$row['online_quiz_id']; ?>" target="_blank"><?php echo $row['title']; ?>
                                                                        <br>
                                                                        <?php 

                                                                         if($row['status'] == 'published'){
                                                                            echo '<span class="badge badge-success text-left">'.strtoupper($row['status']).'</span>';
                                                                         }elseif ($row['status'] == 'pending') {
                                                                            echo '<span class="badge badge-warning text-left">'.strtoupper($row['status']).'</span>';
                                                                         }else{
                                                                             echo '<span class="badge badge-danger text-left">'. strtoupper($row['status']).'</span>';
                                                                         } ?>
                                                                      </a></td>
                                                                      <td><?php echo $class_name; ?></td>
                                                                      <td><?php echo $section_name; ?></td>
                                                                      <td><?php echo $subject_name; ?></td>
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
                                                            <?php echo $m;?> <?php echo $year_now;?>
                                                          </span>
                                                         </h6>      
                                                           <div class="table-responsive">
                                                              <table class="table table-lightborder table-striped table-hover">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                       <th>#</th>
                                                                       <th><?php echo get_phrase('Title');?></th>
                                                                       <th><?php echo get_phrase('Class');?></th>
                                                                       <th><?php echo get_phrase('Section');?></th>
                                                                       <th><?php echo get_phrase('Subject');?></th>
                                                                       <th><?php echo get_phrase('Teacher');?></th>
                                                                       <th><?php echo get_phrase('Date');?></th>
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
                                                                      <td><?php echo $counter.'.) '; ?></td>
                                                                      <td> <a href="<?php echo base_url().'teacher/homework_details/'.$row['homework_code']; ?>" target="_blank"><?php echo $row['title']; ?> </a></td>
                                                                      <td><?php echo $class_name; ?></td>
                                                                      <td><?php echo $section_name; ?></td>
                                                                      <td><?php echo $subject_name; ?></td>
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
                                                            <?php echo $m;?> <?php echo $year_now;?>
                                                          </span>
                                                         </h6>      
                                                           <div class="table-responsive">
                                                              <table class="table table-lightborder table-striped table-hover">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                       <th>#</th>
                                                                       <th><?php echo get_phrase('Title');?></th>
                                                                       <th><?php echo get_phrase('Class');?></th>
                                                                       <th><?php echo get_phrase('Section');?></th>
                                                                       <th><?php echo get_phrase('Subject');?></th>
                                                                       <th><?php echo get_phrase('Teacher');?></th>
                                                                       <th><?php echo get_phrase('Date');?></th>
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
                                                                      <td><?php echo $counter.'.) '; ?></td>
                                                                      <td><a href="<?php echo base_url().'admin/forumroom/'.$row['post_code']; ?>" target="_blank"><?php echo $row['title']; ?></a></td>
                                                                      <td><?php echo $class_name; ?></td>
                                                                      <td><?php echo $section_name; ?></td>
                                                                      <td><?php echo $subject_name; ?></td>
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
                                                            <?php echo $m;?> <?php echo $year_now;?>
                                                          </span>
                                                         </h6>      
                                                           <div class="table-responsive">
                                                              <table class="table table-lightborder table-striped table-hover">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                       <th>#</th>
                                                                       <th style="width: 40%"><?php echo get_phrase('Title');?></th>
                                                                       <th>Class</th>
                                                                       <th><?php echo get_phrase('Section - Subject');?></th>
                                                                       <th><?php echo get_phrase('Teacher');?></th>
                                                                       <th><?php echo get_phrase('Date');?></th>
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
                                                                      <td><?php echo $counter.'.) '; ?></td>
                                                                      <td>
                                                                        <a download="" href="<?php echo base_url().'uploads/document/'.$row['file_name']; ?>" style="color:gray;">
                                                                        <?php echo $row['description'];?><br>
                                                                        <span class="text-sm text-primary"><?php echo $row['file_name'];?><span class="smaller">(<?php echo $row['filesize'];?>)</span></span></a>
                                                                      </td>
                                                                      <td><?php echo $class_name; ?></td>
                                                                      <td><?php echo $section_name; ?> - <?php echo $subject_name; ?></td>
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
                                                            <?php echo $m;?> <?php echo $year_now;?>
                                                          </span>
                                                         </h6>      
                                                           <div class="table-responsive">
                                                              <table class="table table-lightborder table-striped table-hover">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                       <th>#</th>
                                                                       <th style="width: 45%"><?php echo get_phrase('Title & links');?></th>
                                                                       <th>Class</th>
                                                                       <th><?php echo get_phrase('Section - Subject');?></th>
                                                                       <th><?php echo get_phrase('Teacher');?></th>
                                                                       <th><?php echo get_phrase('Date');?></th>
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
                                                                      <td><?php echo $counter.'.) '; ?></td>
                                                                      <td>
                                                                        

                                                                        <?php echo $row['description']; ?>
                                                                        <br>

                                                                         <?php
                                                                           $host_id = $row['video_host_id'];
                                                                           $host_name = $this->db->query("SELECT hostname FROM tbl_hostnames where id = '$host_id'")->row()->hostname;
                                                                           
                                                                           if(strtolower($host_name) == 'other link'){ ?>
                                                                            <a href="<?php echo $row['link_name'];?>" target="_blank" id="video_id"><?php echo $row['link_name']; ?></a>
                                                                           <?php }else{ ?>

                                                                            <a onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_video/<?php echo $row['link_id'];?>');" style="color:gray;" href="javascript:void(0);"><?php echo $row['link_name']; ?></a>

                                                                        <?php } ?>

                                                                      </td>
                                                                      <td><?php echo $class_name; ?></td>
                                                                      <td><?php echo $section_name; ?> - <?php echo $subject_name; ?></td>
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
                                                            <?php echo $m;?> <?php echo $year_now;?>
                                                          </span>
                                                         </h6>      
                                                           <div class="table-responsive">
                                                              <table class="table table-lightborder table-striped table-hover">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                       <th>#</th>
                                                                       <th style="width: 40%"><?php echo get_phrase('Title & links');?></th>
                                                                       <th>Host</th>
                                                                       <th>Class</th>
                                                                       <th><?php echo get_phrase('Section - Subject');?></th>
                                                                       <th><?php echo get_phrase('Teacher');?></th>
                                                                       <th><?php echo get_phrase('Date');?></th>
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
                                                                      <td><?php echo $counter.'.) '; ?></td>
                                                                      <td>
                                                                        <?php echo $row['description']; ?>
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
                                                                       <td><?php echo $class_name; ?></td>
                                                                      <td><?php echo $section_name; ?> - <?php echo $subject_name; ?></td>
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
                                             <?php endfor; ?>
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