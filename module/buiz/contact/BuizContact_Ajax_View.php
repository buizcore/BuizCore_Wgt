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
class BuizContact_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $menuName
   * @return void
   */
  public function displayNew( $params = null )
  {


    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#buiz-desktop-contact-form';
    $pageFragment->action = 'html';
    $pageFragment->setModel($this->loadModel('BuizContact'));

    $pageFragment->setTemplate( 'buiz/contact/tpl/form_new', true);

    $tpl->setArea('new_contact', $pageFragment);

    $tpl->addJsCode("\$S('#buiz-desktop-contact-form').show();");

  }//end public function displayNew */

}//end class BuizContact_Ajax_View

