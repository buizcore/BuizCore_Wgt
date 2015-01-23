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
abstract class LibTemplatePresenter extends LibTemplate
{

  /**
   * de:
   * Dropmenu builder für die Maintab, Subwindow etc View Elemente
   * @var WgtDropmenu
   */
  public $menu = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see src/lib/LibTemplate::setModel()
   */
  public function setModel($model)
  {
    $this->model = $model;
  }//end public function setModel */



} // end class LibTemplateHtml

