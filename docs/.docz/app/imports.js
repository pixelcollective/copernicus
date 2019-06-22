export const imports = {
  'md/configuration.mdx': () =>
    import(
      /* webpackPrefetch: true, webpackChunkName: "md-configuration" */ 'md/configuration.mdx'
    ),
  'md/creating-blocks.mdx': () =>
    import(
      /* webpackPrefetch: true, webpackChunkName: "md-creating-blocks" */ 'md/creating-blocks.mdx'
    ),
  'md/getting-started.mdx': () =>
    import(
      /* webpackPrefetch: true, webpackChunkName: "md-getting-started" */ 'md/getting-started.mdx'
    ),
  'md/license.mdx': () =>
    import(
      /* webpackPrefetch: true, webpackChunkName: "md-license" */ 'md/license.mdx'
    ),
  'md/overview.mdx': () =>
    import(
      /* webpackPrefetch: true, webpackChunkName: "md-overview" */ 'md/overview.mdx'
    ),
}
