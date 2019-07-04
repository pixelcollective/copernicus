<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Use WordPress Default Block Styles
    |--------------------------------------------------------------------------
    |
    | Core blocks include default styles. The styles are enqueued for editing
    | but are not enqueued for viewing unless the theme opts-in to the core
    | styles. Enable to utilize these default styles in your theme.
    |
    | @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#default-block-styles
    |
    */

    'defaultBlockStyles' => true,

    /*
    |--------------------------------------------------------------------------
    | Editor Color Palette
    |--------------------------------------------------------------------------
    |
    | Different blocks have the possibility of customizing colors. The block
    | editor provides a default palette, but a theme can overwrite it and provide
    | its own.
    |
    | @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
    |
    */

    'colorPalette' => [
        [
            'name' => __('native scarlet', 'copernicus'),
            'slug' => 'native-scarlet',
            'color' => '#C31425',
        ],
        [
            'name' => __('kuroi', 'copernicus'),
            'slug' => 'kuroi',
            'color' => '#101820',
        ],
        [
            'name' => __('very light gray', 'copernicus'),
            'slug' => 'very-light-gray',
            'color' => '#eee',
        ],
        [
            'name' => __('dark gray', 'copernicus'),
            'slug' => 'very-dark-gray',
            'color' => '#444',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Disable Custom Color Palettes
    |--------------------------------------------------------------------------
    |
    | This flag will make sure users are only able to choose colors from the
    | editor-color-palette the theme provided or from the editor default
    | colors if the theme did not provide one.
    |
    | @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
    |
    */

    'disableCustomUserColors' => true,

    /*
    |--------------------------------------------------------------------------
    | Editor Font Sizes
    |--------------------------------------------------------------------------
    |
    | Block view composers provide a more convenient method for registering
    | blocks and also allow blocks to be rendered using certain Blade views.
    |
    | @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-font-sizes
    |
    */

    'fontSizes' => [
        [
            'name' => __('Small', 'copernicus'),
            'size' => 12,
            'slug' => 'small'
        ],
        [
            'name' => __('Normal', 'copernicus'),
            'size' => 16,
            'slug' => 'normal'
        ],
        [
            'name' => __('Large', 'copernicus'),
            'size' => 36,
            'slug' => 'large'
        ],
        [
            'name' => __('Huge', 'copernicus'),
            'size' => 50,
            'slug' => 'huge'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Disable Custom Color Palettes
    |--------------------------------------------------------------------------
    |
    | This flag will make sure users are only able to choose font sizes from the
    | font_sizes the theme provided or from the editor default
    | font_sizes if the theme did not provide one.
    |
    | @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-font-sizes
    |
    */

    'disableCustomUserFontSizes' => true,

    /*
    |--------------------------------------------------------------------------
    | Editor Styles
    |--------------------------------------------------------------------------
    |
    | Block view composers provide a more convenient method for registering
    | blocks and also allow blocks to be rendered using certain Blade views.
    |
    | @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#editor-styles
    |
    */

    'supportEditorStyles' => true,
    'supportDarkEditorStyles' => false,

    /*
    |--------------------------------------------------------------------------
    | Block Alignments
    |--------------------------------------------------------------------------
    |
    | Some blocks such as the image block have the possibility to define a
    | “wide” or “full” alignment by adding the corresponding classname to
    | the block’s wrapper (alignwide or alignfull).
    |
    | @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#wide-alignment
    |
    */

    'supportWideAlign' => true,

    /*
    |--------------------------------------------------------------------------
    | Responsive Embeds
    |--------------------------------------------------------------------------
    |
    | The embed blocks automatically apply styles to embedded content to
    | reflect the aspect ratio of content that is embedded in an iFrame. To
    | make the content resize and keep its aspect ratio, the <body> element
    | needs the wp-embed-responsive class.
    |
    | @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#responsive-embedded-content
    |
    */

    'supportResponsiveEmbeds' => true,

    /*
    |--------------------------------------------------------------------------
    | Display Reusable Blocks in the Admin Menu
    |--------------------------------------------------------------------------
    |
    | By default, Reusable Blocks are a built-in posttype which is not
    | displayed in the admin menu. Setting to true will display them the same
    | as any normal WordPress posttype.
    |
    */

    'unlockReusableBlocks' => true,

    /*
    |--------------------------------------------------------------------------
    | Reusable Blocks Icon
    |--------------------------------------------------------------------------
    |
    | Specify an icon to use with the Reusable blocks. Obviously has no effect
    | if the 'reusable_blocks_unlock' config flag is not set to `true`.
    |
    */

    'reusableBlocksIcon' => 'dashicons-layout',

    /*
    |--------------------------------------------------------------------------
    | Display Reusable Blocks in the Admin Menu
    |--------------------------------------------------------------------------
    |
    | Modify the labels used for Reusable blocks.
    |
    */

    'reusableBlocksLabels' => [
        'name'                     => _x('Blocks', 'post type general name', 'copernicus'),
        'singular_name'            => _x('Block', 'post type singular name', 'copernicus'),
        'menu_name'                => _x('Blocks', 'admin menu', 'copernicus'),
        'name_admin_bar'           => _x('Block', 'add new on admin bar', 'copernicus'),
        'add_new'                  => _x('Add New', 'Block', 'copernicus'),
        'add_new_item'             => __('Add New Block', 'copernicus'),
        'new_item'                 => __('New Block', 'copernicus'),
        'edit_item'                => __('Edit Block', 'copernicus'),
        'view_item'                => __('View Block', 'copernicus'),
        'all_items'                => __('All Blocks', 'copernicus'),
        'search_items'             => __('Search Blocks', 'copernicus'),
        'not_found'                => __('No blocks found.', 'copernicus'),
        'not_found_in_trash'       => __('No blocks found in Trash.', 'copernicus'),
        'filter_items_list'        => __('Filter blocks list', 'copernicus'),
        'items_list_navigation'    => __('Blocks list navigation', 'copernicus'),
        'items_list'               => __('Blocks list', 'copernicus'),
        'item_published'           => __('Block published.', 'copernicus'),
        'item_published_privately' => __('Block published privately.', 'copernicus'),
        'item_reverted_to_draft'   => __('Block reverted to draft.', 'copernicus'),
        'item_scheduled'           => __('Block scheduled.', 'copernicus'),
        'item_updated'             => __('Block updated.', 'copernicus'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable reusable blocks GraphQL Endpoint
    |--------------------------------------------------------------------------
    |
    | This flag does not do anything if wpgraphql/wpgraphql is not present
    | in this environment
    |
    | @link https://github.com/wp-graphql/wp-graphql
    |
    */

    'reusableBlocksUseGraphQL' => true,

    /*
    |--------------------------------------------------------------------------
    | Reusable blocks ACL
    |--------------------------------------------------------------------------
    |
    | Modify the permissions for reusable blocks
    |
    */

    'reusableBlocksCapabilityType' => 'block',

    'reusableBlocksCapabilities' => [
        'read'         => 'read_blocks',
        'create_posts' => 'create_posts',
    ],
];
