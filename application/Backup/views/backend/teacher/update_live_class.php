<?php 

  $live_id = $param2; 
  $data = $param3;
  $form = $param4;
  $query = $this->db->query("SELECT * from tbl_live_class where live_id = '$live_id'")->row_array();
?>

<div class="modal-body">
  <div class="ui-block-title" style="background-color:#00579c">
            <h6 class="title" style="color:white"><span class="fa fa-edit"></span> <?php echo get_phrase('update_live_class');?></h6>
            </div>
            <div class="ui-block-content">

               <?php echo form_open(base_url() . 'teacher/live_class/update/'.$live_id.'/'.$data.'/'.$form  , array('enctype' => 'multipart/form-data'));?>

               <div class="row">

                  <input type="hidden" value="<?php echo $live_id;?>" name="live_id"/>
                  <input type="hidden" value="<?php echo $ex[0];?>" name="class_id"/>
                  <input type="hidden" value="<?php echo $ex[1];?>" name="section_id"/>
                  <input type="hidden" value="<?php echo $ex[2];?>" name="subject_id"/>

                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('titles');?></label>
                        <input class="form-control" name="title" type="text" value="<?php echo $query['title'];?>">
                     </div>
                  </div>

                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
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

                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('select_host');?></label>
                        <div class="select">
                           <select name="host_id" id="host_id">
                              <option value=""><?php echo get_phrase('select');?></option>

                              <?php 

                              if($query['host_id'] == 1){ ?>

                                  <option value="1" selected=""><?php echo get_phrase('Zoom');?></option>
                                  <option value="2"><?php echo get_phrase('Jitsi Meet');?></option>

                              <?php }else if($query['host_id'] == 2){ ?>

                                  <option value="1" ><?php echo get_phrase('Zoom');?></option>
                                  <option value="2" selected=""><?php echo get_phrase('Jitsi Meet');?></option>

                              <?php } ?>

                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('date');?></label>
                        <input type='text' class="datepicker-here" data-position="top left" data-language='en' name="live_class_date" data-multiple-dates-separator="/" value="<?php echo $query['start_date'] ?>" />
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('start_time');?></label>
                        
                        <input type="time" required="" name="start_time" class="form-control" value="<?php echo $query['start_time'] ?>">

                     </div>
                  </div>

                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('description');?></label>
                        <textarea class="form-control" rows="2" name="description"><?php echo $query['description'] ?></textarea>
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                      <div class="form-buttons-w text-right">
                        <center><button class="btn btn-rounded btn-success btn-lg" type="submit"><?php echo get_phrase('update');?></button></center>
                     </div>
                  </div>
               </div>
              
               <?php echo form_close();?>        
            </div>
</div>