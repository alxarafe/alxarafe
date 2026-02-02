import { defineConfig } from 'vitepress'

export default defineConfig({
    title: "Alxarafe",
    base: '/docs/',
    srcDir: './webDoc', // <--- ESTO ES CLAVE: le dice que busque los .md aquí

    locales: {
        root: { label: 'English', lang: 'en' }, // Al estar en webDoc, buscará en /en/
        es: { label: 'Español', lang: 'es', link: '/es/' }
    },

    themeConfig: {
        sidebar: {
            '/en/': [{ text: 'Documentation', items: [{ text: 'Home', link: '/en/' }] }],
            '/es/': [{ text: 'Documentación', items: [{ text: 'Inicio', link: '/es/' }] }]
        }
    }
})