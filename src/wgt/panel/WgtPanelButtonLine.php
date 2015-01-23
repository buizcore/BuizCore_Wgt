<?php

/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
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
 * @package net.webfrap.wgt
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

