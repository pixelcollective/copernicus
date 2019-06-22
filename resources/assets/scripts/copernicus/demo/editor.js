// @wordpress
import { __ } from '@wordpress/i18n'
import { registerBlockType } from '@wordpress/blocks'
import { InnerBlocks } from '@wordpress/block-editor'

// components
import { edit } from './components/edit'

// registration
registerBlockType('copernicus/demo', {
  title: __('Demo', 'copernicus'),
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
  edit,
  save: () => <InnerBlocks.Content />,
})
