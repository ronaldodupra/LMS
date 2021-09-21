<div class="content-w">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
  <div class="content-i">
    <div class="content-box">
      <?php echo form_open(base_url() . 'teacher/new_student/admission/' , array('enctype' => 'multipart/form-data', 'autocomplete' => 'off'));?>
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="pipeline white lined-primary">
            <div class="panel-heading">
              <h5 class="panel-title">Add New Enrollee</h5>
            </div><br>
            <div class="panel-body">
              <div class="row">
                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="form-group label-floating">
                    <label class="control-label"><?php echo get_phrase('first_name');?></label>
                    <input class="form-control" name="first_name" type="text" required="">
                  </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="form-group label-floating">
                    <label class="control-label"><?php echo get_phrase('last_name');?></label>
                    <input class="form-control" name="last_name" type="text" required="">
                  </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="form-group date-time-picker label-floating">
                    <label class="control-label"><?php echo get_phrase('birthday');?></label>
                    <input type='text' class="datepicker-here" data-position="bottom left" data-language='en' name="datetimepicker" data-multiple-dates-separator="/"/>
                  </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="form-group label-floating">
                    <label class="control-label"><?php echo get_phrase('email');?></label>
                    <input class="form-control" name="email" type="email">
                  </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="form-group label-floating">
                    <label class="control-label"><?php echo get_phrase('phone');?></label>
                    <input class="form-control" name="phone" type="text">
                  </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="form-group label-floating is-select">
                    <label class="control-label"><?php echo get_phrase('gender');?></label>
                    <div class="select">
                      <select name="gender" required="">
                        <option value=""><?php echo get_phrase('select');?></option>
                        <option value="M"><?php echo get_phrase('male');?></option>
                        <option value="F"><?php echo get_phrase('female');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="form-group label-floating">
                    <label class="control-label"><?php echo get_phrase('address');?></label>
                    <input class="form-control" name="address" type="text">
                  </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="form-group label-floating">
                    <label class="control-label"><?php echo get_phrase('username');?></label>
                    <input class="form-control" name="username" autocomplete="false" required="" type="text" id="user_student">
                    <small><span id="result_student"></span></small>
                  </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="form-group label-floating">
                    <label class="control-label"><?php echo get_phrase('password');?></label>
                    <input class="form-control" name="password" required="" autocomplete="false" type="password">
                  </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="form-group label-floating is-select">
                    <label class="control-label"><?php echo get_phrase('class');?></label>
                    <div class="select">
                      <select name="class_id" required="" onchange="get_class_sections(this.value);">
                        <option value=""><?php echo get_phrase('select');?></option>
                        <?php $classes = $this->db->query("SELECT * FROM class ORDER BY nivel_id ASC")->result_array();
                          foreach($classes as $class):
                          ?>
                        <option value="<?php echo $class['class_id'];?>"><?php echo $class['name'];?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="form-group label-floating is-select">
                    <label class="control-label"><?php echo get_phrase('section');?></label>
                    <div class="select">
                      <select name="section_id" id="section_selector_holder">
                        <option value=""><?php echo get_phrase('select');?></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-buttons-w text-right">
                <button class="btn btn-rounded btn-success btn-lg" type="submit" id="sub_form"><?php echo get_phrase('submit');?></button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){         
    var query;          
    $("#user_student").keyup(function(e){
      query = $("#user_student").val();
      $("#result_student").queue(function(n) {                     
            
        $.ajax({
          type: "POST",
          url: '<?php echo base_url();?>register/search_user',
          data: "c="+query,
          dataType: "html",
          error: function(){
                alert("¡Error!");
          },
          success: function(data)
          { 
            if (data == "success") 
            {            
                texto = "<b style='color:#ff214f'><?php echo get_phrase('already_exist');?></b>"; 
                $("#result_student").html(texto);
                $('#sub_form').attr('disabled','disabled');
            }
            else { 
                texto = ""; 
                $("#result_student").html(texto);
                $('#sub_form').removeAttr('disabled');
            }
            n();
          }
        });                           
      });                       
    });                       
  });
</script>

<script type="text/javascript">
  function get_class_sections(class_id) 
  {
    $.ajax({
      url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
      success: function(response)
      {
        jQuery('#section_selector_holder').html(response);
      }
    });
  }
  $('#check').click(function () {
    if ($('#check').is(':checked') == true) {
      $("#new_parent").show(500);
      $("#initial").hide(500);
    }else{
      $("#new_parent").hide(500);
      $("#initial").show(500);
    }
  });
  $("#new_parent").hide();
</script>