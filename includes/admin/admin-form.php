<?php
/**
 * Settings Page for Form Settings
 *
 * @package tecsb
 * @author mokchya
 */

?>
<div class="tecsb-admin-content-box">
	<div class="tecsb-admin-content-header">
		<h3><i class="tecsb-icon-wpforms header-icon"></i><?php esc_html_e( 'Form Settings', 'tecsb' ); ?></h3>
	</div>
	<div class="tecsb-admin-content-main">
		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-note">
				<?php esc_html_e( 'If none of the category is selected, it will subscribe a subscriber to all event categories.', 'tecsb' ); ?>
			</p>
			<p class="tecsb-onoff-switch">
				<?php $_status = $tecsb->function->return_check_yesno( 'tecsb_admin_category' ); ?>
				<?php $tecsb->function->tecsb_switch_button( 'tecsb_admin_category', 'green', $_status ); ?>
				<span class="label">
					<?php esc_html_e( 'Enable category selection?', 'tecsb' ); ?>
				</span>
			</p>
		</div>
		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
					<?php esc_html_e( 'Subscription Box Header Text', 'tecsb' ); ?>
			</p>
			<p class="tecsb-admin-content-info">
				<?php esc_html_e( '** If left empty "Notify Me" will be printed.', 'tecsb' ); ?>
			</p>
			<p>
				<input type="text" name="tecsb_header_text" placeholder="<?php esc_html_e( 'Notify Me', 'tecsb' ); ?>" value="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_header_text' ) ); ?>"/>
			</p>

		</div>
		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
				<?php esc_html_e( 'Subscription Box Sub Header Text', 'tecsb' ); ?>
			</p>
			<p class="tecsb-admin-content-info">
				<?php esc_html_e( '** If left empty "Notify me about any upcomig Events" will be printed.', 'tecsb' ); ?>
			</p>
			<p>
				<input type="text" name="tecsb_subheader_text" placeholder="<?php esc_html_e( 'Notify me about any upcomig Events', 'tecsb' ); ?>" value="<?php echo esc_attr( $tecsb->function->return_option_value( 'tecsb_subheader_text' ) ); ?>"/>
			</p>

		</div>
		<div class="tecsb-admin-content-main-sec">
			<p class="tecsb-admin-content-head">
				<?php esc_html_e( 'Select Form Theme', 'tecsb' ); ?>
			</p>
			<p class="tecsb-admin-content-info">
				<?php esc_html_e( '** Only applicable if used inside calendar page.', 'tecsb' ); ?>
			</p>
			<p>
				<?php $selected = $tecsb->function->return_option_value( 'tecsb_subscription_theme' ); ?>
				<div class="tecsb-radio-group">
					<div class="tecsb-radio green">
						<input type="radio" name="tecsb_subscription_theme" id="1" value="1" <?php echo ( '1' === $selected || empty( $selected ) ) ? 'checked' : ''; ?>/>
						<div class="design"></div>
					</div>
					<span class="tecsb-theme-holder">
						<span class="tecsb-th-color tecsb-bg-pbg default"></span>
						<span class="tecsb-th-color tecsb-bg-txt default"></span>
						<span class="tecsb-th-color tecsb-bg-pbtn default"></span>
						<span class="tecsb-th-color tecsb-bg-pcat default"></span>
					</span>
				</div>
				<div class="tecsb-radio-group">
					<div class="tecsb-radio green">
						<input type="radio" name="tecsb_subscription_theme" id="2" value="2" <?php echo ( '2' === $selected ) ? 'checked' : ''; ?>/>
						<div class="design"></div>
					</div>
					<span class="tecsb-theme-holder">
						<span class="tecsb-th-color tecsb-bg-pbg modern"></span>
						<span class="tecsb-th-color tecsb-bg-txt modern"></span>
						<span class="tecsb-th-color tecsb-bg-pbtn modern"></span>
						<span class="tecsb-th-color tecsb-bg-pcat modern"></span>
					</span>
				</div>
				<div class="tecsb-radio-group">
					<div class="tecsb-radio green">
						<input type="radio" name="tecsb_subscription_theme" id="3" value="3" <?php echo ( '3' === $selected ) ? 'checked' : ''; ?>/>
						<div class="design"></div>
					</div>
					<span class="tecsb-theme-holder">
						<span class="tecsb-th-color tecsb-bg-pbg mauve"></span>
						<span class="tecsb-th-color tecsb-bg-txt mauve"></span>
						<span class="tecsb-th-color tecsb-bg-pbtn mauve"></span>
						<span class="tecsb-th-color tecsb-bg-pcat mauve"></span>
					</span>
				</div>
				<div class="tecsb-radio-group">
					<div class="tecsb-radio green">
						<input type="radio" name="tecsb_subscription_theme" id="4" value="4" <?php echo ( '4' === $selected ) ? 'checked' : ''; ?>/>
						<div class="design"></div>
					</div>
					<span class="tecsb-theme-holder">
						<span class="tecsb-th-color tecsb-bg-pbg green"></span>
						<span class="tecsb-th-color tecsb-bg-txt green"></span>
						<span class="tecsb-th-color tecsb-bg-pbtn green"></span>
						<span class="tecsb-th-color tecsb-bg-pcat green"></span>
					</span>
				</div>
				<div class="tecsb-radio-group">
					<div class="tecsb-radio green">
						<input type="radio" name="tecsb_subscription_theme" id="5" value="5" <?php echo ( '5' === $selected ) ? 'checked' : ''; ?>/>
						<div class="design"></div>
					</div>
					<span class="tecsb-theme-holder">
						<span class="tecsb-th-color tecsb-bg-pbg space"></span>
						<span class="tecsb-th-color tecsb-bg-txt space"></span>
						<span class="tecsb-th-color tecsb-bg-pbtn space"></span>
						<span class="tecsb-th-color tecsb-bg-pcat space"></span>
					</span>
				</div>
		</div>
	</div>
</div>
