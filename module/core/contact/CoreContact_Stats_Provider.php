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
class CoreContact_Stats_Provider extends Provider
{

  /**
   * @return int
   */
  public function countContacts()
  {
      
    $db = $this->getDb();
      
    $sql = <<<SQL
SELECT
  count(contact.rowid) as number
FROM
  core_contact_r contact;
SQL;
      
      return $db->select($sql)->getField('number');
      
  }//end public function countContacts */

  /**
   * @return int
   */
  public function countPersonContacts()
  {

        $db = $this->getDb();
      
    $sql = <<<SQL
SELECT
  count(contact.rowid) as number
FROM
  core_contact_r contact
JOIN core_person_r person
    ON contact.id_person = person.rowid
WHERE person.type = 1;
    
SQL;
      
      return $db->select($sql)->getField('number');

  }//end public function countPersonContacts */

  /**
   * @return int
   */
  public function countCompanyContacts()
  {
  
      $db = $this->getDb();
  
      $sql = <<<SQL
SELECT
  count(contact.rowid) as number
FROM
  core_contact_r contact
JOIN core_person_r person
    ON contact.id_person = person.rowid
WHERE person.type = 2;
SQL;
  
      return $db->select($sql)->getField('number');
  
  }//end public function countCompanyContacts */
  
}// end class CoreContact_Stats_Provider

