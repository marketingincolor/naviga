<?php
	$postID = $post->ID;
	$default = '<div class="default">&nbsp;</div>';
	if(is_numeric($postID)) {

		$ss_setting = get_post_meta($postID, 'cft_slideshow_setting', true);

		if($ss_setting == 'ss_small') {
			p_slideshow(180);
		} else if($ss_setting == 'ss_large') {
			p_slideshow();
		} else if($ss_setting == 'custom_image') {
			$custom_image = get_post_meta($postID, 'cft_header_image', true);
			$custom_image = wp_get_attachment_image_src($custom_image, array(940,180));
			$custom_image = $custom_image[0];
			$custom_image = str_replace( 'sites/1/', '', $custom_image );
			$custom_text  = get_post_meta($postID, 'cft_header_description', true);
			if(!empty($custom_image))
				echo '<div class="default custom" style="background:url('. $custom_image .') no-repeat bottom center;">'.$custom_text.'</div>';
			else
				echo $default;
		} else {
			echo $default;
		}

	} else {
		echo $default;
	}


	function p_slideshow($h = 330) {
		global $postID;
		echo '<ul style="height:'.$h.'px;">';
		for ($i = 0; $i < 10; $i++) {
				$slideshow_image = get_post_meta($postID, 'cft_slideshow'.$i.'_image', true);
				$slideshow_text  = get_post_meta($postID, 'cft_slideshow'.$i.'_description', true);

			if(isset($slideshow_image) && !empty($slideshow_image)) {

			$background = wp_get_attachment_image_src( $slideshow_image, array(940,$h) );
			?>
			<li style="background:url(<?php print $background[0]; ?>);height:<?php echo $h;?>px;width:100%;<?php print ($i > 0)? "display:none;" : ""; ?>">
			<?php print $slideshow_text;
			echo '</li>';
			}
		}
		echo '</ul>';
	}
?>