import { defineConfig } from 'vitepress'

export default defineConfig({
    title: "Alxarafe",
    base: '/',
    srcDir: '.',
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
                        { text: 'API Development', link: '/en/api_development' },
                        { text: 'Menu Manager', link: '/en/menu_manager' },
                        { text: 'Resource Controller Lifecycle', link: '/en/resource_controller_lifecycle' },
                        { text: 'Themes', link: '/en/themes' },
                        { text: 'Template Engine', link: '/en/template_engine' },
                        { text: 'Template Schema', link: '/en/template_schema' },
                        { text: 'PHP 8.5 Diagnosis', link: '/en/php85_diagnosis' },
                        { text: 'Publishing Guide', link: '/en/publishing_guide' },
                        { text: 'Contribution Guide', link: '/en/contribution_guide' },
                        { text: 'Testing', link: '/en/testing' },
                    ]
                },
                {
                    text: 'Class Reference',
                    link: '/en/classes/',
                    items: [
                        {
                            text: 'Controllers',
                            collapsed: false,
                            items: [
                                { text: 'Resource Controller', link: '/en/classes/core/base/controller/resource-controller' },
                                { text: 'API Controller', link: '/en/classes/core/base/controller/api-controller' },
                                { text: 'Generic Controller', link: '/en/classes/core/base/controller/generic-controller' },
                                { text: 'Public Controller', link: '/en/classes/core/base/controller/generic-public-controller' },
                                { text: 'View Controller', link: '/en/classes/core/base/controller/view-controller' },
                            ]
                        },
                        {
                            text: 'Models',
                            collapsed: false,
                            items: [
                                { text: 'Base Model', link: '/en/classes/core/base/model/model/model' },
                                { text: 'Configuration', link: '/en/classes/core/base/model/config' },
                                { text: 'Database', link: '/en/classes/core/base/model/database' },
                                { text: 'Seeder', link: '/en/classes/core/base/model/seeder' },
                            ]
                        },
                        {
                            text: 'Traits',
                            collapsed: true,
                            items: [
                                { text: 'Database Trait', link: '/en/classes/core/base/controller/trait/db-trait' },
                                { text: 'View Trait', link: '/en/classes/core/base/controller/trait/view-trait' },
                                { text: 'DTO Trait', link: '/en/classes/core/base/model/model/trait/dto-trait' },
                            ]
                        },
                        { text: 'Full API (phpDoc)', link: '/api_combined/' },
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
                        { text: 'Desarrollo de APIs', link: '/es/desarrollo_de_apis' },
                        { text: 'Gestor de Menús', link: '/es/gestor_de_menus' },
                        { text: 'Ciclo de Vida ResourceController', link: '/es/resource_controller_lifecycle' },
                        { text: 'Temas', link: '/es/temas' },
                        { text: 'Motor de Plantillas', link: '/es/motor-plantillas' },
                        { text: 'Esquema de Plantillas', link: '/es/esquema_de_plantillas' },
                        { text: 'Diagnóstico PHP 8.5', link: '/es/diagnostico_php85' },
                        { text: 'Guía de Publicación', link: '/es/guia_de_publicacion' },
                        { text: 'Guía de Contribución', link: '/es/guia_de_contribucion' },
                        { text: 'Testing', link: '/es/testing' },
                    ]
                },
                {
                    text: 'Referencia de Clases',
                    link: '/es/classes/',
                    items: [
                        {
                            text: 'Controladores',
                            collapsed: false,
                            items: [
                                { text: 'Controlador de Recursos', link: '/es/classes/core/base/controller/resource-controller' },
                                { text: 'Controlador API', link: '/es/classes/core/base/controller/api-controller' },
                                { text: 'Controlador Genérico', link: '/es/classes/core/base/controller/generic-controller' },
                                { text: 'Controlador Público', link: '/es/classes/core/base/controller/generic-public-controller' },
                                { text: 'Controlador de Vista', link: '/es/classes/core/base/controller/view-controller' },
                            ]
                        },
                        {
                            text: 'Modelos',
                            collapsed: false,
                            items: [
                                { text: 'Modelo Base', link: '/es/classes/core/base/model/model/model' },
                                { text: 'Configuración', link: '/es/classes/core/base/model/config' },
                                { text: 'Base de Datos', link: '/es/classes/core/base/model/database' },
                                { text: 'Seeder', link: '/es/classes/core/base/model/seeder' },
                            ]
                        },
                        {
                            text: 'Traits',
                            collapsed: true,
                            items: [
                                { text: 'Trait de Base de Datos', link: '/es/classes/core/base/controller/trait/db-trait' },
                                { text: 'Trait de Vista', link: '/es/classes/core/base/controller/trait/view-trait' },
                                { text: 'Trait DTO', link: '/es/classes/core/base/model/model/trait/dto-trait' },
                            ]
                        },
                        { text: 'API Completa (phpDoc)', link: '/api_combined/' },
                    ]
                }
            ]
        }
    }
})