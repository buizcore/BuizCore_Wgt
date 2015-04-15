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
class BuizFileType_Selectbox_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

/*////////////////////////////////////////////////////////////////////////////*/
// Query Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Fetch method for the BuizFileType Selectbox
   * @return void
   */
  public function fetchSelectbox($maskKey = null)
  {

    $db = $this->getDb();

    $hasReferences = 0;

    if ($maskKey) {

      if (is_string($maskKey)) {

      $sql = <<<SQL
SELECT COUNT(asgd.rowid) as num_asgd
  from buiz_vref_file_type asgd
JOIN
  buiz_management mgmt
    on asgd.vid = mgmt.rowid
WHERE
  UPPER(mgmt.access_key) = UPPER('{$maskKey}');
SQL;

      $hasReferences = $db->select($sql)->getField('num_asgd');

      }

    }

    if (!$this->criteria)
      $criteria = $db->orm->newCriteria();
    else
      $criteria = $this->criteria;

    $criteria->select(array(
	      'buiz_file_type.rowid as id',
	      'buiz_file_type.name as value',
	      'buiz_file_type.description as content'
    	),true
    );

    $criteria->from('buiz_file_type');

    if ($maskKey && is_array($maskKey)) {

      $searchKey =  "UPPER('".implode("'), UPPER('", $maskKey)."')" ;
      $criteria->where("UPPER(buiz_file_type.access_key) IN({$searchKey})");
    } elseif ($hasReferences) {

      $criteria->joinOn(
        'buiz_file_type', 'rowid',
        'buiz_vref_file_type', 'id_type'
      );
      $criteria->joinOn(
        'buiz_vref_file_type', 'vid',
        'buiz_management', 'rowid'
      );
      $criteria->where("UPPER(buiz_management.access_key) = UPPER('{$maskKey}')");

    } else {

      $criteria->where('buiz_file_type.flag_global = TRUE');
    }

    $criteria->orderBy('buiz_file_type.name ');

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

    $criteria->select(array(
      'DISTINCT buiz_file_type.rowid as id',
      'buiz_file_type.name as value',
      'buiz_file_type.description as content'
    ));
    $criteria->from('buiz_file_type');

    $criteria->where("buiz_file_type.rowid = '{$entryId}'"  );

    return $db->orm->select($criteria)->get();

  }//end public function fetchSelectboxEntry */

  /**
   * Laden einer definierten Liste von Werten
   * Wird benötigt wenn die Selectbox mit der option multi
   * verwendet wird und einige der aktiven Werte durch die Filter gerutscht sind.
   * siehe auch self::fetchSelectboxEntry
   *
   * @param int $entryId
   * @return void
   */
  public function fetchSelectboxEntries($entryIds)
  {

    // wenn der array leer ist müssen wir nicht weiter prüfen
    if (!$entryIds)
      return [];

    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select(array(
      'DISTINCT buiz_file_type.rowid as id',
      'buiz_file_type.name as value',
      'buiz_file_type.description as content'
     ));
    $criteria->from('buiz_file_type');

    $criteria->where("buiz_file_type.rowid IN ('".implode("', '", $entryIds)."')"  );

    return $db->orm->select($criteria)->getAll();

  }//end public function fetchSelectboxEntries */

}//end class BuizFileType_Selectbox_Query

