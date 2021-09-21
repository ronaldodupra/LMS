<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h5 class="title" style="color:white">List of Attendees</h5>
    </div>
    <div class="ui-block-content">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-lightborder table-bordered">
                  <thead>
                    <tr style="background:#0061da; color:#fff">
                      <th><h5 style="color:#fff">Student</b></h5></th>
                      <th><h5 style="color:#fff">DateTime</h5></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $counter = 1;
                        $attendees = $this->db->get_where('tbl_attendance_logs', array('subject_id' => $param2,'live_class_id' => $param3))->result_array();
                        foreach ($attendees as $row):?>
                    <tr>
                        <td><?php echo $counter++;?>.) <?php echo $this->crud_model->get_name('student', $row['student_id']); ?></td>
                        <td> 
                            <b><?php echo date('Y-m-d h:i A',strtotime($row['datetime_log']))?></b>
                        </td>
                    </tr>
                    <?php endforeach;?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>