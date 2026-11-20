<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'mst reloadtrigger',
    'description' => 'add a trigger that can be watched by browsersync, great for development, especially with ddev',
    'author' => 'Michael Stein (mxsteini)',
    'author_email' => 'info@michaelstein-itb.de',
    'author_company' => 'Michael Stein IT-Beratung',
    'state' => 'stable',
    'version' => '0.1.12',
    'constraints' => [
        'depends' => [
          'php' => '8.2.0-8.5.99',
          'typo3' => '12.4.0-14.99.99'
        ],
    ],
];
