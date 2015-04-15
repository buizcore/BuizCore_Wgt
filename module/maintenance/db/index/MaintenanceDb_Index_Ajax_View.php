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
class MaintenanceDb_Index_Ajax_View extends LibViewAjax
{

 /**
  * Methode zum befüllen des BuizMessage Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayRecalc($params)
  {

    $response = $this->getResponse();

    $response->addMessage('Sucessfully recalculated the Data index');

  }//end public function displayRecalc */

 /**
  * Methode zum befüllen des BuizMessage Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayRecalcEntity($params)
  {

    $response = $this->getResponse();

    $response->addMessage('Sucessfully recalculated the Data index');

  }//end public function displayRecalcEntity */

}//end class DaidalosBdlModules_Ajax_View

