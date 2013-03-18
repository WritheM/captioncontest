<?php
require_once(WWW_DIR."/lib/framework/basepage.php");

/**
 * This class represents every normal user page in the site.
 */
class Page extends BasePage
{    	
	/**
	 * Default constructor.
	 */
	function Page()
	{	
		parent::BasePage();
        
    }
    
	/**
	 * Output the page.
	 */
	public function render() 
	{			
		//$this->smarty->assign('page',$this);
		$this->page_template = "basepage.tpl";				
		
		parent::render();
	}
}