<?php

return [

	/*
	|--------------------------------------------------------------------------
	| PDO Fetch Style
	|--------------------------------------------------------------------------
	|
	| By default, database results will be returned as instances of the PHP
	| stdClass object; however, you may desire to retrieve records in an
	| array format for simplicity. Here you can tweak the fetch style.
	|
	*/

	'fetch' => PDO::FETCH_CLASS,

	/*
	|--------------------------------------------------------------------------
	| Default Database Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the database connections below you wish
	| to use as your default connection for all database work. Of course
	| you may use many connections at once using the Database library.
	|
	*/

	'default' => env('DB_DRIVER', 'mysql'),

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	| OpenShift Notes:
	|   MySQL:      https://developers.openshift.com/en/databases-mysql.html
	|   PostgreSQL: https://developers.openshift.com/en/databases-postgresql.html
	*/

	'connections' => [

		'mysql' => [
			'driver'    => 'mysql',
			'host'      => env('DB_HOST', env('OPENSHIFT_MYSQL_DB_HOST', 'localhost')),
			'port'      => env('DB_PORT', env('OPENSHIFT_MYSQL_DB_PORT', 3306)),
			'database'  => env('DB_DATABASE', env('OPENSHIFT_APP_NAME', 'memory')),
			'username'  => env('DB_USERNAME', env('OPENSHIFT_MYSQL_DB_USERNAME', 'root')),
			'password'  => env('DB_PASSWORD', env('OPENSHIFT_MYSQL_DB_PASSWORD', 'rafal')),
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'strict'    => false,
		]

	],

	/*
	|--------------------------------------------------------------------------
	| Migration Repository Table
	|--------------------------------------------------------------------------
	|
	| This table keeps track of all the migrations that have already run for
	| your application. Using this information, we can determine which of
	| the migrations on disk haven't actually been run in the database.
	|
	*/

	'migrations' => 'migrations'

];