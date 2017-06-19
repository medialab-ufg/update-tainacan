<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Update_Tainacan
 * @subpackage Update_Tainacan/admin
 * @author     Marcus Molinari <mbrunodm@gmail.com>
 */
class Update_Tainacan_Admin {

    public $links = [
        'ibram-tainacan' => 'https://github.com/medialab-ufg/ibram-tainacan/archive/master.zip',
        'data_aacr2' => 'https://github.com/medialab-ufg/data_aacr2/archive/master.zip',
        'tainacan' => 'https://github.com/medialab-ufg/tainacan/archive/dev.zip'
    ];
    public $branches = [
        'ibram-tainacan' => 'master',
        'data_aacr2' => 'master',
        'tainacan' => 'dev'
    ];

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/update-tainacan-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/update-tainacan-admin.js', array('jquery'), $this->version, false);
    }

    /**
     * Register Update_Tainacan's option link at wordpress admin panel
     *
     * @since    1.0.0
     */
    public function add_update_tainacan_menu() {
        add_options_page('Update Tainacan Plugin', 'Update Tainacan Config', 'manage_options', $this->plugin_name, array($this, 'display_update_setup_page'));
    }

    /**
     * Adds Update_Tainacan's settings shortcut at plugins' list
     *
     * @since    1.0.0
     */
    public function add_action_links($links) {
        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);
    }

    /**
     * Loads admin internal pages
     *
     * @since    1.0.0
     */
    public function display_update_setup_page() {
        include_once( 'partials/class-update-tainacan-helper.php' );
        include_once( 'partials/update-tainacan-admin-display.php' );
    }

    public function options_update() {
        //var_dump($_POST);
        if (isset($_POST['action'])):
            $Plugins = (isset($_POST['update_plugins']) ? $_POST['update_plugins'] : null);
            $Themes = (isset($_POST['update_themes']) ? $_POST['update_themes'] : null);

            if ($Plugins):
                foreach ($Plugins as $Plugin):
                    $this->do_update($Plugin, 'plugins', $_POST['update-tainacan'][$Plugin]);
                endforeach;
            endif;

            if ($Themes):
                foreach ($Themes as $Theme):
                    $this->do_update($Theme, 'themes', $_POST['update-tainacan'][$Theme]);
                endforeach;
            endif;

        endif;
    }

    private function recursiveRemoveDirectory($directory) {
        if (is_dir($directory)) {
            foreach (glob("{$directory}/{,.}[!.,!..]*", GLOB_MARK | GLOB_BRACE) as $file) {
                if (is_dir($file)) {
                    $this->recursiveRemoveDirectory($file);
                } else {
                    @unlink($file);
                }
            }
            @rmdir($directory);
        }
    }

    private function do_update($plugin, $folder, $plugin_file) {
//        var_dump($plugin, $folder, $plugin_file);
//        exit();
        if (!empty($plugin_file)):
            $Link = (isset($this->links[$plugin]) ? $this->links[$plugin] : null);
            if ($Link):
                //file_put_contents(dirname(__FILE__) . "../../../../" . $folder . "/" . $plugin . "/Tmpfile.zip", file_get_contents($Link));
                $Tmpfile = dirname(__FILE__) . "../../../../" . $folder . "/Tmpfile.zip";
                $Path = dirname(__FILE__) . "../../../../" . $folder . "/";
                file_put_contents($Tmpfile, file_get_contents($Link));

                $zip = new ZipArchive;
                $res = $zip->open($Tmpfile);
                if ($res === TRUE):
                    $time = time();
                    if ($zip->extractTo($Path)):
                        rename($Path . $plugin, $Path . $plugin . '_BKP_' . $time);
                        rename($Path . $plugin . '-' . $this->branches[$plugin], $Path . $plugin);
                    endif;
                    $zip->close();

                    if (is_dir($Path . $plugin . '_BKP_' . $time)):
                        $this->recursiveRemoveDirectory($Path . $plugin . '_BKP_' . $time);
                    endif;

                    unlink($Tmpfile);
                    echo '<script>alert("Sucesso! Dados atualizados com sucesso.");</script>';
                else:
                    //ERRO
                    echo '<script>alert("Erro! Erro ao atualizar, verifique as configurações do plugin.");</script>';
                endif;
            endif;
        endif;

        //file_put_contents("Tmpfile.zip", file_get_contents("http://someurl/file.zip"));
    }

}
