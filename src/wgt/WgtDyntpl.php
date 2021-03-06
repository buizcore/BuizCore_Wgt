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
 *
 * @package net.buizcore.wgt
 */
class WgtDyntpl extends BaseChild
{

  /**
   * @param LibTemplateView $env
   */
  public function __construct($env)
  {

    $this->env = $env;
    $this->view = $env;

  }//end public function __construct */

} // end class WgtDyntpl

