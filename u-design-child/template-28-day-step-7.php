<?php
/**
 * Template Name: 28-day-template-step-7
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
			<!--This page is a seventh step one for 28-day C.B.R.T Program.-->

			<?php
			/* echo do_shortcode("[message type='erroneous']xxx[/message]");
			echo do_shortcode("[message type='info']xxx[/message]");
			echo do_shortcode("[message type='success']xxx[/message]");
			echo do_shortcode("[message type='warning']xxx[/message]"); */

			$step_num = 7;
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


			//$lang="se"; // or "en"
			$query="SELECT `text_id`, `{$lang}_text` AS `text` FROM `tw_text` ORDER BY `text_id` ASC";
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
					<div style="text-align:center;"><h2><?php echo add_login_link($text[52],get_permalink(woocommerce_get_page_id('myaccount')),$lang); ?></h2></div>
			<?php
				}else{//when user was logged
			?>
					<div class='stepWrapper' stepNum="7">
						<img src='<?=CHILD_DIR."/images/step7_header.jpg" ?>'>

								<?php ob_start(); ?>
								<div class="statistic-title"><?php echo $text[209];//Breathing Training Statistic ?> :</div>
								<div class="single-statistic daycount">
									<span class="statistic-label"><?php echo $text[154];//The number of used day ?>: </span><span class="statistic-value"><?php echo $total_use_day; ?></span><span> <?php echo $text[155];//of 28 ?></span>
								</div>
								<div class="single-statistic tape-num">
									<span class="statistic-label"><?php echo $text[156];//Total number of nights slept with taped mouth ?>: </span><span class="statistic-value"><?php echo $total_tape_number; ?></span><span> <?php echo $text[163];//nights of ?> </span><span class="statistic-value"><?php echo $total_use_day; ?></span>
								</div>
								<div class="single-statistic relaxator-time">
									<span class="statistic-label"><?php echo $text[158];//Total minutes using the Relaxator ?>: </span><span class="statistic-value"><?php echo $total_time_relaxator; ?></span><span> <?php echo $text[152];//minutes ?> ( </span><span class="statistic-value"><?php echo $average_time_relaxator; ?></span><span> <?php echo $text[164];//minutes/day ?> )</span>
								</div>
								<div class="single-statistic physical-time">
									<span class="statistic-label"><?php echo $text[159];//Total minutes doing physical activity with the mouth closed ?>: </span><span class="statistic-value"><?php echo $total_time_physical; ?></span><span> <?php echo $text[152];//minutes ?> ( </span><span class="statistic-value"><?php echo $average_time_physical; ?></span><span> <?php echo $text[164];//minutes/day ?> )</span>
								</div>
								<?php $statistics = ob_get_clean();
									echo do_shortcode("[message type='info']".$statistics."[/message]");
								?>

						</div>
						<div class="step-content">
							<?php
								$message="";

								$improvement_flag=false;
								$improvements=array();
								$answers=array();
								$index_before="";
								$index_after="";
								$habits_week_1="";
								$habits_week_4="";
								$awareness_answer="";
								$reach_goal_answer="";

								$total_use_day=0;
								$total_tape_number=0;
								$total_time_relaxator=0;
								$total_time_physical=0;

								$relaxator_use_day=0;
								$physical_act_day=0;
								$average_time_relaxator=0;
								$average_time_physical=0;

								$pass_flag=0;
								$course_id=0;

								$query="SELECT b.`{$lang}_text` AS `improvement` FROM `tw_step_7_improvement` a, `tw_text` b WHERE a.`text_id`= b.`text_id`"; // or "en_text"
								$result0=$wpdb->get_results($wpdb->prepare($query));
								if ($result0){
									$improvement_flag=true;
									foreach ($result0 as $row){
										$temp=(String) $row->improvement;
										array_push($improvements,$temp);
									}
								}

								$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
								$result1=$wpdb->get_row($query);
								if ($result1){
									$course_id=$result1->course_id;
									$course_current_step=$result1->course_current_step;

									if ($course_current_step>3){
										$query="SELECT * FROM `tw_step_4` WHERE `course_id`=".$course_id;
										$result7=$wpdb->get_results($wpdb->prepare($query));
										if ($result7){
											foreach($result7 as $row){
												$temp= $row->tape_use;
												if ($temp=="1"){ $total_tape_number++;}
												$temp= $row->relaxator;
												if ($temp!="0"){ $total_time_relaxator+= intval($temp);$relaxator_use_day++;}
												$temp= $row->physical;
												if ($temp!="0"){ $total_time_physical+= intval($temp);$physical_act_day++;}
												$temp= $row->use_flag;
												if (intval($temp)>0){
													$total_use_day++;
													$last_used_day=intval($row->day_num);
												}
											}

											//if ($relaxator_use_day>0) { $average_time_relaxator=floor($total_time_relaxator/$relaxator_use_day); }
											//if ($physical_act_day>0) { $average_time_physical=floor($total_time_physical/$physical_act_day);}
											if ($total_use_day>0) { $average_time_relaxator=floor($total_time_relaxator/$total_use_day); }
											if ($total_use_day>0) { $average_time_physical=floor($total_time_physical/$total_use_day);}
										}
									}

									if ($course_current_step==7){
										//$message="You passed all steps(step1~step7) already! You can finish this course in step-7 page. ";
										$message=$text[56];

										$query="SELECT * FROM `tw_step_7` WHERE `course_id`=".$course_id;
										$result2=$wpdb->get_row($query);
										if ($result2){
											$pass_flag=7;
											/*
											$index_before=$result2->index_before;
											$index_after=$result2->index_after;
											$habits_week_1=$result2->habits_week_1;
											$habits_week_4=$result2->habits_week_4;
											*/
											$answers_str=$result2->improvements;

											/* $answers_str=urldecode($answers_str);
											$answers=unserialize($answers_str); */
											$answers = json_decode($answers_str);

											$awareness_answer=$result2->awareness_answer;
											$reach_goal_answer=$result2->reach_goal_answer;

											$query="SELECT * FROM `tw_step_1` WHERE `course_id`=".$course_id;
											$result3=$wpdb->get_row($query);
											if ($result3){
												$index_before=$result3->total_score;
											}
											$query="SELECT * FROM `tw_step_6` WHERE `course_id`=".$course_id;
											$result4=$wpdb->get_row($query);
											if ($result4){
												$index_after=$result4->total_score;
											}
											$query="SELECT * FROM `tw_step_5` WHERE `course_id`=".$course_id." AND `week_num`=1";
											$result5=$wpdb->get_row($query);
											if ($result5){
												$habits_week_1=$result5->total_score;
											}
											$query="SELECT * FROM `tw_step_5` WHERE `course_id`=".$course_id." AND `week_num`=4";
											$result6=$wpdb->get_row($query);
											if ($result6){
												$habits_week_4=$result6->total_score;
											}
										}else{
											//$message="You passed seventh step already! But not found the entry data of seventh step !";
											$message=$text[202];
										}

									}else{
										//$message="You passed by step-".$course_current_step." !";
										switch ($course_current_step){
											case 1:
												$message=$text[203]." !";
												break;
											case 2:
												$message=$text[204]." !";
												break;
											case 3:
												$message=$text[205]." !";
												break;
											case 4:
												$message=$text[206]." !";
												break;
											case 5:
												$message=$text[207]." !";
												break;
											case 6:
												$message=$text[208]." !";
												break;
										}
										if ($course_current_step==6){
											$pass_flag=6;

											$query="SELECT * FROM `tw_step_1` WHERE `course_id`=".$course_id;
											$result3=$wpdb->get_row($query);
											if ($result3){
												$index_before=$result3->total_score;
											}
											$query="SELECT * FROM `tw_step_6` WHERE `course_id`=".$course_id;
											$result4=$wpdb->get_row($query);
											if ($result4){
												$index_after=$result4->total_score;
											}
											$query="SELECT * FROM `tw_step_5` WHERE `course_id`=".$course_id." AND `week_num`=1";
											$result5=$wpdb->get_row($query);
											if ($result5){
												$habits_week_1=$result5->total_score;
											}
											$query="SELECT * FROM `tw_step_5` WHERE `course_id`=".$course_id." AND `week_num`=4";
											$result6=$wpdb->get_row($query);
											if ($result6){
												$habits_week_4=$result6->total_score;
											}
										}
									}
								}else{
									//$message="You should pass first step ! There is no course in progress!";
									$message=$text[106];
								}
								$info_message= "<div class='message  green_message' id='message_content'>{$message}</div>";
								echo do_shortcode("[message type='success']".$info_message."[/message]");
								?>

							<ul>
								<li>
									<div class="evaluation-title" ><span><?php echo $text[210];//Has the breathing re-training resulted in any changes in regards to your: ?></span></div>
									<div class="evaluation-content1">
										<div class="breathing">
											<span class="breathing-index"><?php echo $text[211];//breathing index ?>:</span>
											<span class="before-index"><?php echo $text[212];//Before (Step 1 Score) ?>:</span>
											<input name="before-index" disabled value="<?php if ($pass_flag>5) echo $index_before; ?>">
											<span class="after-index"><?php echo $text[213];//After (Step 6 Score) ?>:</span>
											<input name="after-index" disabled value="<?php if ($pass_flag>5) echo $index_after; ?>">
										</div>
										<div class="breathing">
											<span class="breathing-habits"><?php echo $text[214];//breathing habits (Step 5 Score) ?>:</span>
											<span class="week-1-habits"><?php echo $text[182];//Week ?> 1:</span>
											<input name="week-1-habits" disabled value="<?php if ($pass_flag>5) echo $habits_week_1; ?>">
											<span class="week-4-habits"><?php echo $text[182];//Week ?> 4:</span>
											<input name="week-4-habits" disabled value="<?php if ($pass_flag>5) echo $habits_week_4; ?>">
										</div>
										<div style="clear:both;"></div>
									</div>
								</li>
								<li>
									<div class="evaluation-title" ><span><?php echo $text[215];//Do you feel any improvement in ?></span></div>
									<div class="evaluation-content2">
										<ul>

										<?php
											if ($improvement_flag){
												for ($i=0;$i<count($improvements);$i++){
													$question_order = sprintf("%02d",$i+1);
													echo "<li class='question_board' itemnum=\"".($i+1)."\">";
													echo "<div class='target_checkbox'><span>".$question_order."</span></div>";
													echo "<div class='target_expression'>".$improvements[$i]."</div>";

													echo "<select class=\"";
													if ($pass_flag==7) echo "choice-value"; else echo "choice-label";
													echo "\">";

														echo "<option value=\"20\" class=\"choice-label\">".$text[65]."</option>";// $text[65]="Make choice"
														echo "<option class=\"choice-value\" value=\"11\" ";
															if ($pass_flag==7 && intval($answers[$i])==11){
																echo "selected";
															}
														echo ">".$text[216]."</option>";//$text[216]="Not Applicable"
														echo "<option class=\"choice-value\" value=\"0\" ";
															if ($pass_flag==7 && intval($answers[$i])==0){
																echo "selected";
															}
														echo ">0 (".$text[217].")</option>";//$text[217]="None"

														for ($j=1;$j<10;$j++){
															echo "<option class=\"choice-value\" value=\"".$j."\" ";
																if ($pass_flag==7 && intval($answers[$i])==$j){
																	echo "selected";
																}
															echo ">".$j."</option>";
														}

														echo "<option class=\"choice-value\" value=\"10\" ";
															if ($pass_flag==7 && intval($answers[$i])==10){
																echo "selected";
															}
														echo ">10(".$text[218].")</option>";//$text[218]="Very big"
													echo "</select>";

													echo "</li>";
												}
											}else{//when datatbase error
												//$question_read_fail_message="There are no improvement items of step-7 in database !";
												$question_read_fail_message=$text[219];
												echo "<li>".$question_read_fail_message."</li>";
										?>
											<!--li itemnum="1">
												<span>Concentration</span>
												<select class="choice-label">
													<option class="choice-label" value="20">Make choice</option>
													<option class="choice-value" value="11">Not Applicable</option>
													<option class="choice-value" value="0">0 (None)</option>
													<?php for ($i=1;$i<10;$i++){ ?>
													<option class="choice-value" value="<?php echo $i;?>"><?php echo $i;?></option>
													<?php } ?>
													<option class="choice-value" value="10">10(Very big)</option>
												</select>
											</li-->
										<?php } ?>
										</ul>
									</div>
								</li>
								<li>
									<div class="evaluation-title" ><span><?php echo $text[220];//Has your breathing awareness increased? In what way? ?></span></div>
									<div class="evaluation-content3"><textarea name="evaluation3-textarea" rows="3"><?php if ($pass_flag==7) echo $awareness_answer; ?></textarea></div>
								</li>
								<li>
									<div class="evaluation-title" ><span><?php echo $text[221];//How did breathing re-training help you reach or get closer to the goals you specified in Step 2? ?></span></div>
									<div class="evaluation-content4"><textarea name="evaluation4-textarea" rows="3"><?php if ($pass_flag==7) echo $reach_goal_answer; ?></textarea></div>
								</li>
							</ul>
							<div class="controls">
								<div class="buttons">
									<?php if ($pass_flag==7){ ?>
									<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
									<span class="update"><?php echo $text[68];//Update ?></span>
									<!--span class="reset"><?php echo $text[69];//Reset ?></span-->
									<?php }else if ($pass_flag==6){ ?>
									<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
									<span class="update" style="display:none;"><?php echo $text[68];//Update ?></span>
									<span class="save"><?php echo $text[71];//Save ?></span>
									<!--span class="reset"><?php echo $text[69];//Reset ?></span-->
									<?php }else if ($course_id!=0){ ?>
									<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
									<?php }else{ ?>
									<span class="first-step"><?php echo $text[134];//To first step ?></span>
									<?php } ?>
									<span class="finish"><?php echo $text[222];//Finish this course ?></span>
								</div>
							</div>
						</div>
					</div>
					<script>
						<?php if(empty($message)):?>
						jQuery("div.step-content .success:eq(0)").hide();
						<?php endif; ?>
						var index_before=0;
						var index_after=0;
						var habits_week_1=0;
						var habits_week_4=0;
						var improvements=Array();
						var awareness_answer="";
						var reach_goal_answer="";

						var origin_index_before=0;
						var origin_index_after=0;
						var origin_habits_week_1=0;
						var origin_habits_week_4=0;
						var origin_improvements=Array();
						var origin_awareness_answer="";
						var origin_reach_goal_answer="";

						var itemCount= jQuery(".evaluation-content2 ul li").size();
						for (var i=0;i<itemCount;i++){
							//improvements[i]=0;
							improvements[i]=parseInt(jQuery(".evaluation-content2 ul li:eq("+i+") select").val());
						}
						origin_improvements=improvements.slice();

						jQuery(".evaluation-content2 ul li select").change(function(){
							var itemNum=jQuery(this).parent().attr("itemnum");
							var value=jQuery(this).val();
							improvements[itemNum-1]=parseInt(value);
							if (value!="20"){
								jQuery(this).removeClass().addClass("choice-value");
							}else{
								jQuery(this).removeClass().addClass("choice-label");
							}
						});

						jQuery(".controls .save").click(function(){
							valid_flag=true;
							for (var i=0;i<itemCount;i++){
								if (improvements[i]==20){
									valid_flag=false;
									break;
								}
							}
							if (!valid_flag){
								//jQuery(".step-content .message").removeClass("green_message").html("Please make a choice about all improvement items!");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[223]; ?>");
								animateScrollTop(".step-content .message",'3000');
								return;
							}

							var temp=parseInt(jQuery(".evaluation-content1 .breathing:eq(0) input:eq(0)").val());
							if (isNaN(temp)){
								temp=0;
								jQuery(".evaluation-content1 .breathing:eq(0) input:eq(0)").val("0");
							}
							index_before=temp;
							temp=parseInt(jQuery(".evaluation-content1 .breathing:eq(0) input:eq(1)").val());
							if (isNaN(temp)){
								temp=0;
								jQuery(".evaluation-content1 .breathing:eq(0) input:eq(1)").val("0");
							}
							index_after=temp;
							temp=parseInt(jQuery(".evaluation-content1 .breathing:eq(1) input:eq(0)").val());
							if (isNaN(temp)){
								temp=0;
								jQuery(".evaluation-content1 .breathing:eq(1) input:eq(0)").val("0");
							}
							habits_week_1=temp;
							temp=parseInt(jQuery(".evaluation-content1 .breathing:eq(1) input:eq(1)").val());
							if (isNaN(temp)){
								temp=0;
								jQuery(".evaluation-content1 .breathing:eq(1) input:eq(1)").val("0");
							}
							habits_week_4=temp;
							awareness_answer=jQuery(".evaluation-content3 textarea").val();
							reach_goal_answer=jQuery(".evaluation-content4 textarea").val();

							jQuery.ajax({
								type : "POST",
								async : true,
								url : "<?php bloginfo('stylesheet_directory')?>/breathing-step-save.php",
								data : {
									user_id: <?php echo $user_id;?>,
									step_num:7,
									index_before: index_before,
									index_after: index_after,
									habits_week_1: habits_week_1,
									habits_week_4: habits_week_4,
									improvements: improvements,
									awareness_answer: awareness_answer,
									reach_goal_answer: reach_goal_answer
								},
								cache : false,
								global : false,
								dataType : "json",
								error : function(i, g, h) {
									//jQuery(".step-content .message").removeClass("green_message").html("Saving failed!");
									jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
									jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[74]; ?>");
									animateScrollTop(".step-content .message",'3000');
								},
								success : function(g) {
									if (g.status=="ok"){
										//console.log(g.query);
										origin_index_before=index_before;
										origin_index_after=index_after;
										origin_habits_week_1=habits_week_1;
										origin_habits_week_4=habits_week_4;
										origin_improvements=improvements.slice();
										origin_awareness_answer=awareness_answer;
										origin_reach_goal_answer=reach_goal_answer;

										//jQuery(".step-content .message").addClass("green_message").html("You passed all steps! Please review all steps and finish this course.");
										jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
										jQuery(".step-content .message").addClass("green_message").html("<?php echo $text[224]; ?>");
										jQuery(".controls .save").hide();
										jQuery(".controls .update").show();
										animateScrollTop(".step-content .message",'3000');

									}else{
										jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
										jQuery(".step-content .message").removeClass("green_message").html(g.status);
										animateScrollTop(".step-content .message",'3000');
									}
								}
							});
						});

						jQuery(".controls .update").click(function(){
							valid_flag=true;
							for (var i=0;i<itemCount;i++){
								if (improvements[i]==20){
									valid_flag=false;
									break;
								}
							}
							if (!valid_flag){
								//jQuery(".step-content .message").removeClass("green_message").html("Please make a choice about all improvement items!");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[223]; ?>");
								animateScrollTop(".step-content .message",'3000');
								return;
							}

							var temp=parseInt(jQuery(".evaluation-content1 .breathing:eq(0) input:eq(0)").val());
							if (isNaN(temp)){
								temp=0;
								jQuery(".evaluation-content1 .breathing:eq(0) input:eq(0)").val("0");
							}
							index_before=temp;
							temp=parseInt(jQuery(".evaluation-content1 .breathing:eq(0) input:eq(1)").val());
							if (isNaN(temp)){
								temp=0;
								jQuery(".evaluation-content1 .breathing:eq(0) input:eq(1)").val("0");
							}
							index_after=temp;
							temp=parseInt(jQuery(".evaluation-content1 .breathing:eq(1) input:eq(0)").val());
							if (isNaN(temp)){
								temp=0;
								jQuery(".evaluation-content1 .breathing:eq(1) input:eq(0)").val("0");
							}
							habits_week_1=temp;
							temp=parseInt(jQuery(".evaluation-content1 .breathing:eq(1) input:eq(1)").val());
							if (isNaN(temp)){
								temp=0;
								jQuery(".evaluation-content1 .breathing:eq(1) input:eq(1)").val("0");
							}
							habits_week_4=temp;
							awareness_answer=jQuery(".evaluation-content3 textarea").val();
							reach_goal_answer=jQuery(".evaluation-content4 textarea").val();

							//if (!(origin_index_before==index_before && origin_index_after==index_after && origin_habits_week_1==habits_week_1 && origin_habits_week_4==habits_week_4 && origin_awareness_answer==awareness_answer && origin_reach_goal_answer==reach_goal_answer && origin_improvements.toString()==improvements.toString() )){
								jQuery.ajax({
									type : "POST",
									async : true,
									url : "<?=get_stylesheet_directory_uri()?>/breathing-step-update.php",
									data : {
										user_id: <?php echo $user_id;?>,
										step_num:7,
										index_before: index_before,
										index_after: index_after,
										habits_week_1: habits_week_1,
										habits_week_4: habits_week_4,
										improvements: improvements,
										awareness_answer: awareness_answer,
										reach_goal_answer: reach_goal_answer
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
											//console.log(g.query);
											origin_index_before=index_before;
											origin_index_after=index_after;
											origin_habits_week_1=habits_week_1;
											origin_habits_week_4=habits_week_4;
											origin_improvements=improvements.slice();
											origin_awareness_answer=awareness_answer;
											origin_reach_goal_answer=reach_goal_answer;

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
							/*
							}else{
								jQuery(".step-content .message").html("There are no any changes for updating !");
							}*/
						});

						jQuery(".controls .reset").click(function(){
							index_before=0;
							index_after=0;
							habits_week_1=0;
							habits_week_4=0;
							awareness_answer="";
							reach_goal_answer="";
							for (var i=0;i<itemCount;i++){
								improvements[i]=20;
							}
							jQuery(".evaluation-content1 input").val("");
							jQuery(".evaluation-content2 select").val("20");
							jQuery(".evaluation-content3 textarea").val("");
							jQuery(".evaluation-content4 textarea").val("");
						});
						jQuery(".controls .finish").click(function(){
							var f=confirm("<?php echo $text[225];//Do you want to finish current course really? ?>");
							if (f==true){
								jQuery.ajax({
									type : "POST",
									async : true,
									url : "<?=get_stylesheet_directory_uri()?>/breathing-step-save.php",
									data : {
										user_id: <?php echo $user_id;?>,
										step_num:10
									},
									cache : false,
									global : false,
									dataType : "json",
									error : function(i, g, h) {
										//jQuery(".step-content .message").removeClass("green_message").html("Finishing failed!");
										jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
										jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[226]; ?>");
										animateScrollTop(".step-content .message",'3000');
									},
									success : function(g) {
										if (g.status=="ok"){
											//jQuery(".step-content .message").addClass("green_message").html("Finishing succeed!");
											jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
											jQuery(".step-content .message").addClass("green_message").html("<?php echo $text[227]; ?>");

											animateScrollTop(".step-content .message",'3000');
										}else{
											jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
											jQuery(".step-content .message").removeClass("green_message").html(g.status);
											animateScrollTop(".step-content .message",'3000');
										}
									}
								});
							}
						});


						jQuery(".controls .prev-step").click(function(){
							window.location.replace("<?php echo get_page_link($prev_page->ID); ?>");
						});
						jQuery(".controls .first-step").click(function(){
							window.location.replace("<?php echo get_page_link($first_page->ID); ?>");
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

		<?php //get_sidebar(); ?>

	</div>

</div><!-- /#content -->

<?php get_footer(); ?>