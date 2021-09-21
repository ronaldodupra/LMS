<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Teacher extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    function online_exam_result($param1 = '', $param2 = '') 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'online_exam_result';
        $page_data['param2'] = $param1;
        $page_data['student_id'] = $param2;
        $page_data['page_title'] = get_phrase('online_exam_results');
        $this->load->view('backend/index', $page_data);
    }

    function online_quiz_result($param1 = '', $param2 = '') 
    {
        
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'online_quiz_result';
        $page_data['param2'] = $param1;
        $page_data['student_id'] = $param2;
        $page_data['page_title'] = get_phrase('online_quiz_results');
        $this->load->view('backend/index', $page_data);

    }

    public function index()
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($this->session->userdata('teacher_login') == 1)
        {
            redirect(base_url() . 'teacher/panel/', 'refresh');
        }
    }
    
    function manage_online_exam_status($online_exam_id = "", $status = "", $data = ''){
        $this->crud_model->manage_online_exam_status($online_exam_id, $status);
            redirect(base_url() . 'teacher/online_exams/'.$data."/", 'refresh');
    }

    function manage_online_quiz_status($online_quiz_id = "", $status = "", $data = ''){
        $this->crud_model->manage_online_quiz_status($online_quiz_id, $status);
            redirect(base_url() . 'teacher/online_quiz/'.$data."/", 'refresh');
    }
    
    function new_exam($data = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['data'] = $data;
        $page_data['page_name']  = 'new_exam';
        $page_data['page_title'] = get_phrase('homework_details');
        $this->load->view('backend/index', $page_data);
    }

    function new_quiz($data = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['data'] = $data;
        $page_data['page_name']  = 'new_quiz';
        $page_data['page_title'] = get_phrase('quiz_details');
        $this->load->view('backend/index', $page_data);
    }
    
    function panel()
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        $page_data['page_name']  = 'panel';
        $page_data['page_title'] = get_phrase('dashboard');
        $this->load->view('backend/index', $page_data);
    }

    function grados($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'update_labs') 
        {
            $data['la1'] = $this->input->post('la1');
            $this->db->where('subject_id', $param2);
            $this->db->update('subject', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'teacher/marks_upload/'.$this->input->post('exam_id')."/".$class_id."/".$this->input->post('section_id')."/".$param2, 'refresh');
        }
        $page_data['class_id']   = $class_id;
        $page_data['subjects']   = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
        $page_data['page_name']  = 'grados';
        $page_data['page_title'] = get_phrase('classes');
        $this->load->view('backend/index', $page_data);
    }

    function group($param1 = "group_message_home", $param2 = ""){
      if ($this->session->userdata('teacher_login') != 1)
          redirect(base_url(), 'refresh');
      $max_size = 2097152;
      if ($param1 == 'group_message_read') 
      {
        $page_data['current_message_thread_code'] = $param2;
      }
      else if($param1 == 'send_reply')
      {
        if (!file_exists('uploads/group_messaging_attached_file/')) 
        {
          $oldmask = umask(0);
          mkdir ('uploads/group_messaging_attached_file/', 0777);
        }
        if ($_FILES['attached_file_on_messaging']['name'] != "") 
        {
          if($_FILES['attached_file_on_messaging']['size'] > $max_size)
          {
            $this->session->set_flashdata('error_message' , "2MB Allowed");
            redirect(base_url() . 'teacher/group/group_message_read/'.$param2, 'refresh');
          }
          else
          {
            $file_path = 'uploads/group_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
            move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
          }
        }
        $this->crud_model->send_reply_group_message($param2);
        $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
        redirect(base_url() . 'teacher/group/group_message_read/'.$param2, 'refresh');
      }

      $page_data['message_inner_page_name']   = $param1;
      $page_data['page_name']                 = 'group';
      $page_data['page_title']                = get_phrase('message_group');
      $this->load->view('backend/index', $page_data);
      
    }

    function marks_print_view($student_id  = '', $exam_id = '') 
     {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $page_data['exam_id']    =   $exam_id;
        $this->load->view('backend/teacher/marks_print_view', $page_data);
    }
    
    function view_marks($student_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $year =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' =>$year))->row()->class_id;
        $page_data['class_id']   =   $class_id;
        $page_data['page_name']  = 'view_marks';
        $page_data['page_title'] = get_phrase('view_marks');
        $page_data['student_id']   = $student_id;
        $this->load->view('backend/index', $page_data);    
    }

    function polls($param1 = '', $param2 = '')
    {
      if ($this->session->userdata('teacher_login') != 1)
      {
            redirect(base_url(), 'refresh');
      }
      if($param1 == 'response')
      {
         $data['poll_code'] = $this->input->post('poll_code');
         $data['answer'] = $this->input->post('answer');
         $user = $this->session->userdata('login_user_id');
         $user_type = $this->session->userdata('login_type');
         $data['user'] = $user_type ."-".$user;
         $data['date'] = date('d M, Y');
         $this->db->insert('poll_response', $data);
      }
    }

    function my_routine()
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'my_routine';
        $page_data['page_title'] = get_phrase('teacher_routine');
        $this->load->view('backend/index', $page_data);
    }

    // function class_routine($class_id = '')
    // {
    //     if ($this->session->userdata('teacher_login') != 1)
    //         redirect(base_url(), 'refresh');
    //     $page_data['page_name']  = 'class_routine';
    //     $page_data['class_id']  =   $class_id;
    //     $page_data['page_title'] = get_phrase('Class-Routine');
    //     $this->load->view('backend/index', $page_data);
    // }

    function class_routine_view($param1 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == '')
        {
            $cid = $this->db->get('class')->first_row()->class_id;
            $sid = $this->db->get('section')->first_row()->section_id;
        }
        else{
            
            $decode_info = base64_decode($param1);
            $data = explode('-', $decode_info);

            $cid = $data[0];
            $sid = $data[1]; 
        }

        $page_data['page_name']  = 'class_routine';
        $page_data['id']         =  $cid;
        $page_data['sid']        =  $sid;
        $page_data['page_title'] = get_phrase('class_routine');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create') 
        {
            $data['class_id']       = $this->input->post('class_id');
            if($this->input->post('section_id') != '') 
            {
                $data['section_id'] = $this->input->post('section_id');
            }
            $subject_id = $this->input->post('subject_id');
            $teacher_id = $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->teacher_id;
            $data['subject_id']     = $this->input->post('subject_id');
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['day']            = $this->input->post('day');
            if($this->input->post('ending_ampm') == 1){
                $sts = "AM";
            }else{
                $sts = "PM";
            }
            $data['amend']            = $sts;
            if($this->input->post('starting_ampm') == 1){
                $st = "AM";
            }else{
                $st = "PM";
            }
            $data['amend']            = $sts;
            $data['amstart']            = $st;
            $data['day']            = $this->input->post('day');
            $data['teacher_id'] = $teacher_id;
            $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('class_routine', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'teacher/class_routine_view/'.base64_encode($this->input->post('class_id')), 'refresh');
        }
        if ($param1 == 'update') 
        {
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            if($this->input->post('ending_ampm') == 1){
                $sts = "AM";
            }else{
                $sts = "PM";
            }
            $data['amend']            = $sts;
            if($this->input->post('starting_ampm') == 1){
                $st = "AM";
            }else{
                $st = "PM";
            }
            $data['amstart']            = $st;
            $data['day']            = $this->input->post('day');
            $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->where('class_routine_id', $param2);
            $this->db->update('class_routine', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'teacher/class_routine_view/'.$param3, 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->db->where('class_routine_id', $param2);
            $this->db->delete('class_routine');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/class_routine_view/'.$param3, 'refresh');
        } 
    }

    function student_report($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'send')
        {
            $parent_id = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->parent_id;
            $student_name = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->name;
            $parent_phone = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->phone;
            $parent_email = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->email;
            
            $data['student_id'] = $this->input->post('student_id');
            $data['class_id']   = $this->input->post('class_id');
            $data['section_id'] = $this->input->post('section_id');
            $one = 'teacher';
            $two = $this->session->userdata('login_user_id');
            $data['user_id']    = $one."-".$two;
            $data['title']      = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['file'] = $_FILES["file"]["name"];
            $data['date'] = date('d M, Y');
            $data['priority'] = $this->input->post('priority');
            $data['status'] = 0;
            $data['code'] = substr(md5(rand(0, 1000000)), 0, 7);
            $this->db->insert('reports', $data);
            $this->crud_model->students_reports($this->input->post('student_id'), $parent_id);

            move_uploaded_file($_FILES["file"]["tmp_name"], 'uploads/report_files/'. $_FILES["file"]["name"]);

            $name = $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'));
            $notifys['notify'] = "<strong>". $name."</strong>". " ". get_phrase('student_report_notify').":"." ". "<b>".$this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->name."</b>";
            $admins = $this->db->get('admin')->result_array();
            foreach($admins as $row)
            {
                $notifys['user_id'] = $row['admin_id'];
                $notifys['user_type'] = "admin";
                $notifys['url'] = "admin/looking_report/".$data['code'];
                $notifys['date'] = date('d M, Y');
                $notifys['time'] = date('h:i A');
                $notifys['status'] = 0;
                $notifys['original_id'] = $this->session->userdata('login_user_id');
                $notifys['original_type'] = $this->session->userdata('login_type');
                $this->db->insert('notification', $notifys);
            }
            $notify = $this->db->get_where('settings' , array('type' => 'students_reports'))->row()->description;
            if($notify == 1)
            {
              $message = "A behavioral report has been created for " . $student_name;
              $sms_status = $this->db->get_where('settings' , array('type' => 'sms_status'))->row()->description;
              if ($sms_status == 'msg91') 
              {
                  $this->crud_model->send_sms_via_msg91($message,$parent_phone);
              }
              else if ($sms_status == 'twilio') 
              {
                  $this->crud_model->twilio($message,$parent_phone);
              }
              else if ($sms_status == 'clickatell') 
              {
                  $this->crud_model->clickatell($message,$parent_phone);
              }
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'teacher/student_report/', 'refresh');
        }
        if($param1 == 'response')
        {
            $data['report_code'] = $this->input->post('report_code');
            $data['message'] = $this->input->post('message');
            $data['date'] = date('d M, Y');
            $data['sender_type'] = $this->session->userdata('login_type');
            $data['sender_id'] = $this->session->userdata('login_user_id');
            $this->db->insert('report_response', $data);
        }
        $page_data['page_name']  = 'student_report';
        $page_data['page_title'] = get_phrase('reports');
        $this->load->view('backend/index', $page_data);
    }

     function view_report($report_code = '') 
    {
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        $page_data['code'] = $report_code;
        $page_data['page_name'] = 'view_report';
        $page_data['page_title'] = get_phrase('report_details');
        $this->load->view('backend/index', $page_data);
    }
    
     function birthdays()
    {
        if ($this->session->userdata('teacher_login') != 1)
        { 
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'birthdays';
        $page_data['page_title'] = get_phrase('manage_class');
        $this->load->view('backend/index', $page_data);
    }
    
    function calendar($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
         {
            redirect(base_url(), 'refresh');
         }
        $page_data['page_name']  = 'calendar';
        $page_data['page_title'] = get_phrase('calendar');
        $this->load->view('backend/index', $page_data); 
    }

    function news()
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->crud_model->delete_news($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/panel/', 'refresh');
        }
        if ($param1 == 'delete2') 
        {
            $this->crud_model->delete_news($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/news/', 'refresh');
        }
        $page_data['page_name']  = 'news';
        $page_data['page_title'] = get_phrase('news');
        $this->load->view('backend/index', $page_data);
    }

    function courses($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'create')
        {
            $md5 = md5(date('d-m-y H:i:s'));

            $data['name']        = $this->input->post('name');
            $data['color']       = $this->input->post('color');
            $data['class_id']    = $this->input->post('class_id');
            $data['section_id']  = $this->input->post('section_id');
            $data['teacher_id']  = $this->input->post('teacher_id');
            $data['year']        = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
            //$data['semester_id'] = $this->input->post('sem_id');
            //$data['category'] = $this->input->post('categ_id');
            
            if($_FILES['userfile']['name'] <> ''){
                $data['icon'] = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }

            $this->db->insert('subject', $data);
            $subject_id = $this->db->insert_id();

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/subject_icon/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));

            $this->crud_model->save_user_logs("teacher", 'Subject', 'Add New Subject', 'Added new Subject: '.$data['name']);

            if ($param2 == 'MS') {
                redirect(base_url() . 'teacher/my_subjects/', 'refresh');
            }
            else{
                redirect(base_url() . 'teacher/cursos/'.base64_encode($param2)."/", 'refresh');
            }
            
        }
        if ($param1 == 'update') 
        {   
            $md5 = md5(date('d-m-y H:i:s'));

            $data['name']       = $this->input->post('name');
            $data['color']      = $this->input->post('color');
            $data['class_id']   = $this->input->post('class_id');
            $data['section_id'] = $this->input->post('section_id');
            $data['teacher_id'] = $this->input->post('teacher_id');
            //$data['semester_id'] = $this->input->post('sem_id');
            //$data['category'] = $this->input->post('categ_id');
            
            if($_FILES['userfile']['size'] > 0){
                $data['icon'] = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
           
            $this->db->where('subject_id', $param2);
            $this->db->update('subject', $data);

            $class_id = $this->input->post('class_id');
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/subject_icon/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));

            $this->crud_model->save_user_logs("teacher", 'Subject', 'Edit Subject', 'Edit Subject: '.$data['name']);

            redirect(base_url() . 'teacher/cursos/'.base64_encode($class_id)."/", 'refresh');
        }
        if ($param1 == 'update_labs') 
        {
            $class_id = $this->db->get_where('subject', array('subject_id' => $param2))->row()->class_id;
            $data['la1'] = $this->input->post('la1');
            $data['la2'] = $this->input->post('la2');
            $data['la3'] = $this->input->post('la3');
            $data['la4'] = $this->input->post('la4');
            $data['la5'] = $this->input->post('la5');
            $data['la6'] = $this->input->post('la6');
            $data['la7'] = $this->input->post('la7');
            $data['la8'] = $this->input->post('la8');
            $data['la9'] = $this->input->post('la9');
            $data['la10'] = $this->input->post('la10');
            $data['la11'] = $this->input->post('la11');
            $data['la12'] = $this->input->post('la12');
            $data['la13'] = $this->input->post('la13');
            $data['la14'] = $this->input->post('la14');
            $this->db->where('subject_id', $param2);
            $this->db->update('subject', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));

            $this->crud_model->save_user_logs("teacher", 'Lab. Activities', 'Edit Lab. Activities Title', 'Edit Lab. Activities Title');

            redirect(base_url() . 'teacher/upload_marks/'.base64_encode($class_id."-".$this->input->post('section_id')."-".$param2).'/', 'refresh');
        }
        
        $page_data['class_id']   = $param1;
        $page_data['subjects']   = $this->db->get_where('subject' , array('class_id' => $param1))->result_array();
        $page_data['page_name']  = 'coursess';
        $page_data['page_title'] = get_phrase('subjects');
        $this->load->view('backend/index', $page_data);
    }

    function tab_sheet($class_id = '' , $exam_id = '', $section_id = '') 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if ($this->input->post('operation') == 'selection') 
        {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['section_id'] = $this->input->post('section_id');
            $page_data['class_id']   = $this->input->post('class_id');
            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0) 
            {
                redirect(base_url() . 'teacher/tab_sheet/' . $page_data['class_id'] . '/' . $page_data['exam_id'] . '/' . $page_data['section_id'] , 'refresh');
            } else {
                redirect(base_url() . 'teacher/tab_sheet/', 'refresh');
            }
        }
        $page_data['exam_id']    = $exam_id;
        $page_data['section_id'] = $section_id;
        $page_data['class_id']   = $class_id;
        $page_data['page_info']  = 'Exam marks';
        $page_data['page_name']  = 'tab_sheet';
        $page_data['page_title'] = get_phrase('tabulation_sheet');
        $this->load->view('backend/index', $page_data);
    }

    function tab_sheet_print($class_id  = '', $exam_id = '', $section_id = '') 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['class_id'] = $class_id;
        $page_data['exam_id']  = $exam_id;
        $page_data['section_id']  = $section_id;
        $this->load->view('backend/teacher/tab_sheet_print' , $page_data);
    }

    function cuadros($grado = '', $seccion = '', $curso = '') 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['grado']  = $grado;
        $page_data['seccion']  = $seccion;
        $page_data['curso']  = $curso;
        $this->load->view('backend/teacher/cuadros' , $page_data);
    }

    // function get_class_section($class_id = '')
    // {
    //     $sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
    //     foreach ($sections as $row) 
    //     {
    //         echo '<option value="' . $row['section_id'].'">' . $row['name'] . '</option>';
    //     }
    // }
    
    // function get_class_subject($sec_id = '') 
    // {
    //     $subject = $this->db->get_where('subject' , array('section_id' => $sec_id))->result_array();
    //     foreach ($subject as $row) 
    //     {
    //         echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
    //     }
    // }

    function get_class_section($class_id = '')
    {   
        echo '<option value="">Select</option>';
        $sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
        foreach ($sections as $row) 
        {   
            echo '<option value="' . $row['section_id'].'">' . $row['name'] . '</option>';
        }
    }

    function get_class_section_selected($class_id = '', $section_id = '')
    {   
        echo '<option value="">Select</option>';
        $sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
        foreach ($sections as $row) 
        {   
            if ($row['section_id'] == $section_id) {
                echo '<option value="'.$row['section_id'].'" selected>' . $row['name'] . '</option>';
            }
            else{
                echo '<option value="'.$row['section_id'].'">' . $row['name'] . '</option>';
            }
        }
    }
    
    function get_class_subject($sec_id = '') 
    {   
        echo '<option value="">Select</option>';
        $subject = $this->db->get_where('subject' , array('section_id' => $sec_id))->result_array();
        foreach ($subject as $row) 
        {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_student_list($class_id = '', $sec_id = '') 
    {   
        echo '<option value="">Select</option>';
        $student = $this->db->query("SELECT * FROM student a LEFT JOIN enroll b ON a.`student_id` = b.`student_id` WHERE b.`class_id` = '$class_id' AND b.`section_id` = '$sec_id' ORDER BY a.`last_name` ASC")->result_array();

        foreach ($student as $row)
        {   
            echo '<option value="' . $row['student_id'] . '">' . $row['last_name'].', '.$row['first_name'] . '</option>';
        }
    }

    function teacher_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'personal_profile') 
        {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        }
        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teachers';
        $page_data['page_title'] = get_phrase('teachers');
        $this->load->view('backend/index', $page_data);
    }

    function students_area($id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect('login', 'refresh');
        }

        $id = $this->input->post('class_id');
        $login_id = $this->session->userdata('login_user_id');
        
        if ($id == '')
        {   
            $id = $this->db->query("SELECT * from class where teacher_id = '$login_id'")->first_row()->class_id;
        }

        $page_data['page_name']   = 'students_area';
        $page_data['page_title']  = get_phrase('students');
        $page_data['class_id']  = $id;
        $this->load->view('backend/index', $page_data);
    }


    function subject($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
	$page_data['class_id']   = $param1;
        $page_data['subjects']   = $this->db->get_where('subject' , array('class_id' => $param1,
            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->result_array();
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('subjects');
        $this->load->view('backend/index', $page_data);
    }
    
    function exam_routine($class_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'viendo_horarios';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('exam_routine');
        $this->load->view('backend/index', $page_data);
    }
    
    function upload_marks($datainfo = '', $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $info = base64_decode($datainfo);
        $ex = explode('-', $info);
        $year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        //$department_id = $this->crud_model->get_department($ex[2]);

        if($param2 != ""){
            $page = $param2;
        }else{
            $page = $this->db->query("SELECT exam_id FROM exam WHERE status = 1")->first_row()->exam_id;
        }

        $data['exam_id']    = $page;
        $data['class_id']   = $ex[0];
        $data['section_id'] = $ex[1];
        $data['subject_id'] = $ex[2];
        $data['year']       = $year;

        // $students = $this->db->get_where('enroll', array('class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year']))->result_array();

        $students = $this->db->query("SELECT a.`student_id`, b.`last_name` FROM enroll a LEFT JOIN student b ON a.`student_id` = b.`student_id` WHERE a.`class_id` = '$ex[0]' AND a.`section_id` = '$ex[1]' AND a.`year` = '$year' ORDER BY last_name ASC")->result_array();

        //$students = $this->db->query("SELECT t2.`student_id`, t2.`last_name`, t4.`Id` FROM enroll t1 LEFT JOIN student t2 ON t1.`student_id` = t2.`student_id` LEFT JOIN subject t3 ON t1.`class_id` = t3.`class_id` AND t1.`section_id` = t3.`section_id` LEFT JOIN tbl_stud_subject_exclusion t4 ON t1.`student_id` = t4.`student_id` AND t3.`subject_id` = t4.`subject_id` WHERE t1.`class_id` = '$ex[0]' AND t1.`section_id` = '$ex[1]' AND t3.`subject_id` = '$ex[2]' AND t1.`year` = '$year' AND ISNULL(t4.`Id`) UNION SELECT a.`student_id`, c.`last_name`, b.`roll` FROM tbl_student_subject a LEFT JOIN enroll b ON a.`student_id` = b.`student_id` LEFT JOIN student c ON b.`student_id` = c.`student_id` WHERE a.`class_id` = '$ex[0]' AND a.`section_id` = '$ex[1]' AND a.`subject_id` = '$ex[2]' AND a.`year` = '$year' ORDER BY last_name ASC")->result_array();

        foreach($students as $row) 
        {   

            $verify_data = array('exam_id' => $data['exam_id'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'student_id' => $row['student_id'], 'subject_id' => $data['subject_id'], 'year' => $data['year']);

            $query = $this->db->get_where('mark' , $verify_data);
           
            if($query->num_rows() < 1)
            {  
                $data['student_id'] = $row['student_id'];
                // Assessments
                $data['mark_obtained'] = $this->crud_model->get_total_exam_points($row['student_id'], $ex[0], $ex[1], $ex[2], $page);
                $data['labuno'] = $this->crud_model->get_total_quiz_points($row['student_id'], $ex[0], $ex[1], $ex[2], $page);

                // Written Works
                // $data['labdos'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '1', '1');
                // $data['labtres'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '1', '2');
                // $data['labcuatro'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '1', '3');

                // Performance Task
                // $data['labcinco'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '2', '1');
                // $data['labseis'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '2', '2');
                // $data['labsiete'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '2', '3');
               
                $this->db->insert('mark' , $data);
            }
            else
            {
               // $data['mark_obtained'] = $this->crud_model->get_total_exam_points($row['student_id'], $ex[0], $ex[1],$ex[2], $page);
               // $data['labuno'] = $this->crud_model->get_total_quiz_points($row['student_id'], $ex[0], $ex[1],$ex[2], $page);
               // $data['labdos'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '1', '1');
               // $data['labtres'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '1', '2');
               // $data['labcuatro'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '1', '3');
               // $data['labcinco'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '2', '1');
               // $data['labseis'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '2', '2');
               // $data['labsiete'] = $this->crud_model->get_deliveries_points($row['student_id'], $ex[2], $page, '2', '3');

               // $this->db->where('exam_id', $page);
               // $this->db->where('class_id', $ex[0]);
               // $this->db->where('section_id', $ex[1]);
               // $this->db->where('subject_id', $ex[2]);
               // $this->db->where('student_id', $row['student_id']);
               // $this->db->update('mark', $data);
            }
        }

        $page_data['exam_id'] = $page;
        $page_data['data'] = $datainfo;
        $page_data['page_name']  = 'upload_marks';
        $page_data['page_title'] = get_phrase('upload_marks');
        $this->load->view('backend/index', $page_data);
    }

    function marks_selector()
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;

        $students = $this->db->get_where('enroll' , array('class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']))->result_array();
        foreach($students as $row) 
        {
            $verify_data = array('exam_id' => $data['exam_id'],'class_id' => $data['class_id'],'section_id' => $data['section_id'],
            'student_id' => $row['student_id'],'subject_id' => $data['subject_id'], 'year' => $data['year']);

            $query = $this->db->get_where('mark' , $verify_data);
            if($query->num_rows() < 1) 
            {   
                    $data['student_id'] = $row['student_id'];
                    $this->db->insert('mark' , $data);
            }
        }
        redirect(base_url() . 'teacher/marks_upload/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id'], 'refresh');
    }

    function teacher_update()
    {
        if ($this->session->userdata('teacher_login') != 1) 
        {            
            redirect(base_url(), 'refresh');
        }
        include_once 'src/Google_Client.php';
        include_once 'src/contrib/Google_Oauth2Service.php';
        $clientId = $this->db->get_where('settings', array('type' => 'google_sync'))->row()->description; //Google client ID
        $clientSecret = $this->db->get_where('settings', array('type' => 'google_login'))->row()->description; //Google client secret
        $redirectURL = base_url().'auth/sync/'; //Callback URL
        //Call Google API
        $gClient = new Google_Client();
        $gClient->setApplicationName('google');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectURL);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        $authUrl = $gClient->createAuthUrl();
        $output = filter_var($authUrl, FILTER_SANITIZE_URL);
        
        $page_data['page_name']  = 'teacher_update';
        $page_data['page_title'] =  get_phrase('profile');
        $page_data['output']         = $output;
        $this->load->view('backend/index', $page_data);
    }
    
    function marks_update($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $marks_of_students = $this->db->get_where('mark' , array('exam_id' => $exam_id, 'class_id' => $class_id,'section_id' => $section_id, 'year' => $running_year,'subject_id' => $subject_id))->result_array();

        foreach($marks_of_students as $row) 
        {
            $obtained_marks = $this->input->post('marks_obtained_'.$row['mark_id']);
            $labouno = $this->input->post('lab_uno_'.$row['mark_id']);
            $labodos = $this->input->post('lab_dos_'.$row['mark_id']);
            $labotres = $this->input->post('lab_tres_'.$row['mark_id']);
            $labocuatro = $this->input->post('lab_cuatro_'.$row['mark_id']);
            $labocinco = $this->input->post('lab_cinco_'.$row['mark_id']);
            $laboseis = $this->input->post('lab_seis_'.$row['mark_id']);
            $labosiete = $this->input->post('lab_siete_'.$row['mark_id']);
            $laboocho = $this->input->post('lab_ocho_'.$row['mark_id']);
            $labonueve = $this->input->post('lab_nueve_'.$row['mark_id']);
            $labodeis = $this->input->post('lab_deis_'.$row['mark_id']);
            $laboonse = $this->input->post('lab_onse_'.$row['mark_id']);
            $labodose = $this->input->post('lab_dose_'.$row['mark_id']);
            $labotrese = $this->input->post('lab_trese_'.$row['mark_id']);
            //$comment = $this->input->post('comment_'.$row['mark_id']);

            // $counter = 0;
            // $arr_lab_mark = array();
            // array_push($arr_lab_mark, $obtained_marks, $labouno, $labodos, $labotres, $labocuatro, $labocinco, $laboseis, $labosiete, $laboocho, $labonueve);

            // foreach ($arr_lab_mark as $r) {
            //     if ($r > 0 ) {
            //         $counter = $counter + 1;
            //     }
            // }

            // //echo "Counter : " . $counter;

            // $labototal = ($obtained_marks + $labouno + $labodos + $labotres + $labocuatro + $labocinco + $laboseis + $labosiete + $laboocho + $labonueve + $labfinal) / $counter;
            //'labtotal' => number_format($labototal, 2, '.', '')
            
            $this->db->where('mark_id' , $row['mark_id']);
            $this->db->update('mark' , array('mark_obtained' => $obtained_marks , 'labuno' => $labouno, 'labdos' => $labodos, 'labtres' => $labotres
            , 'labcuatro' => $labocuatro, 'labcinco' => $labocinco, 'labseis' => $laboseis, 'labsiete' => $labosiete, 'labocho' => $laboocho
            , 'labnueve' => $labonueve, 'labdeis' =>  $labodeis, 'labonse' => $laboonse, 'labdose' => $labodose, 'labtrese' => $labotrese));
            
        }
        $info = base64_encode($class_id.'-'.$section_id.'-'.$subject_id);
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
        redirect(base_url().'teacher/upload_marks/'.$info.'/'.$exam_id.'/' , 'refresh');
    }

    function subject_marks($data = '') 
     {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['data'] = $data;
        $page_data['page_name']    = 'subject_marks';
        $page_data['page_title']   = get_phrase('subject_marks');
        $this->load->view('backend/index',$page_data);
     }

    function files($task = "", $code = "")
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }       
        if($task == 'download'){
            $user_folder = md5($this->session->userdata('login_user_id'));
            $file_name = $this->db->get_where('file', array('file_id' => $code))->row()->name;
            $folder = $this->db->get_where('file', array('file_id' => $code))->row()->folder_token;
            $folder_name = $this->db->get_where('folder', array('token' => $folder))->row()->name;
            $this->load->helper('download');
            if($folder != ""){
                $data = file_get_contents("uploads/users/teacher/". $user_folder."/".$folder_name.'/'.$file_name);
            }else{
                $data = file_get_contents("uploads/users/teacher/". $user_folder.'/'.$file_name);
            }
            $name = $file_name;
            force_download($name, $data);
        }
        if($task == 'create_folder')
        {
            $folder = md5($this->session->userdata('login_user_id'));
            if (!file_exists('uploads/users/'.$this->session->userdata('login_type').'/'.$folder)) {
                mkdir('uploads/users/'.$this->session->userdata('login_type').'/'.$folder, 0777, true);
            }
            if (!file_exists('uploads/users/'.$this->session->userdata('login_type').'/'.$folder.'/'.$this->input->post('name'))) 
            {
                $data['name'] = $this->input->post('name');
                $data['user_id'] = $this->session->userdata('login_user_id');
                $data['user_type'] = 'teacher';
                $data['token'] = base64_encode($data['name']);
                $data['date'] = date('d M, Y H:iA');
                $this->db->insert('folder', $data);
                mkdir('uploads/users/'.$this->session->userdata('login_type').'/'.$folder.'/'.$data['name'], 0777, true);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_uploaded'));
                redirect(base_url() . 'teacher/folders/', 'refresh');
            }else{
                $this->session->set_flashdata('flash_message' ,get_phrase('folder_already_exist'));
                redirect(base_url() . 'teacher/files/', 'refresh');
            }
        }
        if ($task == 'delete')
        {
            $user_folder = md5($this->session->userdata('login_user_id'));
            
            $file_name = $this->db->get_where('file', array('file_id' => $code))->row()->name;
            $folder = $this->db->get_where('file', array('file_id' => $code))->row()->folder_token;
            $folder_name = $this->db->get_where('folder', array('token' => $folder))->row()->name;
            if($folder != ""){
                unlink("uploads/users/teacher/". $user_folder."/".$folder_name.'/'.$file_name);
            }else{
                unlink("uploads/users/teacher/". $user_folder.'/'.$file_name);
            }
            $this->db->where('file_id',$code);
            $this->db->delete('file');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/all/');
        }
        $data['page_name']              = 'files';
        $data['page_title']             = get_phrase('your_files');
        $this->load->view('backend/index', $data);
    }

    function folders($task = '', $param2 = '')
    {
      if ($this->session->userdata('teacher_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      if($task == 'update')
      {
        $user_folder = md5($this->session->userdata('login_user_id'));
        $old_folder = $this->db->get_where('folder', array('folder_id' => $param2))->row()->name;
        rename('uploads/users/teacher/'.$user_folder.'/'.$old_folder,'uploads/users/teacher/'.$user_folder.'/'.$this->input->post('name'));
        
        $data['name'] = $this->input->post('name');
        $data['token'] = base64_encode($this->input->post('name'));
        $this->db->where('folder_id', $param2);
        $this->db->update('folder', $data);
        $this->session->set_flashdata('flash_message' ,get_phrase('successfully_updated'));
        redirect(base_url() . 'teacher/folders/', 'refresh');
      }
      if($task == 'delete')
      {
        $user_folder = md5($this->session->userdata('login_user_id'));
        $folder = $this->db->get_where('folder', array('folder_id' => $param2))->row()->name;
        $this->deleteDir('uploads/users/teacher/'.$user_folder.'/'.$folder);
        $this->db->where('folder_id', $param2);
        $this->db->delete('folder');
        $this->session->set_flashdata('flash_message' ,get_phrase('successfully_deleted'));
        redirect(base_url() . 'teacher/folders/', 'refresh');
      }
      $page_data['page_title']             = get_phrase('folders');
      $page_data['token']   = $task;
      $page_data['page_name']   = 'folders';
      $this->load->view('backend/index', $page_data);
    }
    
    function deleteDir($path) {
        return is_file($path) ? @unlink($path) :
        array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
    }
    
    function marks_get_subject($class_id = '')
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/teacher/marks_get_subject' , $page_data);
    }

    function homework($param1 = '', $param2 = '', $param3 = '') 
    {   
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create') 
        {
            $year =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $data['title'] = $this->input->post('title');
            $data['category'] = $this->input->post('category');
            $data['activity_type'] = $this->input->post('activity_type');
            $data['description'] = $this->input->post('description');
            $data['time_end'] = $this->input->post('time_end');
            $data['date_end'] = $this->input->post('date_end');
            $data['type'] = $this->input->post('type');
            $data['wall_type'] = 'homework';
            $data['publish_date'] = date('Y-m-d H:i:s');
            $data['upload_date'] = date('d M. H:iA');
            $data['year'] = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $data['status'] = $this->input->post('status');
            if($this->input->post('file_loc') <> ''){
                $data['file_name'] = $this->input->post('file_loc');
            }else{
                $data['file_name'] = '';
            }
            if($this->input->post('file_size') <> ''){
                $data['filesize'] = $this->input->post('file_size');
            }else{
                $data['filesize'] = '';
            }
            $data['class_id'] = $this->input->post('class_id');
            $data['section_id'] = $this->input->post('section_id');
            $data['user'] = $this->session->userdata('login_type');
            $data['subject_id'] = $this->input->post('subject_id');
            $data['uploader_type']  =  $this->session->userdata('login_type');
            $data['uploader_id']  =  $this->session->userdata('login_user_id');
            $data['homework_code'] = substr(md5(rand(100000000, 200000000)), 0, 15);
            $data['semester_id'] = $this->input->post('semester_id');
            $this->db->insert('homework', $data);
           
            $homework_code = $data['homework_code'];
            $class_id = $this->input->post('class_id');
            $subject_id = $this->input->post('subject_id');
            $section_id = $this->input->post('section_id');
            $title = $this->input->post('title');
            $description = $this->input->post('description');

            $activity_name =  $this->db->get_where('tbl_act_type', array('id' => $this->input->post('activity_type')))->row()->activity_type;

            $notify['notify'] = "<strong>".$this->crud_model->get_name('teacher', $this->session->userdata('login_user_id')).":</strong>". " added new ". $activity_name .": <b>".$this->input->post('title')."</b>";
            
            $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $year))->result_array();
            
            foreach($students as $row)
            {
                $notify['user_id'] = $row['student_id'];
                $notify['user_type'] = 'student';
                $notify['url'] = "student/homework/".base64_encode($this->input->post('class_id').'-'.$this->input->post('section_id').'-'.$this->input->post('subject_id'));
                $notify['date'] = date('d M, Y');
                $notify['year'] = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                $notify['class_id'] = $this->input->post('class_id');
                $notify['subject_id'] = $this->input->post('subject_id');
                $notify['time'] = date('h:i A');
                $notify['status'] = 0;
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');
                $notify['table_id'] = $homework_code;
                $notify['form'] = "activity";
                $this->db->insert('notification', $notify);
            }

            $this->crud_model->send_homework_notify();
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'teacher/homeworkroom/' . $homework_code , 'refresh');

        }
        if($param1 == 'update')
        {   
            $homework_code = $this->input->post('homework_code');

            $data['title'] = $this->input->post('title');
            $data['category'] = $this->input->post('category');
            $data['activity_type'] = $this->input->post('activity_type');
            $data['semester_id'] = $this->input->post('semester_id');
            $data['description'] = $this->input->post('description');
            $data['time_end'] = $this->input->post('time_end');
            $data['date_end'] = $this->input->post('date_end');
            $data['user'] = $this->session->userdata('login_type');
            $data['status'] = $this->input->post('is_random');
            $data['type'] = $this->input->post('type');
            if($this->input->post('file_loc') <> ''){
                $data['file_name'] = $this->input->post('file_loc');
            }
            if($this->input->post('file_size') <> ''){
                $data['filesize'] = $this->input->post('file_size');
            }

            $this->db->where('homework_code', $homework_code);
            $this->db->update('homework', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));

            echo 1;

            //redirect(base_url() . 'teacher/homework_edit/' . $param2 , 'refresh');
        }
        if($param1 == 'review')
        {
            $id = $this->input->post('answer_id');
            $mark = $this->input->post('mark');
            $comment = $this->input->post('comment');
            $entries = sizeof($mark);
            for($i = 0; $i < $entries; $i++) 
            {
                $data['mark']    = $mark[$i];
                $data['teacher_comment'] = $comment[$i];
                $this->db->where_in('id', $id[$i]);
                $this->db->update('deliveries', $data);
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'teacher/homework_details/' . $param2 , 'refresh');
        }
        if($param1 == 'single')
        {
            $student_id = $this->db->get_where('deliveries', array('id' => $this->input->post('id')))->row()->student_id;
            $code = $this->db->get_where('deliveries', array('id' => $this->input->post('id')))->row()->homework_code;
            $title = $this->db->get_where('homework', array('homework_code' => $code))->row()->title;

            $data['teacher_comment'] = $this->input->post('comment');
            $data['mark'] = $this->input->post('mark');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('deliveries', $data);

            $notify['notify'] = "<strong>". $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('homework_rated') ." <b>".$title.".</b>";
            $notify['user_id'] = $student_id;
            $notify['user_type'] = 'student';
            $notify['date'] = date('d M, Y');
            $notify['time'] = date('h:i A');
            $notify['url'] = "student/homeworkroom/".$code;
            $notify['status'] = 0;
            $notify['original_id']   = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'teacher/single_homework/' . $this->input->post('id') , 'refresh');
        }
        if ($param1 == 'edit') 
        {
            $this->crud_model->update_homework($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'teacher/homeworkroom/edit/' . $param2 , 'refresh');
        }
        if ($param1 == 'delete')
        {   
            $this->crud_model->delete_homework($param2);

            $this->db->where('table_id', $param2);
            $this->db->where('form', "activity");
            $this->db->delete('notification');
            
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/homework/'.$param3."/", 'refresh');
        }

        $page_data['data'] = $param1;
        $page_data['page_name'] = 'homework';
        $page_data['page_title'] = get_phrase('homework');
        $this->load->view('backend/index', $page_data);
    }
    
    function notify($param1 = '', $param2 = '')
    {
      if ($this->session->userdata('teacher_login') != 1)
      {
          redirect(base_url(), 'refresh');
      }
      if($param1 == 'send_emails')
      {
         $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        require("class.phpmailer.php");
        $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
        $mail->Subject = $this->input->post('subject');
        $data = array(
            'email_msg' => $this->input->post('content')
        );
        $mail->Body = $this->load->view('backend/mails/notify.php',$data,TRUE);
        $users = $this->db->get_where('enroll', array('year' => $year, 'class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id')))->result_array();
        foreach($users as $row)
        {
            if($this->input->post('receiver') == 'student'){
                $mail->AddAddress($this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->email);   
            }else if($this->input->post('receiver') == 'parent'){
                $this->db->group_by('parent_id');
                $this->db->where('student_id', $row['student_id']);
                $parent_id = $this->db->get('student')->row()->parent_id;
                $mail->AddAddress($this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->email);
            }
        }
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
        
        $this->session->set_flashdata('flash_message' , get_phrase('sent_successfully'));
        redirect(base_url() . 'teacher/notify/', 'refresh');
      }
      if($param1 == 'sms')
      {       
        $sms_status = $this->db->get_where('settings' , array('type' => 'sms_status'))->row()->description; 
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $class_id   =   $this->input->post('class_id');
        $section_id   =   $this->input->post('section_id');
        $receiver   =   $this->input->post('receiver');
        $users = $this->db->get_where('enroll' , array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $year))->result_array();
        $message = $this->input->post('message');
        foreach ($users as $row) 
        {
            if($receiver == 'student'){
                $phones = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->phone;
            }else{
                $this->db->group_by('parent_id');
                $parent_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
                $phones = $this->db->get_where('parent' , array('parent_id' => $row['parent_id']))->row()->phone;
            }
            if ($sms_status == 'twilio') 
            {
                 $this->crud_model->twilio($message,$phones);
            }else if ($sms_status == 'clickatell') 
            {
                 $this->crud_model->clickatell($message,$phones);
            }  
            else if ($sms_status == 'msg91') 
            {
                 $this->crud_model->send_sms_via_msg91($message,$phones);
            }  
        }
        $this->session->set_flashdata('flash_message' , get_phrase('sent_successfully'));
        redirect(base_url() . 'teacher/notify/', 'refresh');
      }
      $page_data['page_name']  = 'notify';
      $page_data['page_title'] = get_phrase('notifications');
      $this->load->view('backend/index', $page_data);
    }
    
    function subject_dashboard($data = '') 
     {
         if ($this->session->userdata('teacher_login') != 1)
      {
          redirect(base_url(), 'refresh');
      }
         $page_data['data'] = $data;
         $page_data['page_name']    = 'subject_dashboard';
         $page_data['page_title']   = get_phrase('subject_marks');
         $this->load->view('backend/index',$page_data);
     }

     function archived_items($data = '') 
     {
         if ($this->session->userdata('teacher_login') != 1)
        { 
            redirect(base_url(), 'refresh');
        }
         $page_data['data'] = $data;
         $page_data['page_name']    = 'archived_items';
         $page_data['page_title']   = get_phrase('archived_items');
         $this->load->view('backend/index',$page_data);
     }
    
    function cursos($class_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['class_id']  = $class_id;
        $page_data['page_name']  = 'cursos';
        $page_data['page_title'] = get_phrase('subjects');
        $this->load->view('backend/index', $page_data);
    }
    
    function upload_file($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
      {
          redirect(base_url(), 'refresh');
      }
        $page_data['token']  = $param1;
        $page_data['page_name']  = 'upload_file';
        $page_data['page_title'] = get_phrase('library');
        $this->load->view('backend/index', $page_data);
    }
    
    function recent()
    {
        if($this->session->userdata('teacher_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $page_data['page_name']  =  'recent';
        $page_data['page_title'] =  get_phrase('recent_files');
        $this->load->view('backend/index', $page_data);
    }

    function all($class_id = '', $section_id = '')
    {
      if ($this->session->userdata('teacher_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
      $page_data['page_name']   = 'all';
      $page_data['page_title']  = get_phrase('my_files');
      $this->load->view('backend/index', $page_data);
    }
    
    function my_account($param1 = "", $page_id = "")
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }       
        include_once 'src/Google_Client.php';
        include_once 'src/contrib/Google_Oauth2Service.php';
        $clientId = $this->db->get_where('settings', array('type' => 'google_sync'))->row()->description; //Google client ID
        $clientSecret = $this->db->get_where('settings', array('type' => 'google_login'))->row()->description; //Google client secret
        $redirectURL = base_url().'auth/sync/'; //Callback URL
        //Call Google API
        $gClient = new Google_Client();
        $gClient->setApplicationName('google');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectURL);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        $authUrl = $gClient->createAuthUrl();
        $output = filter_var($authUrl, FILTER_SANITIZE_URL);
        if($param1 == 'remove_facebook')
        {
          $data['fb_token']    =  "";
          $data['fb_id']    =  "";
          $data['fb_photo']    =  "";
          $data['fb_name']       =  "";
          $data['femail'] = "";
          unset($_SESSION['access_token']);
          unset($_SESSION['userData']);
          $this->db->where('teacher_id', $this->session->userdata('login_user_id'));
          $this->db->update('teacher', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('facebook_delete'));
            redirect(base_url() . 'teacher/my_account/', 'refresh');
        }
        if($param1 == '1')
        {
            $this->session->set_flashdata('error_message' , get_phrase('google_err'));
            redirect(base_url() . 'teacher/my_account/', 'refresh');
        }
        if($param1 == '3')
        {
            $this->session->set_flashdata('error_message' , get_phrase('facebook_err'));
            redirect(base_url() . 'teacher/my_account/', 'refresh');
        }
        if($param1 == '2')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('google_true'));
            redirect(base_url() . 'teacher/my_account/', 'refresh');
        }
        if($param1 == '4')
        {
            $this->session->set_flashdata('flash_message' , get_phrase('facebook_true'));
            redirect(base_url() . 'teacher/my_account/', 'refresh');
        }  
        if($param1 == 'remove_google')
        {
            include_once 'src/Google_Client.php';
            include_once 'src/contrib/Google_Oauth2Service.php';
            $gClient = new Google_Client();
            $gClient->setApplicationName('google');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectURL);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            $data['g_oauth'] = "";
            $data['g_fname'] = "";
            $data['g_lname'] = "";
            $data['g_picture'] = "";
            $data['link'] = "";
            $data['g_email'] = "";  
            $this->db->where('teacher_id', $this->session->userdata('login_user_id'));
            $this->db->update('teacher', $data);
            
            unset($_SESSION['token']);
            unset($_SESSION['userData']);
            $gClient->revokeToken();
            $this->session->set_flashdata('flash_message' , get_phrase('google_delete'));
            redirect(base_url() . 'teacher/my_account/', 'refresh');
        }
        if ($param1 == 'update_profile') 
        {
            $md5 = md5(date('d-m-y H:i:s'));
            // $data['first_name']  = $this->input->post('first_name');
            // $data['last_name']   = $this->input->post('last_name');
            $data['email']       = $this->input->post('email');
            $data['phone']       = $this->input->post('phone');
            $data['idcard']      = $this->input->post('idcard');
            $data['birthday']    = $this->input->post('birthday');
            $data['address']     = $this->input->post('address');
            $data['username']    = $this->input->post('username');
            $data['zoom_link']   = $this->input->post('zoom_link');
            $data['google_meet_link'] = $this->input->post('gmeet_link');
            $data['teaching_status'] = $this->input->post('t_status');
            if($_FILES['userfile']['name'] != ""){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));   

                $string_to_encrypt=$this->input->post('password');
                $password="password";
                $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
                $data['password_md5'] = $encrypted_string;
            }

            $this->db->where('teacher_id', $this->session->userdata('login_user_id'));

            $this->db->update('teacher', $data);

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            redirect(base_url() . 'teacher/teacher_update/', 'refresh');
        }

        $data['page_name']  = 'my_account';
        $data['output']     = $output;
        $data['page_title'] = get_phrase('profile');
        $this->load->view('backend/index', $data);
    }

    function manage_attendance($class_id = '')
    {
        if($this->session->userdata('teacher_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $page_data['page_name']  =  'manage_attendance';
        $page_data['class_id']   =  $class_id;
        $page_data['page_title'] =  get_phrase('attendance');
        $this->load->view('backend/index', $page_data);
    }

    function manage_attendance_view($class_id = '' , $section_id = '' , $timestamp = '', $am_pm = '')
    {
        if($this->session->userdata('teacher_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        $class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $page_data['class_id'] = $class_id;
        $page_data['timestamp'] = $timestamp;
        $page_data['am_pm'] = $am_pm;
        $page_data['page_name'] = 'manage_attendance_view';
        $section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
        $page_data['section_id'] = $section_id;
        $page_data['page_title'] = get_phrase('attendance') . ' ' . $class_name . ' : ' . get_phrase('section') . ' ' . $section_name;
        $this->load->view('backend/index', $page_data);
    }

    function attendance_selector()
    {
        $data['class_id']   = $this->input->post('class_id');
        $data['year']       = $this->input->post('year');
        $originalDate =$this->input->post('timestamp');
        $newDate = date("d-m-Y", strtotime($originalDate));
        $data['timestamp']  = strtotime($newDate);
        $data['section_id'] = $this->input->post('section_id');
        $data['am_pm'] = $this->input->post('am_pm');
            $query = $this->db->get_where('attendance' ,array(
                'class_id'=>$data['class_id'],
                    'section_id'=>$data['section_id'],
                        'year'=>$data['year'],
                            'timestamp'=>$data['timestamp'],
                                'am_pm'=>$data['am_pm']));
        if($query->num_rows() < 1) 
        {
            $students = $this->db->get_where('enroll' , array('class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']))->result_array();
            foreach($students as $row) 
            {
                $attn_data['class_id']   = $data['class_id'];
                $attn_data['year']       = $data['year'];
                $attn_data['timestamp']  = $data['timestamp'];
                $attn_data['section_id'] = $data['section_id'];
                $attn_data['student_id'] = $row['student_id'];
                $attn_data['am_pm'] = $data['am_pm'];

                $date_trans =  date('yy-m-d', $data['timestamp']);
                $student_id = $row['student_id'];
                $am_pm = $data['am_pm'];

                $q = $this->db->query("SELECT * from tbl_attendance_logs WHERE student_id = '$student_id' and date_trans = '$date_trans' and am_pm = '$am_pm'")->num_rows();

                if($q > 0 ){
                    //present
                    $attn_data['status'] = 1;
                }else{
                    //absent
                    $attn_data['status'] = 2;
                }
                
                $this->db->insert('attendance' , $attn_data);  
            }
        }
        redirect(base_url().'teacher/manage_attendance_view/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['timestamp'].'/'.$data['am_pm'],'refresh');
    }

    function attendance_update($class_id = '' , $section_id = '' , $timestamp = '', $am_pm = '')
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $attendance_of_students = $this->db->get_where('attendance' , array('class_id'=>$class_id,'section_id'=>$section_id,'year'=>$running_year,'timestamp'=>$timestamp, 'am_pm'=>$am_pm))->result_array();
        foreach($attendance_of_students as $row) 
        {
            $attendance_status = $this->input->post('status_'.$row['attendance_id']);
            $this->db->where('attendance_id' , $row['attendance_id']);
            $this->db->update('attendance' , array('status' => $attendance_status));
        }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
        redirect(base_url().'teacher/manage_attendance_view/'.$class_id.'/'.$section_id.'/'.$timestamp.'/'.$am_pm , 'refresh');
    }
    
    function study_material($task = "", $document_id = "", $data = '')
    {
        
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        } 
        if ($task == "create")
        {

            $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            //$this->crud_model->save_study_material_info();
            //INSERT STUDY MATERIAL
            $study_data = $this->input->post('study_data');

            $data_insert['type'] = $this->session->userdata('login_type');
            $data_insert['timestamp']         = strtotime(date("Y-m-d H:i:s"));
            $data_insert['title']             = $this->input->post('title');
            $data_insert['description']       = $this->input->post('description');
            $data_insert['upload_date'] = date('d M. H:iA');
            $data_insert['publish_date'] = date('Y-m-d H:i:s');
            if($this->input->post('file_loc') <> ''){
                $data_insert['file_name']         = $this->input->post('file_loc');
            }else{
                $data_insert['file_name'] = '';
            }
            if($this->input->post('file_size') <> ''){
                $data_insert['filesize']         = $this->input->post('file_size');
            }else{
                $data_insert['filesize'] = '';
            }
            $data_insert['wall_type'] = 'material';
            $data_insert['file_type']         = $this->input->post('file_type');
            $data_insert['class_id']          = $this->input->post('class_id');
            $data_insert['subject_id']         = $this->input->post('subject_id');
            $data_insert['section_id']         = $this->input->post('section_id');
            $data_insert['teacher_id'] = $this->session->userdata('login_user_id');
            $data_insert['semester_id'] = $this->input->post('semester_id');
            $data_insert['document'] = $this->input->post('document');
            $data_insert['doc_type'] = $this->input->post('doc_type');
            $this->db->insert('document',$data_insert);
            $table_id = $this->db->insert_id();
            //INSERT STUDY MATERIAL

            $notify['notify'] = "<strong>".$this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong> ". " added new study material description: ".$data_insert['description'];
            
            $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'),'section_id' => $this->input->post('section_id'), 'year' => $year))->result_array();
            
            foreach($students as $row)
            {
                $notify['user_id'] = $row['student_id'];
                $notify['user_type'] = 'student';
                $notify['url'] = "student/study_material/".base64_encode($this->input->post('class_id').'-'.$this->input->post('section_id').'-'.$this->input->post('subject_id'));
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['type'] = 'material';
                $notify['status'] = 0;
                $notify['year'] = $year;
                $notify['class_id'] = $this->input->post('class_id');
                $notify['section_id'] = $this->input->post('section_id');
                $notify['subject_id'] = $this->input->post('subject_id');
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');

                $notify['table_id'] = $table_id;
                $notify['form'] = "study_material";

                $this->db->insert('notification', $notify);
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_uploaded'));
            echo 1;
        }
        if ($task == "delete")
        {
            $this->crud_model->delete_study_material_info($document_id);
            
            $this->db->where('table_id',$document_id);
            $this->db->where('form','study_material');
            $this->db->delete('notification');

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/study_material/'.$data."/");
        }
        if($task == "update"){

            $file_loc = $this->input->post('file_loc');

            if($file_loc <> ''){
                $data_udpate['file_name'] = $this->input->post('file_loc');
                $data_udpate['filesize'] = $this->input->post('file_size');
            }
            $data_udpate['description'] = $this->input->post('description');
            $data_udpate['semester_id'] = $this->input->post('semester_id');
            $this->db->where('document_id', $document_id);
            $this->db->update('document', $data_udpate);

        }
        $page_data['data'] = $task;
        $page_data['page_name']              = 'study_material';
        $page_data['page_title']             = get_phrase('study_material');
        $this->load->view('backend/index', $page_data);
    }

    function library($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $id = $this->input->post('class_id');
        if ($id == '')
        {
            $id = $this->db->get('class')->first_row()->class_id;
        }
        $page_data['id']  = $id;
        $page_data['page_name']  = 'library';
        $page_data['page_title'] = get_phrase('library');
        $this->load->view('backend/index', $page_data);
    }
    
    function query($search_key = '') 
    {        
        if ($_POST)
        {
            redirect(base_url() . 'teacher/search_results?query=' . base64_encode($this->input->post('search_key')), 'refresh');
        }
    }

    function search_results()
    {
        if($this->session->userdata('teacher_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if ($_GET['query'] == "")
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['search_key'] =  $_GET['query'];
        $page_data['page_name']  =  'search_results';
        $page_data['page_title'] =  get_phrase('search_results');
        $this->load->view('backend/index', $page_data);
    }

    function notifications()
    {
        if($this->session->userdata('teacher_login')!=1)
        {
            redirect(base_url() , 'refresh');
        }
        
        $page_data['page_name']  =  'notifications';
        $page_data['page_title'] =  get_phrase('your_notifications');
        $this->load->view('backend/index', $page_data);
    }

    function message($param1 = 'message_home', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        if ($param1 == 'send_new') 
        {
            $message_thread_code = $this->crud_model->send_new_private_message();
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/messages/" . $_FILES["file_name"]["name"]);
            $this->session->set_flashdata('flash_message' , get_phrase('message_sent'));
            redirect(base_url() . 'teacher/message/message_read/' . $message_thread_code, 'refresh');
        }
        if ($param1 == 'send_reply') 
        {
            $this->crud_model->send_reply_message($param2);
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/messages/" . $_FILES["file_name"]["name"]);
            $this->session->set_flashdata('flash_message' , get_phrase('reply_sent'));
            redirect(base_url() . 'teacher/message/message_read/' . $param2, 'refresh');
        }
        if ($param1 == 'message_read') 
        {
            $page_data['current_message_thread_code'] = $param2; 
            $this->crud_model->mark_thread_messages_read($param2);
        }
        $page_data['infouser'] = $param2;
        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('private_messages');
        $this->load->view('backend/index', $page_data);
    }

    function request($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }    
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        if ($param1 == "create")
        {
            $this->crud_model->permission_request();
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/request/" . $_FILES["file_name"]["name"]);            

            $notify['notify'] = "<strong>".  $this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". get_phrase('absense_teacher');

            $admins = $this->db->get('admin')->result_array();

            foreach($admins as $row)
            {
                $notify['user_id'] = $row['admin_id'];
                $notify['user_type'] = "admin";
                $notify['url'] = "admin/request";
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['status'] = 0;
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');
                $this->db->insert('notification', $notify);
            }

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'teacher/request', 'refresh');

        }
        
        $data['page_name']  = 'request';
        $data['page_title'] = get_phrase('permissions');
        $this->load->view('backend/index', $data);
    }

    function homeworkroom($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'file') 
        {
            $page_data['room_page']    = 'homework_file';
            $page_data['homework_code'] = $param2;
        }  
        else if ($param1 == 'details') 
        {
            $page_data['room_page'] = 'homework_details';
            $page_data['homework_code'] = $param2;
        }
        else if ($param1 == 'edit') 
        {
            $page_data['room_page'] = 'homework_edit';
            $page_data['homework_code'] = $param2;
        }

        $page_data['homework_code'] =   $param1;
        $page_data['page_name']   = 'homework_room'; 
        $page_data['page_title']  = get_phrase('homework');
        $this->load->view('backend/index', $page_data);
    }

    function homework_file($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $homework_code = $this->db->get_where('homework', array('homework_id'))->row()->homework_code;
        if ($param1 == 'upload')
        {
            $this->crud_model->upload_homework_file($param2);
        }
        else if ($param1 == 'download')
        {
            $this->crud_model->download_homework_file($param2);
        }
        else if ($param1 == 'delete')
        {
            $this->crud_model->delete_homework_file($param2);
            redirect(base_url() . 'teacher/homeworkroom/details/' . $homework_code , 'refresh');
        }
    }

    function forum($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($param1 == 'create') 
        {
            $code = "F-". substr(md5(rand(100000000, 200000000)), 0, 15);

            $year =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['class_id'] = $this->input->post('class_id');
            $data['type'] = $this->session->userdata('login_type');
            $data['publish_date'] = date('Y-m-d H:i:s');
            $data['upload_date'] = date('d M. H:iA');
            $data['wall_type'] = "forum";
            $data['section_id'] = $this->input->post('section_id');

            if($this->input->post('post_status') != "1"){
                $data['post_status'] = 0;
            }else{
                $data['post_status'] = $this->input->post('post_status');   
            }

            $data['timestamp'] = date("d M, Y H:iA");
            $data['subject_id'] = $this->input->post('subject_id');

            if($this->input->post('file_loc') <> ''){
                $data['file_name'] = $this->input->post('file_loc');
            }else{
                $data['file_name'] = '';
            }

            $data['teacher_id']  =   $this->session->userdata('login_user_id');
            $data['post_code'] = $code;
            $data['semester_id'] = $this->input->post('semester_id');
            $this->db->insert('forum', $data);

            $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $year))->result_array();

            foreach($students as $row)
            {
                $notify['notify'] = "<strong>".$this->crud_model->get_name('teacher', $this->session->userdata('login_user_id'))."</strong>". " added new forum title: ". $data['title'];
                $notify['user_id'] = $row['student_id'];
                $notify['user_type'] = 'student';
                $notify['type'] = 'forum';
                $notify['url'] = "student/forumroom/".$data['post_code'];
                $notify['date'] = date('d M, Y');
                $notify['year'] = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                $notify['class_id'] = $this->input->post('class_id');
                $notify['subject_id'] = $this->input->post('subject_id');
                $notify['time'] = date('h:i A');
                $notify['status'] = 0;
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');

                $notify['table_id'] = $code;
                $notify['form'] = "forum";

                $this->db->insert('notification', $notify);
            }
            //move_uploaded_file($_FILES["userfile"]["tmp_name"], "uploads/forum/" . $_FILES["userfile"]["name"]);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'teacher/forum/' . $param2."/" , 'refresh');
        }
        if ($param1 == 'update') 
        {
            if($this->input->post('post_status') != "1"){
                $data['post_status'] = 0;
            }else{
                $data['post_status'] = $this->input->post('post_status');   
            }
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['type'] = $this->session->userdata('login_type');
            $data['timestamp'] = date("d M,Y H:iA");
            $data['teacher_id']  =   $this->session->userdata('login_user_id');
            $this->db->where('post_code', $param2);
            $this->db->update('forum', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            redirect(base_url() . 'teacher/edit_forum/' . $param2 , 'refresh');
        }
        if ($param1 == 'delete')
        {

            $this->crud_model->delete_post($param2);

            $this->db->where('table_id',$param2);
            $this->db->where('form',"forum");
            $this->db->delete('notification');

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/forum/'.$param3."/" , 'refresh');

        }
        $page_data['data'] = $param1;
        $page_data['page_name'] = 'forum';
        $page_data['page_title'] = get_phrase('forum');
        $this->load->view('backend/index', $page_data);
    }

    function single_homework($param1 = '', $param2 = '') 
    {
       if ($this->session->userdata('teacher_login') != 1)
       {
            redirect(base_url(), 'refresh');
       }
       
       $page_data['answer_id'] = $param1;
       $page_data['page_name'] = 'single_homework';
       $page_data['page_title'] = get_phrase('homework');
       $this->load->view('backend/index', $page_data);
    }

    function create_online_exam($info = '') 
    {   
        
        if ($this->session->userdata('teacher_login') != 1){
                redirect(base_url(), 'refresh');
            }

        $code = substr(md5(uniqid(rand(), true)), 0, 7);
        $year =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        
        $data['sem_category'] = $this->input->post('semester_category');
        $data['is_random'] = $this->input->post('is_random');
        $data['examdate'] = $this->input->post('exam_date');
        $data['publish_date'] = date('Y-m-d H:i:s');
        $data['uploader_type'] = $this->session->userdata('login_type');
        $data['wall_type'] = "exam";
        $data['uploader_id'] = $this->session->userdata('login_user_id');
        $data['upload_date'] = date('d M. H:iA');
        $data['code']  = $code;
        $data['title'] = html_escape($this->input->post('exam_title'));
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['minimum_percentage'] = html_escape($this->input->post('minimum_percentage'));
        $data['instruction'] = html_escape($this->input->post('instruction'));
        $data['exam_date'] = strtotime(html_escape($this->input->post('exam_date')));
        $data['time_start'] = html_escape($this->input->post('time_start').":00");
        $data['time_end'] = html_escape($this->input->post('time_end').":00");
        $data['duration'] = strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_end']) - strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_start']);
        $data['running_year'] = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $data['semester_id'] = $this->input->post('semester_id');
        
        $this->db->insert('online_exam', $data);
        $table_id = $this->db->insert_id();

        $this->crud_model->insert_exam_order($table_id);
        
        $this->crud_model->send_exam_notify($table_id);

        $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
        
        $desc = 'Added new online exam Title: '.$data['title'] . 'Description: ' . $data['instruction'] .' Schedule:' .$data['exam_date'] . ' '.$data['time_start'] . ' ' . $data['time_end'] .' Code: '.$code;

        $this->crud_model->save_user_logs("teacher", 'Online Exam', 'Add Online Exam', $desc);

        redirect(base_url().'teacher/examroom/'.$table_id, 'refresh');

    }

    function create_online_quiz($info = '') 
    {   

        $code = substr(md5(uniqid(rand(), true)), 0, 7);
        
        $year =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        
        $data['quizdate'] = $this->input->post('quiz_date');
        $data['publish_date'] = date('Y-m-d H:i:s');
        $data['uploader_type'] = $this->session->userdata('login_type');
        $data['wall_type'] = "quiz";
        $data['uploader_id'] = $this->session->userdata('login_user_id');
        $data['upload_date'] = date('d M. H:iA');
        $data['code']  = $code;
        $data['title'] = html_escape($this->input->post('quiz_title'));
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['minimum_percentage'] = html_escape($this->input->post('minimum_percentage'));
        $data['instruction'] = html_escape($this->input->post('instruction'));
        $data['quiz_date'] = strtotime(html_escape($this->input->post('quiz_date')));
        $data['time_start'] = html_escape($this->input->post('time_start').":00");
        $data['time_end'] = html_escape($this->input->post('time_end').":00");
        $data['duration'] = strtotime(date('Y-m-d', $data['quiz_date']).' '.$data['time_end']) - strtotime(date('Y-m-d', $data['quiz_date']).' '.$data['time_start']);
        $data['running_year'] = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $data['semester_id'] = $this->input->post('semester_id');
        $this->db->insert('tbl_online_quiz', $data);
        $table_id = $this->db->insert_id();
        
        $this->crud_model->send_quiz_notify($table_id);
        
        $this->crud_model->insert_quiz_order($table_id);

        $desc = 'Added new online quiz Title: '.$data['title'] . 'Description: ' . $data['instruction'] .' Schedule:' .$data['quiz_date'] . ' '.$data['time_start'] . ' ' . $data['time_end'] .' Code: '.$code;

        $this->crud_model->save_user_logs("teacher", 'Online Quiz', 'Add Online Quiz', $desc);

        $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));

        redirect(base_url().'teacher/online_quiz/'.$info."/", 'refresh');
    }

    function manage_exams($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {

            $chk_data = $this->db->query("SELECT * from question_bank where online_exam_id = '$param2'")->num_rows();

            if($chk_data > 0){

               
            $this->session->set_flashdata('flash_message' , 'You cannot delete this record it has existing related information.');
            redirect(base_url() . 'teacher/online_exams/'.$param3."/", 'refresh');

            }else{

                $exam_title = $this->db->get_where('online_exam' , array('online_exam_id' => $param2))->row()->title;
            
                $desc = 'Delete online exasm: '.$exam_title . ' Online_exam_id:' .$param2;
                 //save logs
                $this->crud_model->save_user_logs("teacher", 'Delete Online Exam', 'Delete Online Exam', $desc);

                $this->db->where('online_exam_id', $param2);
                $this->db->delete('online_exam');

                //DELETE NOTIFICATION
                $this->db->where('table_id',$param2);
                $this->db->where('form',"online_exam");
                $this->db->delete('notification');

                $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
                redirect(base_url() . 'teacher/online_exams/'.$param3."/", 'refresh');

            }


        }elseif($param1 == 'enable'){

            $data['is_view'] = 1;

            $this->db->where('online_exam_id', $param2);

            $this->db->update('online_exam', $data);

            $this->session->set_flashdata('flash_message' , 'Exam successfully updated.');

            redirect(base_url() . 'teacher/online_exams/'.$param3."/", 'refresh');

        }elseif($param1 == 'disable'){
            
            $data['is_view'] = 0;

            $this->db->where('online_exam_id', $param2);

            $this->db->update('online_exam', $data);

            $this->session->set_flashdata('flash_message' , 'Exam successfully updated.');

            redirect(base_url() . 'teacher/online_exams/'.$param3."/", 'refresh');

        }

    }

    function manage_quiz($param1 = '', $param2 = '', $param3 = '')
    {
        
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('online_quiz_id', $param2);
            $this->db->delete('tbl_online_quiz');

             //DELETE NOTIFICATION
            $this->db->where('table_id',$param2);
            $this->db->where('form',"online_quiz");
            $this->db->delete('notification');

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_removed'));
            redirect(base_url() . 'teacher/online_quiz/'.$param3."/", 'refresh');
        }
        elseif($param1 == 'enable'){

            $data['is_view'] = 1;

            $this->db->where('online_quiz_id', $param2);

            $this->db->update('tbl_online_quiz', $data);

            $this->session->set_flashdata('flash_message' , 'Quiz successfully updated.');

            redirect(base_url() . 'teacher/online_quiz/'.$param3."/", 'refresh');

        }elseif($param1 == 'disable'){
            
            $data['is_view'] = 0;

            $this->db->where('online_quiz_id', $param2);

            $this->db->update('tbl_online_quiz', $data);

            $this->session->set_flashdata('flash_message' , 'Quiz successfully updated.');

            redirect(base_url() . 'teacher/online_quiz/'.$param3."/", 'refresh');

        }

    }

    function homework_details($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['homework_code'] = $param1;
        $page_data['page_name']  = 'homework_details';
        $page_data['page_title'] = get_phrase('homework_details');
        $this->load->view('backend/index', $page_data);
    }

    function online_exams($param1 = '', $param2 = '', $param3 ='') 
    {
        if ($param1 == 'edit') 
        {
            if ($this->input->post('class_id') > 0 && $this->input->post('section_id') > 0 && $this->input->post('subject_id') > 0) {
                $this->crud_model->update_online_exam();
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
                redirect(base_url() . 'teacher/exam_edit/' . $this->input->post('online_exam_id'), 'refresh');
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('error'));
                redirect(base_url() . 'teacher/exam_edit/' . $this->input->post('online_exam_id'), 'refresh');
            }
        }
        if ($param1 == 'questions') 
        {
            $this->crud_model->add_questions();
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'teacher/exam_questions/' . $param2 , 'refresh');
        }
        if ($param1 == 'delete_questions') 
        {
            $this->db->where('question_id', $param2);
            $this->db->delete('questions');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/exam_questions/'.$param3, 'refresh');
        }
        if ($param1 == 'delete'){
            $this->crud_model->delete_exam($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/online_exams/', 'refresh');
        }
        $page_data['data'] = $param1;
        $page_data['page_name'] = 'online_exams';
        $page_data['page_title'] = get_phrase('online_exams');
        $this->load->view('backend/index', $page_data);
    }

    //ONLINE QUIZ
    function online_quiz($param1 = '', $param2 = '', $param3 ='') 
    {
        if ($param1 == 'edit') 
        {
            if ($this->input->post('class_id') > 0 && $this->input->post('section_id') > 0 && $this->input->post('subject_id') > 0) {
                $this->crud_model->update_online_quiz();
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
                redirect(base_url() . 'teacher/quiz_edit/' . $this->input->post('online_quiz_id'), 'refresh');
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('error'));
                redirect(base_url() . 'teacher/quiz_edit/' . $this->input->post('online_quiz_id'), 'refresh');
            }
        }
        if ($param1 == 'questions') 
        {
            $this->crud_model->add_questions();
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'teacher/quiz_questions/' . $param2 , 'refresh');
        }
        if ($param1 == 'delete_questions') 
        {
            $this->db->where('question_id', $param2);
            $this->db->delete('questions');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/quiz_questions/'.$param3, 'refresh');
        }
        if ($param1 == 'delete'){
            $this->crud_model->delete_quiz($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/online_quiz/', 'refresh');
        }

        $page_data['data'] = $param1;
        $page_data['page_name'] = 'online_quiz';
        $page_data['page_title'] = get_phrase('online_quiz');
        $this->load->view('backend/index', $page_data);

    }


    function examroom($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name']   = 'exam_room'; 
        $page_data['online_exam_id']  = $param1;
        $page_data['page_title']  = get_phrase('online_exams');
        $this->load->view('backend/index', $page_data);
    }

    function quizroom($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name']   = 'quiz_room'; 
        $page_data['online_quiz_id']  = $param1;
        $page_data['page_title']  = get_phrase('online_quiz');
        $this->load->view('backend/index', $page_data);
    }

    function exam_questions($exam_code = '') 
    {    
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['exam_code'] = $exam_code;
        $page_data['page_name'] = 'exam_questions';
        $page_data['page_title'] = get_phrase('exam_questions');
        $this->load->view('backend/index', $page_data);
    }
    
    function delete_question_from_online_exam($question_id = ''){
        $online_exam_id = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->online_exam_id;
        $this->crud_model->delete_question_from_online_exam($question_id);
        $this->session->set_flashdata('flash_message' , "Eliminada");
            redirect(base_url() . 'teacher/examroom/'.$online_exam_id, 'refresh');
    }

    function update_online_exam_question($question_id = "", $task = "", $online_exam_id = "") {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $online_exam_id = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->online_exam_id;
        $type = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->type;
        if ($task == "update") {
            if ($type == 'multiple_choice') {
                $this->crud_model->update_multiple_choice_question($question_id);
            }
            elseif($type == 'true_false'){
                $this->crud_model->update_true_false_question($question_id);
            }
            elseif($type == 'fill_in_the_blanks'){
                $this->crud_model->update_fill_in_the_blanks_question($question_id);
            }elseif($type == 'essay'){
                $this->crud_model->update_essay_question($question_id);
            }elseif($type == 'image'){
                $this->crud_model->update_image_question($question_id);
            }elseif($type == 'enumeration'){
                $this->crud_model->update_enumeration_question($question_id);
            }elseif($type == 'identification'){
                $this->crud_model->update_identification_question($question_id);
            }elseif($type == 'matching_type'){
                $this->crud_model->update_matching_type_question($question_id);
            }

            redirect(base_url() . 'teacher/examroom/'.$online_exam_id, 'refresh');
        }
        $page_data['question_id'] = $question_id;
        $page_data['page_name'] = 'update_online_exam_question';
        $page_data['page_title'] = get_phrase('update_questions');
        $this->load->view('backend/index', $page_data);
    }

    function update_online_quiz_question($question_id = "", $task = "", $online_quiz_id = "") {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $online_quiz_id = $this->db->get_where('tbl_question_bank_quiz', array('question_bank_id' => $question_id))->row()->online_quiz_id;
        $type = $this->db->get_where('tbl_question_bank_quiz', array('question_bank_id' => $question_id))->row()->type;
        if ($task == "update") {
            if ($type == 'multiple_choice') {
                $this->crud_model->update_multiple_choice_question_quiz($question_id);
            }
            elseif($type == 'true_false'){
                $this->crud_model->update_true_false_question_quiz($question_id);
            }
            elseif($type == 'fill_in_the_blanks'){
                $this->crud_model->update_fill_in_the_blanks_question_quiz($question_id);
            }elseif($type == 'essay'){
                $this->crud_model->update_essay_question_quiz($question_id);
            }elseif($type == 'image'){
                $this->crud_model->update_image_question_quiz($question_id);
            }elseif($type == 'enumeration'){
                $this->crud_model->update_enumeration_question_quiz($question_id);
            }elseif($type == 'identification'){
                $this->crud_model->update_identification_question_quiz($question_id);
            }
            redirect(base_url() . 'teacher/quizroom/'.$online_quiz_id, 'refresh');
        }
        $page_data['question_id'] = $question_id;
        $page_data['page_name'] = 'update_online_quiz_question';
        $page_data['page_title'] = get_phrase('update_questions');
        $this->load->view('backend/index', $page_data);
    }

    function delete_question_from_online_quiz($question_id = ''){
        $online_quiz_id = $this->db->get_where('tbl_question_bank_quiz', array('question_bank_id' => $question_id))->row()->online_quiz_id;
        $this->crud_model->delete_question_from_online_quiz($question_id);
        $this->session->set_flashdata('flash_message' , "Removed");
            redirect(base_url() . 'teacher/quizroom/'.$online_quiz_id, 'refresh');
    }

    function manage_online_exam_question($online_exam_id = "", $task = "", $type = ""){

        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        if ($task == 'add') {
            if ($type == 'multiple_choice') {
                $this->crud_model->add_multiple_choice_question_to_online_exam($online_exam_id);
            }
            elseif ($type == 'true_false') {
                $this->crud_model->add_true_false_question_to_online_exam($online_exam_id);
            }
            elseif ($type == 'fill_in_the_blanks') {
                $this->crud_model->add_fill_in_the_blanks_question_to_online_exam($online_exam_id);
            }
            elseif ($type == 'essay') {
                $this->crud_model->add_essay_question_to_online_exam($online_exam_id);
            }
            elseif ($type == 'image') {
                $this->crud_model->add_image_question_to_online_exam($online_exam_id);
            }elseif ($type == 'enumeration') {
                $this->crud_model->add_enumeration_question_to_online_exam($online_exam_id);
            }
            elseif ($type == 'identification') {
                $this->crud_model->add_identification_question_to_online_exam($online_exam_id);
            }elseif ($type == 'matching_type') {
                $this->crud_model->add_matching_type_question_to_online_exam($online_exam_id);
            }
            redirect(base_url() . 'teacher/examroom/'.$online_exam_id, 'refresh');
        }

    }

    function manage_online_quiz_question($online_quiz_id = "", $task = "", $type = ""){

        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        if ($task == 'add') {
            if ($type == 'multiple_choice') {
                $this->crud_model->add_multiple_choice_question_to_online_quiz($online_quiz_id);
            }
            elseif ($type == 'true_false') {
                $this->crud_model->add_true_false_question_to_online_quiz($online_quiz_id);
            }
            elseif ($type == 'fill_in_the_blanks') {
                $this->crud_model->add_fill_in_the_blanks_question_to_online_quiz($online_quiz_id);
            }
            elseif ($type == 'essay') {
                $this->crud_model->add_essay_question_to_online_quiz($online_quiz_id);
            }
            elseif ($type == 'image') {
                $this->crud_model->add_image_question_to_online_quiz($online_quiz_id);
            }
            elseif ($type == 'enumeration') {
                $this->crud_model->add_enumeration_question_to_online_quiz($online_quiz_id);
            }elseif ($type == 'identification') {
                $this->crud_model->add_identification_question_to_online_quiz($online_quiz_id);
            }
            redirect(base_url() . 'teacher/quizroom/'.$online_quiz_id, 'refresh');
        }

    }

    function manage_multiple_choices_options() {
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('backend/teacher/manage_multiple_choices_options', $page_data);
    }
    
    function load_question_type($type = '', $online_exam_id = '') {
        $page_data['question_type'] = $type;
        $page_data['online_exam_id'] = $online_exam_id;
        $this->load->view('backend/teacher/online_exam_add_'.$type, $page_data);
    }

    function load_question_type_quiz($type = '', $online_quiz_id = '') {
        $page_data['question_type'] = $type;
        $page_data['online_quiz_id'] = $online_quiz_id;
        $this->load->view('backend/teacher/online_quiz_add_'.$type, $page_data);
    }

    function exam_results($exam_code = '') 
    { 
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }   
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        //remove duplicate data
            $sql = $this->db->query("DELETE t1 FROM `tbl_enumeration_data` t1 INNER  JOIN `tbl_enumeration_data` t2 WHERE t1.id < t2.id AND t1.online_exam_quiz_id = t2.online_exam_quiz_id AND t1.`student_id` = t2.`student_id` AND t1.`question_bank_id` = t2.`question_bank_id` AND t1.`answer` = t2.`answer` AND t1.`online_exam_quiz_id` = '$exam_code'");
        //remove duplicate data
        $page_data['online_exam_id'] = $exam_code;
        $page_data['page_name'] = 'exam_results';
        $page_data['page_title'] = get_phrase('exams_results');
        $this->load->view('backend/index', $page_data);
    }

    function quiz_results($exam_code = '') 
    { 
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }   
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        $page_data['online_quiz_id'] = $exam_code;
        $page_data['page_name'] = 'quiz_results';
        $page_data['page_title'] = get_phrase('quiz_results');
        $this->load->view('backend/index', $page_data);
    }

    function exam_edit($exam_code= '') 
    { 
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }   
        $page_data['online_exam_id'] = $exam_code;
        $page_data['page_name'] = 'exam_edit';
        $page_data['page_title'] = get_phrase('update_exam');
        $this->load->view('backend/index', $page_data);
    }

    function quiz_edit($exam_code= '') 
    { 
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }   
        $page_data['online_quiz_id'] = $exam_code;
        $page_data['page_name'] = 'quiz_edit';
        $page_data['page_title'] = get_phrase('update_quiz');
        $this->load->view('backend/index', $page_data);
    }

    function homework_edit($homework_code = '') 
    {   
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        } 
        $page_data['homework_code'] = $homework_code;
        $page_data['page_name'] = 'homework_edit';
        $page_data['page_title'] = get_phrase('homework');
        $this->load->view('backend/index', $page_data);
    }

    function forumroom($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        if ($param1 == 'comment') 
        {
            $page_data['room_page']    = 'comments';
            $page_data['post_code'] = $param2; 
        }
        else if ($param1 == 'posts') 
        {
            $page_data['room_page'] = 'post';
            $page_data['post_code'] = $param2; 
        }
        else if ($param1 == 'edit') 
        {
            $page_data['room_page'] = 'post_edit';
            $page_data['post_code'] = $param2;
        }

        $page_data['page_name']   = 'forum_room'; 
        $page_data['post_code']   = $param1;
        $page_data['page_title']  = get_phrase('forum');
        $this->load->view('backend/index', $page_data);
    }

    function notification($param1 ='', $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('id', $param2);
            $this->db->delete('notification');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/notifications/', 'refresh');
        }
    }

    function edit_forum($code = '')
    {
        $page_data['page_name']  = 'edit_forum';
        $page_data['page_title'] = get_phrase('update_forum');
        $page_data['code']   = $code;
        $this->load->view('backend/index', $page_data);    
    }

    function forum_message($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'add') 
        {

            $this->crud_model->create_post_message($this->input->post('post_code'));

        }elseif($param1 == 'approve'){

            $message_id = $this->input->post('message_id');
            $post_code = $this->input->post('post_code');

            $data['is_approved'] = 1;

            $this->db->where('message_id', $message_id);
            $this->db->update('forum_message', $data); 
            echo $message_id;

        }
        elseif($param1 == 'disapprove'){

            $message_id = $this->input->post('message_id');
            $post_code = $this->input->post('post_code');

            $data['is_approved'] = 2;

            $this->db->where('message_id', $message_id);
            $this->db->update('forum_message', $data); 
            echo $message_id;

        }
    }

    // Student logs modal
    function student_logs($stud_id = "",$date_trans = "",$am_pm = "") {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['stud_id'] = $stud_id;
        $page_data['date_trans'] = $date_trans;
        $page_data['am_pm'] = $am_pm;
        $page_data['page_name'] = 'student_logs';
        $page_data['page_title'] = get_phrase('view_student_logs');
        $this->load->view('backend/index', $page_data);
    }

    //Video Link
    function video_link($task = "", $document_id = "", $data = '',$form='')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        } 
        if ($task == "create")
        {
            $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            
            //INSERT VIDEO LINK
            $data_insert['description'] = $this->input->post('description');
            $data_insert['link_name'] = $this->input->post('link_name');
            $data_insert['video_host_id'] = $this->input->post('host_name');  
            $data_insert['class_id'] = $this->input->post('class_id');
            $data_insert['teacher_id'] = $this->session->userdata('login_user_id');
            $data_insert['timestamp'] = strtotime(date("Y-m-d H:i:s"));
            $data_insert['subject_id'] = $this->input->post('subject_id');
            $data_insert['type'] = $this->session->userdata('login_type');
            $data_insert['wall_type'] = 'video link';
            $data_insert['publish_date'] = date('Y-m-d H:i:s');
            $data_insert['section_id'] = $this->input->post('section_id');
            $data_insert['semester_id'] = $this->input->post('semester_id');
            $this->db->insert('tbl_video_link',$data_insert);
            $table_id = $this->db->insert_id();
            //INSERT VIDEO LINK

            $notify['notify'] = "<strong>".$this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong> ". " added new video link.";
            $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'),'section_id' => $this->input->post('section_id'), 'year' => $year))->result_array();
            foreach($students as $row)
            {
                $notify['user_id'] = $row['student_id'];
                $notify['user_type'] = 'student';
                $notify['url'] = "student/video_link/".base64_encode($this->input->post('class_id').'-'.$this->input->post('section_id').'-'.$this->input->post('subject_id'));
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['type'] = 'video link';
                $notify['status'] = 0;
                $notify['year'] = $year;
                $notify['class_id'] = $this->input->post('class_id');
                $notify['section_id'] = $this->input->post('section_id');
                $notify['subject_id'] = $this->input->post('subject_id');
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');

                $notify['table_id'] = $table_id;

                $this->db->insert('notification', $notify);
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_uploaded'));
            redirect(base_url() . 'teacher/video_link/'.$document_id."/" , 'refresh');
        }
        if($task == "update"){

            $link_id = $this->input->post('link_id');

            $up['description'] = $this->input->post('description');
            $up['link_name'] = $this->input->post('link_name');
            $up['video_host_id'] = $this->input->post('host_name');
            $up['semester_id'] = $this->input->post('semester_id');
            
            $this->db->where('link_id',  $link_id);
            $this->db->update('tbl_video_link', $up);

            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));

            if($form == 'load_dashboard'){
                
                redirect(base_url() . 'teacher/subject_dashboard/'.$data."/" , 'refresh');
               
            }else{
               
                 redirect(base_url() . 'teacher/video_link/'.$data."/" , 'refresh');

            }

        }
        if ($task == "delete")
        {   

            $this->crud_model->delete_video_link_info($document_id);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));

            if($form == 'load_dashboard'){

                redirect(base_url() . 'teacher/subject_dashboard/'.$data."/" , 'refresh');
               
            }else{
               
                redirect(base_url() . 'teacher/video_link/'.$data."/" , 'refresh');

            }

        }

        $page_data['data'] = $task;

        $page_data['page_name']              = 'video_link';

        $page_data['page_title']             = get_phrase('video_link');

        $this->load->view('backend/index', $page_data);
    }

    //Live Classroom
    function live_class($task = "", $document_id = "", $data = '',$form='')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        } 
        if ($task == "create")
        {
            $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

            //INSERT live class
            $data_live['title'] = $this->input->post('title');
            $data_live['description'] = $this->input->post('description'); 
            $data_live['host_id'] = $this->input->post('host_id');
            $data_live['start_time'] = $this->input->post('start_time');
            $data_live['start_date'] = $this->input->post('live_class_date');
            $data_live['class_id'] = $this->input->post('class_id');
            $data_live['teacher_id'] = $this->session->userdata('login_user_id');
            $data_live['timestamp'] = strtotime(date("Y-m-d H:i:s"));
            $data_live['subject_id'] = $this->input->post('subject_id');
            $data_live['type'] = $this->session->userdata('login_type');
            $data_live['wall_type'] = 'live class';
            $data_live['publish_date'] = date('Y-m-d H:i:s');
            $data_live['section_id'] = $this->input->post('section_id');
            $data_live['semester_id'] = $this->input->post('semester_id');

            $this->db->insert('tbl_live_class',$data_live); 
            $table_id = $this->db->insert_id();
            //INSERT live class

            $notify['notify'] = "<strong>".$this->crud_model->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong> ". " ".get_phrase('added_new_live_class');
            
            $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'),'section_id' => $this->input->post('section_id'), 'year' => $year))->result_array();
            
            foreach($students as $row)
            {
                $notify['user_id'] = $row['student_id'];
                $notify['user_type'] = 'student';
                $notify['url'] = "student/live_class/".base64_encode($this->input->post('class_id').'-'.$this->input->post('section_id').'-'.$this->input->post('subject_id'));
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['type'] = 'live class';
                $notify['status'] = 0;
                $notify['year'] = $year;
                $notify['class_id'] = $this->input->post('class_id');
                $notify['section_id'] = $this->input->post('section_id');
                $notify['subject_id'] = $this->input->post('subject_id');
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');

                $notify['table_id'] = $table_id;

                $this->db->insert('notification', $notify);
            }
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_uploaded'));
            redirect(base_url() . 'teacher/live_class/'.$document_id."/" , 'refresh');
        }
        if ($task == "delete")
        {
            $this->crud_model->delete_live_class_info($document_id);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));

            if($form == 'load_dashboard'){

                redirect(base_url() . 'teacher/subject_dashboard/'.$data."/" , 'refresh');

            }else{
               
                 redirect(base_url() . 'teacher/live_class/'.$data."/");

            }

        }
        if ($task == "update")
        {

            $this->crud_model->update_live_class_info();

            if($form == 'load_dashboard'){

                redirect(base_url() . 'teacher/subject_dashboard/'.$data."/" , 'refresh');

            }else{
               
                 redirect(base_url() . 'teacher/live_class/'.$data."/");

            }

            
        }
        
        $page_data['data'] = $task;
        $page_data['page_name']              = 'live_class';
        $page_data['page_title']             = get_phrase('live_class');
        $this->load->view('backend/index', $page_data);

    }

    //live class value
    function live_class_video($live_id = '') 
    {
      if ($this->session->userdata('teacher_login') != 1)
      
      { 
          redirect(base_url(), 'refresh');
      }

      $page_data['live_id'] = $live_id;
      $page_data['page_name']    = 'live_class_video';
      $page_data['page_title']   = get_phrase('live_class_video');
      
      $this->load->view('backend/index',$page_data);

    } 
    
    //Update Exam Points
    function update_points() 
    {

        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $exam_id = $this->input->post('exam_id');
        $student_id = $this->input->post('stud_id');
        $total_points = $this->input->post('totalPoints');

        

        //$data['obtained_mark'] = $total_grade;
        $data['essay_mark'] = $total_points;

        $this->db->where('online_exam_id', $exam_id);

        $this->db->where('student_id', $student_id);

        $this->db->update('online_exam_result', $data);

        $this->crud_model->update_online_exam_result($student_id,$exam_id);

    }

    function insert_update_points() 
    {

        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $exam_id = $this->input->post('exam_id');
        $student_id = $this->input->post('stud_id');
        $question_id = $this->input->post('question_id');
        $grade_val = $this->input->post('grade_val');
        $id = $this->input->post('id');

        if($id == ''){

            $essay_ins['online_exam_id'] = $exam_id;
            $essay_ins['student_id'] = $student_id;
            $essay_ins['question_id'] = $question_id;
            $essay_ins['grade'] = $grade_val;

            $this->db->insert('tbl_exam_essay_grade', $essay_ins);

        }else{

            $essay_up['online_exam_id'] = $exam_id;
            $essay_up['student_id'] = $student_id;
            $essay_up['question_id'] = $question_id;
            $essay_up['grade'] = $grade_val;
            $this->db->where('id', $id);
            $this->db->update('tbl_exam_essay_grade', $essay_up);

        }

    }

    function load_points(){

        $exam_id = $this->input->post('exam_id');
        $student_id = $this->input->post('stud_id');

        $query = $this->db->query("SELECT * FROM online_exam_result where student_id = '$student_id' and online_exam_id = '$exam_id'");

        $row = $query->row_array();

        $total_grade = 0;

        if($row['obtained_mark'] == ''){
            $obtained_mark = 0;
        }else{
             $obtained_mark = $row['obtained_mark'];
        } 

        if($row['essay_mark'] == ''){
            $essay_mark = 0;
        }else{
            $essay_mark = $row['essay_mark'];
        }   

        $mark_as_check_points = $this->db->query("SELECT sum(points) as total_points FROM tbl_exam_mark_as_check where student_id = '$student_id' and online_exam_id = '$exam_id'");

        $check_points = $mark_as_check_points->row_array();

        if($check_points['total_points'] == ''){
            $checked_points = 0;
        }else{
            $checked_points = $check_points['total_points'];
        }

        $enumeration_data = $this->db->query("SELECT sum(points) as total_points FROM tbl_enumeration_data where student_id = '$student_id' and online_exam_quiz_id = '$exam_id' and type = 'exam'");

        $enumeration_points =  $enumeration_data->row_array();

        if($enumeration_points['total_points'] == ''){
            $enumeration = 0;
        }else{
            $enumeration = $enumeration_points['total_points'];
        }

        $total_grade = $obtained_mark + $essay_mark + $checked_points + $enumeration;

        echo $total_grade;

    }

    //Add Section
    function sections($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'add_modal'){
            $data['name']       =   $this->input->post('name');
            $data['class_id']   =   $this->input->post('class_id');
            $data['teacher_id'] =   $this->input->post('teacher_id');
            $this->db->insert('section' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
            redirect(base_url() . 'teacher/grados/', 'refresh');
        }
        // if ($param1 == 'edit') {
        //     $data['name']       =   $this->input->post('name');
        //     $data['class_id']   =   $this->input->post('class_id');
        //     $data['teacher_id'] =   $this->input->post('teacher_id');
        //     $this->db->where('section_id' , $param2);
        //     $this->db->update('section' , $data);
        //     redirect(base_url() . 'teacher/section/' . $data['class_id'] , 'refresh');
        // }
        // if ($param1 == 'delete') 
        // {
        //     $this->db->where('section_id' , $param2);
        //     $this->db->delete('section');
        //     $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
        //     redirect(base_url() . 'teacher/section/' , 'refresh');
        // }
    }

    //Add Student
    function student($param1 = '', $param2 = '', $param3 = '', $param4 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
           redirect(base_url(), 'refresh');
        }

        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

        if($param1 == 'accept')
        {
            $pending = $this->db->get_where('pending_users', array('user_id' => $param2))->result_array();
            foreach ($pending as $row) 
            {
                $data['first_name'] = $row['first_name'];
                $data['last_name'] = $row['last_name'];
                $data['email'] = $row['email'];
                $data['username'] = $row['username'];
                $data['sex'] = $row['sex'];
                if($this->input->post('password') != "")
                {
                    $data['password']  = sha1($this->input->post('password'));
                    $string_to_encrypt = $this->input->post('password');
                    $password="password";
                    $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
                    $data['password_md5'] = $encrypted_string;
                }
                $data['birthday'] = $row['birthday'];
                $data['phone'] = $row['phone'];
                $data['since'] = $row['since'];
                $data['date'] = date('d M, Y');
                $this->db->insert('student', $data);
                $student_id = $this->db->insert_id();

                $data2['student_id']     = $student_id;
                $data2['enroll_code']    = substr(md5(rand(0, 1000000)), 0, 7);
                $data2['class_id']       = $row['class_id'];
                $data2['section_id']     = $row['section_id'];
                $data2['roll']           = $row['roll'];
                $data2['date_added']     = strtotime(date("Y-m-d H:i:s"));
                $data2['year']           = $running_year;
                $this->db->insert('enroll', $data2);
                $this->crud_model->account_confirm('student', $student_id);

                $up_data['status'] = 1;
                $this->db->where('original_id', $row['code']);
                $this->db->update('notification', $up_data);

            }
            $this->db->where('user_id', $param2);
            $this->db->delete('pending_users');
            $this->session->set_flashdata('flash_message' , get_phrase('Student successfully accepted.'));
            redirect(base_url() . 'teacher/pending/'.$param3.'/'.$param4, 'refresh');
        }
        if ($param1 == 'do_update') 
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            $data['first_name']      = $this->input->post('first_name');
            $data['last_name']       = $this->input->post('last_name');
            $data['birthday']        = $this->input->post('datetimepicker');
            $data['email']           = $this->input->post('email');
            $data['phone']           = $this->input->post('phone');
            $data['sex']             = $this->input->post('gender');
            $data['username']        = $this->input->post('username');
            if($this->input->post('password') != "")
            {
                $data['password'] = sha1($this->input->post('password'));
                $string_to_encrypt=$this->input->post('password');
                $password="password";
                $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
                $data['password_md5'] = $encrypted_string;
            }
            $data['address']         = $this->input->post('address');
            $data['transport_id']    = $this->input->post('transport_id');
            $data['dormitory_id']    = $this->input->post('dormitory_id');
            $data['diseases']    = $this->input->post('diseases');
            $data['allergies']    = $this->input->post('allergies');
            $data['doctor']    = $this->input->post('doctor');
            $data['doctor_phone']    = $this->input->post('doctor_phone');
            $data['authorized_person']    = $this->input->post('auth_person');
            $data['authorized_phone']    = $this->input->post('auth_phone');
            $data['note']    = $this->input->post('note');
            if($_FILES['userfile']['size'] > 0){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            $data['parent_id']       = $this->input->post('parent_id');
            $data['student_session'] = $this->input->post('student_session');
            $this->db->where('student_id', $param2);
            $this->db->update('student', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));

            $data2['roll'] = $this->input->post('roll');
            $data2['class_id'] = $this->input->post('class_id');
            $data2['section_id'] = $this->input->post('section_id');
            $this->db->where('student_id', $param2);
            $this->db->update('enroll', $data2);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
            $this->crud_model->clear_cache();
            redirect(base_url() . 'teacher/student_update/'. $param2.'/', 'refresh');
        }
        if ($param1 == 'do_updates') 
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            $data['first_name']            = $this->input->post('first_name');
            $data['last_name']            = $this->input->post('last_name');
            $data['username']        = $this->input->post('username');
            $data['phone']           = $this->input->post('phone');
            $data['address']         = $this->input->post('address');
            $data['parent_id']       = $this->input->post('parent_id');
            $data['student_session'] = $this->input->post('student_session');
            $data['email']           = $this->input->post('email');
            if($_FILES['userfile']['size'] > 0){
                $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
            }
            if($this->input->post('password') != "")
            {
                $data['password'] = sha1($this->input->post('password'));
                $string_to_encrypt=$this->input->post('password');
                $password="password";
                $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
                $data['password_md5'] = $encrypted_string;
            }
            $this->db->where('student_id', $param2);
            $this->db->update('student', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_updated'));
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));

            $c_id = $this->input->post('class_id');
            echo 1;
            redirect(base_url() . 'teacher/students/'.$c_id, 'refresh');
        }

    }

    function students($id = '')
    {
      if ($this->session->userdata('teacher_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }
     
      $page_data['page_name']   = 'students';
      $page_data['page_title']  = get_phrase('students');
      $page_data['class_id']  = $id;
      $this->load->view('backend/index', $page_data);
    }

    function students_enrolled($param1 = '', $param2 = '')
    {
      if ($this->session->userdata('teacher_login') != 1)
      {
        redirect(base_url(), 'refresh');
      }

      if ($param1 == 'Add') {

        $row_data = explode('-', base64_decode($param2)); 
        $data['student_id'] = $this->input->post('stud_list');
        $data['class_id']   = $row_data[0];
        $data['section_id'] = $row_data[1];
        $data['subject_id'] = $row_data[2];
        $data['teacher_id'] = $this->session->userdata('login_user_id');
        $data['date_added'] = date("Y-m-d");
        $data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->db->insert('tbl_students_subject' , $data);
        $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
        echo 1;
        redirect(base_url() . 'teacher/students_enrolled/'.$param2, 'refresh');
      }
     
      $page_data['page_name']  = 'students_enrolled';
      $page_data['page_title'] = get_phrase('students_enrolled');
      $page_data['data'] = $param1;
      $this->load->view('backend/index', $page_data);
    }

    //Pending User
    function pending($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['class_id']   = $param1;
        $page_data['t_id']       = $param2;
        $page_data['page_name']  = 'pending';
        $page_data['page_title'] = get_phrase('pending_users');
        $this->load->view('backend/index', $page_data);
    }

    function admissions($param1 = '', $param2 = '', $param3 = '', $param4 = '')
    {
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($_GET['id'] != "")
        {
            $notify['status'] = 1;
            $this->db->where('id', $_GET['id']);
            $this->db->update('notification', $notify);
        }
        if($param1 == 'reject')
        {
            $this->db->where('user_id', $param2);
            $this->db->delete('pending_users');
            $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
            redirect(base_url() . 'teacher/pending/'.$param3.'/'.$param4, 'refresh');
        }
        $page_data['page_name']  = 'admissions';
        $page_data['page_title'] = get_phrase('admissions');
        $this->load->view('backend/index', $page_data);
    }

    function delete_multiple_student() 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if(isset($_POST["id"]))
        {

            foreach($_POST["id"] as $id )
            {

                $homework = $this->db->query("SELECT * FROM deliveries where student_id = '$id'")->num_rows();

                $online_quiz = $this->db->query("SELECT * FROM tbl_online_quiz_result where student_id = '$id'")->num_rows();

                $online_exam = $this->db->query("SELECT * FROM online_exam_result where student_id = '$id'")->num_rows();

                $attendance_logs = $this->db->query("SELECT * FROM tbl_attendance_logs where student_id = '$id'")->num_rows();

                $book_request = $this->db->query("SELECT * FROM book_request where student_id = '$id'")->num_rows();

                if($homework == 0 and $online_quiz == 0 and $online_exam == 0 and $attendance_logs == 0 and $book_request == 0){
                    //can be delete

                    $tables = array('student', 'attendance', 'enroll', 'invoice', 'mark', 'payment', 'students_request', 'reporte_alumnos');
                    $this->db->delete($tables, array('student_id' => $id));
                    $threads = $this->db->get('message_thread')->result_array();
                    if (count($threads) > 0) 
                    {
                        foreach ($threads as $row) 
                        {
                            $sender = explode('-', $row['sender']);
                            $receiver = explode('-', $row['reciever']);
                            if (($sender[0] == 'student' && $sender[1] == $id) || ($receiver[0] == 'student' && $receiver[1] == $id)) 
                            {
                                $thread_code = $row['message_thread_code'];
                                $this->db->delete('message', array('message_thread_code' => $thread_code));
                                $this->db->delete('message_thread', array('message_thread_code' => $thread_code));
                            }
                        }
                    }

                }else{
                    //cannot be delete

                    //echo 0;

                }
            }
        }
    }

    function manage_image_options() {
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('backend/teacher/manage_image_options', $page_data);
    }


    //Update Quiz Points
    function update_points_quiz() 
    {

        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $quiz_id = $this->input->post('quiz_id');
        $student_id = $this->input->post('stud_id');
        $total_points = $this->input->post('totalPoints');

        $data['essay_mark'] = $total_points;

        $this->db->where('online_quiz_id', $quiz_id);

        $this->db->where('student_id', $student_id);

        $this->db->update('tbl_online_quiz_result', $data);

        $this->crud_model->update_online_quiz_result($student_id,$quiz_id);
        
    }

    function insert_update_points_quiz() 
    {

        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $quiz_id = $this->input->post('quiz_id');
        $student_id = $this->input->post('stud_id');
        $question_id = $this->input->post('question_id');
        $grade_val = $this->input->post('grade_val');
        $id = $this->input->post('id');

        if($id == ''){

            $essay_ins['online_quiz_id'] = $quiz_id;
            $essay_ins['student_id'] = $student_id;
            $essay_ins['question_id'] = $question_id;
            $essay_ins['grade'] = $grade_val;

            $this->db->insert('tbl_quiz_essay_grade', $essay_ins);

        }else{

            $essay_up['online_quiz_id'] = $quiz_id;
            $essay_up['student_id'] = $student_id;
            $essay_up['question_id'] = $question_id;
            $essay_up['grade'] = $grade_val;
            $this->db->where('id', $id);
            $this->db->update('tbl_quiz_essay_grade', $essay_up);

        }

    }

    function load_points_quiz(){

        $quiz_id = $this->input->post('quiz_id');
        $student_id = $this->input->post('stud_id');

        $query = $this->db->query("SELECT * FROM tbl_online_quiz_result where student_id = '$student_id' and online_quiz_id = '$quiz_id'");

        $row = $query->row_array();

        $total_grade = 0;

        if($row['obtained_mark'] == ''){
            $obtained_mark = 0;
        }else{
             $obtained_mark = $row['obtained_mark'];
        } 

        if($row['essay_mark'] == ''){
            $essay_mark = 0;
        }else{
            $essay_mark = $row['essay_mark'];
        }   

        $mark_as_check_points = $this->db->query("SELECT sum(points) as total_points FROM tbl_quiz_mark_as_check where student_id = '$student_id' and online_quiz_id = '$quiz_id'");

        $check_points = $mark_as_check_points->row_array();

        if($check_points['total_points'] == ''){
            $checked_points = 0;
        }else{
            $checked_points = $check_points['total_points'];
        }

        $enumeration_data = $this->db->query("SELECT sum(points) as total_points FROM tbl_enumeration_data where student_id = '$student_id' and online_exam_quiz_id = '$quiz_id' and type = 'quiz'");

        $enumeration_points =  $enumeration_data->row_array();

        if($enumeration_points['total_points'] == ''){
            $enumeration = 0;
        }else{
            $enumeration = $enumeration_points['total_points'];
        }

        $total_grade = $obtained_mark + $essay_mark + $checked_points + $enumeration;

        echo $total_grade;

    }

    function student_portal($student_id, $param1='')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->row()->class_id;
        $student_name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $system = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
        $page_data['page_name']  = 'student_portal';
        $page_data['page_title'] =  get_phrase('student_portal');
        $page_data['student_id'] =  $student_id;
        $page_data['class_id']   =   $class_id;
        $this->load->view('backend/index', $page_data);
    }
    
    function student_update($student_id = '', $param1='')
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->row()->class_id;
        $page_data['page_name']  = 'student_update';
        $page_data['page_title'] =  get_phrase('student_portal');
        $page_data['student_id'] =  $student_id;
        $page_data['class_id']   =   $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function load_pending_users($param1 = '',$param2 = '')
    {       

        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        else
        {
            $class_id =  $param1;
            $tid      =  $param2;

            $sec = $this->db->get_where('section', array('class_id' => $class_id), array('teacher_id' => $tid))->row()->section_id;

            $pending_users = $this->db->query("SELECT * FROM pending_users WHERE class_id = $class_id AND section_id = $sec AND type = 'student' OR type = 'parent'")->result_array();

            //$query = $this->db->get('pending_users')->result_array();

            echo json_encode($pending_users);
        }
    }

    //Live Conference
    function live_conference($task = "")
    {

        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        } 

      $page_data['data']       = $task;
      $page_data['page_name']  = 'live_conference';
      $page_data['page_title'] = get_phrase('live_conference');
      $this->load->view('backend/index', $page_data);
    }

    function retake_examiner($online_exam_id="") 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

        $class_id = $this->db->query("SELECT class_id from online_exam where online_exam_id = '$online_exam_id'")->row()->class_id;

        $section_id = $this->db->query("SELECT section_id from online_exam where online_exam_id = '$online_exam_id'")->row()->section_id;

        $subject_id = $this->db->query("SELECT subject_id from online_exam where online_exam_id = '$online_exam_id'")->row()->subject_id;

        $code = $this->db->query("SELECT code from online_exam where online_exam_id = '$online_exam_id'")->row()->code;

        $teacher_id = $this->session->userdata('login_user_id');

        $name = $this->crud_model->get_name('teacher', $teacher_id);

        if(isset($_POST["id"]))
        {

             foreach($_POST["id"] as $id )
             {

                $student_name = $this->crud_model->get_name('student', $id);
                //save logs
                $this->crud_model->save_user_logs("teacher", 'Online Exam', 'Retake Online Exam', 'Removed the exam result of '.$student_name. ' to retake the exam.');

                //insert student previews exam details

                $answer_script = $this->db->query("SELECT answer_script from online_exam_result where online_exam_id = '$online_exam_id' and student_id = '$id'")->row()->answer_script;

                $date_start = $this->db->query("SELECT exam_started_timestamp from online_exam_result where online_exam_id = '$online_exam_id' and student_id = '$id'")->row()->exam_started_timestamp;

                $date_end = $this->db->query("SELECT exam_endtime from online_exam_result where online_exam_id = '$online_exam_id' and student_id = '$id'")->row()->exam_endtime;

                $status = $this->db->query("SELECT result from online_exam_result where online_exam_id = '$online_exam_id' and student_id = '$id'")->row()->result;


                $check_result = $this->db->query("SELECT * from online_exam_result where online_exam_id = '$online_exam_id' and student_id = '$id'")->num_rows();

                //Get points
                $total_mark = $this->crud_model->get_total_mark($online_exam_id);

                $points = $this->crud_model->obtained_points_exam($online_exam_id,$id);

                if($check_result > 0){
                    $this->crud_model->save_retake_details($online_exam_id, $id,'exam',$points,$answer_script,$date_start,$date_end,$status);
                }
                //insert student previews exam details

                //remove student points in the tbl_exam_essay_grade
                $this->db->where('online_exam_id' , $online_exam_id);
                $this->db->where('student_id' , $id);
                $this->db->delete('tbl_exam_essay_grade');

                //remove student points in the tbl_exam_mark_as_check
                $this->db->where('online_exam_id' , $online_exam_id);
                $this->db->where('student_id' , $id);
                $this->db->delete('tbl_exam_mark_as_check');

                //remove student points in the tbl_enumeration_data
                $this->db->where('online_exam_quiz_id' , $online_exam_id);
                $this->db->where('student_id' , $id);
                $this->db->where('type' , 'exam');
                $this->db->delete('tbl_enumeration_data');

                //remove student data in the tbl_exam_temp_table
                $this->db->where('online_exam_id' , $online_exam_id);
                $this->db->where('student_id' , $id);
                $this->db->delete('tbl_exam_temp_table');
                
                //remove student result
                $this->db->where('online_exam_id' , $online_exam_id);
                $this->db->where('student_id' , $id);
                $this->db->delete('online_exam_result');

                //notify student
                
                $notify['notify'] = "<strong>".$name."</strong>". " ordered you to retake your exam, click this notification to redirect to your exam</b>";

                $notify['user_id'] = $id;

                $notify['user_type'] = 'student';

                $notify['url'] = "student/online_exams/".base64_encode($class_id.'-'.$section_id.'-'.$subject_id);
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['status'] = 0;
                $notify['type'] = 'exam';
                $notify['year'] = $year;
                $notify['class_id'] = $class_id;
                $notify['section_id'] = $section_id;
                $notify['subject_id'] = $subject_id;
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');
                $notify['table_id'] = $online_exam_id;
                $notify['form'] = "online_exam_retake";
                $this->db->insert('notification', $notify);

                //echo $notify;


             }
             
        }
        
    } 

   function retake_quiz($online_quiz_id="") 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

         $class_id = $this->db->query("SELECT class_id from tbl_online_quiz where online_quiz_id = '$online_quiz_id'")->row()->class_id;

         $section_id = $this->db->query("SELECT section_id from tbl_online_quiz where online_quiz_id = '$online_quiz_id'")->row()->section_id;

         $subject_id = $this->db->query("SELECT subject_id from tbl_online_quiz where online_quiz_id = '$online_quiz_id'")->row()->subject_id;

         $code = $this->db->query("SELECT code from tbl_online_quiz where online_quiz_id = '$online_quiz_id'")->row()->code;

         $teacher_id = $this->session->userdata('login_user_id');

         $name = $this->crud_model->get_name('teacher', $teacher_id);

        if(isset($_POST["id"]))
        {

             foreach($_POST["id"] as $id )
             {

                $student_name = $this->crud_model->get_name('student', $id);
                //save logs
                $this->crud_model->save_user_logs("teacher", 'Online Quiz', 'Retake Online Quiz', 'Removed the quiz result of '.$student_name. ' to retake the quiz.');

                //insert student previews quiz details

                $answer_script = $this->db->query("SELECT answer_script from tbl_online_quiz_result where online_quiz_id = '$online_quiz_id' and student_id = '$id'")->row()->answer_script;

                $date_start = $this->db->query("SELECT quiz_started_timestamp from tbl_online_quiz_result where online_quiz_id = '$online_quiz_id' and student_id = '$id'")->row()->quiz_started_timestamp;

                $date_end = $this->db->query("SELECT quiz_endtime from tbl_online_quiz_result where online_quiz_id = '$online_quiz_id' and student_id = '$id'")->row()->quiz_endtime;

                $status = $this->db->query("SELECT result from tbl_online_quiz_result where online_quiz_id = '$online_quiz_id' and student_id = '$id'")->row()->result;

                //Get points
                $points = $this->crud_model->obtained_points_quiz($online_quiz_id,$id);

                $this->crud_model->save_retake_details($online_quiz_id, $id,'quiz',$points,$answer_script,$date_start,$date_end,$status);

                //insert student previews quiz details

                //remove student points in the tbl_exam_essay_grade
                $this->db->where('online_quiz_id' , $online_quiz_id);
                $this->db->where('student_id' , $id);
                $this->db->delete('tbl_quiz_essay_grade');

                //remove student points in the tbl_quiz_mark_as_check
                $this->db->where('online_quiz_id' , $online_quiz_id);
                $this->db->where('student_id' , $id);
                $this->db->delete('tbl_quiz_mark_as_check');

                //remove student points in the tbl_enumeration_data
                $this->db->where('online_exam_quiz_id' , $online_quiz_id);
                $this->db->where('student_id' , $id);
                $this->db->where('type' , 'quiz');
                $this->db->delete('tbl_enumeration_data');

                //remove student data in the tbl_quiz_temp_table
                $this->db->where('online_quiz_id' , $online_quiz_id);
                $this->db->where('student_id' , $id);
                $this->db->delete('tbl_quiz_temp_table');

                //remove student result
                $this->db->where('online_quiz_id' , $online_quiz_id);
                $this->db->where('student_id' , $id);
                $this->db->delete('tbl_online_quiz_result');

                //notify student
                
                $notify['notify'] = "<strong>".$name."</strong>". " ordered you to retake your quiz, click this notification to redirect to your quiz</b>";

                $notify['user_id'] = $id;

                $notify['user_type'] = 'student';

                $notify['url'] = "student/online_quiz/".base64_encode($class_id.'-'.$section_id.'-'.$subject_id);
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['status'] = 0;
                $notify['type'] = 'quiz';
                $notify['year'] = $year;
                $notify['class_id'] = $class_id;
                $notify['section_id'] = $section_id;
                $notify['subject_id'] = $subject_id;
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');
                $notify['table_id'] = $online_quiz_id;
                $notify['form'] = "online_quiz_retake";
                $this->db->insert('notification', $notify);

                //echo $notify;

             }
             
        }
        
    }

    function online_exam_print_view($online_exam_id) 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['online_exam_id'] =   $online_exam_id;
        $this->load->view('backend/admin/online_exam_print_view', $page_data);
    }

    function remove_student() 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($_POST["Id"] != "")
        {
            $id = $_POST["Id"];
            $this->db->query("DELETE FROM tbl_students_subject WHERE Id ='$id'");
            echo 1;
        }
        else{
            echo 2;
        }
    }

    function multiple_exclude_student() 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $subject_id = $this->input->post('subject_id');

        if(isset($_POST["id"]))
        {

            foreach($_POST["id"] as $id )
            {

                $data['student_id'] = $id;
                $data['class_id']   = $class_id;
                $data['section_id'] = $section_id; 
                $data['subject_id'] = $subject_id;
                $data['teacher_id'] = $this->session->userdata('login_user_id');
                $data['date_excluded'] = date("Y-m-d");
                $data['year'] = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                $this->db->insert('tbl_stud_subject_exclusion' , $data);
                echo 1;

            }
         
        }
        else{
            echo 2;
        }
    }

    // New Update 10-09-2020
    function multiple_delete_exam_question(){

        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if(isset($_POST["id"]))
        {

             foreach($_POST["id"] as $id )
             {
                //insert to tbl_allowed_examiners

                $this->db->where('question_bank_id' , $id);
                $this->db->delete('question_bank');
                
             }
             
        }

    }

    function exam_preview($online_exam_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name']   = 'exam_preview'; 
        $page_data['online_exam_id']  = $online_exam_id;
        $page_data['page_title']  = get_phrase('Preview Examination');
        $this->load->view('backend/index', $page_data);
    }
    // New Update 10-09-2020

    //Manage Question Directions
    function save_update_direction(){

        $direction_id = $this->input->post('direction_id');
        $online_exam_id = $this->input->post('online_exam_id');
        $direction = $this->input->post('direction');
        $question_type = $this->input->post('q_type');

        if($direction_id <> ''){
            //update

            $data_up['directions'] = $direction;
            $this->db->where('id', $direction_id);
            $this->db->update('tbl_exam_directions', $data_up);

            echo 2;

        }else{
            //insert

            $check_duplicate = $this->db->query("SELECT * from tbl_exam_directions where online_exam_id = '$online_exam_id' and question_type = '$question_type'")->num_rows();

            if($check_duplicate > 0){
                
                echo 404;
            
            }else{

                $data['directions'] = $direction;
                $data['online_exam_id'] = $online_exam_id;
                $data['date_modified'] = date('Y-m-d h:i:s');
                $data['question_type'] = $question_type;

                $this->db->insert('tbl_exam_directions', $data);

                echo 1;

            }

        }

    }

    function load_directions(){
        
        $online_exam_id = $this->input->post('online_exam_id');

        $query = $this->db->query("SELECT * from tbl_exam_directions where online_exam_id = '$online_exam_id'")->result_array();

        echo json_encode($query);

    }

    function delete_direction(){

        $id = $this->input->post('id');
        $this->db->where('id',$id);
        $this->db->delete('tbl_exam_directions');

    }

    function load_direction_data(){
        $id = $this->input->post('id');

        $direction = $this->db->query("SELECT directions from tbl_exam_directions where id = '$id'")->row()->directions;

        echo $direction;

    }

    function load_question_type_data(){
        $id = $this->input->post('id');

        $question_type = $this->db->query("SELECT question_type from tbl_exam_directions where id = '$id'")->row()->question_type;

        echo $question_type;

    }

    //Manage Question Directions

    //Manage Quiz Directions
    function save_update_direction_quiz(){

        $direction_id = $this->input->post('direction_id');
        $online_quiz_id = $this->input->post('online_quiz_id');
        $direction = $this->input->post('direction');
        $question_type = $this->input->post('q_type');

        if($direction_id <> ''){
            //update

            $data_up['directions'] = $direction;
            $data_up['date_modified'] = date('Y-m-d h:i:s');
            $this->db->where('id', $direction_id);
            $this->db->update('tbl_quiz_directions', $data_up);

            echo 2;

        }else{
            //insert

            $check_duplicate = $this->db->query("SELECT * from tbl_quiz_directions where online_quiz_id = '$online_quiz_id' and question_type = '$question_type'")->num_rows();

            if($check_duplicate > 0){
                
                echo 404;
            
            }else{

                $data['directions'] = $direction;
                $data['online_quiz_id'] = $online_quiz_id;
                $data['date_modified'] = date('Y-m-d h:i:s');
                $data['question_type'] = $question_type;

                $this->db->insert('tbl_quiz_directions', $data);

                echo 1;

            }

        }

    }

    function load_directions_quiz(){
        
        $online_quiz_id = $this->input->post('online_quiz_id');

        $query = $this->db->query("SELECT * from tbl_quiz_directions where online_quiz_id = '$online_quiz_id'")->result_array();

        echo json_encode($query);

    }

    function delete_direction_quiz(){

        $id = $this->input->post('id');
        $this->db->where('id',$id);
        $this->db->delete('tbl_quiz_directions');

    }

    function load_direction_data_quiz(){
        $id = $this->input->post('id');

        $direction = $this->db->query("SELECT directions from tbl_quiz_directions where id = '$id'")->row()->directions;

        echo $direction;

    }

    function load_question_type_data_quiz(){
        $id = $this->input->post('id');

        $question_type = $this->db->query("SELECT question_type from tbl_quiz_directions where id = '$id'")->row()->question_type;

        echo $question_type;

    }
    //Manage Quiz Directions

    function multiple_delete_quiz_question(){

        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if(isset($_POST["id"]))
        {

             foreach($_POST["id"] as $id )
             {
                
                $this->db->where('question_bank_id' , $id);
                $this->db->delete('tbl_question_bank_quiz');
                
             }
             
        }

    }

    function quiz_preview($online_quiz_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name']   = 'quiz_preview'; 
        $page_data['online_quiz_id']  = $online_quiz_id;
        $page_data['page_title']  = get_phrase('Preview Quiz');
        $this->load->view('backend/index', $page_data);
    }

    //Manage Online Exam/Quiz Points

    function mark_as_correct_exam() 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $question_bank_id = $this->input->post('question_bank_id');
        $online_exam_id = $this->input->post('exam_id');
        $student_id = $this->input->post('stud_id');
        $points = $this->input->post('points');

        $check_duplicate = $this->db->query("SELECT * from tbl_exam_mark_as_check where question_bank_id = '$question_bank_id' and online_exam_id = '$online_exam_id' and student_id = '$student_id'")->num_rows();

        if($check_duplicate > 0){
            echo 404;
        }else{

            $data['question_bank_id'] = $question_bank_id;
            $data['student_id'] = $this->input->post('stud_id');
            $data['online_exam_id'] = $this->input->post('exam_id');
            $data['points'] = $points;
            $data['date_mark'] = date('Y-m-d h:i:s');

            $this->db->insert('tbl_exam_mark_as_check', $data);

            $this->crud_model->update_online_exam_result($student_id,$online_exam_id);

            echo 1;

        }
        
    }

    function mark_as_wrong_exam() 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $question_bank_id = $this->input->post('id');
        $online_exam_id = $this->input->post('exam_id');
        $student_id = $this->input->post('stud_id');

        $this->db->where('question_bank_id' , $question_bank_id);
        $this->db->where('online_exam_id' , $online_exam_id);
        $this->db->where('student_id' , $student_id);
        $this->db->delete('tbl_exam_mark_as_check');
        $this->crud_model->update_online_exam_result($student_id,$online_exam_id);
        echo 1;

    }

    function mark_as_correct_quiz() 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $question_bank_id = $this->input->post('question_bank_id');
        $online_quiz_id = $this->input->post('quiz_id');
        $student_id = $this->input->post('stud_id');
        $points = $this->input->post('points');

        $check_duplicate = $this->db->query("SELECT * from tbl_quiz_mark_as_check where question_bank_id = '$question_bank_id' and online_quiz_id = '$online_quiz_id' and student_id = '$student_id'")->num_rows();

        if($check_duplicate > 0){
            echo 404;
        }else{

            $data['question_bank_id'] = $question_bank_id;
            $data['student_id'] = $this->input->post('stud_id');
            $data['online_quiz_id'] = $this->input->post('quiz_id');
            $data['points'] = $points;
            $data['date_mark'] = date('Y-m-d h:i:s');

            $this->db->insert('tbl_quiz_mark_as_check', $data);

            $this->crud_model->update_online_quiz_result($student_id,$online_quiz_id);

            echo 1;

        }
        
    }

    function mark_as_wrong_quiz() 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $question_bank_id = $this->input->post('id');
        $online_quiz_id = $this->input->post('quiz_id');
        $student_id = $this->input->post('stud_id');

        $this->db->where('question_bank_id' , $question_bank_id);
        $this->db->where('online_quiz_id' , $online_quiz_id);
        $this->db->where('student_id' , $student_id);
        $this->db->delete('tbl_quiz_mark_as_check');

        $this->crud_model->update_online_quiz_result($student_id,$online_quiz_id);

        echo 1;

    }

    //Manage Online Exam/Quiz Points

    //My Subjects 
    function my_subjects()
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $sem_id = $this->input->post('sem_id');

        if ($sem_id == "") {
            $exam_id = $this->db->query("SELECT * FROM exam WHERE category = '2' AND status = '1'")->row()->exam_id;
        }
        else{
            $exam_id = $sem_id;
        }

        $page_data['exam_id']  = $exam_id;
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('my_subject_lists');
        $this->load->view('backend/index', $page_data);
    }

    //Live Consultation
    function live_consultation($task = "")
    {

        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        } 
        
        $page_data['data']       = $task;
        $page_data['page_name']  = 'live_consultation';
        $page_data['page_title'] = get_phrase('live_consultation');
        $this->load->view('backend/index', $page_data);
    }  

    //Manage Froala in the study material
    function load_studymaterial_form($class_id = '', $section_id = '',$subject_id = '',$data = '') {

        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['subject_id'] = $subject_id;
        $page_data['data'] = $data;

        $this->load->view('backend/teacher/add_study_material', $page_data);
    }

    function study_material_preview_data($document_id){

        $page_data['document_id'] = $document_id;
        $page_data['page_name']   = 'study_material_preview_data';
        $page_data['page_title']  = get_phrase('study_material_preview_data');
        $this->load->view('backend/index', $page_data);

    }

    function load_study_material_data($document_id) {

        $page_data['document_id'] = $document_id;
        $this->load->view('backend/teacher/view_study_material', $page_data);

    }

    function update_study_material(){

        $document_id = $this->input->post('document_id');
        $txt_data = $this->input->post('txt_data');

        $up_data['document'] = $txt_data;
        $this->db->where('document_id', $document_id);
        $this->db->update('document', $up_data);

    }
    //End Manage Froala in the study material

    //Retake Activity
    function retake_activity($homework_id="") 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

        $homework_code = $this->db->query("SELECT homework_code from homework where homework_id = '$homework_id'")->row()->homework_code;

         $class_id = $this->db->query("SELECT class_id from deliveries where homework_code = '$homework_code'")->row()->class_id;

         $section_id = $this->db->query("SELECT section_id from deliveries where homework_code = '$homework_code'")->row()->section_id;

         $subject_id = $this->db->query("SELECT subject_id from deliveries where homework_code = '$homework_code'")->row()->subject_id;
         
         $teacher_id = $this->session->userdata('login_user_id');

         $name = $this->crud_model->get_name('teacher', $teacher_id);

        if(isset($_POST["id"]))
        {

             foreach($_POST["id"] as $id )
             {

                
                $student_name = $this->crud_model->get_name('student', $id);
                //save logs
                $this->crud_model->save_user_logs("teacher", 'Activity', 'Retake Activity', 'Removed the activity result of '.$student_name. ' to resend his/her answer.');

              
                //remove student result
                $this->db->where('homework_code' , $homework_code);
                $this->db->where('student_id' , $id);
                $this->db->delete('deliveries');

                //notify student
                
                $notify['notify'] = "<strong>".$name."</strong>". " ordered you to resend your answer, click this notification to redirect to your activity</b>";

                $notify['user_id'] = $id;

                $notify['user_type'] = 'student';
                $notify['url'] = "student/homeworkroom/".$homework_code;
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['status'] = 0;
                $notify['type'] = 'activity';
                $notify['year'] = $year;
                $notify['class_id'] = $class_id;
                $notify['section_id'] = $section_id;
                $notify['subject_id'] = $subject_id;
                $notify['original_id'] = $this->session->userdata('login_user_id');
                $notify['original_type'] = $this->session->userdata('login_type');
                $notify['table_id'] = $homework_id;
                $notify['form'] = "activity_retake";
                $this->db->insert('notification', $notify);

                //echo $notify;

             }
             
        }
        
    }  
    
    function load_activity_view_froala($answer_id) {

        $page_data['answer_id'] = $answer_id;
        $this->load->view('backend/teacher/view_homework_froala', $page_data);

    }

    //Manage Froala in the homework
    function load_homework_form($class_id="",$section_id="",$subject_id="") {
        
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['subject_id'] = $subject_id;
        $page_data['page_name']   = 'homework_form';
        $page_data['page_title']  = get_phrase('Add new Activity');
        $this->load->view('backend/index', $page_data);

    }

    function load_homework_form_froala($homework_id="") {

        $page_data['homework_id'] = $homework_id; 
        
        $this->load->view('backend/teacher/homework_froala',$page_data);

    }
    //End Manage Froala in the homework

    //Manage Enumeration options Exam/ Quiz
    function manage_enumeration_options() {
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('backend/teacher/manage_enumeration_options', $page_data);
    }

    function load_enumeration_points(){

        $online_exam_quiz_id = $this->input->post('online_exam_quiz_id');
        $question_bank_id = $this->input->post('question_bank_id');
        $student_id = $this->input->post('student_id');
        $type = $this->input->post('type');

        $enumeration_points = $this->db->query("SELECT sum(points) as total_points from tbl_enumeration_data where online_exam_quiz_id = '$online_exam_quiz_id' and student_id = '$student_id' and type = '$type' and question_bank_id = '$question_bank_id'")->row_array();

        echo number_format($enumeration_points['total_points']);

    }

    function update_enumeration_status(){

        $id = $this->input->post('id');
        $status = $this->input->post('status');
        //$points = $this->input->post('points');
        $online_exam_quiz_id = $this->input->post('online_exam_quiz_id');
        $student_id = $this->input->post('student_id');
        $modified_by = $this->session->userdata('login_user_id');
        $student_name = $this->crud_model->get_name('student', $student_id);
        $type = $this->input->post('type');
        $question_bank_id = $this->input->post('question_bank_id');

        if($type == 'exam'){
          $points = $this->crud_model->get_question_details_by_id($question_bank_id, 'mark');
        }else{
          $points = $this->crud_model->get_question_details_by_id_quiz($question_bank_id, 'mark');
        }

        if($status == 1){

            $up_data['points'] = $points;
            $up_data['date_modified'] = date('Y-m-d h:i:s');
            $up_data['modified_by'] = $modified_by;
            $this->db->where('id', $id);
            $this->db->update('tbl_enumeration_data', $up_data);
            echo 1;
            
            $desc = "Modified Enumeration Data of " . $student_name .' | Status: Marked as correct'. ' | '.$type.' ID: ' . $online_exam_quiz_id;
            $this->crud_model->save_user_logs("teacher", 'Modify Enumeration Data', 'Modified Enumeration Data', $desc);

        }else{

            $up_data['points'] = 0.0;
            $up_data['date_modified'] = date('Y-m-d h:i:s');
            $up_data['modified_by'] = $modified_by;
            $this->db->where('id', $id);
            $this->db->update('tbl_enumeration_data', $up_data);
            echo 2;

            $desc = "Modified Enumeration Data of " . $student_name .' | Status: Marked as Wrong '. ' | '.$type.'  ID: ' . $online_exam_quiz_id;

            $this->crud_model->save_user_logs("teacher", 'Modify Enumeration Data', 'Modified Enumeration Data', $desc);

        }
        
        if($type == 'exam'){
            $this->crud_model->update_online_exam_result($student_id,$online_exam_quiz_id);
        }else{
            $this->crud_model->update_online_quiz_result($student_id,$online_exam_quiz_id);
        }

    }

    function load_e_options(){

        $online_exam_quiz_id = $this->input->post('online_exam_quiz_id');
        $question_bank_id = $this->input->post('question_bank_id');
        $student_id = $this->input->post('student_id');
        $type = $this->input->post('type');

        if($type == "exam"){

            $question_type = $this->db->query("SELECT type from question_bank WHERE online_exam_id = '$online_exam_quiz_id' and question_bank_id = '$question_bank_id'")->row()->type;

        }else{

            $question_type = $this->db->query("SELECT type from tbl_question_bank_quiz`` WHERE online_quiz_id = '$online_exam_quiz_id' and question_bank_id = '$question_bank_id'")->row()->type;

        }

        if($question_type == 'fill_in_the_blanks' || $question_type == 'enumeration' || $question_type = 'matching_type'){

            $answer_e = $this->db->query("SELECT * from tbl_enumeration_data where online_exam_quiz_id = '$online_exam_quiz_id' and student_id = '$student_id' and type = '$type' and question_bank_id = '$question_bank_id' and answer <> '' and question_type = '$question_type' order by id asc")->result_array();
        
            echo json_encode($answer_e);

        }
        
    }
    //Manage Enumeration options Exam/Quiz

    function check_grade_val(){

        $question_id = $this->input->post('question_id');
        $points = $this->input->post('points');

        $mark = $this->crud_model->get_question_details_by_id($question_id, 'mark');

        if($points > $mark){
            echo $mark;
        }else{
            echo $points;
        }

    }

    function check_grade_val_quiz(){

        $question_id = $this->input->post('question_id');
        $points = $this->input->post('points');

        $mark = $this->crud_model->get_question_details_by_id_quiz($question_id, 'mark');

        if($points > $mark){
            echo $mark;
        }else{
            echo $points;
        }

    }

    function publish_exam(){

        $exam_id = $this->input->post('exam_id');
        $up_data['status'] = 'published';
        $up_data['publish_date'] = date('Y-m-d h:i:s');
        $this->db->where('online_exam_id', $exam_id);
        $this->db->update('online_exam', $up_data);
        echo 1;

    }

    function publish_quiz(){

        $quiz_id = $this->input->post('quiz_id');
        $up_data['status'] = 'published';
        $up_data['publish_date'] = date('Y-m-d h:i:s');
        $this->db->where('online_quiz_id', $quiz_id);
        $this->db->update('tbl_online_quiz', $up_data);
        echo 1;

    }

    function online_quiz_print_view($online_quiz_id) 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['online_quiz_id'] = $online_quiz_id;
        $this->load->view('backend/admin/online_quiz_print_view', $page_data);
    }

    function load_exam_quiz(){

         $category = $this->input->post('category');
         $class_id = $this->input->post('class_id');
         $section_id = $this->input->post('section_id');
         $subject_id = $this->input->post('subject_id');
         $online_exam_id = $this->input->post('online_exam_id');

         if($category == 'Quiz'){
            $query = $this->db->query("SELECT online_quiz_id as ID,title from tbl_online_quiz where class_id = '$class_id' and section_id = '$section_id' and subject_id = '$subject_id'");
         }else{
            $query = $this->db->query("SELECT online_exam_id as ID,title from online_exam where class_id = '$class_id' and section_id = '$section_id' and subject_id = '$subject_id' and online_exam_id <> '$online_exam_id'");
         }
        if($query->num_rows() > 0){ ?>

            <option value="">Select</option>
              <?php
                 foreach($query->result_array() as $row):
                 ?>
              <option value="<?php echo $row['ID'];?>"><?php echo $row['title'];?></option>
              <?php endforeach;?>

        <?php }else{ ?>
                <option value="">No Data</option>
        <?php }

    }

    function load_exam_quiz_questions(){

        $category = $this->input->post('category');
        $online_exam_quiz_id = $this->input->post('online_exam_quiz_id');

        if($category == 'Quiz'){

            $query = $this->db->query("SELECT * from tbl_question_bank_quiz where online_quiz_id = '$online_exam_quiz_id' order by type,question_bank_id ASC");

        }else{

            $query = $this->db->query("SELECT * from question_bank where online_exam_id = '$online_exam_quiz_id' order by type,question_bank_id ASC");

        }

        echo json_encode($query->result_array());
    }

    function save_copy_questions(){

        if(isset($_POST["id"]))
        {

            $category = $this->input->post('category');
            $online_exam_id = $this->input->post('online_exam_id');

             foreach($_POST["id"] as $id )
             {  

                if($category == 'Quiz'){

                    $question_data = $this->db->query("SELECT * from tbl_question_bank_quiz where question_bank_id = '$id'");

                }else{

                    $question_data = $this->db->query("SELECT * from question_bank where question_bank_id = '$id'");

                }

                if($question_data->num_rows() > 0){


                    $row = $question_data->row_array();

                    //insert to tbl_allowed_examiners
                    $data['online_exam_id'] = $online_exam_id;
                    $data['question_title'] = $row['question_title'];
                    $data['type'] = $row['type'];
                    $data['number_of_options'] = $row['number_of_options'];
                    $data['options'] = $row['options'];
                    $data['correct_answers'] = $row['correct_answers'];
                    $data['mark'] = $row['mark'];
                    $data['image'] = $row['image'];
                    $this->db->insert('question_bank', $data);

                }

             }
             
        }

    }

    function view_question_details(){

        $question_bank_id = $this->input->post('id');
        $category = $this->input->post('category');

        if($category == 'Quiz'){

            $query = $this->db->query("SELECT * from tbl_question_bank_quiz where question_bank_id = '$question_bank_id'");

        }else{

            $query = $this->db->query("SELECT * from question_bank where question_bank_id = '$question_bank_id'");

        }

        //echo $question_bank_id;

        if($query->num_rows() > 0){
            echo json_encode($query->result_array());
         }

    }

    //manage Exam Quiz Questionnares
    function exam_quiz_questions($data="") 
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(site_url('login'), 'refresh');
        }

        $page_data['page_name'] = 'exam_quiz_questions';
        $page_data['page_title'] = "Manage Exam/Quiz Questions";
        $page_data['data'] = $data;

        $this->load->view('backend/index', $page_data);
    }

    function load_exam_quiz_q(){

         $semester_id = $this->input->post('semester_id');
         $class_id = $this->input->post('class_id');
         $section_id = $this->input->post('section_id');
         $subject_id = $this->input->post('subject_id');

         if($semester_id > 0){

            $query = $this->db->query("SELECT online_exam_id,title,wall_type,semester_id FROM online_exam WHERE semester_id = '$semester_id' AND class_id = '$class_id' AND section_id = '$section_id' AND subject_id = '$subject_id' UNION SELECT online_quiz_id,title,wall_type,semester_id FROM tbl_online_quiz WHERE semester_id = '$semester_id' AND class_id = '$class_id' AND section_id = '$section_id' AND subject_id = '$subject_id' ORDER BY wall_type,title ASC ;");

         }else{

            $query = $this->db->query("SELECT online_exam_id,title,wall_type,semester_id FROM online_exam WHERE class_id = '$class_id' AND section_id = '$section_id' AND subject_id = '$subject_id' UNION SELECT online_quiz_id,title,wall_type,semester_id FROM tbl_online_quiz WHERE class_id = '$class_id' AND section_id = '$section_id' AND subject_id = '$subject_id' ORDER BY wall_type,title ASC ;");

         }

            if($query->num_rows() > 0){ ?>

                <?php 

                if($semester_id > 0){ ?>

                    <option value="0" selected="">ALL</option>
                      <?php
                         foreach($query->result_array() as $row):
                            $sem_id= $row['semester_id'];
                            $semester_name = $this->db->query("SELECT name from exam where exam_id = '$sem_id'")->row()->name;
                         if($semester_id > 0){
                            $desc = $row['title']." (".strtoupper($row['wall_type']).")"; 
                         }else{
                            $desc = $row['title']." (".strtoupper($row['wall_type'])." - " .strtoupper($semester_name).")"; 
                         } 
                         ?>
                      <option value="<?php echo $row['online_exam_id'].'-'.$row['wall_type'];?>"><?php echo $desc; ?></option>
                      <?php endforeach;?>

                <?php }else{ ?>
                    <option value="0" selected="">ALL</option>
                <?php }

                ?>
            <?php }else{ ?>
                    <option value="">No Data</option>
            <?php }

    }

    function load_exam_quiz_questionnares(){

        $semester_id = $this->input->post('semester_id');
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $subject_id = $this->input->post('subject_id');
        $exam_quiz_id = $this->input->post('exam_quiz_id');
        $data = base64_encode($class_id."-".$section_id."-".$subject_id);
        if($semester_id > 0){
            if($exam_quiz_id == "" || $exam_quiz_id == 0){
                $query = $this->db->query("SELECT t2.`question_bank_id`,t2.`question_title`,t2.`type`,t2.`mark`,t1.`wall_type`,t2.`number_of_options`,t1.`online_exam_id`,t1.`semester_id` FROM online_exam t1 LEFT JOIN question_bank t2 ON t1.`online_exam_id` = t2.`online_exam_id` WHERE t2.`question_bank_id` IS NOT NULL AND t1.`semester_id` = '$semester_id' AND t1.class_id = '$class_id' AND t1.section_id = '$section_id' AND t1.subject_id = '$subject_id' UNION SELECT t2.`question_bank_id`,t2.`question_title`,t2.`type`,t2.`mark`,t1.`wall_type`,t2.`number_of_options`,t1.`online_quiz_id`,t1.`semester_id` FROM tbl_online_quiz t1 LEFT JOIN tbl_question_bank_quiz t2 ON t1.`online_quiz_id` = t2.`online_quiz_id` WHERE t2.`question_bank_id` IS NOT NULL AND t1.`semester_id` = '$semester_id' AND t1.class_id = '$class_id' AND t1.section_id = '$section_id' AND t1.subject_id = '$subject_id' ORDER BY wall_type,question_title ASC");
            }else{
                 $query = $this->db->query("SELECT t2.`question_bank_id`,t2.`question_title`,t2.`type`,t2.`mark`,t1.`wall_type`,t2.`number_of_options`,t1.`online_exam_id`,t1.`semester_id` FROM online_exam t1 LEFT JOIN question_bank t2 ON t1.`online_exam_id` = t2.`online_exam_id` WHERE t1.`online_exam_id` = '$exam_quiz_id' AND t2.`question_bank_id` IS NOT NULL AND t1.`semester_id` = '$semester_id' AND t1.class_id = '$class_id' AND t1.section_id = '$section_id' AND t1.subject_id = '$subject_id' UNION SELECT t2.`question_bank_id`,t2.`question_title`,t2.`type`,t2.`mark`,t1.`wall_type`,t2.`number_of_options`,t1.`online_quiz_id`,t1.`semester_id` FROM tbl_online_quiz t1 LEFT JOIN tbl_question_bank_quiz t2 ON t1.`online_quiz_id` = t2.`online_quiz_id` WHERE t1.`online_quiz_id` = '$exam_quiz_id' AND t2.`question_bank_id` IS NOT NULL AND t1.`semester_id` = '$semester_id' AND t1.class_id = '$class_id' AND t1.section_id = '$section_id' AND t1.subject_id = '$subject_id' ORDER BY wall_type,question_title ASC;");
            }
        }else{
            $query = $this->db->query("SELECT t2.`question_bank_id`,t2.`question_title`,t2.`type`,t2.`mark`,t1.`wall_type`,t2.`number_of_options`,t1.`online_exam_id`,t1.`semester_id` FROM online_exam t1 LEFT JOIN question_bank t2 ON t1.`online_exam_id` = t2.`online_exam_id` WHERE t2.`question_bank_id` IS NOT NULL AND t1.class_id = '$class_id' AND t1.section_id = '$section_id' AND t1.subject_id = '$subject_id' UNION SELECT t2.`question_bank_id`,t2.`question_title`,t2.`type`,t2.`mark`,t1.`wall_type`,t2.`number_of_options`,t1.`online_quiz_id`,t1.`semester_id` FROM tbl_online_quiz t1 LEFT JOIN tbl_question_bank_quiz t2 ON t1.`online_quiz_id` = t2.`online_quiz_id` WHERE t2.`question_bank_id` IS NOT NULL AND t1.class_id = '$class_id' AND t1.section_id = '$section_id' AND t1.subject_id = '$subject_id' ORDER BY wall_type,question_title ASC;");

        }
        $counter = 0;

        if($query->num_rows() > 0){ ?>
            
              <?php foreach($query->result_array() as $row): $counter++;
                if($row['wall_type'] == 'exam'){
                    $link = base_url()."teacher/examroom/".$row['online_exam_id'];
                    $edit_link =  base_url().'modal/popup/update_online_exam_question/'.$row['question_bank_id'].'/'.$data;
                }else{
                    $link = base_url()."teacher/quizroom/".$row['online_exam_id'];
                    $edit_link =  base_url().'modal/popup/update_online_quiz_question/'.$row['question_bank_id'].'/'.$data;
                }
                $sem_id= $row['semester_id'];
                $semester_name = $this->db->query("SELECT name from exam where exam_id = '$sem_id'")->row()->name;
                if($row['type'] == 'fill_in_the_blanks' || $row['type'] == 'enumeration'){
                    $total_points =   number_format($row['mark'] * $row['number_of_options']);
                }else{ $total_points = number_format($row['mark']); }
              ?>
                <tr>
                    <input type="hidden" id="total_questions" value="<?php echo $query->num_rows(); ?>">
                    <td> <input style="height: 16px" type="checkbox" name="id[]" onclick="count_checked_items();" class="checkbox_q" value="<?php echo $row['question_bank_id']."-".$row['wall_type'];?>"/></td>
                    <td style="color: #000;"><?php echo $counter;?>.)</td>
                    <td><button class="btn btn-success btn-sm"> <?php echo $semester_name; ?> </button></td>
                    <td  onclick="display_actual_question('<?php echo $row['question_bank_id'];?>','<?php echo $row['wall_type']; ?>')">
                        <a href="javascript:void(0);" id="qv_<?php echo $row['question_bank_id'].$row['wall_type'];?>" style="color: #000;" title="View Actual Question"><?php echo strip_tags($row['question_title']); ?></a><br> 
                        <small class="text-danger"><?php  
                            if($total_points > 1){echo $total_points ." points"; }else{ echo $total_points ." point"; } ?> 
                        </small>
                    </td>
                    <td style="color: #000;"><?php echo str_replace("_", " ", strtoupper($row['type'])); ?></td>
                    <td style="color: #000;" class="text-center"><?php echo strtoupper($row['wall_type']); ?></td>
                    <td class="text-center">
                        <a href="<?php echo $link; ?>" title="Go to Exam/Quiz Room" class="btn btn-sm btn-info" target="_blank"> <span class="fa fa-eye fa-lg"></span></a>&nbsp;
                        <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo $edit_link;?>');" class="btn btn-sm btn-primary"> <span class="fa fa-edit fa-lg"></span> </a>&nbsp;
                        <button class="btn btn-sm btn-danger" onclick="delete_single_question('<?php echo $row['question_bank_id'] ?>','<?php echo $row['wall_type']; ?>')"> <span class="fa fa-trash fa-lg"></span> </button>
                    </td>
                </tr>
              <?php endforeach;?>
        <?php }else{ ?>
               <td class="text-center" colspan="6"> No data found. </td>
        <?php } ?>
        <script type="text/javascript">
            function count_checked_items(){
             var chks = $('.checkbox_q').filter(':checked').length

             $('#count_check').val(chks);
            
             var total_questions = $('#total_questions').val();
             var count_check = $('#count_check').val();             

             if(total_questions == count_check){
                $('#check_all_q').prop("checked", true);
             }else{
                $('#check_all_q').prop("checked", false);
             }

             if(chks > 0){

                $('#btn_copy_questions').html('<span class="fa fa-copy fa-lg"></span> Copy '+chks+' Selected Questions');
                $('#btn_add_new_exam').html('<span class="fa fa-plus fa-lg"></span> Create Online Exam using '+chks+' selected Questions');
                $('#btn_add_new_quiz').html('<span class="fa fa-plus fa-lg"></span> Create Online Quiz using '+chks+' selected Questions');

                document.getElementById('btn_add_exist').disabled= false;
                document.getElementById('btn_add_new_exam').disabled= false;
                document.getElementById('btn_add_new_quiz').disabled= false;

             }else{

                $('#btn_copy_questions').html('<span class="fa fa-copy fa-lg"></span> Copy Selected Questions');
                $('#btn_add_new_exam').html('<span class="fa fa-plus fa-lg"></span> Create Online Exam using selected Questions');
                $('#btn_add_new_quiz').html('<span class="fa fa-plus fa-lg"></span> Create Online Quiz using selected Questions');

                document.getElementById('btn_add_exist').disabled= true;
                document.getElementById('btn_add_new_exam').disabled= true;
                document.getElementById('btn_add_new_quiz').disabled= true;

             }

           }
        </script>
        <?php 
    }

    function load_exam_quiz_add_exists(){

         $class_id = $this->input->post('class_id');
         $section_id = $this->input->post('section_id');
         $subject_id = $this->input->post('subject_id');

         $query = $this->db->query("SELECT online_exam_id,title,wall_type,semester_id FROM online_exam WHERE class_id = '$class_id' AND section_id = '$section_id' AND subject_id = '$subject_id' UNION SELECT online_quiz_id,title,wall_type,semester_id FROM tbl_online_quiz WHERE class_id = '$class_id' AND section_id = '$section_id' AND subject_id = '$subject_id' ORDER BY wall_type,title ASC ;");

            if($query->num_rows() > 0){ ?>

                <?php 
                  foreach($query->result_array() as $row):
                        $sem_id= $row['semester_id'];
                        $semester_name = $this->db->query("SELECT name from exam where exam_id = '$sem_id'")->row()->name;
                     $desc = $row['title']." (".strtoupper($row['wall_type'])." - " .strtoupper($semester_name).")";
                     ?>
                  <option value="<?php echo $row['online_exam_id'].'-'.$row['wall_type'];?>"><?php echo $desc; ?></option>
                  <?php endforeach;?>

                ?>
            <?php }else{ ?>
                    <option value="">No Data</option>
            <?php }

    }

    function copy_question_exam_quiz(){

        $online_exam_id = $this->input->post('online_exam_id');

        $category = explode('-', $online_exam_id);

        if(isset($_POST["id"]))
        {
            //$id = explode('-', $_POST["id"]);

             foreach($_POST["id"] as $id )
             {  

                $data_val = explode('-', $id);
                //echo $data_val[0] . " - " . $data_val[1]; 
                if($data_val[1] == 'quiz'){
                    $question_data = $this->db->query("SELECT * from tbl_question_bank_quiz where question_bank_id = '$data_val[0]'");
                }else{
                    $question_data = $this->db->query("SELECT * from question_bank where question_bank_id = '$data_val[0]'");
                }

                if($question_data->num_rows() > 0){

                    $row = $question_data->row_array();

                    if($category[1] == 'exam'){

                        $data_e['online_exam_id'] = $category[0];
                        $data_e['question_title'] = $row['question_title'];
                        $data_e['type'] = $row['type'];
                        $data_e['number_of_options'] = $row['number_of_options'];
                        $data_e['options'] = $row['options'];
                        $data_e['correct_answers'] = $row['correct_answers'];
                        $data_e['mark'] = $row['mark'];
                        $data_e['image'] = $row['image'];
                        $this->db->insert('question_bank', $data_e);

                    }else{

                        $data_e['online_quiz_id'] = $category[0];
                        $data_e['question_title'] = $row['question_title'];
                        $data_e['type'] = $row['type'];
                        $data_e['number_of_options'] = $row['number_of_options'];
                        $data_e['options'] = $row['options'];
                        $data_e['correct_answers'] = $row['correct_answers'];
                        $data_e['mark'] = $row['mark'];
                        $data_e['image'] = $row['image'];
                        $this->db->insert('tbl_question_bank_quiz', $data_e);

                    }

                }

             }
             
        }

    }

    function create_online_exam_with_q(){

        if ($this->session->userdata('teacher_login') != 1){
            redirect(base_url(), 'refresh');
        }

        $code = substr(md5(uniqid(rand(), true)), 0, 7);
        $year =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        
        $data['sem_category'] = $this->input->post('semester_category');
        $data['is_random'] = $this->input->post('is_random');
        $data['examdate'] = $this->input->post('exam_date');
        $data['publish_date'] = date('Y-m-d H:i:s');
        $data['uploader_type'] = $this->session->userdata('login_type');
        $data['wall_type'] = "exam";
        $data['uploader_id'] = $this->session->userdata('login_user_id');
        $data['upload_date'] = date('d M. H:iA');
        $data['code']  = $code;
        $data['title'] = html_escape($this->input->post('exam_title'));
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['minimum_percentage'] = html_escape($this->input->post('minimum_percentage'));
        $data['instruction'] = html_escape($this->input->post('instruction'));
        $data['exam_date'] = strtotime(html_escape($this->input->post('exam_date')));
        $data['time_start'] = html_escape($this->input->post('time_start').":00");
        $data['time_end'] = html_escape($this->input->post('time_end').":00");
        $data['duration'] = strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_end']) - strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_start']);
        $data['running_year'] = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $data['semester_id'] = $this->input->post('semester_id');
        
        $this->db->insert('online_exam', $data);

        $table_id = $this->db->insert_id();

        $this->crud_model->insert_exam_order($table_id);
        
        $this->crud_model->send_exam_notify($table_id);

        $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
        
        $desc = 'Added new online exam Title: '.$data['title'] . 'Description: ' . $data['instruction'] .' Schedule:' .$data['exam_date'] . ' '.$data['time_start'] . ' ' . $data['time_end'] .' Code: '.$code;

        $this->crud_model->save_user_logs("teacher", 'Online Exam', 'Add Online Exam', $desc);

        // // INSERT SELECTED Questions
        if(isset($_POST["id"]))
        {
             foreach($_POST["id"] as $id )
             {  

                $data_val = explode('-', $id);
                //echo $data_val[0] . " - " . $data_val[1]; 
                if($data_val[1] == 'quiz'){
                    $question_data = $this->db->query("SELECT * from tbl_question_bank_quiz where question_bank_id = '$data_val[0]'");
                }else{
                    $question_data = $this->db->query("SELECT * from question_bank where question_bank_id = '$data_val[0]'");
                }

                if($question_data->num_rows() > 0){

                    $row = $question_data->row_array();
                    $data_insert['online_exam_id'] = $table_id;
                    $data_insert['question_title'] = $row['question_title'];
                    $data_insert['type'] = $row['type'];
                    $data_insert['number_of_options'] = $row['number_of_options'];
                    $data_insert['options'] = $row['options'];
                    $data_insert['correct_answers'] = $row['correct_answers'];
                    $data_insert['mark'] = $row['mark'];
                    $data_insert['image'] = $row['image'];
                    $this->db->insert('question_bank', $data_insert);

                }

             }
             
        }

        echo "";
        
    }

    function create_online_quiz_with_q(){

        if ($this->session->userdata('teacher_login') != 1){
            redirect(base_url(), 'refresh');
        }

        $code = substr(md5(uniqid(rand(), true)), 0, 7);
        
        $year =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

        $data['is_random'] = $this->input->post('is_random');
        $data['quizdate'] = $this->input->post('quiz_date');
        $data['publish_date'] = date('Y-m-d H:i:s');
        $data['uploader_type'] = $this->session->userdata('login_type');
        $data['wall_type'] = "quiz";
        $data['uploader_id'] = $this->session->userdata('login_user_id');
        $data['upload_date'] = date('d M. H:iA');
        $data['code']  = $code;
        $data['title'] = html_escape($this->input->post('quiz_title'));
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['minimum_percentage'] = html_escape($this->input->post('minimum_percentageq'));
        $data['instruction'] = html_escape($this->input->post('instruction'));
        $data['quiz_date'] = strtotime(html_escape($this->input->post('quiz_date')));
        $data['time_start'] = html_escape($this->input->post('time_startq').":00");
        $data['time_end'] = html_escape($this->input->post('time_endq').":00");
        $data['duration'] = strtotime(date('Y-m-d', $data['quiz_date']).' '.$data['time_endq']) - strtotime(date('Y-m-d', $data['quiz_date']).' '.$data['time_startq']);
        $data['running_year'] = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $data['semester_id'] = $this->input->post('semester_idq');
        $this->db->insert('tbl_online_quiz', $data);
        $table_id = $this->db->insert_id();
        
        $this->crud_model->send_quiz_notify($table_id);
        
        $this->crud_model->insert_quiz_order($table_id);

        $desc = 'Added new online quiz Title: '.$data['title'] . 'Description: ' . $data['instruction'] .' Schedule:' .$data['quiz_date'] . ' '.$data['time_start'] . ' ' . $data['time_end'] .' Code: '.$code;

        $this->crud_model->save_user_logs("teacher", 'Online Quiz', 'Add Online Quiz', $desc);

        // // INSERT SELECTED Questions
        if(isset($_POST["id"]))
        {
             foreach($_POST["id"] as $id )
             {  

                $data_val = explode('-', $id);
                //echo $data_val[0] . " - " . $data_val[1]; 
                if($data_val[1] == 'quiz'){
                    $question_data = $this->db->query("SELECT * from tbl_question_bank_quiz where question_bank_id = '$data_val[0]'");
                }else{
                    $question_data = $this->db->query("SELECT * from question_bank where question_bank_id = '$data_val[0]'");
                }

                if($question_data->num_rows() > 0){

                    $row = $question_data->row_array();
                    $data_insert['online_quiz_id'] = $table_id;
                    $data_insert['question_title'] = $row['question_title'];
                    $data_insert['type'] = $row['type'];
                    $data_insert['number_of_options'] = $row['number_of_options'];
                    $data_insert['options'] = $row['options'];
                    $data_insert['correct_answers'] = $row['correct_answers'];
                    $data_insert['mark'] = $row['mark'];
                    $data_insert['image'] = $row['image'];
                    $this->db->insert('tbl_question_bank_quiz', $data_insert);

                }
             } 
        }
        echo "";
    }

    function exam_preview_questions($online_exam_id){
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['online_exam_id'] =   $online_exam_id;
        $this->load->view('backend/admin/exam_preview_questions', $page_data);
    }

    function display_actual_question(){

        $id = $this->input->post('question_id');
        $category = $this->input->post('category');

        if($category == "exam"){

            $question_title = $this->db->query("SELECT question_title from question_bank where question_bank_id = '$id'")->row()->question_title;

        }else{

            $question_title = $this->db->query("SELECT question_title from tbl_question_bank_quiz where question_bank_id = '$id'")->row()->question_title;
        }

        echo $question_title;

    }

    function load_question_view_froala() {
        $question = $this->input->post('question');
        $page_data['question'] = $question;
        $this->load->view('backend/teacher/view_question_froala', $page_data);
    }

    function delete_single_question(){
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        if($category == "exam"){
            $this->db->where('question_bank_id' , $id);
            $this->db->delete('question_bank');
        }else{
            $this->db->where('question_bank_id' , $id);
            $this->db->delete('tbl_question_bank_quiz');
        }
    }

    function quiz_preview_questions($online_quiz_id){
        if ($this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['online_quiz_id'] =   $online_quiz_id;
        $this->load->view('backend/admin/quiz_preview_questions', $page_data);
    }

    //manage Exam Quiz Questionnares

    function check_exams(){

        $online_exam_id = $this->input->post('exam_id');

        $sql = $this->db->query("SELECT * from online_exam_result where online_exam_id = '$online_exam_id'")->num_rows();
        
        if($sql >= 1){
            echo 404;
        }else{
            echo 0;
        }

    }

    function check_quizzes(){

        $online_quiz_id = $this->input->post('quiz_id');

        $sql = $this->db->query("SELECT * from tbl_online_quiz_result where online_quiz_id = '$online_quiz_id'")->num_rows();

        if($sql >= 1){
            echo 404;
        }else{
            echo 0;
        }
        
    }
    
    //Update Quiz points
    function update_points_quiz_multi(){

        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $quiz_id = $this->input->post('quiz_id');
        $student_id = $this->input->post('stud_id');
        $total_points = $this->input->post('point_multi');

        $data['obtained_mark'] = $total_points;

        $this->db->where('online_quiz_id', $quiz_id);

        $this->db->where('student_id', $student_id);

        $this->db->update('tbl_online_quiz_result', $data);

        //Remove duplicate rows in tbl_enumeration and fill in the blanks
        $q = $this->db->query("DELETE t1 FROM `tbl_enumeration_data` t1
        INNER  JOIN `tbl_enumeration_data` t2
        WHERE
        t1.id < t2.id AND
        t1.online_exam_quiz_id = t2.online_exam_quiz_id AND
        t1.`student_id` = t2.`student_id` AND
        t1.`question_bank_id` = t2.`question_bank_id` AND
        t1.`answer` = t2.`answer` AND t1.`student_id` = '$student_id';");
        //Remove duplicate rows in tbl_enumeration and fill in the blanks

        if($q){
            $this->crud_model->update_online_quiz_result($student_id,$quiz_id);
        }
        
    }
    //Update Quiz points

    //Update Exam points
    function update_points_exam_multi(){

        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $exam_id = $this->input->post('exam_id');
        $student_id = $this->input->post('stud_id');
        $total_points = $this->input->post('point_multi');

        $data['obtained_mark'] = $total_points;

        $this->db->where('online_exam_id', $exam_id);

        $this->db->where('student_id', $student_id);

        $this->db->update('online_exam_result', $data);

        //Remove duplicate rows in tbl_enumeration and fill in the blanks
        $q = $this->db->query("DELETE t1 FROM `tbl_enumeration_data` t1
        INNER  JOIN `tbl_enumeration_data` t2
        WHERE
        t1.id < t2.id AND
        t1.online_exam_quiz_id = t2.online_exam_quiz_id AND
        t1.`student_id` = t2.`student_id` AND
        t1.`question_bank_id` = t2.`question_bank_id` AND
        t1.`answer` = t2.`answer` AND t1.`student_id` = '$student_id';");
        //Remove duplicate rows in tbl_enumeration and fill in the blanks

        if($q){
            $this->crud_model->update_online_exam_result($student_id,$exam_id);
        }

    }
    //Update Exam points

    //load result status
    function load_result_status(){

        $online_exam_quiz_id = $this->input->post('online_exam_quiz_id');
        $student_id = $this->input->post('stud_id');
        $type = $this->input->post('type');

        if($type == "exam"){
            $q = $this->db->query("SELECT result from online_exam_result where student_id = '$student_id' and online_exam_id = '$online_exam_quiz_id'");
        }elseif($type == "quiz"){
            $q = $this->db->query("SELECT result from tbl_online_quiz_result where student_id = '$student_id' and online_quiz_id = '$online_exam_quiz_id'");
        }

        if($q->num_rows() > 0){

            $result = $q->row()->result;

            if($result == "fail"){
                echo '<span class="badge badge-danger"> <span class="fa fa-thumbs-down"></span> Failed</span>';
            }elseif ($result == 'pass') {
                echo '<span class="badge badge-success"> <span class="fa fa-thumbs-up"></span> Passed</span>';
            }

        }

    }
    //load result status

// MANAGE ELECTION
    function electionroom($param1 = '')
    {

        if ($this->session->userdata('teacher_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name']   = 'election_room'; 
        $page_data['election_id']  = $param1;
        $page_data['page_title']  = get_phrase('Election');
        $this->load->view('backend/index', $page_data);

    }

    function load_election_details(){
        $election_id = $this->input->post('election_id');
        $positions = $this->db->query("SELECT * from tbl_election_data where election_id = '$election_id' group by position order by position asc");
       if($positions->num_rows() > 0){ 
         foreach ($positions->result_array() as $row): $counter++; 
           ?>
               <div class="pipeline white lined-primary">
                  <div class="panel-heading  mb-3">
                     <h3 class="panel-title text-left">
                       <?php 
                           $position_id = $row['position'];
                           $position = $this->db->query("SELECT name from tbl_election_position where id = '$position_id'")->row()->name;
                           echo $position;
                            ?>
                        <hr>
                     </h3>
                  </div>
                  <div class="panel-body">
                    <ul class="widget w-friend-pages-added notification-list friend-requests">
                       <?php   
                          $candidates = $this->db->query("SELECT * from tbl_election_data where position = '$position_id' and election_id = '$election_id' order by id asc");
                          $counter2 = 0;
                          foreach ($candidates->result_array() as $row2): $counter2++; 
                            
                            $party_list = $this->db->get_where('tbl_election_partylist', array('id' => $row2['party_list']));

                            if($party_list->num_rows() > 0){
                                $party_list_name = strtoupper($party_list->row()->name);
                                $party_list_color = $party_list->row()->party_color;
                            }else{
                                $party_list_name = 'INDEPENDENT';
                                $party_list_color = '#ffffff';
                            }

                            $hexRGB = $party_list_color;
                            if(hexdec(substr($hexRGB,0,2))+hexdec(substr($hexRGB,2,2))+hexdec(substr($hexRGB,4,2))> 381){
                                //bright color
                                $color_ = '#000000';
                            }else{
                                //dark color
                                $color_ = '#ffffff';
                            }
                            ?>

                            <li class="inline-items" style="height: 10%; background: <?php echo $party_list_color; ?>; color: <?php echo $color_; ?>;">
                                 <div class="author-thumb">
                                    <img src="<?php echo $this->crud_model->get_image_url('student', $row2['candidates']);?>" width="35px">
                                 </div>
                                 <div class="notification-event">
                                    <a style="color: <?php echo $color_; ?>;" href="javascript:void(0);" class="h6 notification-friend"><?php echo $counter2.'). '. $this->crud_model->get_name('student', $row2['candidates'])?></a>
                                    <span class="chat-message-item">
                                        <?php echo $party_list_name ?>
                                    </span>
                                 </div>
                                 <button class="btn btn-danger btn-sm float-right" onclick="remove_candidate('<?php echo $row2['id'] ?>')"> <span class="fa fa-times fa-lg"></span> Remove</button> 
                            </li>
                       <?php endforeach; ?>
                    </ul>
                  </div>
               </div>
        <?php endforeach; ?>
        <?php }else{ ?>
              <h1 class="text-center"> No data found! </h1>
        <?php } 

    }

    function load_election_stat(){

        $election_id = $this->input->post('election_id');
        $positions = $this->db->query("SELECT * from tbl_election_data where election_id = '$election_id' group by position order by position asc");

       if($positions->num_rows() > 0){ 
         foreach ($positions->result_array() as $row): $counter++; 
           ?>
               <div class="pipeline white lined-primary">
                  <div class="panel-heading  mb-3">
                     <h3 class="panel-title text-left">
                       <?php 
                           $position_id = $row['position'];
                           $position = $this->db->query("SELECT name from tbl_election_position where id = '$position_id'")->row()->name;
                           echo $position;
                            ?>
                            <small class="float-right"><span class="fa fa-users fa-lg"></span> Real Time Vote Counter</small>
                        <hr>
                     </h3> 
                  </div>
                  <div class="panel-body">
                    <ul class="widget w-friend-pages-added notification-list friend-requests">
                       <?php 
                          // $candidates = $this->db->query("SELECT *,COUNT(id) AS total FROM `tbl_election_response`
                          //               WHERE `election_id` = '$election_id' AND `position` = '$position_id'
                          //               GROUP BY election_id,voted ORDER BY total DESC;");

                          $candidates = $this->db->query("SELECT t1.id AS voted,t1.`party_list`,COUNT(t2.`voted`) AS total FROM `tbl_election_data` t1 LEFT JOIN tbl_election_response t2 ON t1.id = t2.`voted`WHERE t1.`position` = '$position_id' AND t1.`election_id` = '$election_id' GROUP BY t1.id ORDER BY total DESC");

                          $counter2 = 0;

                          if($candidates->num_rows() > 0){

                                foreach ($candidates->result_array() as $row2): $counter2++; 
                                    
                                    $candidate_id = $this->db->get_where('tbl_election_data', array('id' => $row2['voted']))->row()->candidates;

                                    $party_list = $this->db->get_where('tbl_election_partylist', array('id' => $row2['party_list']));

                                    if($party_list->num_rows() > 0){
                                        $party_list_name = strtoupper($party_list->row()->name);
                                        $party_list_color = $party_list->row()->party_color;
                                    }else{
                                        $party_list_name = 'INDEPENDENT';
                                        $party_list_color = '#ffffff';
                                    }

                                    $hexRGB = $party_list_color;
                                    if(hexdec(substr($hexRGB,0,2))+hexdec(substr($hexRGB,2,2))+hexdec(substr($hexRGB,4,2))> 381){
                                        //bright color
                                        $color_ = '#000000';
                                    }else{
                                        //dark color
                                        $color_ = '#ffffff';
                                    }
                                    ?>

                                    <li class="inline-items" style="height: 10%; background: <?php echo $party_list_color; ?>; color: <?php echo $color_; ?>;">
                                         <div class="author-thumb">
                                            <img src="<?php echo $this->crud_model->get_image_url('student', $row2['voted']);?>" width="35px">
                                         </div>
                                         <div class="notification-event">
                                            <a style="color: <?php echo $color_; ?>;" href="javascript:void(0);" class="h6 notification-friend"><?php echo $counter2.'). '. $this->crud_model->get_name('student', $candidate_id)?></a>
                                            <span class="chat-message-item">
                                                <?php echo $party_list_name ?>
                                            </span>
                                         </div>
                                         
                                         <?php 

                                            $this->db->where('voted', $row2['voted']);
                                            $res = $this->db->count_all_results('tbl_election_response');

                                            if($res == 0){
                                              $vote_label = '<span class=" float-right badge badge-primary"> 0 Vote</span>';
                                            }elseif($res == 1){
                                              $vote_label = '<span class=" float-right badge badge-primary"> '.number_format($res).' Vote</span>';
                                            }
                                            else{
                                              $vote_label = '<span class=" float-right badge badge-primary">'.number_format($res).' Votes</span>';
                                            }
                                         ?>
                                        <?php echo $vote_label; ?>

                                    </li>
                               <?php endforeach;

                          }else{ ?>

                            <h4 class="text-center text-primary"> No Vote counted!</h4>

                          <?php } ?>

                              
                    </ul>
                  </div>
               </div>
        <?php endforeach; ?>
        <?php }else{ ?>
              <h1 class="text-center"> No data found! </h1>
        <?php } 

    }

    //Check if election is stop or expired

    function check_election_status(){

        $election_id = $this->input->post('election_id');

        $election_row = $this->db->get_where('tbl_election', array('id' => $election_id))->row_array();

        $date_now = date('Y-m-d H:i');
        $s_date =  date('Y-m-d H:i',strtotime($election_row['date_start']));
        $e_date = date('Y-m-d H:i',strtotime($election_row['date_end']));

        if($election_row['status'] == 'expired' || $election_row['status'] == 'pending'){
            $election_status = 0;
        }else{

            if($date_now >= $s_date and $date_now <= $e_date){
            //election open
                $election_status = 1;
            }else{
            //election closed
                $election_status = 0;
            } 
        }

        echo $election_status;

    }

// MANAGE ELECTION
//MANAGE NEWS & POLLS
    function manage_news($param1 = '', $param2 = '', $param3 = '') 
        {
            if ($this->session->userdata('teacher_login') != 1) 
            {
                $this->session->set_userdata('last_page', current_url());
                redirect(base_url(), 'refresh');
            }
            if ($param1 == 'create') 
            {
                $this->crud_model->create_news();
                //$this->crud_model->send_news_notify();
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
                redirect(base_url() . 'teacher/panel/', 'refresh');
            }
            if ($param1 == 'update_panel') 
            {
                $this->crud_model->update_panel_news($param2);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
                redirect(base_url() . 'teacher/panel/', 'refresh');
            }
            if ($param1 == 'update_news') 
            {
                $this->crud_model->update_panel_news($param2);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_added'));
                redirect(base_url() . 'teacher/news/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->crud_model->delete_news($param2);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
                redirect(base_url() . 'teacher/panel/', 'refresh');
            }
            if ($param1 == 'delete2') 
            {
                $this->crud_model->delete_news($param2);
                $this->session->set_flashdata('flash_message' , get_phrase('successfully_deleted'));
                redirect(base_url() . 'teacher/news/', 'refresh');
            }
            $page_data['page_name'] = 'news';
            $page_data['page_title'] = get_phrase('news');
            $this->load->view('backend/index', $page_data);
        }

        function edit_news($code = '')
        {
            $page_data['page_name']  = 'edit_news';
            $page_data['page_title'] = get_phrase('update_news');
            $page_data['code']   = $code;
            $this->load->view('backend/index', $page_data);    
        }

        function delete_news_teacher(){

            $news_code = $this->input->post('news_code');

            unlink('uploads/news_images/'.$news_code. ".jpg");
            $id = $this->db->get_where('news', array('news_code' => $news_code))->row()->news_id;
            $this->db->where('news_code' , $news_code);
            $this->db->delete('news');


            $this->db->where('news_id' , $id);
            $this->db->delete('tbl_student_news');

            //echo 1;

        }
//MANAGE NEWS & POLLS

    function upload_news()  
       {  

        if($_FILES["file"]["name"] != '')
            {
             $test = explode('.', $_FILES["file"]["name"]);
             $ext = end($test);
             $code = substr(md5(rand(100000000, 200000000)), 0, 10);
             $name = $code . '.' . $ext;
             $location = './uploads/news_images/' . $name;  

            ini_set( 'memory_limit', '200M' );
            ini_set('upload_max_filesize', '200M');  
            ini_set('post_max_size', '200M');  
            ini_set('max_input_time', 3600);  
            ini_set('max_execution_time', 3600);

            move_uploaded_file($_FILES["file"]["tmp_name"], $location);
            echo '<img src="'.base_url().$location.'" height="150" width="225" class="img-thumbnail" /> <input type="hidden" name="file_code" value="'.$code.'"/><br> 
                <small name="file_size"> size: '.$this->formatBytes($_FILES["file"]["size"]).'</small><br><input type="hidden" name="file_loc" id="file_loc" value="'.$name.'"/><input type="hidden" name="file_ext" id="file_ext" value="'.$ext.'"/><br><button onclick="remove_file();" class="btn btn-sm btn-danger view_control"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i> Remove</button>';
             
            }

    }

    function remove_image(){
        $file_loc = $this->input->post('file_loc');
        $folder_name = $this->input->post('folder_name');
        $this->crud_model->remove_file($file_loc,$folder_name);
    }

}