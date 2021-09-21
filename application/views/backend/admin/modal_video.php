<?php 
    $ins_vid = $this->db->get_where('tbl_video_link' , array('link_id' => $param2))->result_array();
    foreach($ins_vid as $row):
?>
    <div class="modal-body">
      <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo get_phrase('video_preview');?></h6>
      </div>
      <div class="ui-block-content">
        <?php
          if ($row['video_host_id'] == 1) {
            $link = $row['link_name'];
            $link_split = explode("=", $link);
        ?>

          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" id="iframe_video" src="https://www.youtube.com/embed/<?php echo $link_split[1]; ?>" allowfullscreen></iframe>
          </div>  

        <?php }
          elseif ($row['video_host_id'] == 2) {
            $link = $row['link_name'];
        ?>

          <center>
            <iframe src="https://www.facebook.com/plugins/post.php?href=<?php echo $link; ?>" width="100%" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowfullscreen="true" allow="encrypted-media"></iframe>
          </center>

        <?php }
          elseif ($row['video_host_id'] == 3) {
            $link = $row['link_name'];
        ?>

            <iframe src="<?php echo $link; ?>/preview" width="100%" height="500" allowfullscreen="true"></iframe>

        <?php }
          elseif ($row['video_host_id'] == 4) {
            $link = $row['link_name']; 
        ?>

          <iframe src="<?php echo $link; ?>" width="100%" height="500" frameborder="0" scrolling="no" allowfullscreen></iframe>

        <?php 
          }
        ?>

         
      </div>     
    </div>
    <!--  <iframe src="https://onedrive.live.com/embed?cid=11A4D7A2C227E1CA&resid=11A4D7A2C227E1CA%218709&authkey=AElE0k-87a1FCjI" width="100%" height="500" frameborder="0" scrolling="no" allowfullscreen></iframe> -->
<?php endforeach;?>
 