<?php 
    $tut_vid = $this->db->get_where('tbl_video_tutorials' , array('code_name' => $param2))->result_array();
    foreach($tut_vid as $row):

    if($row['video_link'] != "" || $row['video_link'] != null):	
?>
  
  <?php
    $link = $row['video_link'];
  ?>

  <iframe src="<?php echo $link; ?>" width="100%" height="650" allowfullscreen="true"></iframe>

  <?php else: ?>

  <center style="height: 600px;"><br><br><br><br><br><br><br><br><br><br><br><br><h2 class="text-center">No Video Available</h2></center>

<?php endif; endforeach;?>
 