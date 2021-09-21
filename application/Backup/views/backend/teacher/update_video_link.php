<?php 
  $link_id = $param2; 
  $data = $param3;
  $form = $param4;
  $query = $this->db->query("SELECT * from tbl_video_link where link_id = '$link_id'")->row_array();

?>

<div class="modal-body">
        <div class="ui-block-title" style="background-color:#00579c">
          <h6 class="title" style="color:white"><?php echo get_phrase('update_video_link');?></h6>
        </div>
        <div class="ui-block-content">
          <?php echo form_open(base_url() . 'teacher/video_link/update/'.$link_id.'/'.$data.'/'.$form  , array('enctype' => 'multipart/form-data'));?>
              <div class="row">
                  <input type="hidden" value="<?php echo $link_id;?>" name="link_id">
                  <input type="hidden" value="<?php echo $ex[0];?>" name="class_id"/>
                  <input type="hidden" value="<?php echo $ex[1];?>" name="section_id"/>
                  <input type="hidden" value="<?php echo $ex[2];?>" name="subject_id"/>
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('description');?></label>
                        <textarea class="form-control" rows="5" name="description"><?php echo $query['description'];?></textarea>
                    </div>
                  </div>
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                      <label class="control-label"><?php echo get_phrase('host_name');?></label>
                      <div class="select">
                        <select name="host_name" id="slct">
                           <option value=""><?php echo get_phrase('select');?></option>
                           <?php $cl = $this->db->get('tbl_hostnames')->result_array();
                              foreach($cl as $row):
                              ?>
                           <option value="<?php echo $row['id'];?>" <?php if($query['video_host_id'] == $row['id']) echo 'selected';?>><?php echo $row['hostname'];?></option>
                           <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                  </div> 
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group label-floating is-select">
                        <label class="control-label"><?php echo get_phrase('select_semester');?></label>

                      <div class="select">
                        <select name="semester_id" id="semester_id">
                           <option value=""><?php echo get_phrase('select');?></option>
                           <?php $ex = $this->db->get('exam')->result_array();
                              foreach($ex as $row):
                              ?>

                           <option value="<?php echo $row['exam_id'];?>" <?php if($query['semester_id'] == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                           <?php endforeach;?>

                        </select>
                      </div>
                     </div>
                  </div>
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('instructional_video_link');?></label>
                        <input class="form-control" name="link_name" type="text" value="<?php echo $query['link_name'] ?>">
                    </div>
                  </div>
              </div>
              <div class="form-buttons-w text-right">
                <center><button class="btn btn-rounded btn-success" type="submit"><?php echo get_phrase('update');?></button></center>
              </div>
            <?php echo form_close();?>        
        </div>
      </div>