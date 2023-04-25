<?php
	
	namespace App\Models\Entities;
	
	/**
	 * MOCK ========= Deve ser implementado ==========
	 */
	class Organization
	{
		/**
		 * @var int
		 */
		public int $id = 1;
		
		/**
		 * @var string
		 */
		public string $name = 'PHP-MVC';
		
		/**
		 * @var string
		 */
		public string $site = 'https://github.com/evandro-tomaz';
		
		/**
		 * @var string
		 */
		public string $description = 'Um projeto para um Blog usando PHP, MariaDB e Bootstrap baseado no projeto do William Costa do canal WDEV';
	}