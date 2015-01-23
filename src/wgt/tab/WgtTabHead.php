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
 * Eine Ajax area
 * @package net.buizcore.wgt
 */
class WgtTabHead
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/
    
    /**
     * Das Label des Tags
     * @var string
     */
    public $label;
    
    /**
     * Der Key des Tags
     * @var string
     */
    public $key;
    
    /**
     * Src wenn Inhalte vom Server geladen werden sollen
     * @var string
     */
    public $src;
    
    /**
     * Steuer Flags als Klassen im TabHead
     * @var string
     */
    public $class;
    
    /**
     * Beschreibung / Controls etc
     * @var string
     */
    public $content;

} // end class WgtTabHead

