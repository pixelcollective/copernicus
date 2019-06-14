// @wordpress
import { __ } from '@wordpress/i18n'

import {Component} from '@wordpress/element'

import {
  InnerBlocks,
  RichText,
  MediaPlaceholder,
} from '@wordpress/editor'

// packages
import tw from 'tailwind.macro'

// components
import {
  Card,
  CardImage,
  CardBody,
  CardSpacing,
  Label,
  CardHeading,
  CardContent,
} from './styled'

// constants
const TEMPLATE = [
  ['core/paragraph', {placeholder: 'Card contents..'}]
]

const TEMPLATE_LOCK = 'all'

// export
class Edit extends Component {
  constructor(props) {
    super(props)

    this.onMedia = this.onMedia.bind(this)
    this.onName = this.onName.bind(this)
    this.onCardLabel = this.onCardLabel.bind(this)
  }

  onMedia(media) {
    this.props.setAttributes({media: null})
    this.props.setAttributes({media})
  }

  onName(name) {
    this.props.setAttributes({name})
  }

  onCardLabel(cardLabel) {
    this.props.setAttributes({cardLabel})
  }

  render() {
    const renderMedia = () => !this.props.attributes.media ? (
      <MediaPlaceholder
        onSelect={this.onMedia}
        css={tw`h-48 lg:h-auto lg:w-48 flex-none`} />
    ):(
      <CardImage
        style={{
          backgroundImage: `url(${this.props.attributes.media.url})`
        }} />
    )

    return (
      <Card>
        {renderMedia()}
        <CardBody>
          <CardSpacing>
            <Label>
              <RichText
                tagName="div"
                onChange={this.onCardLabel}
                value={this.props.attributes.cardLabel ? this.props.attributes.cardLabel : 'About the author'} />
            </Label>
            <CardHeading>
              <RichText
                tagName="div"
                onChange={this.onName}
                placeholder="Author name"
                value={this.props.attributes.name} />
            </CardHeading>
            <CardContent>
              <InnerBlocks
                template={TEMPLATE}
                templateLock={TEMPLATE_LOCK} />
            </CardContent>
          </CardSpacing>
        </CardBody>
      </Card>
    )
  }
}

export { Edit }
