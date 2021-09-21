<?php 
   require_once "face/config.php";
   $redirectURL = base_url()."auth/facebook/";
   $permissions = ['email'];
   $loginURL = $helper->getLoginUrl($redirectURL, $permissions);
?>
<?php $student_info = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->result_array();
  foreach($student_info as $row):
?>
<div class="content-w"> 
	<?php include 'fancy.php';?>
	<div class="header-spacer"></div>
	<div class="content-i">
		<div class="content-box">
			<div class="conty">
    			<div class="row">
        			<main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">                
            			<div id="newsfeed-items-grid">
    						<div class="ui-block paddingtel">
          						<div class="user-profile">
          							<div class="up-head-w" style="background-image:url(<?php echo base_url();?>uploads/bglogin.jpg)">
          								<div class="up-main-info">
          								   	<div class="user-avatar-w">
          								       <div class="user-avatar">
          								            <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']);?>" style="background-color:#fff;">
          								        </div>
          								    </div>
          								    <h3 class="text-white"><?php echo $row['first_name'];?> <?php echo $row['last_name'];?></h3>
          								    <h5 class="up-sub-header">@<?php echo $row['username'];?></h5>
          								</div>
          								<svg class="decor" width="842px" height="219px" viewBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF"><path class="decor-path" d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z"></path></g>
          								</svg>
          							</div>
          							<div class="up-controls">
          								<div class="row">
          								    <div class="col-lg-6">
          								        <div class="value-pair">
          								            <div><?php echo get_phrase('account_type');?>:</div>
          								                <div class="value badge badge-pill badge-primary"><?php echo get_phrase('student');?></div>
          								        </div>
          								        <div class="value-pair">
          								            <div><?php echo get_phrase('member_since');?>:</div>
          								            <div class="value"><?php echo $row['since'];?>.</div>
          								        </div>
          								        <div class="value-pair">
          								            <div><?php echo get_phrase('roll');?>:</div>
          								            <div class="value"><?php echo $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->roll;?>.</div>
          								        </div>
          								    </div>
          								</div>
          							</div>
          							<div class="ui-block">
										<div class="ui-block-title">		
											<h6 class="title"><?php echo get_phrase('personal_information');?></h6>
										</div>
										<div class="ui-block-content">
											<div class="row">
												<div class="col col-lg-6 col-md-6 col-sm-12 col-12">
													<ul class="widget w-personal-info item-block">
														<li>
															<span class="title"><?php echo get_phrase('name');?>:</span>
															<span class="text"><?php echo $row['first_name'];?> <?php echo $row['last_name'];?></span>
														</li>
														<li>
															<span class="title"><?php echo get_phrase('email');?>:</span>
															<span class="text"><?php echo $row['email'];?></span>
														</li>
														<li>
															<span class="title"><?php echo get_phrase('username');?>:</span>
															<span class="text"><?php echo $row['username'];?></span>
														</li>
														<li>
															<span class="title"><?php echo get_phrase('address');?>:</span>
															<span class="text"><?php echo $row['address'];?></span>
														</li>
														<li>
															<span class="title"><?php echo get_phrase('section');?>:</span>
															<?php
															    $section_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->section_id;?>
															<span class="text"><?php echo $this->db->get_where('section', array('section_id' => $section_id))->row()->name;?></span>
														</li>
														<li>
															<span class="title"><?php echo get_phrase('classroom');?>:</span>
															<span class="text"><?php echo $this->db->get_where('dormitory', array('dormitory_id' => $row['dormitory_id']))->row()->name;?></span>
														</li>
													</ul>
												</div>
												<div class="col col-lg-6 col-md-6 col-sm-12 col-12">
													<ul class="widget w-personal-info item-block">
														<li>
															<span class="title"><?php echo get_phrase('parent');?>:</span>
															<span class="text"><?php echo $this->db->get_where('parent', array('parent_id' => $row['parent_id']))->row()->first_name." ".$this->db->get_where('parent', array('parent_id' => $row['parent_id']))->row()->last_name;?></span>
														</li>
														<li>
															<span class="title"><?php echo get_phrase('phone');?>:</span>
															<span class="text"><?php echo $row['phone'];?></span>
														</li>
														<li>
															<span class="title"><?php echo get_phrase('birthday');?>:</span>
															<span class="text"><?php echo $row['birthday'];?></span>
														</li>
														<li>
															<span class="title"><?php echo get_phrase('gender');?>:</span>
															<span class="text"><?php if($row['sex'] == 'M') echo get_phrase('male'); else echo get_phrase('female');?></span>
														</li>
														<li>
															<span class="title"><?php echo get_phrase('class');?>:</span>
															<?php
															    $class_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->class_id;
															    $section_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->section_id;?>
															<span class="text"><?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?></span>
														</li>
														<li>
															<span class="title"><?php echo get_phrase('transport');?>:</span>
															<span class="text"><?php echo $this->db->get_where('transport', array('transport_id' => $row['transport_id']))->row()->name;?></span>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
          						</div>
                			</div>
            			</div>
        			</main>
        			<div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">
            			<div class="crumina-sticky-sidebar">
                			<div class="sidebar__inner">
                				<div class="ui-block paddingtel">
                					<div class="ui-block-content">
                    					<div class="widget w-about">
                        					<a href="javascript:void(0);" class="logo"><img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"></a>
                        					<ul class="socials">
                            				    <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'facebook'))->row()->description;?>"><i class="fab fa-facebook-square" aria-hidden="true"></i></a></li>
                                                <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'twitter'))->row()->description;?>"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                                <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'youtube'))->row()->description;?>"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                                <li><a href="<?php echo $this->db->get_where('settings', array('type' => 'instagram'))->row()->description;?>"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                        					</ul>
                    					</div>
                					</div>
            					</div>
                				<div class="ui-block paddingtel">
                					<div class="ui-block-content">
                						<div class="help-support-block">
											<h4 class="title"><?php echo get_phrase('quick_links');?></h4>
											<ul class="help-support-list">
												<li>
													<i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
													<a href="<?php echo base_url();?>student/my_profile/"><?php echo get_phrase('personal_information');?></a>
												</li>
												<li>
													<i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
													<a href="<?php echo base_url();?>student/student_update/"><?php echo get_phrase('update_information');?></a>
												</li>
												<li>
													<i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
													<a href="<?php echo base_url();?>student/student_info/"><?php echo get_phrase('complementary_information');?></a>
												</li>
											</ul>
										</div>
									</div>
									
									<h3 class="text-center"><?php echo get_phrase('your_linked_accounts');?></h3>
    <?php $photo = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->fb_photo;?>
    <?php $name = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->fb_name;?>
    <?php $id = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->fb_id;?>
    <?php $salir = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->logoutURL;?>
    <?php $gid = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->g_oauth;?>
    <?php $fname = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->g_fname;?>
    <?php $lname = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->g_lname;?>
    <?php $gphoto = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->g_picture;?>
    <?php $gemail = $this->db->get_where('student', array('student_id' => $this->session->userdata('login_user_id')))->row()->g_email;?>

    <div class="pricing-plans row no-gutters">
      <div class="pricing-plan col-sm-6">
        <div class="plan-head">
          <div class="plan-image">
            <?php if($photo != ""):?>
              <img alt="" src="<?php echo $photo;?>" style="width:45px;">
            <?php else:?>
              <img src="<?php echo base_url();?>uploads/facebook.png" style="width:45px;">
            <?php endif;?>
          </div>
          <div class="plan-name">
            Facebook<?php if($name != ""):?><br><small><?php echo $name;?></small><?php endif;?>
          </div>
        </div>
        <div class="plan-body"><br><br>
          <div class="plan-btn-w">
            <?php if($id == ""):?>
              <a class="btn btn-success btn-rounded" href="<?php echo $loginURL;?>"><?php echo get_phrase('link');?></a>
            <?php else:?>
              <a class="btn btn-danger btn-rounded" href="<?php echo base_url();?>student/my_profile/remove_facebook/"><?php echo get_phrase('unlink');?></a>
            <?php endif;?>
          </div>
        </div>
      </div>
      <div class="pricing-plan col-sm-6">
        <div class="plan-head">
          <div class="plan-image">
            <?php if($gid != ""):?>
              <img alt="" src="<?php echo $gphoto;?>" style="width:45px;">
            <?php else:?>
              <img src="<?php echo base_url();?>uploads/google.png" style="width:45px;">
            <?php endif;?>
          </div>
          <div class="plan-name">
            <?php if($gid != ""):?><?php echo $fname ." ". $lname;?><br><span style="font-size:10px;"><?php echo $gemail;?></span><?php else:?>Google<?php endif;?>
          </div>
        </div>
        <div class="plan-body"><br><br>
          <div class="plan-btn-w">
            <?php if($gid == ""):?>
              <a class="btn btn-success btn-rounded" href="<?php echo $output;?>"><?php echo get_phrase('link');?></a>
            <?php else:?>
              <a class="btn btn-danger btn-rounded" href="<?php echo base_url();?>student/my_profile/remove_google/"><?php echo get_phrase('unlink');?></a>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
    
								</div>
                			</div>
            			</div>
        			</div>
    			</div>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>