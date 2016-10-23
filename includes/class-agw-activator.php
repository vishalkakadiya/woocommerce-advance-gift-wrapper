<?php

/**
 * Fired during plugin activation
 *
 * @link       http://profiles.wordpress.org/vishalkakadiya/
 * @since      1.0.0
 *
 * @package    Advanced_Gift_Wrapper
 * @subpackage Advanced_Gift_Wrapper/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Advanced_Gift_Wrapper
 * @subpackage Advanced_Gift_Wrapper/includes
 * @author     Vishal Kakadiya <vishalkakadiya123@gmail.com>
 */
class AGW_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	    
	    $term = term_exists( AGW_POST_TERM, AGW_POST_TAXONOMY );
	    if ( $term === null ) {
		wp_insert_term(
			'Gift Wrap',
			AGW_POST_TAXONOMY,
			array(
				'description' 	=> __( 'This category is for gift wrap products, which will display as an option to user on cart page', 'woocommerce' ),
				'slug' 			=> AGW_POST_TERM,
			  )
		);
	    }
	}

}
