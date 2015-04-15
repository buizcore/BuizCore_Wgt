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
class BuizContact_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array(

    'list' => array(
      'method' => array('GET'),
      'views' => array('maintab')
    ),
    'formnew' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'insert' => array(
      'method' => array('POST'),
      'views' => array('maintab')
    ),

    // delete
    'delete' => array(
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),
    'deleteall' => array(
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),
    'deleteselection' => array(
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),

  );

/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * create an new window with an edit form for the enterprise_company entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_list($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $usrRqt = new BuizContact_List_Request($request);

    /* @var $model BuizContact_Model */
    $model = $this->loadModel('BuizContact');
    $model->loadTableAccess($usrRqt);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    /* @var $view BuizContact_List_Maintab_View */
    $view = $response->loadView(
      'buiz-groupware-list',
      'BuizContact_List',
      'displayList'
    );

    $view->setModel($model);

    $view->displayList($usrRqt);

  }//end public function service_list */


 /**
  * Form zum erstellen einer neuen Message
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formNew($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    /* @var $model BuizContact_Model */
    $model = $this->loadModel('BuizContact');
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // create a window
    $view = $response->loadView(
      'form-messages-new',
      'BuizContact',
      'displayNew'
    );

    // request bearbeiten
    $view->setModel($model);

    $view->displayNew($params);

  }//end public function service_formNew */


 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_insert($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $userRqt = new BuizContact_Save_Request($request);

    /* @var $model BuizContact_Model */
    $model = $this->loadModel('BuizContact');
    $model->loadTableAccess($userRqt);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $model->insert($userRqt);

    /* @var $view Li */
    $view = $response->loadView(
      'form-messages-show-'.$msgId,
      'BuizContact_Tile',
      'displayEntry'
    );
    $view->setModel($model);

    $view->displayEntry($params, true);

  }//end public function service_insert */






















 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formShow($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $message = $model->loadMessage($msgId);

    $user = $this->getUser();

    if ($message->id_receiver == $user->getId()) {
      if ($message->id_receiver_status == EMessageStatus::IS_NEW) {
        $orm = $this->getOrm();
        $orm->update('BuizMessage', $message->msg_id, array('id_receiver_status' => EMessageStatus::OPEN));
      }
    }

    // create a window
    $view = $response->loadView
    (
      'form-messages-show-'.$msgId,
      'BuizMessage_Show',
      'displayShow'
    );
    $view->setModel($this->loadModel('BuizMessage'));

    $view->displayShow($params);

  }//end public function service_formShow */




  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete($request, $response)
  {

    // resource laden
    $user = $this->getUser();
    $acl = $this->getAcl();
    $tpl = $this->getTpl();
    $resContext = $response->createContext();

    // load request parameters an interpret as flags
    $params = $this->getFlags($request);

    $messageId = $request->param('objid', Validator::EID);

    $resContext->assertNotNull(
      'Missing the Message ID',
      $messageId
    );

    if ($resContext->hasError)
      throw new InvalidRequest_Exception();

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');

    $model->deleteMessage($messageId);

    //wgt-table-my_message_row_
    $tpl->addJsCode(<<<JS

    \$S('#wgt-table-my_message_row_{$messageId}').remove();

JS
    );

  }//end public function service_delete */

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteAll($request, $response)
  {

    // resource laden
    $user = $this->getUser();
    $acl = $this->getAcl();
    $tpl = $this->getTpl();

    if ($resContext->hasError)
      throw new InvalidRequest_Exception();

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');

    $model->deleteAllMessage();

    //wgt-table-my_message_row_
    $tpl->addJsCode(<<<JS

    \$S('table#wgt-table-my_message-table tbody').html('');

JS
    );

  }//end public function service_deleteAll */

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteSelection($request, $response)
  {

    // resource laden
    $user = $this->getUser();
    $acl = $this->getAcl();
    $tpl = $this->getTpl();

    // load request parameters an interpret as flags
    $params = $this->getFlags($request);

    $msgIds = $request->param('slct', Validator::EID);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->deleteSelection($msgIds);

    $entries = [];

    foreach ($msgIds as $msgId) {
      $entries[] = "#wgt-table-my_message_row_".$msgId;
    }

    $jsCode = "\$S('".implode(', ',$entries)."').remove();";

    $tpl->addJsCode($jsCode);

  }//end public function service_deleteSelection */


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendUserMessage($request, $response)
  {
    // refid
    $refId = $request->param('ref_id', Validator::EID);
    $dataSrc = $request->param('d_src', Validator::CNAME);


    $userId = $request->data('receiver', Validator::EID);

    /* @var $model BuizContactForm_Model */
    $model = $this->loadModel('BuizMessage');

    $mgsData = new TDataObject();
    $mgsData->subject = $request->data('subject', Validator::TEXT);
    $tmpChannels = $request->data('channels', Validator::CKEY);
    $chanels = [];

    foreach ($tmpChannels as $tmpCh) {
      if ($tmpCh)
        $chanels[] = $tmpCh;
    }

    $mgsData->channels = $chanels;

    $mgsData->confidentiality = $request->data('id_confidentiality', Validator::INT);
    $mgsData->importance = $request->data('importance', Validator::INT);
    $mgsData->message = $request->data('message', Validator::HTML);

    $model->sendUserMessage($userId, $dataSrc, $refId, $mgsData);

  }//end public function service_sendUserMessage */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formForward($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $model->loadMessage($msgId);

    // create a window
    $view = $response->loadView
    (
      'form-messages-forward-'.$msgId,
      'BuizMessage_Forward',
      'displayForm'
    );
    $view->setModel($this->loadModel('BuizMessage'));

    $view->displayForm($params);

  }//end public function service_formForward */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendForward($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $msgNode = $model->loadMessage($msgId);


    $userId = $request->data('receiver', Validator::EID);

    $mgsData = new TDataObject();
    $mgsData->subject = 'Fwd: '.$msgNode->subject;
    $mgsData->message = $msgNode->content;
    $mgsData->channels = $request->data('channels', Validator::CKEY);
    $mgsData->confidentiality = $request->data('id_confidentiality', Validator::INT);
    $mgsData->importance = $request->data('importance', Validator::INT);

    $model->sendUserMessage($userId, null, null, $mgsData);

  }//end public function service_sendForward */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formReply($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $model->loadMessage($msgId);

    // create a window
    $view = $response->loadView
    (
      'form-messages-reply-'.$msgId,
      'BuizMessage_Reply',
      'displayForm'
    );
    $view->setModel($this->loadModel('BuizMessage'));

    $view->displayForm($params);

  }//end public function service_formReply */


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendReply($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        'Access denied',
        Response::FORBIDDEN
      );
    }


    $receiverId = $request->data('receiver', Validator::EID);

    /* @var $model BuizContactForm_Model */
    $model = $this->loadModel('BuizMessage');

    $msgData = new TDataObject();
    $msgData->subject = $request->data('subject', Validator::TEXT);
    $msgData->channels = $request->data('channels', Validator::CKEY);
    $msgData->confidentiality = $request->data('id_confidentiality', Validator::INT);
    $msgData->importance = $request->data('importance', Validator::INT);
    $msgData->message = $request->data('message', Validator::HTML);
    $msgData->id_refer = $msgId;

    $model->sendUserMessage($receiverId, null, null, $msgData);

  }//end public function service_sendUserMessage */

} // end class MaintenanceEntity_Controller
