<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Extrameile sys_note',
    'description' => 'Enables you to create sys_notes from the header of the TYPO3 page module.',
    'category' => 'plugin',
    'version' => '1.0.0',
    'state' => 'alpha',
    'uploadfolder' => 0,
    'clearCacheOnLoad' => 0,
    'author' => 'Andreas Kießling',
    'author_email' => 'kiessling@extrameile-gehen.de',
    'author_company' => 'Extrameile GmbH',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
            'sys_note' => '9.5.0-9.5.99',
        ],
    ],
];
