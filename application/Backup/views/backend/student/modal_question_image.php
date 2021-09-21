<div class="modal-body">
     <div class="ui-block-title" style="background-color:#00579c">
      <h6 class="title" style="color:white"><?php echo get_phrase('image');?></h6>
    </div>
    <div class="ui-block-content">
        <div class="row">
            <div class="col col-lg-2 col-md-12 col-sm-12 col-12"></div>
            <div class="col col-lg-8 col-md-12 col-sm-12 col-12">

              <?php 

                if($param3 = 'quiz'){
                  $folder_name = 'online_quiz';
                }else{
                  $folder_name = 'online_exam';
                }

              ?>

            <center><img class="img-fluid" src="<?php echo base_url();?>uploads/<?php echo $folder_name;?>/<?php echo $param2;?>"></center>
            </div>
            <div class="col col-lg-2 col-md-12 col-sm-12 col-12"></div>
        </div>
    </div>
</div>