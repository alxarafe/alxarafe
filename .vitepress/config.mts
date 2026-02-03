import { defineConfig } from 'vitepress'

export default defineConfig({
    title: "Alxarafe",
    base: '/',
    srcDir: './webDoc',
    ignoreDeadLinks: true,

    locales: {
        root: { label: 'Español', lang: 'es', link: '/es/' },
        en: { label: 'English', lang: 'en', link: '/en/' }
    },

    themeConfig: {
        sidebar: {
            '/en/': [{ text: 'Documentation', items: [{ text: 'Home', link: '/en/' }] }],
            '/es/': [{ text: 'Documentación', items: [{ text: 'Inicio', link: '/es/' }] }]
        }
    }
})