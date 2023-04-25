<?php
	
	namespace App\Controllers\Pages;
	
	use App\Models\Entities\Organization;
	use App\Utils\View;
	
	class HomeController extends PageController
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
		public static function getHome(): string
		{
			$objOrganization = new Organization();
			
			$content = View::render('pages/home', [
				'header' => self::getHeader(),
				'footer' => self::getFooter(),
				'name' => $objOrganization->name
			]);
			
			return parent::getPage('HOME', $content);
		}
	}