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
class BuizMessage_MiniList_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// display methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function displayElement($params)
  {

    // laden der mvc/utils adapter Objekte
    $user = $this->getUser();
    $acl = $this->getAcl();
    $request = $this->getRequest();

    $params->qsize = 50;
    $params->elementId = 'wgt-grid-buiz-messages-mini_list';

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    $params->searchFormId = 'wgt-form-buiz-messages-mini_list-search';

    $data = $this->model->fetchMiniListMessages($params);

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-navigation-message-mini_list';
    $pageFragment->action = 'replace';

    $pageFragment->addVar( 'data', $data );
    $pageFragment->addVar( 'params', $params );
    $pageFragment->setTemplate('buiz/message/mini/element',true);
    $pageFragment->render();

    $tpl->setArea('message-mini_list', $pageFragment);

    if ($params->append) {

      $jsCode = <<<WGTJS

  \$S('table#{$params->elementId}-table').grid('renderRowLayout').grid('syncColWidth');

WGTJS;
      $this->addJsCode($jsCode);

    } else {

      $jsCode = <<<WGTJS

  \$S('table#{$params->elementId}-table').grid('renderRowLayout').grid('syncColWidth').grid('setNumEntries', {$data->getSourceSize()});

WGTJS;

      $this->addJsCode($jsCode);

    }

  }//end public function displayElement */


  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function displaySearch($params)
  {

    // laden der mvc/utils adapter Objekte
    $user = $this->getUser();
    $acl = $this->getAcl();
    $request = $this->getRequest();

    $params->qsize = 50;

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    $params->searchFormId = 'wgt-form-buiz-groupware-search';

    $data = $this->model->fetchMessages($params);

    $table = new BuizMessage_Table_Element('messageList', $this);
    $table->setId('wgt-table-buiz-groupware_message');
    $table->access = $params->access;

    $table->setData($data);
    $table->addAttributes(array
    (
      'style' => 'width:99%;'
    ));

    $table->setPagingId($params->searchFormId);


    // the table should only replace the content inside of the container
    // but not the container itself
    $table->insertMode = false;

    if ($params->append) {
      $table->setAppendMode(true);
      $table->buildAjax();

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('renderRowLayout').grid('syncColWidth');

WGTJS;
      $this->addJsCode($jsCode);

    } else {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('renderRowLayout').grid('syncColWidth').grid('setNumEntries', {$table->dataSize});

WGTJS;

      $this->addJsCode($jsCode);

      $table->buildHtml();
    }

    $this->setAreaContent('wgt-table-message', $table->buildAjaxArea());

  }//end public function displaySearch */

} // end class BuizMessage_MiniList_Ajax_View */

