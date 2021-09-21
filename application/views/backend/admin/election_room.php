<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php
   $election_details = $this->db->get_where('tbl_election', array('id' => $election_id))->row_array(); 
   
   $election_data = $this->db->query("SELECT * from tbl_election_data where election_id = '$election_id' order by position asc");
   
   $positions = $this->db->query("SELECT * from tbl_election_data where election_id = '$election_id' group by position order by id asc");
   
   $date_now = date('Y-m-d');
   $date_start = date('Y-m-d',strtotime($election_details['date_start']));



   $exam_ends_timestamp = strtotime($election_details['date_end']);
   $current_timestamp = strtotime("now");
   
   $total_duration   = $exam_ends_timestamp - $current_timestamp;
   $total_hour     =   intval($total_duration / 3600);
   $total_duration   -=  $total_hour * 3600;
   $total_minute     = intval($total_duration / 60);
   $total_second     = intval($total_duration % 60);

?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <?php if($election_id != ""):?>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <div class="col-md-12">
                  <div class="pipeline white lined-primary">
                     <div class="panel-heading">
                        <h5 class="panel-title">Election Details
                           <a href="<?php echo base_url();?>admin/manage_election/" class="btn btn-sm btn-primary float-right"> <span class="fa fa-arrow-left"></span> Back</a>
                        </h5>
                     </div>
                     <div class="panel-body">
                        <div style="overflow-x:auto;">
                           <table  class="table table-bordered">
                              <tbody>
                                 <tr>
                                    <td><b>Title</b>: 
                                      <?php echo $election_details['title']; ?>
                                    </td>
                                    <td><b>Schedule:</b>
                                       <?php 
                                          $start_date = date('M d, Y h:i A',strtotime($election_details['date_start']));
                                          $end_date = date('M d, Y h:i A',strtotime($election_details['date_end']));
                                          ?>
                                       <?php echo $start_date; ?> - <?php echo $end_date; ?>
                                    </td>
                                    <td>
                                       <b>Status:</b>
                                       <?php 
                                          if($election_details['status'] == 'pending'){ ?>

                                             <span class="badge badge-warning">PENDING</span> | <button class="btn btn-primary" onclick="publish_election('<?php echo $election_details['id'] ?>');"> Publish Election </button>

                                          <?php }elseif($election_details['status'] == 'published'){
                                             echo '<span class="badge badge-primary">PUBLISHED</span>';
                                          }elseif($election_details['status'] == 'expired'){
                                              echo '<span class="badge badge-danger">EXPIRED</span>';
                                          }
                                       ?>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="container-fluid">
                 <div class="row">
                    <div class="col col-xl-12 m-auto col-lg-12 col-md-12">
                       <div class="os-tabs-w">
                          <div class="os-tabs-controls">
                             <ul class="navs navs-tabs upper">
                                <li class="navs-item">
                                   <a class="navs-links <?php if($election_details['status'] == 'pending') echo 'active' ?> "  data-toggle="tab" href="#tab1" id="manage"><span class="fa fa-edit fa-lg"></span> Manage Candidates</a>
                                  </li>
                                  <li class="navs-item">
                                     <a class="navs-links <?php if($election_details['status'] == 'published' || $election_details['status'] == 'expired') echo 'active' ?>" id="stats" data-toggle="tab" href="#tab2"><span class="fa fa-chart-bar fa-lg"></span> Election Statistics</a>
                                  </li>
                             </ul>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="tab-content">
                  <div class="tab-pane <?php if($election_details['status'] == 'pending') echo 'active' ?>" id="tab1">

                    <div class="row">
                        
                        <div class="col-md-7">
                          <div class="col-md-12">
                            <h5 class="text-left"><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_data"><span class="fa fa-plus fa-lg"></span> Add</button></h5> 
                          </div>
                          <div class="col-md-12" id="load_election_data"></div>
                        </div>
                        <div class="col-md-5">
                            
                          <div class="col-md-12">
                              <h5 class="text-left"><span class="fa fa-sitemap fa-lg"></span> Manage PartyList 
                                <button data-toggle="modal" data-target="#add_partylist" class="btn btn-sm btn-primary float-right"> <span class="fa fa-plus fa-lg"></span> Add</button></h5> 
                              <div class="pipeline white lined-primary">
                                 <div class="panel-body">
                                    <div style="overflow-x:auto;">
                                      <div class="table table-reponsive" >
                                        <table class="table table-bordered" id="load_partylist">
                                          
                                        </table>
                                      </div>
                                    </div>
                                 </div>
                              </div>
                          </div>

                          <div class="col-md-12">
                              <h5 class="text-left"><span class="fa fa-user fa-lg"></span> Manage Position 
                                <button data-toggle="modal" data-target="#add_position" class="btn btn-sm btn-primary float-right"> <span class="fa fa-plus fa-lg"></span> Add</button></h5> 
                              <div class="pipeline white lined-primary">
                                 <div class="panel-body">
                                    <div style="overflow-x:auto;">
                                      <div class="table table-reponsive" >
                                        <table class="table table-bordered" id="load_positions">
                                          
                                        </table>
                                      </div>
                                    </div>
                                 </div>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="tab-pane <?php if($election_details['status'] == 'published' || $election_details['status'] == 'expired') echo 'active' ?>" id="tab2">

                    <div class="col-md-12">
                        
                        <?php 

                           if($date_now == $date_start){ ?>

                              <h2 class="panel-title text-center">

                                 <div id="timer_value">
                                  <span class="fa fa-clock fa-lg"></span> &nbsp;
                                    <span id="hour_timer"> 0 </span>
                                    <span style="font-size:14px;"><?php echo get_phrase('hour');?> </span>
                                    <span class="blink_text">:</span>
                                    <span id="minute_timer"> 0 </span>
                                    <span style="font-size:14px;"><?php echo get_phrase('minute');?> </span>
                                    <span class="blink_text">:</span>
                                    <span id="second_timer"> 0 </span>
                                    <span style="font-size:14px;"><?php echo get_phrase('second');?> </span>
                                 </div>
                              </h2>

                           <?php }else{ ?>

                              <h1 class="text-center"><span class="fa fa-calendar fa-lg"></span> Schedule: <br> 

                                 <?php 

                                      $start_date = date('M d, Y h:i A',strtotime($election_details['date_start'])); 
                                      $end_date = date('M d, Y h:i A',strtotime($election_details['date_end']));

                                      echo $start_date.' to '. $end_date;

                                 ?>

                              </h1>

                           <?php } ?>
                        
                        
                    </div>
                    <div class="col-md-12" id="load_election_stat"></div>
                  </div>
                 </div>
              </div>
            </div>
         </div>
      </div>
   </div>
      <?php endif;?>
</div>

<a class="back-to-top" href="javascript:void(0);">
<img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
</a>

<div class="modal fade" id="add_data" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="crearadmin" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document" style="width: 70%;">
      <div class="modal-content" style="margin-top:0px;">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-body">
            <div class="modal-header" style="background-color:#00579c">
               <h6 class="title" id="title" style="color:white"><?php echo get_phrase('Add Election Data');?></h6>
            </div>
            <div class="ui-block-content">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <div class="col-sm-12">
                              <input type="hidden" name="election_id" id="election_id" value="<?php echo $election_id; ?>">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-form-label" for=""><?php echo get_phrase('select_position');?></label>
                                       <div class="select">
                                          <select onchange="load_candidate_modal();" id="position_id" required="" name="position_id">
                                             

                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-form-label" for=""><?php echo get_phrase('select_partylist');?></label>
                                       <div class="select">
                                          <select id="party_list" required="" name="party_list">
                                             
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <div class="form-group with-button">
                                          <input class="form-control js-user-se arch" oninput="search_candidate();" onchange="search_candidate();" placeholder="Search student..." type="text" id="txt_search"  name="txt_search" required>
                                          <button ><i class="picons-thin-icon-thin-0033_search_find_zoom"></i></button>
                                      </div>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                   <div class="row" id="show_students">
                                     
                                   </div>
                                 </div>
                                
                                 <div class="col-md-12" id="added_list">
                                   
                                 </div>

                              </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="add_partylist" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="crearadmin" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document" style="width: 70%;">
      <div class="modal-content" style="margin-top:0px;">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-body">
            <div class="modal-header" style="background-color:#00579c">
               <h6 class="title" id="title" style="color:white">Add Partylist</h6>
            </div>
            <div class="ui-block-content">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <div class="col-sm-12">

                            <form enctype="multipart/form-data" id="form_partylist" onsubmit="event.preventDefault(); save_update_partlist();">

                              <input type="hidden" name="elect_id" id="elect_id" value="<?php echo $election_id; ?>">
                              <input type="hidden" name="party_list_id" id="party_list_id">
                              <div class="form-group">
                                 <label class="col-form-label" for="">Title:</label>
                                  <input class="form-control" type="text" id="partylist_name"  name="partylist_name" required>
                              </div>
                              <div class="form-group">
                                 <label class="col-form-label" for="">Color:</label>
                                  <input class="form-control" onchange="change_text_color();" oninput="change_text_color();" type="color" id="party_color"  name="party_color" required>
                              </div>
                              <div class="form-group">
                                  <button type="submit" id="btn_save_p" class="btn btn-success btn-block">Save</button>
                               </div>
                            </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="add_position" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="crearadmin" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document" style="width: 70%;">
      <div class="modal-content" style="margin-top:0px;">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-body">
            <div class="modal-header" style="background-color:#00579c">
               <h6 class="title" id="title" style="color:white">Add Position</h6>
            </div>
            <div class="ui-block-content">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <div class="col-sm-12">
                            <form enctype="multipart/form-data" id="form_position" onsubmit="event.preventDefault(); save_update_position();">
                              <input type="hidden" name="p_id" id="p_id">
                              <div class="form-group">
                                 <label class="col-form-label" for="">Position:</label>
                                  <input class="form-control" type="text" id="position"  name="position" required>
                              </div>
                              <div class="form-group">
                                  <button type="submit" id="btn_save_po" class="btn btn-success btn-block">Save</button>
                               </div>
                            </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">

   function publish_election(election_id) {

      swal({
          title: "Are you sure ?",
          text: "You want to publish this election?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#5bc0de",
         confirmButtonText: "Yes, publish",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
   
         $.ajax({
         url:'<?php echo base_url();?>admin/publish_election',
         method:'POST',
         data:{election_id:election_id},
         cache:false,
         success:function(data)
         {
            if(data == 1){
               window.location.href = '<?php echo base_url();?>admin/electionroom/' + election_id;
            }
         }
       });
        
   
       } 
       else 
       {
   
       }
   
     });

       

   }

  function cmb_partylist(){



    var election_id = $('#election_id').val();
    $.ajax({
 
      url:'<?php echo base_url();?>admin/cmb_partylist',
      method:'POST',
      data:{election_id:election_id},
      cache:false,
      success:function(data)
      {
        $('#party_list').html(data);
      }
    });

  }

  cmb_partylist();

  function cmb_positions(){

    $.ajax({
 
      url:'<?php echo base_url();?>admin/cmb_positions',
      method:'POST',
      cache:false,
      success:function(data)
      {
        $('#position_id').html(data);
      }
    });

  }

  cmb_positions();

  $( document ).ready(function() {
    $('#add_partylist').on('hidden.bs.modal', function () {
      $(this).find('form').trigger('reset');
      $('#party_color').css('background','transparent');
    })

    $('#add_position').on('hidden.bs.modal', function () {
      $(this).find('form').trigger('reset');
    })
  });

  <?php 

  if($election_details['status'] == 'published'){ ?>
    $('#manage').prop('disabled',true);
    $('#stats').prop('disabled',false);
  <?php }else{ ?>
    $('#manage').prop('disabled',false);
    $('#stats').prop('disabled',true);
  <?php } ?>

  function load_election_stat(){
    var election_id = $('#election_id').val();
      $.ajax({
   
        url:'<?php echo base_url();?>admin/load_election_stat',
        method:'POST',
        data:{election_id:election_id},
        cache:false,
        success:function(data)
        {
          if(data == 404){
            $('#load_election_stat').html('<div class="col-md-12 text-center">No data Found!</div>');
          }else{
            $('#load_election_stat').html(data);
          }
        }
      });
    
  }

  load_election_stat();

  var election_timer = setInterval(function () {
    load_election_stat();
  }, 1000);
  

  var election_checker = setInterval(function () {
    check_election_status();
  }, 1000);


  function check_election_status(){
    var election_id = $('#election_id').val();
      $.ajax({
   
        url:'<?php echo base_url();?>admin/check_election_status',
        method:'POST',
        data:{election_id:election_id},
        cache:false,
        success:function(data)
        {
          if(data == 1){
            //election open start timer

          }else{
            //election open start timer
            clearTimeout(election_timer);
            clearTimeout(election_checker);
          } 
        }
      });
    
  }

  function load_election_details(){
    var election_id = $('#election_id').val();
      $.ajax({
   
        url:'<?php echo base_url();?>admin/load_election_details',
        method:'POST',
        data:{election_id:election_id},
        cache:false,
        beforeSend:function(){
          $('#load_election_data').html('<br><div class="col-md-12 text-center">Loading Data...</div>');
        },
        success:function(data)
        {
          if(data == 404){
            $('#load_election_data').html('<div class="col-md-12 text-center">No data Found!</div>');
          }else{
            $('#load_election_data').html(data);
          }
        }
      });
    
  }

  load_election_details();

  function search_candidate(){

    var txt_search = $('#txt_search').val();
    var election_id = $('#election_id').val();

    if(txt_search.length > 2){
      $.ajax({
   
        url:'<?php echo base_url();?>admin/show_candidate',
        method:'POST',
        data:{txt_search:txt_search,election_id:election_id},
        cache:false,
        success:function(data)
        {
   
          if(data == 404){
            $('#show_students').html('<div class="col-md-12 text-center">No data Found!</div>');
          }else{
            $('#show_students').html(data);
          }
   
        }
   
      });
    
    }

  }

  function add_candidate(student_id){
    
    var election_id = $('#election_id').val();
    var student_id = student_id;
    var position_id = $('#position_id').val();
    var party_list = $('#party_list').val();
    var mydata = 'election_id=' + election_id + '&student_id=' + student_id + '&position_id=' + position_id + '&party_list=' + party_list;

    if(party_list == ''){
      swal('info','Please Select Party List','info');
      $('#party_list').focus();
    }else{

      $.ajax({
   
        url:'<?php echo base_url();?>admin/add_candidate',
        method:'POST',
        data:mydata,
        cache:false,
        success:function(data)
        {
   
          if(data == 1){
           
           $('#party_list').val('');
           $('#txt_search').val('');
           $('#show_students').html('');
           $('#txt_search').focus();
           load_candidate_modal();
           load_election_details();
            //window.location.href = '<?php echo base_url();?>admin/electionroom/' + election_id;
   
          }else if(data == 404){
   
            swal("LMS", "Student Already Exists.", "info");
   
          }
          else{
   
             swal("LMS", "Error on adding data", "error");
   
          } 
   
        }
   
    });

    }

  }

  function load_candidate_modal(){

    var election_id = $('#election_id').val();
    var position_id = $('#position_id').val();

    $.ajax({
   
        url:'<?php echo base_url();?>admin/load_added_candidate',
        method:'POST',
        data:{election_id:election_id,position_id:position_id},
        cache:false,
        success:function(data)
        {
          
          $('#added_list').html(data);
          
        }
   
      });

  }

  function remove_candidate(id){

    var election_id = $('#election_id').val();
    
    $.ajax({
      url:"<?php echo base_url();?>admin/remove_candidate/",
      type:'POST',
      data:{id:id},
      success:function(result)
      {
        if(result == 0){
          //alert('cannot be delete');
          swal('info','You cannot delete this record it has existing related information.','info');
        }else{
            load_candidate_modal();
            load_election_details();
        }
      }
    });

  }

  function load_partylist(){

    var election_id = $('#election_id').val();
    
    $.ajax({
      url:"<?php echo base_url();?>admin/load_partylist",
      type:'POST',
      data:{election_id:election_id},
      success:function(result)
      {
        $('#load_partylist').html(result);
      }
    });

  }

  load_partylist();
  
  function save_update_partlist(){

    $.ajax({
      url:"<?php echo base_url();?>admin/save_update_partlist",
      type:'POST',
      data:$("form#form_partylist").serialize(),
      beforeSend:function(){
        $('#btn_save_p').text('Saving...');
        $('#btn_save_p').prop('disabled',true);
      },
      success:function(result)
      {
        $('#btn_save_p').text('Save');
        $('#btn_save_p').prop('disabled',false);
        $('#add_partylist').modal('hide');
        load_partylist();
        load_election_details();
        cmb_partylist();
      }
    });

  }

  function change_text_color(){

    var color_ = $('#party_color').val();
    $('#party_color').css('background',''+color_+'');

  }

  function delete_pl(id){
    $.ajax({
      url:"<?php echo base_url();?>admin/delete_pl/",
      type:'POST',
      data:{id:id},
      success:function(result)
      {
        if(result == 0){
          //alert('cannot be delete');
          swal('info','You cannot delete this record it has existing related information.','info');
        }else{
            load_election_details();
            load_partylist();
            cmb_partylist();
        }
      }
    });
  }

  function edit_pl(id,name,color_){
    $('#party_list_id').val(id);
    $('#party_color').val(color_);
    $('#partylist_name').val(name);
    $('#party_color').css('background',''+color_+'');
    $('#add_partylist').modal('show');
  }

  function load_positions(){
    $.ajax({
      url:"<?php echo base_url();?>admin/load_positions",
      type:'POST',
      success:function(result)
      {
        $('#load_positions').html(result);
      }
    });
  }

  load_positions();

  function save_update_position(){

    $.ajax({
      url:"<?php echo base_url();?>admin/save_update_position",
      type:'POST',
      data:$("form#form_position").serialize(),
      beforeSend:function(){
        $('#btn_save_po').text('Saving...');
        $('#btn_save_po').prop('disabled',true);
      },
      success:function(result)
      {
        $('#btn_save_po').text('Save');
        $('#btn_save_po').prop('disabled',false);
        $('#add_position').modal('hide');
        load_positions();
        load_election_details();
        cmb_positions();
      }
    });
  }

  function delete_po(id){
    $.ajax({
      url:"<?php echo base_url();?>admin/delete_po/",
      type:'POST',
      data:{id:id},
      success:function(result)
      {
        if(result == 0){
          //alert('cannot be delete');
          swal('info','You cannot delete this record it has existing related information.','info');
        }else{
            load_election_details();
            load_positions();
            cmb_positions();
        }
      }
    });
  }

  function edit_po(id,name){
    $('#p_id').val(id);
    $('#position').val(name);
    $('#add_position').modal('show');
  }

</script>

<script type="text/javascript">
   var blank_student_entry = '';
    $(document).ready(function() 
    {
        blank_student_entry = $('#election_entry').html();
        for ($i = 1; $i < 1; $i++) 
        {
          $("#student_entry").append(blank_student_entry);
        }
    });
    function append_election_entry()
    {
      $("#election_entry_append").append(blank_student_entry);
   
    }
    function deleteParentElement(n)
    {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    }
</script>
<script type="text/javascript">
   function add_election_data(){
   
    var election_id = $('#election_id').val();
   
    $.ajax({
   
        url:'<?php echo base_url();?>admin/add_election_data',
        method:'POST',
        data:$("form#form_data").serialize(),
        cache:false,
        success:function(data)
        {
   
          if(data == 1){
   
            window.location.href = '<?php echo base_url();?>admin/electionroom/' + election_id;
   
          }else if(data == 404){
   
            swal("LMS", "Position Already Exists", "info");
   
          }
          else{
   
             swal("LMS", "Error on adding data", "error");
   
          } 
   
        }
   
      });
   
   }
   
   function delete_data2(id) {
   
    var election_id = $('#election_id').val();
   
     swal({
          title: "Are you sure ?",
          text: "You want to delete candidate?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#e65252",
         confirmButtonText: "Yes, delete",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
   
        $.ajax({
        
            url:"<?php echo base_url();?>admin/delete_election_data/",
            type:'POST',
            data:{id:id},
            success:function(result)
            {
   
              if(result == 0){
                //alert('cannot be delete');
                swal('info','You cannot delete this record it has existing related information.','info');
   
              }else{
   
                  window.location.href = '<?php echo base_url();?>admin/electionroom/' + election_id;
   
              }
   
            }
   
          });
   
       } 
       else 
       {
   
       }
   
     });
   
   }
     
</script>

<script type="text/javascript">
   var timer_starting_hour   = <?php echo $total_hour;?>;
   document.getElementById("hour_timer").innerHTML = timer_starting_hour;
   var timer_starting_minute   = <?php echo $total_minute;?>;
   document.getElementById("minute_timer").innerHTML = timer_starting_minute;
   var timer_starting_second   = <?php echo $total_second;?>;
   document.getElementById("second_timer").innerHTML = timer_starting_second;
   var timer = timer_starting_second;
   var mytimer = setInterval(function () {run_timer()}, 1000);
   function run_timer() 
   {
     if (timer == 0 && timer_starting_minute == 0 && timer_starting_hour == 0) {
           
         timer--;
         window.location.href = '<?php echo base_url();?>student/panel/';
         //$('#btn_save_vote').click();
     }
     else {
       timer--;
       if (timer < 0)
       {
         timer = 59;
         timer_starting_minute--;
         if (timer_starting_minute >= 0) {
           document.getElementById("minute_timer").innerHTML = timer_starting_minute;
         }
       }
       if (timer_starting_minute < 0)
       {
         timer_starting_minute = 59;
         document.getElementById("minute_timer").innerHTML = timer_starting_minute;
         timer_starting_hour--;
         document.getElementById("hour_timer").innerHTML = timer_starting_hour;
       }
       document.getElementById("second_timer").innerHTML = timer;
     }
   }
</script>

<style media="screen">
   .containers {
   display: block;
   position: relative;
   padding-left: 18px;
   margin-bottom: 18px;
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
   height: 15px;
   width: 15px;
   background-color: #eee;
   border:1px solid;
   outline-width: thick;
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