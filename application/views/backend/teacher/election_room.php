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
                        <h5 class="panel-title">Election Details</h5>
                         <input type="hidden" name="election_id" id="election_id" value="<?php echo $election_id; ?>">
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
                                  <a class="navs-links <?php if($election_details['status'] == 'published' || $election_details['status'] == 'expired') echo 'active' ?>" id="stats" data-toggle="tab" href="#tab2"><span class="fa fa-chart-bar fa-lg"></span> Election Statistics</a>
                               </li>
                             </ul>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="tab-content">
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

<script type="text/javascript">

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
   
        url:'<?php echo base_url();?>teacher/load_election_stat',
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
   
        url:'<?php echo base_url();?>teacher/check_election_status',
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
   
        url:'<?php echo base_url();?>teacher/load_election_details',
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