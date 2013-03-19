<?php
require_once(SMARTY_DIR.'Smarty.class.php');
require_once(WWW_DIR."/lib/users.php");
require_once(WWW_DIR."/lib/site.php");

class BasePage 
{
	public $title = '';
	public $content = '';
	public $head = '';
	public $body = '';
	public $meta_keywords = '';
	public $meta_title = '';
	public $meta_description = ''; 
	public $page = '';   
	public $page_template = ''; 
	public $smarty = '';
	public $userdata = array();
	public $serverurl = '';
	public $theme = 'default';
    public $site = '';
	public $secure_connection = false; 
	
	const FLOOD_THREE_REQUESTS_WITHIN_X_SECONDS = 1.000;
	const FLOOD_PUNISHMENT_SECONDS = 5.0;
	
	function BasePage()
	{			
		@session_start();
        
        ini_set('memory_limit', '512M');
        
		// set site variable
		$s = new Sites();
		$this->site = $s->get();

		$this->smarty = new Smarty();
        
        $this->smarty->__toString = false;

		$this->smarty->template_dir = WWW_DIR.'views'.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR.'templates';
		$this->smarty->compile_dir = SMARTY_DIR.'templates_c'.DIRECTORY_SEPARATOR;
		$this->smarty->config_dir = SMARTY_DIR.'configs'.DIRECTORY_SEPARATOR;
		$this->smarty->cache_dir = SMARTY_DIR.'cache'.DIRECTORY_SEPARATOR;	
		$this->smarty->error_reporting = (E_ALL - E_NOTICE);
		$this->secure_connection = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ;
		
		if (isset($_SERVER["SERVER_NAME"]))
		{
			$this->serverurl = ($this->secure_connection ? "https://" : "http://").$_SERVER["SERVER_NAME"].(($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") ? ":".$_SERVER["SERVER_PORT"] : "").WWW_TOP.'/';
			$this->smarty->assign('serverroot', $this->serverurl);
			$this->smarty->assign('requesturl', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
		}
		
        $this->page = (isset($_GET['page'])) ? $_GET['page'] : 'home';
        
        $pageRender = array(
            'title' => $this->title,
            'content' => $this->content,
            'head' => $this->head,
            'body' => $this->body,
            'meta_keywords' => $this->meta_keywords,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'page' => $this->page,
            'page_template' => $this->page_template,
            //'smarty' => $this->smarty,
            'serverurl' => $this->serverurl,
            'theme' => $this->theme,
            //'site' => $this->site,
            'secure_connection' => $this->secure_connection,
        );
		$this->smarty->assign('page', $pageRender);
        		
        
        //should check if logged in later, if admin bypass the floodcheck.
        $this->floodCheck(false, "");
        
		$this->smarty->assign('site', $this->site);
    }
    
    public function __set($k, $v)
    {
        $this->$k = $v;
    }
    
    public function floodCheck($loggedin, $role)
	{
		//
		// if flood wait set, the user must wait x seconds until they can access a page
		//
		if (empty($argc) && 
			($role != Users::ROLE_ADMIN)&&
			isset($_SESSION['flood_wait_until']) && 
			$_SESSION['flood_wait_until'] > microtime(true))
			{
				$this->showFloodWarning();
			}
		else
		{
			//
			// if user not an admin, they are allowed three requests in FLOOD_THREE_REQUESTS_WITHIN_X_SECONDS seconds
			//
			if(empty($argc) && $role != Users::ROLE_ADMIN)
			{
				if (!isset($_SESSION['flood_check']))
				{
					$_SESSION['flood_check'] = "1_".microtime(true);
				}
				else
				{
					$hit = substr($_SESSION['flood_check'], 0, strpos($_SESSION['flood_check'], "_", 0));
					if ($hit >= 3)
					{
						$onetime = substr($_SESSION['flood_check'], strpos($_SESSION['flood_check'], "_") + 1);
						if ($onetime + BasePage::FLOOD_THREE_REQUESTS_WITHIN_X_SECONDS > microtime(true))
						{
							$_SESSION['flood_wait_until'] = microtime(true) + BasePage::FLOOD_PUNISHMENT_SECONDS;
							unset($_SESSION['flood_check']);
							$this->showFloodWarning();
						}
						else 
						{
							$_SESSION['flood_check'] = "1_".microtime(true);
						}
					}
					else
					{
						$hit++;
						$_SESSION['flood_check'] = $hit.substr($_SESSION['flood_check'], strpos($_SESSION['flood_check'], "_", 0));
					}
				}
			}
		}
	}
    
    //
	// Done in html here to reduce any smarty processing burden if a large flood is underway
	//
	public function showFloodWarning()
	{
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Retry-After: '.BasePage::FLOOD_PUNISHMENT_SECONDS);
		echo "
			<html>
			<head>
				<title>Service Unavailable</title>
			</head>

			<body>
				<h1>Service Unavailable</h1>

				<p>Too many requests!</p> 

				<p>You must <b>wait ".BasePage::FLOOD_PUNISHMENT_SECONDS." seconds</b> before trying again.</p> 

			</body>
			</html>";
		die();
	}

	//
	// Inject content into the html head
	//
	public function addToHead($headcontent) 
	{			
		$this->head = $this->head."\n".$headcontent;
	}	
	
	//
	// Inject js/attributes into the html body tag
	//
	public function addToBody($attr) 
	{			
		$this->body = $this->body." ".$attr;
	}		
	
	public function render() 
	{
        $smarty->caching = true;
        $smarty->cache_lifetime = 120;

		$this->smarty->display($this->page_template);
	}
	
	public function isPostBack()
	{
		return (strtoupper($_SERVER["REQUEST_METHOD"]) === "POST");	
	}
	
	public function show404()
	{
		header("HTTP/1.1 404 Not Found");
		die();
	}
	
	public function show403($from_admin = false)
	{
		$redirect_path = ($from_admin) ? str_replace('/admin', '', WWW_TOP) : WWW_TOP;
		header("Location: $redirect_path/login?redirect=".urlencode($_SERVER["REQUEST_URI"]));
		die();
	}
	
	public function show503($retry='')
	{
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Status: 503 Service Temporarily Unavailable');
		if ($retry != '')
			header('Retry-After: '.$retry);
		
		echo "
			<html>
			<head>
				<title>Service Unavailable</title>
			</head>

			<body>
				<h1>Service Unavailable</h1>

				<p>Your maximum api or download limit has been reached for the day</p> 

			</body>
			</html>";
		die();
	}
	
	//
	// paths cannot be relative anymore so use full path
	//
	public function getCommonTemplate($tpl)
	{
		$len = strlen($this->smarty->theme[0]) - (strlen($this->theme) + 1);
		return substr($this->smarty->theme[0], 0, $len)."common".DIRECTORY_SEPARATOR.$tpl;
	}
}

