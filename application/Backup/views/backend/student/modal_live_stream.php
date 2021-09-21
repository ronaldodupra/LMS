<?php 
    $ins_vid = $this->db->get_where('tbl_live_conference' , array('conference_id' => $param2))->result_array();
    foreach($ins_vid as $row):
?>
    <div class="modal-body">
      <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo get_phrase('video_preview');?></h6>
      </div>
      <div class="ui-block-content">
        <?php
          if ($row['provider_id'] == 1):
          $link = $row['live_link'];
          $link_split = explode("=", $link);
        ?>

        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" id="iframe_video" src="https://www.youtube.com/embed/<?php echo $link_split[1]; ?>" allowfullscreen></iframe>
        </div> 

        <?php else: ?>

        <center>
          <?php echo $row['live_link']; ?>
        </center>

      <?php endif; ?>
      </div>     
    </div>
<?php endforeach;?>
 