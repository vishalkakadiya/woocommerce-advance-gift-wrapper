<?php

/**
 * Display backend options on settings page, in "WC - Gift Wrap" menu tab.
 *
 * @see 		AGW_Admin::display_settings()
 * @link        http://profiles.wordpress.org/vishalkakadiya/
 *
 * @package    	Advanced_Gift_Wrapper
 * @subpackage 	Advanced_Gift_Wrapper/admin/templates
 * @since      	1.0.0
 */

$enable_gift_wrap = get_option( '_vk_agw_enable_gift_wrap' );
$gift_in_shop = get_option( '_vk_agw_enable_gift_in_shop' );
$enable_image_upload = get_option( '_vk_agw_enable_image_upload' );
$pic_price = get_option( '_vk_agw_pic_price' );

$gift_wrap = ( $enable_gift_wrap == 1 ) ? 'checked="checked"' : '';
$gift_in_shop_checked = ( $gift_in_shop == 1 ) ? 'checked="checked"' : '';
$image_upload_checked = ( $enable_image_upload == 1 ) ? 'checked="checked"' : '';?>

<div class="wrap">
	<h1 class="agw-gift-setting-title"><?php _e( 'Gift Wrap Settings', 'woocommerce' );?></h1>

	<form method="post">
		<table cellspacing="23">

			<tr>
				<td><?php _e( 'Gift-wrap feature: ', 'woocommerce' ); ?></td>
				<td colspan="2">
					<input type="checkbox" <?php echo $gift_wrap;?> name="vk_agw_enable_gift_wrap" id="vk-agw-enable-gift-wrap"> 
					<label for="vk-agw-enable-gift-wrap"><?php _e( 'Enable feature', 'woocommerce' ); ?></label>
				</td>
				<td><span><?php _e( 'Enable gift wrap feature', 'woocommerce' );?></span></td>
			</tr>

			<tr>
				<td><?php _e( 'On shop page: ', 'woocommerce' ); ?></td>
				<td colspan="2">
					<input type="checkbox" <?php echo $gift_in_shop_checked;?> name="vk_agw_enable_gift_in_shop" id="agw-gift-wrap-shop"> 
					<label for="agw-gift-wrap-shop"><?php _e( 'Enable on shop', 'woocommerce' ); ?></label>
				</td>
				<td><span><?php _e( 'Checked if gift wrap product show on shop page, unchecked to not display.', 'woocommerce' );?></span></td>
			</tr>

			<tr>
				<td><?php _e( 'Enable image upload feature from user: ', 'woocommerce' ); ?></td>
				<td colspan="2">
					<input type="checkbox" <?php echo $image_upload_checked;?> name="vk_agw_enable_image_upload" id="vk-agw-enable-image-upload"> 
					<label for="vk-agw-enable-image-upload"><?php _e( 'Enable', 'woocommerce' ); ?></label>
				</td>
				<td><span><?php _e( 'Checked to enable customer to upload pic which is visible on gift wrap.', 'woocommerce' );?></span></td>
			</tr>

			<tr>
				<td><?php _e( 'Price to print customer\'s pic on gift wrap: ', 'woocommerce' ); ?></td>
				<td><input type="number" value="<?php echo $pic_price;?>" name="vk_agw_pic_price" /></td>
				<td><span><?php _e( 'in($)', 'woocommerce' );?></span></td>
			</tr>

			<tr>
				<td colspan="3">
					<input name="vk_agw_save_gift_wrap" type="submit" class="button button-primary" value="<?php _e( 'Save Settings', 'woocommerce' );?>" />
				</td>
			</tr>
		</table>
	</form>
</div>