<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Update_Tainacan
 * @subpackage Update_Tainacan/includes
 * @author     Marcus Molinari <mbrunodm@gmail.com>
 */
class Update_Tainacan_i18n {

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
                'update-tainacan', false, dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }

}
