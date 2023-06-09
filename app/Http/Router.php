<?php
	
	namespace App\Http;
	
	use Closure;
	use Exception;
	use ReflectionFunction;
	
	/**
	 *
	 */
	class Router
	{
		/**
		 * @var string
		 */
		private string $url;
		
		/**
		 * @var string
		 */
		private string $prefix = '';
		
		/**
		 * @var array
		 */
		private array $routes;
		
		/**
		 * @var Request
		 */
		private Request $request;
		
		/**
		 * @param $url
		 */
		public function __construct($url)
		{
			$this->request = new Request();
			$this->url = $url;
			$this->setPrefix();
		}
		
		/**
		 * @return void
		 */
		private function setPrefix()
		{
			$parseUrl = parse_url($this->url);
			
			$this->prefix = $parseUrl['path'] ?? '';
		}
		
		/**
		 * @param string $method
		 * @param string $route
		 * @param array $params
		 * @return array
		 */
		private function addRoute(string $method, string $route, array $params = []): array
		{
			foreach ($params as $key => $value) {
				if ($value instanceof Closure) {
					$params['controller'] = $value;
					unset($params[$key]);
				}
			}
			
			$params['variables'] = [];
			
			$patternVariable = '/{(.*?)}/';
			
			if (preg_match_all($patternVariable, $route, $matches))
			{
				$route = preg_replace($patternVariable, '(.*?)', $route);
				$params['variables'] = $matches[1];
			}
			
			$patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
			
			return $this->routes[$patternRoute][$method] = $params;
		}
		
		/**
		 * @param string $route
		 * @param array $params
		 * @return array
		 */
		public function get(string $route, array $params = []): array
		{
			return $this->addRoute('GET', $route, $params);
		}
		
		/**
		 * @param string $route
		 * @param array $params
		 * @return array
		 */
		public function post(string $route, array $params = []): array
		{
			return $this->addRoute('POST', $route, $params);
		}
		
		/**
		 * @param string $route
		 * @param array $params
		 * @return array
		 */
		public function put(string $route, array $params = []): array
		{
			return $this->addRoute('PUT', $route, $params);
		}
		
		/**
		 * @param string $route
		 * @param array $params
		 * @return array
		 */
		public function delete(string $route, array $params = []): array
		{
			return $this->addRoute('DELETE', $route, $params);
		}
		
		/**
		 * @return string
		 */
		private function getUri(): string
		{
			$uri = $this->request->getUri();
			
			$xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
			
			return end($xUri);
		}
		
		/**
		 * @return mixed
		 * @throws Exception
		 */
		private function getRoute()
		{
			$uri = $this->getUri();
			$httpMethod = $this->request->getHttpMethod();
			foreach ($this->routes as $patternRoute=>$methods)
			{
				if (preg_match($patternRoute, $uri, $matches))
				{
					if (isset($methods[$httpMethod]))
					{
						unset($matches[0]);
						
						$keys = $methods[$httpMethod]['variables'];
						$methods[$httpMethod]['variables'] = array_combine($keys, $matches);
						$methods[$httpMethod]['variables']['request'] = $this->request;
						
						return $methods[$httpMethod];
					}
					throw new Exception("Método não permitido", 405);
				}
			}
			throw new Exception("URL não encontrada", 404);
		}
		
		/**
		 * @return Response
		 */
		public function run(): Response
		{
			try
			{
				$route = $this->getRoute();
				
				if (!isset($route['controller']))
				{
					throw new Exception("URL não pôde ser processada", 500);
				}
				
				$args = [];
				
				$reflection = new ReflectionFunction($route['controller']);
				foreach ($reflection->getParameters() as $parameter)
				{
					$name = $parameter->getName();
					$args[$name] = $route['variables'][$name] ?? '';
				}
				
				return call_user_func_array($route['controller'], $args);
			}
			catch (Exception $e)
			{
				return new Response($e->getCode(), $e->getMessage());
			}
		}
	}