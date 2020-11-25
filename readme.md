# Introduction #

Minimalistic starter theme for WordPress based on TailwindCSS and AlpineJS. Uses Laravel Mix for asset compilation.

## Theme installation ##

Download and extract the archive in the wp-content/themes folder. Change the name to something else (like, say, everything-is-awesome).

Then...

```
npm install
```

and...

```
composer update
```

... and all should be up and running. 

## Build commands

The SCSS files are located in wptailwind/scss and the JavaScript is located in wptailwind/js

Compile development CSS and JS

```
npm run dev
```

Or run the watch command to compile development CSS and JS when a file is modified

```
npm run watch
```

To compile production CSS and JS with CSS minification with purgeCss just

```
npm run prod
```
