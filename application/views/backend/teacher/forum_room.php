<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<?php 
   $posts = $this->db->get_where('forum' , array('post_code' => $post_code))->result_array();
   foreach ($posts as $row):
   ?>

<div class="content-w">
   <?php include 'fancy.php';?>
   <div class="header-spacer"></div>
   <div class="conty">
      <div class="content-i">
         <div class="content-box">
            <div class="back">
               <a href="<?php echo base_url();?>teacher/forum/<?php echo base64_encode($row['class_id']."-".$row['section_id']."-".$row['subject_id']);?>/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>
            </div>
            <div class="row">
               <div class="col-sm-8">
                  <div class="ui-block responsive-flex">
                     <table class="open-topic-table" id="panel">
                        <thead>
                           <tr>
                              <th class="author"><?php echo get_phrase('author');?></th>
                              <th class="posts"><?php echo get_phrase('topic');?></th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td class="topic-date" colspan="2"><?php echo $row['timestamp'];?></td>
                           </tr>
                           <tr>
                              <td class="author" width="50px" style="border-right: 1px solid #e6ecf5;">
                                 <div class="author-thumb">
                                    <img src="<?php echo $this->crud_model->get_image_url($row['type'], $row['teacher_id']); ?>" alt="author">
                                 </div>
                                 <div class="author-content">
                                    <a href="javascript:void(0);" class="h6 author-name"><?php echo $this->crud_model->get_name($row['type'], $row['teacher_id']);?></a>
                                    <div class="country">
                                      <span class="badge badge-success"><?php echo ucwords($row['type']);?></span>
                                    </div>

                                 </div>
                              </td>
                              <td class="posts">
                                 <h3><?php echo $row['title'];?></h3>
                                 <p><?php echo $row['description'];?></p>
                                 <?php if($row['file_name'] != ""):?>
                                 <?php echo get_phrase('file');?>: <a class="btn btn-rounded btn-sm btn-primary" href="<?php echo base_url();?>uploads/forum/<?php echo $row['file_name'];?>" style="color:white"><i class="os-icon       picons-thin-icon-thin-0042_attachment"></i> <?php echo $row['file_name'];?></a>
                                 <?php endif;?>
                              </td>
                           </tr>
                           <?php
                              $this->db->order_by('message_id' , 'asc'); 
                              $messages = $this->db->get_where('forum_message' , array('post_id' => $row['post_id']))->result_array();
                              foreach ($messages as $row2):
                              ?>
                           <tr>
                              <td class="topic-date" colspan="2"><?php echo $row2['date'];?></td>
                           </tr>
                           <tr>
                              <td class="author" width="50px" style="border-right: 1px solid #e6ecf5;">
                                 <div class="author-thumb">
                                    <?php  if ($row2['user_type'] == "teacher"): ?>
                                    <img alt="" src="<?php echo $this->crud_model->get_image_url('teacher', $row2['user_id']); ?>"> 
                                    <?php endif;?>  
                                    <?php  if ($row2['user_type'] == "student"): ?>
                                    <img alt="" src="<?php echo $this->crud_model->get_image_url('student', $row2['user_id']); ?>"> 
                                    <?php endif;?>
                                    <?php  if ($row2['user_type'] == "admin"): ?>
                                    <img alt="" src="<?php echo $this->crud_model->get_image_url('admin', $row2['user_id']); ?>"> 
                                    <?php endif;?>
                                 </div>
                                 <div class="author-content">
                                    <a href="javascript:void(0);" class="h6 author-name"><?php echo $this->crud_model->get_name($row2['user_type'], $row2['user_id']);?></a>
                                    <?php if($row2['user_type'] == "student"):?>
                                    <div class="country"><span class="badge badge-info"><?php echo ucwords($row2['user_type']);?></span></div>
                                    <?php else:?>
                                    <div class="country">
                                      <span class="badge badge-success"><?php echo ucwords($row2['user_type']);?></span>

                                    </div>
                                    <?php endif;?>
                                 </div>
                              </td>
                              <td class="posts" id="results">

                                 <div class="more float-right">

                                  <i class="icon-options"></i>    

                                  <ul class="more-dropdown">

                                    <li>
                                      <a href="javascript:void(0);" onclick="approve_message('<?php echo $row2['message_id'];?>','<?php echo $post_code; ?>')"><?php echo get_phrase('approve');?></a>
                                      <a href="javascript:void(0);" onclick="disapprove_message('<?php echo $row2['message_id'];?>','<?php echo $post_code; ?>')"><?php echo get_phrase('disapprove');?></a>
                                    </li>

                                  </ul>

                                </div> 

                                <p>

                                  <strong>Message Status:</strong>
                                 
                                  <?php  

                                  if($row2['is_approved'] == 1){ ?>
                                     <span class="badge badge-success" id="a<?php echo $row2['message_id'];?>">Approved</span>
                                  <?php }elseif($row2['is_approved'] == 2){ ?>
                                     <span class="badge badge-danger" id="d<?php echo $row2['message_id'];?>">Disapproved</span>
                                  <?php }else{ ?>
                                    <span class="badge badge-warning" id="w<?php echo $row2['message_id'];?>">Waiting</span>
                                  <?php }

                                  ?>
                                  <span id="<?php echo $row2['message_id'];?>" class="badge badge-success" style="display: none;"></span>
                                </p>

                                <p><?php echo $row2['message'];?></p>

                              </td>
                           </tr>
                           <?php endforeach;?>
                        </tbody>
                     </table>
                  </div>
                  <div class="element-box shadow lined-success">
                     <div class="row" style="margin:2px;margin-bottom:15px">
                        <div class="col-sm-12">
                           <input type="hidden" value="<?php echo $post_code;?>" id="post_code" name="post_code">                   
                           <div class="form-group is-empty"><textarea class="form-control" placeholder="<?php echo get_phrase('write_message');?>..." id="message" name="message" required="" rows="5" style="width:100%"></textarea><span class="material-input"></span></div>
                           <a id="add" class="btn btn-primary pull-right text-white" href="javascript:void(0);"><?php echo get_phrase('reply');?></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-4 ">
                  <div class="crumina-sticky-sidebar">
                     <div class="ui-block paddingtel">
                        <div class="ui-block-title">
                           <h6 class="title"><?php echo get_phrase('students');?></h6>
                        </div>
                        <ul class="widget w-friend-pages-added notification-list friend-requests">
                           <?php $students   =   $this->db->get_where('enroll' , array('class_id' => $row['class_id'], 'section_id' => $row['section_id'] , 'year' => $running_year))->result_array();
                              foreach($students as $row2):?>
                           <li class="inline-items">
                              <div class="author-thumb">
                                 <img src="<?php echo $this->crud_model->get_image_url('student', $row2['student_id']); ?>" width="35px">
                              </div>
                              <div class="notification-event">
                                 <a href="javascript:void(0);" class="h6 notification-friend"><?php echo $this->crud_model->get_name('student', $row2['student_id']);?></a>
                                 <span class="chat-message-item"><?php echo get_phrase('roll');?>: <?php echo $this->db->get_where('enroll' , array('student_id' => $row2['student_id']))->row()->roll; ?></span>
                              </div>
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
<?php endforeach;?>


<script>
   var post_message    = '<?php echo get_phrase('comment_success');?>';
   $(document).ready(function()
   {
     $("#add").click(function()
     {
       message=$("#message").val();
       post_code=$("#post_code").val();
       if(message!="" && post_code!="")
       {
         $.ajax({url:"<?php echo base_url();?>teacher/forum_message/add",type:'POST',data:{message:message,post_code:post_code},success:function(result)
         {
              $('#panel').load(document.URL + ' #panel');
              $("#message").val('');
              const Toast = Swal.mixin({
             toast: true,
             position: 'top-end',
             showConfirmButton: false,
             timer: 8000
             }); 
             Toast.fire({
             type: 'success',
             title: post_message
             });
         }});
       }
     });
   });

function approve_message(message_id,post_code){

  swal({
          title: "Are you sure ?",
          text: "You want to approve this message?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#5bc0de",
         confirmButtonText: "Yes",
         closeOnConfirm: true
     },
   function(isConfirm){
 
     if (isConfirm) 
     {        
 
       $.ajax({
        
        url:"<?php echo base_url();?>teacher/forum_message/approve",
        type:'POST',
        data:{message_id:message_id,post_code:post_code},
        success:function(result)
        {

          $('#w'+result).css('display','none');
          $('#d'+result).css('display','none');
          $('#'+result).css('display','inline');
          $('#'+result).removeClass('badge-danger');
          $('#'+result).addClass('badge-success');
          $('#'+result).html('Approved');

          const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 8000
          }); 
          Toast.fire({
          type: 'success',
          title: 'Message successfully approved.'
          });

        }});

     } 
     else 
     {
 
     }
 
   });

}

function disapprove_message(message_id,post_code){

  swal({
          title: "Are you sure ?",
          text: "You want to disapprove this message?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#5bc0de",
         confirmButtonText: "Yes",
         closeOnConfirm: true
     },
   function(isConfirm){
 
     if (isConfirm) 
     {        
 
       $.ajax({
        
        url:"<?php echo base_url();?>teacher/forum_message/disapprove",
        type:'POST',
        data:{message_id:message_id,post_code:post_code},
        success:function(result)
        {

          $('#w'+result).css('display','none');
          $('#a'+result).css('display','none');
          $('#'+result).css('display','inline');
          $('#'+result).removeClass('badge-success');
          $('#'+result).addClass('badge-danger');
          $('#'+result).html('Disapproved');


          const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 8000
          }); 
          Toast.fire({
          type: 'success',
          title: 'Message successfully disapproved.'
          });

        }});

     } 
     else 
     {
 
     }
 
   });

}

// function load_messages(){

//   var post_code = $('#post_id').val();

//       $.ajax({
//           type  : 'POST',
//           url   : '<?php echo base_url();?>teacher/load_forum_messages',
//           data:{post_code:post_code},
//           async : true,
//           dataType : 'json',
//           success : function(data){

//             $('#results').html(data);
            
//               var html = '';
//               var i;
//               for(i=0; i<data.length; i++){
//                   html += '<div class="more float-right">' +
//                           '<i class="icon-options"></i>' +
//                           '<ul class="more-dropdown">' +
//                           '<li>' +
//                           '<a href="#" onclick="approve_message('+data[i].message_id+')"><?php echo get_phrase('approve');?></a>'+
//                           '<a href="#" onclick="disapprove_message('+data[i].message_id+')"><?php echo get_phrase('disapprove');?>
//                               </li>' +
//                           '</ul>'+
//                           '</div>' + 
//                           '<p>' +
//                           '<strong>Message Status:</strong>' +
//                           '<span class="badge badge-success" id="approve" style="display: none;">Approved</span>' +
//                           '<p>'+data[i].message+'</p>';
//               }
//               $('#results').html(html);
//           }

//       });
//   }

</script>
<!-- <script type="text/javascript">
  load_messages();
</script> -->