<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : Conias
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
class ImportGeneric_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/
    
    /**
    * @param ImportGeneric_Upload_Request $userRqt
    */
    public function displayUpload($userRqt)
    {
    
        $ajaxArea = new WgtAjaxArea();
        $ajaxArea->selector = '#wgt-box-generic-import-table';
        $ajaxArea->action = 'html';
        
        $tableBuilder = new WgtTableBuilder();

        
        $fileReader = new LibFilereaderCsv(
            PATH_ROOT.'/BuizCore_CSV_Data/data/social/population/cia-population-2014.txt'
        );
        
        $data = $fileReader->getFull("\015","\011");
        
        $importData = new ImportGeneric_GeoRegionPopulation_Importer();
        
        /*
        var_dump($data);
        die();
        */

        $tableBuilder->cols = current($data);
        
        $tableBuilder->cbHead = function($tableBuilder) use ($importData) {
            
            $select = '<select class="wcm wcm_widget_selectbox" >';
            $select .='<option value="" >Ignore</option>'.NL;
            foreach ($importData->fields as $label => $subFields) {
                
                $select .= '<optgroup label="'.$label.'" >'.NL;
                foreach ($subFields as $key => $subField) {
                    $select .='<option value="'.$key.'" >'.$subField.'</option>'.NL;
                }
                $select .='</optgroup>'.NL;
            }
            $select .= '</select>';
         
            // Creating the Head
            $head = '<thead class="wgt-table-head" >'.NL;
            $head .= '<tr>'.NL;
            
            foreach ($tableBuilder->cols as $colName)
                $head .= '<th>'.$colName.'</th>'.NL;
            
            $head .= '<th style="width:70px;">'.$this->i18n->l('nav', 'wbf.text.tableNav'  ).'</th>'.NL;
            
            $head .= '</tr>'.NL;
            $head .= '<tr>'.NL;
            
            foreach ($tableBuilder->cols as $colName) {
                $head .= '<th>'.$select.'</th>'.NL;
            }
            
            $head .= '<th style="width:70px;">&nbsp;</th>'.NL;
            
            $head .= '</tr>'.NL;
            $head .= '</thead>'.NL;
            //\ Creating the Head
            return $head;
            
        };
        
        $tableBuilder->setData($data);
        
        $content = $tableBuilder->build();
        
        $ajaxArea->setContent($content);
        
        
        $this->setArea('import-list', $ajaxArea);
    
    }//end public function displayUpload */

    

}//end class ImportGeneric_Ajax_View

