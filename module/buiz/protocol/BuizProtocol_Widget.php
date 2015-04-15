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
 *
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 *
 */
class BuizProtocol_Widget extends WgtWidget
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab($containerId, $tabId, $tabSize = 'medium')
  {

    $user = $this->getUser();
    $view = $this->getView();

    $profile = $user->getProfileName();

    $params = new TArray;
    $params->qsize = 25;

    $db = $this->getDb();
    $query = $db->newQuery('BuizProtocol');

    $params->order = array
    (
      'buiz_protocol_message.m_time_created desc'
    );

    $query->fetchFullProtocol($params);

    $tableProtocol = $view->newItem('tableBuizProtocolMessage','BuizProtocol_Table');
    $tableProtocol->setId('wgt-table_widget_protocol');
    $tableProtocol->setData($query);
    $tableProtocol->addAttributes(array
    (
      'style' => 'width:99%;'
    ));
    $tableProtocol->setPagingId('wgt-form-widget_protocol-search');
    $tableProtocol->setActions([]);
    $tableProtocol->enableNav = false;

    $tableProtocol->buildProtocolEntityHtml();

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="protocol"  >
      <form
        id="wgt-form-widget_protocol-search"
        class="wcm wcm_req_ajax"
        action="ajax.php?c=Widget.BuizProtocol.reload" method="post" ></form>
      <h2>Action Protocol</h2>
      {$tableProtocol}
      <div class="do-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */

  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function runReload($view, $tabSize = 'medium')
  {

    $condition = [];

    $httpRequest = $this->getRequest();
    $db = $this->getDb();
    $orm = $db->getOrm();
    $view->getI18n();
    $params = $this->getSearchFlags();

    /*
    if ($httpRequest->method('POST')  ) {
      if ($free = $httpRequest->param('free_search' , Validator::TEXT))
        $condition['free'] = $free;

      if (!$fieldsBuizProtocolMessage = $this->getRegisterd('search_fields_buiz_protocol_message')) {
         $fieldsBuizProtocolMessage = $orm->getSearchCols('BuizProtocolMessage');
      }

      if ($refs = $httpRequest->dataSearchIds('search_buiz_protocol_message')) {
        $fieldsBuizProtocolMessage = array_unique(array_merge
        (
          $fieldsBuizProtocolMessage,
          $refs
        ));
      }

      $filterBuizProtocolMessage = $httpRequest->checkSearchInput
      (
        $orm->getValidationData('BuizProtocolMessage', $fieldsBuizProtocolMessage),
        $orm->getErrorMessages('BuizProtocolMessage'  ),
        'search_buiz_protocol_message'
      );
      $condition['buiz_protocol_message'] = $filterBuizProtocolMessage->getData();

      if ($mRoleCreate = $httpRequest->param('search_buiz_protocol_message', Validator::EID, 'm_role_created'   ))
        $condition['buiz_protocol_message']['m_role_created'] = $mRoleCreate;

      if ($mRoleChange = $httpRequest->param('search_buiz_protocol_message', Validator::EID, 'm_role_changed'   ))
        $condition['buiz_protocol_message']['m_role_changed'] = $mRoleChange;

      if ($mTimeCreatedBefore = $httpRequest->param('search_buiz_protocol_message', Validator::DATE, 'm_time_created_before'   ))
        $condition['buiz_protocol_message']['m_time_created_before'] = $mTimeCreatedBefore;

      if ($mTimeCreatedAfter = $httpRequest->param('search_buiz_protocol_message', Validator::DATE, 'm_time_created_after'   ))
        $condition['buiz_protocol_message']['m_time_created_after'] = $mTimeCreatedAfter;

      if ($mTimeChangedBefore = $httpRequest->param('search_buiz_protocol_message', Validator::DATE, 'm_time_changed_before'   ))
        $condition['buiz_protocol_message']['m_time_changed_before'] = $mTimeChangedBefore;

      if ($mTimeChangedAfter = $httpRequest->param('search_buiz_protocol_message}', Validator::DATE, 'm_time_changed_after'   ))
        $condition['buiz_protocol_message']['m_time_changed_after'] = $mTimeChangedAfter;

      if ($mRowid = $httpRequest->param('search_buiz_protocol_message', Validator::EID, 'm_rowid'   ))
        $condition['buiz_protocol_message']['m_rowid'] = $mRowid;

      if ($mUuid = $httpRequest->param('search_buiz_protocol_message', Validator::TEXT, 'm_uuid'    ))
        $condition['buiz_protocol_message']['m_uuid'] = $mUuid;

    }
    */

    $query = $db->newQuery('BuizProtocol');

    $query->fetchFullProtocol
    (
      $params
    );

    $table = $view->newItem
    (
      'tableBuizProtocolMessage',
      'BuizProtocol_Table'
    );

    // use the query as datasource for the table
    $table->setData($query);

    // set the offset to set the paging menu correct
    $table->start = $params->start;

    // set the position for the size menu
    $table->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if ($params->begin)
      $table->begin = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    $table->setId('wgt-table_widget_protocol');

    $acl = $this->getAcl();

    if ($acl->access(array('buiz/protocol_message:edit'))) {
      $actions[] = 'edit';
    }

    if ($acl->access(array('buiz/protocol_message:delete'))) {
      $actions[] = 'delete';
    }

    $table->addActions($actions);

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    $table->setPagingId('wgt-form-widget_protocol-search');

    // refresh the table in ajax requests
    $table->refresh = true;

    // the table should only replace the content inside of the container
    // but not the container itself
    $table->insertMode = false;

    $table->buildProtocolEntityHtml();

    return $table;

  }//end public function runReload */

  /**
   * @param TFlowFlag $flowFlags
   * @return TFlowFlag
   */
  protected function getSearchFlags($flowFlags = null)
  {

    if (!$flowFlags)
      $flowFlags = new TFlowFlag();

    // start position of the query and size of the table
    $flowFlags->start
 = $this->request->param('start', Validator::INT);

    // stepsite for query (limit) and the table
    if (!$flowFlags->qsize = $this->request->param('qsize', Validator::INT))
      $flowFlags->qsize = Wgt::$defListSize;

    // order for the multi display element
    $flowFlags->order
 = $this->request->param('order', Validator::CNAME);

    // target for a callback function
    $flowFlags->target
 = $this->request->param('target', Validator::CKEY  );

    // target for some ui element
    $flowFlags->targetId
 = $this->request->param('targetId', Validator::CKEY  );

    // flag for beginning seach filter
    if ($text = $this->request->param('begin', Validator::TEXT  )) {
      // whatever is comming... take the first char
      $flowFlags->begin = $text[0];
    }

    return $flowFlags;

  }//end protected function getSearchFlags */

}//end class BuizProtocol_Widget