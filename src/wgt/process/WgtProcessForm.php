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

/** Form Class
 *
 * @package net.buizcore.wgt
 */
class WgtProcessForm extends WgtAbstract
{
/*////////////////////////////////////////////////////////////////////////////*/
// public interface attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * der Prozess
   * @var Process
   */
  public $process = null;

  /**
   * die id des formulars an welches die Prozessdaten gehängt werden
   * @var string
   */
  public $formId = null;

  /**
   * Objekt mit relevanten Parametern zum bauen des Form Templates
   * @var string
   */
  public $params = null;

  /**
   * Das Label des Prozesses
   * @var string
   */
  public $processLabel = null;

  /**
   * Flag ob der Prozess einen gesonderten Running Status hat
   * @var string
   */
  public $hasStatus = true;

/*////////////////////////////////////////////////////////////////////////////*/
// public interface attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param LibTemplate $view
   * @param int $name the name of the wgt object
   */
  public function __construct($view = null, $name = null)
  {

    $this->view = $view?$view:BuizCore::$env->getTpl();
    $this->name = $name;
    $this->init();

  } // end public function __construct */

  /**
   * @param string $formId
   * @param TFlag $params
   * @return string
   */
  public function render($params = null)
  {

      if(!$params){
          $params = new TFlag();
      }
      
      // shitty solution
      if (!$params->formId) {
          $params->formId = 'wgt-form-process-'.$this->process->name.'-'.$this->process->entity->getId();
      }
      
    $this->formId = $params->formId;
    $i18n = $this->getI18n();

    Debug::console("RENDER PROCESS", $this->process);

    if (!$this->process) {
      Debug::console('MISSING PROCESS');

      return '';
    }

    $statusData = $this->process->getActiveNode();

    $iconStatus = $this->icon($statusData->icon , $statusData->label);

    $statusHtml = $this->renderStatusDropdown($this->process, $params);

    $edges = $this->process->getActiveEdges();
    $actionHtml = $this->renderEdgeActions($edges, $params);
    $descriptionHtml = $this->renderEdgeDescriptions($edges, $params);

    Debug::console("Process Context key: wgt-process-{$this->process->name}-{$params->contextKey}");

    $codeButtons = '';

    if (isset($this->process->access) && $this->process->access->admin) {

      $codeButtons = <<<HTML

       <button
        class="wgt-button"
        tabindex="-1"
        onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-change-{$this->process->name}')();" ><i class="fa fa-random" ></i> Change</button>

HTML;

    }

    $codePhases = $this->renderPhases($this->process);
    $codePSteps = $this->renderPhaseSteps($this->process);
    $codeStates = $this->renderStates($this->process);
    $slidesHtml = $this->renderSlides($this->process);


    $html = <<<HTML

  <div class="wgt-panel-control" >

  <form
    method="put"
    id="{$this->formId}-states"
    action="ajax.php?c={$this->process->processUrl}.saveStates&amp;objid={$this->process->activStatus}" ></form>

    <button
        class="wcm wcm_ui_dropform wcm_ui_tip-top wgt-button"
        id="wgt-process-{$this->process->name}-{$params->contextKey}"
        title="Click to Change the Status"
      ><div
        class="left">{$iconStatus} Status: {$statusData->label} <i class="fa fa-angle-down" ></i></div><var>{"size":"big"}</var></button>

    <div class="wgt-process-{$this->process->name}-{$params->contextKey} hidden" >

      <div class="wgt-process-form" >

        <div
          class="wcm wcm_ui_tip-top wgt-panel title"
          tooltip="{$this->processLabel}" >
          <h2>{$i18n->l('Status','wbf.label')}: {$statusData->label}</h2>
          <div class="right" ><a class="wgt-button icon-only wgtac_close_overlay"  ><i class="fa fa-times" ></i></a></div>
        </div>

{$codePhases}
{$codePSteps}

        <div class="wgt-panel" >

          <button
            class="wgt-button"
            tabindex="-1"
            onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-history-{$this->process->name}')();" ><i class="fa fa-book" ></i> Show History</button>

          <button
            class="wgt-button"
            tabindex="-1"
            onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-graph-{$this->process->name}')()" ><i class="fa fa-sitemap" ></i> Process Graph</button>
{$codeButtons}
{$statusHtml}
        </div>


        <div class="do-clear small" ></div>

        <div class="description left" >
          <h3>{$i18n->l('Description','wbf.label')}</h3>
          <div class="description-active" >
            {$statusData->description}
          </div>
{$descriptionHtml}
        </div>

        <div class="form" >

{$slidesHtml}

          <div class="do-clear small" ></div>

          <div class="action" >
            <h3>{$i18n->l('Action','wbf.label')}</h3>
            <ul class="actions" >
              {$actionHtml}
            </ul>
            <div class="do-clear" ></div>
          </div>

          <div class="do-clear small" ></div>
        </div>

        <div class="states" >
          <h3>Checklist</h3>
          {$codeStates}
        </div>

      </div>

    </div>

  </div>

HTML;

    return $html;

  }//end public function render */

  /**
   * @param string $formId
   * @param TFlag $params
   * @return string
   */
  public function renderTemplate($params = null)
  {
  
      if(!$params){
          $params = new TFlag();
      }
  
      // shitty solution
      if (!$params->formId) {
          $params->formId = 'wgt-form-process-'.$this->process->name.'-'.$this->process->entity->getId();
      }
  
      $this->formId = $params->formId;
      $i18n = $this->getI18n();
  
      Debug::console("RENDER PROCESS", $this->process);
  
      if (!$this->process) {
          Debug::console('MISSING PROCESS');
  
          return '';
      }
  
      $statusData = $this->process->getActiveNode();
  
      $iconStatus = $this->icon($statusData->icon , $statusData->label);
  
      $statusHtml = $this->renderStatusDropdown($this->process, $params);
  
      $edges = $this->process->getActiveEdges();
      $actionHtml = $this->renderEdgeActions($edges, $params);
      $descriptionHtml = $this->renderEdgeDescriptions($edges, $params);
  
      Debug::console("Process Context key: wgt-process-{$this->process->name}-{$params->contextKey}");
  
      $codeButtons = '';
  
      if (isset($this->process->access) && $this->process->access->admin) {
  
          $codeButtons = <<<HTML
  
       <button
        class="wgt-button"
        tabindex="-1"
        onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-change-{$this->process->name}')();" ><i class="fa fa-random" ></i> Change</button>
  
HTML;
  
      }
  
      $codePhases = $this->renderPhases($this->process);
      $codePSteps = $this->renderPhaseSteps($this->process);
      $codeStates = $this->renderStates($this->process);
      $slidesHtml = $this->renderSlides($this->process);
  
  
      $html = <<<HTML
  
  <div class="wgt-panel-control" >
  
    <form
      method="put"
      id="{$this->formId}"
      action="ajax.php?c={$this->process->processUrl}.switchStatus&amp;objid={$this->process->activStatus}" ></form>
  
    <form
        method="put"
        id="{$this->formId}-states"
        action="ajax.php?c={$this->process->processUrl}.saveStates&amp;objid={$this->process->activStatus}" ></form>
  
    <button
        class="wcm wcm_ui_dropform wcm_ui_tip-top wgt-button"
        id="wgt-process-{$this->process->name}-{$params->contextKey}"
        title="Click to Change the Status"
      ><div
        class="left">{$iconStatus} Status: {$statusData->label} <i class="fa fa-angle-down" ></i></div><var>{"size":"big"}</var></button>
  
    <div class="wgt-process-{$this->process->name}-{$params->contextKey} hidden" >
  
      <div class="wgt-process-form" >
  
        <div
          class="wcm wcm_ui_tip-top wgt-panel title"
          tooltip="{$this->processLabel}" >
          <h2>{$i18n->l('Status','wbf.label')}: {$statusData->label}</h2>
          <div class="right" ><a class="wgt-button icon-only wgtac_close_overlay"  ><i class="fa fa-times" ></i></a></div>
        </div>
  
{$codePhases}
{$codePSteps}
  
        <div class="wgt-panel" >
  
          <button
            class="wgt-button"
            tabindex="-1"
            onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-history-{$this->process->name}')();" ><i class="fa fa-book" ></i> Show History</button>
  
          <button
            class="wgt-button"
            tabindex="-1"
            onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-graph-{$this->process->name}')()" ><i class="fa fa-sitemap" ></i> Process Graph</button>
{$codeButtons}
{$statusHtml}
        </div>
  
  
        <div class="do-clear small" ></div>
  
        <div class="description left" >
          <h3>{$i18n->l('Description','wbf.label')}</h3>
          <div class="description-active" >
            {$statusData->description}
          </div>
{$descriptionHtml}
        </div>
  
        <div class="form" >
  
{$slidesHtml}
  
          <div class="do-clear small" ></div>
  
          <div class="action" >
            <h3>{$i18n->l('Action','wbf.label')}</h3>
            <ul class="actions" >
              {$actionHtml}
            </ul>
            <div class="do-clear" ></div>
          </div>
  
          <div class="do-clear small" ></div>
        </div>
  
        <div class="states" >
          <h3>Checklist</h3>
          {$codeStates}
        </div>
  
      </div>
  
    </div>
  
  </div>
  
HTML;
  
            return $html;
  
  }//end public function render */

  /**
   * @param TFlag $params
   * @return string
   */
  public function renderListForm($params)
  {

    $this->formId = 'wgt-form_'.$params->inputId;

    $i18n = $this->getI18n();

    if (!$this->access)
      $this->access = $params->access;

    Debug::console("RENDER PROCESS", $this->process);

    if (!$this->process) {
      Debug::console('MISSING PROCESS');

      return '';
    }

    $statusData = $this->process->getActiveNode();

    $iconStatus = $this->icon($statusData->icon , $statusData->label);


    /*
    <div class="wgt-panel" >
      <button class="wgt-button" ><img class="wgt-icon" src="<?php echo $pathIcon ?>xsmall/process/feedback.png" /> Request Feedback</button>
      <button class="wgt-button" ><img class="wgt-icon" src="<?php echo $pathIcon ?>xsmall/process/history.png" /> Show History</button>
    </div>
     */

    $edges = $this->process->getActiveEdges();
    $actionHtml = $this->renderListFormEdgeActions($edges, $params);
    $descriptionHtml = $this->renderEdgeDescriptions($edges, $params);

    $urlSwitchType = '';
    $appendToUrl = '';

    if ($params->maskType) {
      $urlSwitchType = ucfirst($params->maskType);
    }

    if ($params->targetMask) {
      $appendToUrl   .= "&amp;target_mask={$params->targetMask}" ;
    }

    if ($params->ltype) {
      $appendToUrl   .= "&amp;ltpye={$params->ltype}";
    }

    if ($params->element) {
      $appendToUrl   .= "&amp;element={$params->element}";
    }

    if ($params->refId) {
      $appendToUrl   .= "&amp;refid={$params->refId}";
    }

    if ($params->viewId) {
      $appendToUrl   .= "&amp;view_id={$params->viewId}";
    }

    $codeButtons = '';

    if ($this->process->access->admin) {

      $codeButtons = <<<HTML

       <button
        class="wgt-button"
        tabindex="-1"
        onclick="\$S('#{$params->inputId}').data('paction-change-{$this->process->name}')();" ><i class="fa fa-random" ></i> Change</button>

HTML;

    }

    $codePhases = $this->renderPhases($this->process);
    $codePSteps = $this->renderPhaseSteps($this->process);
    $codePStatus = $this->renderStatusDropdownList($this->process, $params);
    $codeStates = $this->renderStates($this->process);
    $slidesHtml = $this->renderSlides($this->process);

    $html = <<<HTML

  <div class="wgt-process-form" >

    <form
      method="put"
      id="{$this->formId}"
      action="ajax.php?c={$this->process->processUrl}.switchStatus{$urlSwitchType}&amp;objid={$this->process->activStatus}{$appendToUrl}" ></form>

    <form
      method="put"
      id="{$this->formId}-states"
      action="ajax.php?c={$this->process->processUrl}.saveStates&amp;objid={$this->process->activStatus}{$appendToUrl}" ></form>

    <div
      class="wcm wcm_ui_tip-top wgt-panel title"
      tooltip="{$this->processLabel}" >
      <h2>{$i18n->l('Status','wbf.label')}: {$statusData->label}</h2>

      <div class="right" ><a class="wgt-button icon-only wgtac_close_overlay"  ><i class="fa fa-times" ></i></a></div>

    </div>

{$codePhases}
{$codePSteps}

    <div class="wgt-panel" >

      <button
        class="wgt-button"
        tabindex="-1"
        onclick="\$S('#{$params->inputId}').data('paction-history-{$this->process->name}')();" ><i class="fa fa-book" ></i> Show History</button>

      <button
        class="wgt-button"
        tabindex="-1"
        onclick="\$S('#{$params->inputId}').data('paction-graph-{$this->process->name}')();" ><i class="fa fa-sitemap" ></i> Process Graph</button>

{$codeButtons}
{$codePStatus}
    </div>

    <div class="do-clear small" ></div>

    <div class="description left" >
      <h3>{$i18n->l('Description','wbf.label')}</h3>
      <div class="description-active" >
        {$statusData->description}
      </div>
{$descriptionHtml}
    </div>

    <div class="form" >

{$slidesHtml}

      <div class="do-clear small" ></div>

      <div class="action" >
        <h3>{$i18n->l('Action','wbf.label')}</h3>
        <ul class="actions" >
          {$actionHtml}
        </ul>
        <div class="do-clear" ></div>
      </div>

      <div class="do-clear small" ></div>
    </div>

    <div class="states" >
      <h3>Checklist</h3>
      {$codeStates}
    </div>

  </div>


HTML;

    $this->renderListFormActionJs($params);

    return $html;

  }//end public function renderListForm */

  /**
   * @return string
   */
  public function renderForm($view)
  {

    if (!$this->process) {
      Debug::console('MISSING PROCESS');

      return 'Missing Process';
    }

    $i18n = $this->getI18n();

    $params = $this->params;
    $this->formId = $params->formId;

    $statusData = $this->process->getActiveNode();

    $iconStatus = $this->icon($statusData->icon , $statusData->label);
    $iconHistory = $this->icon('process/history.png', 'History');


    $edges = $this->process->getActiveEdges();
    $actionHtml = $this->renderTemplateEdgeActions($edges, $params);
    $descriptionHtml = $this->renderEdgeDescriptions($edges, $params);

    $slides = $this->process->getActiveSlices();
    $slidesHtml = '';

    if ($slides) {
      $slidesHtml .= '<div class="slides" >'.NL;

      foreach ($slides as $slide) {
        $slRenderer = $slide->getRenderer();
        $slidesHtml .= $slRenderer->render($this);
      }

      $slidesHtml .= '</div>'.NL;
    }

    $html = <<<HTML

  <div style="width:650px;" class="wgt-space" >

    <form
      method="put"
      id="{$this->formId}"
      action="ajax.php?c={$this->process->processUrl}.switchStatus&amp;view_id={$view->id}&amp;objid={$this->process->activStatus}" ></form>

    <div class="do-clear medium" ></div>

{$slidesHtml}

    <div class="half-b left" >
      <h3>{$i18n->l('Description', 'wbf.label')}</h3>
      <div class="description-active" >
        {$statusData->description}
      </div>
{$descriptionHtml}
    </div>

    <div class="half-b right" >
      <h3>{$i18n->l('Action', 'wbf.label')}</h3>
      <ul class="actions" >
        {$actionHtml}
      </ul>
      <div class="do-clear" ></div>
    </div>

    <div class="do-clear small" ></div>
  </div>


HTML;

    return $html;

  }//end public function renderForm */

  /**
   * @param array<LibProcess_Edge> $edges
   * @param TFlag $params
   * @return string
   */
  protected function renderEdgeActions($edges, $params)
  {

    $html = '';
    $entity = $this->process->getEntity();

    foreach ($edges as $edge) {

      $iconNode = $this->icon($edge->icon , $edge->label);

      $html .=<<<HTML

  <li>
    <button
      class="wgt-button"
      tabindex="-1"
      onclick="\$S('#wgt-process-{$this->process->name}-{$params->contextKey}').data('paction-{$this->process->name}-{$edge->key}')();" >
      {$iconNode} {$edge->label}
    </button>

  </li>

HTML;

    /*

    <button
      class="wgt-button info wcm wcm_ui_tip"
      title="Klick for more information"  >
      {$iconInfo}
    </button>
     */

    }

    return $html;

  }//end protected function renderEdgeActions */

  /**
   * @param array<LibProcess_Edge> $edges
   * @param TFlag $params
   * @return string
   */
  protected function renderListFormEdgeActions($edges, $params)
  {

    $html = '';
    $entity = $this->process->getEntity();

    $iconInfo = $this->icon('control/info.png' , 'Info');

    foreach ($edges as $edge) {

      $iconNode = $this->icon($edge->icon , $edge->label);

      $html .=<<<HTML

  <li>
    <button
      class="wgt-button"
      tabindex="-1"
      onclick="\$S('#{$params->inputId}').data('paction-{$this->process->name}-{$edge->key}')();" >
      {$iconNode} {$edge->label}
    </button>

  </li>

HTML;

    }

    /*
    <button
      class="wgt-button info wcm wcm_ui_tip"
      title="Klick for more information"  >
      {$iconInfo}
    </button>
     */

    return $html;

  }//end protected function renderListFormEdgeActions */

  /**
   * @param array<LibProcess_Edge> $edges
   * @param TFlag $params
   * @return string
   */
  protected function renderTemplateEdgeActions($edges, $params)
  {

    $html = '';
    $entity = $this->process->getEntity();

    $iconInfo = $this->icon('control/info.png' , 'Info');

    foreach ($edges as $edge) {

      $iconNode = $this->icon($edge->icon , $edge->label);

      $html .=<<<HTML

  <li>
    <button
      class="wgt-button"
      tabindex="-1"
      onclick="\$S('#{$this->formId}').data('paction-{$this->process->name}-{$edge->key}')();"
      id="wgt-button-{$this->process->name}-{$params->contextKey}-{$edge->key}" >
      {$iconNode} {$edge->label}
    </button>

  </li>

HTML;

    }

    /*

    <button
      class="wgt-button info wcm wcm_ui_tip"
      id="wgt-button-info-{$this->process->name}-{$params->contextKey}-{$edge->key}"
      title="Klick for more information"  >
      {$iconInfo}
    </button>
     */

    return $html;

  }//end protected function renderTemplateEdgeActions */

  /**
   * @param array<LibProcess_Edge> $edges
   * @param TFlag $params
   * @return string
   */
  protected function renderEdgeDescriptions($edges, $params)
  {

    $html = '';

    foreach ($edges as $edge) {

      $html .= <<<HTML

  <div class="description-{$edge->key} hidden" >
    {$edge->description}
  </div>

HTML;

    }

    return $html;

  }//end protected function renderEdgeDescriptions */

  /**
   * @param TFlag $params
   * @return string
   */
  public function buildEdgeActionJs($params)
  {

    if (!$this->process) {
      return '';
    }

    $edges = $this->process->getActiveEdges();
    $entity = $this->process->getEntity();

    $html = <<<HTML

    var process = self.getObject().find("#wgt-process-{$this->process->name}-{$params->contextKey}").not('flag-touch');

    if (process) {

      process.addClass('flag-touch');

      process.data('paction-history-{$this->process->name}', function() {
        \$R.get('modal.php?c=Process.Base.showHistory&process={$this->process->activStatus}&objid={$entity}&entity={$entity->getTable()}');
        \$S.fn.miniMenu.close();
      });


      process.data('paction-graph-{$this->process->name}', function() {
        \$R.get('maintab.php?c={$this->process->processUrl}.showNodeGraph&objid={$this->process->activStatus}');
        \$S.fn.miniMenu.close();
      });

      process.data('paction-change-{$this->process->name}', function() {
        \$R.get('modal.php?c=Buiz.Maintenance_Process.formSwitchStatus&process_id={$this->process->processId}&vid={$entity->getId()}&dkey={$entity->getTable()}&active={$this->process->activStatus}');
        \$S.fn.miniMenu.close();
      });

      process.data('paction-stateChange-{$this->process->name}', function(state) {
        self.setChanged(false);
        \$R.form('{$params->formId}','&process_state='+state+'&reload=true',{append:true});
      });

    } else {
      alert("Missing Process Node!");
    }

HTML;

    foreach ($edges as $edge) {

      if ($edge->confirm) {

        $html .= <<<HTML

    if (process) {

      process.data('paction-{$this->process->name}-{$edge->key}', function() {
        self.setChanged(false);
        if (!\$S('input#wgt-input-{$this->process->name}-confirm-{$entity}').is(':checked')) {
          \$D.errorWindow('You have to confirm before trigger {$edge->label}');

          return false;
        }
        \$R.form('{$params->formId}','&process_edge={$edge->key}&reload=true',{append:true});
      });
    }

HTML;
      } else {

        $html .= <<<HTML

    if (process) {
      process.data('paction-{$this->process->name}-{$edge->key}', function() {
        self.setChanged(false);
        \$R.form('{$params->formId}','&process_edge={$edge->key}&reload=true',{append:true});
      });
    }

HTML;
      }

    }

    return $html;

  }//end public function buildEdgeActionJs */
  
  /**
   * @param TFlag $params
   * @return string
   */
  public function buildTemplateJs($params, $callback = null)
  {
  
      if (!$this->process) {
          return '';
      }
  
      $edges = $this->process->getActiveEdges();
      $entity = $this->process->getEntity();
  
      $html = <<<HTML
  
    var process = $("#wgt-process-{$this->process->name}-{$params->contextKey}").not('flag-touch');
  
    if (process) {
  
      process.addClass('flag-touch');
  
      process.data('paction-history-{$this->process->name}', function() {
        \$R.get('modal.php?c=Process.Base.showHistory&process={$this->process->activStatus}&objid={$entity}&entity={$entity->getTable()}');
        \$S.fn.miniMenu.close();
      });
  
      process.data('paction-graph-{$this->process->name}', function() {
        \$R.get('maintab.php?c={$this->process->processUrl}.showNodeGraph&objid={$this->process->activStatus}');
        \$S.fn.miniMenu.close();
      });
  
      process.data('paction-change-{$this->process->name}', function() {
        \$R.get('modal.php?c=Buiz.Maintenance_Process.formSwitchStatus&process_id={$this->process->processId}&vid={$entity->getId()}&dkey={$entity->getTable()}&active={$this->process->activStatus}');
        \$S.fn.miniMenu.close();
        {$callback}
      });
  
      process.data('paction-stateChange-{$this->process->name}', function(state) {
        \$R.form('{$params->formId}','&process_state='+state+'&reload=true',{append:true});
      });
  
    } else {
      alert("Missing Process Node!");
    }
  
HTML;
  
      foreach ($edges as $edge) {
  
          if ($edge->confirm) {
  
              $html .= <<<HTML
  
    if (process) {
  
      process.data('paction-{$this->process->name}-{$edge->key}', function() {
        if (!\$S('input#wgt-input-{$this->process->name}-confirm-{$entity}').is(':checked')) {
          \$D.errorWindow('You have to confirm before trigger {$edge->label}');
  
          return false;
        }
        \$R.form('{$params->formId}','&process_edge={$edge->key}&reload=true',{append:true});
      });
    }
  
HTML;
          } else {
  
              $html .= <<<HTML
  
    if (process) {
      process.data('paction-{$this->process->name}-{$edge->key}', function() {
        \$R.form('{$params->formId}','&process_edge={$edge->key}&reload=true',{append:true});
      });
    }
  
HTML;
          }
  
      }
  
      return $html;
  
  }//end public function buildEdgeActionJs */

  /**
   * @param TFlag $params
   * @return string
   */
  public function renderListFormActionJs($params)
  {

    if (!$this->process) {
      return '';
    }

    $edges = $this->process->getActiveEdges();
    $entity = $this->process->getEntity();

    $html = <<<HTML

    var process = \$S("#{$params->inputId}");
    var appendEvents = false;
    if (!process.is('flag-touch')) {

      process.addClass('flag-touch');
      appendEvents = true;

      process.data('paction-history-{$this->process->name}', function() {
        \$R.get('modal.php?c=Process.Base.showHistory&process={$this->process->activStatus}&objid={$entity}&entity={$entity->getTable()}');
        \$S.fn.miniMenu.close();
      });


      process.data('paction-graph-{$this->process->name}', function() {
        \$R.get('maintab.php?c={$this->process->processUrl}.showNodeGraph&objid={$this->process->activStatus}');
        \$S.fn.miniMenu.close();
      });

      process.data('paction-change-{$this->process->name}', function() {
        \$R.get('modal.php?c=Buiz.Maintenance_Process.formSwitchStatus&process_id={$this->process->processId}&vid={$entity->getId()}&dkey={$entity->getTable()}&active={$this->process->activStatus}');
        \$S.fn.miniMenu.close();
      });
    }

HTML;

    foreach ($edges as $edge) {

      if ($edge->confirm) {

        $html .= <<<HTML

    if (appendEvents) {
      process.data('paction-{$this->process->name}-{$edge->key}', function() {
        if (!\$S('#wgt-input-{$this->process->name}-confirm-{$entity}').is(':checked')) {
          \$D.errorWindow('You have to confirm before trigger {$edge->label}');

          return false;
        }
        \$R.form('{$this->formId}','&status={$edge->key}&reload=true',{append:true});
      });
    }

HTML;
      } else {

        $html .= <<<HTML

    if (appendEvents) {

      process.data('paction-{$this->process->name}-{$edge->key}', function() {
        \$R.form('{$this->formId}','&status={$edge->key}&reload=true',{append:true});
      });
    }

HTML;
      }

    }

    $this->view->addJsCode($html);

    //return '<script type="application/javascript" >(function() {'.$html.'})(window);</script>';

  }//end public function renderListFormActionJs */


  /**
   * @param TFlag $params
   * @return string
   */
  public function buildTemplateEdgeActionJs($params)
  {

    if (!$this->process) {
      return '';
    }

    $edges = $this->process->getActiveEdges();
    $entity = $this->process->getEntity();
    
    if ($params->formId) {
        $formId = $params->formId;
    } else {
        $formId = $this->formId;
    }

    $html = <<<HTML

    var process = self.getObject().find('#{$formId}').not('flag-touch');

    if (process) {
      console.log('Found Process #{$formId}');

      process.addClass('flag-touch');


      process.data('paction-history-{$this->process->name}', function() {
        \$R.get('modal.php?c=Process.Base.showHistory&process={$this->process->activStatus}&objid={$entity}&entity={$entity->getTable()}');
      });

      process.data('paction-graph-{$this->process->name}', function() {
        \$R.get('maintab.php?c={$this->process->processUrl}.showNodeGraph&objid={$this->process->activStatus}');
      });

      process.data('paction-change-{$this->process->name}', function() {
        \$R.get('modal.php?c=Buiz.Maintenance_Process.formSwitchStatus&process_id={$this->process->processId}&vid={$entity->getId()}&dkey={$entity->getTable()}&active={$this->process->activStatus}');
      });
    } else {
      alert('Missing Process #wgt-process-{$this->process->name}-{$params->contextKey}');
      console.error('Missing Process #wgt-process-{$this->process->name}-{$params->contextKey}');
    }


HTML;

    foreach ($edges as $edge) {

      if ($edge->confirm) {

        $html .= <<<HTML

    if (process) {
      process.data('paction-{$this->process->name}-{$edge->key}', function() {

        if (!\$S('#wgt-input-{$this->process->name}-confirm-{$entity}').is(':checked')) {
          \$D.errorWindow('You have to confirm before trigger {$edge->label}');

          return false;
        }
        \$R.form('{$formId}','&process_edge={$edge->key}',{append:true});
      });
      console.log('Add pAction paction-{$this->process->name}-{$edge->key}');
    }


HTML;
      } else {

        $html .= <<<HTML

    if (process) {

      process.data('paction-{$this->process->name}-{$edge->key}', function() {
        \$R.form('{$formId}','&process_edge={$edge->key}',{append:true});
      });
      console.log('Add pAction paction-{$this->process->name}-{$edge->key}');
    }


HTML;
      }

    }

    return $html;

  }//end public function buildTemplateEdgeActionJs */

/*////////////////////////////////////////////////////////////////////////////*/
// Sub render Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param Process $process
   * @return string
   */
  protected function renderPhases($process)
  {

    $codePhases = '';

    $statusData = $process->getActiveNode();

    if ($process->phases) {

      $phEntries = '';

      foreach ($this->process->phases as $phaseName => $phaseData) {

        $active = null;
        if ($statusData->phaseKey &&  $statusData->phaseKey == $phaseName) {
          $active = ' wgt-active';
        }

        // überspringen wenn nicht im pfad
        if (isset($phaseData['display']['path']) && !$phaseData['display']['path'] &&!$active)
          continue;

        $phEntries .= <<<HTML
      <li class="nb{$active}" ><span>{$phaseData['label']}</span></li>
HTML;
      }

      $codePhases = <<<HTML
    <div class="wgt-panel progress" >
      <label class="text" >Phases:</label>
      <ul class="progress" >
      {$phEntries}
      </ul>
     </div>
HTML;

    }

    return $codePhases;

  }//end protected function renderPhases */

  /**
   *
   * @param Process $process
   * @return string
   */
  protected function renderPhaseSteps($process)
  {

    $codePhases = '';

    $statusData = $process->getActiveNode();

    if ($statusData->phaseKey) {

      $phEntries = '';

      foreach ($this->process->nodes as $nodeKey => $nodeData) {

        // überspringen wenn nicht im pfad
        if (isset($nodeData['display']['path']) && !$nodeData['display']['path']) {

          if ($statusData->key !== $nodeKey)
            continue;
        }


        Debug::console("{$statusData->phaseKey}, {$nodeData['phase']}, {$nodeData['label']}");

        if ($nodeData['phase'] !== $statusData->phaseKey && $nodeData['preview'] !== $statusData->phaseKey)
          continue;

        $active = null;
        if ($statusData->key == $nodeKey) {

          $active = ' wgt-active';
        }

        $phEntries .= <<<HTML
      <li class="nb{$active}" ><span>{$nodeData['label']}</span></li>
HTML;
      }

      $codePhases = <<<HTML
    <div class="wgt-panel progress" >
      <label class="text" >Steps:</label>
      <ul class="progress" >
      {$phEntries}
      </ul>
     </div>
HTML;

    }

    return $codePhases;

  }//end protected function renderPhaseSteps */

  /**
   * @param Process $process
   * @param Context $params
   * @return string
   */
  protected function renderStatusDropdownList($process, $params)
  {

    // hat keinen status
    if (!$process->hasRunningState)
      return '';

    $iconPStL = array();
    $iconPStL[0] = '<i class="fa fa-ok fa-2x wgt-cursor-pointer" ></i>';
    $iconPStL[1] = '<i class="fa fa-warning-sign fa-2x wgt-cursor-pointer" ></i>';
    $iconPStL[2] = '<i class="fa fa-time fa-2x wgt-cursor-pointer" ></i>';
    $iconPStL[3] = '<i class="fa fa-times fa-2x wgt-cursor-pointer" ></i>';
    $iconPStL[4] = '<i class="fa fa-ok-circle fa-2x wgt-cursor-pointer" ></i>';

    $iconSt = array();
    $iconSt[0] = '<i class="fa fa-ok" ></i>';
    $iconSt[1] = '<i class="fa fa-warning-sign" ></i>';
    $iconSt[2] = '<i class="fa fa-clock-o" ></i>';
    $iconSt[3] = '<i class="fa fa-times" ></i>';
    $iconSt[4] = '<i class="fa fa-ok-circle" ></i>';

    $stateUrl = "ajax.php?c={$process->processUrl}.changeStateListing"
      ."&process_id={$process->processId}"
      ."&vid={$process->entity}&cntrl={$params->inputId}&target_mask={$params->targetMask}"
      ."&objid={$process->activStatus}&dkey={$params->dkey}"
      ."&state=";

    $codeStatus = <<<HTML
      <div
        class="right"
      ><button
          class=" wcm wcm_control_dropmenu pstate wgt-button"
          id="wgt-process-{$process->name}-{$process->entity}-drop-cntrl"
          data-drop-box="wgt-process-{$process->name}-{$process->entity}-dropbox" >{$iconPStL[$process->state]}</button>
        <var
          id="wgt-process-{$process->name}-{$process->entity}-drop-cntrl-cfg-dropmenu"
        >{"align":"right","closeScroll":"true"}</var>
      </div>
      <div
        class="wgt-dropdownbox al_right"
        id="wgt-process-{$process->name}-{$process->entity}-dropbox"  >
        <ul>
          <li><a
            onclick="\$R.put('{$stateUrl}0');"   >
            {$iconSt[0]} Running
          </a></li>
          <li><a
            onclick="\$R.put('{$stateUrl}1');"   >
            {$iconSt[1]} Warning
          </a></li>
          <li><a
            onclick="\$R.put('{$stateUrl}2');"   >
            {$iconSt[2]} Pause
          </a></li>
          <li><a
            onclick="\$R.put('{$stateUrl}3');"   >
            {$iconSt[3]} Aborted
          </a></li>
          <li><a
            onclick="\$R.put('{$stateUrl}4');"   >
            {$iconSt[4]} Completed
          </a></li>
        </ul>
      </div>
HTML;

    return $codeStatus;

  }//end protected function renderStatusDropdownList */

  /**
   * @param Process $process
   * @param Context $params
   * @return string
   */
  protected function renderStatusDropdown($process, $params)
  {
    // hat keinen status
    if (!$process->hasRunningState)
      return '';

    $iconPStL = array();
    $iconPStL[0] = '<i class="fa fa-check fa-2x wgt-cursor-pointer" ></i>';
    $iconPStL[1] = '<i class="fa fa-warning fa-2x wgt-cursor-pointer" ></i>';
    $iconPStL[2] = '<i class="fa fa-time fa-2x wgt-cursor-pointer" ></i>';
    $iconPStL[3] = '<i class="fa fa-times fa-2x wgt-cursor-pointer" ></i>';
    $iconPStL[4] = '<i class="fa fa-check-circle-o fa-2x wgt-cursor-pointer" ></i>';

    $iconSt = array();
    $iconSt[0] = '<i class="fa fa-check" ></i>';
    $iconSt[1] = '<i class="fa fa-warning" ></i>';
    $iconSt[2] = '<i class="fa fa-clock-o" ></i>';
    $iconSt[3] = '<i class="fa fa-times" ></i>';
    $iconSt[4] = '<i class="fa fa-check-circle-o" ></i>';

    $stateUrl = "ajax.php?c={$process->processUrl}.changeStateCrud&process_id={$process->processId}"
      ."&vid={$process->entity}&cntrl={$params->inputId}&reload=true"
      ."&objid={$process->activStatus}&dkey={$process->entity->getTable()}&state=";

    $codeStatus = <<<HTML
      <div
        class="right"
      ><button
        class="wcm wcm_control_dropmenu  pstate wgt-button"
        id="wgt-process-{$process->name}-{$process->entity}-drop-cntrl"
        data-drop-box="wgt-process-{$process->name}-{$process->entity}-dropbox" >{$iconPStL[$process->state]}</button>
        <var
          id="wgt-process-{$process->name}-{$process->entity}-drop-cntrl-cfg-dropmenu"
        >{"align":"right","closeScroll":"true"}</var>
      </div>

      <div
        class="wgt-dropdownbox al_right"
        id="wgt-process-{$process->name}-{$process->entity}-dropbox"  >
        <ul>
          <li><a
            onclick="\$S('#wgt-process-{$process->name}-{$params->contextKey}').data('paction-stateChange-{$process->name}')(0);"   >
            {$iconSt[0]} Running
          </a></li>
          <li><a
            onclick="\$S('#wgt-process-{$process->name}-{$params->contextKey}').data('paction-stateChange-{$process->name}')(1);"   >
            {$iconSt[1]} Pause
          </a></li>
          <li><a
            onclick="\$S('#wgt-process-{$process->name}-{$params->contextKey}').data('paction-stateChange-{$process->name}')(2);"   >
            {$iconSt[2]} Pause
          </a></li>
          <li><a
            onclick="\$S('#wgt-process-{$process->name}-{$params->contextKey}').data('paction-stateChange-{$process->name}')(3);"   >
            {$iconSt[3]} Aborted
          </a></li>
          <li><a
            onclick="\$S('#wgt-process-{$process->name}-{$params->contextKey}').data('paction-stateChange-{$process->name}')(4);"   >
            {$iconSt[4]} Completed
          </a></li>
        </ul>
      </div>
HTML;

    return $codeStatus;

  }//end protected function renderStatusDropdown */

  /**
   *
   * @param Process $process
   * @return string
   */
  protected function renderStates($process)
  {

    $states = $process->getActiveStates();

    $codeStates = '';
    if ($states) {
      foreach ($states as $stateKey => $state) {

        $checked = '';
        if (isset($this->process->statesData->{$stateKey}) && $this->process->statesData->{$stateKey}) {
          $checked = " checked=\"checked\" ";
        } else {
          $checked = "";
        }

        $codeStates .= <<<HTML
      <div>
        <input
          name="state[{$stateKey}]" {$checked}
          type="checkbox"
          class="asgd-{$this->formId}-states" /> <label>{$state['label']}</label>
      </div>

HTML;
      }

      $codeStates .= <<<HTML

<div class="do-clear small" ></div>
<div>
  <button
    class="wgt-button"
    onclick="\$R.form('{$this->formId}-states');" ><i class="fa fa-save" ></i> Save states</button>
</div>

HTML;

    } else {
      $codeStates .= <<<HTML

<p>There are no checks defined for this process step.</p>

HTML;
    }

    return $codeStates;

  }//end protected function renderStates */

  /**
   *
   * @param Process $process
   * @return string
   */
  protected function renderSlides($process)
  {

    $slides = $process->getActiveSlices();
    $slidesHtml = '';

    if ($slides) {
      $slidesHtml .= '<div class="slides" >'.NL;

      foreach ($slides as /* @var $slide WgtProcessFormSlice */ $slide) {
        $slRenderer = $slide->getRenderer();
        $slidesHtml .= $slRenderer->render($this, $slide);
      }

      $slidesHtml .= '</div>'.NL;
    }

    return $slidesHtml;

  }//end protected function renderSlides */

}//end class WgtProcessForm

