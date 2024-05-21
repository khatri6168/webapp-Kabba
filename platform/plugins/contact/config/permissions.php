<?php

return [
    [
        'name' => 'Contacts',
        'flag' => 'contacts.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'contacts.create',
        'parent_flag' => 'contacts.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'contacts.edit',
        'parent_flag' => 'contacts.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'contacts.destroy',
        'parent_flag' => 'contacts.index',
    ],
];
