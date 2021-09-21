<div class="content-w">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
  <div class="conty">
    <div class="all-wrapper no-padding-content solid-bg-all">
      <div class="layout-w">
        <div class="content-w">
          <div class="content-i">
            <div class="content-box">
              <div class="app-email-w">
                <div class="app-email-i">
                  <div class="ae-content-w" style="background-color: #f2f4f8;">
                    <div class="top-header top-header-favorit">
                      <div class="top-header-thumb">
                        <img src="<?php echo base_url();?>uploads/bglogin.jpg" style="height:180px; object-fit:cover;">
                        <div class="top-header-author">
                          <div class="author-thumb">
                            <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff; padding:10px">
                          </div>
                          <div class="author-content">
                            <a href="javascript:void(0);" class="h3 author-name">
                            Live Conference | Live Stream</a>
                            <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="header-spacer"></div>
                    <div class="container-fluid" id="results">
                      <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                          <div class="element-wrapper">
                            <div class="element-box-tp">
                              <h5 class="element-header">
                                <div style="margin-top:auto;float:right;">
                                  <a href="#" data-target="#addmaterial" data-toggle="modal" class="text-white btn btn-control btn-grey-lighter btn-success mr-5">
                                    <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                    <div class="ripple-container"></div>
                                  </a>
                                </div>
                              </h5>
                              <p id="text" style="display: none;"></p>
                              <div class="table-responsive" style="margin-top: -2%;">
                                <table class="table table-padded">
                                  <thead>
                                    <tr>
                                      <th><?php echo get_phrase('title');?></th>
                                      <th><?php echo get_phrase('schedule');?></th>
                                      <th><?php echo get_phrase('host');?></th>
                                      <th><?php echo get_phrase('description');?></th>
                                      <th><?php echo get_phrase('options');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="results">
                                    <?php
                                      $admin_id = $this->session->userdata('login_user_id');
                                      $fname = $this->db->get_where('admin', array('admin_id' => $admin_id))->row()->first_name;
                                      $lname = $this->db->get_where('admin', array('admin_id' => $admin_id))->row()->last_name;
                                      $sname = $fname . ' ' . $lname;
                                    ?>
                                    <?php
                                      $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
                                      $con_live_info = $this->db->query("SELECT * FROM tbl_live_conference ORDER BY conference_id DESC");
                                      
                                      if ($con_live_info->num_rows() > 0):
                                        foreach($con_live_info->result_array() as $rows):
                                          $room_name = $rows['title'].'-'.sha1($row['timestamp']);
                                    ?>
                                    <?php if($rows['live_type'] == 1):?>
                                    <tr>
                                      <td><?php echo $rows['title']; ?></td>
                                      <td><?php echo '<b>'.get_phrase('date').':</b> '.$rows['start_date'].'<br>'.'<b>'.get_phrase('time').':</b> '.date('g:i A', strtotime($rows['start_time']));?></td>
                                      <td><?php if ($rows['host_id'] == 1) { echo 'Zoom'; } else { echo 'Jitsi Meet'; } ?></td>
                                      <td><?php echo $rows['description']; ?></td>
                                      <td class="text-center bolder">
                                        <?php if ($rows['host_id'] == 2): ?>
                                          <a title="Join Live Classroom" href="<?php echo base_url();?>jitsi_meet/host.php?data=<?php echo base64_encode($room_name.'-'.$sname);?>" target="_blank" class="btn btn-info btn-sm laptop_desktop"> <i class="picons-thin-icon-thin-0324_computer_screen"></i> <?php echo get_phrase('Join');?></a>
                                          
                                          <a title="Join Live Classroom" href="https://meet.jit.si/<?php echo $room_name?>" target="_blank" class="btn btn-info btn-sm mobile"> <i class="picons-thin-icon-thin-0191_window_application_cursor"></i> <?php echo get_phrase('Join');?></a>
                                        <?php endif ?>
                                        
                                        <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/update_live_conference/<?php echo $rows['conference_id']?>/<?php echo $data;?>')" class="btn btn-success btn-sm"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> <?php echo get_phrase('edit');?></a><br>

                                        <a href="javascript:void(0)" onclick="delete_data_live_con('<?php echo $rows['conference_id'] ?>','<?php echo $data ?>')" class="btn btn-danger btn-sm"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i> <?php echo get_phrase('delete');?></a>
                                      </td>
                                    </tr>
                                    <?php else:?>
                                    <tr>
                                      <td><?php echo $rows['title']; ?></td>
                                      <td><?php echo '<b>'.get_phrase('date').':</b> '.$rows['start_date'].'<br>'.'<b>'.get_phrase('time').':</b> '.date('g:i A', strtotime($rows['start_time']));?></td>
                                      <td><?php if ($rows['provider_id'] == 1) { echo 'Youtube Live Stream'; } else {echo 'Facebook Live Stream';} ?></td>
                                      <td><?php echo $rows['description']; ?></td>
                                      <td class="text-center bolder">
                                        <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_live_stream/<?php echo $rows['conference_id'];?>');" class="btn btn-info btn-sm"> <i class="picons-thin-icon-thin-0324_computer_screen"></i> <?php echo get_phrase('watch');?></a>
                                        <?php if($rows['provider_id'] == '1'): ?>
                                        <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/update_live_conference/<?php echo $rows['conference_id']?>/<?php echo $data;?>')" class="btn btn-success btn-sm"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> <?php echo get_phrase('edit');?></a>
                                        <?php endif; ?>
                                        <br>

                                        <a href="javascript:void(0)" onclick="delete_data_live_con('<?php echo $rows['conference_id'] ?>','<?php echo $data ?>')" class="btn btn-danger btn-sm"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i> <?php echo get_phrase('delete');?></a>
                                      </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php endforeach;
                                      else:?>
                                    <tr>
                                      <td colspan="5"> No data Found...</td>
                                    </tr>
                                    <?php endif;?>
                                  </tbody>
                                </table>
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
          </div>
        </div>
      </div>
      <div class="display-type"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="addmaterial" tabindex="-1" role="dialog" aria-labelledby="addmaterial" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
      <div class="modal-content">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
         </a>
         <div class="modal-body">
            <div class="ui-block-title" style="background-color:#00579c">
               <h6 class="title" style="color:white"><span class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></span> <?php echo get_phrase('create_live_conference');?></h6>
            </div>
            <div class="ui-block-content">
               <?php echo form_open(base_url() . 'admin/live_conference/create/', array('enctype' => 'multipart/form-data')); ?>
               <div class="row">
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('title');?></label>
                        <input class="form-control" required="" name="title" type="text">
                     </div>
                  </div>

                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                      <label class="control-label"><?php echo get_phrase('date');?></label>
                      <input type='text' required="" class="datepicker-here" data-position="top left" data-language='en' name="live_class_date" data-multiple-dates-separator="/"/>
                    </div>
                  </div>
                  
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                      <label class="control-label"><?php echo get_phrase('start_time');?></label>
                      <input type="time" required="" name="start_time" class="form-control" value="07:00"> 
                     </div>
                  </div>

                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('type');?></label>
                        <div class="select">
                           <select name="type_id" required="" id="type_id" onchange="select_type(this.value)">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="1"><?php echo get_phrase('live_conference');?></option>
                              <option value="2"><?php echo get_phrase('live_stream');?></option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12" id="con_host">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('select_host');?></label>
                        <div class="select">
                           <select name="host_id" id="host_id">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="1"><?php echo get_phrase('Zoom');?></option>
                              <option value="2"><?php echo get_phrase('Jitsi Meet');?></option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12" id="con_parti">
                    <div class="col-sm-12">
                      <legend><span style="font-size:15px;"><?php echo get_phrase('Participant');?></span></legend>
                    </div>
                     <div class="form-group">
                        <input type="hidden" id="participant" name="participant">
                        <div id="participant_val">
                           <div class="row">
                              <div class="col-sm-3">
                                 <label class="containers">ALL
                                 <input type="checkbox" onclick="get_days()" name="days_group" value="all">
                                 <span class="checkmark"></span>
                                 </label>    
                              </div>
                              <div class="col-sm-3">
                                 <label class="containers">STUDENTS
                                 <input type="checkbox" onclick="get_days()" name="days_group" value="student">
                                 <span class="checkmark"></span>
                                 </label>    
                              </div>
                              <div class="col-sm-3">
                                 <label class="containers">TEACHERS
                                 <input type="checkbox" onclick="get_days()" name="days_group" value="teacher">
                                 <span class="checkmark"></span>
                                 </label>    
                              </div>
                              <div class="col-sm-3">
                                 <label class="containers">PARENTS
                                 <input type="checkbox" onclick="get_days()" name="days_group" value="parent">
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

                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12" id="con_provider">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('select_provider');?></label>
                        <div class="select">
                           <select name="provider_id" id="provider_id">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="1"><?php echo get_phrase('youtube');?></option>
                              <option value="2"><?php echo get_phrase('facebook');?></option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12" id="con_link">
                    <div class="form-group">
                      <label class="control-label"><?php echo get_phrase('live_stream_link');?></label>
                      <input type="text" name="live_link" class="form-control"> 
                    </div>
                  </div>

                  <!-- <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                      <label class="control-label"><?php //echo get_phrase('select_participant');?></label>
                      <div class="select">
                        <select name="parti_id" id="parti_id" required="">
                          <option value="">Select</option>
                          <option value="1">All</option>
                          <option value="2">Student</option>
                          <option value="3">Teacher</option>
                          <option value="4">Parents</option>
                          <option value="5">Admins</option>
                          <option value="6">Librarian</option>
                          <option value="7">Accounting</option>
                        </select>
                      </div>
                    </div>
                  </div> -->

                  <!-- <div class="col col-lg-12 col-md-12 col-sm-12 col-12">                    
                    <div class="form-group">
                      <?php
                        echo $categ;
                        $user_array = ['teacher'];
                        for ($i=0; $i < sizeof($user_array); $i++):
                        $user_list = $this->db->get($user_array[$i])->result_array();
                      ?>
                      <div class="col-md-12" style="margin-top: 10px;">
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th><input type="checkbox" id="<?php echo $user_array[$i]; ?>" onchange="checkAllBoxes(this)"><center><?php echo get_phrase('select_all');?></center></th>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <thead>
                            <tr>
                              <th style="background-color:#99bf2d; color: #fff;"><?php echo get_phrase('select');?></th>
                              <th style="background-color:#99bf2d; color: #fff;"><?php echo get_phrase('user');?></th>
                              <th style="background-color:#99bf2d; color: #fff;"><?php echo get_phrase('name');?></th>
                            </tr>
                          </thead>
                           <input type="hidden" id="t_id" name="t_id">
                          <?php foreach ($user_list as $user):?>
                            <tr id="filter_search">
                              <td width = "20%" id="tid_val"><input type="checkbox" id="chk_teacher" onclick="get_teacher_name();" class="<?php echo $user_array[$i];?>" name="user[]" value="<?php echo $user[$user_array[$i].'_id'];?>"></td>
                              <td width = "25%"><?php echo $user['username'] ?></td>
                              <td width = "55%"><?php echo $user['first_name']." ".$user['last_name'] ?></td>
                            </tr>
                          <?php endforeach ?>
                        </table>
                      </div>
                      <?php endfor; ?>   
                    </div>
                  </div> -->

                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                      <label class="control-label"><?php echo get_phrase('description');?></label>
                      <textarea class="form-control" rows="2" name="description"></textarea>
                    </div>
                  </div>

                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                      <div class="form-buttons-w text-right">
                        <center><button class="btn btn-rounded btn-success btn-lg" type="submit"><?php echo get_phrase('save');?></button></center>
                      </div>
                    </div>
                  </div>
                </div>
               <?php echo form_close();?>        
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
  $(document).ready(function(e){

    $("#con_parti").hide();
    $("#con_host").hide();
    $("#con_provider").hide();
    $("#con_link").hide();

    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    var element = document.getElementById('text');
    if (isMobile) {
        element.innerHTML = "You are using Mobile";

        $('.laptop_desktop').css('display','none');

    } else {
      element.innerHTML = "You are using Desktop";
      $('.mobile').css('display','none');
    }

  })

  function get_days(){
    var chkArray = [];
    
    /* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
    $("#participant_val input:checked").each(function() {
      chkArray.push($(this).val());
    });
    
    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join(','+' ') ;
    //alert(selected)
    $("#participant").val(selected);
  }

  function get_teacher_name(){
    var chkArray = [];
    
    /* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
    $("#tid_val input:checked").each(function() {
      chkArray.push($(this).val());
    });
    
    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join(','+' ') ;
    //alert(selected)
    $("#t_id").val(selected);
  }

  function checkAllBoxes(check){
    var checkboxes = $("#chk_teacher").val()
    if (check.checked) {
      $('.'+check.id).prop("checked", true);
    } else {
      $('.'+check.id).prop("checked", false);
    }
  }

  function select_type($id){

    if ($id == 1) {
      $("#con_parti").show();
      $("#con_host").show();
      $("#con_provider").hide();
      $("#con_link").hide();
    }
    else{
      $("#con_parti").hide();
      $("#con_host").hide();
      $("#con_provider").show();
      $("#con_link").show();
    }
  }

  function delete_data_live_con(id,data) {
   
    swal({
      title: "Are you sure ?",
      text: "You want to delete this data?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#e65252",
      confirmButtonText: "Yes, delete",
      closeOnConfirm: true
    },
    function(isConfirm){
 
      if (isConfirm) 
      {        
        
        $('#results').html('<td class="text-center" colspan="6"> Please wait removing data... </td>');
        window.location.href = '<?php echo base_url();?>admin/live_conference/delete/' + id +'/'+ data;

      } 
      else 
      {
 
      }
    });
  }
</script>

<style media="screen">
  .containers {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }
  .containers input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }
  .checkmark {
    position: absolute;
    top: 0; 
    left: 0;
    height: 20px;
    width: 23px;
    background-color: #eee;
  }
  .containers:hover input ~ .checkmark {
    background-color: #ccc;
  }
  .containers input:checked ~ .checkmark {
    background-color: #2196F3;
  }
  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }
  .containers input:checked ~ .checkmark:after {
    display: block;
  }
  .containers .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
</style>