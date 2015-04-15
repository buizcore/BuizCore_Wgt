<?php

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Buiz.Attachment.uploadFile'.$VAR->preUrl.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-add-file',
  'post'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'BuizFileType_Selectbox' );
$typeData->fetchSelectbox( $VAR->typeFilter );

$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$simpleTabDesc = new WgtSimpleTabContainer($this,'wbf-attachment-add-file-type');
$simpleTabDesc->data = $typeData->getAll();

?>

<section class="wgt-content_box form single" style="min-width:600px;width:600px;" >
  <header style="min-width:600px;width:600px;margin:0px;" >
    <h2>Upload File</h2>
  </header>
  <div class="content single" style="min-width:600px;width:600px;" >
    <fieldset>
    
      <div class="left n-cols-2 single">

    <?php $uplForm->upload( 'File', 'file' ); ?></td>

        <?php $uplForm->selectboxByKey(
          'Type',
          'type',
          'BuizFileType_Selectbox',
          $typeData->getAll(),
          null,
          array('class'=>'wcm wcm_ui_selection_tab','data-tab-body'=>'wbf-attachment-add-file-type')
        ); ?>
         <?php echo $simpleTabDesc->render() ?>
        
        <?php $uplForm->selectboxByKey(
          'Confidentiality Level',
          'id_confidentiality',
          'BuizConfidentialityLevel_Selectbox',
          $confidentialData->getAll(),
          $orm->getIdByKey( 'BuizConfidentialityLevel', 'restricted' )
        ); ?>


        <?php $uplForm->textarea( 'Description', 'description', null, [], array( 'size' => 'xlarge' ) ); ?>

        <?php $uplForm->submit( 'Upload', '$S.modal.close();' ); ?>

        
        </fieldset>
    </div>
</section>