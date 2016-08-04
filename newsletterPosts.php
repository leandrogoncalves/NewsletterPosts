<?php
/**
 * Plugin Name: Get Remote Posts
 * Description: Recupera posts remotos
 * Version: 1.0
 * Author: Leandro
 * Author URI http://github.com/leandrogocnalves
 */

class Get_remote_posts
{

    /**
     * Capability name
     *
     * @var string
     */
    private $_capability = 'GRP_manager_cap';

    /**
     * Option name
     *
     * @var string
     */
    private $_option_name = 'GPP_options';

    /**
     * Get_remote_posts constructor.
     * Contain all action for plugin work
     */
     public function __construct()
    {
        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            wp_die(__("This plugin require the PHP version 5.3.0 or later ", 'grp_plugin'));
        }
        add_action( 'init', array( &$this, 'textdomain') );
        add_action('admin_menu', array(&$this, 'admin_menu'));
        $this->_create_capability();
        $this->_create_options();
    }

//    public function activation()
//    {
////        wp_die('plugin instalado');
//    }

//    public function deactivation()
//    {
////        wp_die('plugin desinstalado');
//    }

    /**
     * admin menu create
     * @return void
     */
    public function admin_menu()
    {
        if ( function_exists( 'add_menu_page' ) ){
            add_menu_page(
                __('Remote data','grp_plugin'),
                __('Remote data','grp_plugin'),
                'GRP_manager_cap',
                'grp-plugin',
                array(&$this, 'options_form'),
                'dashicons-tickets',
                2
            );
        }
    }


    
    /**
     * show plugin main page
     */
    public function options_form()
    {
        echo 'formulario';
    }

    /**
     * Load i18n
     */
    public function textdomain()
    {
        load_plugin_textdomain( 'grp_plugin', false , '/'. dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }


    /**
     * Create the capability
     */
    private function _create_capability()
    {
        $role = get_role('administrator');

        if( !$role->has_cap( $this->_capability ) )  $role->add_cap($this->_capability );
    }

    /**
     * Create the options
     */
    private function _create_options()
    {
        $options = get_option( $this->_option_name );

        if(is_array($options)){
            extract( $options, EXTR_SKIP );
        }

        if( $options ){
            $update_opt = array(
                'source_id'                 => ( $source_id ) ? $source_id : '',
                'country_code'              => ( $country_code ) ? $country_code : 'BR',
            );
            update_option( $this->_option_name, $update_opt );
        }
        else
        {
            $add_opt = array(
                'source_id'       => '',
                'country_code'    => '',
            );
            add_option( $this->_option_name, $add_opt );
        }
    }

}

$plugin_Get_remote_posts = new Get_remote_posts();

//register_activation_hook(__FILE__, array($plugin_Get_remote_posts, 'activation'));
//register_deactivation_hook(__FILE__, array($plugin_Get_remote_posts, 'deactivation'));