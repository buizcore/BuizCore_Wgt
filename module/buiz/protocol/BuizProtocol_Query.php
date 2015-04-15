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
class BuizProtocol_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// queries
/*////////////////////////////////////////////////////////////////////////////*/

 /**
   * Loading the tabledata from the database
   * @param string/array $entityKey conditions for the query
   * @param string/array $params how should the query be orderd
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchFullProtocol( $params)
  {

    $this->sourceSize = null;
    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $cols = array
    (
      'buiz_protocol_message.message  as buiz_protocol_message_message',
      'buiz_protocol_message.context  as buiz_protocol_message_context',
      'buiz_protocol_message.m_time_created  as buiz_protocol_m_time_created',
      'buiz_protocol_message.m_role_created  as buiz_protocol_m_role_created',
      'buiz_protocol_message.vid      as buiz_protocol_message_vid',
      'buiz_protocol_message.rowid    as buiz_protocol_message_rowid',
      'view_person_role.core_person_firstname ',
      'view_person_role.core_person_lastname '
    );

    $criteria->select($cols);

    $criteria->from('buiz_protocol_message');

    $criteria->leftJoinOn
    (
      'buiz_protocol_message',
      'm_role_created',
      'view_person_role',
      'buiz_role_user_rowid'
    );// attribute reference

    $this->checkLimitAndOrder($criteria, $params);

    // Run Query und save the result
    $this->result = $db->orm->select($criteria);
    $this->calcQuery = $criteria->count('count(buiz_protocol_message.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetchFullProtocol */

 /**
   * Loading the tabledata from the database
   * @param string/array $entityKey conditions for the query
   * @param string/array $params how should the query be orderd
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchEntityProtocol($entityKey , $params)
  {

    $this->sourceSize = null;
    $db = $this->getDb();

    $entityId = $db->orm->getResourceId($entityKey);
    $criteria = $db->orm->newCriteria();

    $cols = array
    (
      'buiz_protocol_message.message  as buiz_protocol_message_message',
      'buiz_protocol_message.context  as buiz_protocol_message_context',
      'buiz_protocol_message.m_time_created  as buiz_protocol_m_time_created',
      'buiz_protocol_message.m_role_created  as buiz_protocol_m_role_created',
      'buiz_protocol_message.vid      as buiz_protocol_message_vid',
      'buiz_protocol_message.rowid    as buiz_protocol_message_rowid',
      'view_person_role.core_person_firstname ',
      'view_person_role.core_person_lastname '
    );

    $criteria->select($cols);

    $criteria->from('buiz_protocol_message');

    $criteria->leftJoinOn
    (
      'buiz_protocol_message',
      'm_role_created',
      'view_person_role',
      'buiz_role_user_rowid'
    );// attribute reference

    //Wenn ein Standard Condition gesetzt wurde dann kommt diese in die Query
    $criteria->where(' buiz_protocol_message.id_vid_entity = '.$entityId);

    $this->checkLimitAndOrder($criteria, $params);

    // Run Query und save the result
    $this->result = $db->orm->select($criteria);
    $this->calcQuery = $criteria->count('count(buiz_protocol_message.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetchEntityProtocol */

 /**
   * Loading the tabledata from the database
   * @param string/array $entityKey conditions for the query
   * @param string/array $params how should the query be orderd
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchDatasetProtocol($entityKey, $objid, $params)
  {

    $this->sourceSize = null;
    $db = $this->getDb();

    $entityId = $db->orm->getResourceId($entityKey);
    $criteria = $db->orm->newCriteria();

    $cols = array
    (
      'buiz_protocol_message.message  as buiz_protocol_message_message',
      'buiz_protocol_message.context  as buiz_protocol_message_context',
      'buiz_protocol_message.m_time_created  as buiz_protocol_m_time_created',
      'buiz_protocol_message.m_role_created  as buiz_protocol_m_role_created',
      'buiz_protocol_message.vid      as buiz_protocol_message_vid',
      'buiz_protocol_message.rowid    as buiz_protocol_message_rowid',
      'view_person_role.core_person_firstname ',
      'view_person_role.core_person_lastname '
    );

    $criteria->select($cols);

    $criteria->from('buiz_protocol_message');

    $criteria->leftJoinOn
    (
      'buiz_protocol_message',
      'm_role_created',
      'view_person_role',
      'buiz_role_user_rowid'
    );// attribute reference

    //Wenn ein Standard Condition gesetzt wurde dann kommt diese in die Query
    $criteria->where(' buiz_protocol_message.id_vid_entity = '.$entityId.' and buiz_protocol_message.vid = '.$objid);

    $this->checkLimitAndOrder($criteria, $params);

    // Run Query und save the result
    $this->result = $db->orm->select($criteria);
    $this->calcQuery = $criteria->count('count(buiz_protocol_message.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetchDatasetProtocol */

/*////////////////////////////////////////////////////////////////////////////*/
// append query parts
/*////////////////////////////////////////////////////////////////////////////*/

 /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @param $params
   * @return void
   */
  public function checkLimitAndOrder($criteria, $params  )
  {

    // check if there is a given order
    if ($params->order)
      $criteria->orderBy($params->order);
    else // if not use the default
      $criteria->orderBy('buiz_protocol_message.m_time_created desc');

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

}//end class BuizProtocol_Query

