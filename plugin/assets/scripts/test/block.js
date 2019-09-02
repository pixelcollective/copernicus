// @wordpress
import { __ } from '@wordpress/i18n'
import { registerBlockType } from '@wordpress/blocks'

// components
import { testEdit as edit } from './components'

const save = () => null

const attributes = {
  text: {
    type: `string`,
  },
  media: {
    type: `object`,
    default: {
      url: `http://placehold.it/500`,
    },
  },
}

const icon = {
  src: `admin-plugins`,
  background: `rgba(0, 0, 0, 0.1)`,
  foreground: `rgba(0, 0, 0, 1)`,
}

registerBlockType(`plugin/demo`, {
  title: __(`Copernicus Test Block`),
  description: __(`A block with an image and text field.`),
  category: `common`,
  icon,
  attributes,
  edit,
  save,
})
