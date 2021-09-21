<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php $info = base64_decode($data);?>
<?php $ex = explode("-",$info);?>
<?php $class_info = $this->db->get('class')->result_array(); ?>
<?php $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
   foreach($sub as $row):
   ?>

<style type="text/css">

  #video_id{
    color: gray;
  }

  #video_id:hover{

    color: blue;
    text-decoration: underline;
    font-weight: bolder;

  }

</style>

<div class="content-w">
   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
      <div class="cursos cta-with-media" style="background: #<?php echo $row['color'];?>;">
         <div class="cta-content">
            <div class="user-avatar">
               <img alt="" src="<?php echo base_url();?>uploads/subject_icon/<?php echo $row['icon'];?>" style="width:60px;">
            </div>
            <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo get_phrase('instructional_video_links');?></small></h3>
            <small style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?> "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"</small>
         </div>
      </div>
      <div class="os-tabs-w menu-shad">
         <div class="os-tabs-controls">
            <ul class="navs navs-tabs upper">
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/subject_dashboard/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo get_phrase('dashboard');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/online_exams/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_exams');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/online_quiz/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo get_phrase('online_quiz');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/homework/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo get_phrase('activity');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/forum/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo get_phrase('forum');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/study_material/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo get_phrase('study_material');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>admin/video_link/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i><span><?php echo get_phrase('video_links');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/live_class/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo get_phrase('live_classroom');?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/upload_marks/<?php echo $data;?>/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span>Grades</span></a>
               </li>
            </ul>
         </div>
      </div>
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                  <div id="newsfeed-items-grid">
                     <div class="element-wrapper">
                        <div class="element-box-tp">
                           <h5 class="element-header">
                              <?php echo get_phrase('instructional_video_links');?>
                              <div style="margin-top:auto;float:right;">
                                 <a href="#" data-target="#addmaterial" data-toggle="modal" class="text-white btn btn-control btn-grey-lighter btn-success mr-5">
                                    <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                    <div class="ripple-container"></div>
                                 </a>
                              </div>
                           </h5>
                           <div class="os-tabs-w">
                              <div class="os-tabs-controls">
                                 <ul class="navs navs-tabs upper">
                                    <?php 
                                       $active = 0;
                                       $query = $this->db->query("SELECT * from exam ORDER BY exam_id ASC"); 
                                       if ($query->num_rows() > 0):
                                       $sections = $query->result_array();
                                       foreach ($sections as $rows): $active++;
                                       $status= $rows['status']; 
                                       $sems = explode(" ", $rows['name']);
                                    ?>
                                    <li class="navs-item">
                                       <a class="navs-links <?php if($status == 1) echo "active";?>" data-toggle="tab" href="#tab<?php echo $rows['exam_id'];?>"><?php echo $sems[0];?></a>
                                    </li>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                 </ul>
                              </div>
                            </div>
                           <div class="tab-content">
                              <?php 
                                 //$query = $this->db->get_where('section' , array('class_id' => $class_id));
                                 $query1 = $this->db->query("SELECT * from exam ORDER BY exam_id ASC");
                                 if ($query1->num_rows() > 0):
                                 $semesters = $query1->result_array();
                                 
                                 foreach ($semesters as $row_s): 
                                 $semester_id = $row_s['exam_id'];
                                 $status= $row_s['status'];?>
                              <div class="tab-pane <?php if($status == 1) echo "active";?>" id="tab<?php echo $row_s['exam_id'];?>">
                                 <?php //echo $row_s['exam_id'];?>
                                 <div class="table-responsive" style="margin-top: -2%;">
                                    <table class="table table-padded">
                                       <thead>
                                          <tr>
                                          <tr>
                                             <th style="width: 30%;"><?php echo get_phrase('description');?></th>
                                             <th><?php echo get_phrase('host_name');?></th>
                                             <th><?php echo get_phrase('link_name');?></th>
                                             <th><?php echo get_phrase('options');?></th>
                                          </tr>
                                          </tr>
                                       </thead>
                                       <tbody id="results">
                                          <?php
                                             $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                                             
                                             $subject_id = $row['subject_id'];
                                             
                                             $class_id = $row['class_id'];
                                             
                                             $study_material_info = $this->db->query("SELECT t2.`name` AS semester_name, t1.* FROM tbl_video_link t1 LEFT JOIN exam t2 ON t1.`semester_id` = t2.`exam_id`
                                              where subject_id = '$subject_id' and class_id = '$class_id' and section_id = $ex[1] order by link_id desc ");
                                             
                                             if ($study_material_info->num_rows() > 0):
                                             
                                             foreach($study_material_info->result_array() as $row):
                                             
                                             ?>
                                          <tr>
                                             <td><?php echo $row['description']?></td>
                                             <td>
                                                <?php
                                                   $host_id = $row['video_host_id'];
                                                   $host_name = $this->db->query("SELECT hostname FROM tbl_hostnames where id = '$host_id'")->row()->hostname;
                                                   echo $host_name;
                                                ?>
                                             </td>
                                             <td class="text-left cell-with-media ">

                                                <?php
                                                   $host_id = $row['video_host_id'];
                                                   $host_name = $this->db->query("SELECT hostname FROM tbl_hostnames where id = '$host_id'")->row()->hostname;
                                                   
                                                   if(strtolower($host_name) == 'other link'){ ?>
                                                    <a href="<?php echo $row['link_name'];?>" target="_blank" id="video_id"><?php echo $row['link_name']; ?></a>
                                                   <?php }else{ ?>

                                                    <a onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_video/<?php echo $row['link_id'];?>');" style="color:gray;" href="javascript:void(0);"><?php echo $row['link_name']; ?></a>

                                                   <?php } ?>
                                                
                                             </td>
                                             
                                             <td class="text-center bolder"> 
                                                <a style="color:grey;" href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/update_video_link/<?php echo $row['link_id']?>/<?php echo $data;?>')">
                                                <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                                </a>
                                                <a style="color:grey;" onclick="delete_videlink('<?php echo $row['link_id']?>','<?php echo $data;?>')"  href="#"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i>
                                                </a>
                                             </td>
                                          </tr>
                                          <?php endforeach;
                                             else:?>
                                          <tr>
                                             <td colspan="5"> No data Found...</td>
                                          </tr>
                                          <?php endif;?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <?php endforeach;?>
                              <?php endif;?>
                           </div>
                        </div>
                     </div>
                  </div>
               </main>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="addmaterial" tabindex="-1" role="dialog" aria-labelledby="addmaterial" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
      <div class="modal-content">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
         </a>
         <div class="modal-body">
            <div class="ui-block-title" style="background-color:#00579c">
               <h6 class="title" style="color:white"><?php echo get_phrase('add_instructional_video_link');?></h6>
            </div>
            <div class="ui-block-content">
               <?php echo form_open(base_url() . 'admin/video_link/create/'.$data, array('enctype' => 'multipart/form-data')); ?>
               <div class="row">
                  <input type="hidden" value="<?php echo $ex[0];?>" name="class_id"/>
                  <input type="hidden" value="<?php echo $ex[1];?>" name="section_id"/>
                  <input type="hidden" value="<?php echo $ex[2];?>" name="subject_id"/>
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('description');?></label>
                        <textarea class="form-control" rows="5" name="description"></textarea>
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group label-floating is-select">
                        <label class="control-label"><?php echo get_phrase('host_name');?></label>
                        <div class="select">
                           <select name="host_name" id="host_name">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php $cl = $this->db->get('tbl_hostnames')->result_array();
                                 foreach($cl as $row):
                                 ?>
                              <option value="<?php echo $row['id'];?>"><?php echo $row['hostname'];?></option>
                              <?php endforeach;?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                     <div class="form-group label-floating is-select">
                        <label class="control-label"><?php echo get_phrase('select_semester');?></label>
                        <div class="select">
                           <select name="semester_id" id="semester_id">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php $cl = $this->db->get('exam')->result_array();
                                 foreach($cl as $row):
                                 ?>
                              <option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
                              <?php endforeach;?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('instructional_video_link');?></label>
                        <input class="form-control" name="link_name" type="text">
                     </div>
                  </div>
               </div>
               <div class="form-buttons-w text-right">
                  <center><button class="btn btn-rounded btn-success btn-lg" type="submit"><?php echo get_phrase('save');?></button></center>
               </div>
               <?php echo form_close();?>        
            </div>
         </div>
      </div>
   </div>
</div>
<?php endforeach;?>
<script type="text/javascript">
   function delete_videlink(id,data) {
   
     swal({
          title: "Are you sure ?",
          text: "You want to delete this data?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#e65252",
         confirmButtonText: "Yes, delete",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
   
         $('#results').html('<td> Deleting data... </td>');
         window.location.href = '<?php echo base_url();?>admin/video_link/delete/' + id + '/' + data;
   
       } 
       else 
       {
   
       }
   
     });
   
   }
   
</script>