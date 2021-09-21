<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php

  $date_today = date('Y-m-d');

  $online_exam_today = $this->db->query("SELECT * FROM online_exam WHERE examdate = '$date_today' and status = 'published' order by time_start ASC");
  $total_attendees = $this->db->query("SELECT t1.`status`, DATE(FROM_UNIXTIME(t1.`exam_started_timestamp`)) AS date_ FROM online_exam_result t1 WHERE DATE(FROM_UNIXTIME(t1.`exam_started_timestamp`)) = '$date_today' and t1.status = 'attended'");

?>
<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>admin/examroom/<?php echo $online_exam_id;?>/"><i class="os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span> Online Exam For Today</span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
                <div class="col-sm-12">
                  <div class="pipeline white lined-primary">
                     <div class="pipeline-header">
                        <h4>
                           <span class="fa fa-list-ol"></span> List of Examination for today (<?php echo date('Y-m-d'); ?>)
                        </h4>
                     </div>
                     <div class="row">
                        <div class="col-sm-10">
                           <div class="form-group">
                              <input class="form-control" style="height: 40px;" id="filter" placeholder="Search <?php echo $online_exam_today->num_rows(); ?> Exams... " type="text" name="search_key">
                           </div>
                        </div>
                        <div class="col-sm-2">  
                           <button class="btn btn-primary btn-block"><span class="fa fa-users"></span> Attendees - <?php echo $total_attendees->num_rows(); ?> </button>
                        </div>
                     </div>
                     <div class="table-responsive">
                        <table class="table table-lightborder table-striped table-hover">
                           <thead>
                              <tr>
                                 <th>Title</th>
                                 <th>Class-Section</th>
                                 <th>Subject</th>
                                 <th>Schedule</th>
                                 <th>Examiners</th>
                                 <th>Attended</th>
                                 <th>Option</th>
                              </tr>
                           </thead>
                           <tbody id="results">
                              <?php $counter = 0;  foreach ($online_exam_today->result_array() as $row): $counter++; 

                                    $subject_id = $row['subject_id'];
                                    $class_id = $row['class_id'];
                                    $section_id = $row['section_id'];
                                    $exam_id = $row['online_exam_id'];

                                    $class = $this->db->query("SELECT name from class where class_id = '$class_id'")->row()->name;
                                    $section = $this->db->query("SELECT name from section where section_id = '$section_id'")->row()->name;

                                    $subject = $this->db->query("SELECT name from subject where subject_id = '$subject_id'")->row()->name;

                                    $failed = $this->db->query("SELECT student_id from online_exam_result where online_exam_id = '$exam_id' and result = 'fail'")->num_rows();

                                    $passed = $this->db->query("SELECT student_id from online_exam_result where online_exam_id = '$exam_id' and result = 'pass'")->num_rows();

                                    $attended = $this->db->query("SELECT student_id from online_exam_result where online_exam_id = '$exam_id' and status = 'attended'")->num_rows();

                                    $total_students = $this->db->query("SELECT t1.student_id FROM enroll t1 
                                    LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id`
                                    where t1.class_id = '$class_id' and t1.section_id = '$section_id' and t1.year = '$running_year'
                                    ORDER BY t2.`last_name` ASC")->num_rows();

                                    $total_examiner = $total_students - $failed - $passed - $attended;

                              ?>
                              <tr>
                                <td><?php echo $counter.').'; ?>&nbsp;<?php echo $row['title']; ?></td>
                                <td><?php echo $class.' - ' . $section; ?></td>
                                <td><?php echo $subject; ?></td>
                                <td><span class="badge badge-success"><span class="fa fa-clock"></span> <?php echo date('g:i A', strtotime($row['time_start'])) . ' - ' . date('g:i A', strtotime($row['time_end'])); ?></td>
                                <td class="text-center">
                                  <span class="badge badge-warning" title="Total Examiners"> <span class="fa fa-users fa-lg"></span> <?php echo $total_examiner;?></span>
                                </td>
                                <td class="text-center">

                                  <?php 

                                   $date_now = date('Y-m-d');
                                   $time_now = date('H:i:s');
                             
                                   if($date_now = $row['examdate'] && $time_now >= $row['time_start'] && $time_now <= $row['time_end']){ ?>
                             
                                      <span class="badge badge-primary" title="Exam Attendees"> <span class="fa fa-pencil-alt fa-lg"></span> <?php echo $attended;?></span>

                                   <?php }else{ ?>
                              
                                    <span class="badge badge-danger" title="Taken but not submitted"> <span class="fa fa-times fa-lg"></span> <?php echo $attended;?></span>
                             
                                   <?php } ?>
                                 
                                </td>
                                <td><a class="btn btn-primary btn-sm" href="<?php echo base_url().'admin/exam_results/'.$row['online_exam_id']; ?>" target="_blank"> <span class="fa fa-eye fa-lg"></span> View Results </a></td>
                              </tr>
                              <?php endforeach; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <a class="back-to-top" href="javascript:void(0);">
   <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
   </a>
</div>

<script type="text/javascript">
  
  window.onload=function(){      
    $("#filter").keyup(function() {
    
      var filter = $(this).val(),
        count = 0;
    
      $('#results tr').each(function() {
    
        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
          $(this).hide();
    
        } else {
          $(this).show();
          count++;
        }
      });
    });
    }

</script>