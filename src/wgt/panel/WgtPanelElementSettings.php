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
 * Form Class
 *
 * @package net.buizcore.wgt
 */
class WgtPanelElementSettings extends WgtPanelElement
{
/* //////////////////////////////////////////////////////////////////////////// */
// public interface attributes
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     * die id des formulars an welches die Prozessdaten gehängt werden
     * 
     * @var string
     */
    public $formId = null;

    /**
     * Sind die Settings editierbar?
     * 
     * @var string
     */
    public $readOnly = false;

    /**
     * Die Settings Felder
     * 
     * @var string
     */
    public $fields = array();

    /**
     *
     * @var Model
     */
    public $model = null;

    /**
     *
     * @var [Entity]
     */
    public $entities = array();
    
/* //////////////////////////////////////////////////////////////////////////// */
// public interface attributes
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     * default constructor
     *
     * @param array $entities            
     * @param array $fields            
     * @param LibTemplate $view            
     */
    public function __construct($model, $view)
    {

        $this->env = BuizCore::$env;
        $this->model = $model;
        $this->view = $view;
        $this->init();
    
    } // end public function __construct */

    /**
     *
     * @param string $formId            
     * @param TFlag $params            
     * @return string
     */
    public function render($params = null)
    {

        $i18n = $this->getI18n();
        
        $codeReadonly = '';
        if ($this->readOnly) {
            $codeReadonly = ' readonly="readonly" ';
        }
        
        $html = <<<HTML

    <button
        class="wcm wcm_ui_dropform wcm_ui_tip-top wgt-button"
        id="{$this->id}-settings"
        title="{$i18n->l('Click to edit the Settings','wbf.label')}"
      ><i class="fa fa-cog" ></i><var>{"size":"big"}</var></button><div class="{$this->id}-settings hidden" >
      <div class="wgt-space" >
      <h2>Settings</h2>
      <ul>
HTML;
        
        foreach ($this->fields as $nameKey => $field) {
            
            $html .= '<li><input type="checkbox" '
                .$codeReadonly.' name="'.$nameKey.'" '.Wgt::asmAttributes($field[1]).' '
                .$this->entities[$field[1]['wgt_acc_src']]->getChecked($field[1]['wgt_acc_attr'])
                .'  />&nbsp;&nbsp;<label for="'.$field[1]['id'].'" >'.$field[0].'</label></li>'.NL;
        }
        
        $html .= <<<HTML
      </ul>
      </div>
    </div>
HTML;
        
        return $html;
    
    } // end public function render */

}//end class WgtPanelElementSettings

