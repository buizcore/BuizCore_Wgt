<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH
* @project     : BuizCore - The Business Core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.buizcore.wgt
 */
class WgtElementAttachmentTable extends WgtAbstract
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $label = 'Attachments';

  /**
   * @var string
   */
  public $urlSearch = 'ajax.php?c=Buiz.Attachment.search';

  /**
   * @var string
   */
  public $urlDelete = 'ajax.php?c=Buiz.Attachment.delete';

  /**
   * @var string
   */
  public $urlEdit = 'modal.php?c=Buiz.Attachment.edit';

  /**
   * @var string
   */
  public $urlStorageSearch = 'ajax.php?c=Buiz.Attachment.searchStorage';

  /**
   * @var string
   */
  public $urlStorageDelete = 'ajax.php?c=Buiz.Attachment.deleteStorage';

  /**
   * @var string
   */
  public $urlStorageEdit = 'modal.php?c=Buiz.Attachment.editStorage';

  /**
   * @var string
   */
  public $idKey = null;

  /**
   * @var WgtMenuBuilder
   */
  public $menuBuilder = null;

  /**
   * @var array
   */
  public $icons = array();

  /**
   * @var array
   */
  public $dataStorage = array();

  /**
   * Steuerflags zum customizen des elements
   * - attachments  bool: support für attachements
   * -- a_create bool: neue attachments erstellen
   * -- a_update bool: vorhandene attachments ändern
   * -- a_delete bool: attachments löschen
   * - files
   * - links
   * -- l_storage bool: storage support
   * - storages  bool: support für storages
   * -- s_create bool: neue storages erstellen
   * -- s_update bool: vorhandene storages ändern
   * -- s_delete bool: storages löschen
   * @var TArray
   */
  public $flags = null;

  /**
   *
   * @var string
   */
  public $width = 850;

  /**
   *
   * @var string
   */
  public $height = 590;

  /**
   * Standard url extension
   * @var string
   */
  protected $defUrl = '';

  /**
   * Standard url extension
   * @var string
   */
  protected $defAction = '';

  /**
   * @var BuizAttachment_Request
   */
  public $context = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   * @param BuizAttachment_Request $context
   * @param LibTemplate $view
   * @param array $flags
   */
  public function __construct($name, $context, $view = null, $flags = array())
  {

    $this->texts = new TArray();
    $this->flags = new TArray($flags); // here we use flags
    $this->context = $context;

    if ($context->element)
      $this->idKey = $context->element;

    $this->name = $name;
    $this->init();

    if ($view)
      $view->addElement($name, $this);

    // setup der icons
    $this->icons['link'] = '<i class="fa fa-external-link " ></i>';
    $this->icons['file'] = '<i class="fa fa-file-alt" ></i>';
    $this->icons['edit'] = '<i class="fa fa-edit" ></i>';

    $this->icons['level_public'] = $this->icon(
      'confidentiality/public.png',
      'Public',
      'xsmall',
      array('class' => 'wcm wcm_ui_tip', 'tooltip'=>"Confidentiality Level Public")
    );
    $this->icons['level_customer'] = $this->icon(
      'confidentiality/customer.png',
      'Customer',
      'xsmall',
      array('class' => 'wcm wcm_ui_tip', 'tooltip'=>"Public")
     );
    $this->icons['level_restricted'] = $this->icon(
      'confidentiality/restricted.png',
      'Restricted',
      'xsmall',
      array('class' => 'wcm wcm_ui_tip', 'tooltip'=>"Restricted")
     );
    $this->icons['level_confidential'] = $this->icon(
      'confidentiality/confidential.png',
      'Confidential',
      'xsmall',
      array('class' => 'wcm wcm_ui_tip', 'tooltip'=>"Confidential")
     );
    $this->icons['level_secret'] = $this->icon(
      'confidentiality/secret.png',
      'Secret',
      'xsmall',
      array('class' => 'wcm wcm_ui_tip', 'tooltip'=>"Secret")
     );
    $this->icons['level_top_secret'] = $this->icon(
      'confidentiality/top_secret.png',
      'Top Secret',
      'xsmall',
      array('class' => 'wcm wcm_ui_tip', 'tooltip'=>"Top Secret")
     );

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// Getter & Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function getIdKey()
  {

    if (is_null($this->idKey))
      $this->idKey = BuizCore::uniqKey();

    return $this->idKey;

  }//end public function getIdKey */

  /**
   * (non-PHPdoc)
   * @see WgtAbstract::setId()
   */
  public function setId($id)
  {

    $this->idKey = $id;
    $this->context->element = $id;

  }//end public function setId */

  /**
   * @param array $dataStorage
   */
  public function setStorageData(array $dataStorage)
  {
    $this->dataStorage = $dataStorage;
  }//end public function setStorageData */

/*////////////////////////////////////////////////////////////////////////////*/
// Render Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function preRenderUrl()
  {

    if (!$this->context->element)
      $this->context->element = $this->getIdKey();

    $this->defUrl = $this->context->toUrlExt();
    $this->defAction = $this->context->toActionExt();

  }//end public function preRenderUrl */

  /**
   *
   */
  public function preCalculateFlags()
  {

    if (false === $this->flags->attachments) {
      $this->flags->files = false;
      $this->flags->links = false;
      $this->flags->a_delete = false;
      $this->flags->a_create = false;
      $this->flags->a_edit = false;
    }

    if (false === $this->flags->storages) {
      $this->flags->s_delete = false;
      $this->flags->s_create = false;
      $this->flags->s_edit = false;
    }

    if ($this->access) {

      if (!$this->access->update) {
        $this->flags->a_delete = false;
        $this->flags->a_create = false;
        $this->flags->a_edit = false;

        $this->flags->s_delete = false;
        $this->flags->s_create = false;
        $this->flags->s_edit = false;
      }

    }

  }//end public function preCalculateFlags */

  /**
   * @param TFlag $params
   * @return string
   */
  public function render($params = null)
  {

    if ($this->html)
      return $this->html;

    if (!$this->defUrl)
      $this->preRenderUrl();

    $this->preCalculateFlags();

    $idKey = $this->getIdKey();

    // content

    $headAttachmentTab = '';
    $headRepoTab = '';
    $htmlAttachmentTab = '';
    $htmlRepoTab = '';
    $codeButtonsAttach = '';
    $codeButtonsStorage = '';

    if (false !== $this->flags->attachments)
      $htmlAttachmentTab = $this->renderAttachmentTab($idKey);

    if (false !== $this->flags->storages)
      $htmlRepoTab = $this->renderRepoTab($idKey);

    if (false !== $this->flags->attachments) {
      $headAttachmentTab = '<li><a data-tab="files" class="tab" >Files</a></li>';
    }

    // nur wenn create nicht false
    if (false !== $this->flags->a_create) {

      // checken ob wir links wollen
      if (false !== $this->flags->links) {

        $codeButtonsAttach .= <<<HTML
        <button
          onclick="\$R.get('modal.php?c=Buiz.Attachment.formAddLink{$this->defUrl}');"
          class="wgtac-add_link wgt-button"
          tabindex="-1" ><i class="fa fa-plus-circle" ></i> Add Link</button>
HTML;

      }

      // checken ob wir files wollen
      if (false !== $this->flags->files) {

        $codeButtonsAttach .= <<<HTML
        <button
          onclick="\$R.get('modal.php?c=Buiz.Attachment.formUploadFiles{$this->defUrl}');"
          tabindex="-1"
          class="wgtac-add_file wgt-button" ><i class="fa fa-plus-circle" ></i> Add File</button>
HTML;

      }

    }

    // checken ob wir storages wollen
    if (false !== $this->flags->links) {

      $codeButtonsAttach .= <<<HTML

        <button
            class="wcm wcm_ui_dropform wcm_ui_tip-top wgt-button"
            tabindex="-1"
            id="wgt-tab-attachment-{$idKey}-help"
            tooltip="How to deal with nonworking links?"
          >Links not working? <i class="fa fa-info-circle" ></i></button>

        <div class="wgt-tab-attachment-{$idKey}-help hidden" >

          <div class="wgt-space" >

            <p>
            If you click on a link and you get an error page from the browser, the link is either wrong
            or the targeted file was deleted / moved.
            </p>
            <p>
              In some browsers like Firefox it could happen, that you click on a link and nothing happens
              at all.<br />
              This is <strong>NOT a bug!</strong> Browsers have <strong>security restrictions</strong>
              which prevent the browser from open local file links or links to file shares.
            </p>
            <p>
            To open the file just <strong>copy the Link</strong> in a <strong>new Tab</strong> of your browser,
            or your <strong>file explorer</strong>.
            </p>

          </div>

        </div>
        <!-- end help -->

HTML;


    }

    // checken ob wir storages wollen
    if (false !== $this->flags->s_create) {

      $headRepoTab = '<li><a data-tab="repos" class="tab" >Storages</a></li>';

      $codeButtonsStorage = <<<HTML
        <button
          onclick="\$R.get('modal.php?c=Buiz.Attachment.formAddStorage{$this->defUrl}');"
          class="wgtac-add_repo wgt-button"
          tabindex="-1" ><i class="fa fa-plus-circle" ></i> Add Storage</button>
HTML;


    }

    // todo lösung für storages only mit einbauen

    $html = <<<HTML

<!-- start attachment list widget -->
<section
  class="wgt-content_box wgt-attchment_list"
  id="wgt-attachment-{$idKey}"
  style="height:590px;" >

  <!-- start head -->
  <header>
    <table border="0" cellspacing="0" cellpadding="0" width="100%" >
      <tr>
        <td width="480px;" ><h2>{$this->label}</h2></td>
        <td width="320px;" class="search" align="right" >
          <input
            type="text"
            name="skey"
            class="wcm wcm_req_search fparam-wgt-form-attachment-{$idKey}-search large" /><button
            onclick="\$R.form('wgt-form-attachment-{$idKey}-search');"
            class="wgt-button append-inp"
            tabindex="-1" ><i class="fa fa-search" ></i></button>
        </td>
      </tr>
    </table>
  </header><!-- end head -->

  <!-- Das Panel mit den Control Elementen und dem Tab Head -->
  <div class="wgt-panel" >
    <div class="left" >
      <div class="wgt-tab-attachment-{$idKey}-content box-files" >
{$codeButtonsAttach}
      </div>
      <div class="wgt-tab-attachment-{$idKey}-content box-repos" style="display:none;" >
{$codeButtonsStorage}
      </div>
     </div>

     <!-- tab buttons -->
     <div
       class="wcm wcm_ui_tab_head wgt-tab-head ar right"
       id="wgt-tab-attachment-{$idKey}-head"
       style="width:250px;border:0px;"
       data-tab-body="wgt-tab-attachment-{$idKey}-content" >
       <ul
         class="tab_head wgt-tab-head" >
         {$headAttachmentTab}
         {$headRepoTab}
       </ul>
     </div>

  </div><!-- end panel -->

  <!-- start tab Container -->
  <div
    id="wgt-tab-attachment-{$idKey}-content"
    class="wgt-content-box"
    style="height:530px;"  >
    {$htmlAttachmentTab}
    {$htmlRepoTab}
  </div><!-- end tab Container -->

</section><!-- end widget -->

HTML;

    return $html;

  }// end public function render */

  /**
   * @param string $idKey
   * @return string
   */
  protected function renderAttachmentTab($idKey)
  {

    /**
     * attach_id
     * file_id,
     * file_name,
     * file_link,
     * file_size,
     * mimetype,
     * description,
     * file_type,
     * firstname,
     * lastname,
     * user_name,
     * user_id
     */
    $codeEntr = '';

    $counter = 1;

    if ($this->data) {
      foreach ($this->data as $entry) {

        $codeEntr .= $this->renderAjaxEntry($idKey, $entry, $counter);
        ++$counter;

      }
    }

    // filetypes for the search
    if($this->context->maskFilter){
      /* @var $queryFileTypes BuizAttachmentFileType_Selectbox_Query */
      $queryFileTypes = BuizCore::$env->getDb()->newQuery('BuizAttachmentFileType_Selectbox');
      $queryFileTypes->fetchSelectbox($this->context->maskFilter);
      $dataFileTypes = $queryFileTypes->getAll();


      $stackFileTypes = array();
      foreach ($dataFileTypes as $data) {
        $stackFileTypes[] = '<option value="'.$data['id'].'" >'.$data['value'].'</option>';
      }
    } else {
      $stackFileTypes = array();
    }

    $htmlTSelect = '<script id="'.$this->id.'-srchtpl-table-type"  type="text/html" >'.NL;
    $htmlTSelect .= implode('' , $stackFileTypes);
    $htmlTSelect .= '</script>'.NL;



    $dataSize = count($this->data);

    $html = <<<HTML
    <div class="content" wgt_key="files" id="wgt-tab-attachment-{$idKey}-content-files" >

      <div class="content" style="height:530px;" >

        <form
          method="get"
          action="{$this->urlSearch}{$this->defUrl}"
          id="wgt-form-attachment-{$idKey}-search" ></form>

{$htmlTSelect}

        <div id="wgt-grid-attachment-{$idKey}" class="wgt-grid" >

          <var id="wgt-grid-attachment-{$idKey}-table-cfg-grid" >{
          "height":"large",
          "search_form":"wgt-form-attachment-{$idKey}-search",
          "search_able":true,
  				"select_able":false}</var>

          <table
            id="wgt-grid-attachment-{$idKey}-table"
            class="wgt-grid wcm wcm_widget_grid hide-head" >

            <thead>
              <tr>
                <th class="pos" style="width:30px"  >&nbsp;</th>
                <th style="width:50px" >T/C</th>
                <th
                  style="width:270px"
                  wgt_sort_name="order[file_name]"
                  wgt_sort="asc"
                  wgt_search="text:search[file_name]"  >Name</th>
                <th
                  style="width:100px"
                  wgt_sort_name="order[file_type]"
                  wgt_search="select:search-file_type[]"
                  wgt_ms_key="{$this->id}-srchtpl-table-type" >File Type</th>
                <th
                  style="width:100px"
                  wgt_sort_name="order[file_size]" >Size</th>
                <th
                  style="width:120px"
                  wgt_sort_name="order[file_owner]"
                  wgt_search="text:search[file_owner]" >Owner</th>
                <th
                  style="width:120px"
                  wgt_sort_name="order[file_created]" >Created</th>
                <th
                  style="width:180px"
                  wgt_search="text:search[file_description]" >Description</th>
                <th
                  style="width:50px;">Nav.</th>
              </tr>
            </thead>

            <tbody>
              {$codeEntr}
            </tbody>

          </table>

          <div class="wgt-panel wgt-border-top" >
            <div
              class="right menu"  ><span>found <strong class="wgt-num-entry" >{$dataSize}</strong> Entries</span> </div>
          </div>

        </div><!-- end grid -->

      </div><!-- end content -->

    </div><!-- end tab files -->

HTML;

    return $html;

  }//end protected function renderRepoTab */



  /**
   * @param string $elemId
   * @param array $entry
   * @param int $counter
   * @return string
   */
  public function renderAjaxEntry($elemId, $entry, $counter = null)
  {

    $fileSize = '';

    if ('' != trim($entry['file_name'])) {

      $fileIcon = '<i class="fa fa-file"></i>';
      $fileName = trim($entry['file_name']);
      $fileSize = SFormatNumber::formatFileSize($entry['file_size']);
      $b64Name = base64_encode($fileName);

      $link = "<a href=\"file.php?f=buiz_file-name-{$entry['file_id']}&amp;n={$b64Name}\" "
        ." target=\"wgt_dms\" rel=\"nofollow\" >{$fileName}</a>";

    } else {

      if ('' != trim($entry['storage_link'])) {
        $storageLink = 'file:\\\\\\'.trim($entry['storage_link']) ;
      } else {
        $storageLink = '';
      }
      $storageName = $entry['storage_name'];

      $lastChar = substr($storageLink, -1) ;

      if ( '' != $lastChar && $lastChar != '\\' && $lastChar != '/')
        $storageLink .= '\\';

      $fileIcon = '<i class="fa fa-link"></i>';
      $fileName = str_replace('\\\\', '\\', trim($entry['file_link'])) ;

      $firstChar = substr($fileName, 0, 1) ;

      if ($firstChar == '\\')
        $fileName = substr($fileName,1) ;

      //$fileName = str_replace('//', '/', $fileName) ;

      if($storageLink){
      	$link = "<a href=\"{$storageLink}\" >{$storageName}: </a><a href=\"{$storageLink}{$fileName}\" target=\"wgt_dms\" rel=\"nofollow\" >{$fileName}</a>";
      } else {
      	$link = "<a href=\"{$storageLink}{$fileName}\" target=\"wgt_dms\" rel=\"nofollow\" >{$fileName}</a>";
      }

    }

    $timeCreated = date('Y-m-d - H:i',  strtotime($entry['time_created'])  );
    $menuCode = $this->renderRowMenu($entry, $elemId);

    if ($counter) {
      $rowClass = 'row_'.($counter%2);
    } else {
      $rowClass = 'row_1';
      $counter = 1;
    }

    $confidentialIcon = '';

    if ($entry['confidential_level']) {
      $confidentialIcon = isset($this->icons['level_'.$entry['confidential_level']])
        ? $this->icons['level_'.$entry['confidential_level']]
        : '';
    }

    if (!($this->access && !$this->access->update) && false !== $this->flags->a_update) {

      $codeEntr = <<<HTML

    <tr
      class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['attach_id']}"
      id="wgt-grid-attachment-{$elemId}_row_{$entry['attach_id']}"
      data-url="{$this->urlEdit}{$this->defUrl}&amp;objid={$entry['attach_id']}" >
HTML;

    } else {

      $codeEntr = <<<HTML

    <tr
      class="{$rowClass} node-{$entry['attach_id']}"
      id="wgt-grid-attachment-{$elemId}_row_{$entry['attach_id']}" >
HTML;

    }


    $codeEntr .= <<<HTML

      <td class="pos" >{$counter}</td>
      <td>{$fileIcon} {$confidentialIcon}</td>
      <td>{$link}</td>
      <td>{$entry['file_type']}</td>
      <td>{$fileSize}</td>
      <td><span
        class="wcm wcm_control_contact_user"
        wgt_eid="{$entry['user_id']}"
        title="{$entry['lastname']}, {$entry['firstname']}" >{$entry['user_name']}</span></td>
      <td class="no_oflw" >{$timeCreated}</td>
      <td class="no_oflw" >{$entry['description']}</td>
      <td class="nav" >{$menuCode}</td>
    </tr>

HTML;

    return $codeEntr;

  }//end public function renderAjaxEntry */

  /**
   * @param string $elementId
   * @param array $data
   * @return string
   */
  public function renderAjaxBody($elementId, $data)
  {

    if ($this->html)
      return $this->html;

    $counter = 1;
    $html = '';

    if ($this->data) {

      foreach ($this->data as $entry) {

        $html .= $this->renderAjaxEntry($this->idKey, $entry, $counter);
        ++$counter;

      }
    }

    $this->html = $html;

    return $html;

  }// end public function renderAjaxBody */

  /**
   * @param array $entry
   * @return string
   */
  public function renderRowMenu($entry, $elementId)
  {

    if ($this->access && !$this->access->update)
      return '';

    $menuId = 'wgt-cntrl-'.$elementId.'-file-'.$entry['attach_id'];

    $html = <<<HTML
  <div id="{$menuId}" class="wgt-grid_menu" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      tabindex="-1"
      id="{$menuId}-cntrl"
      style="width:40px;" data-drop-box="{$menuId}-menu" >
      <i class="fa fa-cog" ></i>
      <i class="fa fa-angle-down" ></i>
    </button>
  </div>
  <div class="wgt-dropdownbox al_right" id="{$menuId}-menu" >
    <ul>
      <li>
        <a
          href="{$this->urlEdit}{$this->defAction}&objid={$entry['attach_id']}"
          class="wcm wcm_req_ajax"
          tabindex="-1" ><i class="fa fa-edit" ></i> Edit</a>
      </li>
    </ul>
    <ul>
      <li>
        <a
          onclick="\$R.del('{$this->urlDelete}{$this->defAction}&objid={$entry['attach_id']}',{confirm:'Confirm to delete.'});"
          tabindex="-1" ><i class="fa fa-times" ></i> delete</a>
      </li>
    </ul>
  </div>
  <var id="{$menuId}-cntrl-cfg-dropmenu"  >{"align":"right"}</var>
HTML;

    return $html;


  }//end public function renderRowMenu */


/*////////////////////////////////////////////////////////////////////////////*/
// title
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $idKey
   * @return string
   */
  protected function renderRepoTab($idKey)
  {

    /**
     * storage_id,
     * storage_name,
     * storage_link,
     * storage_description,
     * type_name
     */
    $codeEntr = '';

    $counter = 1;

    if ($this->dataStorage) {
      foreach ($this->dataStorage as $entry) {
        $codeEntr .= $this->renderAjaxStorageEntry($this->idKey, $entry, $counter);
        ++$counter;
      }
    }

    $dataSize = count($this->dataStorage);

    $code = <<<HTML
    <div class="content" wgt_key="files" id="wgt-tab-attachment-{$idKey}-content-repos" >

      <div class="content" style="height:530px;" >

        <form
          method="get"
          action="{$this->urlStorageSearch}{$this->defUrl}"
          id="wgt-form-attachment-{$idKey}-search" ></form>

        <div id="wgt-grid-attachment-{$idKey}" class="wgt-grid" >

          <var id="wgt-grid-attachment-{$idKey}-storage-cfg-grid" >{
          "height":"large",
          "search_form":"wgt-form-attachment-{$idKey}-storage-search",
          "search_able":"true"}</var>

          <table id="wgt-grid-attachment-{$idKey}-storage-table" class="wgt-grid wcm wcm_widget_grid hide-head" >

            <thead>
              <tr>
                <th class="pos" style="width:30px"  >&nbsp;</th>
                <th style="width:30px" >C</th>
                <th
                  style="width:120px"
                  wgt_sort_name="storage[name]"
                  wgt_sort="asc"
                  wgt_search="input:storage[name]"  >Name</th>
                <th
                  style="width:270px"
                  wgt_sort_name="storage[link]"
                  wgt_sort="asc"
                  wgt_search="input:storage[link]"  >Address</th>
                <th
                  style="width:100px"
                  wgt_sort_name="storage[id_type]"
                  wgt_search="input:storage[id_type]" >Type</th>
                <th
                  style="width:250px"
                  >Description</th>
                <th
                  style="width:50px;">Nav.</th>
              </tr>
            </thead>

            <tbody>
              {$codeEntr}
            </tbody>

          </table>

          <div class="wgt-panel wgt-border-top" >
            <div class="right menu"  ><span>found <strong class="wgt-num-entry" >{$dataSize}</strong> Entries</span> </div>
          </div>

        </div><!-- end grid -->

      </div><!-- end content -->

    </div><!-- end tab repos -->
HTML;

    return $code;

  }//end protected function renderRepoTab */

  /**
   * @param string $elemId
   * @param array $entry
   * @param int $counter
   * @return string
   */
  public function renderAjaxStorageEntry($elemId, $entry, $counter = null)
  {


    $menuCode = $this->renderRowStorageMenu($entry);

    if ($counter)
      $rowClass = 'row_'.($counter%2);
    else {
      $rowClass = 'row_1';
      $counter = 1;
    }

    $confidentialIcon = '';

    if ($entry['confidential_level']) {
      $confidentialIcon = isset($this->icons['level_'.$entry['confidential_level']])
        ? $this->icons['level_'.$entry['confidential_level']]
        : '';
    }

    $codeEntr = <<<HTML

    <tr
      class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['storage_id']}"
      id="wgt-grid-attachment-{$elemId}-storage_row_{$entry['storage_id']}"
      data-url="{$this->urlStorageEdit}{$this->defUrl}&amp;objid={$entry['storage_id']}" >
      <td class="pos" >{$counter}</td>
      <td>{$confidentialIcon}</td>
      <td>{$entry['storage_name']}</td>
      <td>{$entry['storage_link']}</td>
      <td>{$entry['type_name']}</td>
      <td class="no_oflw" >{$entry['storage_description']}</td>
      <td class="nav" >{$menuCode}</td>
    </tr>

HTML;

    return $codeEntr;

  }//end public function renderAjaxStorageEntry */

  /**
   * @param array $entry
   * @return string
   */
  public function renderRowStorageMenu($entry)
  {

    if (false === $this->flags->s_delete)
      return '';

    $html = <<<CODE
  <button
    onclick="\$R.del('{$this->urlStorageDelete}{$this->defAction}&objid={$entry['storage_id']}',{confirm:'Confirm to delete.'});"
    class="wgt-button"
    tabindex="-1" ><i class="fa fa-times" ></i></button>
CODE;

    return $html;

  }//end public function renderRowMenuStorage */

} // end class WgtElementAttachmentTable

