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
class BuizDataConnector_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param BuizDataConnector_Search_Request $searchReq
   * @return void
   */
  public function displaySearch($searchReq  )
  {

    $result = $this->model->search($searchReq);
    
    $menuBuilder = new WgtMenuBuilder_SplitButton($this);
    $menuBuilder->actions = array('connect');
    
    $menuBuilder->buttons = array(
      'connect' => array(
        Wgt::ACTION_JS,
        'Connect',
        '$S(\'#'.$searchReq->cbElement.'\').trigger(\'connect\',[\'{$id}\'])',
        'fa fa-external-link',
        '',
        null
      ),
    );
    
    
    $html = '';
    $pos = 1;
    
    foreach ($result as $row) {

      $html .= <<<XML
      <tr>
        <td class="pos" >{$pos}</td>
        <td>{$row['entity_name']}</td>
        <td>{$row['title']}</td>
        <td>{$row['key']}</td>
        <td>{$row['description']}</td>
        <td>{$menuBuilder->buildRowMenu($row,$row['vid'])}</td>
      </tr>
XML;
      ++$pos;
    }

    $this->setAreaContent('searchResult', <<<XML
<htmlArea selector="table#{$searchReq->elid}>tbody" action="html" ><![CDATA[
{$html}
]]></htmlArea>
XML
    );

  }//end public function displaySearch */

} // end class BuizDataConnector_Ajax_View */

