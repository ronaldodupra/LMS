<?php 
  $conference_id = $param2; 
  $data = $param3;
  $form = $param4;
  $query = $this->db->query("SELECT * from tbl_live_conference where conference_id = '$conference_id'")->row_array();
  ?>
<div class="modal-body">
  <div class="ui-block-title" style="background-color:#00579c">
    <h6 class="title" style="color:white"><span class="fa fa-edit"></span> <?php echo get_phrase('update_live_class');?></h6>
  </div>
  <div class="ui-block-content">
    <?php echo form_open(base_url() . 'admin/live_conference/update/'.$live_id.'/'.$data.'/'.$form  , array('enctype' => 'multipart/form-data'));?>
    <div class="row">
      <input type="hidden" value="<?php echo $conference_id;?>" name="con_id"/>
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
      <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
          <label class="control-label"><?php echo get_phrase('type');?></label>
          <div class="select">
            <input type="hidden" id="typeid" value="<?php echo $query['live_type'];  ?>">
            <select name="type_id" required="" id="type_id" onload="select_type(this.value)">
              <option value=""><?php echo get_phrase('select');?></option>
              <?php if($query['live_type'] == 1) {?>
              <option value="1" selected=""><?php echo get_phrase('live_conference');?></option>
              <option value="2"><?php echo get_phrase('live_stream');?></option>
              <?php } else if($query['live_type'] == 2) {?>
              <option value="1"><?php echo get_phrase('live_conference');?></option>
              <option value="2" selected=""><?php echo get_phrase('live_stream');?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col col-lg-12 col-md-12 col-sm-12 col-12" id="econ_host">
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
      <div class="col col-lg-12 col-md-12 col-sm-12 col-12" id="econ_parti">
        <div class="col-sm-12">
          <legend><span style="font-size:15px;"><?php echo get_phrase('Participant');?></span></legend>
        </div>
        <div class="form-group">
          <input type="hidden" id="eparticipant" name="eparticipant" value="<?php echo $query['member'];?>">
          <div id="eparticipant_val">
            <?php
              $data = $query['member'];
              $member = explode(", ", $data);
            ?>
            <div class="row">
              <div class="col-sm-3">
                <label class="containers">ALL
                <?php if($member[0]=='all' || $member[1]=='all' || $member[2]=='all' || $member[3]=='all'): ?>
                <input type="checkbox" onclick="get_days()" name="days_group" value="all" checked="">
                <?php else: ?>
                <input type="checkbox" onclick="get_days()" name="days_group" value="all">
                <?php endif; ?>
                <span class="checkmark"></span>
                </label>    
              </div>
              <div class="col-sm-3">
                <label class="containers">STUDENTS
                <?php if($member[0]=='student' || $member[1]=='student' || $member[2]=='student' || $member[3]=='student'): ?>
                <input type="checkbox" onclick="get_days()" name="days_group" value="student" checked="">
                <?php else: ?>
                <input type="checkbox" onclick="get_days()" name="days_group" value="student">
                <?php endif; ?>
                <span class="checkmark"></span>
                </label>    
              </div>
              <div class="col-sm-3">
                <label class="containers">TEACHERS
                <?php if($member[0]=='teacher' || $member[1]=='teacher' || $member[2]=='teacher' || $member[3]=='teacher'): ?>
                <input type="checkbox" onclick="get_days()" name="days_group" value="teacher" checked="">
                <?php else: ?>
                <input type="checkbox" onclick="get_days()" name="days_group" value="teacher">
                <?php endif; ?>
                <span class="checkmark"></span>
                </label>    
              </div>
              <div class="col-sm-3">
                <label class="containers">PARENTS
                <?php if($member[0]=='parent' || $member[1]=='parent' || $member[2]=='parent' || $member[3]=='parent'):?>
                <input type="checkbox" onclick="get_days()" name="days_group" value="parent" checked="">
                <?php else: ?>
                <input type="checkbox" onclick="get_days()" name="days_group" value="parent">
                <?php endif; ?>
                <span class="checkmark"></span>
                </label>    
              </div>
            </div>

            <div class="row" style="display: none;">
              <div class="col-sm-3">
                <label class="containers">ADMINS
                <input type="checkbox" onclick="get_days()" name="days_group" value="admin">
                <span class="checkmark"></span>
                </label>    
              </div>
              <div class="col-sm-3">
                <label class="containers">LIBRARIAN
                <input type="checkbox" onclick="get_days()" name="days_group" value="librarian">
                <span class="checkmark"></span>
                </label>    
              </div>
              <div class="col-sm-3">
                <label class="containers">ACCOUNTING
                <input type="checkbox" onclick="get_days()" name="days_group" value="accountant">
                <span class="checkmark"></span>
                </label>    
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col col-lg-6 col-md-12 col-sm-12 col-12" id="econ_provider">
        <div class="form-group">
          <label class="control-label"><?php echo get_phrase('select_provider');?></label>
          <div class="select">
            <select name="provider_id" id="provider_id">
              <option value=""><?php echo get_phrase('select');?></option>
              <?php if($query['provider_id'] == 1) {?>
              <option value="1" selected=""><?php echo get_phrase('youtube');?></option>
              <option value="2"><?php echo get_phrase('facebook');?></option>
              <?php } else if($query['provider_id'] == 2){ ?>
              <option value="1"><?php echo get_phrase('youtube');?></option>
              <option value="2" selected=""><?php echo get_phrase('facebook');?></option>
              <?php }?>
            </select>
          </div>
        </div>
      </div>
      <div class="col col-lg-6 col-md-12 col-sm-12 col-12" id="econ_link">
        <div class="form-group">
          <label class="control-label"><?php echo get_phrase('live_stream_link');?></label>
          <input type="text" name="live_link" class="form-control" value="<?php echo $query['live_link'];?>"> 
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

<script type="text/javascript">
  $(document).ready(function(e){
    $("#econ_parti").hide();
    $("#econ_host").hide();
    $("#econ_provider").hide();
    $("#econ_link").hide();

    var id = $("#typeid").val();
    select_type(id)
  })

  function get_days(){
    var chkArray = [];
    
    /* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
    $("#eparticipant_val input:checked").each(function() {
      chkArray.push($(this).val());
    });
    
    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join(','+' ') ;
    //alert(selected)
    $("#eparticipant").val(selected);
  }

  function select_type($id){
    if ($id == 1) {
      $("#econ_parti").show();
      $("#econ_host").show();
      $("#econ_provider").hide();
      $("#econ_link").hide();
    }
    else{
      $("#econ_parti").hide();
      $("#econ_host").hide();
      $("#econ_provider").show();
      $("#econ_link").show();
    }
  }
</script>