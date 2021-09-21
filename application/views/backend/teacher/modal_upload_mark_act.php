<?php  
  $ex = explode('-', $param2);

  $exam = $this->db->query("SELECT b.`title`, a.`mark` FROM deliveries a LEFT JOIN homework b ON a.`homework_code` = b.`homework_code`  WHERE a.`student_id` = '$ex[0]' AND a.`subject_id` = '$ex[1]' AND b.`category` = '$ex[2]' AND b.`activity_type` = '$ex[3]' AND b.`semester_id` = '$ex[4]' GROUP BY a.`student_id`")->result_array();

?>  
<div class="modal-body">
  <div class="modal-header" style="background-color:#00579c">
    <h6 class="title" style="color:white"><?php echo get_phrase();?></h6>
  </div>
  <div class="ui-block-content">
    <div class="table-responsive">
      <table class="table table-lightborder table-striped">
        <thead class="table-dark">
          <tr>
            <th><?php echo get_phrase('activity_name');?></th>
            <th><?php echo get_phrase('mark_points');?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($exam as $row): ?>
            <tr>
              <td><?php echo $row['title']; ?></td>
              <td><?php echo $row['mark']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>      
  </div>
 </div>