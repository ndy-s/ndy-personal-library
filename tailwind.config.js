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
                'custom-black-pearl': '#040D12',
                'custom-prussian-blue': '#183D3D',
                'custom-cadet-blue': '#5C8374',
                'custom-gainsboro': '#93B1A6',
            },
            backgroundColor: {
                'custom-black-pearl': '#040D12',
                'custom-prussian-blue': '#183D3D',
                'custom-cadet-blue': '#5C8374',
                'custom-gainsboro': '#93B1A6',
            },
        },
    },
    plugins: [],
}

