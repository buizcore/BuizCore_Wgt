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
 * Basisklasse für Table Panels
 *
 * @package net.buizcore.wgt
 */
class WgtPanelButtonLine extends WgtPanelElement
{
    /* //////////////////////////////////////////////////////////////////////////// */
    // Attributes
    /* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     *
     * @var string
     */
    public $dKey = null;

    /**
     *
     * @var Entity
     */
    public $entity = null;
    
    /* //////////////////////////////////////////////////////////////////////////// */
    // build method
    /* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     *
     * @var Base $env
     */
    public function __construct($env)
    {

        $this->env = $env;
    
    } // end public function __construct */

    /**
     *
     * @return string
     */
    public function render()
    {

        $this->setUp();
        
        $html = '';
        
        return $html;
    
    } // end public function render */

}//end class WgtPanelButtonLine

