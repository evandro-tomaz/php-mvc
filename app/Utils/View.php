<?php
	
	namespace App\Utils;
	
	/**
	 *
	 */
	class View
	{
		private static $vars = [];
		
		public static function init(array $vars = [])
		{
			self::$vars = $vars;
		}
		
		/**
		 * Verifica se existe o arquivo passado através do caminho que chega na entrada
		 * @param string $view
		 * @return string
		 */
		private static function getContentView(string $view): string
		{
			$file = __DIR__ . '/../../resources/view/' . $view . '.html';
			return file_exists($file) ? file_get_contents($file) : '';
		}
		
		/**
		 * Obtem e retorna o conteúdo de uma view processando as variáveis
		 * @param string $view
		 * @param array $vars (string/numeric)
		 * @return string
		 */
		public static function render(string $view, array $vars = []): string
		{
			$viewContent = self::getContentView($view);
			
			$vars = array_merge(self::$vars, $vars);
			
			//CHAVES PARA O MAPEAMENTO
			$keys = array_keys($vars);
			$keys = array_map(function ($item) {
				return '{{' . $item . '}}';
			}, $keys);
			
			return str_replace($keys, array_values($vars), $viewContent);
		}
	}