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
        
        if (!$env ) {
            $env = Buizcore::$env;
        }
        
        $this->env = $env;
        $this->getAcl();
        $this->getI18n();
        $this->getCache();
        
        $this->init();
    
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
	public function init() 
	{
	    
	}//end public function init */
	
	/**
	 *
	 */
	public function beforeRender()
	{
	     
	}//end public function beforeRender */

	/**
	 *
	 */
	public function afterRender()
	{
	
	}//end public function afterRender */
	

	/**
	 */
	public function render( )
	{
	   
	    $this->beforeRender();
	    return $this->includeTemplate($this->template);
	    $this->afterRender();
	
	}
	

} // end class LibTemplateWidget */

