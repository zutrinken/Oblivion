<form action="<?php echo home_url() ?>" class="searchform" method="get" role="search">
	<?php if(is_search()) : ?>
		<input class="searchform-input" type="text" value="<?php the_search_query(); ?>" name="s">
	<?php else : ?>
		<input class="searchform-input" type="text" placeholder="<?php _e('Search ...','oblivion'); ?>" name="s">
	<?php endif; ?>
	<button type="submit" name="submit" class="searchform-button"><i class="icon-search"></i></button>
	<div class="clear"></div>
</form>