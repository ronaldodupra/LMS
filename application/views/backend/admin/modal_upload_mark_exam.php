<?php  
  $ex = explode('-', $param2);

  $exam = $this->db->query("SELECT b.`online_exam_id`, a.`student_id`, b.`title`, a.`obtained_mark`, a.`essay_mark`, a.`result` FROM online_exam_result a LEFT JOIN online_exam b ON a.`online_exam_id` = b.`online_exam_id` WHERE b.`subject_id` = '$ex[1]' AND a.`student_id` = '$ex[0]' AND b.`semester_id` = '$ex[2]'")->result_array();

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
            <th><?php echo get_phrase('exam_name');?></th>
            <th><?php echo get_phrase('points_obtained');?></th>
            <th><?php echo get_phrase('status');?></th>
          </tr>
        </thead>
        <tbody>
          
            <?php 
              foreach ($exam as $row):
                $total_mark = $this->crud_model->get_total_mark($row['online_exam_id']);
            ?>
            <tr>
              <td><?php echo $row['title']?></td>
              <td><?php echo $row['obtained_mark'] + $row['essay_mark'].' / '. $total_mark; ?></td>
              <td>
                <?php if($row['result'] == 'pass'):?>
                  <span class='badge badge-success'><?php echo get_phrase('passed'); ?></span>
                <?php else: ?>
                  <span class='badge badge-danger'><?php echo get_phrase('failed'); ?></span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>      
  </div>
 </div>