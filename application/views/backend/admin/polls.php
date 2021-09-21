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
                                    <img src="<?php echo base_url();?>uploads/bglogin.jpg" alt="nature" style="height:180px; object-fit:cover;">
                                    <div class="top-header-author">
                                       <div class="author-thumb">
                                          <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" alt="author" style="background-color: #fff;padding:10px;">
                                       </div>
                                       <div class="author-content">
                                          <a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('polls');?></a>
                                          <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="profile-section" style="background-color: #fff;">
                                    <div class="control-block-button">
                                       <a href="<?php echo base_url();?>admin/new_poll/" class="btn btn-control bg-purple" style="background:#0084ff; color: #fff;">
                                          <i class="icon-feather-plus" title="<?php echo get_phrase('new_poll');?>"></i>
                                          <div class="ripple-container"></div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              <br>
                              <div class="aec-full-message-w" id="results">
                                 <div class="aec-full-message" style="background-color:#f2f4f8">
                                    <div class="container-fluid">
                                       <div class="row">
                                          <div class="col col-xl-10 col-lg-10 col-md-12 col-sm-12  m-auto">
                                             <ul class="table-careers">
                                                <?php 
                                                   $this->db->order_by('id', 'desc');
                                                   $polls = $this->db->get('polls')->result_array();
                                                   foreach($polls as $poll):
                                                   ?>
                                                <li class="ui-block lists">
                                                   <div class="post__author author vcard inline-items">
                                                      <img src="<?php echo $this->crud_model->get_image_url('admin', $poll['admin_id']);?>">
                                                      <div class="author-date">
                                                         <a class="h6 post__author-name fn" href="javascript:void(0);"><?php echo $this->crud_model->get_name('admin', $poll['admin_id']);?></a>
                                                         <div class="post__date">
                                                            <time class="published"><?php echo $poll['date']." ".$poll['date2'];?></time>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <strong class="btnss successs pull-right" style="margin-top:-65px; margin-right:-10px; font-size:15px; border-radius:25px; padding:7px; box-shadow: 0 2px 30px 0 rgba(153, 191, 45, 0.20);"><?php $this->db->where('poll_code', $poll['poll_code']); echo $this->db->count_all_results('poll_response');?> <?php echo get_phrase('votes');?></strong>
                                                   <a href="<?php echo base_url();?>admin/view_poll/<?php echo $poll['poll_code'];?>/">
                                                      <h3><span class="bold"><?php echo $poll['question'];?></span></h3>
                                                   </a>
                                                   <a onclick="delete_poll('<?php echo $poll['poll_code'];?>')" href="#"><i style="font-size:18px;" class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a>
                                                </li>
                                                <?php endforeach;?>
                                             </ul>
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
         <div class="display-type"></div>
      </div>
   </div>
</div>

<script type="text/javascript">

   function delete_poll(id) {
   
     swal({
          title: "Are you sure ?",
          text: "You want to delete this poll?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Yes, delete",
         closeOnConfirm: true
     },
     function(isConfirm){
   
       if (isConfirm) 
       {        

        $.ajax({
        
            url:"<?php echo base_url();?>admin/check_polls/",
            type:'POST',
            data:{id:id},
            success:function(result)
            {

              if(result == 0){
                //alert('cannot be delete');
                swal('info','Poll cannot be delete','info');

              }else{
  
                 $('#results').html('<div class="col-md-12 text-center"><img src="<?php echo base_url();?>assets/images/preloader.gif" /><br><b>deleting data..</b></div>');
                  window.location.href = '<?php echo base_url();?>admin/polls/delete2/' + id;

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