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
class BuizMaintenance_ProcessNode_Selectbox_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

/*////////////////////////////////////////////////////////////////////////////*/
// Query Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Fetch method for the BuizFileStorage Selectbox
   * @return void
   */
  public function fetchSelectbox($processNode)
  {

    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select(array
    (
      'buiz_process_node.rowid as id',
      'buiz_process_node.label as value'
     ));

    $criteria->from('buiz_process_node');

    $criteria->orderBy('buiz_process_node.m_order ');
    $criteria->where("buiz_process_node.id_process = {$processNode}");

    $this->result = $db->orm->select($criteria);

  }//end public function fetchSelectbox */

  /**
   * Laden einer einzelnen Zeile,
   * Wird benötigt wenn der aktive Wert durch die Filter gerutscht ist.
   * Kann in archive Szenarien passieren.
   * In diesem Fall soll der Eintrag trotzdem noch angezeigt werden, daher
   * wird er explizit geladen
   *
   * @param int $entryId
   * @return void
   */
  public function fetchSelectboxEntry($entryId)
  {

    // wenn keine korrekte id > 0 übergeben wurde müssen wir gar nicht erst
    // nach einträgen suchen
    if (!$entryId)
      return [];

    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select(array
    (
      'buiz_process_node.rowid as id',
      'buiz_process_node.label as value'
     ));

    $criteria->from('buiz_process_node');

    $criteria->orderBy('buiz_process_node.name ');
    $criteria->where("buiz_process_node.rowid = {$entryId}");

    return $db->orm->select($criteria)->get();

  }//end public function fetchSelectboxEntry */

}//end class BuizMaintenance_ProcessNode_Selectbox_Query

