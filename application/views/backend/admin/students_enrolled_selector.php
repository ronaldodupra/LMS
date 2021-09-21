<?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description; ?>
<div class="element-box">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
        <input class="form-control" style="height: 20px;" id="filter_st" placeholder="<?php echo get_phrase('search_students');?>..." type="text" name="search_key">
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-lightborder table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <td>
            <div class="form-inline">
              <input type="checkbox" class="form-control" name="chk_stud" id="chk_stud" title="Check All">
            </div>
          </td>
          <td class="text-white"><strong><?php echo get_phrase('name');?></strong></td>
          <td align="center" class="text-white"><strong><?php echo get_phrase('class');?></strong></td>
          <td align="center" class="text-white"><strong><?php echo get_phrase('section');?></strong></td>
          <td align="center" class="text-white"><strong><?php echo get_phrase('remarks');?></strong></td>
        </tr>
      </thead>

      <tbody id="results">
        <?php 
          if ($type == 4) {
            $students = $this->db->query("SELECT a.`student_id`, CONCAT(b.`last_name`,', ',b.`first_name`) AS fullname, a.`class_id`, a.`section_id` FROM enroll a LEFT JOIN student b ON a.`student_id` = b.`student_id` LEFT JOIN class c ON a.`class_id` = c.`class_id` WHERE c.`department_id` = '4' AND a.`year` = '$running_year' ORDER BY b.`last_name` ASC")->result_array();
          }
          else {
            $students = $this->db->query("SELECT a.`student_id`, CONCAT(b.`last_name`,', ',b.`first_name`) AS fullname, a.`class_id`, a.`section_id` FROM enroll a LEFT JOIN student b ON a.`student_id` = b.`student_id` WHERE a.`class_id` = '$class_id' AND a.`section_id` = '$section_id' AND a.`year` = '$running_year' ORDER BY b.`last_name` ASC")->result_array();
          }

          foreach($students as $row):
            $query = $this->db->get_where('tbl_students_subject', array('student_id' => $row['student_id'], 'subject_id' => $subject_id, 'year' => $running_year));?>
        <tr>
          <td>
            <?php if($query->num_rows() <= 0): ?>
              <input type="checkbox" onclick="count_check_subs()" name="id[]" class="select_stud" value="<?php echo $row['student_id'] ?>"/>
            <?php endif; ?>
          </td>
          <td><?php echo strtoupper($row['fullname']) ?></td>
          <td align="center">
            <?php if($row['class_id'] != '' || $row['class_id'] != 0)
              echo $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name;
            ?>
          </td>
          <td align="center">
            <?php if($row['section_id'] != '' || $row['section_id'] != 0)
              echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
            ?>
          </td>
          <td>
            <?php if($query->num_rows() < 1):?>
              <center><span class="badge badge-danger"><i class="picons-thin-icon-thin-0153_delete_exit_remove_close"></i> <?php echo get_phrase('not_yet_added');?></span>
              </center>
            <?php endif;?>
            <?php if($query->num_rows() > 0):?>
                <center><span class="badge badge-primary"><i class="picons-thin-icon-thin-0154_ok_successful_check"></i> <?php echo get_phrase('added');?></span>
                </center>
              </center>
            <?php endif;?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<br>

<script type="text/javascript">
  $(document).ready(function() {

    if($.isFunction($.fn.selectBoxIt))
    {
      $("select.selectboxit").each(function(i, el)
      {
        var $this = $(el),
          opts = {
            showFirstOption: attrDefault($this, 'first-option', true),
            'native': attrDefault($this, 'native', false),
            defaultText: attrDefault($this, 'text', ''),
          };
          
        $this.addClass('visible');
        $this.selectBoxIt(opts);
      });
    }

    $("#chk_stud").change(function() {
      if (this.checked) {
        $(".select_stud").each(function() {
            this.checked=true;
        });
      } else {
        $(".select_stud").each(function() {
            this.checked=false;
        });
      }
    });

    $(".select_stud").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".select_stud").each(function() {
            if (!this.checked)
                isAllChecked = 1;
        });

        if (isAllChecked == 0) {
            $("#chk_stud").prop("checked", true);
        }     
      }
      else {
        $("#chk_stud").prop("checked", false);
      }
    });

    $("#filter_st").keyup(function() {
   
      var filter_st = $(this).val(),
      count = 0;

      $('#results tr').each(function() {
        if ($(this).text().search(new RegExp(filter_st, "i")) < 0) {
          $(this).hide();
        } else {
          $(this).show();
          count++;
        }
      });
    });
  });
</script>
<script type="text/javascript">
  function count_check_subs(){

    var chks = $('.select_stud').filter(':checked').length

    if(chks > 0){
     document.getElementById('btn_add_stud').disabled= false;
    }else{
     document.getElementById('btn_add_stud').disabled= true;
    }
  }
</script>