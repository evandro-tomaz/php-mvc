<?php
	
	use App\Http\Response;
	use App\Controllers\Pages;
	use App\Http\Router;
	
	$route = new Router(URL);
	
	$route->get('/', [
		fn() => new Response(200, Pages\HomeController::getHome())
	]);
	
	$route->get('/sobre', [
		fn() => new Response(200, Pages\AboutController::getAbout())
	]);
	
	$route->get('/depoimentos', [
		fn() => new Response(200, Pages\TestimoniesController::getTestimonies())
	]);
	
	$route->post('/depoimentos', [
		fn($request) => new Response(200, Pages\TestimoniesController::insert($request))
	]);
	
	$route->run()->sendResponse();