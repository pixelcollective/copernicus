<?php

/**
 * Plugin Name:     Acorn Block Modules
 * Plugin URI:      https://github.com/pixelcollective/block-modules
 * Description:     Block loader and framework
 * Version:         0.1.0
 * Author:          Roots
 * Author URI:      https://roots.io/
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
            'config'   => __DIR__ . '/config/blocks.php',
            'requires' => (object) [
                'php'  => '7.1.3',
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

        // enable container globals
        add_filter('acorn/globals', function () {
            return true;
        });

        // setup container
        $app = \Roots\Acorn\Application::getInstance();

        // add configuration
        \Roots\config(['blocks' => require $this->plugin->config]);

        // setup providers
        if ($providers = $app['config']->get('blocks.providers') ?? null) {
            array_map([$app, 'register'], $providers);
        }
    }

    private function checkPHPVersion()
    {
        if (version_compare($this->plugin->requires->php, phpversion(), '>')) {
            $this->error(
                __('You must be using PHP'. $this->plugin->requires->php .'or greater.', 'blockmodules'),
                __('Invalid PHP version', 'blockmodules')
            );
        }

        return $this;
    }

    private function checkWPVersion()
    {
        if (version_compare($this->plugin->requires->wp, get_bloginfo('version'), '>')) {
            $this->error(
                __('You must be using WordPress'. $this->plugin->requires->wp .'or greater.', 'blockmodules'),
                __('Invalid WordPress version', 'blockmodules')
            );
        }

        return $this;
    }

    private function checkComposer()
    {
        if (!isset($this->plugin->composer) && file_exists($this->plugin->composer)) {
            $this->error(
                __('You must run <code>composer install</code> from the Block Modules plugin directory.', 'blockmodules'),
                __('Autoloader not found.', 'blockmodules')
            );
        }

        return $this;
    }

    private function checkConfiguration()
    {
        if (!isset($this->plugin->config) && file_exists($this->plugin->config)) {
            $this->error(
                __('The configuration file must be present in the Block Modules plugin directory', 'blockmodules'),
                __('Configuration not found.', 'blockmodules')
            );
        }

        return $this;
    }

    private function error($message, $subtitle = '', $title = '')
    {
        $title = $title ?: __('Acorn Block Modules Runtime Error', 'blockmodules');
        $footer = '<a href="https://tinypixel.dev/plugins/block-modules/">tinypixel.dev/plugins/block-modules/</a>';
        $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";

        wp_die($message, $title);
    }
})->run();
