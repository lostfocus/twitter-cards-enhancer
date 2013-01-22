<?php
/*
Plugin Name: Twitter Cards Enhancer
Plugin URI: http://lostfocus.de/
Description: Some small enhancements to WordPress to make more out of <a href="https://github.com/niallkennedy/twitter-cards">Twitter Cards</a> by Niall Kennedy
Author: Dominik Schwind
Version: 1
Author URI: http://lostfocus.de/
*/

function twitter_cards_enhancer_contactmethod( $contactmethods ) {
	$contactmethods['twitter'] = 'Twitter';
	return $contactmethods;
}

function twitter_cards_enhancer_generalsettings(){
	register_setting( 'general', 'site_twitter', 'esc_attr' );
	add_settings_field('site_twitter', '<label for="site_twitter">'.__('Twitter' , 'site_twitter' ).'</label>' , 'twitter_cards_enhancer_generalsettings_html' , 'general' );
}

function twitter_cards_enhancer_generalsettings_html(){
	$value = get_option( 'site_twitter', '' );
	echo '<input type="text" id="site_twitter" name="site_twitter" value="' . $value . '" />';
}

function twitter_cards_enhancer_cards($twitter_card){
	if(is_array($twitter_card)){
		$site_twitter = get_option( 'site_twitter', '' );
		if(trim($site_twitter) != ''){
			$f = substr($site_twitter,0,1);
			if($f != "@"){
				$site_twitter = "@" . $site_twitter;
			}
			$twitter_card['site'] = $site_twitter;
		}
		$author = get_the_author_meta('twitter');
		if(trim($author) != ''){
			$f = substr($author,0,1);
			if($f != "@"){
				$author = "@" . $author;
			}
			$twitter_card['creator'] = $author;
		}
	}
	return $twitter_card;
}

add_filter( 'user_contactmethods', 'twitter_cards_enhancer_contactmethod', 10, 1);
add_filter( 'admin_init' , 'twitter_cards_enhancer_generalsettings', 10, 1 );
add_filter( 'twitter_cards_properties', 'twitter_cards_enhancer_cards' );