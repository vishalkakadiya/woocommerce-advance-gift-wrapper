<?php

/**
 * Display gift products in form format to select user gift type
 * product from that. It is available on end of woocommerce cart page.
 *
 * Display form to select particular gift wrap product on cart page.
 * 
 * @see 	   AGW_Public::display_gift_form()
 * @link       http://profiles.wordpress.org/vishalkakadiya/
 *
 * @package    Advanced_Gift_Wrapper
 * @subpackage Advanced_Gift_Wrapper/public/templates
 * @since      1.0.0
 */

 ?>

<?php if ( $gift_cards->have_posts() ) : ?>

	<div class="agw-wrapper">
		<form id="agw-gift-shop-form" method="post" enctype="multipart/form-data"  class="form-horizontal" novalidate   >
			<div class="agw-gift-products">
				<?php
				while ( $gift_cards->have_posts() ) : $gift_cards->the_post();
					$post_id = get_the_ID();
					$product = new WC_Product( $post_id ); ?>

					<div class="agw-gift-wrapper">
						<?php the_post_thumbnail( 'thumbnail' );?>
						<div class="agw-gift-wrap-price">
						    <input type="radio" name="vk_agw_wrap_type_id" value="<?php echo $post_id;?>" class="agw-gift-radio" id="agw-wrapper-image-<?php echo $post_id;?>" required />
						    <label for="agw-wrapper-image-<?php echo $post_id;?>"><?php echo wc_price( $product->price );?></label>
						</div>
					</div><?php 
				endwhile;
				wp_reset_postdata();
				?>
				<div id="agw-gift-type-error" class="agw-error"></div>
			</div>

			<div class="agw-gift-fields"><?php
				$enable_image_upload = get_option( '_vk_agw_enable_image_upload' );
				if ( 1 == $enable_image_upload ) {
					$agw_pic_price = get_option( '_vk_agw_pic_price' );?>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">
								<?php _e( 'Want to attach picture on gift wrapper (only extra : '. wc_price( $agw_pic_price ) .')', 'woocommerce' );?>
							</div>
							<input class="form-control" type="file" id="agw-image-field" name="vk_agw_image" />
						</div>
					</div>
					<div id="agw-image-error" class="agw-error"></div><?php
				}?>

				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<?php _e( 'To', 'woocommerce' );?>
						</div>
						<input type="text" name="vk_agw_to_name" placeholder="<?php _e( 'Dear...', 'woocommerce' );?>" class="form-control" id="agw-to-field" />
						<div id="agw-to-error" class="agw-error"></div>
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><?php _e( 'Message', 'woocommerce' );?></div>
						<textarea name="vk_agw_message" placeholder="<?php _e( 'Add your message here...', 'woocommerce' );?>"  class="form-control" id="agw-message-field" ></textarea>
						<div id="agw-message-error" class="agw-error"></div>
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><?php _e( 'From', 'woocommerce' );?></div>
						<input type="text" name="vk_agw_from_name" placeholder="<?php _e( 'Your ...', 'woocommerce' );?>"  class="form-control" id="agw-from-field"  />
						<div id="agw-from-error" class="agw-error"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<input type="submit" name="vk_agw_add_gift_wrap" class="btn btn-primary" value="<?php _e( 'Add Gift Wrap', 'woocommerce' );?>"  onclick="return agwValidateGiftForm()"  />
					</div>
				</div>
			</div>
		</form>
	</div>

<?php endif; ?>