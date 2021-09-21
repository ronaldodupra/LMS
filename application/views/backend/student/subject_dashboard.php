<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php $info = base64_decode($data);
    $ex = explode('-', $info);
?>
<?php $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
foreach($sub as $row):

?>
<style type="text/css">
  
  .blue_pallete{

    background: #1b55e2;
    color: #fff;

  }

</style>
<div class="content-w">
  <div class="conty">
    <p id="text" style="display: none;"></p>
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
    <div class="cursos cta-with-media" style="background: #<?php echo $row['color'];?>;">
      <div class="cta-content">
        <div class="user-avatar">
          <img alt="" src="<?php echo base_url();?>uploads/subject_icon/<?php echo $row['icon'];?>" style="width:60px;">
        </div>
        <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo get_phrase('dashboard');?></small></h3>
        <small style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"</small>
      </div>
    </div> 
    <div class="os-tabs-w menu-shad">
      <div class="os-tabs-controls">
        <ul class="navs navs-tabs upper">
          <li class="navs-item">
            <a class="navs-links active" href="<?php echo base_url();?>student/subject_dashboard/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo get_phrase('dashboard');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/online_exams/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_exams');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/online_quiz/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0678_pen_writting_fontain"></i><span><?php echo get_phrase('online_quiz');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('activity');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/video_link/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i><span><?php echo get_phrase('video_links');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/live_class/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo get_phrase('live_classroom');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/subject_marks/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('marks');?></span></a>
          </li>
        </ul>
      </div>
    </div>
    <div class="content-i">
      <div class="content-box">
        <div class="row">
          <main class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
            <div id="newsfeed-items-grid">     
              <?php 
                $db = $this->db->query("SELECT homework_id, wall_type,publish_date FROM homework WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] 
                  UNION SELECT document_id,wall_type,publish_date FROM document WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] 
                  UNION SELECT online_exam_id,wall_type,publish_date FROM online_exam WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] 
                  UNION SELECT online_quiz_id,wall_type,publish_date FROM tbl_online_quiz WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] UNION SELECT post_id,wall_type,publish_date FROM forum 
                  WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] 

                  UNION SELECT link_id,wall_type,publish_date FROM tbl_video_link WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] 

                  UNION SELECT live_id,wall_type,publish_date FROM tbl_live_class WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] 

                  ORDER BY publish_date DESC LIMIT 10");
                if($db->num_rows() > 0):
                  foreach($db->result_array() as $wall):
              ?>      
              <!-- Homework Dashboard -->     
              <?php 

              $login_id = $this->session->userdata('login_user_id');
              $homework_id = $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_id;

              $activity_type_id = $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->activity_type;
              
              $activity_type = $this->db->query("SELECT activity_type from tbl_act_type where id = '$activity_type_id'")->row()->activity_type;
              
              $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$homework_id' and archive_type='homework' and user_type='student'")->row()->archive_id;

              if($archive_id == '' && $wall['wall_type'] == 'homework' && $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->status == 1):?>
              <div class="ui-block">
                <article class="hentry post thumb-full-width">                
                  <div class="post__author author vcard inline-items">
                    <img src="<?php echo $this->crud_model->get_image_url($this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->uploader_type, $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->uploader_id);?>">                
                    <div class="author-date">
                      <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name($this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->uploader_type, $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->uploader_id);?></a>
                      <div class="post__date">
                        <time class="published">
                          <?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->upload_date;?>
                        </time>
                      </div>
                    </div>
                    <div class="more">
                      <i class="icon-options"></i>                                
                      <ul class="more-dropdown">
                        <li><a href="<?php echo base_url();?>admin/insert_archive/<?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_id;?>/<?php echo $data;?>/homework/student"><?php echo get_phrase('archive');?></a></li>

                      </ul>
                    </div>                
                  </div>                
                  <div class="edu-posts cta-with-media verde">
                    <div class="cta-content">
                      <div class="highlight-header morado"><?php echo $row['name'];?></div>            
                      <div class="grado">
                        <?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                      </div>
                      <h3 class="cta-header"><?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->title;?></h3>           
                      <div class="descripcion">
                        <?php echo strip_tags($this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->description);?>
                      </div>
                      <?php if($this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->file_name != ""):?>
                      <div class="table-responsive">
                        <table class="table table-down">
                          <tbody>
                            <tr>
                              <td class="text-left cell-with-media" >
                                <a href="<?php echo base_url().'uploads/homework/' . $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->file_name;?>"><i class="picons-thin-icon-thin-0111_folder_files_documents" style="font-size:16px; color:#fff;"></i> <span><?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->file_name;?></span><span class="smaller">(<?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->filesize;?>)</span></a>
                              </td>             
                              <td class="text-center bolder">
                                <a href="<?php echo base_url().'uploads/homework/' . $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->file_name;?>"> <span><i class="picons-thin-icon-thin-0121_download_file"></i></span> </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <?php endif;?>
                      <div class="deadtime">
                        <span><?php echo get_phrase('date');?>:</span><i class="picons-thin-icon-thin-0027_stopwatch_timer_running_time"></i><?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->date_end;?> @ <?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->time_end;?>
                      </div>
                      <a href="<?php echo base_url();?>student/homeworkroom/<?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_code;?>/"><button class="btn btn-rounded btn-posts"><i class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i> View <?php echo $activity_type?></button></a>
                    </div>
                  </div>
                  <div class="control-block-button post-control-button">
                    <a href="javascript:void(0);" class="btn btn-control featured-post" style="background-color: #99bf2d; color: #fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo $activity_type;?>">
                      <i class="picons-thin-icon-thin-0004_pencil_ruler_drawing"></i>
                    </a>
                  </div>                
                </article>
              </div>
              <?php endif;?>
              <!-- Homework Dashboard -->
              <!-- Examination Dashboard -->
              <?php 

              $login_id = $this->session->userdata('login_user_id');
              $exam_id = $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->online_exam_id;

              $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$exam_id' and archive_type='exam' and user_type='student'")->row()->archive_id;

              if($archive_id == '' && $wall['wall_type'] == 'exam' && $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->status != 'pending'):?>

                <div class="ui-block">
                <article class="hentry post thumb-full-width">                
                  <div class="post__author author vcard inline-items">
                    <img src="<?php echo $this->crud_model->get_image_url($this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->uploader_type, $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->uploader_id);?>">                
                    <div class="author-date">
                      <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name($this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->uploader_type, $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->uploader_id);?></a>
                      <div class="post__date">
                        <time class="published">
                          <?php echo $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->upload_date;?>
                        </time>

                      </div>
                    </div> 
                    <div class="more">
                      <i class="icon-options"></i>                                
                      <ul class="more-dropdown">
                        <li><a href="<?php echo base_url();?>admin/insert_archive/<?php echo $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->online_exam_id;?>/<?php echo $data;?>/exam/student"><?php echo get_phrase('archive');?></a></li>

                      </ul>
                    </div>               
                  </div>                
                  <div class="edu-posts cta-with-media morado">
                    <div class="cta-content">
                      <div class="highlight-header celeste">
                        <?php echo $row['name'];?>
                      </div>            
                      <div class="grado">
                        <?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                      </div>
                      <h3 class="cta-header"><?php echo $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->title;?></h3>           
                      <div class="descripcion">
                        <?php echo strip_tags($this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->instruction);?>
                      </div>
                      <div class="deadtime">
                        <span><?php echo get_phrase('date');?>:</span><i class="picons-thin-icon-thin-0027_stopwatch_timer_running_time"></i><?php echo date('M d, Y', $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->exam_date);?>
                      </div>
                      <div class="deadtime">
                        <span><?php echo get_phrase('hour');?>:</span><i class="picons-thin-icon-thin-0027_stopwatch_timer_running_time"></i><?php echo $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->time_start. " - ".$this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->time_end;?>
                      </div>
                      <div class="deadtime">
                        <span><?php echo get_phrase('duration');?>:</span><i class="picons-thin-icon-thin-0026_time_watch_clock"></i><?php $minutes = number_format($this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->duration/60,0); echo $minutes;?> mins.
                      </div>
                      <a href="<?php echo base_url();?>student/online_exams/<?php echo $data;?>/"><button class="btn btn-rounded btn-posts verde"><i class="picons-thin-icon-thin-0014_notebook_paper_todo"></i> <?php echo get_phrase('go_to_exams');?></button></a><br>
                     
                    </div>
    
                   </div>              
                  <div class="control-block-button post-control-button">                

                    <a href="javascript:void(0);" class="btn btn-control" style="background-color: #a01a7a; color: #fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('online_exams');?>">
                      <i class="picons-thin-icon-thin-0207_list_checkbox_todo_done"></i></a>   
                    
                  </div>                
                </article>
              </div>
              <?php endif;?>
              <!-- Examination Dashboard -->

              <!-- Quiz Dashboard -->
              <?php 

              $login_id = $this->session->userdata('login_user_id');
              $quiz_id = $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->online_quiz_id;

              $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$quiz_id' and archive_type='quiz' and user_type='student'")->row()->archive_id;

              if($archive_id == '' && $wall['wall_type'] == 'quiz'):?>

                <div class="ui-block">
                <article class="hentry post thumb-full-width">                
                  <div class="post__author author vcard inline-items">
                    <img src="<?php echo $this->crud_model->get_image_url($this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->uploader_type, $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->uploader_id);?>">                
                    <div class="author-date">
                      <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name($this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->uploader_type, $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->uploader_id);?></a>
                      <div class="post__date">
                        <time class="published">
                          <?php echo $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->upload_date;?>
                        </time>

                      </div>
                    </div> 
                    <div class="more">
                      <i class="icon-options"></i>                                
                      <ul class="more-dropdown">
                        <li><a href="<?php echo base_url();?>admin/insert_archive/<?php echo $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->online_quiz_id;?>/<?php echo $data;?>/quiz/student"><?php echo get_phrase('archive');?></a></li>

                      </ul>
                    </div>               
                  </div>                
                  <div class="edu-posts cta-with-media blue_pallete">
                    <div class="cta-content">
                      <div class="highlight-header celeste">
                        <?php echo $row['name'];?>
                      </div>            
                      <div class="grado">
                        <?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                      </div>
                      <h3 class="cta-header"><?php echo $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->title;?></h3>           
                      <div class="descripcion">
                        <?php echo strip_tags($this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->instruction);?>
                      </div>
                      <div class="deadtime">
                        <span><?php echo get_phrase('date');?>:</span><i class="picons-thin-icon-thin-0027_stopwatch_timer_running_time"></i><?php echo date('M d, Y', $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->quiz_date);?>
                      </div>
                      <div class="deadtime">
                        <span><?php echo get_phrase('hour');?>:</span><i class="picons-thin-icon-thin-0027_stopwatch_timer_running_time"></i><?php echo $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->time_start. " - ".$this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->time_end;?>
                      </div>
                      <div class="deadtime">
                        <span><?php echo get_phrase('duration');?>:</span><i class="picons-thin-icon-thin-0026_time_watch_clock"></i><?php $minutes = number_format($this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->duration/60,0); echo $minutes;?> mins.
                      </div>
                      <a href="<?php echo base_url();?>student/online_quiz/<?php echo $data;?>/"><button class="btn btn-rounded btn-success"><i class="picons-thin-icon-thin-0014_notebook_paper_todo"></i> <?php echo get_phrase('go_to_quiz');?></button></a><br>
                     
                    </div>
    
                   </div>              
                  <div class="control-block-button post-control-button">                

                    <a href="javascript:void(0);" class="btn btn-control" style="background-color: #1b55e2; color: #fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('online_quiz');?>">
                      <i class="picons-thin-icon-thin-0207_list_checkbox_todo_done"></i></a>   
                    
                  </div>                
                </article>
              </div>
              <?php endif;?>
              <!-- Exit Quiz Dashboard -->
              <!-- Study Material -->
              <?php 
                
                $login_id = $this->session->userdata('login_user_id');
                $document_id = $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->document_id;

                $subject_id = $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->subject_id;

                $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$document_id' and archive_type='material'and user_type='student'")->row()->archive_id;

              if($archive_id == '' && $wall['wall_type'] == 'material'):?>
                  <div class="ui-block">                    
                <article class="hentry post thumb-full-width">
                  <div class="post__author author vcard inline-items">
                    <img src="<?php echo $this->crud_model->get_image_url($this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->type, $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->teacher_id);?>">                
                    <div class="author-date">
                      <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name($this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->type, $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->teacher_id);?></a>
                      <div class="post__date">
                        <time class="published">
                          <?php echo $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->upload_date;?>
                        </time>
                      </div>
                    </div>
                    <div class="more">
                      <i class="icon-options"></i>                                
                      <ul class="more-dropdown">
                        <li><a href="<?php echo base_url();?>admin/insert_archive/<?php echo $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->document_id;?>/<?php echo $data;?>/material/student"><?php echo get_phrase('archive');?></a></li>
                      </ul>
                    </div>                 
                  </div>                
                  <div class="edu-posts cta-with-media azul">
                    <div class="cta-content">
                      <div class="highlight-header morado">
                        <?php echo $row['name'];?>
                      </div>            
                      <div class="grado">
                        <?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                      </div>
                      <h3 class="cta-header"><?php echo get_phrase('study_material');?></h3>   
                      <div class="descripcion">
                        <?php echo strip_tags($this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->description);?>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-down">
                          <tbody>
                            <tr>
                              <td class="text-left cell-with-media" >
                                <a download="" onclick="download_file2('<?php echo $subject_id; ?>');" href="<?php echo base_url().'uploads/document/'.$this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->file_name; ?>"><i class="picons-thin-icon-thin-0111_folder_files_documents" style="font-size:16px; color:#fff;"></i> <span><?php echo $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->file_name;?></span><span class="smaller">(<?php echo $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->filesize;?>)</span></a>
                              </td>             
                              <td class="text-center bolder">
                                <a download="" onclick="download_file2('<?php echo $subject_id; ?>');" href="<?php echo base_url().'uploads/document/'.$this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->file_name; ?>"> <span><i class="picons-thin-icon-thin-0121_download_file"></i></span> </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>  
                    </div>
                  </div>
                  <div class="control-block-button post-control-button">                
                    <a href="javascript:void(0);" class="btn btn-control" style="background-color: #00579c; color: #fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('study_material');?>">
                      <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </a>                
                  </div>                
                </article>
              </div>

              <!-- Exit Study Material -->
              <!-- Forum Dashbboard -->
              <?php endif;?>
              <?php 
              $login_id = $this->session->userdata('login_user_id');
              $forum_id = $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_id;

              $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$forum_id' and archive_type='forum' and user_type='student'")->row()->archive_id;

              if($archive_id == '' && $wall['wall_type'] == 'forum' && $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_status == 1):?>
              <div class="ui-block">
                <article class="hentry post thumb-full-width">                
                  <div class="post__author author vcard inline-items">
                    <img src="<?php echo $this->crud_model->get_image_url($this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->type, $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->teacher_id);?>">                
                    <div class="author-date">
                      <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name($this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->type, $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->teacher_id);?></a>
                      <div class="post__date">
                        <time class="published">
                          <?php echo $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->upload_date;?>
                        </time>
                      </div>
                    </div>
                    <div class="more">
                      <i class="icon-options"></i>                                
                      <ul class="more-dropdown">
                        <li><a href="<?php echo base_url();?>admin/insert_archive/<?php echo $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_id;?>/<?php echo $data;?>/forum/student"><?php echo get_phrase('archive');?></a></li>
                      </ul>
                    </div>                  
                  </div>                
                  <div class="edu-posts cta-with-media yellow">
                    <div class="cta-content">
                      <div class="highlight-header yellow">
                        <?php echo $row['name'];?>
                      </div>            
                      <div class="grado">
                         <?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                      </div>
                      <h3 class="cta-header"><?php echo $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->title;?></h3>           
                      <div class="descripcion">
                        <?php echo strip_tags($this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->description);?>
                      </div>
                      <a href="<?php echo base_url();?>student/forumroom/<?php echo $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_code;?>/"><button class="btn btn-rounded btn-posts"><i class="picons-thin-icon-thin-0014_notebook_paper_todo"></i> <?php echo get_phrase('view_forum');?></button></a>
                    </div>
    
                  </div>              
                  <div class="control-block-button post-control-button">                
                    <a href="javascript:void(0);" class="btn btn-control" style="background-color: #f4af08; color: #fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('forum');?>">
                      <i class="picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i>
                    </a>                
                  </div>                
                </article>
              </div>
                <?php endif;?>

               <!--EXIT Forum Dashbboard -->

               <!-- Video Link -->  
                     <?php 

                      $login_id = $this->session->userdata('login_user_id');
                     
                      $link_id = $this->db->get_where('tbl_video_link', array('link_id' => $wall['homework_id']))->row()->link_id;

                      $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$link_id' and archive_type='video link' and user_type='student'")->row()->archive_id;
                        
                     if($archive_id == '' && $wall['wall_type'] == 'video link'):?>
                     <div class="ui-block">
                        <article class="hentry post thumb-full-width">
                           <div class="post__author author vcard inline-items">
                              <img src="<?php echo $this->crud_model->get_image_url($this->db->get_where('tbl_video_link', array('link_id' => $wall['homework_id']))->row()->type, $this->db->get_where('tbl_video_link', array('link_id' => $wall['homework_id']))->row()->teacher_id);?>">                
                              <div class="author-date">
                                 <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name($this->db->get_where('tbl_video_link', array('link_id' => $wall['homework_id']))->row()->type, $this->db->get_where('tbl_video_link', array('link_id' => $wall['homework_id']))->row()->teacher_id);?></a>
                                 <div class="post__date">
                                    <time class="published">
                                    
                                    <?php 

                                    $publish_date = $this->db->get_where('tbl_video_link', array('link_id' => $wall['homework_id']))->row()->publish_date;

                                    echo date('d M Y h:i A', strtotime($publish_date));

                                    ?>
                                    </time>
                                 </div>
                              </div>
                              <div class="more">
                                 <i class="icon-options"></i>                                
                                 <ul class="more-dropdown">
                                    <li><a href="<?php echo base_url();?>admin/insert_archive/<?php echo $this->db->get_where('tbl_video_link', array('link_id' => $wall['homework_id']))->row()->link_id;?>/<?php echo $data;?>/video_link/student"><?php echo get_phrase('archive');?></a></li>
                                 </ul>
                              </div>
                           </div>
                           <div class="edu-posts cta-with-media celeste">
                              <div class="cta-content">
                                 <div class="highlight-header naranja">
                                    <?php echo $row['name'];?>
                                 </div>
                                 <div class="grado">
                                    <?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                                 </div>
                                 <h3 class="cta-header"><?php echo $this->db->get_where('tbl_video_link', array('link_id' => $wall['homework_id']))->row()->description;?></h3>
                                 <div class="descripcion">
                                    
                                 </div>

                                 <?php  

                                 $link_id = $wall['homework_id'];

                                 $video_host_id = $this->db->query("SELECT video_host_id FROM tbl_video_link where link_id = '$link_id'")->row()->video_host_id;

                                 $host_name = $this->db->query("SELECT hostname FROM tbl_hostnames where id = '$video_host_id'")->row()->hostname;

                                 $link_name = $this->db->query("SELECT link_name FROM tbl_video_link where link_id = '$link_id'")->row()->link_name;

                                 $subject_id = $this->db->query("SELECT subject_id FROM tbl_video_link where link_id = '$link_id'")->row()->subject_id;
                                 
                                 if(strtolower($host_name) == 'other link'){ ?>

                                  <a  href="<?php echo $link_name;?>" onclick="view_video_link2('<?php echo $subject_id; ?>')" target="_blank"><button class="btn btn-rounded btn-posts"><i class="fa fa-eye"></i> <?php  echo get_phrase('view_video_link');?></button></a>
                                 
                                 <?php }else{ ?>

                                  <a onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_video/<?php echo $link_id;?>'); view_video_link2('<?php echo $subject_id; ?>');"  href="javascript:void(0);"><button class="btn btn-rounded btn-posts"><i class="fa fa-eye"></i> <?php echo get_phrase('view_video_link');?></button></a>

                                 <?php } ?>
                                 
                              </div>
                           </div>
                           <div class="control-block-button post-control-button">                
                              <a href="javascript:void(0);" class="btn btn-control" style="background-color: #53c1ef; color: #fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Video Link');?>">
                              <i class="picons-thin-icon-thin-0273_video_multimedia_movie"></i>
                              </a>                
                           </div>
                        </article>
                     </div>
                     <?php endif;?>
                     <!-- Video Link -->  
                     <!-- Live Class -->  
                     <?php 

                      $login_id = $this->session->userdata('login_user_id');
                     
                      $live_id = $this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->live_id;

                      $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$live_id' and archive_type='live class' and user_type='student'")->row()->archive_id;
                        
                     if($archive_id == '' && $wall['wall_type'] == 'live class'):?>
                     <div class="ui-block">
                        <article class="hentry post thumb-full-width">
                           <div class="post__author author vcard inline-items">
                              <img src="<?php echo $this->crud_model->get_image_url($this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->type, $this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->teacher_id);?>">                
                              <div class="author-date">
                                 <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name($this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->type, $this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->teacher_id);?></a>
                                 <div class="post__date">
                                    <time class="published">
                                    <?php 
                                    $publish_date = $this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->publish_date;

                                    echo date('d M Y h:i A',strtotime($publish_date));
                                    ?>
                                    </time>
                                 </div>
                              </div>
                              <div class="more">
                                 <i class="icon-options"></i>                                
                                 <ul class="more-dropdown">
                                    <li><a href="<?php echo base_url();?>admin/insert_archive/<?php echo $this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->live_id;?>/<?php echo $data;?>/video_link/student"><?php echo get_phrase('archive');?></a></li>
                                 </ul>
                              </div>
                           </div>
                           <div class="edu-posts cta-with-media naranja">
                              <div class="cta-content">
                                 <div class="highlight-header naranja">
                                    <?php echo $row['name'];?>
                                 </div>
                                 <div class="grado">
                                    <?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                                 </div>
                                 <h3 class="cta-header"><?php echo $this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->title;?></h3>
                                 <div class="descripcion">
                                    <?php echo strip_tags($this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->description);?><br>
                                    Schedule: <?php 

                                        $start_date = $this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->start_date;
                                         $start_time = strip_tags($this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->start_time);

                                       echo date('d M Y',strtotime($start_date)) .' '. date('g:i A', strtotime($start_time));

                                    ?>
                                 </div>

                                 <?php  

                                 $live_id = $wall['homework_id'];

                                 $host_name = $this->db->query("SELECT hostname FROM tbl_hostnames where id = '$live_id'")->row()->hostname;

                                 $host_id = $this->db->query("SELECT host_id FROM tbl_live_class where live_id = '$live_id'")->row()->host_id;

                                 $title = $this->db->query("SELECT title FROM tbl_live_class where live_id = '$live_id'")->row()->title;

                                 $timestamp = $this->db->query("SELECT * FROM tbl_live_class where live_id = '$live_id'")->row()->timestamp;
                                
                                 $room_name = $title.'-'.sha1($timestamp);

                                $teacher_id = $this->db->query("SELECT * FROM tbl_live_class where live_id = '$live_id'")->row()->teacher_id;

                                $fname = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->first_name;

                                $lname = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->last_name;

                                $sname = $fname . ' ' . $lname;

                                $zoom_link=$this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->zoom_link;

                   
                                 $date_now = date('m/d/Y');
                                 $time_now = date("H:i"); 

                                 $date_sched = $start_date;
                                 $time_sched = date('H:i', strtotime($start_time) - 300);
                                
                                 $subject_id = $this->db->get_where('tbl_live_class', array('live_id' => $wall['homework_id']))->row()->subject_id;

                                 //echo $time_now.' >= '.$time_sched;

                                 if($date_now == $date_sched AND $time_now >= $time_sched){
                                  
                                    if($host_id == 1){ ?>

                                    <!-- Zoom App -->

                                    <a title="Join Live Classroom" onclick="join_live_class('<?php echo $subject_id; ?>')" href="<?php echo $zoom_link ?>" target="_blank" class="btn btn-info btn-rounded text-center"> <i class="picons-thin-icon-thin-0191_window_application_cursor"></i> <?php echo get_phrase('Join Live Classroom');?></a>

                                    <?php }else if($host_id == 2){ ?>

                                    <!-- Zitsi Meet -->

                                    <a title="Join Live Classroom" onclick="join_live_class('<?php echo $subject_id; ?>')" href="<?php echo base_url();?>jitsi_meet/client.php?data=<?php echo base64_encode($room_name.'-'.$sname);?>" target="_blank" class="btn btn-info laptop_desktop btn-rounded text-center"> <i class="picons-thin-icon-thin-0324_computer_screen"></i> <?php echo get_phrase('Join Live Classroom');?></a>

                                    <a title="Join Live Classroom" onclick="join_live_class('<?php echo $subject_id; ?>')" href="https://meet.jit.si/<?php echo $room_name?>" target="_blank" class="btn btn-info mobile btn-rounded text-center"> <i class="picons-thin-icon-thin-0191_window_application_cur sor"></i> <?php echo get_phrase('Join Live Classroom');?></a>

                                    <?php }

                                 }else{ ?>
                                  
                                  <a href="javascript:void(0)" class="btn btn-warning text-center"><span class="fa fa-info fa-lg"></span> You can join this live class in the established time.</a>

                                 <?php } ?>
                                      
                              </div>
                           </div>
                           <div class="control-block-button post-control-button ">                
                              <a href="javascript:void(0);" class="btn btn-control" style="background-color: #ea791c; color: #fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Live Classroom');?>">
                              <i class="picons-thin-icon-thin-0591_presentation_video_play_beamer"></i>
                              </a>                
                           </div>
                        </article>
                     </div>
                     <?php endif;?>
                     <!-- Live Class -->  

              <?php endforeach;?>
              <?php elseif($db->num_rows() == 0):?>
                   <div class="ui-block">
                <article class="hentry post thumb-full-width">                                
                  <div class="edu-posts cta-with-media">
                    <br><br>
                      <center><h3><?php echo get_phrase('no_recent_activity');?></h3></center><br>
                       <center><img src="<?php echo base_url();?>uploads/icons/norecent.svg" width="55%"></center>
                   <br><br>
                  </div>              
                </article>
              </div>
              <?php endif;?>
            </div>
          </main>

          <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
            <div class="crumina-sticky-sidebar">
                <div class="sidebar__inner">
                    <div class="ui-block">
                      <div class="ui-block-content">
                        <div class="widget w-about">
                          <a href="javascript:void(0);" class="logo">
                            <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>">
                          </a>
                          <ul class="socials">
                            <li><a target="_blank" href="<?php echo $this->db->get_where('settings', array('type' => 'facebook'))->row()->description;?>"><i class="fab fa-facebook-square" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="<?php echo $this->db->get_where('settings', array('type' => 'twitter'))->row()->description;?>"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="<?php echo $this->db->get_where('settings', array('type' => 'youtube'))->row()->description;?>"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="<?php echo $this->db->get_where('settings', array('type' => 'instagram'))->row()->description;?>"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                          </ul>
                        </div>                    
                      </div>
                    </div>
                    <div class="ui-block">
                      <div class="ui-block-title">
                        <h6 class="title">Subject Activity</h6>                      
                      </div>
                       <?php 
                          $this->db->order_by('id', desc);
                          $this->db->group_by('type');
                          $notifications = $this->db->get_where('notification', array('class_id' => $ex[0], 'subject_id' => $ex[2], 'year' => $running_year));
                          if($notifications->num_rows() > 0):
                      ?>
                      <ul class="widget w-activity-feed notification-list">
                        <?php foreach($notifications->result_array() as $notify):?>
                        <li>
                          <div class="author-thumb">
                            <img src="<?php echo base_url();?>uploads/notify.svg">
                          </div>
                          <div class="notification-event">
                            <a href="javascript:void(0);" class="notification-friend"><?php echo $notify['notify'];?>.</a>
                            <span class="notification-date"><time class="entry-date updated"><?php echo $notify['date'];?> <?php echo get_phrase('at');?> <?php echo $notify['time'];?></time></span>
                          </div>
                        </li>
                        <?php endforeach;?>
                      </ul>
                      <?php else:?>
                        <br><br><br>
                        <center><h6><?php echo get_phrase('no_subject_activity');?></h6></center>
                        <br><br><br>
                      <?php endif;?>
                    </div>
                    <div class="ui-block">
                      <div class="ui-block-title">
                        <h6 class="title"><?php echo get_phrase('latest_news');?></h6>
                      </div>
                      <div class="ui-block-content">          
                        <ul class="widget w-personal-info item-block">
                          <?php 
                            $this->db->limit(5);
                            $this->db->order_by('news_id', 'desc');
                            $news = $this->db->get('news')->result_array();
                            foreach($news as $row5):
                          ?>
                            <li><span class="text"><?php echo $row5['description'];?></span></li>
                            <hr>
                          <?php endforeach;?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">
                <div class="crumina-sticky-sidebar">
                  <div class="sidebar__inner">
                    <div class="ui-block paddingtel lined-danger">
                      <div class="ui-block-title">
                        <h6 class="title"><?php echo get_phrase('teacher_of_the_subject');?></h6>
                      </div>
                      <div class="ui-block-content">
                        <div class="widget w-about" style="text-align:center">
                          <?php $tch= $this->db->get_where('subject', array('subject_id' => $ex[2]))->row()->teacher_id;?>
                          <a href="javascript:void(0);" class="logo"><img src="<?php echo $this->crud_model->get_image_url('teacher', $tch);?>" alt="Educaby" style="width:90px;"></a>
                          <h5><?php echo $this->crud_model->get_name('teacher', $tch)?><br> <small><?php echo $this->db->get_where('teacher', array('teacher_id' => $tch))->row()->email;?></small></h5>
                          <h6><a class="badge badge-primary" href="javascript:void(0);"> <?php echo get_phrase('teacher');?></a></h6>
                          <br>
                        </div>
                      </div>
                    </div>
                    <a class="btn btn-block btn-info mb-3" href="<?php echo base_url();?>student/archived_items/<?php echo $data;?>/">Archived items</a>
                    <div class="ui-block paddingtel">
                      <div class="ui-block-title">
                        <h6 class="title"><?php echo get_phrase('students');?></h6>
                      </div>
                      <ul class="widget w-friend-pages-added notification-list friend-requests">
                        <?php

                          $students = $this->db->query("SELECT * FROM enroll a LEFT JOIN student b ON a.`student_id`=b.`student_id` WHERE a.`class_id`='$ex[0]' AND a.`section_id`='$ex[1]' AND a.`year`='$running_year' ORDER BY b.`last_name` ASC")->result_array();

                          // $students = $this->db->get_where('enroll' , array('class_id' => $ex[0], 'section_id' => $ex[1] , 'year' => $running_year))->result_array();
                          
                          foreach($students as $row2):
                        ?>
                            <li class="inline-items">
                              <div class="author-thumb">
                                <img src="<?php echo $this->crud_model->get_image_url('student', $row2['student_id']);?>" width="35px">
                              </div>
                              <div class="notification-event">
                                <a href="javascript:void(0);" class="h6 notification-friend"><?php echo $this->crud_model->get_name('student', $row2['student_id'])?></a>
                                <span class="chat-message-item"><?php echo get_phrase('roll');?>: <?php echo $this->db->get_where('enroll' , array('student_id' => $row2['student_id']))->row()->roll; ?></span>
                              </div>
                            </li>
                          <?php endforeach;?>
                        </ul>
                      </div> 
                    </div>
                  </div>
                </div> 
              </div>
            </div>
            <a class="back-to-top" href="javascript:void(0);">
              <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
            </a>
          </div>
        </div>
      </div>
      <?php endforeach;?>
      <script type="text/javascript">
        $(document).ready(function(e){

          var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var element = document.getElementById('text');
            if (isMobile) {
                element.innerHTML = "You are using Mobile";

                $('.laptop_desktop').css('display','none');

            } else {
              element.innerHTML = "You are using Desktop";
              $('.mobile').css('display','none');
            }

        });

        function join_live_class(subject_id){

          var subject_id = subject_id;

          $.ajax({
             url:"<?php echo base_url();?>student/join_live_class",
             type:'POST',
             data:{subject_id:subject_id},
             success:function(result)
             {

             }});

       }

       function view_video_link2(subject_id){

        var subject_id = subject_id;

        $.ajax({
           url:"<?php echo base_url();?>student/play_video_link",
           type:'POST',
           data:{subject_id:subject_id},
           success:function(result)
           {

           }});

     }


      function download_file2(subject_id){

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