<?php

require_once('../../../wp-load.php');
global $wpdb;
//$course_id=(int) $_POST["course_id"];
$user_id=(int) $_POST["user_id"];
$step_num=(int) $_POST["step_num"];

$course_id=0;
$course_current_step=0;

$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
$result=$wpdb->get_row($query);
if ($result){
	$course_id=$result->course_id;
	$course_current_step=$result->course_current_step;
}
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
		$answer=$_POST["answer"];
		//$answer_str=serialize($answer);
		//print_r($answer_str);
		$answer_str = json_encode($answer);
		$total_score=$_POST["total_score"];

		$query="UPDATE `tw_step_1` SET `answers`='".$answer_str."', `total_score`=".$total_score." WHERE `course_id`=".$course_id;
		$result=$wpdb->query($query);
		if ($result){
			echo '{ "status" : "ok"}';
			exit;
		}else{
			//echo '{ "status" : "Fail to update in tw_step_1 table !"}';
			echo '{ "status" : "'.$text[97].'" }';
			exit;
		}
		break;
	case 2:
		$goal=$_POST["goal"];
		$goal1=$goal[0];
		$goal2=$goal[1];
		$goal3=$goal[2];

		$query="UPDATE `tw_step_2` SET `goal1`='".$goal1."', `goal2`='".$goal2."', `goal3`='".$goal3."' WHERE `course_id`=".$course_id;
		$result=$wpdb->query($query);
		if ($result){
			echo '{ "status" : "ok"}';
			exit;
		}else{
			//echo '{ "status" : "Fail to update in tw_step_2 table !"}';
			echo '{ "status" : "'.$text[98].'" }';
			exit;
		}
		break;
	case 3:
		$visual=$_POST["visual"];
		$visual1=$visual[0];
        $visual2=$visual[1];
        $visual3=$visual[2];

		$query="UPDATE `tw_step_3` SET `visual1`='".$visual1."', `visual2`='".$visual2."', `visual3`='".$visual3."' WHERE `course_id`=".$course_id;
		$result=$wpdb->query($query);
		if ($result){
			echo '{ "status" : "ok"}';
			exit;
		}else{
			//echo '{ "status" : "Fail to update in tw_step_3 table !"}';
			echo '{ "status" : "'.$text[99].'" }';
			exit;
		}
		break;
	case 4:
		$tape=$_POST["tape"];
		$relaxator=$_POST["relaxator"];
		$physical=$_POST["physical"];
		$use_flag=$_POST["use_flag"];
		$dayCount=count($tape);

		$update_flag=false;
		for ($i=0;$i<$dayCount;$i++){
			$query="UPDATE `tw_step_4` SET `tape_use`=".$tape[$i].", `relaxator`=".$relaxator[$i].", `physical`=".$physical[$i].", `use_flag`=".$use_flag[$i]." WHERE `course_id`=".$course_id." AND `day_num`=".($i+1);
			$result2=$wpdb->query($query);
			if ($result2){ $update_flag=true; }
		}
		if ($update_flag){
			$last_used_day=0;
			$query="SELECT * FROM `tw_step_4` WHERE `course_id`=".$course_id;
			$result3=$wpdb->get_results($wpdb->prepare($query));
			if ($result3){
				foreach($result3 as $row){
					$temp= $row->use_flag;
					if (intval($temp)>0){
						$last_used_day=intval($row->day_num);
					}
				}
			}
			if ($last_used_day==28 && $course_current_step<4){
					$query="UPDATE `tw_course` SET `course_current_step`=4 WHERE `course_id`=".$course_id;
					$result4= $wpdb->query($query);
					if ($result4){
						echo '{ "status" : "ok"}';
						exit;
					}else{
						echo '{ "status" : "Fail to update in tw_course table!" }';
						exit;
					}
			}else{
				echo '{ "status" : "ok"}';
				exit;
			}
		}else{
			//echo '{ "status" : "Fail to update in tw_step_4 table !"}';
			echo '{ "status" : "'.$text[100].'" }';
			exit;
		}
		break;
	case 5:
		$habits1=$_POST["habits1"];
		/* $habits1_str=serialize($habits1);
		$habits1_str=urlencode($habits1_str); */
		$habits1_str = json_encode($habits1);
		$habits2=$_POST["habits2"];
		$habits2_str=serialize($habits2);
		$habits2_str=urlencode($habits2_str);

		$habits2_str = json_encode($habits2);
		$week_num= $_POST["week_num"];
		$total_score=$_POST["total_score"];

		$query="UPDATE `tw_step_5` SET `habits1`='".$habits1_str."', `habits2`='".$habits2_str."', `total_score`=".$total_score." WHERE `course_id`=".$course_id." AND `week_num`=".$week_num;
		$result=$wpdb->query($query);
		if ($result){
			echo '{ "status" : "ok"}';
			exit;
		}else{
			//echo '{ "status" : "Fail to update in tw_step_5 table !"}';
			echo '{ "status" : "'.$text[101].'" }';
			exit;
		}
		break;
	case 6:
		$answer=$_POST["answer"];
		/* $answer_str=serialize($answer);
		$answer_str=urlencode($answer_str); */
		$answer_str = json_encode($answer);
		$total_score=$_POST["total_score"];

		$query="UPDATE `tw_step_6` SET `answers`='".$answer_str."', `total_score`=".$total_score." WHERE `course_id`=".$course_id;
		$result=$wpdb->query($query);
		if ($result){
			echo '{ "status" : "ok"}';
			exit;
		}else{
			//echo '{ "status" : "Fail to update in tw_step_6 table !"}';
			echo '{ "status" : "'.$text[102].'" }';
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

		$query="UPDATE `tw_step_7` SET `index_before`=".$index_before.", `index_after`=".$index_after.", `habits_week_1`=".$habits_week_1.", `habits_week_4`=".$habits_week_4.", `improvements`='".$improvements_str."' , `awareness_answer`='".$awareness_answer."' , `reach_goal_answer`='".$reach_goal_answer."' WHERE `course_id`=".$course_id;
		$result=$wpdb->query($query);
		if ($result){
			echo '{ "status" : "ok"}';
			exit;
		}else{
			//echo '{ "status" : "There are no any changes for updating !"}';
			echo '{ "status" : "'.$text[103].'" }';
			exit;
		}

		break;
}

?>