<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				 // Specific rule for user/details
        'user/details/<id:\d+>' => 'user/details', 

        // This should match URLs like '/user/view/8'
        '<controller:\w+>/<id:\d+>' => '<controller>/view', 
        
        // Generic rule for actions with id
        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        
        // Generic rule for actions without id
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				
				// '<controller:\w+>/<id:\d+>'=>'<controller>/view',
				// '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				// '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		// 		'user/details/<id:\d+>' => 'user/details', // Specific rule for user/details
        // '<controller:\w+>/<id:\d+>' => '<controller>/view', // Matches controller/view for regular views
        // '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>', // Generic rule for actions with id
        // '<controller:\w+>/<action:\w+>' => '<controller>/<action>', // Generic rule for actions without id
			),
		),
		

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		// 'log'=>array(
		// 	'class'=>'CLogRouter',
		// 	'routes'=>array(
		// 		array(
		// 			'class'=>'CFileLogRoute',
		// 			'levels'=>'error, warning',
		// 		),
		// 		// uncomment the following to show log messages on web pages
		// 		/*
		// 		array(
		// 			'class'=>'CWebLogRoute',
		// 		),
		// 		*/
		// 	),
		// ),
		'log'=>array(
    'class'=>'CLogRouter',
    'routes'=>array(
        // File logging for errors and warnings
        array(
            'class'=>'CFileLogRoute',
            'levels'=>'error, warning',
        ),
        // Show DB logs on page and FireBug
        array(
            'class'=>'CWebLogRoute',
            'categories' => 'system.db.*',
            'showInFireBug' => true,
        ),
    ),
),



	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
