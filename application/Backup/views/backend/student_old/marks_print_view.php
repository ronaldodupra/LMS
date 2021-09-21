 <?php $ex = explode('-', base64_decode($student_id));?>
 <?php
	$class_name		 	= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
	$exam_name  		= 	$this->db->get_where('exam' , array('exam_id' => $ex[1]))->row()->name;
	$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
    $system_email       =   $this->db->get_where('settings' , array('type'=>'system_email'))->row()->description;
    $running_year       =   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
    $phone       =   $this->db->get_where('settings' , array('type'=>'phone'))->row()->description;
?>
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>style/cms/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>style/cms/css/main.css?version=3.3" rel="stylesheet">
<style>
* {
    -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
    color-adjust: exact !important;                 /*Firefox*/ 
}
</style>
<div class="content-w">
<div class="content-i">
    <div class="content-box">
   
      <div class="element-wrapper">
      <div class="rcard-wy" id="print_area">
        <div class="rcard-w">
          <div class="infos">
            <div class="info-1">
              <div class="rcard-logo-w">
                <img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>">
              </div>
              <div class="company-name"><?php echo $system_name;?></div>
              <div class="company-address"><?php echo get_phrase('marks');?></div>
            </div>
            <div class="info-2">
            <div class="rcard-profile">
            <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $this->session->userdata('login_user_id'));?>">
            </div>
              <div class="company-name"><?php echo $this->crud_model->get_name('student' , $this->session->userdata('login_user_id'));?></div>
              <div class="company-address">
                <?php echo get_phrase('roll');?>: <?php echo $this->db->get_where('enroll', array('student_id' => $this->session->userdata('login_user_id')))->row()->roll;?><br/><?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?><br/><?php echo $this->db->get_where('section' , array('class_id' => $class_id))->row()->name;?>
              </div>
            </div>
          </div>
          <div class="rcard-heading">
            <h5><?php echo $exam_name;?></h5>
            <div class="rcard-date"><?php echo $class_name;?></div>
          </div>
            <div class="rcard-table table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="text-center"><?php echo get_phrase('subject');?></th>
                    <th class="text-center"><?php echo get_phrase('teacher');?></th>
                    <th class="text-center"><?php echo get_phrase('mark');?></th>
                  </tr>
                </thead>
                <tbody>
                 <?php 
                    $exams = $this->crud_model->get_exams();
                    $subjects = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
                    foreach ($subjects as $row3):
                    $mark = $this->db->get_where('mark' , array('student_id' => $this->session->userdata('login_user_id'),'subject_id' => $row3['subject_id'], 'class_id' => $class_id, 'exam_id' => $ex[1], 
                                                            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description));    
                    if($mark->num_rows() > 0) 
                    {
                        $marks = $mark->result_array();
                    }                
                    foreach ($marks as $row4):
                    ?>
                    <tr>
                        <td><?php echo $row3['name'];?></td>
                        <td><?php echo $this->crud_model->get_name('teacher' ,$row3['teacher_id']);?></td>
                        <td class="text-center"><?php echo $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'exam_id' => $ex[1], 'student_id'=> $ex[0],'year' => $running_year))->row()->labtotal; ?></td>
                    </tr>
                    <?php endforeach; endforeach; ?>
                </tbody>
              </table>
          </div>
          <div class="rcard-footer">
            <div class="rcard-logo">
              <img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"><span><?php echo $system_name;?></span>
            </div>
            <div class="rcard-info">
              <span><?php echo $system_email;?></span><span><?php echo $phone;?></span>
            </div>
          </div>
        </div>
        </div>
      </div>
      <button class="btn btn-info btn-rounded" onclick="printDiv('print_area')"><?php echo get_phrase('print');?></button>
    </div>
</div>
</div>

<script>
 function printDiv(nombreDiv) 
 {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;
     document.body.innerHTML = contenido;
     window.print();
     document.body.innerHTML = contenidoOriginal;
}
</script>    