<?php

return [
    [
        'name' => 'TERMS',
        'flag' => 'plugin.terms',
    ],
    [
        'name' => 'TERMS',
        'flag' => 'terms.index',
        'parent_flag' => 'plugin.terms',
    ],
    [
        'name' => 'Create',
        'flag' => 'terms.create',
        'parent_flag' => 'terms.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'terms.edit',
        'parent_flag' => 'terms.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'terms.destroy',
        'parent_flag' => 'terms.index',
    ],
    [
        'name' => 'GLOBAL TERMS',
        'flag' => 'plugin.globalterms',
    ],
    [
        'name' => 'GLOBAL TERMS',
        'flag' => 'globalterms.index',
        'parent_flag' => 'plugin.globalterms',
    ],
    [
        'name' => 'Create',
        'flag' => 'globalterms.create',
        'parent_flag' => 'globalterms.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'globalterms.edit',
        'parent_flag' => 'globalterms.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'globalterms.destroy',
        'parent_flag' => 'globalterms.index',
    ],
    
];
