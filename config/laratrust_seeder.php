<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'DataAdmin' => [

        ],
        'ResultsApprover' => [

        ],
        'ResultsQC' => [

        ],

        'LabTech' => [

        ],
        'DataClerkSite' => [

        ],
        'DataClerkLab' => [

        ],

    ],

    'permissions_map' => [
        'm' => 'manage',
        'a' => 'approve',
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'x' => 'accept',
    ],
];
