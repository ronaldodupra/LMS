<?php 
    $m ="";
    $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; 
?>
<div class="content-w">  
<?php include 'fancy.php';?>
    <div class="header-spacer"></div>
          <div class="conty">
    <div class="os-tabs-w menu-shad">       
        <div class="os-tabs-controls">        
            <ul class="navs navs-tabs upper">         
                <li class="navs-item">             
                    <a class="navs-links active" href="<?php echo base_url();?>parents/attendance_report/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                    <span><?php echo get_phrase('attendance_report');?></span></a>
                </li>
            </ul>       
        </div>
    </div>  
    <div class="content-i">   
        <div class="content-box">      
            <div class="element-wrapper">         
            <?php echo form_open(base_url() . 'parents/attendance_report_selector/', array('class' => 'form m-b')); ?>
                    <div class="row">                
                    <input type="hidden" name="year" value="<?php echo $running_year;?>">
                        <div class="col-sm-4">                  
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo get_phrase('month');?></label>
                                <div class="select">
                                    <select name="month" required="" onchange="show_year()">
                                        <option value=""><?php echo get_phrase('select');?></option>
                                            <?php
                                                for ($i = 1; $i <= 12; $i++):
                                                if ($i == 1) $m = get_phrase('january');
                                                else if ($i == 2) $m = get_phrase('february');
                                                else if ($i == 3) $m = get_phrase('march');
                                                else if ($i == 4) $m = get_phrase('april');
                                                else if ($i == 5) $m = get_phrase('may');
                                                else if ($i == 6) $m = get_phrase('june');
                                            else if ($i == 7) $m = get_phrase('july');
                                            else if ($i == 8) $m = get_phrase('august');
                                            else if ($i == 9) $m = get_phrase('september');
                                            else if ($i == 10) $m = get_phrase('october');
                                            else if ($i == 11) $m = get_phrase('november');
                                            else if ($i == 12) $m = get_phrase('december');
                                        ?>
                                            <option value="<?php echo $i; ?>"<?php if($month == $i) echo 'selected'; ?>  ><?php echo $m; ?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                            </div>                
                        </div>  
                        <div class="col-sm-4">    
                        <div class="form-group label-floating is-select">
                        <label class="control-label"><?php echo get_phrase('student');?></label>
                        <div class="select">
                            <select name="student_id" required="">
                                <option value=""><?php echo get_phrase('select');?></option>
                                <?php $children_of_parent = $this->db->get_where('student' , array('parent_id' => $this->session->userdata('parent_id')))->result_array();
                                foreach ($children_of_parent as $row): ?>
                                <option value="<?php echo $row['student_id']; ?>" <?php if($student_id == $row['student_id']) echo 'selected'; ?>><?php echo $this->crud_model->get_name('student', $row['student_id']); ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                        </div>            
                        <div class="col-md-2">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo get_phrase('year');?></label>
                                <div class="select">
                                    <select name="year" required="">
                                        <?php $year_options = explode('-', $running_year); ?>
                                        <option value="<?php echo $year_options[0]; ?>" <?php if($year == $year_options[0]) echo 'selected'; ?>>
                                            <?php echo $year_options[0]; ?></option>
                                            <option value="<?php echo $year_options[1]; ?>" <?php if($year == $year_options[1]) echo 'selected'; ?>>
                                            <?php echo $year_options[1]; ?></option>
                                    </select>
                                </div>
                            </div>
                                                                    
                        </div>    
                        <div class="col-sm-2">                 
                            <div class="form-group"> 
                                <button class="btn btn-rounded btn-success btn-upper" style="margin-top:20px"><span><?php echo get_phrase('generate');?></span></button>
                            </div>                
                        </div>             
                    </div>          
                <?php echo form_close();?>


                <?php if ($class_id != '' && $section_id != '' && $month != '' && $student_id != ''): ?>
                <div class="element-box lined-primary shadow">              
                    <div class="row">                
                        <div class="col-7 text-left">                  
                            <h5 class="form-header"><?php echo get_phrase('attendance_report');?></h5>
                        </div>
                        <div class="col-5 text-right">
                            <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $student_id);?>" width="20px" style="border-radius:20px;margin-right:5px;"> <?php echo $this->crud_model->get_name('student', $student_id);?> 
                        </div>                
                    </div>              
                <div class="table-responsive">                
                    <table class="table table-sm table-lightborder">
                        <thead>                    
                            <tr class="text-center" height="50px">
                                <th class="text-left"> <?php echo get_phrase('');?></th>  
                                <?php
                                    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                    for ($i = 1; $i <= $days; $i++) {
                                ?>                    
                                    <th class="text-center"> <?php echo $i; ?> </th>                    
                                    <?php } ?>
                                </tr> 
                            </thead>                  
                            <tbody>                    
                                <tr>                      
                                    <td><b>AM</b></td>    
                            <?php
                                $status = 0;
                                for ($i = 1; $i <= $days; $i++) {
                                
                                $timestamp = strtotime($i . '-' . $month . '-' . $year);
                                
                                $this->db->group_by('timestamp');
                                $this->db->where('am_pm', 1);
                                $attendance = $this->db->get_where('attendance', array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year, 'timestamp' => $timestamp,'am_pm' => 1, 'student_id' => $student_id))->result_array();

                                foreach ($attendance as $row1): 
                                   
                                    $month_dummy = date('d', $row1['timestamp']);

                                if ($i == $month_dummy) $status = $row1['status'];

                                endforeach; ?>
                                    <td class="text-center">
                                      <?php 
                                      if ($status == 1) { ?>
                                        <div class="status-pilli green" data-title="<?php echo get_phrase('present');?>" data-toggle="tooltip"></div>
                                   <?php  } if($status == 2)  { ?>
                                        <div class="status-pilli red" data-title="<?php echo get_phrase('absent');?>" data-toggle="tooltip"></div>
                                    <?php  } if($status == 3)  { ?>
                                        <div class="status-pilli yellow" data-title="<?php echo get_phrase('late');?>" data-toggle="tooltip"></div>
                                    <?php  } $status =0;?>
                                    </td> 

                                 <?php } ?>
                                </tr>    
                                <tr>                      
                                    <td><b>PM</b></td>    
                            <?php
                                $status = 0;
                                for ($i = 1; $i <= $days; $i++) {
                                $timestamp = strtotime($i . '-' . $month . '-' . $year);

                                $this->db->group_by('timestamp');
                                $this->db->where('am_pm', 2);
                                $attendance_pm = $this->db->get_where('attendance', array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year, 'timestamp' => $timestamp, 'student_id' => $student_id))->result_array();

                                foreach ($attendance_pm as $row1): $month_dummy = date('d', $row1['timestamp']);
                                if ($i == $month_dummy) 
                                    $status = $row1['status'];
                              
                                endforeach; ?>
                                    <td class="text-center">
                                      <?php if ($status == 1) { ?>

                                        <div class="status-pilli green" data-title="<?php echo get_phrase('present');?>" data-toggle="tooltip"></div>
                                   <?php  } if($status == 2)  { ?>
                                        <div class="status-pilli red" data-title="<?php echo get_phrase('absent');?>" data-toggle="tooltip"></div>
                                    <?php  } if($status == 3)  { ?>
                                        <div class="status-pilli yellow" data-title="<?php echo get_phrase('late');?>" data-toggle="tooltip"></div>
                                    <?php  } $status =0;?>
                                    </td> 
                                                         
                                 <?php } ?>
                                </tr>                                   
                            </tbody>                
                        </table>             
                    </div> 
                    <div class="row">                
                        <div class="col-7 mt-2 text-left">                  
                            <h6 class="form-header"><?php echo get_phrase('Legends:');?></h6>
                             <div class="status-pilli green"></div> Present
                             <div class="status-pilli yellow ml-3"></div> Late
                             <div class="status-pilli red ml-3"></div> Absent
                        </div>              
                    </div>           
                </div>   
                <?php endif;?>       
            </div>        
            </div>        
        </div>      
    </div>   
    </div>