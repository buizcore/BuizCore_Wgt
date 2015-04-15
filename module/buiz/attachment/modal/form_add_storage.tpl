<?php

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Buiz.Attachment.addStorage'.$VAR->preUrl,
  'wgt-form-wbf-attachment-add-storage',
  'post'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'BuizFileStorageType_Selectbox' );
$typeData->fetchSelectbox();

$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

?>

<section class="wgt-content_box form single" style="min-width:600px;width:600px;" >
  <header style="min-width:600px;width:600px;margin:0px;" >
    <h2>Add Storage</h2>
  </header>
  <div class="content single" style="min-width:600px;width:600px;" >
    <fieldset>
    
      <div class="left n-cols-2 single">

          <?php $uplForm->input
          (
          		'Link',
          		'link',
            null,
            [],
            array('size'=>'xlarge', 'required' => true  )
          ); ?>

          <?php $uplForm->input
            (
            	'Name',
            	'name',
              null,
              [],
              array( 'required' => true )
             ); ?>
          <?php $uplForm->selectboxByKey
          (
          	 'Type',
          	 'id_type',
          	 'BuizFileStorageType_Selectbox',
             $typeData->getAll()
          ); ?>
          <?php $uplForm->selectboxByKey
          (
          		'Confidentiality Level',
          		'id_confidentiality',
          		'BuizConfidentialityLevel_Selectbox',
            $confidentialData->getAll(),
            $orm->getIdByKey( 'BuizConfidentialityLevel', 'restricted' ),
            [],
            array( 'required' => true )
          ); ?>
          <?php $uplForm->textarea
          (
          		'Description',
          		'description',
            null,
            [],
            array( 'size' => 'xlarge' )
          ); ?>

          <?php $uplForm->submit( 'Add Storage', '$S.modal.close();' ); ?>

        </fieldset>
    
    </div>

</section>