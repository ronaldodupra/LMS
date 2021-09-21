<?php 

$election_array = $this->db->query("SELECT * from tbl_election");

?>
<div class="content-w">
    <?php include 'fancy.php';?>
	<div class="header-spacer"></div>
	   <div class="conty">
		    <div class="os-tabs-w menu-shad">
			    <div class="os-tabs-controls">
			        <ul class="navs navs-tabs upper">
				        <li class="navs-item">
    				        <a class="navs-links" href="<?php echo base_url();?>admin/academic_settings/"><i class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i><span><?php echo get_phrase('academic_settings'); ?></span></a>
				        </li>
                        <li class="navs-item ">
                          <a class="navs-links active" href="<?php echo base_url();?>admin/manage_election/"><i class="fa fa-chart-bar fa-2x"></i><span> Manage Election</span></a>
                        </li>
				        <li class="navs-item">
				            <a class="navs-links" href="<?php echo base_url();?>admin/section/"><i class="os-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i><span><?php echo get_phrase('sections'); ?></span></a>
				        </li>
				        <li class="navs-item">
				            <a class="navs-links" href="<?php echo base_url();?>admin/grade/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('grades'); ?></span></a>
				        </li>
				        <li class="navs-item">
				            <a class="navs-links" href="<?php echo base_url();?>admin/semesters/"><i class="os-icon picons-thin-icon-thin-0007_book_reading_read_bookmark"></i><span><?php echo get_phrase('semesters'); ?></span></a>
				        </li>
                <li class="navs-item">
				            <a class="navs-links" href="<?php echo base_url();?>admin/student_promotion/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('student_promotion'); ?></span></a>
				        </li>
			        </ul>
			    </div>
		    </div>
            <div class="content-i">
                <div class="content-box">
		            <div class="col-sm-12">
                    <div class="element-box lined-primary shadow">
		                <h5 class="form-header"><?php echo get_phrase('Manage Election');?> <button data-toggle="modal" data-target="#new_election_modal" class="btn btn-sm btn-primary float-right"><span class="fa fa-plus"></span> Add Election</button></h5>
		                
                        <div class="table-responsive">
                        <table class="table table-lightborder table-striped table-hover">
                           <thead>
                              <tr>
                                 <th>Title</th>
                                 <th>Schedule</th>
                                 <th>Status</th>
                                 <th>Date Added</th>
                                 <th>Options</th>
                              </tr>
                           </thead>
                           <tbody id="results">
                              <?php 

                              if($election_array->num_rows() > 0){ 

                                foreach ($election_array->result_array() as $row): $counter++; ?>
                              <tr>
                                 <td><?php echo $row['title'] ?></td>
                                 <td><?php 
                                          $start_date = date('Y/m/d h:i A',strtotime($row['date_start']));
                                          $end_date = date('Y/m/d h:i A',strtotime($row['date_end']));
                                          ?>
                                       <?php echo $start_date; ?> - <?php echo $end_date; ?></td>

                                 <td>
                                     
                                    <?php $status = $row['status']; 

                                    if($status == 'pending'){ ?>

                                        <span class="badge badge-warning"> Pending </span>

                                    <?php }else if ($status == 'published'){ ?>

                                        <span class="badge badge-primary"> Published </span>

                                    <?php }else if ($status == 'expired'){ ?>

                                        <span class="badge badge-danger"> Expired </span>

                                    <?php }else{ ?>
                                        <span class="badge badge-info"> ---- </span>
                                    <?php }

                                    ?>

                                 </td>
                                 <td>
                                     <?php 
                                          echo date('Y/m/d h:i A',strtotime($row['publish_date'])); ?>
                                 </td>

                                 <td>
                                     
                                    <?php if ($row['status'] == 'pending'): ?>
                                    <a onclick="publish('<?php echo $row['id'];?>')" href="#" class="btn btn-info btn-sm"><?php echo get_phrase('publish');?></a>

                                    <?php elseif ($row['status'] == 'published'): ?>
                                    <a onclick="mark_expired_data('<?php echo $row['id'];?>')" href="#" class="btn btn-primary btn-sm"> <?php echo get_phrase('mark_as_expired');?></a>

                                    <?php elseif($row['status'] == 'expired'): ?>
                                    <a href="#" class="btn btn-warning btn-sm"> <?php echo get_phrase('expired');?></a>

                                    <?php endif; ?>

                                    <a href="<?php echo base_url();?>admin/electionroom/<?php echo $row['id'];?>" class="btn btn-info btn-sm"><span class="fa fa-info-circle"></span> <?php echo get_phrase('details');?></a><br>

                                    <a onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_election/<?php echo $row['id']?>')" class="btn btn-success btn-sm" href="javascript:void(0);"><span class="fa fa-edit"></span> <?php echo get_phrase('edit');?></a>
                                    
                                    <a onclick="delete_election('<?php echo $row['id'];?>');" class="btn btn-danger btn-sm" href="javascript:void(0);"><span class="fa fa-trash"></span> <?php echo get_phrase('delete');?></a>

                                 </td>

                              </tr>
                              <?php endforeach; ?>

                              <?php }else{ ?>

                                <td colspan="5" class="text-center"> No data found! </td>

                              <?php } ?>
                           </tbody>
                        </table>
                     </div>

		            </div>
		        </div>
	        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new_election_modal" tabindex="-1" role="dialog" aria-labelledby="crearadmin" aria-hidden="true">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document" style="width: 70%;">
      <div class="modal-content" style="margin-top:0px;">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
         <div class="modal-body">
            <div class="modal-header" style="background-color:#00579c">
               <h6 class="title" style="color:white"><?php echo get_phrase('new_election');?></h6>
            </div>
            <div class="ui-block-content">
               <div class="row">
                  <div class="col-md-12">
                     <?php echo form_open(base_url() . 'admin/create_election/'.$data, array('enctype' => 'multipart/form-data')); ?>
                     <div class="row">

                        <div class="col-md-8">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('title');?></label>
                              <div class="input-group">
                                 <input type="text" class="form-control" name="title">
                              </div>
                           </div>
                        </div>

                        <div class="col-md-4">
                           
                           <div class="form-group">

                               <label class="col-form-label" for=""><?php echo get_phrase('select_category');?></label>                        
                               <div class="select">
                      
                                  <select id="category" required="" name="category">
                                    <option value="">Select</option>
                                    <?php $cl = $this->db->query("SELECT * FROM tbl_election_category WHERE status = 1")->result_array();
                                      foreach($cl as $row):
                                      ?>
                                    <option value="<?php echo $row['id'];?>"><?php echo $row['category'];?></option>
                                    <?php endforeach;?>
                                  </select>

                        
                               </div>
                        
                          </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('start_date');?></label>
                                <input type='date' class="form-control" name="start_date" value="<?php echo date('Y-m-d'); ?>"/>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('start_time');?></label>
                                <input type='time' class="form-control" name="start_time" value="<?php echo date('H:i'); ?>"/>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('end_date');?></label>
                                <input type='date' class="form-control" name="end_date" value="<?php echo date('Y-m-d'); ?>"/>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label" for=""><?php echo get_phrase('end_time');?></label>
                                <input type='time' class="form-control" name="end_time" value="<?php echo date('H:i', strtotime('+1 hour')) ?>"/>
                           </div>
                        </div>
                        
                     </div>
                     
                     <div class="form-group">
                        <div class="col-sm-12" style="text-align: center;">
                           <button type="submit" class="btn btn-success"><?php echo get_phrase('save');?></button>
                        </div>
                     </div>

                     <?php echo form_close();?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
    
    function publish(id) {
   
     swal({
          title: "Are you sure ?",
          text: "You want to publish this election?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#5bc0de",
         confirmButtonText: "Yes, publish",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
   
         $('#results').html('<td colspan="5"> Publising data... </td>');
         window.location.href = '<?php echo base_url();?>admin/manage_election_status/' + id + '/published';
   
       } 
       else 
       {
   
       }
   
     });
   
   }

   function mark_expired_data(id) {
   
     swal({
          title: "Are you sure ?",
          text: "You want to mark the exam expired?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#00579d",
         confirmButtonText: "Yes, mark as expired",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
   
         $('#results').html('<td colspan="4"> marking as expired data... </td>');
          window.location.href = '<?php echo base_url();?>admin/manage_election_status/' + id + '/expired';
   
       } 
       else 
       {
   
       }
   
     });
   
   }

   function delete_election(id) {
        
     swal({
          title: "Are you sure ?",
          text: "You want to delete this data?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#00579d",
         confirmButtonText: "Yes, Delete",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        
           
         $.ajax({
            url:'<?php echo base_url();?>admin/delete_election',
            method:'POST',
            data:{id:id},
            cache:false,
            success:function(data)
            {

              if(data == 0){
                swal('LMS','You cannot delete this record it has existing related information.','info');
              }else if(data == 1){
                window.location.href = '<?php echo base_url();?>admin/manage_election/';
              }else{
                swal('LMS','Error on deleting data.','error');
              }
              
            }
         });
   
       } 
       else 
       {
   
       }
   
     });
   
   }

</script>