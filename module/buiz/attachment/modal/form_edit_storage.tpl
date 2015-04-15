<?php

$uplForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Buiz.Attachment.saveStorage'.$VAR->preUrl,
  'wgt-form-wbf-attachment-edit-storage',
  'put'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'BuizFileStorageType_Selectbox' );
$typeData->fetchSelectbox();


$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

?>

<section class="wgt-content_box form single" style="min-width:600px;width:600px;" >
  <header style="min-width:600px;width:600px;margin:0px;" >
    <h2>Edit Storage Location</h2>
  </header>
  <div class="content single" style="min-width:600px;width:600px;" >
    <fieldset>
    
      <div class="left n-cols-2 single">

  <?php $uplForm->hidden('objid', $VAR->storage->getId() ); ?>

          <?php $uplForm->input(
          	'Link',
          	'link',
           $VAR->storage->link,
           [],
           array( 'size' => 'xlarge' )
           ); ?>

           <?php $uplForm->input(
            'Name',
            'name',
             $VAR->storage->name,
             [],
             array( 'required' => true )
          ); ?>

           <?php $uplForm->selectboxByKey(
          	'Type',
          	'id_type',
          	'BuizFileStorageType_Selectbox',
           $typeData->getAll(),
           $VAR->storage->id_type
          ); ?>

          <?php $uplForm->selectboxByKey(
              'Confidentiality Level',
              'id_confidentiality',
              'BuizConfidentialityLevel_Selectbox',
              $confidentialData->getAll(),
              $VAR->storage->id_confidentiality
          ); ?>

          <?php $uplForm->textarea(
          	 'Description',
          	 'description',
            $VAR->storage->description,
            [],array( 'size' => 'xlarge' )
          ); ?>

          <?php $uplForm->submit( 'Save Storage', '$S.modal.close();' ); ?>

        </fieldset>
    
    </div>

</section>