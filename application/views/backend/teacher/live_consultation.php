<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
  <div class="conty">
    <div class="os-tabs-w menu-shad">
      <div class="os-tabs-controls">
        <ul class="navs navs-tabs upper">
          <li class="navs-item">
            <a class="navs-links" href="<?php echo base_url();?>teacher/student_report/"><i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i><span><?php echo get_phrase('reports');?></span></a>
          </li>
          <li class="navs-item">
            <a class="navs-links active" href="<?php echo base_url();?>teacher/live_consultation/"><i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i><span><?php echo get_phrase('live_consultation');?></span></a>
          </li>
        </ul>
      </div>
    </div>
    <div class="content-box">
      <div class="element-wrapper">
        <h6 class="element-header">
          <div style="margin-top:auto;text-align:right;"></div>
        </h6>
        <div class="element-box-tp">
          <div class="table-responsive">
            <table class="table table-padded" id="student_report">
              <thead>
                <tr>
                  <th><?php echo get_phrase('title');?></th>
                  <th><?php echo get_phrase('schedule');?></th>
                  <th><?php echo get_phrase('host');?></th>
                  <th><?php echo get_phrase('description');?></th>
                  <th><?php echo get_phrase('options');?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $teacher_id = $this->session->userdata('login_user_id');
                  $fname = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->first_name;
                  $lname = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->last_name;
                  $sname = $fname . ' ' . $lname;
                  ?>
                <?php
                  $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
                  $con_live_info = $this->db->query("SELECT * FROM tbl_live_consultation WHERE member_type = '2' ORDER BY consultation_id DESC");
                  
                  if ($con_live_info->num_rows() > 0):
                     foreach($con_live_info->result_array() as $rows):
                       $room_name = $rows['title'].'-'.sha1($row['timestamp']);
                  
                       $data = $rows['members'];
                       $member = explode(", ", $data);
                  
                       for ($i=0; $i < count($member); $i++):
                  ?>
                <tr>
                  <?php if($member[$i] == $teacher_id): ?>
                  <td><?php echo $rows['title']; ?></td>
                  <td><?php echo '<b>'.get_phrase('date').':</b> '.$rows['start_date'].'<br>'.'<b>'.get_phrase('time').':</b> '.date('g:i A', strtotime($rows['start_time']));?></td>
                  <td><?php if ($rows['host_id'] == 1) { echo 'Zoom'; } else { echo 'Jitsi Meet'; } ?></td>
                  <td><?php echo $rows['description']; ?></td>
                  <td class="text-center bolder">
                    <?php if ($rows['host_id'] == 2): ?>
                      <a title="Join Live Classroom" href="<?php echo base_url();?>jitsi_meet/client.php?data=<?php echo base64_encode($room_name.'-'.$sname);?>" target="_blank" class="btn btn-info btn-sm laptop_desktop"> <i class="picons-thin-icon-thin-0324_computer_screen"></i> <?php echo get_phrase('Join');?></a>

                      <a title="Join Live Classroom" href="https://meet.jit.si/<?php echo $room_name?>" target="_blank" class="btn btn-info btn-sm mobile"> <i class="picons-thin-icon-thin-0191_window_application_cursor"></i> <?php echo get_phrase('Join');?></a>
                    <?php else:
                      $zoom_link=$this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->zoom_link; 
                    ?>
                      <a title="Join Live Classroom" href="<?php echo $zoom_link ?>" target="_blank" class="btn btn-info btn-sm"> <i class="picons-thin-icon-thin-0191_window_application_cursor"></i> <?php echo get_phrase('Join');?></a>
                    <?php endif; ?>
                  </td>
                  <?php endif; endfor; endforeach;?>
                </tr>
                <?php else: ?>
                <tr>
                  <td colspan="5"> No data Found...</td>
                </tr>
                <?php endif;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="display-type"></div>

<script type="text/javascript">
  $(document).ready(function(e){
  
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    var element = document.getElementById('text');
    if (isMobile) {
        //element.innerHTML = "You are using Mobile";
        $('.laptop_desktop').css('display','none');
  
    } else {
      //element.innerHTML = "You are using Desktop";
      $('.mobile').css('display','none');
    }
  })
</script>