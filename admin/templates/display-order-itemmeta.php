<?php

/**
 * Display gift form fields data which user enter on front-end side,
 * while placing order.
 *
 * Display order item's metadata for gift wrapper item.
 *
 * @see 	   AGW_Admin::display_order_itemmeta()
 * @link       http://profiles.wordpress.org/vishalkakadiya/
 * @since      1.0.0
 *
 * @package    Advanced_Gift_Wrapper
 * @subpackage Advanced_Gift_Wrapper/admin/templates
 */

$wrap_details = wc_get_order_item_meta( $item_id, 'agw_gift_wrap_details', true );

if ( isset( $wrap_details ) && ! empty( $wrap_details ) ) {

	if ( ! empty( $wrap_details['vk_agw_photo'] ) ) { ?>
		<br />
		<a href="<?php echo $wrap_details['vk_agw_photo'];?>" download>
			<img class="vk-agw-gift-image" src="<?php echo $wrap_details['vk_agw_photo'];?>" />
		</a><?php
	}

	if ( ! empty( $wrap_details['vk_agw_to_name'] ) ) { ?>
		<h4 class="vk-agw-gift-to-name">
			<?php echo __( 'To : ', 'woocommerce' ) . $wrap_details['vk_agw_to_name'];?>
		</h4><?php
	}

	if ( ! empty( $wrap_details['vk_agw_message'] ) ) { ?>
		<p class="vk-agw-gift-message">
			<?php echo __( 'Message : ', 'woocommerce' ) . $wrap_details['vk_agw_message'];?>
		</p><?php
	}

	if ( ! empty( $wrap_details['vk_agw_from_name'] ) ) { ?>
		<h4 class="vk-agw-gift-from-name">
		    <?php echo __( 'From : ', 'woocommerce' ) . $wrap_details['vk_agw_from_name'];?>
		</h4><?php
	}
}