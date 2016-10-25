<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(''); ?></title>
	<meta name="author" content="kevinleary.net" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link href="<?php bloginfo('template_url'); ?>/css/print.css" type="text/css" rel="stylesheet" media="print" />
	<!--[if IE]><link href="<?php bloginfo('template_url'); ?>/css/ie.css" type="text/css" rel="stylesheet" media="all" /><![endif]-->
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.1.3.1.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/m5.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.cycle.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/global.js"></script>
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>	
</head>
<body>
<div id="wrapper">
	
	<div id="branding">
		<a href="<?php echo get_option('home'); ?>" id="logo"><?php bloginfo('name'); ?></a>
		<ul id="signup" class="clearfix">
			<li id="rss"><a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe to RSS">RSS</a></li>
		</ul>
		<ul id="mainNav">
			<?php wp_list_categories('sort_column=name&title_li=&depth=1'); ?>	
		</ul>
	</div><!--// end #branding -->
