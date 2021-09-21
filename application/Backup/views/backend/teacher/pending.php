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
                                          <img src="<?php echo base_url();?>uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>" style="background-color: #fff; padding:10px;">
                                       </div>
                                       <div class="author-content">
                                          <a href="javascript:void(0);" class="h3 author-name"><?php echo get_phrase('pending_users');?></a>
                                          <div class="country"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>  |  <?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;?></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="profile-section" style="background-color: #fff;">
                                    <div class="control-block-button">
                                    </div>
                                 </div>
                              </div>
                              <div class="aec-full-message-w">
                                 <div class="aec-full-message">
                                    <div class="container-fluid" style="background-color: #f2f4f8;">
                                       <br>
                                       <div class="row">

                                         <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                          <div class="form-group label-floating" style="background-color: #fff;">
                                             <label class="control-label"><?php echo get_phrase('search_name...');?></label>
                                             <input class="form-control" id="filter" type="text" required="">
                                          </div>
                                       </div>

                                       <div class="col col-lg-5 col-md-6 col-sm-12 col-12">

                                        <div class="btn-group float-right">

                                           <button type="button" class="btn btn-info " id="btn-accept" disabled="">
                                            <span class="fa fa-thumbs-up fa-lg"></span> Accept
                                          </button>

                                           <button type="button" class="btn btn-danger" id="btn-reject" disabled="">
                                            <span class="fa fa-thumbs-down fa-lg"></span> Reject
                                          </button>

                                        </div>

                                       </div>
           
                                       </div>
                                       
                                      <div class="table-responsive">
                                        <input type="hidden" id="class_id" value="<?php echo $class_id;?>">
                                        <input type="hidden" id="t_id" value="<?php echo $t_id;?>">
                                        <table class="table table-padded" id="loader">
                                            <thead>
                                               <tr>
                                                  <th>
                                                    <div class="form-inline">
                                                      <input type="checkbox" class="form-control" name="chk_subs" id="chk_subs" onclick="check_all_subs();"><small style="display: none;">Check All</small>
                                                    </div>
                                                  </th>
                                                  <th><?php echo get_phrase('name');?></th>
                                                  <th><?php echo get_phrase('username');?></th>
                                                  <th><?php echo get_phrase('email');?></th>
                                                  <th><?php echo get_phrase('account_type');?></th>
                                               </tr>
                                            </thead>
                                            <tbody id="results">
                                               
                                            </tbody>
                                         </table>
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

<script>

  load_pending_users();

  function count_check_subs(){
    var chks = $('.select_subs').filter(':checked').length

    if(chks > 0){
      document.getElementById('btn-accept').disabled= false;
      document.getElementById('btn-reject').disabled= false;
    }else{
      document.getElementById('btn-accept').disabled= true;
      document.getElementById('btn-reject').disabled= true;
    }
  }

  function check_all_subs() {

    if (document.getElementById('chk_subs').checked) {
        document.getElementById('btn-accept').disabled= false;
        document.getElementById('btn-reject').disabled= false;
    } else {
        document.getElementById('btn-accept').disabled= true;
       document.getElementById('btn-reject').disabled= true;
    }
  }

  $(document).ready(function(){

    $("#chk_subs").change(function(){

        if(this.checked){
          $(".select_subs").each(function(){
            this.checked=true;
          })       
        }else{
          $(".select_subs").each(function(){
            this.checked=false;
          })              
        }
      });

    $('#btn-accept').click(function(){

      swal({
        title: "Are you sure?",
        text: "You want to accept selected data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34464a",
        confirmButtonText: "Accept",
        closeOnConfirm: true
      },
      function(isConfirm){

        if(isConfirm) 
        {  

          var id = [];
          var user_type = [];
          // var user_type = [];
          $(':checkbox:checked').each(function(i){
              id[i] = $(this).val();
              user_type[i] = $(this).attr("id");
          });

          if(id.length === 0) //tell you if the array is empty
          {
            swal("LMS", "Please select atleast one user", "info");
          }
          else
          {

            $.ajax({
              url:'<?php echo base_url();?>admin/accept_user/',
              method:'POST',
              data:{id:id,user_type:user_type},
              cache:false,
              beforeSend:function(){
              $('#results').html("<td colspan='5' class='text-center'><img src='<?php echo base_url();?>assets/images/preloader.gif' /><br><b> Please wait accepting data...</b></td>");
              },  
              success:function(data)
              {

              if(data == 404){
                
               swal("LMS", "Error on accepting data", "info");

              }else{

                var cl_id = $("#class_id").val();
                var tid = $("#t_id").val();

                swal("LMS", "Selected Data successfully accepted.", "success");
                window.location.href = '<?php echo base_url();?>teacher/pending/' + cl_id + '/' + tid;
                // $('#chk_subs').prop('checked',false);
                // document.getElementById('btn-accept').disabled= true;
                // document.getElementById('btn-reject').disabled= true;
                // load_pending_users();

              }

              }

            });
          }

        }else{

        }

      });

    });

    $('#btn-reject').click(function(){

      swal({
        title: "Are you sure?",
        text: "You want to reject selected data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34464a",
        confirmButtonText: "Reject",
        closeOnConfirm: true
      },
      function(isConfirm){

        if (isConfirm) 
        {  

          var id = [];
        // var user_type = [];
        $(':checkbox:checked').each(function(i){
            id[i] = $(this).val();
        });

        if(id.length === 0) //tell you if the array is empty
        {
          swal("LMS", "Please select atleast one user", "info");
        }
        else
        {

          $.ajax({
            url:'<?php echo base_url();?>admin/reject_user/',
            method:'POST',
            data:{id:id},
            cache:false,
            beforeSend:function(){
            $('#results').html("<td colspan='5' class='text-center'><img src='<?php echo base_url();?>assets/images/preloader.gif' /><br><b> Please wait rejecting data...</b></td>");
            }, 
            success:function(data)
            {

              if(data == 404){
                
               swal("LMS", "Error on rejecting data", "info");

              }else{

                var cl_id = $("#class_id").val();
                var tid = $("#t_id").val();

                swal("LMS", "Selected Data successfully rejected.", "success");
                window.location.href = '<?php echo base_url();?>teacher/pending/' + cl_id + '/' + tid;
                // $('#chk_subs').prop('checked',false);
                // document.getElementById('btn-accept').disabled= true;
                // document.getElementById('btn-reject').disabled= true;
                // load_pending_users();
                
              }

            }

          });

        }

        }

      });

    });


    });

  function load_pending_users()
  {
    var cl_id = $("#class_id").val();
    var tid = $("#t_id").val();

    $.ajax({
      url:"<?php echo base_url(); ?>teacher/load_pending_users/"+ cl_id + '/' + tid,
      dataType:"JSON",
      success:function(data){

        var html='';

        if(data.length > 0){
          $('#chk_subs').prop('disabled',false);
          for(var count = 0; count < data.length; count++)
          {

            var type = data[count].type;
            var user_type;
            if(type == 'student'){
              user_type = '<a class="btn nc btn-sm btn-rounded btn-secondary" href="#"><?php echo get_phrase('student');?></a>';
            }else if(type == 'teacher'){
              user_type = '<a class="btn nc btn-sm btn-rounded btn-success" href="#"><?php echo get_phrase('teacher');?></a>';
            }else if(type == 'parent'){
              user_type = '<a class="btn nc btn-sm btn-rounded btn-purple" href="#"><?php echo get_phrase('parent');?></a>';
            }

            html += '<tr>';
            html += '<td><input type="checkbox" onclick="count_check_subs();" name="id[]" class="select_subs" value="'+data[count].user_id+'" id="'+type+'"/></td>';
            html += '<td>'+data[count].last_name+ ', ' +data[count].first_name+'</td>';
            html += '<td>'+data[count].username+'</td>';
            html += '<td>'+data[count].email+'</td>';
            html += '<td>'+user_type+'</td></tr>';

          }
        }else{
          $('#chk_subs').prop('disabled',true);
          html += '<td class="text-center" colspan="5">No data found!</td>';
        }

        $('#results').html(html);

      }
    });
  }

</script>

<script type="text/javascript">
   window.onload=function(){      
   $("#filter").keyup(function() {
   
     var filter = $(this).val(),
       count = 0;
   
     $('#results tr').each(function() {
   
       if ($(this).text().search(new RegExp(filter, "i")) < 0) {
         $(this).hide();
   
       } else {
         $(this).show();
         count++;
       }
     });
   });
   }
</script>