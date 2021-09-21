<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once('PHPMailer/PHPMailerAutoload.php');

class Register extends CI_Controller 
{
    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    public function index() 
    {
        if($this->db->get_where('settings', array('type' => 'register'))->row()->description == 0)
        {
            redirect(base_url(), 'refresh');
        }else{
        $this->load->view('backend/register');
        }
    }

     function search_user() 
    {
        if($_POST['c'] != "")
        {
            $credential = array('username' => $_POST['c']);
            $query = $this->db->get_where('admin', $credential);
            if ($query->num_rows() > 0) 
            {
                echo 'success';
            }
            $query = $this->db->get_where('teacher', $credential);
            if ($query->num_rows() > 0) 
            {
              echo 'success';
            }             
              $query = $this->db->get_where('student', $credential);
            if ($query->num_rows() > 0) 
              {
                echo 'success';
            }
            $query = $this->db->get_where('parent', $credential);
            if ($query->num_rows() > 0) 
            {
                echo 'success';                  
            } 
            $query = $this->db->get_where('accountant', $credential);
            if ($query->num_rows() > 0) 
            {
                echo 'success';                  
            } 
            $query = $this->db->get_where('librarian', $credential);
            if ($query->num_rows() > 0) 
            {
                echo 'success';                  
            } 
        }
    }

    function check_teacher_name(){

        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');

        $query = $this->db->query("SELECT * from teacher where first_name = '$first_name' and last_name = '$last_name'");

        if($query->num_rows() > 0){
            echo 404;
        }else{
            echo 1;
        }

    }
    
    function check_student_name(){

        $first_name = $this->input->post('first_name2');
        $last_name = $this->input->post('last_name2');
        $user_name = $this->input->post('user2');

        $query = $this->db->query("SELECT * from student where first_name = '$first_name' and last_name = '$last_name'");

        if($query->num_rows() > 0){
            echo 404;
        }else{
            echo 1;
        }

        $u = $this->db->query("SELECT * from student where username = '$user_name'");
        
        if($u->num_rows() > 0){
            echo 405;
        }else{
            echo 1;
        }

    }

    function check_parent_name(){

        $first_name = $this->input->post('first_name3');
        $last_name = $this->input->post('last_name3');

        $query = $this->db->query("SELECT * from parent where first_name = '$first_name' and last_name = '$last_name'");

        if($query->num_rows() > 0){
            echo 404;
        }else{
            echo 1;
        }
        
    }

    function encrypt($pass){
        $string_to_encrypt=$pass;
        $password="password";
        $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
        return  $encrypted_string;
    }

    function decrypt($pass){
        $string_to_encrypt=$pass;
        $password="password";
        $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
        return $decrypted_string=openssl_decrypt($encrypted_string,"AES-128-ECB",$password);
    }

    function create_account($param1 = '')
    {   

        $code = substr(md5(rand(100000000, 20000000000)), 0, 5);

        $name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');

        if($param1 == 'teacher')
        {
            $data['first_name']        = $this->input->post('first_name');
            $data['last_name']        = $this->input->post('last_name');
            $data['since']     = date('d M, Y');
            $data['username']    = $this->input->post('username');
            $data['phone']       = $this->input->post('phone');
            $data['email']        = $this->input->post('email');
            $data['sex']       = $this->input->post('sex');
            $data['birthday']    = $this->input->post('birthday');
            $data['type']    = "teacher";
            $data['password']    = sha1($this->input->post('password'));

            $string_to_encrypt=$this->input->post('password');
            $password="password";
            $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);

            $data['password_md5'] = $encrypted_string;
            $data['code'] = $code;
            $this->db->insert('pending_users', $data);
            $user_id = $this->db->insert_id();
            $this->welcome_user($user_id);

            $notify['notify'] = "<strong>".get_phrase('register').":</strong>,". " ". get_phrase('reg_teacher') ." <b>".$name."</b>";

            $admins = $this->db->get('admin')->result_array();

            foreach($admins as $row)
            {
                $notify['user_id'] = $row['admin_id'];
                $notify['user_type'] = 'admin';
                $notify['url'] = "admin/pending/";
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['status'] = 0;
                $notify['original_id'] = $code;
                $notify['original_type'] = "";
                $this->db->insert('notification', $notify);
            }
            
            echo 1;

            // $this->session->set_flashdata('flash_message' , "Your account has been created, an email will be sent when your account is approved.");
            // redirect(base_url() . 'login', 'refresh:5');
        }
        if($param1 == 'student')
        {
            
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $user_name = $this->input->post('username');

            $query = $this->db->query("SELECT * from student where first_name = '$first_name' and last_name = '$last_name'");

            if($query->num_rows() > 0){
                $error = 404;
            }else{
                $error = 1;
            }

            $u = $this->db->query("SELECT * from student where username = '$user_name'");
            
            if($u->num_rows() > 0){
               $error2 = 405;
            }else{
                $error2 = 1;
            }

            $val = $error . $error2;

            if($val == 4051 || $val == 1405){
                echo 404;
            }else if($val == 4041 || $val == 1404){
                echo 404;
            }else if($val == 404405){
                echo 404;
            }else{

                $data['class_id']    = $this->input->post('class_id');
                $data['section_id']  = $this->input->post('section_id');
                $data['parent_id']   = $this->input->post('parent_id');
                $data['first_name']        = $this->input->post('first_name');
                $data['last_name']        = $this->input->post('last_name');
                $data['since']     = date('d M, Y');
                $data['username']    = $this->input->post('username');
                $data['phone']       = $this->input->post('phone');
                $data['email']        = $this->input->post('email');
                $data['sex']         = $this->input->post('sex');
                $data['birthday']    = $this->input->post('birthday');
                $data['roll']        = $this->input->post('roll');
                $data['type']        = "student";
                $data['password']    = sha1($this->input->post('password'));

                $string_to_encrypt=$this->input->post('password');
                $password="password";
                $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);

                $data['password_md5'] = $encrypted_string;
                $data['code'] = $code;

                $this->db->insert('pending_users', $data);
                $user_id = $this->db->insert_id();
                $this->welcome_user($user_id);

                 $notify['notify'] = "<strong>".get_phrase('register').":</strong>,". " ". get_phrase('reg_student')." <b>".$name."</b>";

                $admins = $this->db->get('admin')->result_array();

                foreach($admins as $row)
                {
                    $notify['user_id'] = $row['admin_id'];
                    $notify['user_type'] = 'admin';
                    $notify['url'] = "admin/pending/";
                    $notify['date'] = date('d M, Y');
                    $notify['time'] = date('h:i A');
                    $notify['status'] = 0;
                    $notify['original_id'] = $code;
                    $notify['original_type'] = "";
                    $this->db->insert('notification', $notify);
                }

                echo 1;

            }

            // $this->session->set_flashdata('flash_message' , "Your account has been created, an email will be sent when your account is approved.");
            // redirect(base_url() . 'login', 'refresh');
        }
        if($param1 == 'parent')
        {
            $data['first_name']        = $this->input->post('first_name');
            $data['last_name']        = $this->input->post('last_name');
            $data['email']        = $this->input->post('email');
            $data['since']     = date('d M, Y');
            $data['username']    = $this->input->post('username');
            $data['phone']       = $this->input->post('phone');
            $data['profession']    = $this->input->post('profession');
            $data['type']        = "parent";
            $data['password']    = sha1($this->input->post('password'));

            $string_to_encrypt=$this->input->post('password');
            $password="password";
            $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);

            $data['password_md5'] = $encrypted_string;
            $data['code'] = $code;

            $this->db->insert('pending_users', $data);
            $user_id = $this->db->insert_id();
            $this->welcome_user($user_id);

            $notify['notify'] = "<strong>".get_phrase('register').":</strong>,". " ". get_phrase('reg_parent')." <b>".$name."</b>";
            $admins = $this->db->get('admin')->result_array();
            foreach($admins as $row)
            {
                $notify['user_id'] = $row['admin_id'];
                $notify['user_type'] = 'admin';
                $notify['url'] = "admin/pending/";
                $notify['date'] = date('d M, Y');
                $notify['time'] = date('h:i A');
                $notify['status'] = 0;
                $notify['original_id'] = $code;
                $notify['original_type'] = "";
                $this->db->insert('notification', $notify);
            }

            echo 1;

            // $this->session->set_flashdata('flash_message' , "Your account has been created, an email will be sent when your account is approved.");
            // redirect(base_url() . 'login', 'refresh');
        }
    }    
    
    function welcome_user($id)
    {

        $user_email = $this->db->get_where('pending_users', array('user_id' => $id))->row()->email;
        $user_name = $this->db->get_where('pending_users', array('user_id' => $id))->row()->first_name." ".$this->db->get_where('pending_users', array('user_id' => $id))->row()->last_name;
        $username = $this->db->get_where('pending_users', array('user_id' => $id))->row()->username;
        $type = $this->db->get_where('pending_users', array('user_id' => $id))->row()->type;
        $password = $this->input->post('password');

        $email_sub    =   "Welcome ". $user_name;
        $email_msg   .=   "Hi <strong>".$user_name.",</strong><br><br>";
        $email_msg   .=  "A new account has been created with your email address in ".base_url()."<br><br>";
        $email_msg   .=  "Your data are as follows:<br><br>";
        $email_msg   .=  "<strong>Name:</strong> ".$user_name."<br/>";
        $email_msg   .=  "<strong>Email:</strong> ".$user_email."<br/>";
        $email_msg   .=  "<strong>Username:</strong> ".$username."<br/>";
        $email_msg   .=  "<strong>Account type:</strong> ".ucwords($type)."<br/>";
        $email_msg   .=  "<strong>Password:</strong> ".$password."<br/>";
        $email_msg   .=  "<strong>NOTE:</strong> At the moment you can not log in until an administrator approves your account, you will be notified about the status of your account.<br/><br>";

        $CLIENT_NAME  = $user_name;
        $CLIENT_EMAIL = $user_email;

        $this->email->from($from,$name);
        $data = array(
            'email_msg' => $email_msg
        );

        try {
            //Server settings
            require_once('class.phpmailer.php');

            //Recipients
            $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
            $mail->addAddress($user_email);     // Add a recipient
            //Content
            $mail->isHTML(true);                             
            $mail->SetFrom($this->db->get_where('settings', array('type' => 'system_email'))->row()->description, $this->db->get_where('settings', array('type' => 'system_name'))->row()->description);
            $mail->Subject = $email_sub;
            $mail->Body = $this->load->view('backend/mails/notify.php',$data,TRUE);

            $mail->AltBody = '';

            $mail->send();

        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    }

}