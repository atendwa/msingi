import preset from './vendor/filament/support/tailwind.config.preset'
/** @type {import('tailwindcss').Config} */

export default {
    presets: [preset],
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './app/Filament/**/*.php',
        './app/Livewire/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/css/app.css',
    ],
    theme: {
        extend: {
            fontFamily: {
                primary: 'Jost'
            },
            colors: {
                primary: '#02338D',
                secondary: '#CC9C4A',
                red: '#D81620',
            }
        },
        animation: {
            wobble: 'wobble 0.8s both',
            'flame-rise': 'flame-rise 1s ease-in-out',
        },
        keyframes: {
            'flame-rise': {
                '100%': {
                    transform: 'translateY(-2rem)',
                    transformOrigin: '50% 50%',
                    scale: 0.75,
                    opacity: 0,
                },
            },
            'wobble': {
                '0%, 100%': {
                    transform: 'translateX(0%)',
                    transformOrigin: '50% 50%',
                },
                '15%': {
                    transform: 'translateX(-30px) rotate(-6deg)',
                },
                '30%': {
                    transform: 'translateX(15px) rotate(6deg)',
                },
                '45%': {
                    transform: 'translateX(-15px) rotate(-3.6deg)',
                },
                '60%': {
                    transform: 'translateX(9px) rotate(2.4deg)',
                },
                '75%': {
                    transform: 'translateX(-6px) rotate(-1.2deg)',
                },
            },
        }
}
};

