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
class AclMgmt_Table_Query extends LibSqlQuery
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
  public function fetch($areaKeys, $condition = null, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize = null;
    $db = $this->getDb();

    if (!$this->criteria) {
      $criteria = $db->orm->newCriteria();
    } else {
      $criteria = $this->criteria;
    }

    if (!$criteria->cols) {
      $this->setCols($criteria);
    }

    $this->setTables($criteria);
    $this->appendConditions($criteria, $condition, $params  );
    $this->checkLimitAndOrder($criteria, $params);

    $keys = "'".implode("', '",$areaKeys)."'";
    $criteria->where("area.access_key IN({$keys}) and security_access.partial = 0");

    // Run Query und save the result
    $this->result = $db->orm->select($criteria);
    $this->calcQuery = $criteria->count('count(DISTINCT security_access.'.Db::PK.') as '.Db::Q_SIZE);

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
      'security_access.rowid as "security_access_rowid"',
      'area.access_key as area_key',
      'security_access.access_level as "security_access_access_level"',
      'security_access.ref_access_level as "security_access_ref_access_level"',
      'security_access.meta_level as "security_access_meta_level"',
      'security_access.message_level as "security_access_message_level"',
      'security_access.priv_message_level as "security_access_priv_message_level"',
      'security_access.date_start as "security_access_date_start"',
      'security_access.date_end as "security_access_date_end"',
      'role_group.name as "role_group_name"',
      'role_group.rowid as "role_group_rowid"',
      'count(distinct group_users.id_user) as num_assignments',
    );

    $criteria->select($cols);
    $criteria->groupBy('role_group.rowid');
    $criteria->groupBy('role_group.name');
    $criteria->groupBy('area.access_key');
    $criteria->groupBy('security_access.rowid');
    $criteria->groupBy('security_access.access_level');
    $criteria->groupBy('security_access.ref_access_level');
    $criteria->groupBy('security_access.message_level');
    $criteria->groupBy('security_access.priv_message_level');
    $criteria->groupBy('security_access.meta_level');
    $criteria->groupBy('security_access.date_start');
    $criteria->groupBy('security_access.date_end');

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

    $criteria->from('buiz_security_access security_access', 'security_access');

    $criteria->leftJoinOn (
      'security_access',
      'id_group',
      'buiz_role_group',
      'rowid',
      null,
      'role_group'
    );

    $criteria->leftJoinOn (
      'security_access',
      'id_group',
      'buiz_group_users',
      'id_group',
      null,
      'group_users'
    );

    $criteria->leftJoinOn (
      'security_access',
      'id_area',
      'buiz_security_area',
      'rowid',
      null,
      'area'
    );

    $criteria->leftJoinOn (
      'area',
      'id_type',
      'buiz_security_area_type',
      'rowid',
      null,
      'area_type'
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


    if (isset($condition['free']) && trim($condition['free']) != ''  ) {

       if (ctype_digit($condition['free'])) {
          $criteria->where(
            '(security_access.rowid = \''.$condition['free'].'\')'
          );
       } else {
          $criteria->where(
            '( upper(role_group.name) like upper(\'%'.$condition['free'].'%\'))'
          );
       }

    }//end if


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
    $criteria->orderBy('area_type.m_order desc');
    $criteria->orderBy('role_group.name');
    $criteria->groupBy('area_type.m_order');
    $criteria->groupBy('role_group.name');
    
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

} // end class AclMgmt_Table_Query */

