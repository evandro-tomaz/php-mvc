<?php
	
	namespace App\Controllers\Pages;
	
	use App\Utils\View;
	
	/**
	 *
	 */
	class PageController
	{
		/**
		 * Controlador que monta a página genérica padrão compartilhada
		 * @param string $title
		 * @param string $body
		 * @return string
		 */
		public static function getPage(string $title, string $body): string
		{
			return View::render('pages/shared/page', [
				'pageTitle' => $title,
				'body' => $body
			]);
		}
	}