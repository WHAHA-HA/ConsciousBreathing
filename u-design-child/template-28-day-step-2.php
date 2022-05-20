<?php
/**
 * Template Name: 28-day-template-step-2
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
			<!--This page is a second step one for 28-day C.B.R.T Program.-->

			<?php
			$step_num = 2;

			$lang="se"; // or "en"
			if($lang =="en")
				$page_path_str = "improve-your-breathing";
			else
				$page_path_str = "andningstraning";


			$parent = get_page_by_path($page_path_str);
			$cbr_pages = get_pages(array('child_of' => $parent->ID,'sort_column'=> 'page_title','sort_order'=>'asc'));
		//	print_r($cbr_pages);


			$next_step = $step_num+1;
			if($next_step>7)
				$next_step = 7;
			$prev_step = $step_num-1;
			if($prev_step<1)
				$prev_step = 1;

			//in-array index should be step_num-1
			$next_page = $cbr_pages[$next_step-1];
			$prev_page = $cbr_pages[$prev_step-1];
			$step_4 = $cbr_pages[3];


			$lang="se"; // or "en"
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
					<div class='stepWrapper' stepNum="2">
						<img src='<?=CHILD_DIR."/images/step2_header.jpg" ?>'>
							<div class="description description-main">
								<!--<b>Write down your three main goals related to your wellbeing.</b> To find the purpose in what you do is many
								times crucial to success. Setting goals	in connection with breathing re-training creates more motivation
								and meaningfulness. When you set your goals, make sure you’re not over-challenging yourself so that you
								will be able to enjoy the journey. The purpose of the breathing re-training is to reduce stress in your life, not
								add more.<br> <b>Please note! To set a goal, you don’t need to know how to achieve the goal.</b>-->
								<?php echo $text[107]; ?>
							</div>
						<div class="step-content">
							<?php
								$message="";
								$goals_flag=false;
								$goals_ex=array();
								$goal=array("","","");
								$pass_flag=false;
								$course_id=0;

								$query="SELECT b.`{$lang}_text` AS `goal_ex` FROM `tw_step_2_goal` a, `tw_text` b WHERE a.`text_id`= b.`text_id`"; // or "en_text"
								$result0=$wpdb->get_results($wpdb->prepare($query));
								if ($result0){
									$goals_flag=true;
									foreach ($result0 as $row){
										$temp=(String) $row->goal_ex;
										array_push($goals_ex,$temp);
									}
								}else{}

								$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
								$result1=$wpdb->get_row($query);
								if ($result1){
									$course_id=$result1->course_id;
									$course_current_step=$result1->course_current_step;

									if ($course_current_step>=2){
										$query="SELECT * FROM `tw_step_2` WHERE `course_id`=".$course_id;
										$result2=$wpdb->get_row($query);
										if ($result2){
											$pass_flag=true;
											//$message="You passed second step already!";
											$message=$text[105];
											$goal[0]=$result2->goal1;
											$goal[1]=$result2->goal2;
											$goal[2]=$result2->goal3;
										}

										if ($course_current_step==7){
											//$message="You passed all steps(step1~step7) already! You can finish this course in step-7 page. ";
											$message=$text[56];
										}
									}
								}else{
									//$message="You should pass first step ! There is no course in progress!";
									$message=$text[106];
								}
							$info_message= "<div class='message  green_message' id='message_content'>{$message}</div>";
							echo do_shortcode("[message type='success']".$info_message."[/message]");
							?>


							<div class="description goal-ex">
							<?php
							if ($goals_flag){
							?>
								<div><!--<b>Examples of goals</b> may be:--><h1><?php echo $text[108]; ?></h1></div>
								<ul>
								<?php
									$total = count($goals_ex);
									$first_count = $total/2;

									for ($i=0;$i<$first_count;$i++){
										$question_order = sprintf("%02d",$i+1);
										echo "<li class='target_sheet' exNum=\"".($i+1)."\">";
										echo "<div class='target_checkbox'><span>".$question_order."</span></div>";
										echo "<div class='target_expression'>".$goals_ex[$i]."</div>";
										echo "</li>";
									}
								?>
								</ul>
								<ul>
								<?php
									for ($i=$first_count;$i<$total;$i++){
										$question_order = sprintf("%02d",$i+1);
										echo "<li class='target_sheet' exNum=\"".($i+1)."\">";
										echo "<div class='target_checkbox'><span>".$question_order."</span></div>";
										echo "<div class='target_expression'>".$goals_ex[$i]."</div>";
										echo "</li>";
									}
								?>
								</ul>
							<?php } ?>
							</div>
							<img src='<?=CHILD_DIR."/images/step2-3_header.jpg" ?>'>
							<div class="goals-content">
								<ul>
								<?php
									for ($i=0;$i<3;$i++){
										echo "<li  goalNum=\"".($i+1)."\">";
										echo "<div class=\"goal\"><input name=\"goal-".($i+1)."\" value=\"".$goal[$i]."\"></div>";
										echo "</li>";
									}
								?>
								</ul>
							</div>

							<div class="controls">
								<div class="buttons">
									<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
									<?php if ($pass_flag){ ?>
									<span class="update"><?php echo $text[68];//Update ?></span>
									<!--span class="reset"><?php echo $text[69];//Reset ?></span-->
									<span class="next-step" ><?php echo $text[70];//To next step ?></span>
									<?php }else if ($course_id!=0){ ?>
									<span class="update" style="display:none;"><?php echo $text[68];//Update ?></span>
									<span class="save"><?php echo $text[71];//Save ?></span>
									<!--span class="reset"><?php echo $text[69];//Reset ?></span-->
									<span class="next-step" style="display: none;"><?php echo $text[70];//To next step ?></span>
									<span class="to-step-4"><?php echo $text[111];//Skip and go to step 4 ?></span>
									<?php } ?>

								</div>
							</div>
						</div>
					</div>
					<script>
						var goal=Array();
						var origin_goal=Array();
						var goalCount= jQuery(".goals-content ul li").size(); //  =3
						for (var i=0;i<goalCount;i++){
							goal[i]=jQuery(".goals-content ul li[goalNum='"+(i+1)+"'] input").val();
						}
						origin_goal=goal.slice();
						<?php if(empty($message)):?>
							jQuery("div.step-content .success:eq(0)").hide();
						<?php endif; ?>

						jQuery(".controls .save").click(function(){
							jQuery(".goals-content ul li input").each(function(index){
								goal[index]=jQuery(this).val();
							});
							valid_flag=false;
							for (var i=0;i<goalCount;i++){
								if (goal[i]!=""){
									valid_flag=true;
									break;
								}
							}
							if (!valid_flag){
								//jQuery(".step-content .message").removeClass("green_message").html("Please input your three main goals for saving !");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[112]; ?>");
								animateScrollTop(".step-content .message",'3000');
								return;
							}

							jQuery.ajax({
								type : "POST",
								async : true,
								url : "<?=get_stylesheet_directory_uri()?>/breathing-step-save.php",
								data : {
									user_id: <?php echo $user_id;?>,
									step_num:2,
									goal: goal
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
									//console.log(g);
									if (g.status=="ok"){
										//console.log(g.query);
										//alert("Saving succeed!");
										origin_goal=goal.slice();
										//jQuery(".step-content .message").addClass("green_message").html("You passed second step! You should pass step-3.");
										jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
										jQuery(".step-content .message").addClass("green_message").html("<?php echo $text[113]; ?>");
										jQuery(".controls .save").hide();
										jQuery(".controls .update").show();
										jQuery(".controls .next-step").show();
										jQuery(".controls .to-step-4").hide();
									}else{
										jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
										jQuery(".step-content .message").removeClass("green_message").html(g.status);
										animateScrollTop(".step-content .message",'3000');
									}
								}
							});
						});

						jQuery(".controls .update").click(function(){
							jQuery(".goals-content ul li input").each(function(index){
								goal[index]=jQuery(this).val();
							});
							valid_flag=false;
							for (var i=0;i<goalCount;i++){
								if (goal[i]!=""){
									valid_flag=true;
									break;
								}
							}
							if (!valid_flag){
								//jQuery(".step-content .message").removeClass("green_message").html("Please input your three main goals for updating !");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[114]; ?>");
								animateScrollTop(".step-content .message",'3000');
								return;
							}
							if (!(origin_goal.toString()==goal.toString())){
								jQuery.ajax({
									type : "POST",
									async : true,
									url : "<?=get_stylesheet_directory_uri()?>/breathing-step-update.php",
									data : {
										user_id: <?php echo $user_id;?>,
										step_num:2,
										goal: goal
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
										//console.log(g);
										if (g.status=="ok"){
											//jQuery(".step-content .message").addClass("green_message").html("Updating succeed!");
											jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
											jQuery(".step-content .message").addClass("green_message").html("<?php echo $text[77]; ?>");
											animateScrollTop(".step-content .message",'3000');
											origin_goal=goal.slice();
										}else{
											jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
											jQuery(".step-content .message").html(g.status);
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
							for (var i=0;i<goalCount;i++){
								goal[i]="";
								jQuery(".goals-content ul li input").val("");
							}
						});

						jQuery(".controls .next-step").click(function(){
							window.location.replace("<?php echo get_page_link($next_page->ID); ?>");
						});

						jQuery(".controls .prev-step").click(function(){
							window.location.replace("<?php echo get_page_link($prev_page->ID); ?>");
						});

						jQuery(".controls .to-step-4").click(function(){
							window.location.replace("<?php echo get_page_link($step_4->ID); ?>");
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