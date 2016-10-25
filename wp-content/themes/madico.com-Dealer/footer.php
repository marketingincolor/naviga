
<div id="footer">
	<div  class="container">
		<div class="row-fluid">
			<div class="links NOTclearfix span12">
				<?php wp_nav_menu(array("depth" => 1, 'menu_class' => 'menu footer-menu clearfix')); ?>
			</div>
			<div class="icons span12">
				<div class="row-fluid">
					<div class="span10 offset1">
						<img src="<?php bloginfo('template_url'); ?>/images/mad-dd-org-ico-asid.png" alt="Madico is an ASID Partner" />
						&nbsp;&nbsp;
						<img src="<?php bloginfo('template_url'); ?>/images/mad-dd-org-ico-esp.png" alt="Madico is an Energy Star Partner" />
						&nbsp;&nbsp;
						<img src="<?php bloginfo('template_url'); ?>/images/mad-dd-org-ico-iwfa.png" alt="Madico is IWFA Accredited" />
						&nbsp;&nbsp;
						<img src="<?php bloginfo('template_url'); ?>/images/mad-dd-org-ico-nfrc.png" alt="Madico is an NFRC Member" />
						&nbsp;&nbsp;
						<img src="<?php bloginfo('template_url'); ?>/images/mad-dd-org-ico-sema.png" alt="Madico is a SEMA Member" />
					</div>
				</div>

			</div>
			<div class="copyright span12">
				<?php echo __('Copyright', 'madicotheme') . ' &copy; ' . date("Y") . ' Madico, Inc.'; ?>
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/global.js"></script>

<!-- Google Tag Manager -->

<!-- End Google Tag Manager -->

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/vimeo.ga.js"></script>
<script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
