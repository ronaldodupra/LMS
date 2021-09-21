<?php
     $student_name = $this->crud_model->get_name('student', $param2);
?>
<div class="modal-body">

    <div class="modal-header" style="background-color:#00579c">

        <h5 class="title" style="color:white">Retake information of <?php echo $student_name;?></h5>

    </div>

    <div class="ui-block-content">

        <div class="row">

            <div class="col-md-12">
                <?php// echo $param2 . ' - '.$param3 . '-' . $param4  ?>
                 
                <table class="table table-lightborder table-bordered">

                  <thead>

                    <tr style="background:#0061da; color:#fff">
                      <th style="width: 5%;"><h5 style="color:#fff">#</h5></th>
                      <th style="width: 10%;"><h5 style="color:#fff">Points</h5></th>
                      <th><h5 style="color:#fff">Date Exam</h5></th>
                     
                    </tr>

                  </thead>

                  <tbody>

                    <?php

                        $count = 1;
                    
                        $exam_info = $this->db->get_where('tbl_exam_quiz_retake_info', array('student_id' => $param2,'type' => $param4,'online_exam_quiz_id' => $param3))->result_array();
                    
                        foreach ($exam_info as $row):
                    ?>
                    <tr>

                        <td> 
                            <b><?php echo $count++;?>.)</b>
                        </td>
                        <td><?php echo number_format($row['points']); ?></td>
                        
                        <td>
                        
                        <?php if($row['date_start'] == ''){
                            $date_start = '';
                        }else{
                            $date_start = $row['date_start'];
                        }
                        if($row['date_end'] == ''){
                            $date_end = '';
                        }else{
                            $date_end = $row['date_end'];
                        }
                        echo date('m/d/Y h:i A', $date_start).' - '.date('m/d/Y h:i A', $date_end);?>
                            
                        </td>
                        
                    </tr>

                    <?php endforeach;?>

                  </tbody>

                </table>

            </div>

        </div>

    </div>

</div>