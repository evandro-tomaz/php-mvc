<?php
	
	namespace App\Controllers\Pages;
	
	use App\Http\Request;
	use App\Models\Entities\Organization;
	use App\Models\Entities\Testimony;
	use App\Utils\View;
	
	class TestimoniesController extends PageController
	{
		/**
		 * @return string
		 */
		private static function getHeader(): string
		{
			return View::render('pages/shared/header');
		}
		
		/**
		 * @return string
		 */
		private static function getFooter(): string
		{
			return View::render('pages/shared/footer');
		}
		
		/**
		 * Controlador da View HomeController que retorna o conteúdo da view
		 * @return string
		 */
		public static function getTestimonies(): string
		{
			$objOrganization = new Organization();
			
			$content = View::render('pages/testimonies', [
				'header' => self::getHeader(),
				'footer' => self::getFooter(),
				'name' => $objOrganization->name
			]);
			
			return parent::getPage('DEPOIMENTOS', $content);
		}
		
		/**
		 * @param Request $request
		 * @return string
		 */
		public static function insert(Request $request): string
		{
			$postVars = $request->getPostVars();
			
			$testimony = new Testimony;
			
			$testimony->name = $postVars['inputName'];
			$testimony->message = $postVars['inputMessage'];
			
			$testimony->register();
			
			return self::getTestimonies();
		}
	}