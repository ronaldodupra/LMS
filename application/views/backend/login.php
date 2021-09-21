<?php 
   require_once "face/config.php";
   $redirectURL = base_url()."auth/loginfacebook/";
   $permissions = ['email'];
   $loginURL2 = $helper->getLoginUrl($redirectURL, $permissions);
?>

<?php $title = $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description; ?>
<?php $system_name = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?>
<?php
  include_once 'src/Google_Client.php';
  include_once 'src/contrib/Google_Oauth2Service.php';
  $clientId = $this->db->get_where('settings', array('type' => 'google_sync'))->row()->description;
  $clientSecret = $this->db->get_where('settings', array('type' => 'google_login'))->row()->description;
  $redirectURL = base_url().'auth/login/';
  $gClient = new Google_Client();
  $gClient->setApplicationName('google');
  $gClient->setClientId($clientId);
  $gClient->setClientSecret($clientSecret);
  $gClient->setRedirectUri($redirectURL);
  $google_oauthV2 = new Google_Oauth2Service($gClient);
  $authUrl = $gClient->createAuthUrl();
  $output = filter_var($authUrl, FILTER_SANITIZE_URL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_phrase('login');?> | <?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/login/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/login/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/login/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/login/css/iofrm-theme16.css">
    <link href="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'favicon'))->row()->description;?>" rel="icon">
</head>
<body>
    <div class="form-body without-side">
        <div class="row">
            <div class="form-holder">
                <div class="form-content" style="background-image: url(<?php echo base_url();?>uploads/bglogin.jpg); background-size:cover;">
                    <div class="form-items">
                        <center><img class="logo-size" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" alt="" style="width:120px;"></center>

                     <!--    <p id="text"></p>
 -->                    
                        <br><h5><?php echo get_phrase('login_to_your_account');?></h5><br>
                         <?php if($this->session->userdata('error') == '1'):?>    
                            <div class="form-login-error">
                               <center><div class="alert alert-danger"> <span class="fa fa-info-circle"></span> Invalid Account. Please check your username and password!</div></center>
                            </div>
                        <?php endif;?>
                        <?php if($this->session->userdata('error') == '404'):?>    
                            <div class="form-login-error">
                                <center><div class="alert alert-primary"><span class="fa fa-info-circle"></span> Please wait for the school admin to accept your registration.</div></center>
                            </div>
                        <?php endif;?>
                        <?php if($this->session->userdata('failed') == '1'):?>
                            <div class="alert alert-danger" style="text-align: center; font-weight: bold;"><?php echo get_phrase('social_error');?></div>
                        <?php endif;?>
                        <?php if($this->session->userdata('success_recovery') == '1'):?>
                            <div class="alert alert-success" style="text-align: center; font-weight: bold;"><?php echo get_phrase('password_reset');?></div>
                        <?php endif;?>
                        <?php if($this->session->userdata('failedf') == '1'):?>
                            <div class="alert alert-danger" style="text-align: center; font-weight: bold;"><?php echo get_phrase('social_error');?></div>
                        <?php endif;?>
                        <form method="post" action="<?php echo base_url();?>login/auth/">
                            <input class="form-control" type="text" name="username" placeholder="<?php echo get_phrase('username');?>" required>
                            <input class="form-control" type="password" name="password" id="password" placeholder="<?php echo get_phrase('password');?>" required>

                            <input type="checkbox" id="show_pass" name="show_pass">
                            <label for="show_pass" id="txt"> Show password</label><br>

                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn"><?php echo get_phrase('login');?></button> <a href="<?php echo base_url();?>forgot_password/"><?php echo get_phrase('forgot_my_password');?></a>
                            </div>
                        </form>
                        <?php if($this->db->get_where('settings', array('type' => 'social_login'))->row()->description == 1):?>
                            <div class="other-links" style="text-align:center;">
                               <!--  <div class="text"><?php echo get_phrase('or');?></div>
                                <a href="<?php echo $loginURL2;?>"><i class="fab fa-facebook-f"></i>Facebook</a><a href="<?php echo $output;?>"><i class="fab fa-google"></i>Google</a> -->
                            </div>
                        <?php else:?><br><br>
                        <?php endif;?>
                        <div class="page-links">
                            <a href="<?php echo base_url();?>terms/"><?php echo get_phrase('terms_conditions');?></a>
                            <?php if($this->db->get_where('settings', array('type' => 'register'))->row()->description == 1):?><a href="<?php echo base_url();?>register/"><?php echo get_phrase('create_account');?></a><?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url();?>style/login/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>style/login/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>style/login/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>style/login/js/main.js"></script>
</body>

<script type="text/javascript">
  
  $(document).on('change', '#show_pass', function() {

    var x = document.getElementById("password");
    $('#password').focus();
    if(this.checked) {
       x.type = "text";
       $('#txt').text('Hide Password');
    }else{
       x.type = "password";
       $('#txt').text('Show Password');
    }
});

</script>

</html>

