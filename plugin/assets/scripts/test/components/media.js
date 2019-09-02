// @wordpress
import { __ } from '@wordpress/i18n'
import { MediaUpload } from '@wordpress/block-editor'

const Media = props => {
  const labels = {
    title: props.title && props.title,
    instructions: props.instructions && props.instructions,
  }

  console.log(props.media)

  return (
    <MediaUpload
      labels={labels}
      value={props.media.url}
      onSelect={props.onMedia}
      render={({ open }) => (<img src={props.media.url} onClick={open} />)}
      allowedTypes={props.allowed && props.allowed}
      className={`test__media-image`} />
  )
}

export default Media
