<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@buiz.net>
* @date        :
* @copyright   : Buiz Developer Network <contact@buiz.net>
* @project     : Buiz Web Frame Application
* @projectUrl  : http://buiz.net
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
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 * @copyright BuizCore.com <BuizCore.com>
 * @licence BuizCore.com
 */
class BuizCoreAddress_Item extends WgtAbstract
{
    
    /**
     * @var string
     */
    public $label = 'Addresses';
    
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
    public $countries = [];

    /**
     * @var array
     */
    public $types = [];
    
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
        $this->readUrl = "ajax.php?c=Buiz.CoreAddress.read&refid=".$this->refId."&objid=";
    
    if (!$this->saveUrl)
        $this->saveUrl = "ajax.php?c=Buiz.CoreAddress.save&refid=".$this->refId."&objid=";
    
    if (!$this->saveAllUrl)
        $this->saveAllUrl = "ajax.php?c=Buiz.CoreAddress.saveAll&refid=".$this->refId."&objid=";
    
    if (!$this->deleteUrl)
        $this->deleteUrl = "ajax.php?c=Buiz.CoreAddress.delete&refid=".$this->refId."&objid=";
    
    if (!$this->searchUrl)
        $this->searchUrl = "ajax.php?c=Buiz.CoreAddress.search&refid=".$this->refId;
    
    $codeTypes = '<option value="" ></option>';
    foreach($this->types as $type){
        $codeTypes .= '<option value="'.$type['id'].'" >'.$type['value'].'</option>'.NL;
    }
    
    
    $groupedCountries = [];
    $countryGroupLabels = [
        't' => 'Hauptländer',
    	'f' => 'Sonstige'
    ];
    
    foreach ($this->countries as $country) {
        $groupedCountries[$country['cat_key']][] = $country;
    }
    
    $codeCountries = '<option value="" ></option>';
    foreach ($countryGroupLabels as $catKey => $catLabel) {
        $codeCountries .= '<optgroup label="'.$catLabel.'" >'.NL;
        if (isset($groupedCountries[$catKey])) {
            foreach($groupedCountries[$catKey] as $country){
                $codeCountries .= '<option value="'.$country['id'].'" >'.$country['value'].'</option>'.NL;
            }
        }

        $codeCountries .= '</optgroup>'.NL;
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
            <a class="item-act-save-all" ><i class="fa fa-save" ></i> Adressen speichern</a>
        </div>
        <div class="controls right v-control" >
            <a class="item-act-edit-all" ><i class="fa fa-edit" ></i> Adressen bearbeiten</a>
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
                <span>Neue Adresse hinzufügen</span>
              </div>
             </div>
         </section>
HTML;
    }
    
    $codeViewTpl = <<<HTML
    <li id="{$id}-entry-{{rowid}}" data-eid="{{rowid}}" class="entry" >
        <var>{
            "rowid":"{{rowid}}",
            "name":"{{name}}",
            "type":"{{type}}",
            "id_type":"{{id_type}}",
            "street":"{{street}}",
            "street_no":"{{street_no}}",
            "zip":"{{zip}}",
            "city":"{{city}}",
            "country":"{{country}}",
            "id_country":"{{id_country}}",
            "description":"{{description}}"
            }</var>
        <section class="hidden-controls" >
            <div class="wrapper" > 
              <div class="left wgt-label" >
                {{type}}: 
              </div>
              <div class="inline content" style="width:350px;" >
                  {{#if name}}{{name}}<br />{{/if}} 
                  {{street}}, {{street_no}}<br />
                  {{zip}} {{city}}<br />
                  {{country}}
                  {{#if description}}<p>{{description}}</p>{{/if}}
              </div>
              {$codeEntryControls}
              <div class="do-clear" > </div>
            </div>
        </section>
    </li>
HTML;
              

    
    
    $html = <<<HTML

      <div 
        id="{$id}" 
        class="wcm wcm_widget_edit_list widget wid-ced_list view-mode" >

          <var id="{$id}-params" >{
              "read_url": "{$this->readUrl}",
              "save_url": "{$this->saveUrl}",
              "save_all_url": "{$this->saveAllUrl}",
              "delete_url": "{$this->deleteUrl}",
              "search_url": "{$this->searchUrl}",
              "read_only": {$flagReadOnly},
              "initLoad": true
           }</var>

        <h3 class="wgt-header-l-3" >
           Adressen
           {$codeControls}
        </h3>

        <div class="do-clear tiny" > </div>
        <ul class="root" >
        </ul>
        <div class="do-clear tiny" > </div>
        {$codeNewEntry}
       
        <script id="{$id}-view-tpl" type="text/x-handlebars-template" >
            {$codeViewTpl}
        </script>
        
        <script id="{$id}-list-tpl" type="text/x-handlebars-template" >
            {{#each entries}}
                {$codeViewTpl}
            {{/each}}
        </script>
        
        <script id="{$id}-edit-tpl" type="text/x-handlebars-template" >
            <li id="{$id}-entry-{{rowid}}-edit" data-eid="{{rowid}}" class="entry edit" >
            
                <section class="hidden-controls" >
                    <div class="wrapper" > 
                      <div class="left block" style="width:190px;padding-right:10px;" >
                        <select 
                            class="wcm wcm_widget_selectbox"
                            name="address[{{rowid}}][id_type]"
                            data-label-key="type" 
                            data-key="id_type" 
                            style="width:180px;"
                            data-active="{{id_type}}" >
                            {$codeTypes}
                        </select>
                      </div>
                      <div class="inline content" style="width:400px;" >
                          <div class="block" >
                                <input 
                                    placeholder="Name Empfänger (wenn abweichend)" 
                                    value="{{name}}" 
                                    name="address[{{rowid}}][name]"  
                                    data-key="name" />
                            </div>
                            <div class="block" >
                                <input placeholder="Strasse" value="{{street}}" class="wcm wcm_valid_required inp-3-4" data-key="street"  name="address[{{rowid}}][street]" />
                                <input placeholder="Nummer" value="{{street_no}}" class="inp-1-4" data-key="street_no"  name="address[{{rowid}}][street_no]" />
                            </div>
                            <div class="block" >
                                <input placeholder="Plz" value="{{zip}}" class="inp-1-3" data-key="zip"  name="address[{{rowid}}][zip]" />
                                <input placeholder="Stadt" value="{{city}}" class="wcm wcm_valid_required inp-2-3" data-key="city"  name="address[{{rowid}}][city]" />
                            </div>
                            <div class="block" >
                                <select 
                                    class="wcm wcm_widget_selectbox v-country"   
                                    name="address[{{rowid}}][id_country]" 
                                    data-label-key="country" 
                                    data-key="id_country" 
                                    data-active="{{id_country}}"
                                    placeholder="Bitte Land auswählen" >
                                    {$codeCountries}
                                </select>
                            </div>
                            <div class="block textarea" >
                                <textarea 
                                    placeholder="Kommentar" 
                                    data-key="description" 
                                    name="address[{{rowid}}][description]" >{{description}}</textarea><br />
                                <dfn>Einfacher Kommentar, wird nicht in der Adresse angezeigt</dfn>
                            </div>
                      </div>
                      <div class="block right" >
                          <a class="item-act-remove" ><i class="fa fa-times" ></i> Entfernen</a>
                      </div>
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
    */
    public function renderViewSave()
    { 
        return "$('#{$this->getId()}').editList('saveAll');".NL;
    }//end public function renderViewSave */


} // end class BuizCoreAddress_Item

