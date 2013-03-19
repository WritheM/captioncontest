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
        if ($this->smarty->debugging)
        {
            $pageRender = array(
                'debug' => $this->debug,
                'title' => $this->title,
                'content' => $this->content,
                'head' => $this->head,
                'body' => $this->body,
                'meta_keywords' => $this->meta_keywords,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'page' => $this->page,
                'page_template' => $this->page_template,
                'smarty' => $this->smarty,
                'serverurl' => $this->serverurl,
                'theme' => $this->theme,
                //'site' => $this->site,
                'secure_connection' => $this->secure_connection,
            );
            $this->smarty->assign('page', $pageRender);
        } 
        else
        {
            $this->smarty->assign('page', $this);
        }
		$this->page_template = "basepage.tpl";			
		
		parent::render();
	}
}