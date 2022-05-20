<?php
/**
 * Template Name: 28-day-template-step-3
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
			<!--This page is a third step one for 28-day C.B.R.T Program.-->

			<?php


			$lang="se"; // or "en"
			if($lang =="en")
				$page_path_str = "improve-your-breathing";
			else
				$page_path_str = "andningstraning";


			$step_num = 3;

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
			$first_page = $cbr_pages[0];

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
					<div class='stepWrapper' stepNum="3">
						<img src='<?=CHILD_DIR."/images/step3_header.jpg" ?>'>
						<div class="step-content">
							<?php
								$message="";
								$goal=array("","","");
								$visual=array("","","");
								$step2_pass_flag=false;
								$pass_flag=false;
								$course_id=0;

								$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
								$result1=$wpdb->get_row($query);
								if ($result1){
									$course_id=$result1->course_id;
									$course_current_step=$result1->course_current_step;

									$query="SELECT * FROM `tw_step_2` WHERE `course_id`=".$course_id;
									$result2=$wpdb->get_row($query);
									if ($result2){
										$step2_pass_flag=true;
										$goal[0]=$result2->goal1;
										$goal[1]=$result2->goal2;
										$goal[2]=$result2->goal3;
									}else{
										//$message="You should pass second step for passing this step !";
										$message=$text[116];
									}
									$query="SELECT * FROM `tw_step_3` WHERE `course_id`=".$course_id;
									$result3=$wpdb->get_row($query);
									if ($result3){
										$pass_flag=true;
										//$message="You passed third step already!";
										$message=$text[117];
										$visual[0]=$result3->visual1;
										$visual[1]=$result3->visual2;
										$visual[2]=$result3->visual3;
									}

									if ($course_current_step==7){
										//$message="You passed all steps(step1~step7) already! You can finish this course in step-7 page. ";
										$message=$text[56];
									}

								}else{
									//$message="You should pass first step ! There is no course in progress!";
									$message=$text[106];
								}
								$info_message= "<div class='message  green_message' id='message_content'>{$message}</div>";
								echo do_shortcode("[message type='success']".$info_message."[/message]");
							?>
							<div class="description description-main">
								<!--A visualization answers the questions, "<b>How do I know that I've reached my goal?</b>" and "<b>How does it feel
								when I've reached my goal?</b>" The more emotionally involved you are in a goal, the greater the chance that
								you will reach it. One way to engage your emotions is to link a visualization to your goal. <b>For example</b>-->
								<?php echo $text[118]; ?>
								...
								<ul>
									<li>
										<div><b><?php echo $text[120];//Goal ?>:</b> <?php echo $text[122];//To have more energy. ?></div><br/>
										<div><b><?php echo $text[121];//Visualization ?>:</b> <?php echo $text[123];//Waking up rested and refreshed, full of energy. ?></div>
									</li>
									<li>
										<div><b><?php echo $text[120];//Goal ?>:</b> <?php echo $text[124];//To reach my ideal weight. ?></div><br/>
										<div><b><?php echo $text[121];//Visualization ?>:</b> <?php echo $text[125];//Seeing the scale showing my ideal weight and feeling very happy with my body when I look at myself in the mirror. ?></div>
									</li>
									<li>
										<div><b><?php echo $text[120];//Goal ?>:</b> <?php echo $text[126];//To reduce my alcohol intake. ?></div><br/>
										<div><b><?php echo $text[121];//Visualization ?>:</b> <?php echo $text[127];//Being at a party where I'm sober, relaxed and full of confidence. ?></div>
									</li>
									<li>
										<div><b><?php echo $text[120];//Goal ?>:</b> <?php echo $text[128];//To score more goals when I play sports. ?></div><br/>
										<div><b><?php echo $text[121];//Visualization ?>:</b> <?php echo $text[129];//When I make the goal celebration gesture after I scored. ?></div>
									</li>
								</ul>
							</div>
							<img src='<?=CHILD_DIR."/images/step2-3_header.jpg" ?>'>
							<br/><br/>
							</div>
							<div class="goals-content">
								<ul>
								<?php
									for ($i=0;$i<3;$i++){
										echo "<li goalNum=\"".($i+1)."\">";
										echo "<div class=\"goal\"><input name=\"goal-".($i+1)."\" value=\"".$goal[$i]."\" disabled></div>";
										echo "<div class=\"visualization\"><div>".$text[121].":</div><input name=\"visual-".($i+1)."\" value=\"".$visual[$i]."\"></div>"; // $text[121]="Visualization"
										echo "</li>";
									}
								?>
								</ul>
							</div>
							<div class="controls">
								<div class="buttons">
									<?php if ($pass_flag){ ?>
									<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
									<span class="update"><?php echo $text[68];//Update ?></span>
									<!--span class="reset"><?php echo $text[69];//Reset ?></span-->
									<span class="next-step" ><?php echo $text[70];//To next step ?></span>
									<?php }else if ($step2_pass_flag){ ?>
									<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
									<span class="update" style="display:none;"><?php echo $text[68];//Update ?></span>
									<span class="save"><?php echo $text[71];//Save ?></span>
									<!--span class="reset"><?php echo $text[69];//Reset ?></span-->
									<span class="next-step" ><?php echo $text[70];//To next step ?></span>
									<?php }else if ($course_id!=0){ ?>
									<span class="prev-step"><?php echo $text[110];//To previous step ?></span>
									<span class="next-step" ><?php echo $text[70];//To next step ?></span>
									<?php }else{ ?>
									<span class="first-step"><?php echo $text[134];//To first step ?></span>
									<?php } ?>
								</div>
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

						var visual=Array();
						var origin_visual=Array();
						var visualCount= jQuery(".goals-content ul li").size(); //  =3
						for (var i=0;i<visualCount;i++){
							visual[i]=jQuery(".goals-content ul li[goalNum='"+(i+1)+"'] .visualization input").val();
						}
						origin_visual=visual.slice();

						jQuery(".controls .save").click(function(){
							jQuery(".goals-content ul li .visualization input").each(function(index){
								visual[index]=jQuery(this).val();
							});
							valid_flag=false;
							for (var i=0;i<visualCount;i++){
								if (visual[i]!=""){
									valid_flag=true;
									break;
								}
							}
							if (!valid_flag){
								//jQuery(".step-content .message").removeClass("green_message").html("Please input visualizations to connect your main goals for saving !");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[135]; ?>");
								animateScrollTop(".step-content .message",'3000');
								return;
							}

							jQuery.ajax({
								type : "POST",
								async : true,
								url : "<?=get_stylesheet_directory_uri()?>/breathing-step-save.php",
								data : {
									user_id: <?php echo $user_id;?>,
									step_num:3,
									visual: visual
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
									//console.log(g);
									if (g.status=="ok"){
										origin_goal=goal.slice();
										//jQuery(".step-content .message").addClass("green_message").html("You passed third step! You should pass step-4.");
										jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
										jQuery(".step-content .message").addClass("green_message").html("<?php echo $text[136]; ?>");
										jQuery(".controls .save").hide();
										jQuery(".controls .update").show();
										jQuery(".controls .next-step").show();
									}else{
										jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
										jQuery(".step-content .message").removeClass("green_message").html(g.status);
										animateScrollTop(".step-content .message",'3000');
									}
								}
							});
						});

						jQuery(".controls .update").click(function(){
							jQuery(".goals-content ul li .visualization input").each(function(index){
								visual[index]=jQuery(this).val();
							});
							valid_flag=false;
							for (var i=0;i<visualCount;i++){
								if (visual[i]!=""){
									valid_flag=true;
									break;
								}
							}
							if (!valid_flag){
								//jQuery(".step-content .message").removeClass("green_message").html("Please input visualizations to connect your main goals for updating !");
								jQuery(".step-content").children("div:eq(0)").removeClass("success").addClass("erroneous");
								jQuery(".step-content .message").removeClass("green_message").html("<?php echo $text[137]; ?>");
								animateScrollTop(".step-content .message",'3000');
								return;
							}
							if (!(origin_visual.toString()==visual.toString())){
								jQuery.ajax({
									type : "POST",
									async : true,
									url : "<?=get_stylesheet_directory_uri()?>/breathing-step-update.php",
									data : {
										user_id: <?php echo $user_id;?>,
										step_num:3,
										visual: visual
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
										//console.log(g);
										if (g.status=="ok"){
											//jQuery(".step-content .message").addClass("green_message").html("Updating succeed!");
											jQuery(".step-content").children("div:eq(0)").removeClass("erroneous").addClass("success");
											jQuery(".step-content .message").addClass("green_message").html("<?php echo $text[77]; ?>");
											animateScrollTop(".step-content .message",'3000');
											origin_visual=visual.slice();
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
							for (var i=0;i<visualCount;i++){
								visual[i]="";
								jQuery(".goals-content ul li .visualization input").val("");
							}
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