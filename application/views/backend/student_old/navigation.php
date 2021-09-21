<div class="fixed-sidebar">
  <div class="fixed-sidebar-left sidebar--small" id="sidebar-left">
    <a href="<?php echo base_url();?>student/panel/" class="logo">
      <div class="img-wrap">
        <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'icon_white'))->row()->description;?>">
      </div>
    </a>
    <div class="mCustomScrollbar" data-mcs-theme="dark">
      <ul class="left-menu">
        <li>
          <a href="#" class="js-sidebar-open">
            <i class="left-menu-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/panel/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('dashboard');?>">
                  <div class="left-menu-icon">
                    <i class="picons-thin-icon-thin-0045_home_house"></i>
                  </div></a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/message/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('messages');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
            </div>
          </a>
        </li>     
        <li>
          <a href="<?php echo base_url();?>student/teachers/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('teachers');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/subject/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('class');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
            </div>
          </a>
        </li>  
        <li>
          <a href="<?php echo base_url();?>student/my_marks/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('grade');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
            </div>
          </a>
        </li> 
        <li>
          <a href="<?php echo base_url();?>student/class_routine/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('class_schedule');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/attendance_report/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('attendance');?>">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
            </div>
          </a>
        </li>
         <li>
          <a href="<?php echo base_url();?>student/library/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('library');?>">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
            </div>
          </a>
        </li>
         <li>
          <a href="<?php echo base_url();?>student/noticeboard/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('news');?>">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/request/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('permissions');?>">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
            </div>
          </a>
        </li>
        <?php if($this->db->get_where('settings', array('type' => 'students_reports'))->row()->description == 1):?>
        <li>
          <a href="<?php echo base_url();?>student/send_report/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('teacher_reports');?>">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
            </div>
          </a>
        </li>
        <?php endif;?>
        <li>
          <a href="<?php echo base_url();?>student/calendar/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('calendar');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/files/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('files');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0125_cloud_sync"></i>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/invoice/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('payments');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1">
    <a href="<?php echo base_url();?>student/panel/" class="logo">
      <div class="img-wrap">
        <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'icon_white'))->row()->description;?>">
      </div>
      <div class="title-block">
        <h6 class="logo-title"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?></h6>
      </div>
    </a>

    <div class="mCustomScrollbar" data-mcs-theme="dark">
      <ul class="left-menu">
        <li>
          <a href="#" class="js-sidebar-open">
            <i class="left-menu-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
            <span class="left-menu-title"><?php echo get_phrase('minimize_menu');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/panel/">
                  <div class="left-menu-icon">
                    <i class="picons-thin-icon-thin-0045_home_house"></i>
                  </div>
                  <span class="left-menu-title"><?php echo get_phrase('dashboard');?></span>
            </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/message/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('messages');?></span>
          </a>
        </li>    
        <li>
          <a href="<?php echo base_url();?>student/teachers/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('teachers');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('teachers');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/subject/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('class');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/my_marks/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('grade');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/class_routine/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('class_schedule');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/attendance_report/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('attendance');?></span>
          </a>
        </li>
         <li>
          <a href="<?php echo base_url();?>student/library/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('library');?></span>
          </a>
        </li>
         <li>
          <a href="<?php echo base_url();?>student/noticeboard/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('news');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/request/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('permissions');?></span>
          </a>
        </li>
        <?php if($this->db->get_where('settings', array('type' => 'students_reports'))->row()->description == 1):?>
        <li>
          <a href="<?php echo base_url();?>student/send_report/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('teacher_reports');?></span>
          </a>
        </li>
        <?php endif;?>
        <li>
          <a href="<?php echo base_url();?>student/calendar/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('calendar');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/files/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0125_cloud_sync"></i>
              <span class="left-menu-title"><?php echo get_phrase('files');?></span>
            </div>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/invoice/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('payments');?></span>
          </a>
        </li>
        <br><br>
        <li></li>
      </ul>
    </div>
  </div>
</div>

<div class="fixed-sidebar fixed-sidebar-responsive">
  <div class="fixed-sidebar-left sidebar--small" id="sidebar-left-responsive">
    <a href="<?php echo base_url();?>student/panel/" class="logo js-sidebar-open">
      <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'icon_white'))->row()->description;?>">
    </a>

  </div>

  <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1-responsive">
    <a href="<?php echo base_url();?>student/panel/" class="logo">
      <div class="img-wrap">
        <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'icon_white'))->row()->description;?>">
      </div>
      <div class="title-block">
        <h6 class="logo-title"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?></h6>
      </div>
    </a>
    <div class="mCustomScrollbar" data-mcs-theme="dark">
      <ul class="left-menu">
        <li>
          <a href="#" class="js-sidebar-open">
            <i class="left-menu-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
            <span class="left-menu-title"><?php echo get_phrase('minimize_menu');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/panel/">
                  <div class="left-menu-icon">
                    <i class="picons-thin-icon-thin-0045_home_house"></i>
                  </div>
                  <span class="left-menu-title"><?php echo get_phrase('dashboard');?></span>
            </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/message/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('messages');?></span>
          </a>
        </li> 
        <li>
          <a href="<?php echo base_url();?>student/teachers/" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_phrase('teachers');?>">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('teachers');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/subject/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('academic');?></span>
          </a>
        </li>  
        <li>
          <a href="<?php echo base_url();?>student/my_marks/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('marks');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/class_routine/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('class_routine');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/attendance_report/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('attendance');?></span>
          </a>
        </li>
         <li>
          <a href="<?php echo base_url();?>student/library/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0017_office_archive"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('library');?></span>
          </a>
        </li>
         <li>
          <a href="<?php echo base_url();?>student/noticeboard/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0010_newspaper_reading_news"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('news');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/request/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0015_fountain_pen"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('permissions');?></span>
          </a>
        </li>
        <?php if($this->db->get_where('settings', array('type' => 'students_reports'))->row()->description == 1):?>
        <li>
          <a href="<?php echo base_url();?>student/send_report/">
            <div class="left-menu-icon">
              <i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('teacher_reports');?></span>
          </a>
        </li>
        <?php endif;?>
        <li>
          <a href="<?php echo base_url();?>student/calendar/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('calendar');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/files/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0125_cloud_sync"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('files');?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url();?>student/invoice/">
            <div class="left-menu-icon">
              <i class="picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i>
            </div>
            <span class="left-menu-title"><?php echo get_phrase('payments');?></span>
          </a>
        </li><br><br>
        <li></li>
      </ul>
    </div>
  </div>
</div>