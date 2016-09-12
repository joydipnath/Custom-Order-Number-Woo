<?php
/*
* Plugin Name: woo-commerce custom order number adding suffix and prefix
* Plugin URI : joydipme.com
* Description: A plugin to add Custom suffix and prefix to order number
* Version    : 1.0
* Author     : Joydip Nath
* License    : GPL2
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('woo_commerce_custom_order_number'))
{ 
    class woo_commerce_custom_order_number
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            
		require_once(sprintf("%s/templates/woocommerce-custom-order.php", dirname(__FILE__)));
			// register actions
                add_action('admin_init', array(&$this, 'admin_initialization'));
        	add_action('admin_menu', array(&$this, 'add_menu_'));
                // register actions
		add_filter( 'woocommerce_order_number', 'customize_order' , 1, 2 );
		add_action( 'wp_insert_post', 'maintain_sequence_order_number' , 10, 2 );
		
        } // END public function __construct
    
        

	/**
	 * add a menu
	 */     
	public function add_menu_()
	{
	    add_options_page('customize your order number', 'custom order number', 'manage_options', 'woo_commerce_custom_order_number', array(&$this, 'plugin_settings_page'));
	} // END public function add_menu()

	/**
	 * Menu Callback
	 */     
	public function plugin_settings_page()
	{
	    if(!current_user_can('manage_options'))
	    {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	    }

	    // Render the settings template
	    include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
	} // END public function plugin_settings_page()


		public function admin_initialization()
        	{
        	// register your plugin's settings
        	register_setting('wp_plugin_template-group_order_number', 'pre_order_A');
        	register_setting('wp_plugin_template-group_order_number', 'suf_order_A');        	
        	// add your settings section
        	add_settings_section(
        	    'joy_wp_plugin_order_number_template-section', 
        	    'Add your suffix and preffix to your order number', 
        	    array(&$this, 'settings_section_wp_plugin_template_order_number'), 
        	    'woo_commerce_custom_order_number'
        	);
        	
        	// add your setting's fields
            add_settings_field(
                'wp_plugin_template_prefix', 
                'Preffix', 
                array(&$this, 'settings_field_input_text_for_order_number'), 
                'woo_commerce_custom_order_number', 
                'joy_wp_plugin_order_number_template-section',
                array(
                    'field' => 'pre_order_A'
                )
            );
            add_settings_field(
                'wp_plugin_template_suffix', 
                'Suffix', 
                array(&$this, 'settings_field_input_text_for_order_number'), 
                'woo_commerce_custom_order_number', 
                'joy_wp_plugin_order_number_template-section',
                array(
                    'field' => 'suf_order_A'
                )
            );
            
            // Possibly do additional admin_init tasks
        } // END public static function activate

	public function settings_section_wp_plugin_template_order_number()
        {
            // Think of this as help text for the section.
            echo 'Set the values for adding pressix and suffix to order number ';
        }
        
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text_for_order_number($args)
        {
            // Get the field name from the $args array
            $field_1 = $args['field'];
            // Get the value of this setting
            $value_1 = get_option($field_1);
            // echo a proper input type="text"
            echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field_1, $field_1, $value_1);
        } // END public function settings_field_input_text($args)

    } // END class WP_Plugin_Template
} // END if(!class_exists('WP_Plugin_Template'))

if(class_exists('woo_commerce_custom_order_number'))
{
    // instantiate the plugin class
    $woo_commerce_custom_order_number = new woo_commerce_custom_order_number();
}
if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}
?>
