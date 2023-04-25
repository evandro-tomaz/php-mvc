<?php
	
	namespace App\Http;
	
	/**
	 *
	 */
	class Request
	{
		/**
		 * @var string
		 */
		private string $httpMethod;
		
		/**
		 * @var string
		 */
		private string $uri;
		
		/**
		 * @var array
		 */
		private array $queryParams = [];
		
		/**
		 * @var array
		 */
		private array $postVars = [];
		
		/**
		 * @var array
		 */
		private array $requestHeaders = [];
		
		/**
		 * CONSTRUTOR
		 */
		public function __construct()
		{
			$this->queryParams = $_GET ?? [];
			$this->postVars = $_POST ?? [];
			$this->requestHeaders = getallheaders();
			$this->httpMethod = $_SERVER['REQUEST_METHOD'];
			$this->uri = $_SERVER['REQUEST_URI'];
		}
		
		/**
		 * @return string
		 */
		public function getHttpMethod(): string
		{
			return $this->httpMethod;
		}
		
		/**
		 * @return string
		 */
		public function getUri(): string
		{
			return $this->uri;
		}
		
		/**
		 * @return array
		 */
		public function getQueryParams(): array
		{
			return $this->queryParams;
		}
		
		/**
		 * @return array
		 */
		public function getPostVars(): array
		{
			return $this->postVars;
		}
		
		/**
		 * @return array
		 */
		public function getRequestHeaders(): array
		{
			return $this->requestHeaders;
		}
		
		
	}