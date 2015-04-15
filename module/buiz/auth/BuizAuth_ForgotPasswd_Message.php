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
class BuizAuth_ForgotPasswd_Message extends LibMessageStack
{

  /**
   * Die Kanäle über welcher die Nachricht verschickt werden soll
   * @var array
   */
  public $channels = array
  (
    'mail'
   );

  /**
   * Die Entity zu der die Nachricht in Relation steht
   * @var BuizUser_Entity
   */
  public $entity = null;

  /**
   * Pfad zum Master Template der Nachricht
   * @var string
   */
  public $htmlMaster = 'index';

/*////////////////////////////////////////////////////////////////////////////*/
// Setter & Getter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param BuizUser_Entity $entity
   */
  public function setEntity($entity)
  {

    $this->entity = $entity;

  }//end public function setEntity */

  /**
   * Subject der Nachricht
   * @param LibMessageReceiver $receiver = null
   * @return string
   */
  public function getSubject($receiver = null, $sender = null)
  {
    return <<<SUBJECT
{$this->info->getAppName()}: Anfrage zum Zurücksetzen ihres Passworts
SUBJECT;

  }//end public function getSubject */

  /**
   * Erstellen des Contents, soweit dynamisch nötig
   *
   * @param LibMessageReceiver $receiver = null
   * @param LibMessageSender $sender = null
   * @return string
   */
  public function buildContent($receiver = null, $sender = null)
  {

    $this->htmlDynContent = <<<MAIL
<p class="mail_head" >
  <a href="{$this->getServerAddress()}" >{$this->info->getAppName()}</a> Anfrage zum Zurücksetzen deines Passworts
</p>

<p class="text_def" >
  <strong>Hallo {$receiver->firstname} {$receiver->lastname},</strong>
</p>

<p class="text_def" >
  Es wurde eine Anfrage zum zurücksetzen deines Passworts gestellt.
  Bitte bestätige mit dem klicken auf diesen Link, dass auch wirklich du darum
  gebeten hast dein Passwort zu ändern.
  <a href="{$this->getServerAddress(true)}maintab.php?c=Buiz.Auth.formResetPasswd&token={$this->entity->reset_pwd_key}" >
    {$this->getServerAddress(true)}maintab.php?c=Buiz.Auth.formResetPasswd&token={$this->entity->reset_pwd_key}
  </a>
</p>

<p>
  Wenn der dein Mailclient das klicken auf den Link nicht unterstüzt kopier diesen Link
  in deinen Browser: {$this->getServerAddress(true)}maintab.php?c=Buiz.Auth.formResetPasswd&token={$this->entity->reset_pwd_key}.
</p>

<p>
  Wenn du diese Anfrage nicht von dir gestellt wurde informier bitte den Support.
</p>

MAIL;

  }//end public function buildContent */

  /**
   * laden der Attachments für die Nachricht
   * @return void
   */
  public function loadAttachments()
  {

  }//end public function loadAttachments */

} // end class BuizAuth_ForgotPasswd_Message */

