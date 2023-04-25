<?php
	
	namespace App\Models\Entities;
	
	use WilliamCosta\DatabaseManager\Database;
	
	/**
	 *
	 */
	class Testimony
	{
		/**
		 * @var int
		 */
		public int $id;
		/**
		 * @var string
		 */
		public string $name;
		/**
		 * @var string
		 */
		public string $message;
		/**
		 * @var string
		 */
		public string $data;
		
		/**
		 * @return bool
		 */
		public function register(): bool
		{
			$this->data = date('Y-m-d H:i:s');
			
			$this->id = (new Database('depoimentos'))->insert([
				'name' => $this->name,
				'message' => $this->message,
				'created_at' => $this->data
			]);
			
			return true;
		}
	}