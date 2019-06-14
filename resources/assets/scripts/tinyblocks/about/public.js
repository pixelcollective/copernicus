const ready = () => {
  if(document.body) {
    console.log('works')
    return
  }

  window.requestAnimationFrame(ready)
}

window.requestAnimationFrame(ready)
