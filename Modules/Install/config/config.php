<?php



return [
    'name' => 'Install',
    'dependencies' => [
        [
            'name' => 'Core',
            'version' => '1.0.0',
        ],
        [
            'name' => 'Facturación Premium',
            'version' => '1.0.0',
            'dependencies' => [
                [
                    'name' => 'Facturación Premium',
                    'version' => '1.0.0',
                ],
            ],
        ],
    ],
];
