<?php
	
	namespace App\Controllers\Pages;
	
	use App\Models\Entities\Organization;
	use App\Utils\View;
	
	class AboutController extends PageController
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
		public static function getAbout(): string
		{
			$objOrganization = new Organization();
			
			$content = View::render('pages/about', [
				'header' => self::getHeader(),
				'footer' => self::getFooter(),
				'name' => $objOrganization->name,
				'description' => $objOrganization->description,
				'site' => $objOrganization->site
			]);
			
			return parent::getPage('SOBRE', $content);
		}
	}