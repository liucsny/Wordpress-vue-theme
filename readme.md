# Vuejs-wordpress-theme

A custom wordpress theme for [Drowning Pool](drowningpool.tv).

Based on [vuejs-wordpress-theme-starter](https://github.com/EvanAgee/vuejs-wordpress-theme-starter).

## Getting started

- Clone the repo inside of your `wp-content/themes/` directory
- Navigate to the theme directory and run
    `npm install`
    `npm run watch` for development
    `npm run production` when you're ready to deploy the theme.

## Code Organization
All of the code you're going to edit is located in `/src/`. From there it's broken into a few logical directories.

- `/src`
  - `/api` for API requests
  - `/assets` for images mostly
  - `/components` Vue components
  - `/router` vue-router directives
  - `/store` vuex store and modules
  - `/styles` SCSS styles
  - `/vendor` 3rd party scripts and libraries

All scripts and styles in `/src` are compiled down to the `/dist` directory, which is what you will deploy. **When you're ready to deploy don't deploy the src/ directory.**

## External References
- [Creating Vuex Modules](https://vuex.vuejs.org/en/modules.html)
- [vue-router](https://github.com/vuejs/vue-router)
- [WordPress REST API](http://v2.wp-api.org/)
