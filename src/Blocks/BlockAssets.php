<?php
namespace TinyPixel\Base\Blocks;

use Illuminate\Support\Collection;

/**
 * Demo assets
 *
 */
class Assets
{
    /**
     * Used to identify these assets when composing block views, etc.
     *
     * @var array
     */
    public $name;

    /**
     * Associated blocks
     *
     * @var \Illuminate\Support\Collection
     */
    public $blocks;

    /**
     * Editor assets dependencies.
     *
     * @var array
     */
    public $editorDependencies = [
        'scripts' => ['wp-editor', 'wp-element', 'wp-blocks'],
        'styles'  => [],
    ];

    /**
     * WordPress hooks used for enqueing assets.
     *
     * @var array
     */
    public static $hooks = [
        'app'    => 'wp_enqueue_scripts',
        'editor' => 'enqueue_block_editor_assets',
        'admin'  => 'admin_enqueue_scripts',
    ];

    /**
     * Class constructor.
     *
     */
    public function __construct()
    {
        $this->url = plugins_url() . '/../mu-plugins/block-modules/dist/';

        $this->blocks = Collection::make($this->blocks);

        $this->queue = (object) [
            'app' => (object) [
                'scripts' => isset($this->app['scripts'])
                    ? Collection::make($this->app['scripts'])
                    : null,
                'styles'  => isset($this->app['styles'])
                    ? Collection::make($this->app['styles'])
                    : null,
            ],

            'editor' => (object) [
                'scripts' => isset($this->editor['scripts'])
                    ? Collection::make($this->editor['scripts'])
                    : null,
                'styles'  => isset($this->editor['scripts'])
                    ? Collection::make($this->editor['styles'])
                    : null,
            ],

            'admin'  => (object) [
                'scripts' => isset($this->admin['scripts'])
                    ? Collection::make($this->admin['scripts'])
                    : null,
                'styles'  => isset($this->admin['scripts'])
                    ? Collection::make($this->admin['styles'])
                    : null,
            ],
        ];
    }

    /**
     * Class invocation.
     *
     * @param  string $block
     *
     * @return void
     */
    public function __invoke()
    {
        if (isset($this->app)) {
            add_action('wp_enqueue_scripts', [$this, 'enqueueApp']);
        }

        if (isset($this->editor)) {
            add_action('enqueue_block_editor_assets', [$this, 'enqueueEditor']);
        }

        if (isset($this->admin)) {
            add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin']);
        }
    }

    /**
     * Enqueue Application Assets
     */
    public function enqueueApp()
    {
        /**
         * Return early if block is not used in WP request.
         */
        if ($this->blocks->map(function ($block) {
            return has_block($block) ? true : false;
        })) {
            return;
        }

        /**
         * Enqueue assets.
         */
        $this->queue->app->styles->each(function ($asset) {
            \wp_enqueue_style(
                "$this->name/app/style",
                $this->url . '/styles/' . $asset,
                $this->appDependencies['styles'],
                'all',
            );
        });

        $this->queue->app->scripts->each(function ($script) {
            \wp_enqueue_script(
                "$this->name/app/script",
                $this->url . '/scripts/' . $script,
                $this->appDependencies['scripts'],
                null,
                true,
            );
        });
    }

    /**
     * Enqueue Editor Assets
     */
    public function enqueueEditor()
    {
        $this->queue->editor->styles->each(function ($style) {
            \wp_enqueue_style(
                "$this->name/editor/style",
                $this->url . '/styles/' . $style,
                $this->editorDependencies['styles'],
                'all',
            );
        });

        $this->queue->editor->scripts->each(function ($script) {
            \wp_enqueue_script(
                "$this->name/editor/script",
                $this->url . '/scripts/' . $script,
                $this->editorDependencies['scripts'],
                null,
                true,
            );
        });
    }

    /**
     * Enqueue Admin Assets
     */
    public function enqueueAdmin()
    {
        $this->queue->admin->styles->each(function ($style) {
            \wp_enqueue_style(
                "$this->name/admin/style",
                $this->url . '/styles/' . $style,
                $this->adminDependencies['styles'],
                'all',
            );
        });

        $this->queue->admin->scripts->each(function ($script) {
            \wp_enqueue_script(
                "$this->name/admin/script",
                $this->url . '/scripts/' . $script,
                $this->adminDependencies['scripts'],
                null,
                true,
            );
        });
    }
}
