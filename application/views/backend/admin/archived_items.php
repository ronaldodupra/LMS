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
        <ul class="navs navs-tabs upper" >
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/subject_dashboard/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo get_phrase('dashboard');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/online_exams/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_exams');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/online_quiz/<?php echo $data;?>/"><i class="picons-thin-icon-thin-0678_pen_writting_fontain"></i><span><?php echo get_phrase('online_quiz');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('activity');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/video_link/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i><span><?php echo get_phrase('video_links');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/live_class/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo get_phrase('live_classroom');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/upload_marks/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span>Grades</span></a>
                    </li>
                </ul>
      </div>
    </div>
    <div class="content-i">
      <div class="content-box">
        <div class="back">
          <a href="<?php echo base_url();?>admin/subject_dashboard/<?php echo $data;?>"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>
        </div>
        <div class="row">
          <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
            <div id="newsfeed-items-grid">     
              <?php 
                $db = $this->db->query("SELECT homework_id, wall_type,publish_date FROM homework WHERE class_id = $ex[0] AND subject_id = $ex[2] UNION SELECT document_id,wall_type,publish_date FROM document WHERE class_id = $ex[0] AND subject_id = $ex[2] UNION SELECT online_exam_id,wall_type,publish_date FROM online_exam WHERE class_id = $ex[0] UNION SELECT online_quiz_id,wall_type,publish_date FROM tbl_online_quiz WHERE class_id = $ex[0] AND subject_id = $ex[2] AND subject_id = $ex[2] UNION SELECT post_id,wall_type,publish_date FROM forum WHERE class_id = $ex[0] AND subject_id = $ex[2] ORDER BY publish_date DESC LIMIT 10");
                if($db->num_rows() > 0):
                  foreach($db->result_array() as $wall):
              ?>           
              <?php 

              $login_id = $this->session->userdata('login_user_id');
              
              $homework_id = $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_id;

              $activity_type_id = $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->activity_type;
              
              $activity_type = $this->db->query("SELECT activity_type from tbl_act_type where id = '$activity_type_id'")->row()->activity_type;

              $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$homework_id' and archive_type='homework' and user_type='admin'")->row()->archive_id;

              if($archive_id != '' && $wall['wall_type'] == 'homework'):?>

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
                        <li><a href="<?php echo base_url();?>admin/unarchive/<?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_id;?>/<?php echo $data;?>/homework/admin"><?php echo get_phrase('unarchive');?></a></li>
                        <li><a href="<?php echo base_url();?>admin/homework_edit/<?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_code;?>/"><?php echo get_phrase('edit');?></a></li>
                        <li><a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url(); ?>admin/homework/delete/<?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_code;?>/<?php echo $data;?>/"><?php echo get_phrase('delete');?></a></li>
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
                      <a href="<?php echo base_url();?>admin/homeworkroom/<?php echo $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_code;?>/"><button class="btn btn-rounded btn-posts"><i class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i> View <?php echo $activity_type?></button></a>
                    </div>
                  </div>
                  <div class="control-block-button post-control-button">
                    <a href="javascript:void(0);" class="btn btn-control featured-post" style="background-color: #99bf2d; color: #fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo $activity_type?>">
                      <i class="picons-thin-icon-thin-0004_pencil_ruler_drawing"></i>
                    </a>
                  </div>                
                </article>
              </div>
              <?php endif;?>

              <?php 

              $login_id = $this->session->userdata('login_user_id');
              $exam_id = $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->online_exam_id;

              $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$exam_id' and archive_type='exam' and user_type='admin'")->row()->archive_id;

              if($archive_id != '' && $wall['wall_type'] == 'exam'):?>

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
                        <li><a href="<?php echo base_url();?>admin/unarchive/<?php echo $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->online_exam_id;?>/<?php echo $data;?>/exam/admin"><?php echo get_phrase('unarchive');?></a></li>
                        <li><a href="<?php echo base_url();?>admin/exam_edit/<?php echo $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->online_exam_id;?>/"><?php echo get_phrase('edit');?></a></li>
                        <li><a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>admin/manage_exams/delete/<?php echo $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->online_exam_id;?>/<?php echo $data;?>"><?php echo get_phrase('delete');?></a></li>
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
                        <span><?php echo get_phrase('duration');?>:</span><i class="picons-thin-icon-thin-0026_time_watch_clock"></i><?php $minutes = number_format($this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->duration/60,0); echo $minutes;?> <?php echo get_phrase('minutes');?>.
                      </div>
                      <a href="<?php echo base_url();?>admin/examroom/<?php echo $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->online_exam_id;?>/"><button class="btn btn-rounded btn-posts verde"><i class="picons-thin-icon-thin-0014_notebook_paper_todo"></i> <?php echo get_phrase('view_exam');?></button></a>
                    </div>
                  </div>              
                  <div class="control-block-button post-control-button">                
                    <a href="javascript:void(0);" class="btn btn-control" style="background-color: #a01a7a; color: #fff;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('online_exams');?>">
                      <i class="picons-thin-icon-thin-0207_list_checkbox_todo_done"></i>
                    </a>                
                  </div>                
                </article>
              </div>
              <?php endif;?>
              
              <!-- Quiz Dashboard -->
              <?php 

              $login_id = $this->session->userdata('login_user_id');
              $quiz_id = $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->online_quiz_id;

              $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$quiz_id' and archive_type='quiz' and user_type='admin'")->row()->archive_id;

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
                        <li><a href="<?php echo base_url();?>admin/insert_archive/<?php echo $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->online_quiz_id;?>/<?php echo $data;?>/quiz/admin"><?php echo get_phrase('archive');?></a></li>
                        <li><a href="<?php echo base_url();?>admin/quiz_edit/<?php echo $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->online_quiz_id;?>/"><?php echo get_phrase('edit');?></a></li>
                        <li><a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>admin/manage_quiz/delete/<?php echo $this->db->get_where('tbl_online_quiz', array('online_quiz_id' => $wall['homework_id']))->row()->online_quiz_id;?>/<?php echo $data;?>"><?php echo get_phrase('delete');?></a></li>

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
                      <a href="<?php echo base_url();?>admin/online_quiz/<?php echo $data;?>/"><button class="btn btn-rounded btn-success"><i class="picons-thin-icon-thin-0014_notebook_paper_todo"></i> <?php echo get_phrase('go_to_quiz');?></button></a><br>
                     
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

              <?php 

              $login_id = $this->session->userdata('login_user_id');
              $document_id = $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->document_id;

              $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$document_id' and archive_type='material' and user_type='admin'")->row()->archive_id;

              if($archive_id != '' && $wall['wall_type'] == 'material'):?>

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
                        <li><a href="<?php echo base_url();?>admin/unarchive/<?php echo $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->document_id;?>/<?php echo $data;?>/material/admin"><?php echo get_phrase('unarchive');?></a></li>
                        <li><a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url();?>admin/study_material/delete/<?php echo $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->document_id;?>/<?php echo $data;?>"><?php echo get_phrase('delete');?></a></li>
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
                                <a href="<?php echo base_url().'uploads/document/'.$this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->file_name; ?>"><i class="picons-thin-icon-thin-0111_folder_files_documents" style="font-size:16px; color:#fff;"></i> <span><?php echo $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->file_name;?></span><span class="smaller">(<?php echo $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->filesize;?>)</span></a>
                              </td>             
                              <td class="text-center bolder">
                                <a href="<?php echo base_url().'uploads/document/'.$this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->file_name; ?>"> <span><i class="picons-thin-icon-thin-0121_download_file"></i></span> </a>
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
              <?php endif;?>
              <?php 

              $login_id = $this->session->userdata('login_user_id');
              $forum_id = $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_id;

              $archive_id = $this->db->query("SELECT archive_id FROM tbl_archive where person_id = '$login_id' and archive_id = '$forum_id' and archive_type='forum' and user_type='admin'")->row()->archive_id;

              if($archive_id != '' && $wall['wall_type'] == 'forum'):?>

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
                        <li><a href="<?php echo base_url();?>admin/unarchive/<?php echo $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_id;?>/<?php echo $data;?>/forum/admin"><?php echo get_phrase('unarchive');?></a></li>
                        <li><a href="<?php echo base_url();?>admin/edit_forum/<?php echo $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_code;?>/"><?php echo get_phrase('edit');?></a></li>
                        <li><a onClick="return confirm('<?php echo get_phrase('confirm_delete');?>')" href="<?php echo base_url(); ?>admin/forum/delete/<?php echo $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_code;?>/<?php echo $data;?>"><?php echo get_phrase('delete');?></a></li>
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
                      <a href="<?php echo base_url();?>admin/forumroom/<?php echo $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_code;?>/"><button class="btn btn-rounded btn-posts"><i class="picons-thin-icon-thin-0014_notebook_paper_todo"></i> <?php echo get_phrase('view_forum');?></button></a>
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


              <?php 

              $userid = $this->session->userdata('login_user_id');
              $sql = $this->db->query("SELECT * from tbl_archive where person_id = '$userid '");
              if($sql->num_rows() == 0): ?>

                   <div class="ui-block">
                    <article class="hentry post thumb-full-width">                                
                      <div class="edu-posts cta-with-media">
                        <br><br>
                          <center><h3><?php echo get_phrase('no_archived_items');?></h3></center><br>
                           <center><img src="<?php echo base_url();?>uploads/icons/norecent.svg" width="55%"></center>
                       <br><br>
                      </div>              
                    </article>
                  </div>
         

              <?php endif;?>

            </div>
          </main>

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
                          <a href="javascript:void(0);" class="logo"><img src="<?php echo $this->crud_model->get_image_url('teacher', $tch);?>" style="width:90px;"></a>
                          <h5><?php echo $this->crud_model->get_name('teacher', $tch)?><br> <small><?php echo $this->db->get_where('teacher', array('teacher_id' => $tch))->row()->email;?></small></h5>
                          <h6><a class="badge badge-primary" href="javascript:void(0);"> <?php echo get_phrase('teacher');?></a></h6>
                          <br>
                        </div>
                      </div>
                    </div>

                    <a class="btn btn-block btn-info mb-3" href="<?php echo base_url();?>admin/archived_items/<?php echo $data;?>/">Archived items</a>

                    <div class="ui-block paddingtel">
                      <div class="ui-block-title">
                        <h6 class="title"><?php echo get_phrase('students');?></h6>
                      </div>
                      <ul class="widget w-friend-pages-added notification-list friend-requests">
                        <?php $students   =   $this->db->get_where('enroll' , array('class_id' => $ex[0], 'section_id' => $ex[1] , 'year' => $running_year))->result_array();
                          foreach($students as $row2):?>
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