const ready = () => {
  if(document.body) {
    console.log('works')
  }

  window.requestAnimationFrame(ready)
}

window.requestAnimationFrame(ready)
