<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">

   <div class="conty">
      <?php include 'fancy.php';?>
      <div class="header-spacer"></div>
     
      <div class="content-i">
         <div class="content-box">
            <div class="row">
               <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                  <div id="newsfeed-items-grid">
                     <div class="element-wrapper">
                        <div class="element-box-tp">
                           <h5 class="element-header">
                              <?php echo get_phrase('study_material_Preview');?>
                              <div style="margin-top:auto;float:right;">
                                 <a href="javascript:void(0)" onclick="update_study_material();" class="text-white btn btn-control btn-grey-lighter btn-success mr-5">
                                    <span class="fa fa-save"> </span>
                                 </a>

                              </div>

                           </h5>
                        
                         <div id="study_material_info_data">
                           
                         </div>
                           
                        </div>
                     </div>
                  </div>
               </main>
            </div>
         </div>
      </div>
   </div>
  <a class="back-to-top" href="#">
    <img src="<?php echo base_url();?>style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
  </a>
</div>

<script type="text/javascript">
  
  $(document).ready(function() 
    {

      // beforeSend:function(){
      //         $('#results').html("<td colspan='5' class='text-center'><img src='<?php echo base_url();?>assets/images/preloader.gif' /><br><b> Please wait accepting data...</b></td>");
      //         }, 

      var document_id = <?php echo $document_id?>;

      $.ajax({

          url:'<?php echo base_url();?>teacher/load_study_material_data/'+ document_id,
          cache:false,
          beforeSend:function(){
            $('#study_material_info_data').html("<div class='text-center'><img src='<?php echo base_url();?>assets/images/preloader.gif' /><br><b> Please wait loading data...</b></div>");
            }, 
          success:function(data)
          {
             $('#study_material_info_data').html(data);
          }

        });

      // $.ajax({
      //         url: '<?php //echo base_url();?>teacher/load_study_material_data/'+ document_id
      //     }).done(function(response) {
      //         $('#study_material_info_data').html(response);
      //     });
    });

  function update_study_material(){

    var document_id =  <?php echo $document_id?>;
    var txt_data = $('#contenteditable_update').val();

    $.ajax({

          url:'<?php echo base_url();?>teacher/update_study_material/'+document_id+'/add/essay',
          method:'POST',
          data:{document_id:document_id,txt_data:txt_data},
          cache:false,
          success:function(data)
          {
            window.location.href = '<?php echo base_url();?>teacher/study_material_preview_data/'+document_id;
          }

        });


  }

</script>
