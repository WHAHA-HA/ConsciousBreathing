<?php
/**
 * Template Name: 28-day-template-step-1
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
			<!--This page is a first step one for 28-day C.B.R.T Program.-->

			<?php
			$lang="se"; // or "en"
			if($lang =="en")
				$page_path_str = "improve-your-breathing";
			else
				$page_path_str = "andningstraning";


			$step_num = 1;
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








			//get_page_by_path("/improve-your-breathing", $output);
			//print_r($output);

			//retrive all child pages of improve_your_breathing..

			$query="SELECT `text_id`, `".$lang."_text` AS `text` FROM `tw_text` ORDER BY `text_id` ASC";

			$text_result=$wpdb->get_results($query);

			if ($text_result){
				$text=array();
				foreach($text_result as $row){
					$text_id=(int) $row->text_id;
					$text[$text_id]=$row->text;
				}
				//get current user info
				$current_user = wp_get_current_user();
			    $user_id= $current_user->ID ;

				if ($user_id==0){	//when user was unlogged
			?>
					<!--div style="font-size: 18px; line-height: 35px;">You should log in for using this 28-Day C.B.R.T Program.<br>Please log in.</div-->
					<div style="text-align:center;"><h2><?php echo add_login_link($text[52], get_permalink(woocommerce_get_page_id('myaccount')),$lang); ?></h2></div>
					<!-- first ask user login and then redirect to current page -->
			<?php
				}else{//when user was logged
			?>
					<div class='stepWrapper' stepNum="1">
						<img src='<?=CHILD_DIR."/images/step1_header.jpg" ?>'>
								<div class="description description-main">
									<!--The questions below concern your breathing habits and the state of your airways. Blocked airways, over
									breathing, and irregular breathing, are all factors that can cause many seemingly unrelated health problems.
									Hence, there are questions relating to health issues, such as stomach problems, for example. These questions
									will help you assess your own breathing and become aware of how well your airways work.
									Circle the number on the scale of 0–4 that best describes your current health status.
									All questions refer to the <bpast month.-->
									<p><?php echo $text[59]; ?></p>
								</div>

						<div class="step-content">
							<?php
								$message="";
								$questions_flag=false;
								$questions=array();
								$answers=array();
								$total_score=0;
								$pass_flag=false;
								$course_id=0;

								$query="SELECT b.`".$lang."_text` AS `question` FROM `tw_step_1_6_question` a, `tw_text` b WHERE a.`text_id`= b.`text_id`";
								$result0=$wpdb->get_results($wpdb->prepare($query));
								if ($result0){
									$questions_flag=true;
									foreach ($result0 as $row){
										$temp=(String) $row->question;
										array_push($questions,$temp);
										//$total_score+=4;
									}
								}//else{$total_score=72;}

								$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0 AND `course_current_step`>=1";
								$result1=$wpdb->get_row($query);
								if ($result1){
									$course_id=$result1->course_id;
									$course_current_step=$result1->course_current_step;
									$goto_step=$course_current_step+1;
									if ($course_current_step==7){
										//$message="You passed all steps(step1~step7) already! You can finish this course in step-7 page.";
										$message=$text[56];
									}else{
										//$message="You passed first step already!";
										$message=$text[57];
									}

									$query="SELECT * FROM `tw_step_1` WHERE `course_id`=".$course_id;
									$result2=$wpdb->get_row($query);
									if ($result2){
										$pass_flag=true;
										$answers_str= $result2->answers;

										//$answers_str=urldecode($answers_str);
										//echo $answers_str;
										//$answers=unserialize($answers_str);
										$answers = json_decode($answers_str);
										//print_r($answers);
										$total_score=intval($result2->total_score);

										//var_dump($total_score);

									}else{
										//$message="You passed first step already! But not found the entry data of first step !";
										$message=$text[58];
									}
								}

								$info_message= "<div class='message  green_message' id='message_content'>{$message}</div>";


								echo do_shortcode("[message type='success']".$info_message."[/message]");

							?>
							<!-- <div class="mark-allocation-description">
								<span class="mark-desc"><?php echo $text[64];//Very often ?></span>:<span class="mark-value">1</span>
								<span class="mark-desc"><?php echo $text[63];//Often ?></span>:<span class="mark-value">2</span>
								<span class="mark-desc"><?php echo $text[62];//Sometimes ?></span>:<span class="mark-value">3</span>
								<span class="mark-desc"><?php echo $text[61];//Rarely ?></span>:<span class="mark-value">4</span>
								<span class="mark-desc"><?php echo $text[60];//Never ?></span>:<span class="mark-value">5</span>
								<div class="total-mark">
									<span>Total Score:</span>
									<span class="total-score-value"><?php echo $total_score;?></span>
								</div>
							</div> -->

							<div class="questions">
								<?php
									if ($questions_flag){
									echo "<ul>";
										//$option_label=array("Never","Rarely","Sometimes","Often","Very often");
										$option_label=array($text[64],$text[63],$text[62],$text[61],$text[60]);

										for ($i=0;$i<count($questions);$i++){
											echo "<li class='question_sheet' questionNum=\"".($i+1)."\">";
											$question_order = sprintf("%02d",$i+1);
											echo "<span class='question_order'>".$question_order."</span>";
											echo "<span class='question'>".$questions[$i]."</span>";
											echo "<select class=\"";
											if ($pass_flag) echo "choice-value"; else echo "choice-label";
											echo "\">";
											echo "<option value=\"0\" class=\"choice-label\">".$text[65]."</option>";// $text[65]="Make choice"
											for ($j=0;$j<5;$j++){
												echo "<option class=\"choice-value\" value=\"".($j+1)."\" ";
													if ($pass_flag && intval($answers[$i])==$j+1){
														echo "selected";
													}
												echo ">".$option_label[$j]."</option>";
											}
											echo "</select>";

											echo "</li>";
										}
									echo "</ul>";
									}else{//when datatbase error
										//$question_read_fail_message="There are no questions of first step in database !";
										$question_read_fail_message=$text[66];
										echo $question_read_fail_message;
									}
								?>
							</div>

							<div class="controls">
								<div class="total-mark" <?php if ($pass_flag){echo "style='display:block;'";} ?>>
									<span><?php echo $text[67];//Your Score: ?></span>
									<span class="total-score-value" total_score="<?php echo $total_score;?>"><?php echo $total_score;?></span>
								</div>
								<div class="buttons">
									<?php if ($pass_flag){ ?>
									<span class="update"><?php echo $text[68];//Update ?></span>
									<!-- <span class="reset"><?php echo $text[69];//Reset ?></span> -->
									<span class="next-step" ><?php echo $text[70];//To next step ?></span>
									<?php }else{ ?>
									<span class="update" style="display:none;"><?php echo $text[68];//Update ?></span>
									<span class="save"><?php echo $text[71];//Save ?></span>
									<!-- <span class="reset"><?php echo $text[69];//Reset ?></span> -->
									<span class="next-step" style="display: none;"><?php echo $text[70];//To next step ?></span>
									<?php } ?>
								</div>
							</div>
							<div style="clear:both;"></div>
							<div class="description description-more" style="margin-top:20px;<?php if ($pass_flag){echo "display:block;";} ?>">
								<!--The maximum score on the breathing index is 72. A high score indicates your body is in balance, and you
								have ample internal resources, capable of handling difficult challenges. A score below 25 indicates that your
								breathing could improve greatly. A low score indicates your body is out of balance, and you have low inner
								resources. There is nothing wrong in having a low score. However it may be advantageous to lower your level
								of ambition and try to reduce severity of the challenges you face. It is encouraging to know that improving
								your breathing habits can h elp boost your score and assist you in achieving better health.
								-->
								<?php echo $text[72]; ?>
							</div>
						</div>
					</div>

					<script>
						<?php if(empty($message)):?>
						jQuery("div.step-content .success:eq(0)").hide();
						<?php endif; ?>
						jQuery(".read-more").click(function(){
							jQuery(".read-more-view").show();
							jQuery(".less-view").hide();
						});
						jQuery(".less").click(function(){
							jQuery(".read-more-view").hide();
							jQuery(".less-view").show();
						});
						var answer=Array();
						var total_score=0;
						var origin_answer=Array();
						var origin_total_score=0;
						var questionCount= jQuery(".questions ul li").size();
						for (var i=0;i<questionCount;i++){
							var value=jQuery(".questions ul li:eq("+i+") select").val();
							answer[i]=parseInt(value);
						}
						total_score=parseInt(jQuery(".total-score-value").html());
						origin_answer=answer.slice();
						origin_total_score=total_score;

						jQuery(".questions ul li select").change(function(){
							var questionNum=jQuery(this).parent().attr("questionnum");

							if (answer[questionNum-1]!=0){
								total_score=total_score-answer[questionNum-1];
							}

							var value=jQuery(this).val();
							answer[questionNum-1]=parseInt(value);

							if (value!="0"){
								jQuery(this).removeClass().addClass("choice-value");
								total_score=total_score+answer[questionNum-1];
								//jQuery(".total-score-value").html(total_score);
							}else{
								jQuery(this).removeClass().addClass("choice-label");
							}
							jQuery(".total-score-value").html(total_score);
						});

						jQuery(".controls .save").click(function(){
							valid_flag=true;
							for (var i=0;i<questionCount;i++){
								if (answer[i]==0){
									valid_flag=false;
									break;
								}
							}
							if (!valid_flag){
								//jQuery(".step-content .message").removeClass("green_message").html("Please make a choice about all questions!");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[73]; ?>");
								animateScrollTop(".step-content .message",'3000');
								return;
							}
							//total_score=parseInt(jQuery(".total-score-value").html());
							jQuery.ajax({
								type : "POST",
								async : true,
								url : "<?=get_stylesheet_directory_uri()?>/breathing-step-save.php",
								data : {
									user_id: <?php echo $user_id;?>,
									step_num:1,
									answer: answer,
									total_score:total_score
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

										origin_answer=answer.slice();
										origin_total_score=total_score;
										jQuery(".total-score-value").html(total_score);
										jQuery(".total-mark").show();
										jQuery(".description-more").show();
										//jQuery(".step-content .message").addClass("green_message").html("You passed first step! You should pass step-2.");
										jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
										jQuery(".step-content .message").addClass("green_message").html("<?php echo $text[75]; ?>");
										animateScrollTop(".step-content .message",'3000');
										jQuery(".controls .save").hide();
										jQuery(".controls .update").show();
										jQuery(".controls .next-step").show();

										//window.location.replace("http://consciousbreathing.com/28-dagars-step-2/");
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
							for (var i=0;i<questionCount;i++){
								if (answer[i]==0){
									valid_flag=false;
									break;
								}
							}

							if (!valid_flag){
								//jQuery(".step-content .message").removeClass("green_message").html("Please make a choice about all questions!");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[73]; ?>");
								animateScrollTop(".step-content .message",'3000');
								return;
							}

							//alert(total_score);
							//alert(origin_total_score);

							if (!(origin_total_score==total_score && origin_answer.toString()==answer.toString())){
								jQuery.ajax({
									type : "POST",
									async : true,
									url : "<?=get_stylesheet_directory_uri()?>/breathing-step-update.php",
									data : {
										user_id: <?php echo $user_id;?>,
										step_num:1,
										answer: answer,
										total_score:total_score
									},
									cache : false,
									global : false,
									dataType : "json",
									error : function(i, g, h) {
										jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
										//jQuery(".step-content .message").removeClass("green_message").html("Updating failed!");
										jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[76]; ?>");
									},
									success : function(g) {
										if (g.status=="ok"){
											//jQuery(".step-content .message").addClass("green_message").html("Updating succeed!");
											jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
											jQuery(".step-content .message").addClass("green_message").html("<?php echo $text[77]; ?>");
											origin_answer=answer.slice();
											origin_total_score=total_score;
											jQuery(".total-score-value").html(total_score);
											animateScrollTop(".step-content .message",'3000');
										}else{
											jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
											jQuery(".step-content .message").removeClass("green_message").html(g.status);
											animateScrollTop(".step-content .message",'3000');
										}
									}
								});
							}else{
						//		jQuery(".step-content .message").animate({scrollTop:"300px"});
								//jQuery(".step-content .message").removeClass("green_message").html("There are no any changes for updating !");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[78]; ?>");
								animateScrollTop(".step-content .message",'3000');

							}
						});
						jQuery(".controls .reset").click(function(){
							total_score=0;
							for (var i=0;i<questionCount;i++){
								answer[i]=0;
								jQuery(".questions ul li").eq(i).find("select").val("0");
								jQuery(".questions ul li").eq(i).find("select").removeClass().addClass("choice-label");
							}
							jQuery(".total-score-value").html(total_score);
						});

						jQuery(".controls .next-step").click(function(){
								window.location.replace("<?php echo get_page_link($next_page->ID); ?>");
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