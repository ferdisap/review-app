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
          tsm: ['6px', '12px'],
          dsm: ['8px', '14px'],
          ssm: ['10px', '16px'],
          sm: ['14px', '20px'],
          base: ['16px', '24px'],
          lg: ['20px', '28px'],
          xl: ['24px', '32px'],
        }
    },

    plugins: [require('@tailwindcss/forms')],
};
