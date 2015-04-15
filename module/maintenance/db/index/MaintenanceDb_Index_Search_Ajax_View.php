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
class MaintenanceDb_Index_Search_Ajax_View extends LibViewAjax
{

  /**
   * @param BdlNodeEntityAttribute $attribute
   * @param int $index
   * @param string $entityName
   */
  public function displaySearchResult($result, $params)
  {

    $html = '';

    $pos = 1;
    foreach ($result as $row) {

      $html .= <<<XML
      <tr>
        <td class="pos" >{$pos}</td>
        <td>{$row['entity_name']}</td>
        <td><a class="wcm wcm_req_ajax" href="maintab.php?c={$row['default_edit']}&objid={$row['vid']}" >{$row['name']}</a></td>
        <td>{$row['title']}</td>
        <td>{$row['key']}</td>
        <td>{$row['rank']}</td>
        <td>{$row['description']}</td>
      </tr>
XML;
      ++$pos;
    }

    $this->setAreaContent('searchResult', <<<XML
<htmlArea selector="table#wgt-table-maintenance-db_index-search>tbody" action="html" ><![CDATA[
{$html}
]]></htmlArea>
XML
    );

  }//end public function displaySearchResult */

}//end class MaintenanceDb_Index_Search_Ajax_View

