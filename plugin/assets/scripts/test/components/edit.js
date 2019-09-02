// @wordpress
import { __ } from '@wordpress/i18n'
import { Component } from '@wordpress/element'
import { RichText } from '@wordpress/editor'

// components
import Media from './media'
import Inspector from './inspector'

class testEdit extends Component {
  constructor(props) {
    super(props)

    // initial component state
    this.state = {
      foo: 'bar',
    }

    // component bindings
    this.onText  = this.onText.bind(this)
    this.onMedia = this.onMedia.bind(this)
  }

  onText(text) {
    this.props.setAttributes({ text })
  }
  onMedia(media) {
    this.props.setAttributes({ media })
  }

  render() {
    const { className, attributes } = this.props
    const { media, text } = attributes

    return (
      <div className={className}>
        <Inspector />
        <div className={`${className}__media`}>
          <Media
            onMedia={this.onMedia}
            media={media}
            allowed={[`image`]}
            title={__(`test image`)}
            instructions={__(`Upload an image`)} />
        </div>
        <div className={`${className}__inner`}>
          <RichText
            tagName={`h2`}
            value={text}
            onChange={this.onText}
            className={`${className}__inner-text`}
            placeholder={__(`Write your text here...`)} />
        </div>
      </div>
    )
  }
}

export default testEdit
