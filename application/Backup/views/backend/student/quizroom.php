<?php $details = $this->db->get_where('tbl_online_quiz', array('code' => $code))->result_array();
	foreach($details as $row):
?>
<div class="content-w">
      <div class="conty">
  <?php include 'fancy.php';?>
  <div class="header-spacer"></div>
  <div class="content-i">
    <div class="content-box">
		<div class="element-box lined-primary shadow"  style="text-align:center">
			<div class="col-sm-8" style="margin: 0 auto;"><h3 class="form-header"><?php echo get_phrase('quiz_information');?></h3><br>
				<p><?php echo $row['instruction'];?></p><br>
			</div>
			<div class="table-responsive col-sm-8" style="margin: 0 auto; text-align:left">
			<table class="table table-lightbor table-lightfont">
			  <tr>
				<th><i class="picons-thin-icon-thin-0014_notebook_paper_todo" style="font-size:30px"></i></th>
				<td>
				 <strong> <?php echo get_phrase('total_questions');?>:</strong> <?php $this->db->where('online_quiz_id',$row['online_quiz_id']);  echo $this->db->count_all_results('tbl_question_bank_quiz');?>.
				</td>
			  </tr>
			  <tr>
				<th><i class="picons-thin-icon-thin-0027_stopwatch_timer_running_time" style="font-size:30px"></i></th>
				<td>
				<strong><?php echo get_phrase('duration');?>:</strong> 
				<?php $minutes = number_format($row['duration']/60,0); echo $minutes;?> <?php echo get_phrase('minutes');?>.
				</td>
			  </tr>
			  <tr>
				<th><i class="picons-thin-icon-thin-0007_book_reading_read_bookmark" style="font-size:30px"></i></th>
				<td>
				 <strong> <?php echo get_phrase('average_required');?>:</strong> <a class="btn btn-rounded btn-sm btn-primary" style="color:white"><?php echo $row['minimum_percentage'];?>%</a>
				</td>
			  </tr>
			  <tr>
				<th><i class="picons-thin-icon-thin-0207_list_checkbox_todo_done" style="font-size:30px"></i></th>
				<td>Answer all the questions before sending your quiz.</td>
			  </tr>
			  <tr>
				<th><i class="picons-thin-icon-thin-0376_screen_analytics_line_graph_growth" style="font-size:30px"></i></th>
				<td>
				  <?php echo get_phrase('finish_message');?>
				</td>
			  </tr>
			  <tr>
				<th><i class="picons-thin-icon-thin-0061_error_warning_alert_attention" style="font-size:30px"></i></th>
				<td style="color:red">
				  <strong><?php echo get_phrase('important');?>!</strong>
				  At the end of the quiz, be sure to click on the End quiz button, which is located on the top left..
				</td>
			  </tr>
		  </table>
		</div>		
		<a class="btn btn-rounded btn-lg btn-success" href="<?php echo base_url();?>student/take_online_quiz/<?php echo $row['code'];?>/"><?php echo get_phrase('start_quiz');?></a>
		</div>
</div>
</div>
</div>
</div>
<?php endforeach;?>