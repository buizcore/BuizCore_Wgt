<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Buiz.Maintenance_Process.changeStatus',
  'wgt-form-wbf-process-stat-changer',
  'put'
);
$uplForm->form();


$nodeData = $uplForm->loadQuery( 'BuizMaintenance_ProcessNode_Selectbox' );
$nodeData->fetchSelectbox( $this->model->process );


?>

<div class="wgt-panel" >
    <h2><?php echo $I18N->l('Process','wbf.label'); ?>: <?php echo $this->model->process->name ?></h2>
</div>

    <div class="wgt-box info" >
      Here you can change/correct the Status of the Process to every process status.<br />
      This mask can overwrite the process internal edges.<br />
      Using this mask <strong>none</strong> of the constraints will be checked and <strong>none</strong> of the actions will be triggert.<br />
      This is a maintenance feature. <strong>Do NOT use</strong>  this mask for your daily work.
    </div>

<fieldset>
  

    
    <?php $uplForm->hidden( 'id_status', $this->model->processStatus->getId() ); ?>
    <?php $uplForm->hidden( 'dkey', $this->model->domainNode->domainName ); ?>
  
    <div class="wgt-layout-grid" >
      <div>
        <div>
          <?php $uplForm->decorateInput( 
            $this->model->domainNode->label, 
            'dataset', 
            "<strong>".$this->model->entity->text()."</strong>",
            array( "size"=> "big" )
          ); ?>
        </div>
      </div>
      <div>
        <div>
          <?php $uplForm->decorateInput( 'Actual Status', 'status', "<strong>".$this->model->processNode->label."</strong>" ); ?>
        </div>
      </div>
      <div>
        <div >
          <?php $uplForm->selectboxByKey( 'Change To', 'id_new', 'WgtSelectbox', $nodeData->getAll()  ); ?>
          <?php $uplForm->textarea( 'Change Comment', 'comment', null, [], array( 'size' => 'xlarge_nl' ) ); ?>
        </div>
      </div>
      <div style="margin-top:20px;" >
        <div align="right" >
          <?php $uplForm->submit( 'Change Status', '$S.modal.close();' ); ?>
        </div>
      </div>
    </div>

</fieldset>