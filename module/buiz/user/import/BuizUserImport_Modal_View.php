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
class BuizUserImport_Modal_View extends LibViewModal
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var EventSetup_Model
    */
    public $model = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * Das Edit Form der EventType_Exhibition Maske
  *
  * @param int $objid Die Objid der Hauptentity
  * @param Context $params Flow Control Flags
  *
  * @return null Error im Fehlerfall
  */
  public function displayForm($params)
  {
      
      $this->width = 800;
      $this->height = 600;
      
    // laden der mvc/utils adapter Objekte
    $request = $this->getRequest();
    $response = $this->getResponse();
    $user = $this->getUser();
    $this->params = $params;


    // fetch the i18n text for title, status and bookmark
    $i18nTitle = 'Import Customers';

    // set the maintab title
    $this->setTitle($i18nTitle);

    // set the from template
    $this->setTemplate('buiz/user/import/modal/form', true);

    $this->addVar('params', $params);

    // ok alles gut wir müssen keinen fehler zurückgeben
    return null;

  }//end public function displayMask */

 
}//end class BuizUserImport_Modal_View

