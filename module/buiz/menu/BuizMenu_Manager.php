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
class BuizMenu_Manager extends Manager
{


  /**
   * @param unknown $nodeId
   * @param string $menuId
   */
  public function deleteSubMenu($nodeId, $menuId = null)
  {

    $orm = $this->getOrm();

    if (!$menuId) {
      $menuId = $orm->get('BuizMenuEntry',$nodeId)->id_menu;
    }

    $sql = <<<SQL
WITH RECURSIVE menu_tree(rowid, m_parent) AS (
  SELECT
    p_tree.rowid,
    p_tree.m_parent
  FROM buiz_menu_entry p_tree
  WHERE id_menu = {$menuId}
    and rowid = {$nodeId}

  UNION

    SELECT
      c_tree.rowid,
      c_tree.m_parent
    FROM buiz_menu_entry c_tree
    JOIN menu_tree rt ON rt.rowid = c_tree.m_parent
    WHERE id_menu = {$menuId}
)
SELECT rowid FROM menu_tree;
SQL;

    $toDel = $this->getDb()->select($sql)->getColumn('rowid');

    $orm->deleteByList('BuizMenuEntry',$toDel);

  }//end public function deleteSubMenu */


} // end class BuizMenu_Manager

