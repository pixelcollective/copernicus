<?php

/**
 * Plugin Name:     Copernicus
 * Plugin URI:      https://github.com/pixelcollective/copernicus
 * Description:     A WordPress editor extension framework
 * Version:         0.1.0
 * Author:          Tiny Pixel Collective
 * Author URI:      https://tinypixel.dev
 * License:         MIT License
 * Text Domain:     blockmodules
 * Domain Path:     /resources/lang
 *
 * Note: this file is intentionally written for compatibility with PHP versions
 * which the plugin itself does not support.
 */

(new class {
    public function __construct()
    {
        $this->plugin = (object) [
            'composer' => __DIR__ . '/vendor/autoload.php',
            'config'   => __DIR__ . '/config/copernicus.php',
            'requires' => (object) [
                'php'  => '7.2',
                'wp'   => '5.2',
            ],
        ];
    }

    public function run()
    {
        $this
            ->checkPHPVersion()
            ->checkWPVersion()
            ->checkComposer()
            ->checkConfiguration();

        add_action('after_setup_theme', [
            $this, 'registerWithAcorn',
        ]);
    }

    public function registerWithAcorn()
    {
        // load container dependencies
        require $this->plugin->composer;

        \Roots\bootloader(function (\Roots\Acorn\Application $app) {
            $app->register(Copernicus\Providers\CopernicusServiceProvider::class);
        });
    }


    private function checkPHPVersion()
    {
        if (version_compare($this->plugin->requires->php, phpversion(), '>')) {
            $this->error(
                __('You must be using PHP'. $this->plugin->requires->php .'or greater.', 'copernicus'),
                __('Invalid PHP version', 'copernicus')
            );
        }

        return $this;
    }

    private function checkWPVersion()
    {
        if (version_compare($this->plugin->requires->wp, get_bloginfo('version'), '>')) {
            $this->error(
                __('You must be using WordPress'. $this->plugin->requires->wp .'or greater.', 'copernicus'),
                __('Invalid WordPress version', 'copernicus')
            );
        }

        return $this;
    }

    private function checkComposer()
    {
        if (!file_exists($this->plugin->composer)) {
            $this->error(
                __('You must run <code>composer install</code> from the Block Modules plugin directory.', 'copernicus'),
                __('Autoloader not found.', 'copernicus')
            );
        }

        return $this;
    }

    private function checkConfiguration()
    {
        if (!isset($this->plugin->config) && file_exists($this->plugin->config)) {
            $this->error(
                __('The configuration file must be present in the Block Modules plugin directory', 'copernicus'),
                __('Configuration not found.', 'copernicus')
            );
        }

        return $this;
    }

    private function error($message, $subtitle = '', $title = '')
    {
        $title = $title ?: __('Copernicus Runtime Error', 'copernicus');
        $footer = '<a href="https://tinypixel.dev/plugins/block-modules/">tinypixel.dev/plugins/block-modules/</a>';
        $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";

        wp_die($message, $title);
    }
})->run();
