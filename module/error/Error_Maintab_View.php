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
class Error_Maintab_View extends LibViewMaintabCustom
{

  /**
   *
   */
  public function displayException($exception)
  {

    $this->setTemplate('error/display_exception');
    $this->addVar('exception', $exception);

    // Setzen der Crumbs
    $this->crumbs->setCrumbs(
      array(
        array(
          'Dashboard',
          '',
          'fa fa-dashboard',
          null,
          'wgt-ui-desktop'
        ),
        array(
          'Menu',
          'maintab.php?c=Buiz.Navigation.explorer',
          'fa fa-sitemap',
          null,
          'wgt_tab-maintenance-menu'
        )
      )
    );

    // add the button actions for create in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS
// close tab
self.getObject().find(".wgtac_close").click(function() {
  self.close();
});

BUTTONJS;

    $this->addJsCode($code);

  }//end public function displayException */

  /**
   *
   */
  public function displayEnduserError($exception)
  {

    $this->setTemplate('error/display_exception');
    $this->addVar('exception', $exception);

    // Setzen der Crumbs
    $this->crumbs->setCrumbs(
      array(
        array(
          'Dashboard',
          '',
          'fa fa-dashboard',
          null,
          'wgt-ui-desktop'
        ),
        array(
          'Menu',
          'maintab.php?c=Buiz.Navigation.explorer',
          'fa fa-sitemap',
          null,
          'wgt_tab-maintenance-menu'
        )
      )
    );

    // add the button actions for create in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS
// close tab
self.getObject().find(".wgtac_close").click(function() {
  self.close();
});

BUTTONJS;

    $this->addJsCode($code);

  }//end public function displayEnduserError */

} // end class Error_Maintab_View

