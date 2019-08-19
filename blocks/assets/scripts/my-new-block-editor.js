// @wordpress
import { __ } from '@wordpress/i18n'
import { registerBlockType } from '@wordpress/blocks'
import { InnerBlocks } from '@wordpress/block-editor'

// registration
registerBlockType('copernicus/my-new-block', {
  title: __('My New Block', 'copernicus'),
  category: 'common',
  attributes: {
    heading: {
      type: 'string',
    },
    alignment: {
      type: 'string',
      default: 'full',
    },
  },
  supports: {
    align: true,
  },
  edit: () => <div></div>,
  save: () => <InnerBlocks.Content />,
})
