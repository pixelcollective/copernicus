const mix = require('laravel-mix')
require('laravel-mix-wp-blocks')

const {
  styles,
  scripts: { blocks, react, es6 },
} = require('./assets/scripts/assets.mix')

const script = {
  src: file => `assets/scripts/${file}.js`,
  pub: file => `dist/scripts/${file}.js`,
}

const style = {
  src: file => `assets/styles/${file}.scss`,
  pub: file => `dist/styles/${file}.css`,
}

blocks && blocks.forEach(asset => mix.block(
  script.src(asset), script.pub(asset))
)

react && react.forEach(asset => mix.react(
  script.src(asset), script.pub(asset),
))

es6 && es6.forEach(asset => mix.js(
  script.src(asset), script.pub(asset),
))

styles && styles.forEach(asset => mix.sass(
  style.src(asset), style.pub(asset),
))
