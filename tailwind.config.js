const colors = require('tailwindcss/colors');

module.exports = {
    theme: {
        fontFamily: {
            body: ['Poppins', 'sans-serif'],
            header: ['Poppins', 'sans-serif']
        },
        extend: {
            colors: {
                gray: colors.gray,
                orange: colors.orange,
            },
            screens: {
                '2xl': {'max': '1279px'} 
            }
        },
        
    },
    variants: {},
    plugins: [],
    purge: {
        content: ['**/*.html', '**/*.php', '**/*.js'],
        safelist: [
            'rtl',
            'home',
            'blog',
            'archive',
            'date',
            'error404',
            'logged-in',
            'admin-bar',
            'no-customize-support',
            'custom-background',
            'wp-custom-logo',
            'alignnone',
            'alignright',
            'alignleft',
            'wp-caption',
            'wp-caption-text',
            'screen-reader-text',
            'comment-list',
            /^search(-.*)?$/,
            /^(.*)-template(-.*)?$/,
            /^(.*)?-?single(-.*)?$/,
            /^postid-(.*)?$/,
            /^attachmentid-(.*)?$/,
            /^attachment(-.*)?$/,
            /^page(-.*)?$/,
            /^(post-type-)?archive(-.*)?$/,
            /^author(-.*)?$/,
            /^category(-.*)?$/,
            /^tag(-.*)?$/,
            /^tax-(.*)?$/,
            /^term-(.*)?$/,
            /^(.*)?-?paged(-.*)?$/,
          ],
    },
}