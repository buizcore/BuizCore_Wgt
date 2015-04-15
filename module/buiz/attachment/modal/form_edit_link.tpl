<?php

$uplForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Buiz.Attachment.saveLink'.$VAR->preUrl.'&amp;attachid='.$VAR->attachmentId.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-edit-link',
  'put'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'BuizFileType_Selectbox' );
$typeData->fetchSelectbox( $VAR->typeFilter );

/*
$storageData = $uplForm->loadQuery( 'BuizAttachmentFileStorage_Selectbox' );
$storageData->fetchSelectbox( $VAR->refId );
*/

$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$simpleTabDesc = new WgtSimpleTabContainer($this,'wbf-attachment-edit-link-type');
$simpleTabDesc->data = $typeData->getAll();

?>

<section class="wgt-content_box form single" style="min-width:600px;width:600px;" >
  <header style="min-width:600px;width:600px;margin:0px;" >
    <h2>Edit Link</h2>
  </header>
  <div class="content single" style="min-width:600px;width:600px;" >
    <fieldset>
    
      <div class="left n-cols-2 single">


  <?php $uplForm->hidden
    (
    	'objid',
     $VAR->link->getId()
    ); ?>


          <?php $uplForm->input
          (
          	'Link',
          	'link',
           $VAR->link->link,
           [],
           array( 'size' => 'xlarge' )
           ); ?>


           <?php $uplForm->selectboxByKey
          (
          	'Type',
          	'id_type',
          	'BuizFileType_Selectbox',
           $typeData->getAll(),
           $VAR->link->id_type,
          		array('class'=>'wcm wcm_ui_selection_tab','data-tab-body'=>'wbf-attachment-edit-link-type')
          ); ?>
        	<?php echo $simpleTabDesc->render() ?>

          
          <?php /* $uplForm->selectboxByKey
          (
          	 'Storage ',
          	 'id_storage',
          	 'BuizFileStorage_Selectbox',
            $storageData->getAll(),
            $VAR->link->id_storage
          ); */ ?>

          <?php $uplForm->selectboxByKey
          (
              'Confidentiality Level',
              'id_confidentiality',
              'BuizConfidentialityLevel_Selectbox',
              $confidentialData->getAll(),
              $VAR->link->id_confidentiality
          ); ?>


<?php $uplForm->textarea
          (
          	 'Description',
          	 'description',
            $VAR->link->description  ,
            [],array( 'size' => 'xlarge' )
          ); ?>

          <?php $uplForm->submit( 'Save Link', '$S.modal.close();' ); ?>

          
        </fieldset>
    
    </div>

</section>