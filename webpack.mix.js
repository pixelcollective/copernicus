const fs = require('fs')

const mix = require('laravel-mix')
require('laravel-mix-wp-blocks')
require('laravel-mix-tweemotional')

const blocks = require('./blocks.json')

const namespace = 'tinyblocks';

const script = {
  src: (name, file) => `resources/assets/scripts/${namespace}/${name}/${file}.js`,
  pub: (name, file) => `dist/${namespace}/${name}/${file}.js`,
}

const style = {
  src: (name, file) => `resources/assets/styles/${namespace}/${name}/${file}.scss`,
  pub: (name, file) => `dist/${namespace}/${name}/${file}.css`,
}

blocks.forEach(block => {
  mix.block(
    script.src(block, 'editor'),
    script.pub(block, 'editor'),
  )

  fs.existsSync(script.src(block, 'public')) &&
    mix.block(
      script.src(block, 'public'),
      script.pub(block, 'public'),
    )

  fs.existsSync(style.src(block, 'editor')) &&
    mix.sass(
      style.src(block, 'editor'),
      style.pub(block, 'editor')
    )

  fs.existsSync(style.src(block, 'public')) &&
    mix.sass(
      style.src(block, 'public'),
      style.pub(block, 'public')
    )
})

mix.tweemotional({tailwind: 'tailwind.config.js'})

mix.setPublicPath('./dist')
