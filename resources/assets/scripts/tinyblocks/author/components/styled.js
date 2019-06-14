// packages
import tw from 'tailwind.macro'

// styled
const Card = tw.div`
  max-w-sm w-full max-w-full flex
`

const CardImage = tw.div`
  h-48 h-auto w-48 flex-none bg-cover rounded-t rounded-t-none rounded-l text-center overflow-hidden
`

const CardBody = tw.div`
  border-r border-b border-l border-gray-400 border-l-0 border-t border-gray-400 bg-white rounded-b rounded-b-none rounded-r p-4 flex flex-col justify-between leading-normal
`

const CardSpacing = tw.div`p-4`

const CardHeading = tw.div`
  font-display text-gray-900 font-bold text-3xl mb-0 uppercase
`

const Label = tw.div`
  mb-2 flex items-center
  font-sans text-sm text-gray-600
`

const CardContent = tw.div`text-gray-700 text-base`

const UploadButton = tw.button`
  bg-primary text-white px-6 py-4 rounded
`

export {
  Card,
  CardImage,
  CardBody,
  CardSpacing,
  Label,
  CardHeading,
  CardContent,
  UploadButton,
}
