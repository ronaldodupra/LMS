<div class="content-w">
   <?php include 'fancy.php';?>
   <div class="header-spacer"></div>
   <div class="conty">
      <div class="all-wrapper no-padding-content solid-bg-all">
         <div class="layout-w">
            <div class="content-w">
               <div class="content-i">
                  <div class="content-box">
                     <div class="app-email-w">
                        <div class="app-email-i">
                           <div class="ae-content-w" style="background-color: #f2f4f8;">
                              <div class="top-header top-header-favorit">
                                 <div class="top-header-thumb">
                                    <img src="<?php echo base_url();?>uploads/bglogin.jpg" style="height:180px; object-fit:cover;">
                                    <div class="top-header-author">
                                       <div class="author-thumb">
                                          <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff; padding:10px">
                                       </div>
                                       <div class="author-content">
                                          <a href="javascript:void(0);" class="h3 author-name">
                                          Grades</a>
                                          <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="header-spacer"></div>
                              <div class="container-fluid" id="results">
                                 <div class="row" id="results">
                                    <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 margintelbot" >
                                       <div class="friend-item friend-groups create-group w3-hover-shadow" data-mh="friend-groups-item" style="min-height:250px;">
                                          <a href="javascript:void(0);" class="full-block"></a>
                                          <div class="content">
                                             <a data-toggle="modal" data-target="#creargrado" href="javascript:void(0);" class="text-white btn btn-control bg-success"><i class="icon-feather-plus"></i></a>      
                                             <div class="author-content">
                                                <a  href="javascript:void(0);" class="h5 author-name"><?php echo get_phrase('new_grade_level');?></a>
                                                <div class="country"><?php echo get_phrase('create_new_grade_level');?></div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <?php 

                                       //$classes = $this->db->get('class')->result_array();

                                       $classes = $this->db->query("SELECT t1.*,CONCAT(t2.`first_name`,' ', t2.`last_name`) AS teacher_name FROM class t1 LEFT JOIN teacher t2 ON t1.`teacher_id` = t2.`teacher_id`")->result_array();

                                       foreach($classes as $class):
                                       ?>
                                    <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12" >
                                       <div class="ui-block" data-mh="friend-groups-item">
                                          <div class="friend-item friend-groups">
                                             <div class="friend-item-content">
                                                <div class="more">
                                                   <i class="icon-feather-more-horizontal"></i>
                                                   <ul class="more-dropdown">
                                                      <li><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_class/<?php echo $class['class_id'];?>');"><?php echo get_phrase('edit');?></a></li>
                                                      <li><a href="<?php echo base_url();?>admin/cursos/<?php echo base64_encode($class['class_id']);?>/"><?php echo get_phrase('subjects');?></a></li>
                                                      <li><a href="#" onclick="add_section('<?php echo $class['class_id'];?>','<?php echo $class['name'];?>','<?php echo $class['teacher_id'];?>','<?php echo $class['teacher_name'];?>')"><?php echo get_phrase('add_section');?></a></li>
                                                      <!-- <li><a href="#" onclick="add_student('<?php echo $class['class_id'];?>')"><?php echo get_phrase('add_student');?></a></li> -->
                                                      <li><a onclick="delete_grade('<?php echo $class['class_id'];?>')" href="#"><?php echo get_phrase('delete');?></a></li>
                                                   </ul>
                                                </div>
                                                <div class="friend-avatar">
                                                   <div class="author-thumb">
                                                      <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" width="120px" style="background-color:#fff;padding:15px; border-radius:0px;">
                                                   </div>
                                                   <div class="author-content">
                                                      <a href="<?php echo base_url();?>admin/cursos/<?php echo base64_encode($class['class_id']);?>/" class="h5 author-name"><?php echo $class['name'];?></a>
                                                      <div class="country"><b><?php echo get_phrase('sections');?>:</b> <?php $sections = $this->db->get_where('section', array('class_id' => $class['class_id']))->result_array(); foreach($sections as $sec):?> <?php echo $sec['name']." "."|";?><?php endforeach;?></div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <?php endforeach;?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="display-type"></div>
      </div>
   </div>
</div>

<div class="modal fade" id="creargrado" tabindex="-1" role="dialog" aria-labelledby="fav-page-popup" aria-hidden="true">
   <div class="modal-dialog window-popup fav-page-popup" role="document">
      <div class="modal-content">
         <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal" aria-label="Close">
         </a>
         <div class="modal-header">
            <h6 class="title"><?php echo get_phrase('create_new_grade_level');?></h6>
         </div>
         <div class="modal-body">
            <?php echo form_open(base_url() . 'admin/manage_classes/create/', array('enctype' => 'multipart/form-data')); ?>
            <div class="row">
               <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="form-group label-floating">
                     <label class="control-label"><?php echo get_phrase('name');?></label>
                     <input class="form-control" placeholder="" name="name" type="text" required>
                  </div>
               </div>
               <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="form-group label-floating is-select">
                     <label class="control-label"><?php echo get_phrase('teacher');?></label>
                     <div class="select">
                        <select name="teacher_id" required="">
                           <option value=""><?php echo get_phrase('select');?></option>
                           <?php 
                           $teachers = $this->db->query("SELECT * from teacher order by last_name asc")->result_array();
                           foreach($teachers as $row):
                              ?>
                           <option value="<?php echo $row['teacher_id'];?>"><?php echo $row['last_name'].", ".$row['first_name'];?></option>
                           <?php endforeach;?>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                  <button class="btn btn-success btn-lg full-width" type="submit"><?php echo get_phrase('save');?></button>
               </div>
            </div>
         </div>
         <?php echo form_close();?>
      </div>
   </div>
</div>

<div class="modal fade" id="add_section_modal" tabindex="-1" role="dialog" aria-labelledby="crearadmin" aria-hidden="true" style="top:10%;">
    <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
      <div class="modal-content">
        <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
        </a>
        <div class="modal-body">
          <div class="modal-header" style="background-color:#00579c">
              <h6 class="title" style="color:white"><?php echo get_phrase('new_section');?></h6>
          </div>
          <div class="ui-block-content">
            <?php echo form_open(base_url() . 'admin/sections/add_modal');?>
                <div class="row">

                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group label-floating">
                            <label class="control-label"><?php echo get_phrase('name');?></label>
                            <input class="form-control" type="text" id="name" name="name" required="">
                        </div>
                    </div>

                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                      <div class="form-group label-floating is-select">
                        <label class="control-label"><?php echo get_phrase('teacher');?></label>
                        <!--  <input type="text" disabled="" id="teacher_name"> -->
                        <div class="select">
                          <select name="teacher_id" id="teacher_id" required="">
                            <option value=""><?php echo get_phrase('select');?></option>
                            <?php 
                              $teachers = $this->db->query("SELECT * from teacher order by last_name asc")->result_array();
                              foreach($teachers as $row):
                            ?>
                              <option value="<?php echo $row['teacher_id'];?>"><?php echo $row['last_name'].", ".$row['first_name'];?></option>
                            <?php endforeach;?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo get_phrase('class');?></label>
                            
                                <input type="text" disabled="" id="class_name">
                           
                        </div>
                    </div>
                    <input type="hidden" id="class_id" name="class_id">
                    <!-- <input type="hidden" id="teacher_id" name="teacher_id"> -->
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                        <button class="btn btn-rounded btn-success" type="submit"><?php echo get_phrase('save');?></button>
                    </div>
                </div>
            <?php echo form_close();?>         
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
   function delete_grade(id) {
   
     swal({
          title: "Are you sure ?",
          text: "You want to delete this grade?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Yes, delete",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
   
         $('#results').html('<div class="col-md-12 text-center"><img src="<?php echo base_url();?>assets/images/preloader.gif" /><br><b>deleting data..</b></div>');
         window.location.href = '<?php echo base_url();?>admin/manage_classes/delete/' + id;
   
       } 
       else 
       {
   
       }
   
     });
   
   }

  function add_section(grade_id,grade_name,teacher_id,teacher_name){
    $('#class_id').val(grade_id);
    $('#class_name').val(grade_name);
    $('#teacher_id').val(teacher_id);
    $('#teacher_name').val(teacher_name);
    $('#add_section_modal').modal('show');
  }

  function add_student(class_id){
    //alert(class_id);

    $('#cl_id').val(class_id);
    get_class_sections(class_id);
    $('#bulkstudents').modal('show');
  }
   
</script>