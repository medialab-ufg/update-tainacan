<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/medialab-ufg
 * @since      1.0.0
 *
 * @package    Update_Tainacan
 * @subpackage Update_Tainacan/admin/partials
 */
$helper = new Update_Tainacan_Helper();
?>

<div class="wrap">

    <h2> <?php echo esc_html(get_admin_page_title()); ?> - Tainacan </h2> <hr>

    <form action="" method="post" name="update_config">
        <p>
            <?php esc_attr_e("Select the plugins / themes you'd like to update", $this->plugin_name); ?>:
            <br/>
        </p>
        <h4> <?php esc_attr_e("Plugins", $this->plugin_name); ?> </h4> <hr>
        <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
        foreach ($helper->plugins as $key => $value):
            ?>
            <fieldset class="update_options">
                <input type="checkbox" name="update_plugins[]" value="<?= $key ?>" />
                <label for="update_plugins">
                    <?php echo $key ?>
                </label>
                <select name="<?php echo $this->plugin_name; ?>[<?php echo $key; ?>]" id="<?php echo $key; ?>">
                    <option value=""> <?php esc_attr_e('Select the plugin', $this->plugin_name); ?> </option>
                    <?php $helper->get_selected_opts('plugins'); ?>
                </select>
            </fieldset>
            <?php
        endforeach;
//        echo "<pre>";
//        var_dump(get_plugins());
        ?>

        <br><hr>

        <h4> <?php esc_attr_e("Temas", $this->plugin_name); ?> </h4> <hr>
        <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
        foreach ($helper->themes as $key => $value):
            ?>
            <fieldset class="update_options">
                <input type="checkbox" name="update_themes[]" value="<?= $key ?>" />
                <label for="update_themes">
                    <?php echo $key ?>
                </label>
                <select name="<?php echo $this->plugin_name; ?>[<?php echo $key; ?>]" id="<?php echo $key; ?>">
                    <option value=""> <?php esc_attr_e('Select the theme', $this->plugin_name); ?> </option>
                    <?php $helper->get_selected_opts('themes'); ?>
                </select>
            </fieldset>
            <?php
        endforeach;
        ?>
        <div class="ibram-btn-container">
            <?php submit_button(__('Update', $this->plugin_name), 'primary', 'submit', TRUE); ?>
        </div>

    </form>
</div>

