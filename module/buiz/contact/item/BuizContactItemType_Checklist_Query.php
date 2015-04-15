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
class BuizContactItemType_Checklist_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

/*////////////////////////////////////////////////////////////////////////////*/
// Query Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Fetch method for the BuizAddressItemType Selectbox
   * @return void
   */
  public function fetch()
  {

    $db = $this->getDb();

    if (!$this->criteria)
      $criteria = $db->orm->newCriteria();
    else
      $criteria = $this->criteria;

    $criteria->select(array
    (
      'DISTINCT buiz_address_item_type.access_key as value',
      'buiz_address_item_type.name as label'
     ));
      $criteria->selectAlso('buiz_address_item_type.name as "buiz_address_item_type-m_order-order"');

    $criteria->from('buiz_address_item_type');
    $criteria->where('flag_msg_supported = true');
    $criteria->orderBy('buiz_address_item_type.name ');

    $this->result = $db->orm->select($criteria);

  }//end public function fetch */

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
  public function fetchEntry($entryId)
  {

    // wenn keine korrekte id > 0 übergeben wurde müssen wir gar nicht erst
    // nach einträgen suchen
    if (!$entryId)
      return [];

    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select(array
    (
      'DISTINCT buiz_address_item_type.access_key as value',
      'buiz_address_item_type.name as label'
     ));
    $criteria->from('buiz_address_item_type');

    $criteria->where("buiz_address_item_type.access_key = '{$entryId}'"  );

    return $db->orm->select($criteria)->get();

  }//end public function fetchEntry */

  /**
   * Laden einer definierten Liste von Werten
   * Wird benötigt wenn die Selectbox mit der option multi
   * verwendet wird und einige der aktiven Werte durch die Filter gerutscht sind.
   * siehe auch self::fetchSelectboxEntry
   *
   * @param int $entryId
   * @return void
   */
  public function fetchEntries($entryIds)
  {

    // wenn der array leer ist müssen wir nicht weiter prüfen
    if (!$entryIds)
      return [];

    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select(array
    (
      'DISTINCT buiz_address_item_type.access_key as value',
      'buiz_address_item_type.name as label'
     ));

    $criteria->from('buiz_address_item_type');
    $criteria->where('flag_msg_supported = true');
    $criteria->orderBy('buiz_address_item_type.name ');

    $criteria->where("buiz_address_item_type.access_key IN ('".implode("', '", $entryIds)."')"  );

    return $db->orm->select($criteria)->getAll();

  }//end public function fetchEntries */

}//end class BuizContactItemType_Checklist_Query

