// @wordpress
import { __ } from '@wordpress/i18n'
import { registerBlockType } from '@wordpress/blocks'
import { InnerBlocks } from '@wordpress/block-editor'

// components
import { edit } from './components/edit'

// registration
registerBlockType('tinyblocks/about', {
  title: __('About', 'tinyblocks'),
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
