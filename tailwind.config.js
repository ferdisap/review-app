const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            minWidth: {
              '100px' : '100px'
            }
            
        },
        // fontSize: {
        //   dsm: ['0.5rem', '0.75rem'],
        //   ssm: ['0.625rem', '0.5rem']
        // },
        fontSize: {
          tsm: ['0.375rem', '0.75rem'],
          dsm: ['0.5rem', '0.75rem'],
          ssm: ['0.625rem', '1rem'],
          xs: ['0.75rem', '1rem'],
          sm: ['0.875rem', '1.25rem'],
          base: ['1rem', '1.5rem'],
          lg: ['1.125rem', '1.75rem'],
          xl: ['1.25rem', '1.75rem'],
          dxl: ['1.5rem', '2rem'],
          txl: ['1.875rem', '2.25rem'],
        }
    },

    plugins: [require('@tailwindcss/forms')],
};
