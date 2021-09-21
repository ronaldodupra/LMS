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
               <li class="navs-item">
                  <a class="navs-links active" href="<?php echo base_url();?>admin/section/"><i class="os-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i><span><?php echo get_phrase('sections'); ?></span></a>
               </li>
               <li class="navs-item">
                  <a class="navs-links" href="<?php echo base_url();?>admin/grade/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span> Grades</span></a>
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
               <h5 class="form-header"><?php echo get_phrase('manage_sections');?></h5>
               <br>
               <div class="row">
                  <div class="col-sm-6">
                     <?php //echo form_open(base_url() . 'admin/section/', array('class' => 'form m-b'));?>
                     <div class="form-group label-floating is-select">
                        <label class="control-label"><?php echo get_phrase('class');?></label>
                        <div class="select">
                           <select name="class_id" id="c_id" onchange="load_sections();" oninput="load_sections();">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php $cl = $this->db->get('class')->result_array(); foreach($cl as $row):?>
                              <option value="<?php echo $row['class_id'];?>" <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                              <?php endforeach;?>
                           </select>
                        </div>
                     </div>
                     <?php //echo form_close();?>
                  </div>
                  <div class="col-sm-6">
                     <div style="float:right;">
                        <a href="#" class="btn btn-control bg-purple" style="background:#99bf2d; color: #fff;" onclick="add_section_modal();">
                           <i class="picons-thin-icon-thin-0001_compose_write_pencil_new" style="font-size:25px;" title="<?php echo get_phrase('new_section');?>"></i>
                           <div class="ripple-container"></div>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-12" id="">
                     <div class="row" id="results">

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="section_up" tabindex="-1" role="dialog"   aria-hidden="true" style="top:10%;">
   <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
      <div class="modal-content">
         <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
         </a>
         <div class="modal-body">
            <div class="modal-header" style="background-color:#00579c">
               <h6 class="title" id="title" style="color:white">Add Section</h6>
            </div>
            <div class="ui-block-content">
               <form enctype="multipart/form-data" id="section_update" onsubmit="event.preventDefault();">
                  <div class="row">
                     <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                           <label class="control-label"><?php echo get_phrase('name');?></label>
                           <input class="form-control" type="text" name="name" id="name" required="">
                           <input class="form-control" type="hidden" name="section_id" id="section_id" required="">
                        </div>
                     </div>
                     <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group label-floating is-select">
                           <label class="control-label"><?php echo get_phrase('teacher');?></label>
                           <div class="select">
                              <select name="teacher_id" id="teacher_id">
                                 <option value="0"><?php echo get_phrase('select');?></option>
                                 <?php $teachers = $this->db->get('teacher')->result_array(); 
                                    foreach($teachers as $teacher):
                                    ?>
                                 <option value="<?php echo $teacher['teacher_id'];?>"><?php echo $this->crud_model->get_name('teacher', $teacher['teacher_id']);?></option>
                                 <?php endforeach;?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group label-floating is-select">
                           <label class="control-label"><?php echo get_phrase('class');?></label>
                           <div class="select">
                              <select id="slct" name="slct">
                                 <option value="0"><?php echo get_phrase('select');?></option>
                                 <?php $class = $this->db->get('class')->result_array(); 
                                    foreach($class as $row):
                                    ?>
                                 <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                 <?php endforeach;?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                        <button class="btn btn-rounded btn-success" onclick="update_save_sec();" type="submit"><?php echo get_phrase('update');?></button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">


  $(document).ready(function(){  

    $('#section_up').on('hidden.bs.modal', function () {

      $('#title').html('Add Section');
      $('#section_id').val('');
      $('#name').val('');
      $('#teacher_id').val('0');
      $('#slct').val("0");

    })

  });

  function add_section_modal(){

    $('#section_up').modal('show');

  }

  load_sections();
  function load_sections()
  {
    var c_id = $('#c_id').val();
    var mydata = 'c_id=' + c_id;
    $.ajax({
      url:"<?php echo base_url(); ?>admin/load_sections",
      data:mydata,
      method:"POST",
      dataType:"JSON",
      success:function(data){
        var html='';

        if(data.length > 0){
          //$('#chk_subs').prop('disabled',false);
          for(var count = 0; count < data.length; count++)
          {

            var q = data[count].name;
            var res = q.substring(0, 1);
            var section_id = data[count].section_id;
            //alert(res);
            html += '<div class="col-sm-4">';
            html += '<div class="ui-block list"><div class="more" style="float:right; margin-right:15px; "><i class="icon-options"></i> ';
            html += '<ul class="more-dropdown" style="z-index:999">';
            html += '<li><a href="javascript:void(0)" onclick="edit_section('+data[count].section_id+','+data[count].teacher_id+','+data[count].class_id+')">Edit</a></li>'
            html +='<li><a onclick="delete_section('+data[count].section_id+')" href="javascript:void(0);">Delete</a></li>';
            html +='</ul></div><div class="birthday-item inline-items">';
            html +='<div class="circle blue" title="'+data[count].name+'">'+res+'</div>&nbsp;&nbsp;';
            html +='<div class="birthday-author-name"><div><b><?php echo get_phrase('teacher');?>: '+data[count].teacher+'</b></div>';
            html +=' <div><b><?php echo get_phrase('students');?>: '+data[count].total_student+'</b>.</div>';
            html +='<div><b><?php echo get_phrase('class');?>:</b> <span class="badge badge-info" style="font-size:12px">'+data[count].class+'</span></div></div></div></div></div>';

          }
        }else{
       
          html += '<div class="col-sm-4">No data found!</div>';
        }

        $('#results').html(html);

      }
    });
  }

   function delete_section(id) {
    
      swal({
           title: "Are you sure ?",
           text: "You want to delete this data?",
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
         
             url:"<?php echo base_url();?>admin/check_section/",
             type:'POST',
             data:{id:id},
             success:function(result)
             {
   
               if(result == 0){
                 //alert('cannot be delete');
                 swal('info','You cannot delete this record it has existing related information.','info');
   
               }else{
   
                  $('#result').html('<div class="text-center"><b>deleting data...</b></div>');
                  delete_data_now(id);
                  //window.location.href = '<?php echo base_url();?>admin/sections/delete/' + id;
                  load_sections();
               }
   
             }
   
           });
   
        } 
        else 
        {
    
        }
    
      });
    
   }

   function delete_data_now(id){

    $.ajax({
         
       url:"<?php echo base_url();?>admin/delete_section/",
       type:'POST',
       data:{id:id},
       success:function(result)
       {

         if(result == 1){

           //swal("LMS", "Section successfully deleted.", "success");
           load_sections();

         }

       }

     });

   }

   function edit_section(section_id,teacher_id,class_id){

    $('#section_id').val(section_id);
    $('#teacher_id').val(teacher_id);
    $('#slct').val(class_id);
    $('#title').html('Update Section');
    get_sec_name(section_id);
    $('#section_up').modal('show');

   }

   function get_sec_name(section_id){

      $.ajax({
        url:'<?php echo base_url();?>admin/get_sec_name/',
        method:'POST',
        data:{section_id:section_id},
        cache:false, 
        success:function(data)
        {
          $('#name').val(data);
        }

      });

   }

   function update_save_sec(){

      var name = $('#name').val();

      var section_id = $('#section_id').val();

      var teacher_id = $('#teacher_id').val();

      var slct = $('#slct').val();

      if(name == ''){

        $('#name').focus();

      }else if(teacher_id == 0){

        $('#teacher_id').focus();

      }else if(slct == 0){

        $('#slct').focus();

      }else{

        $.ajax({

          url:'<?php echo base_url();?>admin/section_save_update',
          method:'POST',
          data:$("form#section_update").serialize(),
          cache:false,
          success:function(data)
          {

            if(data == 1){

              //swal("LMS", "Section successfully saved.", "success");
              $('#section_up').modal('hide');
              load_sections();

            }else if(data == 2){

              //swal("LMS", "Section successfully updated.", "success");
              $('#title').html('Add Section');
              $('#section_up').modal('hide');
              load_sections();

            }else{

               swal("LMS", "Error on adding data", "error");

            } 

          }

        });

      }

   }

</script>