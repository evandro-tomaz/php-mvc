<?php
	
	namespace App\Http;
	
	/**
	 *
	 */
	class Response
	{
		/**
		 * @var int
		 */
		private int $httpCode = 200;
		
		/**
		 * @var array
		 */
		private array $responseHeaders = [];
		
		/**
		 * @var string
		 */
		private string $contentType;
		
		/**
		 * @var mixed
		 */
		private $responseContent;
		
		public function __construct($httpCode, $responseContent, $contentType = 'text/html')
		{
			$this->httpCode = $httpCode;
			$this->responseContent = $responseContent;
			$this->setContentType($contentType);
		}
		
		public function setContentType(string $contentType)
		{
			$this->contentType = $contentType;
			$this->addHeader('Content-Type', $contentType);
		}
		
		public function addHeader(string $key, string $value)
		{
			$this->responseHeaders[$key] = $value;
		}
		
		private function sendHeaders()
		{
			http_response_code($this->httpCode);
			
			foreach ($this->responseHeaders as $key => $value) {
				header($key . ': ' . $value);
			}
		}
		
		public function sendResponse()
		{
			$this->sendHeaders();
			switch ($this->contentType) {
				case 'text/html':
					echo $this->responseContent;
					exit();
			}
		}
	}