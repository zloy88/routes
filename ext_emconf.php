<?php

$EM_CONF['routes'] = [
    'title' => 'Extbase Yaml Routes',
    'description' => 'Provides an ability to bind a route slug to the certain Extbase Action endpoint.',
    'category' => 'fe',
    'author' => 'Borulko Serhii',
    'author_email' => 'borulkosergey@icloud.com',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '2.1.2',
    'constraints' => [
        'depends' => [
            'php' => '7.2.0-8.1.99',
            'typo3' => '10.4.15-10.4.99'
        ]
    ]
];
