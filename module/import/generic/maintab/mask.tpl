<?php 
    // get in gateway und liefert die Variable aus Gateway: lists/import/importable_tables.php
    $confLoader = new LibConfLoader();
    $importTables = $confLoader->load('lists/import/importable_tables.php');
    
    $form = new WgtFormBuilder(
        $this, 
        'ajax.php?c=Import.Generic.upload', 
        'import-generic'
    );
    
    $form->form();
?>

<div class="box-form-content s-width-6 align-left" style="width:750px" >
    <?php $form->startDecoration(); ?>
    <select class="wcm wcm_widget_selectbox" >
        <option value="" ></option>
        <?php foreach($importTables as $impTable){ ?>
            <option value="<?php echo $impTable ?>" ><?php echo $impTable ?></option>
        <?php } ?>
    </select>
    <?php $form->decorateBuffer('Datasources', 'data-source') ?>

    <?php $form->upload('Import File', 'file'); ?>
    
    <?php $form->selectboxByKey('Num Entries', 'num_entries', 'Simple', $data); ?>

</div>

<div class="box-form-content s-width-6 align-inline has-clearfix" style="width:750px" >
    <?php $form->input('New Name', 'new_name'); ?>
    <?php $form->textarea('Static Values', 'static_values'); ?>
</div>

<div class="do-clear" > </div>

<div id="wgt-box-generic-import-table" >Table goes here</div>


    
