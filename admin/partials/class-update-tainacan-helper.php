<?php

/**
 * This class defines helper code that is used at admin partials
 *
 * @since      1.0.0
 * @package    Update_Tainacan_Helper
 * @subpackage Update_Tainacan/admin/partials
 * @author     Marcus Molinari <mbrunodm@gmail.com>
 */
class Update_Tainacan_Helper extends Update_Tainacan {

    public $plugins = [
        'ibram-tainacan' => 'https://github.com/medialab-ufg/ibram-tainacan/archive/master.zip',
        'data_aacr2' => 'https://github.com/medialab-ufg/data_aacr2/archive/master.zip'
    ];
    public $themes = [
        'tainacan' => 'https://github.com/medialab-ufg/tainacan/archive/dev.zip'
    ];

    public function get_selected_opts($type) {
        if ($type == 'plugins'):
            $Plugins = get_plugins();
            foreach ($Plugins as $Key => $Plugin) {
                echo '<option value="' . $Key . '">' . $Plugin['Name'] . '</option>';
            }
        else:
            $Themes = wp_get_themes();
            foreach ($Themes as $Key => $Theme) {
                $ThemeInfo = wp_get_theme($Key);
                echo '<option value="' . $Key . '">' . $ThemeInfo->get('Name') . '</option>';
            }
        endif;
    }

}
