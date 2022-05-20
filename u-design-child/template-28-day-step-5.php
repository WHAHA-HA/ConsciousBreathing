<?php
/**
 * Template Name: 28-day-template-step-5
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
			<!--This page is a fifth step one for 28-day C.B.R.T Program.-->

			<?php
			$step_num = 5;

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
					<div style="text-align:center;"><h2><?php echo add_login_link($text[52],get_permalink(woocommerce_get_page_id('myaccount')),$lang); ?></h2></div>
			<?php
				}else{//when user was logged
			?>
					<div class='stepWrapper' stepNum="4">
						<img src='<?=CHILD_DIR."/images/step5_header.jpg" ?>'>
								<div class="description description-main">
									<!--During the 28-Day Breathing Re-training, <b>once each week (day 7, 14, 21 and 28) you should write
									down the situations and emotions</b> that you realize trigger stressed breathing, i.e., fast breathing,
									irregular breathing, periodic breathing, shallow breathing, mouth breathing or noisy breathing -
									coughing, clearing of throat, blocked nose, sniffing, etc.-->
									<?php echo $text[178]; ?>
						</div>
						<div class="step-content">
							<?php
								$message="";
								$habits1_flag=false;
								$habits2_flag=false;
								$habits_flag=false;
								$habits1=array();
								$habits2=array();
								$answers1=array();
								$answers2=array();
								$last_week_num=0;
								$total_score=array(0,0,0,0);
								$pass_flag=false;
								$course_id=0;
								$course_current_step="0";
								//$option_label=array("Very often","Often","Sometimes","Rarely","Never");
								$option_label=array($text[64],$text[63],$text[62],$text[61],$text[60]);
								$step4_last_used_day=0;
								$step4_ok=1;

								$query="SELECT b.`{$lang}_text` AS `habits1` FROM `tw_step_5_habits1` a, `tw_text` b WHERE a.`text_id`= b.`text_id`"; // or "en_text"
								$result0=$wpdb->get_results($wpdb->prepare($query));
								$query="SELECT b.`{$lang}_text` AS `habits2` FROM `tw_step_5_habits2` a, `tw_text` b WHERE a.`text_id`= b.`text_id`"; // or "en_text"
								$result00=$wpdb->get_results($wpdb->prepare($query));

								if ($result0){
									$habits1_flag=true;
									$habits_flag=true;
									foreach ($result0 as $row){
										$temp=(String) $row->habits1;
										array_push($habits1,$temp);
									}
								}
								if ($result00){
									$habits2_flag=true;
									$habits_flag=true;
									foreach ($result00 as $row){
										$temp=(String) $row->habits2;
										array_push($habits2,$temp);
									}
								}

								$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
								$result1=$wpdb->get_row($query);
								//print_r($result1);
								if ($result1){
									$course_id=$result1->course_id;
									$course_current_step=intval($result1->course_current_step);

									$query="SELECT * FROM `tw_step_5` WHERE `course_id`=".$course_id." ORDER BY `week_num` ASC";
									$result2=$wpdb->get_results($query);
									if ($result2){
										$pass_flag=true;

										foreach ($result2 as $row){
											//print_r($row);
											$week_num=intval($row->week_num);
											$answer=array();
											$answers1_str= $row->habits1;

											/* $answers1_str=urldecode($answers1_str);
											$answers=unserialize($answers1_str); */
											$answers = json_decode($answers1_str);
											$answers1[$week_num-1]=$answers;
											$answers2_str= $row->habits2;
											/* $answers2_str=urldecode($answers2_str);
											$answers=unserialize($answers2_str); */
											$answers = json_decode($answers2_str);
											$answers2[$week_num-1]=$answers;
											$total_score[$week_num-1]=intval($row->total_score);
											$last_week_num=$week_num;
										}
										//$message="You passed by week ".$last_week_num." of step-5!";
										switch ($last_week_num) {
    										case 1:
												$message=$text[168];
												break;
											case 2:
												$message=$text[169];
												break;
											case 3:
												$message=$text[170];
												break;
											case 4:
												$message=$text[171];
												break;
										}

									}else{
										//$message="You should pass week 1 of step-5 !";
										$message=$text[172];
									}

									$query="SELECT * FROM `tw_step_4` WHERE `course_id`=".$course_id;
									$result3=$wpdb->get_results($wpdb->prepare($query));
									if ($result3){
										foreach($result3 as $row){
											$temp= $row->use_flag;
											if (intval($temp)>0){
												$step4_last_used_day=intval($row->day_num);
											}
										}
									}

									if ($step4_last_used_day<($last_week_num+1)*7){
										$step4_ok=0;
										if ($last_week_num<4){
											//$message.=" "."You should fill in DAYs of week ".($last_week_num+1)." in step-4.";
											switch ($last_week_num) {
	    										case 0:
													$message.=" ".$text[173];
													break;
												case 1:
													$message.=" ".$text[174];
													break;
												case 2:
													$message.=" ".$text[175];
													break;
												case 3:
													$message.=" ".$text[176];
													break;
											}
										}else{
											//$message="You passed all weeks of step-5 ! You should pass step-6.";
											$message=$text[177];
										}
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
							<div class="description description-main">
									<b><?php echo $text[130];//TIPS ?>:</b> <!--In the beginning it may be advantageous to set an alarm to go off a few times per day, as a reminder to pay attention to your breathing.-->
																			<?php echo $text[179]; ?>
									<br>
									<!--
									<b>Select a value</b> that you feel best represents how stressed/poor your respiration has
									been during the week.
									-->
									<?php echo $text[180]; ?>
								</div>
							<!--<div class="mark-allocation-description" >
								<span class="mark-desc"><?php echo $text[60];//Never ?></span>:<span class="mark-value">4</span>
								<span class="mark-desc"><?php echo $text[61];//Rarely ?></span>:<span class="mark-value">3</span>
								<span class="mark-desc"><?php echo $text[62];//Sometimes ?></span>:<span class="mark-value">2</span>
								<span class="mark-desc"><?php echo $text[63];//Often ?></span>:<span class="mark-value">1</span>
								<span class="mark-desc"><?php echo $text[64];//Very often ?></span>:<span class="mark-value">0</span>
							</div>-->
							<div class="questions">
								<div class="week-select">
									<b><?php echo $text[181];//My breathing is poor when I ?>:</b>
									<div><input type="radio" name="week-num" id="week-4" value="4" <?php if ($last_week_num==3 && $step4_ok==1) echo "checked" ?>><label for="week-4"><?php echo $text[182];//Week ?> 4</label></div>
									<div><input type="radio" name="week-num" id="week-3" value="3" <?php if (($last_week_num==2 && $step4_ok==1) || ($last_week_num==3 && $step4_ok==0)) echo "checked" ?>><label for="week-3"><?php echo $text[182];//Week ?> 3</label></div>
									<div><input type="radio" name="week-num" id="week-2" value="2" <?php if (($last_week_num==1 && $step4_ok==1) || ($last_week_num==2 && $step4_ok==0)) echo "checked" ?>><label for="week-2"><?php echo $text[182];//Week ?> 2</label></div>
									<div><input type="radio" name="week-num" id="week-1" value="1" <?php if ($last_week_num==0 || ($last_week_num==1 && $step4_ok==0) || $last_week_num==4) echo "checked" ?>><label for="week-1"><?php echo $text[182];//Week ?> 1</label></div>
								</div>
								<ul>
								<?php
									if ($habits1_flag){
										for ($i=0;$i<count($habits1);$i++){
											//
											echo "<li class='target_sheet' questionNum=\"".($i+1)."\">";
												//echo "<span>".$habits1[$i]."</span>";
												$question_order = sprintf("%02d",$i+1);
												echo "<div class='target_checkbox'><span>".$question_order."</span></div>";

												echo "<div class='target_expression'>".$habits1[$i]."</div>";

												echo "<select class=\"";
												if ($pass_flag && $last_week_num>3) echo "choice-value"; else echo "choice-label";
												echo " week-4\">";

												echo "<option value=\"0\" class=\"choice-label\">".$text[65]."</option>";// $text[65]="Make choice"
												for ($j=0;$j<5;$j++){
													echo "<option class=\"choice-value\" value=\"".($j+1)."\" ";
														if ($pass_flag && $last_week_num>3 && intval($answers1[3][$i])==$j+1){
															echo "selected";
														}
													echo ">".$option_label[$j]."</option>";
												}

												echo "</select>";

												echo "<select class=\"";
												if ($pass_flag && $last_week_num>2) echo "choice-value"; else echo "choice-label";
												echo " week-3\">";
												echo "<option value=\"0\" class=\"choice-label\">".$text[65]."</option>";// $text[65]="Make choice"
												for ($j=0;$j<5;$j++){
													echo "<option class=\"choice-value\" value=\"".($j+1)."\" ";
													if ($pass_flag && $last_week_num>2 && intval($answers1[2][$i])==$j+1){
														echo "selected";
													}
													echo ">".$option_label[$j]."</option>";
												}

												echo "</select>";

												echo "<select class=\"";
												if ($pass_flag && $last_week_num>1) echo "choice-value"; else echo "choice-label";
												echo " week-2\">";
												echo "<option value=\"0\" class=\"choice-label\">".$text[65]."</option>";// $text[65]="Make choice"
												for ($j=0;$j<5;$j++){
													echo "<option class=\"choice-value\" value=\"".($j+1)."\" ";
														if ($pass_flag && $last_week_num>1 && intval($answers1[1][$i])==$j+1){
															echo "selected";
														}
													echo ">".$option_label[$j]."</option>";
												}

												echo "</select>";

												echo "<select class=\"";
												if ($pass_flag && $last_week_num>0) echo "choice-value"; else echo "choice-label";
												echo " week-1\">";
												echo "<option value=\"0\" class=\"choice-label\">".$text[65]."</option>";// $text[65]="Make choice"
												for ($j=0;$j<5;$j++){
													echo "<option class=\"choice-value\" value=\"".($j+1)."\" ";
														if ($pass_flag && $last_week_num>0 && intval($answers1[0][$i])==$j+1){
															echo "selected";
														}
													echo ">".$option_label[$j]."</option>";
												}

												echo "</select>";

											echo "</li>";
										}

									}else{//when datatbase error
										//$habits1_read_fail_message="There are no habits1 data of fifth step in database !";
										$habits1_read_fail_message=$text[183];
										echo "<li>".$habits1_read_fail_message."</li>";
								?>
									<!--li questionNum="1">
										<span>drive</span>
										<select class="week-4 choice-label"><option value="5" class="choice-label">Make choice</option><option value="4" class="choice-value">Never</option><option value="3" class="choice-value">Rarely</option><option value="2" class="choice-value">Sometimes</option><option value="1" class="choice-value">Often</option><option value="0" class="choice-value">Very often</option></select>
										<select class="week-3 choice-label"><option value="5" class="choice-label">Make choice</option><option value="4" class="choice-value">Never</option><option value="3" class="choice-value">Rarely</option><option value="2" class="choice-value">Sometimes</option><option value="1" class="choice-value">Often</option><option value="0" class="choice-value">Very often</option></select>
										<select class="week-2 choice-value"><option value="5" class="choice-label">Make choice</option><option value="4" class="choice-value">Never</option><option value="3" class="choice-value">Rarely</option><option value="2" class="choice-value">Sometimes</option><option value="1" class="choice-value">Often</option><option value="0" class="choice-value">Very often</option></select>
										<select class="week-1 choice-value"><option value="5" class="choice-label">Make choice</option><option value="4" class="choice-value">Never</option><option value="3" class="choice-value">Rarely</option><option value="2" class="choice-value">Sometimes</option><option value="1" class="choice-value">Often</option><option value="0" class="choice-value">Very often</option></select>
									</li-->
								<?php } ?>
								</ul>
								<div class="poor-get">
									<?php echo $text[184];//My breathing is poor when I get ?>:
								</div>
								<ul>
								<?php
									if ($habits2_flag){
										for ($i=0;$i<count($habits2);$i++){
												$question_order = sprintf("%02d",$i+9);
												echo "<li class='target_sheet' questionNum=\"".($i+1)."\">";
												echo "<div class='target_checkbox'><span>".$question_order."</span></div>";
												echo "<div class='target_expression'>".$habits2[$i]."</div>";


												echo "<select class=\"";
												if ($pass_flag && $last_week_num>3) echo "choice-value"; else echo "choice-label";
												echo " week-4\">";
												echo "<option value=\"0\" class=\"choice-label\">".$text[65]."</option>";// $text[65]="Make choice"
												for ($j=0;$j<5;$j++){
													echo "<option class=\"choice-value\" value=\"".($j+1)."\" ";
														if ($pass_flag && $last_week_num>3 && intval($answers2[3][$i])==$j+1){
															echo "selected";
														}
													echo ">".$option_label[$j]."</option>";
												}
												echo "</select>";

												echo "<select class=\"";
												if ($pass_flag && $last_week_num>2) echo "choice-value"; else echo "choice-label";
												echo " week-3\">";
												echo "<option value=\"0\" class=\"choice-label\">".$text[65]."</option>";// $text[65]="Make choice"
												for ($j=0;$j<5;$j++){
													echo "<option class=\"choice-value\" value=\"".($j+1)."\" ";
														if ($pass_flag && $last_week_num>2 && intval($answers2[2][$i])==$j+1){
															echo "selected";
														}
													echo ">".$option_label[$j]."</option>";
												}
												echo "</select>";

												echo "<select class=\"";
												if ($pass_flag && $last_week_num>1) echo "choice-value"; else echo "choice-label";
												echo " week-2\">";
												echo "<option value=\"0\" class=\"choice-label\">".$text[65]."</option>";// $text[65]="Make choice"
												for ($j=0;$j<5;$j++){
													echo "<option class=\"choice-value\" value=\"".($j+1)."\" ";
														if ($pass_flag && $last_week_num>1 && intval($answers2[1][$i])==$j+1){
															echo "selected";
														}
													echo ">".$option_label[$j]."</option>";
												}
												echo "</select>";

												echo "<select class=\"";
												if ($pass_flag && $last_week_num>0) echo "choice-value"; else echo "choice-label";
												echo " week-1\">";
												echo "<option value=\"0\" class=\"choice-label\">".$text[65]."</option>";// $text[65]="Make choice"
												for ($j=0;$j<5;$j++){
													echo "<option class=\"choice-value\" value=\"".($j+1)."\" ";
														if ($pass_flag && $last_week_num>0 && intval($answers2[0][$i])==$j+1){
															echo "selected";
														}
													echo ">".$option_label[$j]."</option>";
												}
												echo "</select>";

											echo "</li>";
										}

									}else{//when datatbase error
										//$habits2_read_fail_message="There are no habits2 data of fifth step in database !";
										$habits2_read_fail_message=$text[185];
										echo "<li>".$habits2_read_fail_message."</li>";
								?>
									<!--li questionNum="1">
										<span>angry, irritated</span>
										<select class="week-4 choice-label"><option value="5" class="choice-label">Make choice</option><option value="4" class="choice-value">Never</option><option value="3" class="choice-value">Rarely</option><option value="2" class="choice-value">Sometimes</option><option value="1" class="choice-value">Often</option><option value="0" class="choice-value">Very often</option></select>
										<select class="week-3 choice-label"><option value="5" class="choice-label">Make choice</option><option value="4" class="choice-value">Never</option><option value="3" class="choice-value">Rarely</option><option value="2" class="choice-value">Sometimes</option><option value="1" class="choice-value">Often</option><option value="0" class="choice-value">Very often</option></select>
										<select class="week-2 choice-value"><option value="5" class="choice-label">Make choice</option><option value="4" class="choice-value">Never</option><option value="3" class="choice-value">Rarely</option><option value="2" class="choice-value">Sometimes</option><option value="1" class="choice-value">Often</option><option value="0" class="choice-value">Very often</option></select>
										<select class="week-1 choice-value"><option value="5" class="choice-label">Make choice</option><option value="4" class="choice-value">Never</option><option value="3" class="choice-value">Rarely</option><option value="2" class="choice-value">Sometimes</option><option value="1" class="choice-value">Often</option><option value="0" class="choice-value">Very often</option></select>
									</li-->
								<?php } ?>
								</ul>
							</div>
							<div style="clear:both;"></div>

							<div style="clear:both;"></div>
							<div class="controls">
									<div class="total-mark" <?php if ($pass_flag){echo "style='display:block;'";} ?>>
								<span><?php echo $text[186];//Total Score ?>:</span>
								<span class="total-score-value week4-total-score" total-score="<?php echo $total_score[3];?>"><?php echo $total_score[3];?></span>
								<span class="total-score-value week3-total-score" total-score="<?php echo $total_score[2];?>"><?php echo $total_score[2];?></span>
								<span class="total-score-value week2-total-score" total-score="<?php echo $total_score[1];?>"><?php echo $total_score[1];?></span>
								<span class="total-score-value week1-total-score" total-score="<?php echo $total_score[0];?>"><?php echo $total_score[0];?></span>

							</div>
								<div class="buttons">
									<?php
									if ($course_id!=0){
										//here we need some consideration as to update button

										if ($last_week_num==4){
									?>
										<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
										<span class="update"><?php echo $text[68];//Update ?></span>
										<span class="save" style="display:none;"><?php echo $text[71];//Save ?></span>
										<!--span class="reset"><?php echo $text[69];//Reset ?></span-->
										<span class="next-step" ><?php echo $text[70];//To next step ?></span>
									<?php
										}else{
									?>
										<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
										<span class="update" style="display:none;"><?php echo $text[68];//Update ?></span>
										<span class="save"><?php echo $text[71];//Save ?></span>
										<!--span class="reset"><?php echo $text[69];//Reset ?></span-->
										<span class="next-step" style="display:none;"><?php echo $text[70];//To next step ?></span>
									<?php
										}
									}else{
									?>
									<span class="first-step"><?php echo $text[134];//To first step ?></span>
									<?php } ?>
								</div>
							</div>
							<div style="clear:both;"></div>
							<div class="description description-more" style="margin-top:20px;<?php if ($pass_flag){echo "display:block;";} ?>">
								<!--The maximum score is 48. A high score indicates that you have good breathing habits in everyday life.
								A score below 15 indicates that improving your breathing in different situations and when experiencing
								different emotions can benefit you greatly.-->
								<?php echo $text[187]; ?>
							</div>
						</div>
					</div>
					<script>
					jQuery(document).ready(function(){
						<?php if(empty($message)):?>
						jQuery("div.step-content .success:eq(0)").hide();
						<?php endif; ?>
						//read more
						jQuery(".read-more").click(function(){
							jQuery(".read-more-view").show();
							jQuery(".less-view").hide();
						});
						jQuery(".less").click(function(){
							jQuery(".read-more-view").hide();
							jQuery(".less-view").show();
						});

						//current course step
						var course_current_step=<?php echo $course_current_step; ?>;
						//weeknum  current selected week
						var week_num=parseInt(jQuery(".week-select input[name='week-num']:checked").val());
						//last week num
						var last_week_num=<?php echo $last_week_num;?>;

						var step4_last_used_day=<?php echo $step4_last_used_day; ?>;

						if (last_week_num<4){
							jQuery(".next-step").attr("flag","0");
						}else{
							jQuery(".next-step").attr("flag","1");
						}
						//last_week_num=2;//test
						for (var i=last_week_num+2;i<=4;i++){
							jQuery(".week-select input[name='week-num'][value='"+i+"']").attr("disabled","disabled");
							jQuery(".questions ul li select.week-"+i).attr("disabled","disabled");
						}

						for (var i=1;i<=4;i++){
							jQuery(".questions ul li select.week-"+i).attr("disabled","disabled");
						}
						jQuery(".questions ul li select.week-"+week_num).removeAttr("disabled");

						if (step4_last_used_day<(last_week_num+1)*7){
							current_week=last_week_num+1;
							jQuery(".week-select input[name='week-num'][value='"+current_week+"']").attr("disabled","disabled");
							jQuery(".questions ul li select.week-"+current_week).attr("disabled","disabled");
							if (last_week_num<4 && course_current_step>0){
								//alert("You should fill in DAYs of week "+current_week+" in step-4.");
								switch (current_week) {
									case 1:
										alert("<?php echo $text[173]; ?>");
										break;
									case 2:
										alert("<?php echo $text[174]; ?>");
										break;
									case 3:
										alert("<?php echo $text[175]; ?>");
										break;
									case 4:
										alert("<?php echo $text[176]; ?>");
										break;
								}
							}

							if (current_week==1){
								jQuery(".controls .save").hide();
								jQuery(".controls .reset").hide();
							}
							//jQuery(".step-content .message").addClass("green_message").html("You should fill in DAYs of week "+current_week+" in step-4.");
						}
						/*
						if (week_num<=last_week_num){
							jQuery(".buttons .update").show();
							jQuery(".buttons .save").hide();
						}else{
							jQuery(".buttons .update").hide();
							jQuery(".buttons .save").show();
						}
						*/
						var habits1=new Array(4);
						var habits2=new Array(4);
						var total_score=Array(0,0,0,0);
						var temp_habits1=new Array(4);
						var temp_habits2=new Array(4);
						var temp_total_score=Array(0,0,0,0);

						var habits1Count= jQuery(".questions ul:eq(0) li").size();
						var habits2Count= jQuery(".questions ul:eq(1) li").size();

						for (var j=0;j<4;j++){
							habits1[j]=[];
							temp_habits1[j]=[];
							for (var i=0;i<habits1Count;i++){
								habits1[j][i]=parseInt(jQuery(".questions ul:eq(0) li:eq("+i+") select.week-"+(j+1)).val());
								temp_habits1[j][i]=parseInt(jQuery(".questions ul:eq(0) li:eq("+i+") select.week-"+(j+1)).val());
							}

							habits2[j]=[];
							temp_habits2[j]=[];
							for (var i=0;i<habits2Count;i++){
								habits2[j][i]=parseInt(jQuery(".questions ul:eq(1) li:eq("+i+") select.week-"+(j+1)).val());
								temp_habits2[j][i]=parseInt(jQuery(".questions ul:eq(1) li:eq("+i+") select.week-"+(j+1)).val());
							}

							var temp=parseInt(jQuery(".week"+(j+1)+"-total-score").attr("total-score"));
							if (isNaN(temp)){
								temp=0;
							}
							total_score[j]=temp;
							temp_total_score[j]=temp;
						}

						//console.log(habits1);
						//console.log(habits2);
						//console.log(temp_habits1);
						//console.log(temp_habits2);
						//console.log(total_score);
						//console.log(temp_total_score);

						jQuery(".week-select input[name='week-num']").change(function(){
							week_num=parseInt(jQuery(this).val());
							//for week<last week save is on,update is off
							if (week_num<=last_week_num){
								jQuery(".buttons .update").show();
								jQuery(".buttons .save").hide();
							}else{ //for last week save is off/ update is on
								jQuery(".buttons .update").hide();
								jQuery(".buttons .save").show();
							}
							for (var i=1;i<=4;i++){
								jQuery(".questions ul li select.week-"+i).attr("disabled","disabled");
							}
							jQuery(".questions ul li select.week-"+week_num).removeAttr("disabled");
						});

						jQuery(".questions ul:eq(0) li.target_sheet select").change(function(){
							var questionNum=jQuery(this).parent().attr("questionnum");
							//alert(questionNum);
						//	var week_num=parseInt(jQuery(".week-select input[name='week-num']:checked").val());
						//	alert(week_num);
							if (temp_habits1[week_num-1][questionNum-1]!=0){
								temp_total_score[week_num-1] = temp_total_score[week_num-1] - temp_habits1[week_num-1][questionNum-1];
							}
							var value=jQuery(this).val();
							temp_habits1[week_num-1][questionNum-1] = parseInt(value);
							if (value!="0"){
								jQuery(this).removeClass().addClass("choice-value");
								temp_total_score[week_num-1] = temp_total_score[week_num-1] + temp_habits1[week_num-1][questionNum-1];

							}else{
								jQuery(this).removeClass().addClass("choice-label");
							}
						//	alert(temp_total_score[week_num-1]);
							//var week_num = 0;
							jQuery(".week"+week_num+"-total-score").attr("total-score",temp_total_score[week_num-1]);
							jQuery(".week"+week_num+"-total-score").html(temp_total_score[week_num-1]);
							//console.log(temp_habits1[week_num-1]);
							//console.log(temp_total_score[week_num-1]);
						});

						jQuery(".questions ul:eq(1) li select").change(function(){

							var questionNum=jQuery(this).parent().attr("questionnum");
							if (temp_habits2[week_num-1][questionNum-1]!=0){
								temp_total_score[week_num-1] = temp_total_score[week_num-1] - temp_habits2[week_num-1][questionNum-1];
							}
							var value=jQuery(this).val();
							temp_habits2[week_num-1][questionNum-1] = parseInt(value);
							if (value!="0"){
								jQuery(this).removeClass().addClass("choice-value");
								temp_total_score[week_num-1] = temp_total_score[week_num-1] + temp_habits2[week_num-1][questionNum-1];

							}else{
								jQuery(this).removeClass().addClass("choice-label");
							}
							jQuery(".week"+week_num+"-total-score").attr("total-score",temp_total_score[week_num-1]);
							jQuery(".week"+week_num+"-total-score").html(temp_total_score[week_num-1]);
							//console.log(temp_habits2[week_num-1]);
							//console.log(temp_total_score[week_num-1]);
						});


						jQuery(".controls .save").click(function(){
							valid_flag=true;
							for (var i=0;i<habits1Count;i++){
								if (temp_habits1[week_num-1][i]==0){
									valid_flag=false;
									break;
								}
							}
							for (var i=0;i<habits2Count;i++){
								if (temp_habits2[week_num-1][i]==0){
									valid_flag=false;
									break;
								}
							}

							if (!valid_flag){
								//jQuery(".step-content .message").removeClass("green_message").html("Please make a choice about all habits!");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[188]; ?>");
								animateScrollTop(".step-content .message",'3000');
								return;
							}

							//save habits
							jQuery.ajax({
								type : "POST",
								async : true,
								url : "<?=get_stylesheet_directory_uri()?>/breathing-step-save.php",
								data : {
									user_id: <?php echo $user_id;?>,
									step_num:5,
									week_num: week_num,
									habits1:temp_habits1[week_num-1],
									habits2:temp_habits2[week_num-1],
									total_score:temp_total_score[week_num-1]
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
										habits1[week_num-1]=temp_habits1[week_num-1].slice();
										habits2[week_num-1]=temp_habits2[week_num-1].slice();
										total_score[week_num-1]=temp_total_score[week_num-1];

										last_week_num++;
										jQuery(".week-select input[name='week-num'][value='"+(last_week_num+1)+"']").removeAttr("disabled");
										/*
										if (last_week_num<4){
											jQuery(".next-step").attr("flag","0");
										}else{
											jQuery(".next-step").attr("flag","1");
										}*/
										if (last_week_num==4){
											jQuery(".next-step").show();
										}
										jQuery(".week"+week_num+"-total-score").attr("total-score",temp_total_score[week_num-1]);
										jQuery(".week"+week_num+"-total-score").html(temp_total_score[week_num-1]);
										jQuery(".total-mark").show();
										jQuery(".description-more").show();
										//message_str="You passed by week "+week_num+" of step-5! ";
										message_str="";
										switch (week_num) {
											case 1:
												message_str="<?php echo $text[168]; ?>";
												break;
											case 2:
												message_str="<?php echo $text[169]; ?>";
												break;
											case 3:
												message_str="<?php echo $text[170]; ?>";
												break;
											case 4:
												message_str="<?php echo $text[171]; ?>";
												break;
										}
										jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
										jQuery(".step-content .message").addClass("green_message").html(message_str);
										animateScrollTop(".step-content .message",'3000');
										jQuery(".controls .save").hide();
										jQuery(".controls .update").show();
										window.location.reload( true );
									}else{
										jQuery(".step-content .message").removeClass("green_message").html(g.status);
										animateScrollTop(".step-content .message",'3000');
									}
								}
							});
						});

						//update habits...
						jQuery(".controls .update").click(function(){
							valid_flag=true;
							for (var i=0;i<habits1Count;i++){
								if (temp_habits1[week_num-1][i]==0){
									valid_flag=false;
									break;
								}
							}
							for (var i=0;i<habits2Count;i++){
								if (temp_habits2[week_num-1][i]==0){
									valid_flag=false;
									break;
								}
							}

							if (!valid_flag){
								//jQuery(".step-content .message").removeClass("green_message").html("Please make a choice about all habits!");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[188]; ?>");
								animateScrollTop(".step-content .message",'3000');
								return;
							}

							if (!(total_score[week_num-1]==temp_total_score[week_num-1] && habits1[week_num-1].toString()==temp_habits1[week_num-1].toString() && habits2[week_num-1].toString()==temp_habits2[week_num-1].toString() )){
								jQuery.ajax({
									type : "POST",
									async : true,
									url : "<?=get_stylesheet_directory_uri()?>/breathing-step-update.php",
									data : {
										user_id: <?php echo $user_id;?>,
										step_num:5,
										week_num: week_num,
										habits1:temp_habits1[week_num-1],
										habits2:temp_habits2[week_num-1],
										total_score:temp_total_score[week_num-1]
									},
									cache : false,
									global : false,
									dataType : "json",
									error : function(i, g, h) {
										//jQuery(".step-content .message").removeClass("green_message").html("Updating failed!");
										jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
										jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[76]; ?>");
									},
									success : function(g) {
										if (g.status=="ok"){
											//console.log(g.query);
											habits1[week_num-1]=temp_habits1[week_num-1].slice();
											habits2[week_num-1]=temp_habits2[week_num-1].slice();
											total_score[week_num-1]=temp_total_score[week_num-1];

											jQuery(".week"+week_num+"-total-score").attr("total-score",temp_total_score[week_num-1]);
											jQuery(".week"+week_num+"-total-score").html(temp_total_score[week_num-1]);

											message_str="";
											switch (week_num) {
												case 1:
													message_str="<?php echo $text[189]; ?>";
													break;
												case 2:
													message_str="<?php echo $text[190]; ?>";
													break;
												case 3:
													message_str="<?php echo $text[191]; ?>";
													break;
												case 4:
													message_str="<?php echo $text[192]; ?>";
													break;
											}
											jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
											jQuery(".step-content .message").addClass("green_message").html(message_str);
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
						});

						jQuery(".controls .reset").click(function(){
							temp_total_score[week_num-1]=0;
							for (var i=0;i<habits1Count;i++){
								temp_habits1[week_num-1][i]=0;
							}
							for (var i=0;i<habits2Count;i++){
								temp_habits2[week_num-1][i]=0;
							}
							jQuery(".questions ul li select.week-"+week_num).val("0");
							jQuery(".questions ul li select.week-"+week_num).removeClass().addClass("choice-label");
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

		<?php  //get_sidebar(); ?>

	</div>

</div><!-- /#content -->

<?php get_footer(); ?>