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
class BuizMessage_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array(
    'messagelist' => array(
      'method' => array('GET'),
      'views' => array('maintab')
    ),
    'searchlist' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),

    // mini overlay
    'minilist' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'minisearch' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),

    // message logic
    'formnew' => array(
      'method' => array('GET'),
      'views' => array('modal', 'maintab')
    ),
    'formshow' => array(
      'method' => array('GET'),
      'views' => array('modal', 'maintab')
    ),
    'showmailcontent' => array(
      'method' => array('GET'),
      'views' => array('html')
    ),
    'showpreview' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'sendusermessage' => array(
      'method' => array('POST'),
      'views' => array('ajax')
    ),

    'loaduser' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),

    'savemessage' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),

    // form forward
    'formforward' => array(
      'method' => array('GET'),
      'views' => array('modal', 'maintab')
    ),

    'sendforward' => array(
      'method' => array('POST'),
      'views' => array('ajax')
    ),

    // form reply
    'formreply' => array(
      'method' => array('GET'),
      'views' => array('modal', 'maintab')
    ),

    'sendreply' => array(
      'method' => array('POST'),
      'views' => array('ajax')
    ),

    // delete
    'deletemessage' => array(
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

    // archive
    'archivemessage' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),
    'archiveall' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),
    'archiveselection' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),

    // reopen einen archivierten Datensatz wieder öffnen
    'reopen' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),

    // spam / ham
    'setspam' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),

    // nachricht als gelesen markieren
    'markread' => array(
        'method' => array('PUT'),
        'views' => array('ajax')
    ),
    'markreadall' => array(
        'method' => array('PUT'),
        'views' => array('ajax')
    ),
    'markreadselection' => array(
        'method' => array('PUT'),
        'views' => array('ajax')
    ),

    // references
    'addref' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),
    'delref' => array(
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
  public function service_messageList($request, $response)
  {

    /* @var $model BuizMessage_Model  */
    $model = $this->loadModel('BuizMessage');

    $userSettings = $model->loadSettings();

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = new BuizMessage_Table_Search_Request($request, $userSettings);

    if ($userSettings->changed)
      $model->saveSettings($userSettings);

    $model->params = $params;
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // load the view object
    /* @var $view BuizMessage_List_Maintab_View  */
    $view = $response->loadView(
      'buiz-groupware-list',
      'BuizMessage_List',
      'displayList',
      View::MAINTAB
    );

    $view->setModel($model);
    $view->displayList($params);

  }//end public function service_messageList */

 /**
  * create an new window with an edit form for the enterprise_company entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_searchList($request, $response)
  {


    /* @var $model BuizMessage_Model  */
    $model = $this->loadModel('BuizMessage');

    $userSettings = $model->loadSettings();

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = new BuizMessage_Table_Search_Request($request, $userSettings);

    if ($userSettings->changed)
      $model->saveSettings($userSettings);

    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // load the view object
    /* @var $view BuizMessage_List_Ajax_View */
    $view = $response->loadView(
      'list-message_list',
      'BuizMessage_List',
      'displaySearch',
      View::AJAX
    );

    $view->setModel($model);

    $model->params = $params;

    $view->displaySearch($params);

  }//end public function service_searchList */

  /**
   * create an new window with an edit form for the enterprise_company entity
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_miniList($request, $response)
  {

    /* @var $model BuizMessage_Model  */
    $model = $this->loadModel('BuizMessage');

    $userSettings = $model->loadSettings();

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = new BuizMessage_Table_Search_Request($request, $userSettings);

    if ($userSettings->changed)
      $model->saveSettings($userSettings);

    $model->params = $params;
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // load the view object
    /* @var $view BuizMessage_List_Maintab_View  */
    $view = $response->loadView(
      'buiz-message-mini_list',
      'BuizMessage_MiniList',
      'displayElement'
    );

    $view->setModel($model);
    $view->displayElement($params);

  }//end public function service_miniList */


  /**
   * create an new window with an edit form for the enterprise_company entity
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_miniSearch($request, $response)
  {


    /* @var $model BuizMessage_Model  */
    $model = $this->loadModel('BuizMessage');

    $userSettings = $model->loadSettings();

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = new BuizMessage_Table_Search_Request($request, $userSettings);

    if ($userSettings->changed)
      $model->saveSettings($userSettings);

    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
          Response::FORBIDDEN_MSG,
          Response::FORBIDDEN
      );
    }

    // load the view object
    /* @var $view BuizMessage_List_Ajax_View */
    $view = $response->loadView(
        'search-message_mini_list',
        'BuizMessage_MiniList',
        'displaySearch',
        View::AJAX
    );

    $view->setModel($model);
    $model->params = $params;
    $view->displaySearch($params);

  }//end public function service_miniSearch */

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

    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // load the view object
    $view = $response->loadView(
      'form-messages-new',
      'BuizMessage_New',
      'displayNew'
    );

    // request bearbeiten
    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $view->setModel($model);

    $view->displayNew($params);

  }//end public function service_formNew */

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
      throw new InvalidRequest_Exception(
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

    // load the view object
    $view = $response->loadView(
      'form-messages-show-'.$msgId,
      'BuizMessage_Show',
      'displayShow'
    );
    $view->setModel($model);

    $view->displayShow($params);

  }//end public function service_formShow */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_showMailContent($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $model->loadMessage($msgId);

    // load the view object
    $view = $response->loadView(
      'form-messages-show-'.$msgId,
      'BuizMessage',
      'displayContent',
      View::HTML
    );
    $view->setModel($model);

    $view->displayContent($params);

  }//end public function service_showMailContent */


  /**
   * Form zum anschauen einer Nachricht
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_showPreview($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
          Response::FORBIDDEN_MSG,
          Response::FORBIDDEN
      );
    }

    $msgNode = $model->loadMessage($msgId);

    // load the view object
    /* @var $view BuizMessage_Ajax_View */
    $view = $response->loadView(
        'messages-preview-'.$msgId,
        'BuizMessage',
        'displayMsgPreview'
    );
    $view->setModel($model);

    $view->displayMsgPreview($msgNode);

  }//end public function service_showPreview */

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_loadUser($request, $response)
  {

    // resource laden
    $user = $this->getUser();
    $acl = $this->getAcl();


    // load request parameters an interpret as flags
    $params = $this->getFlags($request);

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'message-user-autocomplete';

    $view = $response->loadView(
      'message-user-ajax',
      'BuizMessage',
      'displayUserAutocomplete',
      View::AJAX
    );
    /* @var $model Example_Model */
    $model = $this->loadModel('BuizMessage');
    //$model->setAccess($access);
    $view->setModel($model);

    $searchKey = $this->request->param('key', Validator::TEXT);

    $view->displayUserAutocomplete($searchKey, $params);


  }//end public function service_loadUser */


  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_saveMessage($request, $response)
  {

    // resource laden
    $user = $this->getUser();
    $acl = $this->getAcl();


    // load request parameters an interpret as flags
    $rqtData = new BuizMessage_Save_Request($request);
    $msgId = $request->param('objid',Validator::EID);

  	/* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($rqtData);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $model->saveMessage($msgId, $rqtData);

  }//end public function service_saveMessage */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_setSpam($request, $response)
  {

    // resource laden
    $user = $this->getUser();
    $acl = $this->getAcl();

    // load request parameters an interpret as flags
    $rqtData = $this->getFlags($request);
    $msgId = $request->param('objid',Validator::EID);
    $flagSpam = $request->param('spam',Validator::INT);

  	/* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($rqtData);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }

    if( 100 == $flagSpam) {
      //wenn spam dann löschen
      $this->getTpl()->addJsCode(<<<JS

    \$S('#wgt-table-buiz-groupware_message_row_{$msgId}').remove();

JS
      );
    }

    $model->setSpam($msgId, $flagSpam, $rqtData);

  }//end public function service_saveMessage */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteMessage($request, $response)
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

    //wgt-table-buiz-groupware_message_row_
    $tpl->addJsCode(<<<JS
    \$S('#wgt-table-buiz-groupware_message_row_{$messageId}').remove();
JS
    );

  }//end public function service_deleteMessage */

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

    //wgt-table-buiz-groupware_message_row_
    $tpl->addJsCode(<<<JS

    \$S('table#wgt-table-buiz-groupware_message-table tbody').html('');

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
      $entries[] = "#wgt-table-buiz-groupware_message_row_".$msgId;
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

    $mgsData->confidential = $request->data('confidential', Validator::INT);
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

    // load the view object
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
      throw new InvalidRequest_Exception(
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
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $model->loadMessage($msgId);

    // load the view object
    $view = $response->loadView(
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
      throw new InvalidRequest_Exception(
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

////////////////////////////////////////////////////////////////////////////////
// Reference
////////////////////////////////////////////////////////////////////////////////


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_addRef($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    $msgId = $request->param('msg', Validator::EID);
    $refId = $request->param('ref', Validator::EID);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $linkId = $model->addRef($msgId,$refId);

    /* @var $view BuizMessage_Ajax_View */
    $view = $response->loadView(
      'message-update-ref',
      'BuizMessage',
      'displayAddRef'
     );
    $view->setModel($model);

    $view->displayAddRef($linkId,$msgId);

  }//end public function service_addRef */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delRef($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    $delId = $request->param('delid', Validator::EID);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $model->delRef($delId);

    /* @var $view BuizMessage_Ajax_View */
    $view = $response->loadView(
      'message-del-ref',
      'BuizMessage',
      'displayDelRef'
     );
    $view->setModel($model);

    $view->displayDelRef($delId);

  }//end public function service_addRef */

////////////////////////////////////////////////////////////////////////////////
// Archive
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_archiveMessage($request, $response)
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

    $model->archiveMessage($messageId, true);

    //wgt-table-buiz-groupware_message_row_
    $tpl->addJsCode(<<<JS
    \$S('#wgt-table-buiz-groupware_message_row_{$messageId}').remove();
JS
    );

  }//end public function service_archiveMessage */

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_archiveAll($request, $response)
  {

    // resource laden
    $user = $this->getUser();
    $acl = $this->getAcl();
    $tpl = $this->getTpl();

    $params = $this->getFlags($request);

    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $model->archiveAllMessage();

    //wgt-table-buiz-groupware_message_row_
    $tpl->addJsCode(<<<JS

    \$S('table#wgt-table-buiz-groupware_message-table tbody').html('');

JS
    );

  }//end public function service_archiveAll */

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_archiveSelection($request, $response)
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
    $model->archiveSelection($msgIds);

    $entries = [];

    foreach ($msgIds as $msgId) {
      $entries[] = "#wgt-table-buiz-groupware_message_row_".$msgId;
    }

    $jsCode = "\$S('".implode(', ',$entries)."').remove();";

    $tpl->addJsCode($jsCode);

  }//end public function service_archiveSelection */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_reopen($request, $response)
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

    $model->archiveMessage($messageId, false);

  }//end public function service_reopen */

} // end class BuizMessage_Controller
