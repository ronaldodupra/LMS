<?php 
  $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
  $system_name  = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
  $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
?>
<style type="text/css">

  .titulosincss {
  text-align: center;
  font-weight: bold;
  }

  .imagen {
  position: absolute;
  right: 5px;
  top: 10px;
  }

  .grande {
  font-size: 20px;
  font-family: Helvetica, sans-serif;
  }

  .mediano {
  font-size: 16px;
  font-family: Verdana, sans-serif;
  } 

  .menor {
  font-size: 13px;
  font-family: Arial, sans-serif;
  } 
 
  .tablatitulo {
  padding: 10px 0;
  }

  td.descripcion {
  font-weight: bold;
  }

  td.nota {
  text-align: center;
  }

  td.notapromedio {
  text-align: center;
  font-weight: bold;
  padding: 3px;
  }

  td.notapromediofinal {
  text-align: center;
  font-weight: bold;
  font-size: 14px;
  padding: 5px;
  }

  .firmadirector {
  padding: 40px 0 20px 0;
  font-weight: bold;
  float: right;
  width: 300px;
  }

  .firma {
  border-bottom: 1px solid #000;
  }

  .firmadirector .texto {
  text-align:center;
  }

  table {
  width: 100%;
  }

  .negrita {
  font-weight: bold;
  }
  
  .cuadro{
  width: 100%;
  }

  th {
    font-size: 16px;
     line-height:  35px;
    font-family: Arial, sans-serif;
  }

  td {
    font-size: 14px;
    line-height:  30px;
    font-family: Arial, sans-serif;
  }
</style>
<div class="cuadro" id="print_area">
  <div class="logo">
    <center><img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" alt="" width="7%"/></center>
  </div>
  <div class="titulosincss">
    <div class="grande"><?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
    <div class="menor "><?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description;?></div><br>
    <div class="mediano"><?php echo get_phrase('enrolled_student_list');?></div>
    <div class="menor"><?php echo $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->name;?></div>
    <div class="menor"><?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?> | <?php echo $this->db->get_where('section', array('section_id' => $section_id))->row()->name;?></div>
  </div>
  <table cellpading="0" cellspacing="0" border="1" style="margin: 20px 0;">
    <tr style="background-color: #00579c; color: #fff; text-align: center;">
      <th>#</th>
      <th><?php echo get_phrase('student');?></th>
      <th><?php echo get_phrase('address');?></th>
      <th><?php echo get_phrase('contact_no');?></th>
      <th><?php echo get_phrase('grade_/_course');?></th>
      <th><?php echo get_phrase('section');?></th>
    </tr>
    <?php
      $n = 1;
      $m = 0;
      $f = 0;
      // $students = $this->db->get_where('enroll', array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year))->result_array();

      $dept_id = $this->crud_model->get_department($subject_id);

      if($dept_id == 4)
      {

        if ($exam_id == 5) {

          $students = $this->db->query("SELECT t2.`student_id`, t1.`class_id`, t1.`section_id`, t2.`last_name`, t2.`sex`, t4.`Id` FROM enroll t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN subject t3 ON t1.`class_id` = t3.`class_id` AND t1.`section_id` = t3.`section_id` LEFT JOIN tbl_stud_subject_exclusion t4 ON t1.`student_id` = t4.`student_id` AND t4.`subject_id` = t3.`subject_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t3.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' AND ISNULL(t4.`Id`) UNION SELECT t1.`student_id`, t3.`class_id`, t3.`section_id`, t2.`last_name`, t2.`sex`, t1.`Id` FROM tbl_students_subject t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN enroll t3 ON t2.`student_id` = t3.`student_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t1.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' ORDER BY sex DESC, last_name");

        }
        else
        {

          $students = $this->db->query("SELECT t1.`student_id`, t3.`class_id`, t3.`section_id`, t2.`last_name`, t2.`sex`, t1.`Id` FROM tbl_students_subject t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN enroll t3 ON t2.`student_id` = t3.`student_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t1.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' ORDER BY sex DESC, last_name");

        }
        
      }
      else
      {

        $students = $this->db->query("SELECT t2.`student_id`, t1.`class_id`, t1.`section_id`, t2.`last_name`, t2.`sex`, t4.`Id` FROM enroll t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN subject t3 ON t1.`class_id` = t3.`class_id` AND t1.`section_id` = t3.`section_id` LEFT JOIN tbl_stud_subject_exclusion t4 ON t1.`student_id` = t4.`student_id` AND t4.`subject_id` = t3.`subject_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t3.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' AND ISNULL(t4.`Id`) UNION SELECT t1.`student_id`, t3.`class_id`, t3.`section_id`, t2.`last_name`, t2.`sex`, t1.`Id` FROM tbl_students_subject t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN enroll t3 ON t2.`student_id` = t3.`student_id` WHERE t1.`class_id` = '$class_id' AND t1.`section_id` = '$section_id' AND t1.`subject_id` = '$subject_id' AND t1.`year` = '$running_year' ORDER BY sex DESC, last_name");

      }

      foreach($students->result_array() as $row):
        if($this->db->get_where('student', array('student_id' => $row['student_id']))->row()->sex == 'M'){
          $m+=1;
        }else{
          $f += 1;
        }

        $data = $this->crud_model->get_student_info_by_id($row['student_id']);
      ?>
    <tr id="student-<?php echo $row['student_id'];?>">
      <td style="text-align: center;"><?php echo $n++;?></td>
      <td><?php echo $this->crud_model->get_name('student', $row['student_id'])?></td>
      <td style="text-align: center;"><?php echo get_phrase($data['address'])?></td>
      <td style="text-align: center;"><?php echo $row['phone']?></td>
      <td style="text-align: center;"><?php echo $this->crud_model->get_class_name($row['class_id'])?></td>
      <td style="text-align: center;"><?php echo $this->crud_model->get_section_name($row['section_id'])?></td>
    </tr>
    <?php endforeach;?>
  </table>
  <table cellpading="0" cellspacing="0" border="0" style="margin: 20px 0; width: 40%;">
    <tr>
      <td><?php echo get_phrase('boys');?></td>
      <td><?php echo $m;?></td>
      <td><?php echo get_phrase('girls');?></td>
      <td><?php echo $f;?></td>
    </tr>
  </table>
  <table cellpading="0" cellspacing="0" border="0">
    <tr>
      <td><?php echo get_phrase('teacher');?></td>
      <td><?php echo $this->crud_model->get_name('teacher', $this->session->userdata('login_user_id'))?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td><?php echo get_phrase('signature');?></td>
      <td>_________________________________________</td>
    </tr>
  </table>
</div>

<script type="text/javascript">
  window.onload = function() { window.print(); }
</script>