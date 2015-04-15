<?php

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Buiz.Attachment.addLink'.$VAR->preUrl.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-add-link',
  'post'
);
$uplForm->form();

/* @var $typeData BuizFileType_Selectbox_Query */
$typeData = $uplForm->loadQuery( 'BuizFileType_Selectbox' );
$typeData->fetchSelectbox( $VAR->typeFilter );

/*
$storageData = $uplForm->loadQuery( 'BuizAttachmentFileStorage_Selectbox' );
$storageData->fetchSelectbox( $VAR->refId );
*/

$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$simpleTabDesc = new WgtSimpleTabContainer($this,'wbf-attachment-add-link-type');
$simpleTabDesc->data = $typeData->getAll();


?>

<section class="wgt-content_box form single" style="min-width:600px;width:600px;" >
  <header style="min-width:600px;width:600px;margin:0px;" >
    <h2>Add Link</h2>
  </header>
  <div class="content single" style="min-width:600px;width:600px;" >
    <fieldset>
    
      <div class="left n-cols-2 single">

          <?php $uplForm->input( 'Link', 'link', null, [], array( 'size' => 'xlarge' )  ); ?>

          <?php $uplForm->selectboxByKey(
          	 'Type',
          	 'id_type',
          	 'BuizFileType_Selectbox',
             $typeData->getAll(),
          	 null,
          	 array('class'=>'wcm wcm_ui_selection_tab','data-tab-body'=>'wbf-attachment-add-link-type')
          ); ?>
          
          <?php echo $simpleTabDesc->render() ?>
          
          <?php /* $uplForm->selectboxByKey(
      		'Storage',
      		'id_storage',
      		'BuizFileStorage_Selectbox',
            $storageData->getAll()
          ); */ ?>
          
          <?php $uplForm->selectboxByKey(
      		'Confidentiality Level',
      		'id_confidentiality',
      		'BuizConfidentialityLevel_Selectbox',
            $confidentialData->getAll(),
            $orm->getIdByKey( 'BuizConfidentialityLevel', 'restricted' )
          ); ?>

          <?php $uplForm->textarea(
      		'Description',
      		'description',
            null,
            [],
            array( 'size' => 'xlarge' )
          ); ?>

          <?php $uplForm->submit( 'Add Link', '$S.modal.close();' ); ?>

        </fieldset>
    </div>
</section>