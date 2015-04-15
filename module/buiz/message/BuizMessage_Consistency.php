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
class BuizMessage_Consistency extends DataContainer
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Liste mit den Ids aller user
   * @var array
   */
  protected $sysUsers = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function run()
  {

    $orm = $this->getOrm();
    $this->sysUsers = $orm->getIds("BuizRoleUser", "rowid>0");

    $this->fixUserAddresses();
    $this->fixUserReceiver();

  }//end public function run */

  /**
   *
   */
  protected function fixUserAddresses()
  {

    $orm = $this->getOrm();

    $itemType = $orm->getByKey('BuizAddressItemType', 'message');
    $itemId = $itemType->getId();

    foreach ($this->sysUsers as $sysUser) {

      if (!$item = $orm->get('BuizAddressItem', 'id_user='.$sysUser.' and id_type='.$itemId)) {
        // Private Channel für den User erstellen
        $item = $orm->newEntity('BuizAddressItem');
        $item->address_value = $sysUser;
        $item->id_user = $sysUser;
        $item->id_type = $itemId;
        $item->use_for_contact = true;
        $orm->save($item);

      }

    }

  }//end protected function fixUserAddresses */
  
  /**
   *
   */
  protected function fixUserReceiver()
  {
    
    $db = $this->getDb();
    
      $queries = [];
      $queries[] = 'UPDATE buiz_message set id_sender_status = '.EMessageStatus::IS_NEW.' WHERE id_sender_status is null; ';
      $queries[] = 'UPDATE buiz_message_receiver set status = '.EMessageStatus::IS_NEW.' WHERE status is null; ';
      $queries[] = 'UPDATE buiz_message set spam_level = -1 WHERE spam_level is null; ';
  
      foreach ($queries as $query) {
        $db->exec($query);
      }
      


  }//end protected function fixUserAddresses */

}//end class BuizMessage_Consistency

