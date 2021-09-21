<style type="text/css" media="screen">
	.red {
        color: #f44336;
    }
</style>

<?php echo form_open(base_url() . 'admin/manage_online_exam_question/'.$online_exam_id.'/add/essay' , array('enctype' => 'multipart/form-data'));?>

<input type="hidden" name="type" value="<?php echo $question_type;?>">

<div class="form-group">

    <label class="col-sm-3 control-label"><?php echo get_phrase('points');?></label>
    
    <div class="col-sm-12">

        <input type="number" class="form-control" name="mark" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" min="0"/>

    </div>

</div>

<div class="form-group">

    <label class="col-sm-3 control-label"><?php echo get_phrase('question');?></label>

    <div class="col-sm-12">

        <textarea onkeyup="changeTheBlankColor()" name="question_title" class="form-control" id="question_title" rows="8" cols="80" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>

    </div>

</div>

<div class="form-group">

    <label class="col-sm-3 control-label"><?php echo get_phrase('preview');?>:</label>
    
    <div class="col-sm-12">
       
        <div class="" id="preview"></div>
   
    </div>

</div>

<div class="form-group">

    <div class="col-sm-12">

        <button type="submit" class="btn btn-success btn-block"><?php echo get_phrase('save');?></button>
    
    </div>

</div>

<?php echo form_close();?>

<script type="text/javascript">

	function changeTheBlankColor() {

        var alpha = ["_"];

        var res = "", cls = "";

        var t = jQuery("#question_title").val();

        for (i=0; i<t.length; i++) {

            for (j=0; j<alpha.length; j++) {

                if (t[i] == alpha[j])
                {
                    cls = "red";
                }

            }

            if (t[i] === "_") {

                res += "<span class='"+cls+"'>"+'__'+"</span>";
            
            }
            else{

                res += "<span class='"+cls+"'>"+t[i]+"</span>";
            
            }

            cls="";

        }

        jQuery("#preview").html(res);

    }

</script>