<?php
  $post = $wp_query->post;
  $category = get_the_category($post);
 if (in_category('testimonials') || in_category('kundberattelser')) {
 		get_template_part("single", "testimonials");
      //include CHILD_DIR.'/single-testimonials.php';
  }else if(in_category('articles') || in_category('artiklar')) {
  	get_template_part("single","articles");
  }
  else{
      get_template_part("single","blogs");
  }
?>
