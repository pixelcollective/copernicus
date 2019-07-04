/**
 * Dependencies
 */
const fs = require('fs')
const mix = require('laravel-mix')

// wordpress specific jsx
require('laravel-mix-wp-blocks')

/**
 * Project configuration
 */
const namespace = 'copernicus'

const script = {
  src: (name, file) => `resources/assets/scripts/${namespace}/${name}/${file}.js`,
  pub: (name, file) => `dist/${namespace}/${name}/${file}.js`,
}

const style = {
  src: (name, file) => `resources/assets/styles/${namespace}/${name}/${file}.scss`,
  pub: (name, file) => `dist/${namespace}/${name}/${file}.css`,
}

const blocks = require('./blocks.json')

blocks.forEach(block => {
  /**
   * Editor script
   */
  fs.existsSync(script.src(block, 'editor')) &&
    mix.block(
      script.src(block, 'editor'),
      script.pub(block, 'editor'),
    )

  /**
   * Public script
   */
  fs.existsSync(script.src(block, 'public')) &&
    mix.js(
      script.src(block, 'public'),
      script.pub(block, 'public'),
    )

  /**
   * Public script with wp-element dependencies
   */
  fs.existsSync(script.src(block, 'react')) &&
    mix.block(
      script.src(block, 'react'),
      script.pub(block, 'react'),
    )

  /**
   * Editor style
   */
  fs.existsSync(style.src(block, 'editor')) &&
    mix.sass(
      style.src(block, 'editor'),
      style.pub(block, 'editor')
    )

  /**
   * Public style
   */
  fs.existsSync(style.src(block, 'public')) &&
    mix.sass(
      style.src(block, 'public'),
      style.pub(block, 'public')
    )
})

mix.setPublicPath('./dist')
