// @wordpress
import { __ } from '@wordpress/i18n'
import { registerBlockType } from '@wordpress/blocks'
import { InnerBlocks } from '@wordpress/block-editor'

// components
import { Edit as edit } from './components/Edit'

const attributes = {
  media: {
    type: 'object'
  },
  cardLabel: {
    type: 'string',
  },
  name: {
    type: 'string',
  },
}

registerBlockType('tinyblocks/author', {
  title: __('Author', 'tinyblocks'),
  description: __('Highlight an author or key person', 'tinyblocks'),
  category: 'common',
  keywords: [__('Tiny Pixel Collective', 'tinyblocks')],
  icon: 'smiley',
  attributes,
  edit,
  save: () => <InnerBlocks.Content />,
})
