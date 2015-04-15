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
class BuizUser_Action extends Action
{

  /**
   * @interface Dataset
   * @param Entity $entity
   * @param Context $params
   * @param Base $env
   */
  public function setupAdressItems($entity, $params, $env)
  {

    $orm = $env->getOrm();

    $addrItem = $orm->newEntity('BuizAddressItem');
    $addrItem->address_value = $entity->getId();
    $addrItem->id_user = $entity->getId();
    $addrItem->vid = $entity->getId();
    $addrItem->flag_private = false;
    $addrItem->use_for_contact = true;
    $addrItem->name = "User ID";
    $addrItem->id_type = $orm->getByKey('BuizAddressItemType', 'message');

    $orm->insert($addrItem);

  }//end public function setupAdressItems */

}//end class BuizUser_Action

