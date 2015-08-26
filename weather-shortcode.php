<?php

/*
	Plugin Name: Weather Shortcode
	Description: Weather plugin will show the weather in your city with beautiful icons. Displays shortcode.
	Version: 1.0
	Author: Roman Barbotkin 


	This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

    register_activation_hook( __FILE__, 'ms_activate' );
    register_deactivation_hook(__FILE__, 'ms_deactivation');


    // function activate
	function ms_activate() {
		register_deactivation_hook(__FILE__, 'ms_deactivation');
		$wcode = get_option( 'ms-weather-code' );
		if(empty($wcode)){
			add_option('ms-weather-code', 'FRXX0076');
		}else{
			update_option('ms-weather-code', $_POST['weather-code'] );
		}
	}

	// function deactivate
	function ms_deactivation() {  
		delete_option('ms-weather-code');
	}

	// languages
	function load_plugin() {
	  load_plugin_textdomain( 'ms-weather-plugin', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	add_action( 'init', 'load_plugin' );

    // register js and css
	function register() { 
	 // register js
	 wp_register_script( 'custom-js', plugins_url( '/asset/main.js', __FILE__ ), array(), '1.0', 'all' ); 
	 wp_enqueue_script( 'custom-js' );

	 // register style
	 // font
	 wp_register_style( 'ms-weather-font', plugins_url( '/asset/weather-icons.css', __FILE__ ), array(), '1.0', 'all' ); 
	 wp_enqueue_style( 'ms-weather-font' ); 

	} 

	add_action( 'wp_enqueue_scripts', 'register');


	// action function for above hook
	function ms_add_pages() {
	     add_submenu_page('options-general.php', __('Weather shortcode'), __('Weather shortcode'), 'manage_options', 'ms-weather', 'ms_page');
	}
	// Hook for adding admin menus
	add_action('admin_menu', 'ms_add_pages');

	function ms_page() {
	   echo "<h3>" . __( 'Weather Plugin', 'ms-weather-plugin' ) . "</h3>";

		if(empty($_POST)){
			add_option('ms-weather-code', $_POST['weather-code'] );
		}else{
			update_option('ms-weather-code', $_POST['weather-code'] );
		}

		$wcode = get_option( 'ms-weather-code' );
		$code = '<?php echo do_shortcode("[ms-weather]""); ?>';
	   ?>
	   <form action="" method="post">
	  	<table class="form-table">
		<tbody>
		<tr>
			<p class="description"><?php echo __('You can display the weather temperature for your location.', 'ms-weather-plugin' );?>
			 <br><a href="http://edg3.co.uk/snippets/weather-location-codes/">Go to this website</a> 
				enter your city and press search. <br>Copy and paste in the following field the code. <br>For example for Paris: <strong>FRXX0076</strong>  </p>
		</tr>
		<tr>To add a weather display, use shortcode: <code>[ms-weather]</code><br></tr>
		<tr><br>Use php: <code><?php echo esc_textarea($code); ?></code></tr>
		<tr>
			<th scope="row"><label for="blogname">Weater code</label></th>
			<td><input name="weather-code" id="weather-code" value="<?php echo $wcode;?>" class="regular-text" type="text">
		</td>
		</tr>
		</tbody>
		</table>
		<p class="submit">
			<input name="submit" id="submit" class="button button-primary" value="Save" type="submit">
		</p>
		</form>
	<?php
	}  

	function shortcode(){
		$wcode = get_option( 'ms-weather-code' );
		?>
		<div id="weather">
			<div class="ms-weather-code" id="<?php echo $wcode; ?>"></div>
			<i class="ms-icon"></i>
			<span id="ms-loc"></span>
			<span id="ms-weather"></span>
		</div>
		<?php
	}

	add_shortcode('ms-weather', 'shortcode');    





