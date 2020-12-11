<?php
use Illuminate\Config\Repository as Mangocube_Repository;
use Illuminate\Support\MessageBag as MangocubeMessageBag;
use Illuminate\Support\Collection as MangocubeCollection;
use Illuminate\Support\Fluent as MangocubeFluent;
use Illuminate\Support\Arr as MangocubeArr;
use Illuminate\Support\Str as MangocubeStr;
use Symfony\Component\Finder\Finder;
/*
**
*** In step one we created a constant called APPLICATION_PATH.
*** Now a smarty security check is to make sure that constant is set.
*** This will stope hackers from directly accessing the file from the browser.
*** So we just make sure that the APPLICATION_PATH is in the scope
**
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
**
*** Now at this point we can start including our files, and creating the objects etc.
*** The first object were going to be including is the regsitry object.
**
*/
require_once MANGCUBE_DIR_PATH .'/src/system/registry.php';

$mangocube = new \Mangocube\Registry;

//Add Httpnput to the global registry
$mangocube->httpinput = new \Mangocube\base\HttpInput();

/*
** docs - https://github.com/mattstauffer/Torch/blob/master/components/container/index.php
** laravel container package
*/
$mangocube_container = new Illuminate\Container\Container;
$mangocube_container->bind('mangocube_http', 'Mangocube\base\HttpInput');
$mangocube_http = $mangocube_container->make('mangocube_http');


/*
** All Config file access
**  Use this file anywhere of this plugin
*/

$mangocube_config = new Mangocube_Repository(require MANGCUBE_DIR_PATH . 'src/system/config/app.php');

 // Collection
//  echo '<h2>Collection</h2>';
//  echo '<pre>';
//  $people = new MangocubeCollection(['Declan', 'Abner', 'Mitzi']);

//  $people->map(function ($person) {
// 	 return "<i>$person</i>";
//  })->each(function ($person) {
// 	 echo "Collection person: $person\n";
//  });

// $collection = new MangocubeCollection([
//     ['product' => 'Desk', 'price' => 200],
//     ['product' => 'Chair', 'price' => 100],
//     ['product' => 'Bookcase', 'price' => 150],
//     ['product' => 'Door', 'price' => 100],
// ]);

// $filtered = $collection->where('price', 100);

// dump($filtered->all());

// Create a new MessageBag instance.
// $messageBag = new MangocubeMessageBag;

// // Add new messages to the message bag.
// $messageBag->add('hello', 'The first message bag message');
// $messageBag->add('world', 'The second message');

// dump($messageBag);


// $finder = new Finder();
// $finder->files()->in(__DIR__);

// foreach ($finder as $file) {
//     $contents = $file->getContents();
//     dump($contents); 
//     // ...
// }


// use Symfony\Component\HttpFoundation\Response;

// $response = new Response(
//     'Content',
//     Response::HTTP_OK,
//     ['content-type' => 'text/html']
// );

// dump($response);




