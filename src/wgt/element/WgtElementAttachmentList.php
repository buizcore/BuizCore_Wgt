<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.webfrap.wgt
 */
class WgtElementAttachmentList extends WgtAbstract
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
  public $urlSearch = 'ajax.php?c=Webfrap.Attachment.search&ltype=list';

  /**
   * @var string
   */
  public $urlDelete = 'ajax.php?c=Webfrap.Attachment.delete&ltype=list';

  /**
   * @var string
   */
  public $urlEdit = 'modal.php?c=Webfrap.Attachment.edit&ltype=list';

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
   * Steuerflags zum customizen des elements
   * - attachments  bool: support für attachements
   * -- a_create bool: neue attachments erstellen
   * -- a_update bool: vorhandene attachments ändern
   * -- a_delete bool: attachments löschen
   * - files
   * - links
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
   * @var WebfrapAttachment_Request
   */
  public $context = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   * @param WebfrapAttachment_Request $context
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
      $this->idKey = Webfrap::uniqKey();

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


    if ($this->access) {

      if (!$this->access->update) {
        $this->flags->a_delete = false;
        $this->flags->a_create = false;
        $this->flags->a_edit = false;

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
    $htmlAttachmentTab = '';
    $codeButtonsAttach = '';

    if (false !== $this->flags->attachments)
      $htmlAttachmentTab = $this->renderAttachmentTab($idKey);

    if (false !== $this->flags->attachments) {
      $headAttachmentTab = '<li><a data-tab="files" class="tab" >Files</a></li>';
    }

    // nur wenn create nicht false
    if (false !== $this->flags->a_create) {

      // checken ob wir links wollen
      if (false !== $this->flags->links) {

        $codeButtonsAttach .= <<<HTML
        <a
          onclick="\$R.get('modal.php?c=Webfrap.Attachment.formAddLink{$this->defUrl}&ltype=list');"
          class="wgtac-add_link wgt-control"
          tabindex="-1" ><i class="fa fa-plus-circle" ></i> Add Link</a> |
HTML;

      }

      // checken ob wir files wollen
      if (false !== $this->flags->files) {

        $codeButtonsAttach .= <<<HTML
        <a
          onclick="\$R.get('modal.php?c=Webfrap.Attachment.formUploadFiles{$this->defUrl}&ltype=list');"
          tabindex="-1"
          class="wgtac-add_file wgt-control" ><i class="fa fa-plus-circle" ></i> Add File</a> |
HTML;

      }

    }

    if (false !== $this->flags->links) {

      $codeButtonsAttach .= <<<HTML

        <a
            class="wcm wcm_ui_dropform wcm_ui_tip-top wgt-control"
            tabindex="-1"
            id="wgt-tab-attachment-{$idKey}-help"
            tooltip="How to deal with nonworking links?"
          >Links not working? <i class="fa fa-info-circle" ></i></a>

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

    // todo lösung für storages only mit einbauen
    $i18n = $this->getI18n();

    $html = <<<HTML

<!-- start attachment list widget -->
<section
  class="wgt-content_box wgt-attchment_list"
  id="wgt-attachment-{$idKey}"  >

  <!-- start head -->
  <header>
    <h2>{$i18n->l('Attachments','core.base')}</h2>
  </header><!-- end head -->

  <!-- Das Panel mit den Control Elementen und dem Tab Head -->
  <div class="wgt-panel hx2" >
    <div class="left block small" >
        {$codeButtonsAttach}
     </div>
    <div class="left  block small" style="padding-top:5px;" >
    <input
        type="text"
        name="skey"
        style="vertical-align:baseline;"
        class="wcm wcm_req_search fparam-wgt-form-attachment-{$idKey}-search large" /><button
        onclick="\$R.form('wgt-form-attachment-{$idKey}-search');"
        class="wgt-button append-inp"
        tabindex="-1" ><i class="fa fa-search" ></i></button>
    </div>

  </div><!-- end panel -->

  <!-- start content Container -->
  {$htmlAttachmentTab}

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


    if ($this->data) {
      foreach ($this->data as $entry) {

        $codeEntr .= $this->renderAjaxEntry($idKey, $entry);

      }
    }

    // filetypes for the search
    if($this->context->maskFilter){
      /* @var $queryFileTypes WebfrapAttachmentFileType_Selectbox_Query */
      $queryFileTypes = Webfrap::$env->getDb()->newQuery('WebfrapAttachmentFileType_Selectbox');
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

      <div class="content"  >

        <form
          method="get"
          action="{$this->urlSearch}{$this->defUrl}"
          id="wgt-form-attachment-{$idKey}-search" ></form>

{$htmlTSelect}

        <div id="wgt-atlist-{$idKey}" class="wgt-grid" >

         <ul class="widget wid-ced_list" >
            {$codeEntr}
         </ul>


        </div><!-- end grid -->


HTML;

    return $html;

  }//end protected function renderRepoTab */



  /**
   * @param string $elemId
   * @param array $entry
   * @return string
   */
  public function renderAjaxEntry($elemId, $entry)
  {

    $fileSize = '';

    if ('' != trim($entry['file_name'])) {

      $fileIcon = '<i class="fa fa-file"></i>';
      $fileName = trim($entry['file_name']);
      $fileSize = SFormatNumber::formatFileSize($entry['file_size']);
      $b64Name = base64_encode($fileName);

      $link = "<a href=\"file.php?f=wbfsys_file-name-{$entry['file_id']}&amp;n={$b64Name}\" "
        ." target=\"wgt_dms\" rel=\"nofollow\" >{$fileIcon} {$fileName}</a>";

    } else {


      $fileIcon = '<i class="fa fa-link"></i>';
      $fileName = str_replace('\\\\', '\\', trim($entry['file_link'])) ;

      $firstChar = substr($fileName, 0, 1) ;

      if ($firstChar == '\\')
        $fileName = substr($fileName,1) ;

      //$fileName = str_replace('//', '/', $fileName) ;

      $link = "<a href=\"{$fileName}\" target=\"wgt_dms\" rel=\"nofollow\" >{$fileIcon} {$fileName}</a>";

    }

    $timeCreated = date('Y-m-d - H:i',  strtotime($entry['time_created'])  );
    $menuCode = $this->renderRowMenu($entry, $elemId);


    $confidentialIcon = '';

    if ($entry['confidential_level']) {
      $confidentialIcon = isset($this->icons['level_'.$entry['confidential_level']])
        ? $this->icons['level_'.$entry['confidential_level']]
        : '';
    }

    if (!($this->access && !$this->access->update) && false !== $this->flags->a_update) {

      $codeEntr = <<<HTML

    <li
      class="wcm wcm_control_access_dataset node-{$entry['attach_id']} entry hidden-controls"
      id="wgt-{$elemId}-entry-{$entry['attach_id']}"
      data-url="{$this->urlEdit}{$this->defUrl}&amp;objid={$entry['attach_id']}" >
HTML;

    } else {

      $codeEntr = <<<HTML

    <li
      class="{$rowClass} node-{$entry['attach_id']} entry hidden-controls"
      id="wgt-{$elemId}-entry-{$entry['attach_id']}" >
HTML;

    }

    $fileType = '';
    
    if (isset($entry['file_type'])) {
        $fileType = $entry['file_type'].': ';
    }

    $codeEntr .= <<<HTML
          <div class="wrapper" >
            <div class="left" >
            {$fileType} {$link} ({$confidentialIcon})<br />
            {$timeCreated} {$fileSize} <span
            class="wcm wcm_control_contact_user"
            wgt_eid="{$entry['user_id']}"
            title="{$entry['lastname']}, {$entry['firstname']}" >{$entry['user_name']}</span> <br />
            {$entry['description']}
            </div>
            <div class="right controls" >
                {$menuCode}
            </div>
          <div class="do-clear" > </div>
      </div>
    </li>

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

    $html = '';

    if ($this->data) {

      foreach ($this->data as $entry) {
        $html .= $this->renderAjaxEntry($this->idKey, $entry);
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
  <div id="{$menuId}" >
    <a
      href="{$this->urlEdit}{$this->defAction}&objid={$entry['attach_id']}"
      class="wcm wcm_req_ajax"
      tabindex="-1" ><i class="fa fa-edit" ></i> Edit</a> |
    <a
      onclick="\$R.del('{$this->urlDelete}{$this->defAction}&objid={$entry['attach_id']}',{confirm:'Confirm to delete.'});"
      tabindex="-1" ><i class="fa fa-times" ></i> delete</a>
 </div>
HTML;

    return $html;


  }//end public function renderRowMenu */




} // end class WgtElementAttachmentList

