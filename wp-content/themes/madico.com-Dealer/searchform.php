<form method="get" accept-charset="utf-8" class="search-form clearfix" id="search-form" action="<?php bloginfo( 'home' ); ?>">
	<input class="search-text" type="text" name="s" id="search-text" value="<?php if ( is_search() ) __( get_search_query() ); else echo __('Search this site', 'madicotheme') . '&hellip;'; ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"/>
	<input name="" type="submit" id="searchsubmit" value="" />
</form>