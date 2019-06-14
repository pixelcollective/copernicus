import { __ } from '@wordpress/i18n'
import { RichText, InnerBlocks } from '@wordpress/block-editor'

// packages
import tw from 'tailwind.macro'
import { injectGlobal } from 'emotion'

// components
import { Logo } from './logo'

// styled
const Container = tw.div`py-16`,
      Block = tw.div`flex justify-around`,
      Column = tw.div`w-1/3 flex-1`,
      Content = tw.div`p-16 pt-0`,
      Heading = tw.div`font-display uppercase pb-0 mb-0 mt-0`,
      InnerBlocksContainer = tw.div`leading-relaxed font-serif`

injectGlobal`
  .about-heading {
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    font-size: 1.875rem !important;
  }
`

// innerblocks template
const ALLOWED_BLOCKS = [
  'core/heading',
  'core/paragraph',
]

// exports
const edit = ({setAttributes, attributes}) => (
  <Container>
    <Block>
      <Column>
        <Content>
          <Logo color="#C33125" />
        </Content>
      </Column>
      <Column>
        <Content>
          <Heading>
            <RichText
              tagName="h2"
              className="about-heading"
              placeholder={__('Write your title here...', 'tinypixel')}
              value={attributes.heading}
              onChange={value => setAttributes({ heading: value })} />
          </Heading>
          <InnerBlocksContainer>
            <InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
          </InnerBlocksContainer>
        </Content>
      </Column>
    </Block>
  </Container>
)

export { edit }
