<?php
add_filter( 'wp_head', 'vkExUnit_print_metaDescription',5);
function vkExUnit_print_metaDescription(){
	echo '<meta name="description" content="'.vkExUnit_get_pageDescription().'" />'."\n";
}