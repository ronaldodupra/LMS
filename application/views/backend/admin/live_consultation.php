<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
   <?php include 'fancy.php';?>
   <div class="header-spacer"></div>
   <div class="conty">
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/request_student/"><i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i><span><?php echo get_phrase('reports');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>admin/live_consultation/"><i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i><span><?php echo get_phrase('live_consultation');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/request/"><i class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i><span><?php echo get_phrase('permissions');?></span></a>
               </li>
            </ul>
         </div>
      </div>

      <div class="content-box">
         <div class="element-wrapper">
            <h6 class="element-header">
               <div style="margin-top:auto;text-align:right;">
                  <a href="#" data-target="#addmaterial" data-toggle="modal" class="btn btn-control btn-grey-lighter btn-primary">
                     <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                     <div class="ripple-container"></div>
                  </a>
               </div>
            </h6>
            <div class="element-box-tp">
               <div class="table-responsive">
                  <table class="table table-padded" id="student_report">
                     <thead>
                        <tr>
                           <th><?php echo get_phrase('title');?></th>
                           <th><?php echo get_phrase('schedule');?></th>
                           <th><?php echo get_phrase('host');?></th>
                           <th><?php echo get_phrase('description');?></th>
                           <th><?php echo get_phrase('options');?></th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                          $admin_id = $this->session->userdata('login_user_id');
                          $fname = $this->db->get_where('admin', array('admin_id' => $admin_id))->row()->first_name;
                          $lname = $this->db->get_where('admin', array('admin_id' => $admin_id))->row()->last_name;
                          $sname = $fname . ' ' . $lname;
                        ?>
                        <?php
                           $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
                           $con_live_info = $this->db->query("SELECT * FROM tbl_live_consultation ORDER BY consultation_id DESC");
                          
                           if ($con_live_info->num_rows() > 0):
                              foreach($con_live_info->result_array() as $rows):
                                 $room_name = $rows['title'].'-'.sha1($row['timestamp']);
                        ?>
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
                            
                              <a href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/update_live_consultation/<?php echo $rows['consultation_id']?>/<?php echo $data;?>')" class="btn btn-success btn-sm"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> <?php echo get_phrase('edit');?></a><br>

                              <a href="javascript:void(0)" onclick="delete_data_live_con('<?php echo $rows['consultation_id'] ?>')" class="btn btn-danger btn-sm"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i> <?php echo get_phrase('delete');?></a>
                           <?php endforeach; else:?>
                           <tr>
                             <td colspan="5"> No data Found...</td>
                           </tr>
                           <?php endif;?>
                          </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="display-type"></div>

<div class="modal fade" id="addmaterial" tabindex="-1" role="dialog" aria-labelledby="addmaterial" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document" style="width: 80%;">
      <div class="modal-content">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close" onclick="//reload_live_con()">
         </a>
         <div class="modal-body">
            <div class="ui-block-title" style="background-color:#00579c">
               <h6 class="title" style="color:white"><span class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></span> <?php echo get_phrase('create_live_consultation');?></h6>
            </div>
            <div class="ui-block-content">
               <!-- <form enctype="multipart/form-data" id="add_member" onsubmit="event.preventDefault();"></form> -->
                <?php echo form_open(base_url() . 'admin/live_consultation/create/', array('enctype' => 'multipart/form-data'));?>
                <div class="row">
                  <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                     <div class="row"> 
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                           <div class="form-group">
                              <label class="control-label"><?php echo get_phrase('title');?></label>
                              <input class="form-control" required="" name="title" type="text">
                           </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label class="control-label"><?php echo get_phrase('date');?></label>
                            <input type='text' required="" class="datepicker-here" data-position="top left" data-language='en' name="live_class_date" data-multiple-dates-separator="/"/>
                          </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label class="control-label"><?php echo get_phrase('start_time');?></label>
                            <input type="time" required="" name="start_time" class="form-control" value="07:00"> 
                           </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12" id="con_host">
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
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label class="control-label"><?php echo get_phrase('select_participant');?></label>
                            <div class="select">
                              <select name="parti_id" id="parti_id" required="" onchange="select_type(this.value)">
                                <option value="">Select</option>
                                <option value="1">Student</option>
                                <option value="2">Teacher</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12" id="con_cl">
                           <div class="form-group">
                            <label class="control-label"><?php echo get_phrase('select_class');?></label>
                            <div class="select">
                              <select name="class_id" id="cl_id" onchange="get_class_sections(this.value);">
                                <option value=""><?php echo get_phrase('select');?></option>
                                <?php 
                                  $classes = $this->db->query("SELECT * FROM class ORDER BY nivel_id ASC")->result_array();
                                  foreach($classes as $row):
                                ?>
                                <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                <?php endforeach;?>
                              </select>
                            </div>
                           </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12" id="con_sec">
                           <div class="form-group">
                              <label class="control-label"><?php echo get_phrase('select_section');?></label>
                              <div class="select">
                                <select name="section_id" id="section_selector" onchange="get_section_id(this.value);">
                                  <option value=""><?php echo get_phrase('select');?></option>
                                </select>
                              </div>
                           </div>
                        </div>

                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                          <div class="form-group">
                            <label class="control-label"><?php echo get_phrase('description');?></label>
                            <textarea class="form-control" rows="2" name="description"></textarea>
                          </div>
                        </div>
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-6 col-sm-12 col-12" id="con_list..">
                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                      <input type="hidden" id="mem_id" name="mem_id">
                      <div class="form-group" id="student">
                        <div class="col-md-12" style="margin-top: 30px; height: 450px; overflow: auto;" id="tbl_member_list">
                             
                        </div> 
                      </div>
                    </div>
                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                      <div class="form-group">
                        <div class="form-buttons-w text-right">
                          <center><button class="btn btn-rounded btn-success btn-lg" onclick="//add_live_member();" type="submit"><?php echo get_phrase('add');?></button></center>
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
    $("#con_cl").hide();
    $("#con_sec").hide();

    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    var element = document.getElementById('text');
    if (isMobile) {
        //element.innerHTML = "You are using Mobile";
        $('.laptop_desktop').css('display','none');

    } else {
      //element.innerHTML = "You are using Desktop";
      $('.mobile').css('display','none');
    }
  })

  // function reload_live_con() 
  // {
  //   window.location.href = '<?php //echo base_url();?>admin/live_consultation/';
  // }

  function select_type($id)
  {
    if ($id == 1) {
      $("#con_cl").show();
      $("#con_sec").show();
    }
    else if ($id == 2){
      $("#con_cl").hide();
      $("#con_sec").hide();

      load_member_info($id, '', ''); 
    }
    else{
      $("#con_cl").hide();
      $("#con_sec").hide();

      load_member_info($id, '', ''); 
    }
  }

  function get_class_sections(class_id) 
  {  
    $.ajax({
      url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
      success: function(response)
      {
        jQuery('#section_selector').html(response);
      }
    });
  }

  function get_section_id(sec_id) 
  {
    var type = $("#parti_id").val(); 
    var cid = $("#cl_id").val();
    load_member_info(type, cid, sec_id);
  }

  function get_member_name(){
    var chkArray = [];
    
    /* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
    $("#tid_val input:checked").each(function() {
      chkArray.push($(this).val());
    });
    
    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join(','+' ');
    //alert(selected)
    $("#mem_id").val(selected);
  }

  function checkAllBoxes(check){
    var checkboxes = $("#member").val()

    if (check.checked) {
      $('.'+check.id).prop("checked", true);
    } else {
      $('.'+check.id).prop("checked", false);
    }
  }

  function load_member_info(type, cl_id, sec_id)
  {

    var mydata = 'type=' + type + '&c_id=' + cl_id + '&s_id=' + sec_id;

    $.ajax({
      url:"<?php echo base_url(); ?>admin/load_member",
      data:mydata,
      method:"POST",
      dataType:"JSON",
      success:function(data){
        var html='';

        if(data.length > 0){

          html += '<table class="table table-bordered table-striped" style="">';
          html += '<thead><tr>';
          html += '<th style="background-color:#99bf2d; color: #fff;"><?php echo get_phrase('select');?></th>';
          html += '<th style="background-color:#99bf2d; color: #fff;"><?php echo get_phrase('fullname');?></th>';
          html += '</tr></thead>';

          for(var count = 0; count < data.length; count++)
          {
            html += '<tr id="filter_search">';
            if (type == 1) {
              html += '<td width = "20%" id="tid_val"><input type="checkbox" onclick="get_member_name();" name="user[]" value="'+data[count].Id+'"></td>';
            }else if(type == 2) {
              html += '<td width = "20%" id="tid_val"><input type="checkbox" onclick="get_member_name();" name="user[]" value="'+data[count].Id+'"></td>';
            }
            html += '<td width = "80%">'+data[count].fullname+'</td>';
            html += '</tr>';
          }
          html += '</table>';

        }else{

          html += '<table class="table table-bordered table-striped" style="">';
          html += '<thead><tr>';
          html += '<th style="background-color:#99bf2d; color: #fff;"><?php echo get_phrase('select');?></th>';
          html += '<th style="background-color:#99bf2d; color: #fff;"><?php echo get_phrase('fullname');?></th>';
          html += '</tr></thead>';
          html += '<tr><td colspan="2"><center><?php echo get_phrase('no_data_found');?></center></td></tr>';
          html += '</table>';

        }

        $('#tbl_member_list').html(html);

      }
    });
  }

  // function add_live_member() {

  //   $.ajax({
  //     url:'<?php //echo base_url();?>admin/live_consultation/create/',
  //     method:'POST',
  //     data:$("form#add_member").serialize(),
  //     cache:false,
  //     success:function(data)
  //     {
  //       if(data == 1){
  //         swal("LMS", "Student Profile Successfully Updated.", "success");
  //       }else{
  //         swal("LMS", "Error", "error");
  //       } 
  //     }
  //   });
  // }

  function delete_data_live_con(id) {
   
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
        window.location.href = '<?php echo base_url();?>admin/live_consultation/delete/' + id;

      } 
      else 
      {
 
      }
    });
  }
</script>
