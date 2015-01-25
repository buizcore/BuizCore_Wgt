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
 * Eine Tagcloud
 * @package net.buizcore.wgt
 */
class WgtElementTagCloud extends WgtAbstract
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $label = 'Tags';

  /**
   * @var string
   */
  public $width = 450;

  /**
   * @var string
   */
  public $urlAutoComplete = 'ajax.php?c=Buiz.Tag.autocomplete';

  /**
   * @var string
   */
  public $urlCreate = 'ajax.php?c=Buiz.Tag.add';

  /**
   * @var string
   */
  public $urlDisconnect = 'ajax.php?c=Buiz.Tag.disconnect';

  /**
   * Die ID des Datensatzes der getaggt werden soll
   * @var int
   */
  public $refId = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct($name = null, $view = null)
  {

    $this->texts = new TArray();

    $this->name = $name;
    $this->init();

    if ($view)
      $view->addElement($name, $this);

  } // end public function __construct */

  /**
   * @param TFlag $params
   * @return string
   */
  public function render($params = null)
  {

    if ($this->html)
      return $this->html;

    $codeEntr = '';

    /**
     * title:
     * content:
     */
    if ($this->data) {
      foreach ($this->data as $entry) {

        $codeEntr .= <<<HTML

  <span class="tag" wgt_eid="{$entry['ref_id']}" wgt_tid="{$entry['tag_id']}" >{$entry['label']}</span>

HTML;

      }
    }

    $id = $this->getId();

    $settings = array();

    if ($this->refId)
      $settings[] = '"refid":"'.$this->refId.'"';

    if ($this->urlAutoComplete)
      $settings[] = '"url_auto_complete":"'.SFormatStrings::cleanCC($this->urlAutoComplete).'"';

    if ($this->urlCreate)
      $settings[] = '"url_tag_create":"'.SFormatStrings::cleanCC($this->urlCreate).'"';

    if ($this->urlDisconnect)
      $settings[] = '"url_tag_disconnect":"'.SFormatStrings::cleanCC($this->urlDisconnect).'"';

    $codeSetings = '{'.implode(',', $settings).'}';


    $settingsAuto = '';
    $classAuto = '';

    if ($this->urlAutoComplete) {
      $urlAutoComplete = SFormatStrings::cleanCC($this->urlAutoComplete);

      $settingsAuto = <<<HTML

  <var class="wgt-settings" >{
    "url":"{$urlAutoComplete}&amp;refid={$this->refId}&amp;key=",
    "type":"entity"}
  </var>

  <input
    type="hidden"
    id="{$id}-autoc" />

HTML;

      $classAuto = 'wcm wcm_ui_autocomplete ';
    }

    $html = <<<HTML

<section
  class="wgt-content_box wgt-tag-cloud wcm wcm_widget_tag_cloud"
  id="{$id}"
  style="width:{$this->width}px;" >

  <header>
    <div class="left" style="width:210px;" ><h2>{$this->label}</h2></div>
    <div class="right" style="width:250px;" >
      <input
        type="text"
        class="{$classAuto} c_input_add medium wgt-ignore"
        id="{$id}-autoc-tostring" />
      {$settingsAuto}
      <button
        id="{$id}-trigger"
        tabindex="-1"
        class="wgt-button c_cntrl_add append" ><i class="fa fa-plus-circle" ></i></button>
    </div>
    <div class="do-clear tiny" >&nbsp;</div>
  </header>

  <div class="content" >
    {$codeEntr}
  </div>

  <var id="{$id}-cfg-tag_cloud" >{$codeSetings}</var>
</section>

HTML;

    return $html;

  } // end public function render */

} // end class WgtElementTagcloud

