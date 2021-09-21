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
                            <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff; padding:10px">
                          </div>
                          <div class="author-content">
                            <a href="javascript:void(0);" class="h3 author-name">
                             Live Conference | Live Stream</a>
                            <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="header-spacer"></div>
                    <div class="container-fluid" id="results">
                      <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                          <div class="element-wrapper">
                            <div class="element-box-tp">
                              <h5 class="element-header"></h5><br>
                              <p id="text" style="display: none;"></p>
                              <div class="table-responsive" style="margin-top: -2%;">
                                <table class="table table-padded">
                                  <thead>
                                    <tr>
                                      <th><?php echo get_phrase('title');?></th>
                                      <th><?php echo get_phrase('schedule');?></th>
                                      <th><?php echo get_phrase('host');?></th>
                                      <th><?php echo get_phrase('description');?></th>
                                      <th><?php echo get_phrase('options');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="results">
                                    <?php
                                      $parent_id = $this->session->userdata('login_user_id');
                                      $fname = $this->db->get_where('parent', array('parent_id'=>$parent_id))->row()->first_name;
                                      $lname = $this->db->get_where('parent', array('parent_id'=>$parent_id))->row()->last_name;
                                      $sname = $fname . ' ' . $lname;
                                    ?>
                                    <?php
                                      $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
                                      $con_live_info = $this->db->query("SELECT * FROM tbl_live_conference ORDER BY conference_id DESC");
                                      
                                      if ($con_live_info->num_rows() > 0):
                                      
                                        foreach($con_live_info->result_array() as $rows):
                                          $room_name = $rows['title'].'-'.sha1($row['timestamp']);
                                          $admin_id = $rows['admin_id'];

                                          $data = $rows['member'];
                                          $member = explode(", ", $data);

                                          for ($i=0; $i < count($member); $i++):
                                    ?>
                                    <?php if($rows['live_type'] == 1):?>
                                    <tr>
                                      <?php
                                        if($member[$i] == 'all' || $member[$i] == 'parent'):
                                      ?>
                                      <td><?php echo $rows['title']; ?></td>
                                      <td><?php echo '<b>'.get_phrase('date').':</b> '.$rows['start_date'].'<br>'.'<b>'.get_phrase('time').':</b> '.date('g:i A', strtotime($rows['start_time']));?></td>
                                      <td><?php if ($rows['host_id'] == 1) { echo 'Zoom'; } else { echo 'Jitsi Meet'; } ?></td>
                                      <td><?php echo $rows['description']; ?></td>
                                      <td class="text-center bolder">
                                        <?php if ($rows['host_id'] == 2): ?>
                                          <a title="Join Live Classroom" href="<?php echo base_url();?>jitsi_meet/client.php?data=<?php echo base64_encode($room_name.'-'.$sname);?>" target="_blank" class="btn btn-info btn-sm laptop_desktop"> <i class="picons-thin-icon-thin-0324_computer_screen"></i> <?php echo get_phrase('Join');?></a>
                                          <a title="Join Live Classroom" href="https://meet.jit.si/<?php echo $room_name?>" target="_blank" class="btn btn-info btn-sm mobile"> <i class="picons-thin-icon-thin-0191_window_application_cursor"></i> <?php echo get_phrase('Join');?></a>
                                        <?php else:
                                          $zoom_link=$this->db->get_where('admin', array('admin_id'=>$admin_id))->row()->zoom_link; 
                                        ?>
                                          <a title="Join Live Classroom" href="<?php echo $zoom_link ?>" target="_blank" class="btn btn-info btn-sm"> <i class="picons-thin-icon-thin-0191_window_application_cursor"></i><?php echo get_phrase('Join');?></a>
                                        <?php endif ?>
                                      </td>
                                    <?php endif; ?>
                                    </tr>
                                    <?php else:?>
                                    <tr>
                                      <td><?php echo $rows['title']; ?></td>
                                      <td><?php echo '<b>'.get_phrase('date').':</b> '.$rows['start_date'].'<br>'.'<b>'.get_phrase('time').':</b> '.date('g:i A', strtotime($rows['start_time']));?></td>
                                      <td><?php if ($rows['provider_id'] == 1) { echo 'Youtube Live Stream'; } else {echo 'Facebook Live Stream';} ?></td>
                                      <td><?php echo $rows['description']; ?></td>
                                      <td class="text-center bolder">
                                        <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_live_stream/<?php echo $rows['conference_id'];?>');" class="btn btn-info btn-sm laptop_desktop"> <i class="picons-thin-icon-thin-0324_computer_screen"></i> <?php echo get_phrase('watch');?></a>
                                      </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php endfor; endforeach;
                                      else:?>
                                    <tr>
                                      <td colspan="7"> No data Found...</td>
                                    </tr>
                                    <?php endif;?>
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
          </div>
        </div>
      </div>
      <div class="display-type"></div>
    </div>
  </div>
</div>

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
</script>

