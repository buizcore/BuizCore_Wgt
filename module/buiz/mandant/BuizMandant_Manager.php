<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore.com internal only
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class BuizMandant_Manager extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * Die ID des Standard Mandanten zurückgeben
   * @return int
   */
  public function getDefaultMandant()
  {

    ///@TODO error handling

    $orm = $this->getOrm();
    $conf = $this->getConf();

    $mandant = $conf->getStatus('default_mandant');
    return $orm->getIdByKey('BuizRoleMandant', $mandant);


  }//end public function getDefaultMandant */




} // end class BuizMandant_Manager

