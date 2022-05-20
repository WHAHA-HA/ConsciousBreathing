<?php

//user_id
//step_num:1,
//answer: answer,
//total_score:total_score

require_once('../../../wp-load.php');
global $wpdb;
$user_id=(int) $_POST["user_id"];
$step_num=(int) $_POST["step_num"];

$lang="en"; // or "se"
$query="SELECT `text_id`, `".$lang."_text` AS `text` FROM `tw_text` ORDER BY `text_id` ASC";
$text_result=$wpdb->get_results($query);
$text_flag=false;
$text=array();
if ($text_result){
	$text_flag=true;
	foreach($text_result as $row){
		$text_id=(int) $row->text_id;
		$text[$text_id]=$row->text;
	}
}

switch ($step_num) {
    case 1:
        if (!isset($_POST["answer"]) || !isset($_POST["total_score"])){
        	echo '{ "status" : "answer OR total_score fail!" }';
			exit;
        }
		$answer=$_POST["answer"];
		//$answer_str=serialize($answer);
		//$answer_str=urlencode($answer_str);
		$answer_str = json_encode($answer);
		$total_score=$_POST["total_score"];
		$date_created=date("Y-m-d H:i:s");
		$past_month = date("Y-m-d",mktime(0,0,0,date("m")-1,date("d")));

			//tw_course: course_id, user_id, course_current_step, finish_status, date_created
			//tw_step_1 : course_id, answers, total_score, past_month, date_created
		$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
		$result0=$wpdb->get_row($query);
		if ($result0){
			$course_current_step=$result0->course_current_step;
			$goto_step=$course_current_step+1;
			if ($course_current_step==7){
				//echo '{ "status" : "You passed all steps(step1~step7) already! You can finish this course in step-7 page. "}';
				echo '{ "status" : "'.$text[56].'"}';
				exit;
			}else{
				//echo '{ "status" : "You passed first step already! "}';
				echo '{ "status" : "'.$text[57].'"}';
				exit;
			}
		}

		$query="INSERT INTO `tw_course` (`user_id`, `course_current_step`, `finish_status`, `date_created`) VALUES (".$user_id.",1 ,0 ,'".$date_created."' )";
		$result=$wpdb->query($query);

		if ($result){
			$last_course_id = $wpdb->get_col("SELECT `course_id` FROM `tw_course` ORDER BY `course_id` DESC LIMIT 0 , 1" );
			$course_id=$last_course_id[0];

			$query="INSERT INTO `tw_step_1` (`course_id`, `answers`, `total_score`, `past_month`, `date_created`) VALUES
									(".$course_id.",'".$answer_str."' ,".$total_score." ,'".$past_month."' ,'".$date_created."' )";
			$result2=$wpdb->query($query);

			if ($result2){
				//echo '{ "status" : "ok", "query":"'.$query.'" }';
				echo '{ "status" : "ok"}';
				exit;
			}else{
				$query="DELETE FROM `tw_course` WHERE `course_id`=".$course_id;
				$wpdb->query($query);

				//echo '{ "status" : "Fail to insert in tw_step_1 table!" }';
				echo '{ "status" : "'.$text[80].'" }';
				exit;
			}
		}else{
			//echo '{ "status" : "Fail to insert in tw_course table!" }';
			echo '{ "status" : "'.$text[81].'" }';
			exit;
		}

        break;
    case 2:
        if (!isset($_POST["goal"])){
        	//echo '{ "status" : "Fail to pass the Goals!" }';
        	echo '{ "status" : "'.$text[82].'" }';
			exit;
        }
		$goal=$_POST["goal"];
		$goal1=$goal[0];
		$goal2=$goal[1];
		$goal3=$goal[2];
		$date_created=date("Y-m-d H:i:s");

			//tw_course: course_id, user_id, course_current_step, finish_status, date_created
			//tw_step_2 : course_id, goal1, goal2, goal3, date_created
		$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
		$result=$wpdb->get_row($query);

		if ($result){
			$course_id=$result->course_id;
			$course_current_step=$result->course_current_step;
			$goto_step=$course_current_step+1;
			if ($course_current_step==7){
				//echo '{ "status" : "You passed all steps(step1~step7) already! You can finish this course in step-7 page. "}';
				echo '{ "status" : "'.$text[56].'"}';
				exit;
			}

			$query="INSERT INTO `tw_step_2` (`course_id`, `goal1`, `goal2`, `goal3`, `date_created`) VALUES (".$course_id.",'".$goal1."' ,'".$goal2."' ,'".$goal3."' ,'".$date_created."' )";
			$result2=$wpdb->query($query);

			if ($result2){
				if ($course_current_step==1){
					$query="UPDATE `tw_course` SET `course_current_step`=2 WHERE `course_id`=".$course_id;
					$result3= $wpdb->query($query);
					if ($result3){
						echo '{ "status" : "ok"}';
						exit;
					}else{
						$query="DELETE FROM `tw_step_2` WHERE `course_id`=".$course_id;
						$wpdb->query($query);

						//echo '{ "status" : "Fail to update in tw_course table!" }';
						echo '{ "status" : "'.$text[83].'" }';
						exit;
					}
				}else {
					echo '{ "status" : "ok"}';
					exit;
				}

			}else{
				//echo '{ "status" : "Fail to insert in tw_step_2 table!"}';
				echo '{ "status" : "'.$text[84].'"}';
				exit;
			}
		}else{
			//echo '{ "status" : "Failed: You should pass first step!" }';
			echo '{ "status" : "'.$text[85].'" }';
			exit;
		}

        break;
    case 3:
        $visual=$_POST["visual"];
        $visual1=$visual[0];
        $visual2=$visual[1];
        $visual3=$visual[2];
		$date_created=date("Y-m-d H:i:s");

			//tw_course: course_id, user_id, course_current_step, finish_status, date_created
			//tw_step_3 : course_id,  visual1, visual2, visual3 , date_created
		$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
		$result=$wpdb->get_row($query);

		if ($result){
			$course_id=$result->course_id;
			$course_current_step=$result->course_current_step;

			if ($course_current_step==7){
				//echo '{ "status" : "You passed all steps(step1~step7) already! You can finish this course in step-7 page. "}';
				echo '{ "status" : "'.$text[56].'"}';
				exit;
			}

			$query="INSERT INTO `tw_step_3` (`course_id`, `visual1`, `visual2`, `visual3`, `date_created`) VALUES
							(".$course_id.",'".$visual1."' ,'".$visual2."' ,'".$visual3."' ,'".$date_created."' )";
			echo $query;
			$result2=$wpdb->query($query);
			echo $result;
			if ($result2){
				if ($course_current_step==2){
					$query="UPDATE `tw_course` SET `course_current_step`=3 WHERE `course_id`=".$course_id;
					$result3= $wpdb->query($query);
					if ($result3){
						echo '{ "status" : "ok"}';
						exit;
					}else{
						$query="DELETE FROM `tw_step_3` WHERE `course_id`=".$course_id;
						$wpdb->query($query);

						//echo '{ "status" : "Fail to update in tw_course table!" }';
						echo '{ "status" : "'.$text[83].'" }';
						exit;
					}
				}else{
					echo '{ "status" : "ok"}';
					exit;
				}
			}else{
				//echo '{ "status" : "Fail to insert in tw_step_3 table!" }';
				echo '{ "status" : "'.$text[86].'" }';
				exit;
			}

		}else{
			//echo '{ "status" : "Failed: You should pass first step!" }';
			echo '{ "status" : "'.$text[85].'" }';
			exit;
		}

        break;
	case 4:
        $tape=$_POST["tape"];
		$relaxator=$_POST["relaxator"];
		$physical=$_POST["physical"];
		$use_flag=$_POST["use_flag"];
		$dayCount=count($tape);

		$date_created=date("Y-m-d H:i:s");

			//tw_course: course_id, user_id, course_current_step, finish_status, date_created
			//tw_step_5: course_id, day_num, tape_use, relaxator, physical , date_created
		$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
		$result=$wpdb->get_row($query);

		if ($result){
			$course_id=$result->course_id;
			$course_current_step=$result->course_current_step;

			if ($course_current_step==7){
				//echo '{ "status" : "You passed all steps(step1~step7) already! You can finish this course in step-7 page. "}';
				echo '{ "status" : "'.$text[56].'"}';
				exit;
			}

			$query="INSERT INTO `tw_step_4` (`course_id`, `day_num`, `tape_use`, `relaxator`, `physical`, `use_flag`, `date_created`) VALUES ";
			for ($i=0;$i<$dayCount;$i++){
				$query.="(".$course_id.",".($i+1)." ,".$tape[$i]." ,".$relaxator[$i]." ,".$physical[$i]." ,".$use_flag[$i]." ,'".$date_created."' )";
				if ($i!=($dayCount-1)){
					$query.=",";
				}
			}
			$result2=$wpdb->query($query);
			if ($result2){
				echo '{ "status" : "ok"}';
				exit;
				/*
				if ($course_current_step<4){
					$query="UPDATE `tw_course` SET `course_current_step`=4 WHERE `course_id`=".$course_id;
					$result3= $wpdb->query($query);
					if ($result3){
						echo '{ "status" : "ok"}';
						exit;
					}else{
						$query="DELETE FROM `tw_step_4` WHERE `course_id`=".$course_id;
						$wpdb->query($query);

						//echo '{ "status" : "Fail to update in tw_course table!" }';
						echo '{ "status" : "'.$text[83].'" }';
						exit;
					}
				}else{
					echo '{ "status" : "ok"}';
					exit;
				}*/
			}else{
				//echo '{ "status" : "Fail to insert in tw_step_4 table!" }';
				echo '{ "status" : "'.$text[87].'" }';
				exit;
			}

		}else{
			//echo '{ "status" : "Failed: You should pass first step!" }';
			echo '{ "status" : "'.$text[85].'" }';
			exit;
		}

        break;
	case 5:
        //week_num, habits1, habits2, total_score
        $week_num=$_POST["week_num"];
        $week_str=array("first","second","third","fourth");

        $habits1=$_POST["habits1"];
        /* $habits1_str=serialize($habits1);
		$habits1_str=urlencode($habits1_str); */
		$habits1_str = json_encode($habits1);
        $habits2=$_POST["habits2"];
      	/* $habits2_str=serialize($habits2);
	  	$habits2_str=urlencode($habits2_str); */

	  	$habits2_str = json_encode($habits2);

		$total_score=$_POST["total_score"];
		$date_created=date("Y-m-d H:i:s");

			//tw_course: course_id, user_id, course_current_step, finish_status, date_created
			//tw_step_5 : course_id, week_num, habits1, habits2, total_score, date_created
		$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
		$result=$wpdb->get_row($query);

		if ($result){
			$course_id=$result->course_id;
			$course_current_step=$result->course_current_step;

			if ($course_current_step==7){
				//echo '{ "status" : "You passed all steps(step1~step7) already! You can finish this course in step-7 page. "}';
				echo '{ "status" : "'.$text[56].'"}';
				exit;
			}
			$query  = "SELECT 8 FROM `tw_step_5` where `course_id`='{$course_id}' and `week_num`='{$week_num}' ";
			$result_exist = $wpdb->get_row($query);
			if(!$result_exist) //not saved yet
			{

				$query="INSERT INTO `tw_step_5` (`course_id`, `week_num`, `habits1`, `habits2`, `total_score`, `date_created`) VALUES
						(".$course_id.",".$week_num." ,'".$habits1_str."' ,'".$habits2_str."' ,".$total_score." ,'".$date_created."' )";
			}else{	//already saved , yes we update it
				$query="update `tw_step_5` SET  `habits1`='{$habits1_str}', `habits2` ='{$habits2_str}', `total_score`='{$total_score}', `date_created`='{$date_created}'
				where `course_id`='{$course_id}' and `week_num`='{$week_num}'";
			}
			$result2=$wpdb->query($query);

			if ($result2){
				if ($week_num==4 && $course_current_step<5){

					$query="UPDATE `tw_course` SET `course_current_step`=5 WHERE `course_id`=".$course_id;
					$result3= $wpdb->query($query);
					if ($result3){
						echo '{ "status" : "ok"}';
						exit;
					}else{
						$query="DELETE FROM `tw_step_5` WHERE `course_id`=".$course_id." AND `week_num`=".$week_num;
						$wpdb->query($query);

						//echo '{ "status" : "Fail to update in tw_course table!" }';
						echo '{ "status" : "'.$text[83].'" }';
						exit;
					}

				}else{
					echo '{ "status" : "ok"}';
					exit;
				}
			}else{
				//echo '{ "status" : "Fail to insert in tw_step_5 table.!" }';
				//incase there is already existed update it....
				echo '{ "status" : "'.$text[88].'" }';
				exit;
			}

		}else{
			//echo '{ "status" : "Failed: You should pass first step!" }';
			echo '{ "status" : "'.$text[85].'" }';
			exit;
		}

        break;
	case 6:
        $answer=$_POST["answer"];
		/* $answer_str=serialize($answer);
		$answer_str=urlencode($answer_str); */

        $answer_str=json_encode($answer);
		$total_score=$_POST["total_score"];
		$date_created=date("Y-m-d H:i:s");
		$past_month = date("Y-m-d",mktime(0,0,0,date("m")-1,date("d")));

			//tw_course: course_id, user_id, course_current_step, finish_status, date_created
			//tw_step_6 : course_id, answers, total_score, past_month, date_created
		$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
		$result=$wpdb->get_row($query);

		if ($result){
			$course_id=$result->course_id;
			$course_current_step=$result->course_current_step;
			//$goto_step=$course_current_step+1;
			if ($course_current_step>=6){
				if ($course_current_step==7){
					//echo '{ "status" : "You passed all steps(step1~step7) already! You can finish this course in step-7 page. "}';
					echo '{ "status" : "'.$text[56].'"}';
					exit;
				}else{// $course_current_step==6
					//echo '{ "status" : "Failed: You passed sixth step already!"}';
					echo '{ "status" : "'.$text[89].'"}';
					exit;
				}
			}

			if ($course_current_step!=5){
				//echo '{ "status" : "Failed: You didn\'t pass step-5 !"}';
				echo '{ "status" : "'.$text[90].'"}';
				exit;
			}

			$query="INSERT INTO `tw_step_6` (`course_id`, `answers`, `total_score`, `past_month`, `date_created`) VALUES
								(".$course_id.",'".$answer_str."' ,".$total_score." ,'".$past_month."' ,'".$date_created."' )";
			$result2=$wpdb->query($query);

			if ($result2){
				$query="UPDATE `tw_course` SET `course_current_step`=6 WHERE `course_id`=".$course_id;
				$result3= $wpdb->query($query);
				if ($result3){
					echo '{ "status" : "ok"}';
					exit;
				}else{
					$query="DELETE FROM `tw_step_6` WHERE `course_id`=".$course_id;
					$wpdb->query($query);

					//echo '{ "status" : "Fail to update in tw_course table!" }';
					echo '{ "status" : "'.$text[83].'" }';
					exit;
				}
			}else{
				//echo '{ "status" : "Fail to insert in tw_step_6 table!" }';
				echo '{ "status" : "'.$text[91].'" }';
				exit;
			}

		}else{
			//echo '{ "status" : "Failed: You should pass first step!" }';
			echo '{ "status" : "'.$text[85].'" }';
			exit;
		}

        break;
	case 7:
        $index_before=$_POST["index_before"];
		$index_after=$_POST["index_after"];
		$habits_week_1=$_POST["habits_week_1"];
		$habits_week_4=$_POST["habits_week_4"];
		$improvements=$_POST["improvements"];

		/* $improvements_str=serialize($improvements);
		$improvements_str=urlencode($improvements_str); */
		$improvements_str = json_encode($improvements);

		$awareness_answer=$_POST["awareness_answer"];
		$reach_goal_answer=$_POST["reach_goal_answer"];

		$date_created=date("Y-m-d H:i:s");

			//tw_course: course_id, user_id, course_current_step, finish_status, date_created
			//tw_step_7 : course_id, index_before, index_after, habits_week_1, habits_week_4,
						//improvements, awareness_answer, reach_goal_answer, date_created
		$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
		$result=$wpdb->get_row($query);

		if ($result){
			$course_id=$result->course_id;
			$course_current_step=$result->course_current_step;
			$goto_step=$course_current_step+1;
			if ($course_current_step==7){
				//echo '{ "status" : "Failed: You passed all steps(step1~step7) already! You can finish this course by pressing Finish button."}';
				echo '{ "status" : "'.$text[92].'" }';
				exit;
			}else if ($course_current_step!=6){
				//echo '{ "status" : "Failed: You passed by step-'.$course_current_step.'!"}';
				echo '{ "status" : "'.$text[93].$course_current_step.'!"}';
				exit;
			}

			$query="INSERT INTO `tw_step_7` (`course_id`, `index_before`, `index_after`, `habits_week_1`, `habits_week_4`, `improvements`, `awareness_answer`, `reach_goal_answer`, `date_created`) VALUES
									(".$course_id.",".$index_before." ,".$index_after." ,".$habits_week_1." ,".$habits_week_4." ,'".$improvements_str."' ,'".$awareness_answer."' ,'".$reach_goal_answer."' ,'".$date_created."' )";
			$result2=$wpdb->query($query);

			if ($result2){
				$query="UPDATE `tw_course` SET `course_current_step`=7 WHERE `course_id`=".$course_id;
				$result3= $wpdb->query($query);
				if ($result3){
					echo '{ "status" : "ok"}';
					exit;
				}else{
					$query="DELETE FROM `tw_step_7` WHERE `course_id`=".$course_id;
					$wpdb->query($query);

					//echo '{ "status" : "Fail to update in tw_course table!" }';
					echo '{ "status" : "'.$text[83].'" }';
					exit;
				}
			}else{
				//echo '{ "status" : "Fail to insert in tw_step_7 table!" }';
				echo '{ "status" : "'.$text[94].'" }';
				exit;
			}

		}else{
			//echo '{ "status" : "Failed: You should pass first step!" }';
			echo '{ "status" : "'.$text[85].'" }';
			exit;
		}

        break;
	case 10:// finish current course
		//tw_course: course_id, user_id, course_current_step, finish_status, date_created
		$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
		$result=$wpdb->get_row($query);

		if ($result){
			$course_id=$result->course_id;
			$query="UPDATE `tw_course` SET `finish_status`=1 WHERE `course_id`=".$course_id;
			$result2= $wpdb->query($query);
			if ($result2){
				echo '{ "status" : "ok"}';
				exit;
			}else{
				//echo '{ "status" : "Fail to update for finishing current course in tw_course table!" }';
				echo '{ "status" : "'.$text[95].'" }';
				exit;
			}

		}else{
			//echo '{ "status" : "You have not any course to finish now!" }';
			echo '{ "status" : "'.$text[96].'" }';
			exit;
		}


		break;
}

?>