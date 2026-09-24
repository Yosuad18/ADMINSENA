/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.jsx',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                sena: {
                    green: '#39A900',
                    dark: '#00324D',
                    black: '#1E1E1E',
                },
            },
            fontFamily: {
                archivo: ['Archivo', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
