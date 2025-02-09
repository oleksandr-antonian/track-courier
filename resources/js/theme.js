import {definePreset} from "@primevue/themes";
import Aura from "@primevue/themes/aura";

const themePreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '#f0f5ff',
            100: '#dfe8ff',
            200: '#bac8ff',
            300: '#95a8ff',
            400: '#6f87ff',
            500: '#4a67ff',
            600: '#3b4fd6',
            700: '#2c3eaa',
            800: '#1d2d7e',
            900: '#0f1d52'
        },
        secondary: {
            50: '#f8f8f8',
            100: '#f1f1f1',
            200: '#e0e0e0',
            300: '#cecece',
            400: '#ababab',
            500: '#888888',
            600: '#6e6e6e',
            700: '#575757',
            800: '#3f3f3f',
            900: '#282828'
        },
        success: {
            50: '#f0fdf4',
            100: '#dcfce7',
            200: '#bbf7d0',
            300: '#9af0b7',
            400: '#79e89e',
            500: '#58e085',
            600: '#46b86c',
            700: '#348e56',
            800: '#23643f',
            900: '#124a29'
        },
        info: {
            50: '#f1f9ff',
            100: '#d9f4ff',
            200: '#a6e8ff',
            300: '#73dcff',
            400: '#40d0ff',
            500: '#0dc4ff',
            600: '#0aa3d6',
            700: '#087faa',
            800: '#065c7e',
            900: '#043952'
        },
        warning: {
            50: '#fffdf3',
            100: '#fef9c7',
            200: '#fde98f',
            300: '#fcd357',
            400: '#fbc21f',
            500: '#f9b100',
            600: '#c88a00',
            700: '#976600',
        },
    }
});

export default themePreset;
