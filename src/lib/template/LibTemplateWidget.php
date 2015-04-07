<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH
* @project     : BuizCore - The Business Core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.buizcore.wgt
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class LibTemplateWidget extends LibTemplatePublisher
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

   /**
    * the contstructor
    * @param array $conf the configuration loaded from the conf
    */
    public function __construct($view, $env = null)
    {
      
        $this->tplEngine = $view;
        
        $view->assignSubview($this);
        
        if (!$env) {
            $env = Buizcore::$env;
        }
        
        $this->env = $env;
        $this->getAcl();
        $this->getI18n();
        $this->getCache();
        
        $this->___init();
    
    }// end public function __construct */
    
    /**
     * @param TDataObject $var
     * @param TDataObject $object
     * @param TDataObject $area
     */
    public function injectResources($var, $object, $area ) 
    {

        $this->var = new TDataMasterObject($var);
        $this->object = new TDataMasterObject($object);
        $this->area = new TDataMasterObject($area);

	}//end public function injectResources */

	/**
	 * 
	 */
	public function ___init() 
	{
	    
	}//end public function init */
	
	/**
	 *
	 */
	public function ___beforeRender()
	{
	     
	}//end public function beforeRender */

	/**
	 * zum nachbearbeiten des contents soweit gewünscht
	 */
	public function ___afterRender($content)
	{
	   return $content;
	}//end public function afterRender */
	

	/**
	 */
	public function render( )
	{
	   
	    if ($error = $this->___beforeRender()) {
	        return $error;
	    }
	    
	    $content = $this->includeTemplate($this->template);
	    return $this->___afterRender($content);
	
	}//end public function render */
	
	/**
	 * @return string
	 */
	public function __toString() 
	{ 

	    return $this->render();

	}//end public function __toString */
	

} // end class LibTemplateWidget */

