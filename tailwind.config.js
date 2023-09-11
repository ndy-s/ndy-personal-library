/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/@protonemedia/inertiajs-tables-laravel-query-builder/**/*.{js,vue}",
    ],
    theme: {
        extend: {
            colors: {
                midnight: {
                    900: '#1A202C',
                    800: '#2D3748',
                    700: '#4A5568',
                },
            },
        },
    },
    plugins: [],
}

