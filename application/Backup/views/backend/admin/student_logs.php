<?php
     $student_name = $this->crud_model->get_name('student', $param2);
?>
<div class="modal-body">

    <div class="modal-header" style="background-color:#00579c">

        <h5 class="title" style="color:white">Student Logs of <?php echo $student_name;?></h5>

    </div>

    <div class="ui-block-content">

        <div class="row">

            <div class="col-md-12">
                <?php// echo $param2 . ' - '.$param3 . '-' . $param4  ?>
                 
                <table class="table table-lightborder table-bordered">

                  <thead>

                    <tr style="background:#0061da; color:#fff">

                      <th><h5 style="color:#fff"><b>Date : <?php echo date('F d,Y',strtotime($param3)) ?></b></h5></th>
                      <th><h5 style="color:#fff">Subject</b></h5></th>
                      <th><h5 style="color:#fff">Action</b></h5></th>
                     
                    </tr>

                  </thead>

                  <tbody>

                    <?php

                        $count = 1;
                    
                        $attendance_of_students = $this->db->get_where('tbl_attendance_logs', array('student_id' => $param2,'date_trans' => $param3,'am_pm' => $param4))->result_array();
                    
                        foreach ($attendance_of_students as $row):
                    ?>
                    <tr>

                        <td> 
                            <b><?php echo $count++;?>.) <?php echo date('h:i A',strtotime($row['datetime_log']))?></b>
                        </td>
                        <td><b>
                            <?php 
                         $subject_id = $row['subject_id'];

                            if($subject_id == ''){
                                echo '';
                            }else{
                                $subject = $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->name;
                                echo $subject;
                            }

                            ?>
                            </b>
                        </td>
                        <td> 
                            <b><?php echo $row['form']?></b>
                        </td>

                    </tr>

                    <?php endforeach;?>

                  </tbody>

                </table>

            </div>

        </div>

    </div>

</div>