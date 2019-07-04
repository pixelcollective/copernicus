<?php

namespace Copernicus\Boot;

use \Copernicus\Boot\Copernicus;

use function \admin_url;
use function \is_plugin_active;
use function \deactivate_plugins;
use function \wp_die;
use function \__;

class Error
{
    /**
     * Deactivates plugin and displays errors
     * @param array $error
     */
    public static function throw($error = null)
    {
        /**
         * The error handler can frequently run too late
         * in WordPress' lifecycle to have access to
         * \deactivate_plugins so we just manually include its
         * source file.
         *
         * @see https://developer.wordpress.org/reference/files/wp-admin/includes/plugin.php/
         */
        if (!function_exists('deactivate_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        // if plugin is activated, deactivate it
        is_plugin_active('copernicus') &&
            deactivate_plugins('copernicus');

        // if error is an array then cast it as an object
        if (!is_null($error)) {
            $error = is_array($error) ? (object) $error : $error;
        }

        /**
         * Provide fallback values for error message components
         * not specified in the call
         */
        $message = (object) [
            'title'    => isset($error->title) ?
                            $error->title :
                            self::defaultTitle(),

            'subtitle' => isset($error->subtitle) ?
                            $error->subtitle :
                            self::defaultSubtitle(),

            'body'     => isset($error->body) ?
                            $error->body :
                            self::defaultBody(),

            'footer'   => isset($error->footer) ?
                            $error->footer :
                            self::defaultFooter(),

            'link'     => isset($error->link) ?
                            $error->link :
                            self::defaultLink(),
        ];

        // prepare the liturgy
        $dirge = sprintf(
            "<h1>%s<br><small>%s</small></h1><p>%s</p><p>%s</p>",
            $message->title,
            $message->subtitle,
            $message->body,
            $message->footer
        );

        // bear the bad news
        wp_die($dirge, $message->title, $message->subtitle);
    }

    /**
     * Get default error message title
     * @return i18n formatted string
     */
    public static function defaultTitle()
    {
        return __(
            'Copernicus Framework Runtime Error',
            'copernicus'
        );
    }

    /**
     * Get default error message subtitle
     * @return i18n formatted string
     */
    public static function defaultSubtitle()
    {
        return __(
            'There is a problem with the Copernicus Framework',
            'copernicus'
        );
    }

    /**
     * Get default error message body
     * @return i18n formatted string
     */
    public static function defaultBody()
    {
        return __(
            'The framework could not boot.',
            'copernicus'
        );
    }

    /**
     * Get default error message footer
     * @return i18n formatted string
     */
    public static function defaultFooter()
    {
        return __(
            'The plugin has been deactivated.',
            'copernicus'
        );
    }

    /**
     * Get default error message link
     * @return array link
     */
    public static function defaultLink()
    {
        return [
            'link_text' => __(
                'Plugin Administration ⌫',
                'copernicus'
            ),

            'link_url'  => admin_url('plugins.php'),
        ];
    }
}

// EOF
