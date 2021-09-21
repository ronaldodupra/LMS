 <?php $details = $this->db->get_where('news' , array('news_code' => $code))->result_array();
 foreach($details as $row2):
 ?>
 <div class="content-w">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
  <div class="conty">
	<div class="content-i">
	<div class="content-box">
	<div class="col-lg-12"><br>	
  	<div class="back hidden-sm-down" style="margin-top:-20px;margin-bottom:10px">		
      <a href="<?php echo base_url();?>admin/panel/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>	
  	</div>	

    <div class="element-wrapper">	
		  <div class="element-box lined-primary shadow">
      	<div class="modal-header">
          <h5 class="modal-title"><?php echo get_phrase('update_news');?></h5>
      	</div>
        <div class="modal-body">
          <div class="ui-block-content">
          <?php echo form_open(base_url() . 'admin/news/update_panel/'.$row2['news_code'], array('enctype' => 'multipart/form-data')); ?>
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <label class="control-label"><?php echo get_phrase('description');?></label>
                <!-- <textarea class="form-control" name="description" rows="10"><?php //echo $row['description'];?></textarea> -->

                <textarea class="form-control" id="mymce_news" name="description" rows="10"><?php echo $row2['description'];?></textarea>
              </div>
            </div>
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                 <div class="form-group label-floating">
                    <label class="control-label"><?php echo get_phrase('image');?></label>
                    <input name="userfile" accept="image/x-png,image/gif,image/jpeg" id="imgpre" type="file"/>
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <button class="btn btn-rounded btn-success btn-lg " type="submit"><?php echo get_phrase('update');?></button>
            </div>
          </div>
          <?php echo form_close();?>
        </div>
  		</div>
    </div>
  </div>
  </div>  
  </div>
  </div>
</div>
<?php endforeach;?>