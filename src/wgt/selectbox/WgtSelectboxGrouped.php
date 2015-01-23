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
 * @lang de
 *
 * Basisklasse für Selectboxen
 *
 * @package net.buizcore.wgt
 */
class WgtSelectboxGrouped extends WgtSelectbox
{
    /*
     * ////////////////////////////////////////////////////////////////////////////// // Attributes //////////////////////////////////////////////////////////////////////////////
     */
    
    /**
     * should their be a first "empty/message" entry in the selectbox
     *
     * @var string
     */
    public $groupedField = 'id_parent';

    /**
     *
     * @return string
     */
    public function element($attributes = array())
    {
        if (! $this->renderInput) {
            return '<span> '.$this->activeValue.'</span>';
        }
        
        if ($attributes) {
            $this->attributes = array_merge($this->attributes, $attributes);
        }
        
        if ($this->redirect) {
            if (! isset($this->attributes['id'])) {
                Error::addError('got no id to redirect');
            } else {
                $id = $this->attributes['id'];
                $url = $this->redirect;
                
                $this->attributes['onChange'] = "\$R.selectboxRedirect('#".$this->attributes['id']."', '{$url}')";
            }
        }
        
        if (isset($this->attributes['size'])) {
            if (isset($this->attributes['class'])) {
                $this->attributes['class'] .= ' multi';
            } else {
                $this->attributes['class'] = 'multi';
            }
        }
        
        $codeOptions = '';
        
        $errorMissingActive = 'The previous selected dataset not exists anymore. Select a new entry to fix that issue!';
        
        
        if ($this->data) {
            

            $groupedData = array();
            
            foreach ($this->data as $data) {
            
                if(!$data[$this->groupedField]){
                    $groupedData[0][] = $data;
                } else {
                    $groupedData[$data[$this->groupedField]][] = $data;
                }
            }

            $subRenderer = null;
            $subRenderer = function($id, $label, $groupedData, $active, $subRenderer, $renderer){
                
                
                if (!$id) {
                    return '';
                }
                
                if (!isset($groupedData[$id])) {
                    return '';
                }
                
                $code = '<optgroup label="'.addslashes($label).'" >';
                
                foreach($groupedData[$id] as $dataNode){
                    
                    if ($active == $dataNode['id']) {
                        $code .= '<option selected="selected" value="'.$dataNode['id'].'" >'.$dataNode['value'].'</option>'.NL;
                        $renderer->activeValue = $value;
                    } else {
                        $code .= '<option value="'.$dataNode['id'].'" >'.$dataNode['value'].'</option>'.NL;
                    }
                    
                    $code .= $subRenderer($dataNode['id'], $dataNode['value'], $groupedData, $active, $subRenderer, $renderer);
                }
                
                $code .= '</optgroup>';
                
                return $code;
            };

            foreach ($groupedData[0] as $data) {
                
                $value = $data['value'];
                $id = $data['id'];
                $key = isset($data['key']) ? ' key="'.trim($data['key']).'" ' : '';
                
                if ($this->activ == $id) {
                    $codeOptions .= '<option selected="selected" value="'.$id.'" '.$key.' >'.$value.'</option>'.NL;
                    $this->activeValue = $value;
                } else {
                    $codeOptions .= '<option value="'.$id.'" '.$key.' >'.$value.'</option>'.NL;
                }
                
                $codeOptions .= $subRenderer($data['id'], $data['value'], $groupedData, $this->activ, $subRenderer, $this);
            }
            
            if (! is_null($this->activ) && is_null($this->activeValue)) {
                
                if ($this->loadActive) {
                    
                    $cl = $this->loadActive;
                    
                    $activeData = $cl($this->activ);
                    
                    if ($activeData) {
                        $codeOptions = '<option selected="selected" class="inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
                        $this->activeValue = $activeData['value'];
                    } else {
                        $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
                        $this->activeValue = '**Invalid target**';
                        
                        $this->attributes['title'] = $errorMissingActive;
                    }
                } else {
                    $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
                    $this->activeValue = '**Invalid target**';
                    
                    $this->attributes['title'] = $errorMissingActive;
                }
            }
     
        } else {
            
            if (! is_null($this->activ) && is_null($this->activeValue)) {
                
                if ($this->loadActive) {
                    
                    $cl = $this->loadActive;
                    $activeData = $cl($this->activ);
                    
                    if ($activeData) {
                        $codeOptions = '<option selected="selected" class="inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
                        $this->activeValue = $activeData['value'];
                    } else {
                        $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
                        $this->activeValue = '**Invalid target**';
                        
                        $this->attributes['title'] = $errorMissingActive;
                    }
                } else {
                    $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
                    $this->activeValue = '**Invalid target**';
                    
                    $this->attributes['title'] = $errorMissingActive;
                }
            }
        }
        
        $attributes = $this->asmAttributes();
        
        $placeHolder = '';
        if (! is_null($this->firstFree))
            $placeHolder = ' data-placeholder="'.$this->firstFree.'"  placeholder="'.$this->firstFree.'" ';
        
        $select = '<select '.$attributes.' '.$placeHolder.' >'.NL;
        
        if (! is_null($this->firstFree))
            $select .= '<option>&nbsp;</option>'.NL;
        
        $select .= $codeOptions;
        
        if ($this->firstFree && ! $this->activeValue)
            $this->activeValue = $this->firstFree;
        
        $select .= '</select>'.NL;
        
        return $select;
    
    } // end public function element */
    
}//end class WgtSelectboxGrouped

