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
 * Item zum generieren einer Linkliste
 * @package net.buizcore.wgt
 */
class WgtElementContactItemList extends WgtAbstract
{
    
    /**
     * @var string
     */
    public $label = null;
   
    /**
     * @var string
     */
    public $readUrl = null;

    /**
     * @var string
     */
    public $saveUrl = null;

    /**
     * @var string
     */
    public $saveAllUrl = null;

    /**
     * @var string
     */
    public $deleteUrl = null;

    /**
     * @var string
     */
    public $searchUrl = null;

    /**
     * @var array
     */
    public $types = array();
    
    /**
     * @var array
     */
    public $refId = null;
  

   /**
    * @return string
    */
    public function render($params = null)
    {

        $id = $this->getId();
        
        
        if (!$this->readUrl)
            $this->readUrl = "ajax.php?c=Buiz.ContactData.read&refid=".$this->refId."&objid=";
        
        if (!$this->saveUrl)
            $this->saveUrl = "ajax.php?c=Buiz.ContactData.save&refid=".$this->refId."&objid=";
        
        if (!$this->saveAllUrl)
            $this->saveAllUrl = "ajax.php?c=Buiz.ContactData.saveAll&refid=".$this->refId;
        
        if (!$this->deleteUrl)
            $this->deleteUrl = "ajax.php?c=Buiz.ContactData.delete&refid=".$this->refId."&objid=";
        
        if (!$this->searchUrl)
            $this->searchUrl = "ajax.php?c=Buiz.ContactData.search&refid=".$this->refId;
        
        $codeTypes = '<option value="" ></option>';
        foreach($this->types as $type){
            $codeTypes .= '<option value="'.$type['id'].'" >'.$type['value'].'</option>'.NL;
        }
        
        $flagReadOnly = 'false';
        if($this->readOnly){
            $flagReadOnly = 'true';
        }
        
        
        $codeControls = '';
        $codeEntryControls = '';
        $codeNewEntry = '';
    
        if (!$this->readOnly) {
          
            $codeControls = <<<HTML
        <div class="controls right e-control" >
            <a class="item-act-save-all" ><i class="fa fa-save" ></i> Kontakt speichern</a>
        </div>
        <div class="controls right v-control" >
            <a class="item-act-edit-all" ><i class="fa fa-edit" ></i> Kontakt bearbeiten</a>
        </div>
HTML;
        
            $codeEntryControls = <<<HTML
      <div class="right controls" style="width:120px;"  >
          <div>
              <a class="item-act-remove" ><i class="fa fa-times" ></i> Entfernen</a>
          </div>
      </div>
HTML;
        
            $codeNewEntry = <<<HTML

        <section id="{$id}-entry-create" class="c-entry edit controls e-control" >
            <div class="do-clear" > </div>
            <div class="wrapper" >
              <div class="left block" style="width:180px;padding-right:10px;" >
                <select
                    class="wcm wcm_widget_selectbox ign"
                    id="{$id}-select-create"
                    style="width:170px;" >
                    {$codeTypes}
                </select>
                <span>Neuen Eintrag hinzufügen</span>
              </div>
             </div>
         </section>
HTML;
                
        }
        
        
        $html = <<<HTML

      <div 
        id="{$id}" 
        class="wcm wcm_widget_edit_list widget wid-ced_list single-line view-mode" >

          <var id="{$id}-params" >{
              "read_url": "{$this->readUrl}",
              "save_url": "{$this->saveUrl}",
              "save_all_url": "{$this->saveAllUrl}",
              "delete_url": "{$this->deleteUrl}",
              "search_url": "{$this->searchUrl}",
              "read_only": {$flagReadOnly},
              "initLoad": true
           }</var>
           
        <h3 class="wgt-header-l-3" >Kontaktdaten {$codeControls}</h3>
        <div class="do-clear tiny" > </div>
        <ul class="root" ></ul>
        <div class="do-clear tiny" > </div>
        {$codeNewEntry}
       
        <script id="{$id}-view-tpl" type="text/x-handlebars-template" >
            <li id="{$id}-entry-{{rowid}}" data-eid="{{rowid}}" class="entry" >
                <var>{
                    "rowid":"{{rowid}}",
                    "flag_private":"{{flag_private}}",
                    "address_value":"{{address_value}}",
                    "type":"{{type}}",
                    "id_type":"{{id_type}}"
                }</var>
                <section class="hidden-controls" >
                    <div>
                      <div class="left wgt-label" >{{type}}: </div>
                      <div class="inline content" ><span>{{address_value}}</span>
                          {$codeEntryControls}
                      </div>
                      <div class="do-clear" > </div>
                    </div>
                </section>
            </li>
        </script>
        
        <script id="{$id}-list-tpl" type="text/x-handlebars-template" >
            {{#each entries}}
            <li id="{$id}-entry-{{rowid}}" data-eid="{{rowid}}" class="entry" >
                <var>{
                    "rowid":"{{rowid}}",
                    "flag_private":"{{flag_private}}",
                    "address_value":"{{address_value}}",
                    "type":"{{type}}",
                    "id_type":"{{id_type}}"
                }</var>
                <section class="hidden-controls" >
                    <div>
                      <div class="left wgt-label" >{{type}}: </div>
                      <div class="inline content" ><span>{{address_value}}</span>
                          {$codeEntryControls}
                      </div>
                      <div class="do-clear" > </div>
                    </div>
                </section>
            </li>
            {{/each}}
        </script>
        
        
        <script id="{$id}-edit-tpl" type="text/x-handlebars-template" >
            <li id="{$id}-entry-{{rowid}}-edit" data-eid="{{rowid}}" class="entry edit" >
            
                <section>
                    <div class="block" >
                    
                        <div class="left" style="width:155px;" >
                        <select 
                            class="wcm wcm_widget_selectbox"
                            name="cdata[{{rowid}}][id_type]"
                            style="width:150px;"
                            data-label-key="type" 
                            data-key="id_type" 
                            data-active="{{id_type}}" >
                            {$codeTypes}
                        </select>
                        </div>   
                        <div 
                            class="radio-group inline" 
                            style="width:150px; text-align:center;" >
                            <span class="check" ><input type="radio" value="on" name="cdata[{{rowid}}][flag_private]" data-key="flag_private" {{#if flag_private}}checked="checked"{{/if}}  /> Private</span>
                            <span class="check" ><input type="radio" value="" name="cdata[{{rowid}}][flag_private]" data-key="flag_private" {{#unless flag_private}}checked="checked"{{/unless}}  /> Corp</span>
                        </div>
                              
                        <div class="inline" style="width:285px;" >
                            <input 
                                placeholder="Value" 
                                style="width:280px;"
                                value="{{address_value}}" 
                                name="cdata[{{rowid}}][address_value]"  
                                data-key="address_value" />
                        </div>
                        {$codeEntryControls}
                        <div class="do-clear" > </div>
                   </div>      
        
     
                </section>
            </li>
        </script>
      </div>
HTML;

        return $html;
    
    } // end public function render */
  
    /**
     * 
     * @return string
     */
    public function renderViewSave()
    {
        return "$('#{$this->getId()}').editList('saveAll');".NL;
    }//end public function renderViewSave */

} // end class WgtElementContactItemList

