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
class BuizMaintenance_Metadata_Modal_View extends LibViewModal
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var BuizMaintenance_Metadata_Model
    */
    public $model = null;

    public $listMenu = null;

    /**
     * @var int
     */
    public $width = 600;

    /**
     * @var int
     */
    public $height = 500;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * Methode zum befüllen des BuizMessage Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayStats()
  {

    $i18nLabel = $this->i18n->l(
      'Metadata Stats',
      'wbf.label'
    );

    $this->listMenu = new BuizTaskPlanner_List_Menu($this);

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle($i18nLabel);
    $this->setLabel($i18nLabel);

    // set the form template
    $this->setTemplate('buiz/maintenance/metadata/data_stats', true);

  }//end public function displayStats */

}//end class BuizMaintenance_ProcessStatus_Modal_View

