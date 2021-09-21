<?php 
   require_once "face/config.php";
   $redirectURL = base_url()."auth/facebook/";
   $permissions = ['email'];
   $loginURL = $helper->getLoginUrl($redirectURL, $permissions);
?>
<?php 
    $student_id = $this->session->userdata('login_user_id');
    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
    foreach($student_info as $row): ?>
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
											<h6 class="title"><?php echo get_phrase('update_information');?></h6>
										</div>
										<?php echo form_open(base_url() . 'student/my_profile/update' , array('enctype' => 'multipart/form-data'));?>
										<div class="ui-block-content">
											<div class="row">									
    										<div class="col col-lg-6 col-md-6 col-sm-12 col-12">
											    <div class="form-group label-floating">
    												<label class="control-label"><?php echo get_phrase('first_name');?></label>
												    <input class="form-control" disabled value="<?php echo $row['first_name'];?>" type="text" required="">
											    </div>
						    			    </div>							
										    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
    											<div class="form-group label-floating">
												    <label class="control-label"><?php echo get_phrase('last_name');?></label>
												    <input class="form-control" disabled value="<?php echo $row['last_name'];?>" type="text" required="">
											    </div>								
						   				    </div>	
                          <div class="col col-lg-12 col-md-12 col-sm-12 col-12">               
                          <div class="form-group label-floating is-select">
                              <label class="control-label"><?php echo get_phrase('parent');?></label>
                              <div class="select">
                                  <select name="parent_id">
                                      <option value=""><?php echo get_phrase('select');?></option>
                                      <?php $parents = $this->db->get('parent')->result_array();
                                          foreach($parents as $rows):
                                      ?>
                                          <option value="<?php echo $rows['parent_id'];?>" <?php if($rows['parent_id'] == $row['parent_id']) echo 'selected';?>><?php echo $rows['first_name'];?> <?php echo $rows['last_name'];?></option>
                                      <?php endforeach;?>
                                  </select>
                              </div>
                            </div>
                        </div>					   	
						   				    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">								
    											<div class="form-group label-floating">
												    <label class="control-label"><?php echo get_phrase('email');?></label>
												    <input class="form-control" name="email" value="<?php echo $row['email'];?>" type="email">
											    </div>
						    			    </div>							
										    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">								
    											<div class="form-group label-floating">
												    <label class="control-label"><?php echo get_phrase('phone');?></label>
												    <input class="form-control" name="phone" value="<?php echo $row['phone'];?>" type="text">
											    </div>
						   				    </div>	
						   				    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">								
    											<div class="form-group label-floating">
												    <label class="control-label"><?php echo get_phrase('update_password');?></label>
												    <input class="form-control" name="password" type="password">
											    </div>
						   				    </div>		
										    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">								
    											<div class="form-group label-floating">
												    <label class="control-label"><?php echo get_phrase('address');?></label>
												    <input class="form-control" name="address" value="<?php echo $row['address'];?>" type="text">
											    </div>
										    </div>
										    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">								
    											<div class="form-group">
												    <label class="control-label"><?php echo get_phrase('photo');?></label>
												    <input class="form-control" placeholder="" name="userfile" type="file">
											    </div>
						    			    </div>
						    			    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">	
						    			    <button class="btn btn-info btn-rounded pull-right" type="submit"><?php echo get_phrase('update');?></button>
						    			    </div>
									    </div>
										</div>
										<?php echo form_close();?>
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
											<h3 class="title"><?php echo get_phrase('quick_links');?></h3>
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
									
									<h4 class="text-center"><?php echo get_phrase('your_linked_accounts');?></h4>
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