<?php
/**
 * Template Name: 28-day-template-step-4
 *
 * The archives page template displays a conprehensive archive of the current
 * content of your website on a single page.
 *
 * @package WooFramework
 * @subpackage Template
 */

global $woo_options;
get_header();
?>

<div id="page-content">

	<div id="content-container" class="container_24">

		<?php if ( isset( $woo_options['woo_breadcrumbs_show'] ) && $woo_options['woo_breadcrumbs_show'] == 'true' ) { ?>
		<section id="breadcrumbs">
			<?php woo_breadcrumbs(); ?>
		</section><!--/#breadcrumbs -->
		<?php } ?>

		<section id="main" class="col-left">
			<!--This page is a fourth step one for 28-day C.B.R.T Program.-->

			<?php
			$step_num = 4;

			$lang="se"; // or "en"
			if($lang =="en")
				$page_path_str = "improve-your-breathing";
			else
				$page_path_str = "andningstraning";

			$parent = get_page_by_path($page_path_str);
			$cbr_pages = get_pages(array('child_of' => $parent->ID,'sort_column'=> 'page_title','sort_order'=>'asc'));
			//print_r($cbr_pages);


			$next_step = $step_num+1;
			if($next_step>7)
				$next_step = 7;
			$prev_step = $step_num-1;
			if($prev_step<1)
				$prev_step = 1;

			//in-array index should be step_num-1
			$next_page = $cbr_pages[$next_step-1];
			$prev_page = $cbr_pages[$prev_step-1];
			$first_page = $cbr_pages[0];

			//$lang="en"; // or "en"
			$query="SELECT `text_id`, `".$lang."_text` AS `text` FROM `tw_text` ORDER BY `text_id` ASC";
			$text_result=$wpdb->get_results($query);
			if ($text_result){
				$text=array();
				foreach($text_result as $row){
					$text_id=(int) $row->text_id;
					$text[$text_id]=$row->text;
				}
				$current_user = wp_get_current_user();
			    $user_id= $current_user->ID ;
				if ($user_id==0){//when user was unlogged
			?>
					<!--div style="font-size: 18px; line-height: 35px;">You should log in for using this 28-Day C.B.R.T Program.<br>Please log in.</div-->
					<div style="text-align:center;"><h2><?php echo add_login_link($text[52], get_permalink(woocommerce_get_page_id('myaccount')),$lang); ?></h2></div>
			<?php
				}else{//when user was logged
			?>
					<div class='stepWrapper' stepNum="5">
						<img src='<?=CHILD_DIR."/images/step4_header.jpg" ?>'>
							<div class="description description-main">
								<!-- Enter details of your daily workouts in the training schedule below. -->
								<?php echo $text[140]; ?>
								<ul>
									<li><b><?php echo $text[141];//Tape ?></b>	= <?php echo $text[144];//check if you slept with taped mouth ?></li>
									<li><b><?php echo $text[142];//Relaxator ?></b> = <?php echo $text[145];//the number of minutes you used the Relaxator Breathing Re-trainer ?></li>
									<li><b><?php echo $text[143];//Physical activity ?></b> = <?php echo $text[146];//the number of minutes of physical activity with your mouth closed, and type of activity ?></li>
								</ul>
 					</div>
						<div class="step-content">
							<?php
								$message="";
								$tape_use=array();
								$relaxator=array();
								$physical=array();
								$use_flag=array();

								$last_used_day=0;
								$week_num=0;
								$step5_week_pass_flag=0;

								$total_use_day=0;
								$total_tape_number=0;
								$total_time_relaxator=0;
								$total_time_physical=0;

								$relaxator_use_day=0;
								$physical_act_day=0;
								$average_time_relaxator=0;
								$average_time_physical=0;

								$pass_flag=false;
								$course_id=0;

								$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
								$result1=$wpdb->get_row($query);
							        	if ($result1){
									//current course ID
									$course_id=$result1->course_id;

									//current course step
									$course_current_step=$result1->course_current_step;

									$query="SELECT * FROM `tw_step_4` WHERE `course_id`=".$course_id;
									$result2=$wpdb->get_results($wpdb->prepare($query));

									if ($result2){
										$pass_flag=true;
										foreach($result2 as $row){

											$temp= $row->tape_use;
											array_push($tape_use,$temp);
											if ($temp=="1"){ $total_tape_number++;}

											$temp= $row->relaxator;
											array_push($relaxator,$temp);
											if ($temp!="0"){ $total_time_relaxator+= intval($temp);$relaxator_use_day++;}

											$temp= $row->physical;
											array_push($physical,$temp);
											if ($temp!="0"){ $total_time_physical+= intval($temp);$physical_act_day++;}

											$temp= $row->use_flag;
											array_push($use_flag,$temp);
											if (intval($temp)>0){
												$total_use_day++;
												$last_used_day=intval($row->day_num);
											}
										}

										//if ($relaxator_use_day>0) { $average_time_relaxator=floor($total_time_relaxator/$relaxator_use_day); }
										//if ($physical_act_day>0) { $average_time_physical=floor($total_time_physical/$physical_act_day);}
										if ($total_use_day>0) { $average_time_relaxator=floor($total_time_relaxator/$total_use_day); }
										if ($total_use_day>0) { $average_time_physical=floor($total_time_physical/$total_use_day);}

										$message="You passed by DAY ".$last_used_day." !";
										if ($last_used_day==28){
											$message="You passed all days of 28-day schedule !";
										}

										if ($last_used_day%7==0){
											$week_num=$last_used_day/7;
											if($week_num == 0) $week_num = 1;
											$query="SELECT * FROM `tw_step_5` WHERE `course_id`=".$course_id." AND `week_num`=".$week_num;
											$result3=$wpdb->get_row($query);
											if ($result3){
												$step5_week_pass_flag=1;
											}else{
												$message="Go to step 5 and fill in the breathing habit for week ".$week_num;
											}
										}
										else{
											$week_num = $last_used_day/7 + 1;
											$step5_week_pass_flag = 1;
										}
										//var_dump($tape_use);
										//var_dump($relaxator);
										//var_dump($physical);
										//var_dump($use_flag);
									}//new
									else{
										$step5_week_pass_flag = 1;
									}

									if ($course_current_step==7){
										//$message="You passed all steps(step1~step7) already! You can finish this course in step-7 page. ";
										$message=$text[56];
									}else if ($course_current_step==6){
										//$message="You passed by sixth step already! You should pass step-7.";
										$message=$text[139];
									}
								}else{
									//$message="You should pass first step ! There is no course in progress!";
									$message=$text[106];
								}

								$info_message= "<div class='message  green_message' id='message_content'>{$message}</div>";
								echo do_shortcode("[message type='success']".$info_message."[/message]");
								?>

							<!--<div class="schedule-title" align="center"><?php // echo $text[147];//28-DAY SCHEDULE ?><H1>TRAINING SCHEDULE 28-DAY CONSCIOUS BREATHING RETRAINING</H1></div>-->
							<div class="schedule-content">
								<?php
								for ($i=1;$i<29;$i++){
								?>
								<div class="single-day<?php if ($pass_flag && (intval($use_flag[$i-1])>0)) { if ($use_flag[$i-1]==1) {echo " used_day";} else{echo " no_training_day";}} else {echo " unused_day";} ?>" dayNum="<?php echo $i;?>">
									<div class="day-title"><?php echo $text[148];//DAY ?> <?php echo $i;?></div>
								<!-- 	<div class="no-train"><input type="checkbox" name="day-<?php echo $i;?>-no-train" id="day-<?php echo $i;?>-no-train" <?php if ($pass_flag && ($use_flag[$i-1]==2)) {echo "checked";} ?>><label for="day-<?php echo $i;?>-no-train"><?php echo $text[161];//No trained day ?></label></div> -->
									<div class="tape"><label for="day-<?php echo $i;?>-tape"><?php echo $text[149];//Tape use ?></label><input type="checkbox" name="day-<?php echo $i;?>-tape" id="day-<?php echo $i;?>-tape" <?php if ($pass_flag && (intval($tape_use[$i-1])==1)) {echo "checked";} ?> <?php if ($pass_flag && ($use_flag[$i-1]==2)) {echo "disabled";} ?>></div>
									<div class="relaxator"><span><?php echo $text[150];//Relaxator ?>:</span><input name="day-<?php echo $i;?>-relaxator" value="<?php if ($pass_flag) { echo $relaxator[$i-1];}else{echo "0";} ?>" <?php if ($pass_flag && ($use_flag[$i-1]==2)) {echo "disabled";} ?>><span><?php// echo $text[152];//minutes ?>minuter</span></div>
									<div class="physical-activity"><span><?php echo $text[151];//Physical act ?>:</span><input name="day-<?php echo $i;?>-physical" value="<?php if ($pass_flag) { echo $physical[$i-1];}else{echo "0";} ?>" <?php if ($pass_flag && ($use_flag[$i-1]==2)) {echo "disabled";} ?>><span><?php// echo $text[152];//minutes ?>minuter</span></div>
								</div>
								<?php
								}
								?>
								<!--div class="single-day used_day" dayNum="1">
									<div class="day-title">DAY 1</div>
									<div class="tape"><input type="checkbox" name="day-1-tape" id="day-1-tape"><label for="day-1-tape">Tape use</label></div>
									<div class="relaxator"><span>Relaxator:</span><input name="day-1-relaxator"><span>minutes</span></div>
									<div class="physical-activity"><span>Physical act:</span><input name="day-1-physical"><span>minutes</span></div>
								</div-->
							</div>
							<div class="controls">
								<div class="buttons">
									<?php if ($pass_flag){ ?>
									<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
									<span class="update"><?php echo $text[162];//Save / Update ?></span>
									<!--span class="reset"><?php echo $text[69];//Reset ?></span-->
									<span class="next-step"><?php echo $text[70];//To next step ?></span>
									<?php }else if ($course_id!=0){ ?>
									<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
									<span class="update" style="display:none;"><?php echo $text[162];//Save / Update ?></span>
									<span class="save"><?php echo $text[71];//Save ?></span>
									<!--span class="reset"><?php echo $text[69];//Reset ?></span-->
									<span class="next-step"><?php echo $text[70];//To next step ?></span>
									<?php }else{ ?>
									<span class="first-step"><?php echo $text[134];//To first step ?></span>
									<?php } ?>

								</div>
							</div>
							<div style="clear:both;"></div>

								<?php if ($pass_flag):
									ob_start();?>
								<div class="statistic-title"><?php echo $text[153];//Total Statistic ?> :</div>
								<div class="single-statistic daycount">
									<span class="statistic-label"><?php echo $text[154];//The number of used day ?>: </span><span class="statistic-value"><?php echo $total_use_day; ?></span><span> <?php echo $text[155];//of 28 ?></span>
								</div>
								<div class="single-statistic tape-num">
									<span class="statistic-label"><?php echo $text[156];//Total number of nights slept with taped mouth ?>: </span><span class="statistic-value"><?php echo $total_tape_number; ?></span><span> <?php echo $text[163];//nights of ?> </span><span class="statistic-value"><?php echo $total_use_day; ?></span>
								</div>
								<div class="single-statistic relaxator-time">
									<span class="statistic-label"><?php echo $text[158];//Total minutes using the Relaxator ?> : </span><span class="statistic-value"><?php echo $total_time_relaxator; ?></span><span> <?php echo $text[152];//minutes ?> ( </span><span class="statistic-value"><?php echo $average_time_relaxator; ?></span><span> <?php echo $text[164];//minutes/day ?> )</span>
								</div>
								<div class="single-statistic physical-time">
									<span class="statistic-label"><?php echo $text[159];//Total minutes doing physical activity with the mouth closed ?>: </span><span class="statistic-value"><?php echo $total_time_physical; ?></span><span> <?php echo $text[152];//minutes ?> ( </span><span class="statistic-value"><?php echo $average_time_physical; ?></span><span> <?php echo $text[164];//minutes/day ?> )</span>
								</div>
								<?php $statistics = ob_get_clean();
									echo do_shortcode("[message type='info']".$statistics."[/message]");
									endif;
								?>
							</div>

						</div>
					</div>
					<script>
					jQuery(document).ready(function(){
						<?php if(empty($message)):?>
						jQuery("div.step-content .success:eq(0)").hide();
						<?php endif; ?>
						var tape=Array();
						var relaxator=Array();
						var physical=Array();
						var use_flag=Array();
						var origin_use_flag=Array();
						var origin_tape=Array();
						var origin_relaxator=Array();
						var origin_physical=Array();
						var total_use_day=parseInt(jQuery(".statistic .daycount .statistic-value").html());
						var total_tap_number=parseInt(jQuery(".statistic .tape-num .statistic-value").html());
						var total_time_relaxator=parseInt(jQuery(".statistic .relaxator-time .statistic-value").html());
						var total_time_physical=parseInt(jQuery(".statistic .physical-time .statistic-value").html());

						var dayCount= jQuery(".single-day").size();
						//var last_used_week = 0;
						var last_used_day=parseInt(<?php echo $last_used_day; ?>);
						var last_used_week=parseInt(<?php echo $week_num; ?>);

						//at beginning week_num set 1
						var week_num = last_used_week+1;
						console.log("week_num:" + week_num);

						var step5_week_pass_flag=parseInt(<?php echo $step5_week_pass_flag; ?>);

						var forward_day=jQuery(".single-day[daynum='"+(last_used_day+1)+"'] .day-title");

						//now we submit one WEEK data...
						var forward_week = week_num;
						//Originally forward_day used to mark current checking day, now current_week is  used & users have to fill in form 7 days
						//TO DO: check validity for all 7days in a week.
						if (week_num>0 && step5_week_pass_flag==0){
							alert("Go to step 5 and fill in the breathing habit for week "+last_used_week);
						}else{
							//animate current day...
							var flush_flag=false;
							//in next version we just show enabled days with little light background color....
							/*
							var forward_day_timer=setInterval(function(){
								if (flush_flag){
									forward_day.css("color","#585858");
									flush_flag=false;
								}else{
									forward_day.css("color","#FFF");
									flush_flag=true;
								}
							},500);
							*/
						}
						var week_start_day = (week_num-1)*7+1;
						var week_end_day = week_num * 7;
						if(last_used_day==28) // we can updte any data
						{
							week_start_day = 1;
							week_end_day = 28;
						}
						console.log(week_start_day);
						console.log(week_end_day);
						jQuery(".single-day").each(function(index){


							if (jQuery(this).find(".tape input").is(':checked')){
								tape[index]=1;
							}else{
								tape[index]=0;
							}
							var temp=parseInt(jQuery(this).find(".relaxator input").val());
							if (isNaN(temp)){
								temp=0;
								jQuery(this).find(".relaxator input").val(temp);
							}
							relaxator[index]=temp;

							temp=parseInt(jQuery(this).find(".physical-activity input").val());
							if (isNaN(temp)){
								temp=0;
								jQuery(this).find(".physical-activity input").val(temp);
							}
							physical[index]=temp;

							if (tape[index]==1 || relaxator[index]!=0 || physical[index]!=0 ){
								use_flag[index]=1;
							}else{
								if (jQuery(this).find(".no-train input").is(':checked')){
									use_flag[index]=2;
								}else{
									use_flag[index]=0;
								}
							}
							//allow one week days
							//range ...

							//if (index > last_used_day || (index == last_used_day && week_num>0 && step5_week_pass_flag==0)){
							if(index > week_end_day-1 || index < week_start_day-1){
								jQuery(this).find(".tape input").attr("disabled","disabled");
								jQuery(this).find(".relaxator input").attr("disabled","disabled");
								jQuery(this).find(".physical-activity input").attr("disabled","disabled");
								jQuery(this).find(".no-train input").attr("disabled","disabled");
							}else{
								jQuery(this).css('background-color','#e0e0e0');
							}

						});
						origin_tape=tape.slice();
						origin_relaxator=relaxator.slice();
						origin_physical=physical.slice();
						origin_use_flag=use_flag.slice();

						//console.log(origin_use_flag);
						//console.log(origin_tape);
						//console.log(origin_relaxator);
						//console.log(origin_physical);

						jQuery(".no-train input").click(function(){
							if (jQuery(this).is(':checked')){
								//alert("this is no trained day !");
								jQuery(this).parent().parent().find(".tape input").removeAttr("checked");
								jQuery(this).parent().parent().find(".relaxator input").val("0");
								jQuery(this).parent().parent().find(".physical-activity input").val("0");

								jQuery(this).parent().parent().find(".tape input").attr("disabled","disabled");
								jQuery(this).parent().parent().find(".relaxator input").attr("disabled","disabled");
								jQuery(this).parent().parent().find(".physical-activity input").attr("disabled","disabled");
							}else{
								//alert("this is trained day !");
								var index=parseInt(jQuery(this).parent().parent().attr("daynum"))-1;
								if (tape[index]==1){
									jQuery(this).parent().parent().find(".tape input").attr("checked","checked");
								}else{
									jQuery(this).parent().parent().find(".tape input").removeAttr("checked");
								}
								jQuery(this).parent().parent().find(".relaxator input").val(relaxator[index]);
								jQuery(this).parent().parent().find(".physical-activity input").val(physical[index]);

								jQuery(this).parent().parent().find(".tape input").removeAttr("disabled");
								jQuery(this).parent().parent().find(".relaxator input").removeAttr("disabled");
								jQuery(this).parent().parent().find(".physical-activity input").removeAttr("disabled");
							}
						});

						jQuery(".controls .save").click(function(){
							total_tap_number=0;
							total_time_relaxator=0;
							total_time_physical=0;
							total_use_day=0;
							//number of days traiend in A WEEK...
							full_number_of_days = 0;
							valid_flag=false;
							jQuery(".single-day").each(function(index){
								//first only check those in ranges....
								if(index > week_end_day-1 || index < week_start_day-1)
									return;
								//console.log(index);
								if (jQuery(this).find(".tape input").is(':checked')){
									tape[index]=1;
									total_tap_number++;
								}else{
									tape[index]=0;
								}

								var temp=parseInt(jQuery(this).find(".relaxator input").val());
								if (isNaN(temp)){
									temp=0;
									jQuery(this).find(".relaxator input").val(temp);
								}
								relaxator[index]=temp;
								total_time_relaxator+=relaxator[index];

								temp=parseInt(jQuery(this).find(".physical-activity input").val());
								if (isNaN(temp)){
									temp=0;
									jQuery(this).find(".physical-activity input").val(temp);
								}
								physical[index]=temp;
								total_time_physical+=physical[index];

								if (tape[index]==1 || relaxator[index]!=0 || physical[index]!=0 ){
									use_flag[index]=1;
									total_use_day++;
									valid_flag=true;
								}else{
									if (jQuery(this).find(".no-train input").is(':checked')){
										use_flag[index]=2;
										valid_flag=true;
									}else{
										use_flag[index]=0;
									}
								}
								if(valid_flag)
								{
									full_number_of_days++;
									valid_flag = false;
								}
							});
							console.log('full_days  '+ full_number_of_days);
							//if (valid_flag){
							if(full_number_of_days == 7){
								jQuery.ajax({
									type : "POST",
									async : true,
									url : "<?=get_stylesheet_directory_uri()?>/breathing-step-save.php",
									data : {
										user_id: <?php echo $user_id;?>,
										step_num:4,
										tape:tape,
										relaxator:relaxator,
										physical:physical,
										use_flag:use_flag
									},
									cache : false,
									global : false,
									dataType : "json",
									error : function(i, g, h) {
										//jQuery(".step-content .message").removeClass("green_message").html("Saving failed!");
										jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[74]; ?>");
										animateScrollTop(".step-content .message",'3000');
									},
									success : function(g) {
										if (g.status=="ok"){
											window.location.reload( true );
											//jQuery(".step-content .message").addClass("green_message").html("Saving succeed!");
											jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
											jQuery(".step-content .message").addClass("green_message").html("<?php echo $text[160]; ?>");
											animateScrollTop(".step-content .message",'3000');

										}else{
											jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
											jQuery(".step-content .message").removeClass("green_message").html(g.status);
											animateScrollTop(".step-content .message",'3000');
											console.log(g.query);
										}
									}
								});
							}else{
								//jQuery(".step-content .message").removeClass("green_message").html("There are no any changes for saving !");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[165]; ?>");
								animateScrollTop(".step-content .message",'3000');
							}
						});

						jQuery(".controls .update").click(function(){
							total_tap_number=0;
							total_time_relaxator=0;
							total_time_physical=0;
							total_use_day=0;

							//number of days traiend in A WEEK...
							full_number_of_days = 0;
							valid_flag=false;
							invalid_day = [];
							jQuery(".single-day").each(function(index){

								//console.log(index);
								if(index > week_end_day-1 || index < week_start_day-1)
									return;

								if (jQuery(this).find(".tape input").is(':checked')){
									tape[index]=1;
									total_tap_number++;
								}else{
									tape[index]=0;
								}

								var temp=parseInt(jQuery(this).find(".relaxator input").val());
								if (isNaN(temp)){
									temp=0;
									jQuery(this).find(".relaxator input").val(temp);
								}
								relaxator[index]=temp;
								total_time_relaxator+=relaxator[index];

								temp=parseInt(jQuery(this).find(".physical-activity input").val());
								if (isNaN(temp)){
									temp=0;
									jQuery(this).find(".physical-activity input").val(temp);
								}
								physical[index]=temp;
								total_time_physical+=physical[index];

								if (tape[index]==1 || relaxator[index]!=0 || physical[index]!=0 ){
									use_flag[index]=1;
									total_use_day++;
									valid_flag = true;
								}else{
									if (jQuery(this).find(".no-train input").is(':checked')){
										use_flag[index]=2;
										valid_flag = true;
									}else{
										use_flag[index]=0;
										if (index<week_end_day){
											valid_flag=false;
											invalid_day.push(index+1);
											console.log("invalid day:" + (index+1));
										}
									}
								}
								if(valid_flag)
								{
									full_number_of_days++;
									valid_flag = false;
								}
							});
							console.log(full_number_of_days);
							if (full_number_of_days == 7 || last_used_day==28){
								if (!(origin_use_flag.toString()==use_flag.toString() && origin_tape.toString()==tape.toString() && origin_relaxator.toString()==relaxator.toString() && origin_physical.toString()==physical.toString() )){
									jQuery.ajax({
										type : "POST",
										async : true,
										url : "<?=get_stylesheet_directory_uri()?>/breathing-step-update.php",
										data : {
											user_id: <?php echo $user_id;?>,
											step_num:4,
											tape:tape,
											relaxator:relaxator,
											physical:physical,
											use_flag: use_flag
										},
										cache : false,
										global : false,
										dataType : "json",
										error : function(i, g, h) {
											//jQuery(".step-content .message").removeClass("green_message").html("Updating failed!");
											jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
											jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[76]; ?>");
											animateScrollTop(".step-content .message",'3000');
										},
										success : function(g) {
											if (g.status=="ok"){
												window.location.reload( true );
												//jQuery(".step-content .message").addClass("green_message").html("Updating succeed!");
												jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
												jQuery(".step-content .message").addClass("green_message").html("<?php echo $text[77]; ?>");
												animateScrollTop(".step-content .message",'3000');

											}else{
												jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
												jQuery(".step-content .message").removeClass("green_message").html(g.status);
												animateScrollTop(".step-content .message",'3000');
											}
										}
									});
								}else{
									//jQuery(".step-content .message").removeClass("green_message").html("There are no any changes for updating !");
									jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
									jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[78]; ?>");
									animateScrollTop(".step-content .message",'3000');
								}
							}else{
								//jQuery(".step-content .message").removeClass("green_message").html("Updating Failed: You can not update with invalid values ! Please input values of DAY "+invalid_day);
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[166];//Updating Failed: You can not update with invalid values ! Please input values of DAY ?> "+invalid_day);
								animateScrollTop(".step-content .message",'3000');
							}
						});

						jQuery(".controls .reset").click(function(){
							for (var i=0;i<dayCount;i++){
								tape[i]=0;
								relaxator[i]=0;
								physical[i]=0;
								use_flag[i]=0;
							}
							jQuery(".single-day").each(function(index){
								//console.log(index);
								jQuery(this).find(".tape input").prop( "checked", false );
								jQuery(this).find(".relaxator input").val("0");
								jQuery(this).find(".physical-activity input").val("0");
							});
							jQuery(".statistic .daycount .statistic-value").html("0");
							jQuery(".statistic .tape-num .statistic-value").html("0");
							jQuery(".statistic .relaxator-time .statistic-value").html("0");
							jQuery(".statistic .physical-time .statistic-value").html("0");
							jQuery(".single-day").removeClass("used_day");
						});

						jQuery(".controls .next-step").click(function(){
							window.location.replace("<?php echo get_page_link($next_page->ID); ?>");
						});

						jQuery(".controls .prev-step").click(function(){
							window.location.replace("<?php echo get_page_link($prev_page->ID); ?>");
						});
						jQuery(".controls .first-step").click(function(){
							window.location.replace("<?php echo get_page_link($first_page->ID); ?>");
						});
					});
					</script>
			<?php
				}
			}else{
			?>
				<div style="font-size: 18px; line-height: 35px;">Database error!</div>
			<?php
			}
			?>
		</section><!-- /#main -->

		<?php // get_sidebar(); ?>

	</div>

</div><!-- /#content -->

<?php get_footer(); ?>
