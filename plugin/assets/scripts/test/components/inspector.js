// @wordpress
import { __ } from '@wordpress/i18n'
import { InspectorControls } from '@wordpress/editor'
import { TextControl, ToggleControl, Panel, PanelBody, PanelRow } from '@wordpress/components'

const Inspector = props => (
  <InspectorControls>
    <PanelBody title={__(`Block settings`)}>
    </PanelBody>
  </InspectorControls>
)

export default Inspector
