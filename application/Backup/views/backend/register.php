<?php $title = $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description; ?>
<style>
   body{
   font-family: 'Poppins', sans-serif;
   font-weight: 800;
   -webkit-font-smoothing: antialiased;
   text-rendering: optimizeLegibility; 
   }
</style>
<!DOCTYPE html>
<html>
   <head>
      <title><?php echo get_phrase('create_account');?> | <?php echo $title;?></title>
      <meta charset="utf-8">
      <meta content="ie=edge" http-equiv="x-ua-compatible">
      <meta content="width=device-width, initial-scale=1" name="viewport">
      <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url();?>style/cms/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
      <link href="<?php echo base_url();?>style/cms/icon_fonts_assets/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
      <link href="<?php echo base_url();?>style/cms/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
      <link href="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'favicon'))->row()->description;?>" rel="icon">
      <link href="<?php echo base_url();?>style/cms/css/main.css?version=3.1" rel="stylesheet">
      <!-- <script src="<?php //echo base_url();?>uploads/sweetalert2.all.min.js"></script>  -->
      <link href="<?php echo base_url();?>style/picker.css" rel="stylesheet" type="text/css">
      <script src="<?php echo base_url();?>assets/js/jquery-1.11.0.min.js"></script>
      <link href="<?php echo base_url();?>style/sweetalert.css" rel="stylesheet">
   </head>
   <body class="auth-wrapper login" style="background: url('<?php echo base_url();?>uploads/bglogin.jpg');background-size: cover;background-repeat: no-repeat;">
      <div class="auth-box-w register" style="margin-bottom:2rem;">
         <div class="logo-wy">
            <a href="<?php echo base_url();?>"><img alt="" src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" width="30%"></a>
         </div>
         <div class="content-i">
            <div class="content-box" style="padding-bottom:0px">
               <div class="tab-content">
                  <div class="os-tabs-w">
                     <div class="os-tabs-controls">
                        <ul class="navs navs-tabs upper centered">
                           <li class="navs-item" style="margin-left: -25px;">
                              <a class="navs-links active text-center" data-toggle="tab" href="#students"><i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('student');?></span></a>
                           </li>
                           <li class="navs-item">
                              <a class="navs-links text-center" style="" data-toggle="tab" href="#teachers"><i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i><span><?php echo get_phrase('teacher');?></span></a>
                           </li>
                           <li class="navs-item" style="margin-left: -25px;">
                              <a class="navs-links text-center" data-toggle="tab" href="#parents"><i class="picons-thin-icon-thin-0703_users_profile_group_two"></i><span><?php echo get_phrase('parent');?></span></a>
                           </li>
                        </ul>
                     </div>
                  </div>
                 
                  <div class="tab-pane active" id="students">
                     
                     <div class="col-lg-12" id="stu_results">

                        <div class="element-wrapper">
                           <?php //echo form_open(base_url() . 'register/create_account/student/' , array('enctype' => 'multipart/form-data'));?>
                           <form enctype="multipart/form-data" id="student_form" onsubmit="event.preventDefault(); register_student('student');">
                              
                              <div class="form-group">
                              <span id="student_result"></span>
                              </div>

                              <div class="form-group row">
                                  
                                 <div class="col-sm-12">
                                    <div class="input-group">
                                       <div class="input-group-addon">
                                          <i class="picons-thin-icon-thin-0701_user_profile_avatar_man_male"></i>
                                       </div>
                                       <input class="form-control" placeholder="<?php echo get_phrase('fist_name');?>" name="first_name" id="first_name2" oninput="check_student();" onchange="check_student();" type="text" required="">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12">
                                    <div class="input-group">
                                       <div class="input-group-addon">
                                          <i class="picons-thin-icon-thin-0701_user_profile_avatar_man_male"></i>
                                       </div>
                                       <input class="form-control" placeholder="<?php echo get_phrase('last_name');?>" name="last_name" id="last_name2" oninput="check_student();" onchange="check_student();" type="text" required="">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12">
                                    <div class="input-group">
                                       <div class="input-group-addon">
                                          <i class="picons-thin-icon-thin-0313_email_at_sign"></i> 
                                       </div>
                                       <input class="form-control" placeholder="<?php echo get_phrase('username');?>" id="user2" required="" name="username" oninput="check_student();" onchange="check_student();" type="text">
                                    </div>
                                    <small><span id="result4"></span></small>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12">
                                    <div class="input-group">
                                       <div class="input-group-addon">
                                          <i class="picons-thin-icon-thin-0319_email_mail_post_card"></i>
                                       </div>
                                       <input class="form-control" placeholder="<?php echo get_phrase('email_address');?>" name="email" required=""e id="email2" type="email" oninput="check_student();" onchange="check_student();">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12">
                                    <div class="input-group">
                                       <div class="input-group-addon">
                                          <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                                       </div>
                                       <select class="form-control" name="class_id" required="" onchange="get_sections(this.value);">
                                          <option value=""><?php echo get_phrase('select');?></option>
                                          <?php $classes = $this->db->get('class')->result_array();
                                             foreach($classes as $class):
                                             ?>
                                          <option value="<?php echo $class['class_id'];?>"><?php echo $class['name'];?></option>
                                          <?php endforeach;?>
                                       </select>
                                    </div>   
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12">
                                    <div class="input-group">
                                       <div class="input-group-addon">
                                          <i class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i>
                                       </div>
                                       <select class="form-control" id="section_holder" name="section_id" required="">
                                          <option value=""><?php echo get_phrase('select');?></option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12">
                                    <div class="input-group">
                                       <div class="input-group-addon">
                                          <i class="picons-thin-icon-thin-0714_identity_card_photo_user_profile"></i>
                                       </div>
                                       <input class="form-control" placeholder="<?php echo get_phrase('LRN');?>" name="roll" id="roll" type="text">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12">
                                    <div class="input-group">
                                       <div class="input-group-addon">
                                          <i class="picons-thin-icon-thin-0289_mobile_phone_call_ringing_nfc"></i>
                                       </div>
                                       <input class="form-control" placeholder="<?php echo get_phrase('phone');?>" name="phone" type="number">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12">
                                    <div class="input-group">
                                       <div class="input-group-addon">
                                          <i class="picons-thin-icon-thin-0447_gift_wrapping"></i>
                                       </div>
                                       <input type='text' class="datepicker-here form-control" name="birthday" placeholder="birthday" data-position="top left" data-language='en' data-multiple-dates-separator="/"/>
                                       <!-- <input type='text' class="datepicker-here form-control" name="birthday" placeholder="birthday" data-position="top left" data-language='en' data-multiple-dates-separator="/"/> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12">
                                    <div class="form-check">
                                       <label class="form-check-label"><input checked="" class="form-check-input" name="sex" type="radio" value="M"><?php echo get_phrase('male');?></label>
                                       <label class="form-check-label"><input class="form-check-input" name="sex" type="radio" value="F" style="margin-left:5px;"><?php echo get_phrase('female');?></label>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12">
                                    <div class="input-group">
                                       <div class="input-group-addon">
                                          <i class="picons-thin-icon-thin-0136_rotation_lock"></i>
                                       </div>
                                       <input class="form-control" placeholder="<?php echo get_phrase('password');?>" name="password" id="password2" required type="password">
                                    </div>
                                 </div>
                              </div>
                              <label class="text-success" id="loader" style="display: none">Creating account please wait....</label>
                              <div class="buttons-w">
                                 <input class="btn btn-rounded btn-primary" onclick="register_student('student');" id="sub_student" type="submit" value="<?php echo get_phrase('create_account');?>">
                              </div>

                           </form>
                           
                           <?php //echo form_close();?>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="teachers">
                     <div class="col-lg-12" id="res_teacher">
                        <div class="element-wrapper">
                           <?php //echo form_open(base_url() . 'register/create_account/teacher/' , array('enctype' => 'multipart/form-data'));?>

                           <form enctype="multipart/form-data" id="teacher_form" onsubmit="event.preventDefault(); register_teacher();">

                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0701_user_profile_avatar_man_male"></i>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('first_name');?>" name="first_name" id="first_name" required="" type="text">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0701_user_profile_avatar_man_male"></i>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('last_name');?>" name="last_name" id="last_name" required="" type="text">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0313_email_at_sign"></i> 
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('username');?>" required=""  id="username" name="username" type="text">
                                 </div>
                                 <small><span id="result2"></span></small>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0319_email_mail_post_card"></i>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('email_address');?>" name="email" required=""e type="email" id="email">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0289_mobile_phone_call_ringing_nfc"></i>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('phone');?>" required="" name="phone" id="phone" type="number">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0447_gift_wrapping"></i>
                                    </div>
                                    <input type='text' class="datepicker-here form-control" name="birthday" placeholder="birthday" data-position="top left" data-language='en' data-multiple-dates-separator="/"/>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="form-check">
                                    <label class="form-check-label"><input checked="" class="form-check-input" name="sex" type="radio" value="M"><?php echo get_phrase('male');?></label>
                                    <label class="form-check-label"><input class="form-check-input" name="sex" type="radio" value="F" style="margin-left:5px;"><?php echo get_phrase('female');?></label>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0136_rotation_lock"></i>
                                    </div>
                                    <input class="form-control" required="" placeholder="<?php echo get_phrase('password');?>" id="password" name="password" type="password">
                                 </div>
                              </div>
                           </div>

                           <span id="teacher_result"></span>
                           <label class="text-success" id="loader2" style="display: none">Creating account please wait....</label>
                           <div class="buttons-w">
                              <input class="btn btn-rounded btn-primary" onclick="register_teacher(); " id="sub_teacher" type="submit" value="<?php echo get_phrase('create_account');?>">
                           </div>
                           </form>
                           <?php //echo form_close();?>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="parents">
                     <div class="col-lg-12" id="par_results">
                        <div class="element-wrapper">
                           <?php //echo form_open(base_url() . 'register/create_account/parent/' , array('enctype' => 'multipart/form-data'));?>
                           <form enctype="multipart/form-data" id="parent_form" onsubmit="event.preventDefault(); register_parent();">
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0701_user_profile_avatar_man_male"></i>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('first_name');?>" required name="first_name" id="first_name3" type="text">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0701_user_profile_avatar_man_male"></i>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('last_name');?>" required name="last_name" id="last_name3" type="text">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0313_email_at_sign"></i> 
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('username');?>" id="user5" required="" name="username" type="text">
                                 </div>
                                 <small><span id="result5"></span></small>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0319_email_mail_post_card"></i>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('email_address');?>" name="email" id="email3" required=""e type="email">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0289_mobile_phone_call_ringing_nfc"></i>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('phone');?>" name="phone" type="phone">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0379_business_suitcase"></i>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('profession');?>" name="profession" type="text">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="picons-thin-icon-thin-0136_rotation_lock"></i>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo get_phrase('password');?>" name="password" required="" id="password3" type="password">
                                 </div>
                              </div>
                           </div>
                           <span id="parent_result"></span>
                            <label class="text-success" id="loader3" style="display: none">Creating account please wait....</label>
                           <div class="buttons-w">
                              <input class="btn btn-rounded btn-primary" id="sub_parent" onclick="register_parent();" type="submit" value="<?php echo get_phrase('create_account');?>">
                           </div>
                           <?php //echo form_close();?>
                        </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script type="text/javascript">
         function get_sections(class_id) 
         {
         $.ajax({
              url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
              success: function(response)
              {
                  jQuery('#section_holder').html(response);
              }
          });
         }
      </script>
      <script src="<?php echo base_url();?>style/cms/bower_components/jquery/dist/jquery.min.js"></script>
      <script src="<?php echo base_url();?>style/cms/bower_components/moment/moment.js"></script>
      <script src="<?php echo base_url();?>style/cms/bower_components/tether/dist/js/tether.min.js"></script>
      <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap-validator/dist/validator.min.js"></script>
      <script src="<?php echo base_url();?>style/cms/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
      <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/util.js"></script>
      <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/tab.js"></script>
      <script src="<?php echo base_url();?>style/cms/js/main.js?version=3.2.1"></script>
      <script src="<?php echo base_url();?>style/js/picker.js"></script>
      <script src="<?php echo base_url();?>style/js/picker.en.js"></script>
      <script src="<?php echo base_url();?>style/cms/bower_components/dragula.js/dist/dragula.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>style/js/sweetalert.min.js"></script>
      <?php if ($this->session->flashdata('flash_message') != ""):?>
      <script>
         const Toast = Swal.mixin({
         toast: true,
         position: 'top-end',
         showConfirmButton: false,
         timer: 8000
         }); 
         Toast.fire({
         type: 'success',
         title: '<?php echo $this->session->flashdata("flash_message");?>'
         })
      </script>
      <?php endif;?>
      <script type="text/javascript">
         $(document).ready(function(){         
               var query;          
               $("#username").keyup(function(e){
                      query = $("#username").val();
                      $("#result2").queue(function(n) {                     
                        $.ajax({
                              type: "POST",
                              url: '<?php echo base_url();?>register/search_user',
                              data: "c="+query,
                              dataType: "html",
                              error: function(){
                                    alert("¡Error!");
                              },
                              success: function(data)
                              { 
                                if (data == "success") 
                                {            
                                    texto = "<b style='color:#ff214f'><?php echo get_phrase('already_exist');?></b>"; 
                                    $("#result2").html(texto);
                                    $('#sub_teacher').attr('disabled','disabled');
                                }
                                else { 
                                    texto = ""; 
                                    $("#result2").html(texto);
                                    $('#sub_teacher').removeAttr('disabled');
                                }
                                n();
                              }
                           });                           
                      });                       
               });    

         });
      </script>
      <script type="text/javascript">
         $(document).ready(function(){         
               var query;          
               $("#user5").keyup(function(e){
                      query = $("#user5").val();
                      $("#result5").queue(function(n) {                     
                                 $.ajax({
                                       type: "POST",
                                       url: '<?php echo base_url();?>register/search_user',
                                       data: "c="+query,
                                       dataType: "html",
                                       error: function(){
                                             alert("¡Error!");
                                       },
                                       success: function(data)
                                       { 
                                         if (data == "success") 
                                         {            
                                             texto = "<b style='color:#ff214f'><?php echo get_phrase('already_exist');?></b>"; 
                                             $("#result5").html(texto);
                                             $('#sub_parent').attr('disabled','disabled');
                                         }
                                         else { 
                                             texto = ""; 
                                             $("#result5").html(texto);
                                             $('#sub_parent').removeAttr('disabled');
                                         }
                                         n();
                                       }
                           });                           
                      });                       
               });                       
         });
      </script>
      <script type="text/javascript">
         $(document).ready(function() {
         
            $("#email").keyup(function(){
         
              var email = $("#email").val();
         
              if(email != 0)
              {
         
                  if(isValidEmailAddress(email))
                  {
                     document.getElementById('sub_teacher').disabled = false;
                  } else {
                     document.getElementById('sub_teacher').disabled = true;
                  }
              } else {
               document.getElementById('sub_teacher').disabled = false;
              }
         
          });
         
            $("#email2").keyup(function(){
         
              var email = $("#email2").val();
         
              if(email != 0)
              {
         
                  if(isValidEmailAddress(email))
                  {
                     document.getElementById('sub_student').disabled = false;
                  } else {
                     document.getElementById('sub_student').disabled = true;
                  }
              } else {
               document.getElementById('sub_student').disabled = false;
              }
         
            });
         
            $("#email3").keyup(function(){
         
              var email = $("#email3").val();
         
              if(email != 0)
              {
         
                  if(isValidEmailAddress(email))
                  {
                     document.getElementById('sub_parent').disabled = false;
                  } else {
                     document.getElementById('sub_parent').disabled = true;
                  }
              } else {
               document.getElementById('sub_parent').disabled = false;
              }
         
            });
         
         });
         
         function isValidEmailAddress(emailAddress) {
         var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
         return pattern.test(emailAddress);
         }
         
      </script>

      <script type="text/javascript">
         function check_student(){

               var texto;
               var first_name2 = $("#first_name2").val().trim();
               var last_name2 = $("#last_name2").val().trim();
               var user2 = $("#user2").val().trim();

               $.ajax({

                  url:"<?php echo base_url(); ?>register/check_student_name",
                  method:"POST",
                  data: {first_name2:first_name2,last_name2:last_name2,user2:user2},
                  cache: false,  
                  success:function(data)
                  {  

                     if( data == 4051 || data == 1405){

                        texto = "<b style='color:#ff214f'>Username already exist.</b>"; 
                        $("#student_result").html(texto);
                         //$('#sub_student').prop('disabled',true);

                     }else if(data == 4041 || data == 1404){
                        texto = "<b style='color:#ff214f'>Name already exist.</b>"; 
                        $("#student_result").html(texto);
                       // $('#sub_student').prop('disabled',true);
                     }else if(data == 404405){
                        texto = "<b style='color:#ff214f'>Name and Username already exist.</b>"; 
                        $("#student_result").html(texto);
                        //$('#sub_student').prop('disabled',true);
                     }else{

                        texto = ""; 
                        $("#student_result").html(texto);
                        $('#sub_student').prop('disabled',false);

                     }

                  }

               });

            }
      </script>


      <script type="text/javascript">
         
         function register_student(type){

            //var mydata = $("form#student_form").serialize();

            var first_name2 = $('#first_name2').val();
            var last_name2 = $('#last_name2').val();
            var user2 = $('#user2').val();
            var email2 = $('#email2').val();
            var password2 = $('#password2').val();
            
            if(first_name2 == ''){
            
            }else if(last_name2 == ''){
            
            }else if(user2 == ''){
            
            }else if(email2 == ''){
            
            }else if(password2 == ''){
            
            }else{
            
               $.ajax({
               url:'<?php echo base_url();?>register/create_account/' + type,
               method:'POST',
               data:$("form#student_form").serialize(),
               cache:false,
               beforeSend:function(){
                 $('#sub_student').prop('disabled',true);
                 $('#loader').css('display','inline');
               }, 
               success:function(data)
               {  
                  //alert(data);

                  if(data == 1){

                     swal("LMS", "Successfully Registered.\n Please wait for the school admin to accept your registration.", "success");

                     setTimeout(function(){   
                     window.location.href = '<?php echo base_url();?>login';
                     },3000);

                    $('#loader').css('display','none');
                    $('#sub_student').prop('disabled',false);

                  }else if(data == 404){
                     swal("LMS", "Account already exists.", "info");
                     $('#loader').css('display','none');
                     $('#sub_student').prop('disabled',false);
                  }else{
                       //swal("LMS", "Account already exists.", "info");
                  }
               }

             });
            }
            
            }

         function register_teacher(){

            var fname = $('#first_name').val();
         
            var last_name = $('#last_name').val();
            var username = $('#username').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var password = $('#password').val();
            
            if(fname == ''){
            
            }else if(last_name == ''){
            
            }else if(username == ''){
            
            }else if(email == ''){
            
            }else if(phone == ''){
            
            }else if(password == ''){
            
            }else{
            
            $.ajax({
               url:'<?php echo base_url();?>register/create_account/teacher',
               method:'POST',
               data:$("form#teacher_form").serialize(),
               cache:false,
               beforeSend:function(){
                 $('#sub_teacher').prop('disabled',true);
                 $('#loader2').css('display','inline');
               }, 
               success:function(data)
               {

                  if(data == 1){

                     swal("LMS", "Your account has been created, an email will be sent when your account is approved. \n Please wait for the school admin to accept your registration.", "success");

                     setTimeout(function(){   
                     window.location.href = '<?php echo base_url();?>login';
                     },3000);

                     $('#loader2').css('display','none');
                    $('#sub_teacher').prop('disabled',false);

                  }
               }

             });
            }

            

         }

         function register_parent(){

            first_name3 = $('#first_name3').val();
            last_name3 = $('#last_name3').val();
            user5 = $('#user5').val();
            email3 = $('#email3').val();
            password3 = $('#password3').val();
            
            if(first_name3 == ''){
            
            }else if(last_name3 == ''){
            
            }else if(user5 == ''){
            
            }else if(email3 == ''){
            
            }else if(password3 == ''){
            
            }else{
            
              $.ajax({
               url:'<?php echo base_url();?>register/create_account/parent',
               method:'POST',
               data:$("form#parent_form").serialize(),
               cache:false,
               beforeSend:function(){
                 $('#sub_parent').prop('disabled',true);
                 $('#loader3').css('display','inline');
               }, 
               success:function(data)
               {

                  if(data == 1){

                     swal("LMS", "Your account has been created, an email will be sent when your account is approved. \n Please wait for the school admin to accept your registration.", "success");

                     setTimeout(function(){   
                     window.location.href = '<?php echo base_url();?>login';
                     },3000);

                     $('#loader3').css('display','none');
                    $('#sub_parent').prop('disabled',false);

                  }
               }

             });

            }
            

         }

      </script>


   </body>
</html>