import images from 'remark-images'

const config = {
  spacing: {
    large: `2rem 0rem 2rem 0rem`,
    default: `1rem 0rem 1.5rem 0rem`,
  },
}
export default {
  title: 'Copernicus Framework Documentation',
  description: 'A WordPress Block Editor Framework',
  menu: [
    'Overview',
    'Getting Started',
    'Configuration',
    'Creating Blocks',
    'License',
  ],
  themeConfig: {
    mode: 'dark',
    colors: {
      codeBg: "#EB4D4B",
    },
    styles: {
      body: `
        font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        line-height: 1.9rem;
        font-size: 1.25rem;
      `,
      h1: `
        font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        margin: ${config.spacing.large};
        letter-spacing: 0.05ch;
        font-weight: 600;
      `,
      h2: `
        font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        margin: ${config.spacing.large};
        font-weight: 500;
        letter-spacing 0.02ch;
      `,
      h3:`
        font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        margin: ${config.spacing.default};
      `,
      h4: `
        font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        margin: ${config.spacing.default};
      `,
      ul: `
        margin: ${config.spacing.default};
      `,
      ol: `
        margin: ${config.spacing.default};
      `,
      p: `
        margin: ${config.spacing.default};
        font-size: 1.4rem;
      `,
      pre: `
        font-size: 1.4rem;
      `,
    },
  },
  mdPlugins: [
    images,
  ],
}
