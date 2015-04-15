<?php
$cntForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Business.CustomerImport.import&file='.$VAR->manager->importFile.'&type='.$VAR->manager->importFileType,
  'buiz_user_import',
  'post'
);


$renderBox = function( $nameKey, $mapping ) use($VAR, $cntForm) {
    
    $activeKey = isset($mapping[$nameKey])?$mapping[$nameKey]:null;
    
    $selectbox = '<select name="field['.$nameKey.']" class="'.$cntForm->dKey.'" >';
    
    foreach($VAR->manager->availableStructure as $mainKey => $mainData){
        $selectbox .= '<optgroup label="'.$mainData['label'].'" >';
    
        foreach($mainData['fields'] as $optKey => $optData ){
            
            $checked = '';
            if( $activeKey == $mainKey.'.'.$optKey ){
                $checked = ' selected="selected" ';
            }
            
            $selectbox .= '<option value="'.$mainKey.'.'.$optKey.'" '.$checked.' >'.$optData[0].'</option>';
        }
    
        $selectbox .= '</optgroup>';
    }
    
    $selectbox .= '</select>';
    
    return $selectbox;
    
}



?>

<div id="wgt-box-buiz_user_import" >

    <?php $cntForm->form() ?>
    
    <div class="wgt-panel" >
        <h1>Field Mapper</h1>
    </div>

    <dl class="wgt-field-map" >
        <?php foreach( $VAR->manager->cols as $pos => $col ){ ?>
        <dt><input 
            type="text" 
            name="col[<?php echo $pos ?>]" 
            readonly="readonly" 
            class="<?php echo $cntForm->dKey ?>"
            value="<?php echo $col ?>" />
        </dt>
        <dd><?php echo $renderBox($pos, $VAR->manager->mapping) ?></dd>
        <?php } ?>
    </dl>
    
    <div class="do-clear" > </div>
    
    <div>
        <button class="wgt-button" onclick="$R.form('<?php echo $cntForm->id ?>');" >Import</button>
    </div>

</div>