/**
 * Dependencies
 */
const fs = require('fs')
const mix = require('laravel-mix')

// wordpress specific jsx
require('laravel-mix-wp-blocks')

const script = {
  src: (file) => `blocks/assets/scripts/${file}.js`,
  pub: (file) => `dist/${file}.js`,
}

const style = {
  src: (file) => `blocks/assets/styles/${file}.scss`,
  pub: (file) => `dist/${file}.css`,
}

const publicScripts = ['demo']
publicScripts.forEach(block => {
  mix.block(
    script.src(block, 'public'),
    script.pub(block, 'public'),
  )
})

const editorScripts = ['index']
editorScripts.forEach(block => {
  mix.block(
    script.src(block, 'editor'),
    script.pub(block, 'editor'),
  )
})

mix.setPublicPath('./dist')
