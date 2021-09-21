<?php 
    $ins_vid = $this->db->get_where('tbl_live_class' , array('live_id' => $param2))->result_array();
    foreach($ins_vid as $row):
?>
    <div class="modal-body">
        <div class="modal-header" style="background-color:#00579c">

            <h6 class="title" style="color:white"><?php echo get_phrase('video_preview');?></h6>
        </div>
        <div class="ui-block-content">
            <?php 
                $link = $row['link_name'];
                $link_split = explode("=", $link);
            ?>
            <div class="embed-responsive embed-responsive-16by9">
               <iframe class="embed-responsive-item" id="" src="<?php echo base_url();?>CDN/index.php?mid=<?php echo $row['meeting_id']?>&pwd=<?php echo $row['password']?>" allowfullscreen></iframe>
            </div>  
        </div>
    </div>

    <?php endforeach;?>