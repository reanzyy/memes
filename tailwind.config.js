/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [require("daisyui")],

    daisyui: {
        themes: ["light", "dark", "cupcake"],
        darkTheme: "light",
        base: true,
        styled: true,
        utils: true,
        rtl: false,
        logs: true,
    },
}