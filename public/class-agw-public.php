<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://profiles.wordpress.org/vishalkakadiya/
 * @since      1.0.0
 *
 * @package    Advanced_Gift_Wrapper
 * @subpackage Advanced_Gift_Wrapper/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advanced_Gift_Wrapper
 * @subpackage Advanced_Gift_Wrapper/public
 * @author     Vishal Kakadiya <vishalkakadiya123@gmail.com>
 */
class AGW_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

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
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0.0
	 * @param    string    $plugin_name       The name of the plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/*
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// Plugin CSS
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-gift-wrapper-public.css', array(), $this->version, 'all' );

		// Bootstrap CSS
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// Plugin JS
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-gift-wrapper-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Manage gift products on shop page.
	 *
	 * `Enable on shop page` options is checked on backend then display 
	 * products of gift wrapper category on the shop page, otherwise not.
	 * 
	 * @since 1.0.0
	 *
	 * @param WP_Query $query WP_Query object.
	 */
	public function modify_product_query( $query ) {

		if ( ! $query->is_main_query() ) { return; }
		if ( ! $query->is_post_type_archive() ) { return; }

		if ( ! is_admin() && is_shop() ) {
			$gift_in_shop = get_option( '_vk_agw_enable_gift_in_shop' );
			if ( 1 != $gift_in_shop ) {
				$query->set( 'tax_query', array( 
					array(
						'taxonomy' 	=> $this->taxonomy,
						'field' 	=> 'slug',
						'terms' 	=> array( AGW_POST_TERM ),
						'operator' => 'NOT IN',
					),
				));
			}
		}
	}


	/**
	 * Prime the cache for the top 10 most-commented posts.
	 *
	 * @see get_gift_wrap_cache()
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id Post ID.
	 * @param int $post    Post Object
	 */
	function update_gift_wrap_cache( $post_id, $post ) {
		if ( 'product' == $post->post_type ) {
			$product_terms = get_the_terms( $post, $this->taxonomy );

			if ( ! empty( $product_terms ) ) {
				foreach ($product_terms as $product_term ) {

					if ( $this->agw_term == $product_term->slug ) {
						// Force the cache refresh for Gift wrap posts.
						$this->get_gift_wrap_cache( true );
					}
				}
			}
		}
	}

	/**
	 * Retrieve posts of 'Gift' product category term
	 * and cache results.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $force_refresh Optional. Whether to force the cache 
	 * 							  to be refreshed. Default false.
	 * @return array|WP_Error Array of WP_Post objects with `Gift`
	 * 						  product category term, WP_Error object otherwise.
	 */
	function get_gift_wrap_cache( $force_refresh = false ) {
	    // Check for the agw_gift_wrap_posts key in the 'agw_posts' group.
	    $gift_wrap_posts = wp_cache_get( 'agw_gift_wrap_posts', 'agw_posts' );

	    // If nothing is found, build the object.
	    if ( true === $force_refresh || false === $gift_wrap_posts ) {
	        // Grab posts with `Gift` product category term.
	        $gift_wrap_posts = new WP_Query( array(
				'post_type'				=> 'product',
				$this->taxonomy		    => $this->agw_term,

				// Some important pramas
				'no_found_rows'		    	=> true, // In our case pagination isn't needed
				// 'update_post_meta_cache'    => false, // manage postmeta cache
				// 'update_post_term_cache'    => false  // manage term cache
			) );

	        if ( ! is_wp_error( $gift_wrap_posts ) && $gift_wrap_posts->have_posts() ) {
	            // In this case we don't need a timed cache expiration.
	            wp_cache_set( 'agw_gift_wrap_posts', $gift_wrap_posts, 'agw_posts' );
	        }
	    }
	    return $gift_wrap_posts;
	}


	/**
	 * Display gift wrapper form.
	 * 
	 * Get data from cache, and Display gift wrapper form at bottom of 
	 * woocommerce cart page.
	 * 
	 * @see get_gift_wrap_cache()
	 * 
	 * @since 1.0.0
	 */
	public function display_gift_form() {
		$enable_gift_wrap = get_option( '_vk_agw_enable_gift_wrap' );
		if ( 1 == $enable_gift_wrap ) {

			if ( empty( WC()->session->get( 'agw_gift_wrap_details' ) ) ) {

				$gift_cards = $this->get_gift_wrap_cache();
				/**
				 * Display form to select particular gift wrap product on cart page.
				 */
				include_once 'templates/display-options.php';
			}
		}
	}

	/**
	 * Add selected gift product to cart, and add form data to it's metadata, 
	 * when order is placed that metadata will add with particular order.
	 * 
	 * @since 1.0.0
	 */
	function set_session_data() {
		if ( isset( $_POST['vk_agw_add_gift_wrap'] ) ) {
			if ( ! empty( $_POST['vk_agw_wrap_type_id'] ) ) {
				$agw_wrap_type_id = intval( $_POST['vk_agw_wrap_type_id'] );

				// Adding selected gift wrap product in cart.
				WC()->cart->add_to_cart( $agw_wrap_type_id, 1 );

				// Image upload logic
				$photo_url = '';
				if ( ! empty( $_FILES['vk_agw_image'] ) && $_FILES['vk_agw_image']['error'] == 0 ) {
					if ( ! function_exists( 'wp_handle_upload' ) ) {
						require_once( ABSPATH . 'wp-admin/includes/file.php' );
					}

					$uploadedfile = $_FILES['vk_agw_image'];
					$upload_overrides = array( 'test_form' => false );
					$uploaded_photo = wp_handle_upload( $uploadedfile, $upload_overrides );

					if ( $uploaded_photo && ! isset( $uploaded_photo['error'] ) ) {
						$photo_url = $uploaded_photo['url'];
					} else {
						wc_add_notice( __( 'Due to some error your photo can\'t upload', 'woocommerce' ), 'error' );
					}
				}

				// Validating fields
				$vk_agw_to_name = sanitize_text_field( $_POST['vk_agw_to_name'] );
				$vk_agw_message = sanitize_text_field( $_POST['vk_agw_message'] );
				$vk_agw_from_name = sanitize_text_field( $_POST['vk_agw_from_name'] );

				// Adding data into session.
				WC()->session->set(
					'agw_gift_wrap_details',
					array(
						'vk_agw_wrap_type_id'	=> $agw_wrap_type_id,
						'vk_agw_to_name'		=> $vk_agw_to_name,
						'vk_agw_message'		=> $vk_agw_message,
						'vk_agw_from_name'		=> $vk_agw_from_name,
						'vk_agw_photo'			=> $photo_url,
					)
				);
			} else {
				wc_add_notice( __( 'Please select any gift product from gift list.', 'woocommerce' ), 'error' );
			}
		}
	}

	/**
	 * Add extra price of gift wrap product, if picture is uploaded to
	 * print on gift box.
	 * 
	 * @since 1.0.0
	 * 
	 * @param Object $cart_object WC_Cart-Object All details of cart items.
	 */
	function change_product_price( $cart_object ) {
	    
		$wrap_details = WC()->session->get( 'agw_gift_wrap_details' );
		if ( ! empty( $wrap_details ) ) {
			if ( ! empty( $wrap_details['vk_agw_photo'] ) ) {
				$price = get_option( '_vk_agw_pic_price' );

				foreach ( $cart_object->cart_contents as $key => $value ) {
					if ( $wrap_details['vk_agw_wrap_type_id'] == $value['product_id'] ) {
						$value['data']->post->post_title .= __( '(incluing picture charges)', 'woocommerce' );

						$value['data']->price = $value['data']->price + $price;
					}
				}
			}
		}
	}

	/**
	 * Remove data from session, if gift product is removed from cart.
	 * 
	 * @since 1.0.0
	 * 
	 * @param string $cart_item_key Uniq key of each cart item.
	 * @param WC_Cart $cart Object of woocommerce cart.
	 */
	function remove_session_data( $cart_item_key, $cart ) {
		$product_id = $cart->cart_contents[ $cart_item_key ]['product_id'];
		$wrap_details = WC()->session->get( 'agw_gift_wrap_details' );
		if ( ! empty( $wrap_details ) ) {
			if ( $product_id == $wrap_details['vk_agw_wrap_type_id']  ) {

				// Removing custom data from session
				WC()->session->__unset( 'agw_gift_wrap_details' );
			}
		}
	}

	/**
	 * Preventing to add more than one gift products, 
	 * only one gift wrap product is allowed per order. 
	 * 
	 * @since 1.0.0
	 * 
	 * @param boolean $return.
	 * @param WC_Product_Simple $product Object of product post-type.
	 * @return boolean true/$return Return TRUE if second gift product in 
	 * 								same order, Otherwise return `$return`.
	 */
	function disable_quantity_update( $return, $product ) {
		$wrap_details = WC()->session->get( 'agw_gift_wrap_details' );
		if ( ! empty( $wrap_details ) ) {
			if ( $product->id == $wrap_details['vk_agw_wrap_type_id']  ) {
				return true;
			}
		}

		return $return;
	}

	/**
	 * Get data from session and add into order metadata for gift type
	 * order item.
	 * 
	 * @since 1.0.0
	 * 
	 * @param int $item_id Post ID of product post-type.
	 * @param array $values Array of item meta in cart.
	 */
	function add_order_item_meta( $item_id, $values ) {
		$wrap_details = WC()->session->get( 'agw_gift_wrap_details' );
		if ( ! empty( $wrap_details ) ) {
			if ( $wrap_details['vk_agw_wrap_type_id'] == $values['product_id'] ) {
				wc_add_order_item_meta( $item_id, 'agw_gift_wrap_details', $wrap_details );
			}
		}
	}

	/**
	 * Remove data from session, when cart becomes empty.
	 * 
	 * @since 1.0.0
	 */
	function destroy_session() {
		if ( ! empty( WC()->session->get( 'agw_gift_wrap_details' ) ) ) {
			WC()->session->__unset( 'agw_gift_wrap_details' );
		}
	}

}
