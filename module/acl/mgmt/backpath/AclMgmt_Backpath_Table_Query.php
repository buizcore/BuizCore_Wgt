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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>

 */
class AclMgmt_Backpath_Table_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /** build criteria, interpret conditions and load data
   *
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $params
   *
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch($areaId, $condition = null, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize = null;
    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();
    $this->setCols($criteria);
    $this->setTables($criteria);
    $this->appendConditions($criteria, $condition, $params);
    $this->checkLimitAndOrder($criteria, $params);

    $criteria->where("buiz_security_backpath.id_area = {$areaId}");

    // Run Query und save the result
    $this->result = $db->orm->select($criteria);
    $this->calcQuery = $criteria->count('count(DISTINCT buiz_security_backpath.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetch */
  
  /** build criteria, interpret conditions and load data
   *
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $params
   *
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchById($areaId, $pathId, $condition = null, $params = null)
  {
  
    if (!$params)
      $params = new TFlag();
  
    $this->sourceSize = null;
    $db = $this->getDb();
  
    $criteria = $db->orm->newCriteria();
    $this->setCols($criteria);
    $this->setTables($criteria);
    $this->appendConditions($criteria, $condition, $params);
    $this->checkLimitAndOrder($criteria, $params);
  
    $criteria->where("buiz_security_backpath.id_area = {$areaId}");
    $criteria->where("buiz_security_backpath.rowid = {$pathId}");
  
    // Run Query und save the result
    $this->result = $db->orm->select($criteria);
    $this->calcQuery = $criteria->count('count(DISTINCT buiz_security_backpath.'.Db::PK.') as '.Db::Q_SIZE);
  
  }//end public function fetch */

 /** inject the requested cols in the criteria
   *
   * to add more cols overwrite this method, or create more methods that also
   * inject cols.
   * It't not expected that you try to remove a onetime setted col, so think
   * about what you are going to do.
   *
   * @param LibSqlCriteria $criteria
   * @return void
   */
  public function setCols($criteria)
  {

    ///TODO remove one of redundant id_group attributes
    // take care for the getEntryData method on the model
    $cols = array(
      'buiz_security_backpath.rowid as "buiz_security_backpath_rowid"',
      'buiz_security_backpath.ref_field as "buiz_security_backpath_ref_field"',
      'buiz_security_backpath.groups as "buiz_security_backpath_groups"',
      'buiz_security_backpath.set_groups as "buiz_security_backpath_set_groups"',
      'buiz_security_backpath.access_level as "buiz_security_backpath_access_level"',
      'buiz_security_backpath.ref_access_level as "buiz_security_backpath_ref_access_level"',
      'buiz_security_backpath.meta_level as "buiz_security_backpath_meta_level"',
      'buiz_security_backpath.message_level as "buiz_security_backpath_message_level"',
      'buiz_security_backpath.priv_message_level as "buiz_security_backpath_priv_message_level"',
      'buiz_security_area.access_key as target_area_key',
    );

    $criteria->select($cols);

  }//end public function setCols */

  /**
   * inject the table an join conditions in the criteria object
   * to append new join conditions overwrite this method, or create a second
   * method that injects more join conditions
   *
   * @param LibSqlCriteria $criteria
   * @return void
   */
  public function setTables($criteria   )
  {

    $criteria->from('buiz_security_backpath');

    $criteria->leftJoinOn(
      'buiz_security_backpath',
      'id_target_area',
      'buiz_security_area',
      'rowid'
    );


  }//end public function setTables */

  /** inject conditions in the criteria object
   *
   * this method checks if there where conditions that has to injected in the
   * criteria
   * if condition is a int value the method expects to get the rowid
   * if condition is a string, the system expects to get a query fragment
   * if condition is an array the variable is delegated to checkConditions to be
   *   interpreted by convention
   *
   * if there's a flag begin on $params the system expect that this is a char
   * that sould be used to filter by a beginning char
   *
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   * @param TFlag $params
   * @return void
   */
  public function appendConditions($criteria, $condition, $params)
  {



  }//end public function appendConditions */


 /** check for limits, offset and order
   *
   * this method checks if there are parameters to manipulate the query result
   * - limit: if -1 the system sets no limit, if the limit is bigger than 500
   *          the system automatically resets the limit to 500
   * - offset: the offset for the query pointer
   * - order: an array of orders
   *
   * @param LibSqlCriteria $criteria
   * @param TArray $params
   * @return void
   */
  public function checkLimitAndOrder($criteria, $params  )
  {

    // check if there is a given order
    if ($params->order) {
      $criteria->orderBy($params->order);
    } else { // if not use the default
      $criteria->orderBy('buiz_security_area.access_key');
    }

    // Check the offset
    if ($params->start) {
      if ($params->start < 0)
        $params->start = 0;
    } else {
      $params->start = null;
    }
    $criteria->offset($params->start);

    // Check the limit
    if (-1 == $params->qsize) {
      // no limit if -1
      $params->qsize = null;
    } elseif ($params->qsize) {
      // limit must not be bigger than max, for no limit use -1
      if ($params->qsize > Wgt::$maxListSize)
        $params->qsize = Wgt::$maxListSize;
    } else {
      // if limit 0 or null use the default limit
      $params->qsize = Wgt::$defListSize;
    }

    $criteria->limit($params->qsize);

  }//end public function checkLimitAndOrder */

} // end class AclMgmt_Backpath_Table_Query */

