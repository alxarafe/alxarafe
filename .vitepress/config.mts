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
        nav: [
            { text: 'Inicio', link: '/' },
        ],

        sidebar: {
            '/en/': [
                {
                    text: 'Documentation',
                    items: [
                        { text: 'Home', link: '/en/' },
                        { text: 'Architecture', link: '/en/architecture' },
                        { text: 'Docker Usage', link: '/en/docker' },
                        { text: 'Improvement Plan', link: '/en/improvement_plan' },
                        { text: 'PHP 8.5 Diagnosis', link: '/en/php85_diagnosis' },
                        { text: 'Publishing Guide', link: '/en/publishing_guide' },
                        { text: 'Contribution Guide', link: '/en/contribution_guide' },
                    ]
                },
                {
                    text: 'Class Reference',
                    items: [
                        { text: 'Resource Controller', link: '/en/classes/core/base/controller/resource-controller' },
                        { text: 'API Controller', link: '/en/classes/core/base/controller/api-controller' },
                        { text: 'Full API (phpDoc)', link: '/api/' },
                    ]
                }
            ],
            '/es/': [
                {
                    text: 'Documentación',
                    items: [
                        { text: 'Inicio', link: '/es/' },
                        { text: 'Arquitectura', link: '/es/arquitectura' },
                        { text: 'Uso de Docker', link: '/es/docker' },
                        { text: 'Análisis de Mejoras', link: '/es/analisis_de_mejoras' },
                        { text: 'Diagnóstico PHP 8.5', link: '/es/diagnostico_php85' },
                        { text: 'Guía de Publicación', link: '/es/guia_de_publicacion' },
                        { text: 'Guía de Contribución', link: '/es/guia_de_contribucion' },
                    ]
                },
                {
                    text: 'Referencia de Clases',
                    items: [
                        { text: 'Controlador de Recursos', link: '/es/classes/core/base/controller/resource-controller' },
                        { text: 'Controlador API', link: '/es/classes/core/base/controller/api-controller' },
                        { text: 'API Completa (phpDoc)', link: '/api/' },
                    ]
                }
            ]
        }
    }
})