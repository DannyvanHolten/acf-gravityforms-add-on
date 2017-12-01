<?php

namespace ACFGravityformsField;


class Utils
{

    /**
     * Generate an activation URL for a plugin like the ones found in WordPress plugin administration screen.
     *
     * @param  string $plugin A plugin-folder/plugin-main-file.php path (e.g. "my-plugin/my-plugin.php")
     *
     * @return string         The plugin activation url
     */
    public function generatePluginActivationLinkUrl($plugin)
    {
        // the plugin might be located in the plugin folder directly
        $plugin = urldecode($plugin);
        
        $activateUrl = sprintf(admin_url('plugins.php?action=activate&plugin=%s&plugin_status=all&paged=1&s'), $plugin);
        
        // change the plugin request to the plugin to pass the nonce check
        $activateUrl = wp_nonce_url($activateUrl, 'activate-plugin_' . $plugin);
        
        return $activateUrl;
    }

    /**
     * Generate an installation URL for a plugin like the ones found in WordPress plugin administration screen.
     *
     * @param  string $plugin A plugin-url path (e.g. "plugin-url")
     *
     * @return string         The plugin installation url
     */
    public function generatePluginInstallLinkUrl($plugin)
    {   
        $installUrl = sprintf(admin_url('update.php?action=install-plugin&plugin=%s'), $plugin);
        
        // change the plugin request to the plugin to pass the nonce check
        $installUrl = wp_nonce_url($installUrl, 'install-plugin_' . $plugin);
        
        return $installUrl;
    }

    /**
     * Checks if a WordPress plugin is installed.
     *
     * @param  string  $pluginTitle The plugin title (e.g. "My Plugin")
     *
     * @return string/boolean       The plugin file/folder relative to the plugins folder path (e.g. "my-plugin/my-plugin.php") or false
     */
    public function isPluginInstalled($pluginTitle)
    {
        // get all the plugins
        $installedPlugins = get_plugins();

        foreach ($installedPlugins as $installedPlugin => $data) {

            // check for the plugin title
            if ($data['Title'] == $pluginTitle) {

                // return the plugin folder/file
                return $installedPlugin;
            }
        }

        return false;
    }
}