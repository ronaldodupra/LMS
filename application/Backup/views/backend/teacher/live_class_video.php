<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

$teacher_id = $this->session->userdata('login_user_id');

$fname = $this->db->query("SELECT first_name FROM teacher where teacher_id = '$teacher_id'")->row()->first_name; 
$lname = $this->db->query("SELECT last_name FROM teacher where teacher_id = '$teacher_id'")->row()->last_name; 

$sname = $fname . ' ' . $lname;
?>

<?php 
  $ins_vid = $this->db->get_where('tbl_live_class' , array('live_id' => $live_id))->result_array();
  foreach($ins_vid as $row):
    $room_name = sha1($row['title'].'-'.$row['timestamp']);
?>
<style type="text/css">
  #video_div {
    border-width:5px;  
    border-style:dashed;
    border-color: #428bca;
  }
</style>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="cursos cta-with-media" style="background: #<?php echo $rows['color'];?>;">
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                  <div id="newsfeed-items-grid">
                     <div class="element-wrapper">
                        <div class="element-box-tp">
                           <div class="row element-header">
                              <div class="col-md-8">
                                 <h4><i class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i> <?php echo get_phrase('live_classroom');?><br></h4>
                              </div>
                              <div class="col-md-4">
                                 <p>
                                    Description: 
                                    <span class="badge badge-success"><?php echo strtoupper($row['description'])?></span>
                                    <!-- Meeting ID:  <span class="badge badge-success"><?php echo $row['meeting_id']?></span> -->
                                 </p>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <?php //echo $room_name.' '.$sname; ?>
                            <!-- <div class="embed-responsive embed-responsive-16by9" id="video_div">
                              <iframe class="embed-responsive-item" id="" src="<?php //echo base_url();?>CDN/index.php?mid=<?php //echo $row['meeting_id']?>&pwd=<?php //echo $row['password']?>&sname=<?php //echo $sname?>" allowfullscreen>
                              </iframe>
                            </div> -->

                            <div class="embed-responsive embed-responsive-16by9" id="video_div">
                              <iframe class="embed-responsive-item" id="" src="<?php echo base_url();?>jitsi_meet/index.php?room=<?php echo $room_name; ?>&sname=<?php echo $sname?>" allowfullscreen>
                              </iframe>
                            </div>
                          </div>

                          <div class="col-md-12 mt-4">
                            <center>
                              <span class="badge badge-success">CLICK HERE TO REDIRECT ON YOUR JITSI MEET APPLICATION.</span>
                              <br><br>
                              <a type="button" class="btn btn-primary btn-lg" href="https://meet.jit.si/<?php echo $room_name?>" target="_blank"><i class="picons-thin-icon-thin-0191_window_application_cursor"></i> Click Here</a>
                            </center>
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