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
	 * Gift wrap term
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string     custom-term slug
	 */
	private $agw_term = 'agw-gift-wrap';

	/**
	 * Product category
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string     custom-term slug
	 */
	private $taxonomy = 'product_cat';


	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

	    $term = term_exists( $this->agw_term, $this->taxonomy );
	    if ( $term === null ) {
			wp_insert_term(
				'Gift Wrap',
				$this->taxonomy,
				array(
					'description' 	=> __( 'This category is for gift wrap products, which will display as an option to user on cart page', 'woocommerce' ),
					'slug' 			=> $this->agw_term,
				  )
			);
	    }
	}

}
