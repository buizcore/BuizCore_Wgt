<?php 

$form = new WgtFormBuilder(
    $this, 
    'ajax.php?c=MaintenanceDbAdmin.query', 
    'maintenance-db-admin', 
    'post', 
    false
);

?>

<div class="wgt-box-form" > 
    <header class="wgt-header-2" ><h2>Data form</h2></header>

    <div class="wgt-box-form-content" >

        <?php echo $form->form(); ?>
        
        <?php echo $form->textarea('Query', 'query',null,['class'=>'large']); ?>
        
        
        <div class="wgt-form-controls" >
            
            <div class="wgt-panel-control" > 
                <?php echo $form->submit('Execute query') ?>
            </div>
        
        </div>
    
    </div>

</div>

<div class="wgt-list-box" > 


</div>