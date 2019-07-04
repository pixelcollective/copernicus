<?php

namespace Copernicus\Boot;

class Copernicus
{
    public function __construct(string $baseDir)
    {
        /**
         * Plugin name
         * @var string
         */
        $this->name = 'Copernicus';

        /**
         * Plugin dependencies
         * @var string
         */
        $this->dependencies = "{$baseDir}/vendor/autoload.php";

        /**
         * Plugin requirements
         * @var object
         */
        $this->requires = (object) [
            'php'  => '7.2',
            'wp'   => '5.2',
        ];

        /**
         * Runtime
         * @var string
         */
        $this->runtime = (object) [
            'env' => strtoupper(env('WP_ENV')),
            'php' => phpversion(),
            'wp'  => get_bloginfo('version')
        ];

        /**
         * Location of plugin translation files
         * @var string
         */
        $this->i18nHandle = "{$baseDir}/resources/languages";
    }

    /**
     * Does compatibility checks
     * @return object self
     */
    public function preflight()
    {
        $this
            ->loadTextDomain()
            ->checkDependencies()
            ->checkPHPVersion()
            ->checkWPVersion();

        return $this;
    }

    /**
     * Register Copernicus with the Acorn IOC
     * @return object self
     */
    public function registerWithAcorn()
    {
        \Roots\bootloader(function (\Roots\Acorn\Application $app) {
            $app->register(\Copernicus\Providers\CopernicusServiceProvider::class);
        });

        return $this;
    }

    /**
     * Loads plugin i18n texts
     * @return object self
     */
    private function loadTextDomain()
    {
        \load_plugin_textdomain(
            'copernicus',
            false,
            dirname(plugin_basename(__FILE__)) . '/../resources/languages/'
        );

        return $this;
    }

    /**
     * Checks autoload viability
     * @return object self
     */
    private function checkDependencies()
    {
        // If there is an issue with the autoloader this manually
        // loads the error handler class and uses it to throw an early
        // error
        !file_exists($this->dependencies) &&  \Copernicus\Boot\Error::throw([
            'body'     => __(
                'Copernicus needs to be installed in order to be run.<br />'.
                'Run <code>composer install</code> from the plugin directory.',
                'copernicus'
            ),

            'subtitle' => __(
                'Autoloader not found.',
                'copernicus'
            ),
        ]);

        // Load plugin dependencies
        require $this->dependencies;

        return $this;
    }

    /**
     * Checks for minimum PHP version compatibility
     * @return object self
     */
    private function checkPHPVersion()
    {
        version_compare($this->requires->php, $this->runtime->php, '>') &&
            \Copernicus\Boot\Error::throw([
                /* translators: PHP language version requirement */
                'body' => sprintf(__(
                    'You must be using PHP %s or greater.',
                    'copernicus'
                ), $this->requires->php),

                /* translators: Currently installed PHP language version */
                'subtitle' => sprintf(__(
                    'Invalid PHP version (%s)',
                    'copernicus'
                ), $this->runtime->php),
            ]);

        return $this;
    }

    /**
     * Checks for minimum WordPress version compatibility
     * @return object self
     */
    private function checkWPVersion()
    {
        version_compare($this->requires->wp, $this->runtime->wp, '>') &&
            \Copernicus\Boot\Error::throw([
                /* translators: WordPress version requirement */
                'body' => sprintf(__(
                    'You must be using WordPress %s or greater',
                    'copernicus'
                ), $this->requires->wp),

                /* translators: Currently installed WordPress version */
                'subtitle' => sprintf(__(
                    'Invalid WordPress version (%s)',
                    'copernicus'
                ), $this->runtime->wp),
            ]);

        return $this;
    }
}

// EOF
