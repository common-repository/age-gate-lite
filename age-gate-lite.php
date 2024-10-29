<?php
/*
Plugin Name: Age Gate Lite
description: A lightweight, customisable age gate to lock content from younger audience.
Version: 0.0.7
Author: siddhu09rocks
Author URI: https://www.phenomcraftstudios.com/
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
	
if ( ! class_exists( 'AGE_GATE_LITE' ) ) {
	
	load_plugin_textdomain( 'age-gate-lite', false, dirname( plugin_basename( __FILE__ ) ) . '/' );

	class AGE_GATE_LITE {
		public function __construct() {

			add_action( 'wp_head', array( &$this, 'agl_functions' ), 20 );			
			
			// indicates we are running the admin
			if ( is_admin() ) {
				include( 'age-gate-lite-settings.php' );
			}

		}

		public function agl_functions() {

			
			$agl_logo_img =  ( get_option('agl_logo_img') ? '<img src="'.get_option('agl_logo_img').'">' : '') ;
			$cookie_days =  ( get_option('agl_cookie_days') ? get_option('agl_cookie_days') : 'null') ;
			$agl_primary_color =  ( get_option('agl_primary_color') ? get_option('agl_primary_color') : '#ff6c2d') ;
			$agl_title_color =  ( get_option('agl_title_color') ? get_option('agl_title_color') : '#000000') ;
			$agl_age_limit =  ( get_option('agl_age_limit') ? get_option('agl_age_limit') : '18') ;
			$agl_main_title =  ( get_option('agl_main_title') ? get_option('agl_main_title') : 'Are you old enough to be here?') ;
			$agl_description =  ( get_option('agl_description') ? get_option('agl_description') : 'You must be at least '.$agl_age_limit.' to enter this site') ;
			$agl_success_message =  ( get_option('agl_custom_success_message') ? get_option('agl_custom_success_message') : '') ;
			$agl_yes_btn_text =  ( get_option('agl_yes_btn_text') ? get_option('agl_yes_btn_text') : 'Yes') ;
			$agl_no_btn_text =  ( get_option('agl_no_btn_text') ? get_option('agl_no_btn_text') : 'No') ;
			$agl_safe_link =  ( get_option('agl_safe_link') ? get_option('agl_safe_link') : 'https://google.com') ;
			
			?>
			<style>
				.agl_wrapper {position: fixed;width: 100%;height: 100%;top: 0;left: 0;z-index: 1111111111;align-items: center;background: rgba(0, 0, 0, 0.75);}
				.agl_main {display: block;margin: 0 auto;text-align: center;background: #fff;max-width: 500px;width: 95%;padding: 30px;}
				div#agl_form img {max-width: 300px;}
				div#agl_form h2 {color: <?php echo $agl_title_color; ?>;}
				.agl_buttons {display: inline-block;vertical-align: middle;padding: 10px 20px;color: <?php echo $agl_primary_color; ?>;}
				.agl_success_message{display:none;}
				.agl_buttons_wrp {margin: 20px auto;}
				#agl_yes_button.agl_buttons {background: <?php echo $agl_primary_color; ?>;color: #fff !important;}
				#agl_close_link {color: <?php echo $agl_primary_color; ?>;cursor: pointer;}
			</style>
			<div id="agl_wrapper" class="agl_wrapper" style="display:none;">
				<div class="agl_main">
					<div id="agl_form" class="agl_form">						
						<?php echo $agl_logo_img; ?>						
						<h2><?php echo $agl_main_title; ?></h2>
						<?php echo $agl_description; ?>
						<div class="agl_buttons_wrp">
							<a href="javascript:void(0)" id="agl_yes_button" class="agl_buttons agl_yes_button"><?php echo $agl_yes_btn_text; ?></a>
							<a href="<?php echo $agl_safe_link; ?>" id="agl_no_button"  class="agl_buttons agl_no_button"><?php echo $agl_no_btn_text; ?></a>
						</div>
					</div>
					<?php if($agl_success_message != ''){ ?>
					<div id="agl_success_message" class="agl_success_message">
						<?php echo do_shortcode($agl_success_message); ?>
						<div><a id="agl_close_link" href="javascript:void(0)">continue to site</a></div>
					</div>
					<?php } ?>
				</div>
			</div>
			<script>
				(function() {

					

					function close_agl(){
							document.getElementById("agl_wrapper").style.display = "none";
					}

					function show_agl(){
						document.getElementById("agl_wrapper").style.display = "flex";						
					}

					function slide_agl_success_message(){
						document.getElementById("agl_form").style.display = "none";
						document.getElementById("agl_success_message").style.display = "block";
					}

					function setCookie_agl(cname,cvalue,exdays) {
						<?php
						if ( !get_option('agl_test_mode') ) {
							?>
								var d = new Date();
								var expires = "";

								if(exdays != null ){
									d.setTime(d.getTime() + (exdays*24*60*60*1000));
									expires = "expires=" + d.toGMTString() + ";";
								}
								
								document.cookie = cname + "=" + cvalue + ";" + expires + "path=/";

								
								if (window.CustomEvent && typeof window.CustomEvent === 'function') {
									var agl_event = new CustomEvent('agl_passed');
								} else {
									var agl_event = document.createEvent('CustomEvent');
									agl_event.initCustomEvent('agl_passed');
								}
								document.dispatchEvent(agl_event);


							<?php
						}	
						?>
					}
					function getCookie_agl(cname) {
						var name = cname + "=";
						var decodedCookie = decodeURIComponent(document.cookie);
						var ca = decodedCookie.split(';');
						for(var i = 0; i < ca.length; i++) {
							var c = ca[i];
							while (c.charAt(0) == ' ') {
								c = c.substring(1);
							}
							if (c.indexOf(name) == 0) {
								return c.substring(name.length, c.length);
							}
						}
						return "";
					}
					function checkCookie_agl() {
						var agl_cookie=getCookie_agl("agl_cookie");
						if (agl_cookie != "") {
							//  Cookie Exists
							close_agl();
						} else {
							// No Cookie
							show_agl()
						}
					}
					checkCookie_agl();

					<?php if($agl_success_message != ''){ ?>
					document.getElementById("agl_close_link").onclick = function(){
						close_agl()
					}
					<?php } ?>

					document.getElementById("agl_yes_button").onclick = function(){						
						setCookie_agl("agl_cookie", '<?php echo $agl_primary_color; ?>', <?php echo $cookie_days; ?>);
						<?php if($agl_success_message != ''){ ?>
							slide_agl_success_message()
						<?php } else { ?>
							close_agl()
						<?php } ?>
					}
					
					document.getElementById("agl_no_button").onclick = function(){						
						if (window.CustomEvent && typeof window.CustomEvent === 'function') {
							var agl_event = new CustomEvent('agl_failed');
						} else {
							var agl_event = document.createEvent('CustomEvent');
							agl_event.initCustomEvent('agl_failed');
						}
						document.dispatchEvent(agl_event);
					}


				})();
			</script>
			<?php
		}
	}

	// finally instantiate our plugin class and add it to the set of globals
	$GLOBALS['age-gate-lite'] = new AGE_GATE_LITE();
}