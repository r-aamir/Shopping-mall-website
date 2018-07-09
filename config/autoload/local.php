<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */
use Doctrine\DBAL\Driver\PDOPgSql\Driver as PDOPgSqlDriver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOPgSqlDriver::class,
                'params' => [
                    'host' => '127.0.0.1',
                    'port' => '5432',
                    'user' => 'admin',
                    'password' => '12345678',
                    'dbname' => 'shopping',
                ]
            ],
        ],
    ],
    'elasticsearch' => [
        'enable' => true,
        'hosts' => [
            'localhost', // Domain
        ]
    ]
];
