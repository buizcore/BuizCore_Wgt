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
class BuizUserImport_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var BuizUserImport_Model
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
  */
  public function displayUpload($params)
  {
      

      $area = $this->newArea('import');
      $area->position = '#wgt-box-buiz_user_import';
      $area->setTemplate( 'buiz/user/import/ajax/form', true );
      
      $area->addVar('manager', $this->model->manager );


  }//end public function displayUpload */
  
  /**
   * Das Edit Form der EventType_Exhibition Maske
   *
   * @param int $objid Die Objid der Hauptentity
   * @param Context $params Flow Control Flags
   *
   */
  public function displayImport($params)
  {
  
  
      $area = $this->newArea('import');
      $area->position = '#wgt-box-buiz_user_import';
      $area->setTemplate( 'buiz/user/import/ajax/import', true );
  
      $area->addVar('manager', $this->model->manager );
  
  
  }//end public function displayImport */

 
}//end class BuizUserImport_Ajax_View

