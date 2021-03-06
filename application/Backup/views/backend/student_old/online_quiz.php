<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php $info = base64_decode($data);
    $ex = explode('-', $info);
?>
<?php $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
foreach($sub as $row):
?>
<div class="content-w">
  <div class="conty">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
    <div class="cursos cta-with-media" style="background: #<?php echo $row['color'];?>;">
      <div class="cta-content">
        <div class="user-avatar">
          <img alt="" src="<?php echo base_url();?>uploads/subject_icon/<?php echo $row['icon'];?>" style="width:60px;">
        </div>
        <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo get_phrase('online_quizzes');?></small></h3>
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
            <a class="navs-links active" href="<?php echo base_url();?>student/online_quiz/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_quiz');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('homework');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>student/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
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
          <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
            <div id="newsfeed-items-grid">                
                <div class="element-wrapper">
                    <div class="element-box-tp">
                    <h6 class="element-header"><?php echo get_phrase('online_quizzes');?></h6>
                  <div class="table-responsive">
                    <table class="table table-padded">
                        <thead>
                          <tr>
                            <th><?php echo get_phrase('title');?></th>
                            <th><?php echo get_phrase('date');?></th>
                            <th><?php echo get_phrase('options');?></th>
                          </tr>
                        </thead>
                          <tbody>
                          <?php
                              foreach ($quiz as $row):
                    	        $current_time = time();
                    	        $quiz_start_time = strtotime(date('Y-m-d', $row['quiz_date']).' '.$row['time_start']);
                    	        $quiz_end_time = strtotime(date('Y-m-d', $row['quiz_date']).' '.$row['time_end']);
            	            ?>
                          <tr>
                            <td><?php echo $row['title'];?></td>
                            <td><?php echo '<b>'.get_phrase('date').':</b> '.date('M d, Y', $row['quiz_date']).'<br>'.'<b>'.get_phrase('hour').':</b> '.$row['time_start'].' - '.$row['time_end'];?></td>
                            <td class="bolder">
                              <?php if ($this->crud_model->check_availability_for_student_quiz($row['online_quiz_id']) != "submitted"): ?>

              								<?php if ($current_time >= $quiz_start_time && $current_time <= $quiz_end_time): ?>
              									<a href="<?php echo base_url();?>student/quizroom/<?php echo $row['code'];?>/" class="btn btn-success btn-rounded"><?php echo get_phrase('take_quiz');?></a>
              								<?php else: ?>
              									<div class="btn btn-info btn-rounded">
              										<?php echo get_phrase('You_can_take_the_quiz_in_the_established_time');?>
              									</div>
              								<?php endif; ?>
              							<?php else: ?>
        	    					    <?php if($current_time > $quiz_end_time): ?>
                                            <a href="<?php echo base_url();?>student/online_quiz_result/<?php echo $row['online_quiz_id'];?>/" class="btn btn-success btn-rounded"><?php echo get_phrase('view_results');?></a>
                                        <?php else: ?>
                                            <a href="javascript:void(0);" class="btn btn-warning btn-roundend"><?php echo get_phrase('waiting_results');?></a>
                                        <?php endif; ?>
            						    <?php endif; ?>
                            </td>
                          </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
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