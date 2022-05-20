	
<?php

require_once('../../../wp-load.php');
global $wpdb;

$user_id=(int) $_POST["user_id"];
$week_num=(int) $_POST["week_num"];
$week_str=array("first","second","third","fourth");

$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0";
$result0=$wpdb->get_row($query);
if ($result0){
	$course_id=$result0->course_id;
	$course_current_step= $result0->course_current_step;
	$goto_step=$course_current_step+1;
	if ($course_current_step<3){
		echo '{ "status" : "You passed step-'.$course_current_step.'! So you should pass step-'.$goto_step.'."}';
		exit;
	}
	
	$query="SELECT max(`week_num`) AS last_week FROM `tw_step_4` WHERE `course_id`=".$course_id;
	$result1=$wpdb->get_row($query);
	if ($result1){
		$last_week_num=(int) $result1->last_week;
		if ($last_week_num<$week_num){
			if ($last_week_num==0){
				echo '{ "status" : "You should pass '.$week_str[$last_week_num].' week."}';
				exit;
			}else{
				echo '{ "status" : "You passed '.$week_str[$last_week_num-1].' week of step-4 ! So you should pass '.$week_str[$last_week_num].' week."}';
				exit;
			}
		}else{
			$query="SELECT * FROM `tw_step_4` WHERE `course_id`=".$course_id." AND `week_num`=".$week_num;
			$result2=$wpdb->get_row($query);
			$habits1_str=$result2->habits1;
			$habits1_str=urldecode($habits1_str);
			$habits1=array();
			$habits1=unserialize($habits1_str);
			
			$habits2_str=$result2->habits2;
			$habits2_str=urldecode($habits2_str);
			$habits2=array();
			$habits2=unserialize($habits2_str);
			
			$total_score=(int) $result2->total_score;
			
			$result=array("status"=>"ok", "habits1"=>$habits1, "habits2"=>$habits2, "total_score"=>$total_score);
			$result=json_encode($result);
			echo $result;
			exit;
			
		}
	}else{
		echo '{ "status" : "You should pass first week of step-4."}';
		exit;
	}
	
	
	
}else{
	echo '{ "status" : "You should pass first step!"}';
	exit;
}

?>