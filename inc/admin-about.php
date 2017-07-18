<?php

/**
 * Title: About
*
* Description: Displays list of all CyberChimps theme linking to it's pro and free versions.
*
* Please do not edit this file. This file is part of the CyberChimps Framework and all modifications
* should be made in a child theme.
*
* @category CyberChimps Framework
* @package  Framework
* @since    1.0
* @author   CyberChimps
* @license  http://www.opensource.org/licenses/gpl-license.php GPL v3.0 (or later)
* @link     http://www.cyberchimps.com/
*/

// Add stylesheet and JS for upsell page.
function cyberchimps_about_style() {

	// Set template directory uri
	$directory_uri = get_template_directory_uri();


	wp_enqueue_style( 'about_style', get_template_directory_uri() . '/css/about.css' );

}

// Add upsell page to the menu.
function cyberchimps_add_about() {
	$page = add_theme_page(
			'About Altitude Lite',
			'About Altitude Lite',
			'administrator',
			'cyberchimps-responsive',
			'cyberchimps_display_about'
	);

	add_action( 'admin_print_styles-' . $page, 'cyberchimps_about_style' );
}

add_action( 'admin_menu', 'cyberchimps_add_about' );

// Define markup for the upsell page.
function cyberchimps_display_about() {

	// Set template directory uri
	$theme      = wp_get_theme();
	?>
	<div class="about-container">

		<div class="about-info">
			<h1><?php echo "Altitude Lite - ".$theme['Version'] ?></h1>
			<?php
				$directory_uri = get_template_directory_uri();

			?>
			<span><img src="<?php echo $directory_uri ?>/images/logo.png"></span>
			<?php printf( '<p>Altitude Lite is a responsive sleek mobile first design embodying sheer beauty. This Free WordPress theme features the theme customizer for live theme options, a beautiful parallax header image, custom logo, sharp typography, and looks amazing on mobile devices.'
			); ?>
		</div>

		<div class="features">
			<table class="features-table">
			<thead>
			<tr>
				<th class=""></th>
				<th>Altitude Lite</th>
				<th>Altitude</th>
			</tr>

			<tr>
			<td class="feature">Responsive layout <p>Works on every device</p></td>
			<td class="featureyes"><span class='dashicons-before dashicons-yes'></span></td>
			<td class="featureyes"><span class='dashicons-before dashicons-yes'></span></td>
			</tr>
			<tr>
			<td class="feature">Parallax effect for header image</td>
			<td class="featureyes"><span class="dashicons-before dashicons-yes"></span></td>
			<td class="featureyes"><span class='dashicons-before dashicons-yes'></span></td>
			</tr>

			<tr>
			<td class="feature">Custom Menus</td>
			<td class="featureyes"><span class="dashicons-before dashicons-yes"></span></td>
			<td class="featureyes"><span class='dashicons-before dashicons-yes'></span></td>
			</tr>
			<tr>
			<td class="feature">Featured Area with text and call to action button</td>
			<td class="featureyes"><span class="dashicons-before dashicons-no-alt"></span></td>
			<td class="featureno"><span class='dashicons-before dashicons-yes'></span></td>
			</tr>


						<tr>
						<td class="feature">Social Media Options</td>
						<td class="featureyes"><span class="dashicons-before dashicons-no-alt"></span></td>
						<td class="featureno"><span class='dashicons-before dashicons-yes'></span></td>
						</tr>

			<tr>
			<td class="feature">High Priority Support via Helpdesk</td>
			<td class="featureyes"><span class="dashicons-before dashicons-no-alt"></span></td>
			<td class="featureno"><span class='dashicons-before dashicons-yes'></span></td>
			</tr>


			</thead>
			</table>
		</div>
		<div class="buy">
		<a class="button button-primary buylink" target="_blank" href="https://cyberchimps.com/store/altitude/?utm_source=about">Buy Altitude</a>
		</div>
	</div>
<?php
}
