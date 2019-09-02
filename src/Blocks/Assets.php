<?php
namespace TinyPixel\Copernicus\Blocks;

use Illuminate\Support\Collection;

class Assets
{
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
        $this->blocks = Collection::make($this->blocks);
        $this->queue  = (object) ['app', 'editor', 'admin'];
    }

    /**
     * Class invocation.
     *
     * @param  string $block
     *
     * @return void
     */
    public function __invoke(string $baseUrl)
    {
        $this->url = $baseUrl;

        Collection::make(self::$hooks)->each(function ($hook, $type) {
            $this->queue->{$type} = (object) [
                'scripts' => isset($this->{$type}['scripts'])
                    ? Collection::make($this->{$type}['scripts'])
                    : null,

                'styles' => isset($this->{$type}['styles'])
                    ? Collection::make($this->{$type}['styles'])
                    : null,
            ];
        });

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
                "{$this->url}/{$asset}",
                $this->appDependencies['styles'],
                'all',
            );
        });

        $this->queue->app->scripts->each(function ($asset) {
            \wp_enqueue_script(
                "{$this->name}/app/script",
                "{$this->url}/{$asset}",
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
        $this->queue->editor->styles->each(function ($asset) {
            \wp_enqueue_style(
                "{$this->name}/editor/style",
                "{$this->url}/{$asset}",
                $this->editorDependencies['styles'],
                'all',
            );
        });

        $this->queue->editor->scripts->each(function ($asset) {
            \wp_enqueue_script(
                "{$this->name}/editor/script",
                "{$this->url}/{$asset}",
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
        $this->queue->admin->styles->each(function ($asset) {
            \wp_enqueue_style(
                "{$this->name}/admin/style",
                "{$this->url}/{$asset}",
                $this->adminDependencies['styles'],
                'all',
            );
        });

        $this->queue->admin->scripts->each(function ($asset) {
            \wp_enqueue_script(
                "{$this->name}/admin/script",
                "{$this->url}/{$asset}",
                $this->adminDependencies['scripts'],
                null,
                true,
            );
        });
    }
}
