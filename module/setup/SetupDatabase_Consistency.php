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
class SetupDatabase_Consistency extends DataContainer
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function run()
  {

    $this->systemUsers();

  }//end public function run */

  /**
   *
   */
  protected function systemUsers()
  {

    $orm = $this->getOrm();
    $request = $this->getRequest();

    $userLib = new LibUser($this);

    $user = new LibEnvelopUser();

    $user->userName = 'system';
    $user->firstName = 'gaia';
    $user->lastName = 'olymp';

    $user->passwd = '☯kqU✈m92✇.Pdw+73HW☮d!2§ÄaV°;-)';
    $user->level = User::LEVEL_SYSTEM;
    $user->profile = 'default';
    $user->description = 'Der System User';
    $user->inactive = false;
    $user->nonCertLogin = false;

    $user->addressItems[] = array('mail', 'system@'.$request->getServerName());

    $userLib->createUser($user);

  }//end protected function systemUsers */

}//end class SetupDatabase_Consistency

