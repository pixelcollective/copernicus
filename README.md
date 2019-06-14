# WIP

## Quick notes:

1. keep your block inventory as an array of plain block names in blocks.json
2. blocks go in resources/assets/scripts/{namespace}/{blockname}/
3. expected endpoints: editor.js, editor.css (for editor) && public.js, public.css, react.js (for public)
4. blockscripts only enqueued on pages that use them
5. there is no registration, webpack, etc. beyond maintaining blocks.json in root and making sure your entrypoints are in the matching resources/assets/scripts directory.
