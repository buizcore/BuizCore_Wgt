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
class BuizAuth_Query extends LibSqlQuery
{

 /**
   * Loading the tabledata from the database
   * @param string $email
   * @return array
   */
  public function dataUserByEmail($email  )
  {

    $db = $this->getDb();
    $criteria = $db->orm->newCriteria();
    $criteria->select('buiz_role_user.*')->from('buiz_role_user');

    $criteria->joinOn
    (
      'buiz_role_user',     // the base table
      'rowid',                // id in base table (here we always join the pk of base)
      'buiz_address_item',  // the join table
      'id_user'               // id for the join
    );

    $criteria->joinOn
    (
      'buiz_address_item',      // the base table
      'id_type',                    // id in base table (here we always join the pk of base)
      'buiz_address_item_type', // the join table
      'rowid'                   // id for the join
    );

    //Wenn ein Standard Condition gesetzt wurde dann kommt diese in die Query
    $criteria->where
    (
      " upper(buiz_address_item.address_value) = upper('{$email}')
          and buiz_address_item_type.access_key) = upper('mail') "
    );

    // Run Query und save the result
    $this->result = $db->orm->select($criteria);

    return $this->get();

  }//end public function dataUserByEmail */

}//end class ProjectIspcatsImport_Query

