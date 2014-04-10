<?php

error_reporting(0); // Set E_ALL for debuging

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';
// Required for MySQL storage connector
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeMySQL.class.php';
// Required for FTP connector support
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeFTP.class.php';


/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}


// Documentation for connector options:
// https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
$opts = array(
	'locale' => 'en_US.UTF-8',
	'bind' => array(
		// '*' => 'logger',
		'mkdir mkfile rename duplicate upload rm paste' => 'logger'
	),
	'debug' => true,
	'roots' => array(
		array(
			'driver'     => 'LocalFileSystem',
			'path'       => '../files/',
			'startPath'  => '../files/test/',
			'URL'        => dirname($_SERVER['PHP_SELF']) . '/../files/',
			// 'treeDeep'   => 3,
			// 'alias'      => 'File system',
			'mimeDetect' => 'internal',
			'tmbPath'    => '.tmb',
			'utf8fix'    => true,
			'tmbCrop'    => false,
			'tmbBgColor' => 'transparent',
			'accessControl' => 'access',
			'acceptedName'    => '/^[^\.].*$/',
			// 'disabled' => array('extract', 'archive'),
			// 'tmbSize' => 128,
			'attributes' => array(
				array(
					'pattern' => '/\.js$/',
					'read' => true,
					'write' => false
				),
				array(
					'pattern' => '/^\/icons$/',
					'read' => true,
					'write' => false
				)
			)
			// 'uploadDeny' => array('application', 'text/xml')
		),
		// array(
		// 	'driver'     => 'LocalFileSystem',
		// 	'path'       => '../files2/',
		// 	// 'URL'        => dirname($_SERVER['PHP_SELF']) . '/../files2/',
		// 	'alias'      => 'File system',
		// 	'mimeDetect' => 'internal',
		// 	'tmbPath'    => '.tmb',
		// 	'utf8fix'    => true,
		// 	'tmbCrop'    => false,
		// 	'startPath'  => '../files/test',
		// 	// 'separator' => ':',
		// 	'attributes' => array(
		// 		array(
		// 			'pattern' => '~/\.~',
		// 			// 'pattern' => '/^\/\./',
		// 			'read' => false,
		// 			'write' => false,
		// 			'hidden' => true,
		// 			'locked' => false
		// 		),
		// 		array(
		// 			'pattern' => '~/replace/.+png$~',
		// 			// 'pattern' => '/^\/\./',
		// 			'read' => false,
		// 			'write' => false,
		// 			// 'hidden' => true,
		// 			'locked' => true
		// 		)
		// 	),
		// 	// 'defaults' => array('read' => false, 'write' => true)
		// ),

		// array(
		// 	'driver' => 'FTP',
		// 	'host' => '192.168.1.38',
		// 	'user' => 'dio',
		// 	'pass' => 'hane',
		// 	'path' => '/Users/dio/Documents',
		// 	'tmpPath' => '../files/ftp',
		// 	'utf8fix' => true,
		// 	'attributes' => array(
		// 		array(
		// 			'pattern' => '~/\.~',
		// 			'read' => false,
		// 			'write' => false,
		// 			'hidden' => true,
		// 			'locked' => false
		// 		),
		// 		
		// 	)
		// ),
		
		//array(
		//	'driver' => 'FTP',
		//	'host' => 'work.std42.ru',
		//	'user' => 'dio',
		//	'pass' => 'wallrus',
		//	'path' => '/',
		//	'tmpPath' => '../files/ftp',
		//),
		
		// array(
		// 	'driver' => 'FTP',
		// 	'host' => '10.0.1.3',
		// 	'user' => 'frontrow',
		// 	'pass' => 'frontrow',
		// 	'path' => '/',
		// 	'tmpPath' => '../files/ftp',
		// ),

		// array(
		// 	'driver'     => 'LocalFileSystem',
		// 	'path'       => '../files2/',
		// 	'URL'        => dirname($_SERVER['PHP_SELF']) . '/../files2/',
		// 	'alias'      => 'Files',
		// 	'mimeDetect' => 'internal',
		// 	'tmbPath'    => '.tmb',
		// 	// 'copyOverwrite' => false,
		// 	'utf8fix'    => true,
		// 	'attributes' => array(
		// 		array(
		// 			'pattern' => '~/\.~',
		// 			// 'pattern' => '/^\/\./',
		// 			// 'read' => false,
		// 			// 'write' => false,
		// 			'hidden' => true,
		// 			'locked' => false
		// 		),
		// 	)
		// ),

		// array(
		// 	'driver' => 'MySQL',
		// 	'path' => 1,
		// 	// 'treeDeep' => 2,
		// 	// 'socket'          => '/opt/local/var/run/mysql5/mysqld.sock',
		// 	'user' => 'root',
		// 	'pass' => 'hane',
		// 	'db' => 'elfinder',
		// 	'user_id' => 1,
		// 	// 'accessControl' => 'access',
		// 	// 'separator' => ':',
		// 	'tmbCrop'         => true,
		// 	// thumbnails background color (hex #rrggbb or 'transparent')
		// 	'tmbBgColor'      => '#000000',
		// 	'files_table' => 'elfinder_file',
		// 	// 'imgLib' => 'imagick',
		// 	// 'uploadOverwrite' => false,
		// 	// 'copyTo' => false,
		// 	// 'URL'    => 'http://localhost/git/elfinder',
		// 	'tmpPath' => '../filesdb/tmp',
		// 	'tmbPath' => '../filesdb/tmb',
		// 	'tmbURL' => dirname($_SERVER['PHP_SELF']) . '/../filesdb/tmb/',
		// 	// 'attributes' => array(
		// 	// 	array(),
		// 	// 	array(
		// 	// 		'pattern' => '/\.jpg$/',
		// 	// 		'read' => false,
		// 	// 		'write' => false,
		// 	// 		'locked' => true,
		// 	// 		'hidden' => true
		// 	// 	)
		// 	// )
		// 	
		// )
	)

);

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();

