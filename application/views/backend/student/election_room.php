<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php
   $election_details = $this->db->get_where('tbl_election', array('id' => $election_id))->row_array(); 
    
   $positions = $this->db->query("SELECT * from tbl_election_data where election_id = '$election_id' group by position order by id asc");
 
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
                        <h5 class="panel-title"><?php echo get_phrase('election_details');?> (<?php echo $election_details['title']; ?>)
                           <a href="<?php echo base_url();?>student/manage_election/" class="btn btn-sm btn-primary float-right"> <span class="fa fa-arrow-left"></span> Back</a>
                        </h5>
                     </div>
                     <div class="panel-body">
                        <div style="overflow-x:auto;">
                           <table  class="table table-bordered">
                              <tbody>
                                 <tr>
                                    <td><b><?php echo get_phrase('Schedule:');?></b>
                                       <?php 
                                          $start_date = date('Y/m/d h:i A',strtotime($election_details['date_start']));
                                          $end_date = date('Y/m/d h:i A',strtotime($election_details['date_end']));
                                          ?>
                                       <?php echo $start_date; ?> - <?php echo $end_date; ?>
                                    </td>
                                    <td style="width: 50%">
                                       <strong class="text-danger">Please Select 1 candidate per position.
                                       </strong>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="pipeline white lined-primary">
                     <div class="panel-heading">
                        <h4 class="panel-title text-center">
                           <span class="fa fa-chart-bar"> </span> <?php echo get_phrase('Voting Form');?>
                           <div class="mt-3" style="height:20px; font-size:25px; font-weight:200; color: #212121;" id="timer_value">
                              <span id="hour_timer"> 0 </span>
                              <span style="font-size:14px;"><?php echo get_phrase('hour');?> </span>
                              <span class="blink_text">:</span>
                              <span id="minute_timer"> 0 </span>
                              <span style="font-size:14px;"><?php echo get_phrase('minute');?> </span>
                              <span class="blink_text">:</span>
                              <span id="second_timer"> 0 </span>
                              <span style="font-size:14px;"><?php echo get_phrase('second');?> </span>
                           </div>
                        </h4>
                        <hr>
                        <marquee><b class="text-danger">Vote Wisely !!!<b></marquee>
                     </div>
                     <div class="panel-body">
                        <br>
                        <?php 
                           if($positions->num_rows() > 0){ 
                              foreach ($positions->result_array() as $row): $counter++; 
                           
                               ?>
                                <div class="col-md-12">
                                   <div class="pipeline white lined-primary">
                                      <div class="panel-heading">
                                         <h5 class="panel-title">
                                            <b><?php 
                                               $position_id = $row['position'];
                                               $position = $this->db->query("SELECT name from tbl_election_position where id = '$position_id'")->row()->name;?>
                                              For the position of <strong><?php echo $position; ?></strong>    
                                              </b>
                                            <button class="btn btn-sm btn-danger float-right"> Please select 1 candidate </button>
                                         </h5>
                                      </div>
                                      <div class="panel-body">
                                         <hr>
                                        
                                         <ul class="widget w-friend-pages-added notification-list friend-requests">
                                         <?php   
                                            $candidates = $this->db->query("SELECT * from tbl_election_data where position = '$position_id' and election_id = '$election_id' order by id asc");
                                            $counter2 = 0;
                                            foreach ($candidates->result_array() as $row2): $counter2++; 
                                              
                                              $party_list = $this->db->get_where('tbl_election_partylist', array('id' => $row2['party_list']));

                                              if($party_list->num_rows() > 0){
                                                  $party_list_name = strtoupper($party_list->row()->name);
                                                  $party_list_color = $party_list->row()->party_color;
                                              }else{
                                                  $party_list_name = 'INDEPENDENT';
                                                  $party_list_color = '#ffffff';
                                              }

                                              $hexRGB = $party_list_color;
                                              if(hexdec(substr($hexRGB,0,2))+hexdec(substr($hexRGB,2,2))+hexdec(substr($hexRGB,4,2))> 381){
                                                  //bright color
                                                  $color_ = '#000000';
                                              }else{
                                                  //dark color
                                                  $color_ = '#ffffff';
                                              }
                                              ?>

                                              <li class="inline-items" style="height: 10%;">
                                                   <div class="author-thumb">
                                                      <img src="<?php echo $this->crud_model->get_image_url('student', $row2['candidates']);?>" width="35px">
                                                   </div>
                                                   <div class="notification-event">
                                                       <span class="radio">
                                                       <h6><label >
                                                          <input type="radio" id="answer" name="<?php echo $row['id'];?>" value="<?php echo $row2['id'];?>"><span class="circle task"></span>
                                                          <span class="check"></span>
                                                          <?php echo $counter2.'). '. $this->crud_model->get_name('student', $row2['candidates'])?><br>
                                                          <b class="badge" style="background: <?php echo $party_list_color; ?>; color: <?php echo $color_; ?>;"><?php echo $party_list_name ?></b>
                                                          </label>
                                                       </h6>
                                                    </span>
                                                   </div>                                                   
                                              </li>
                                         <?php endforeach; ?>
                                      </ul>

                                      </div>
                                   </div>
                                </div>
                        <?php endforeach; ?>
                        <?php }else{ ?>
                        <h1> No data found! </h1>
                        <?php } ?> 
                     </div>
                     <div class="col-md-12">
                        <button class="btn btn-primary btn-lg btn-block" id="btn_save_vote"> Save </button>
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
</div>
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
<script type="text/javascript">
   $(document).ready(function() {
   
     $("#btn_save_vote").click(function(){
      
      var election_id = <?php echo $election_id;?>;
   
      var selectedVal = "";
      var selected = $("input[type='radio'][class='task']:checked");
      if (selected.length > 0) {
          selectedVal = selected.val();
      }
   
         $("input[type=radio]:checked").each(function() {
             var vote = $(this).val();
             var election_data_id = $(this).attr("name");
   
             $.ajax({
         
         url:"<?php echo base_url();?>student/save_vote/",
         type:'POST',
         data:{vote:vote,election_data_id:election_data_id,election_id:election_id},
         beforeSend:function(){
           $('#btn_save_vote').html('Saving data...');
           $('#btn_save_vote').prop('disabled',true);
          }, 
         success:function(result)
         {
   
            if(result == 1){
              // const Toast = Swal.mixin({
              //  toast: true,
              //  position: 'top-end',
              //  showConfirmButton: false,
              //  timer: 8000
              //  }); 
              //  Toast.fire({
              //  type: 'success',
              //  title: 'Vote successfully saved.'
              //  });
   
               window.location.href = '<?php echo base_url();?>student/panel/';
   
             }else{
              const Toast = Swal.mixin({
               toast: true,
               position: 'top-end',
               showConfirmButton: false,
               timer: 8000
               }); 
               Toast.fire({
               type: 'error',
               title: 'Error on saving data'
               });
             }
             
             
         }
       });
   
   
         });
   
     });
   
   });
   
</script>