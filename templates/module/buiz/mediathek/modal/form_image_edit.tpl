<?php 

$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Buiz.Mediathek_Image.update&amp;media='.$VAR->mediaId.'&amp;element='.$VAR->elementId,
  'wgt-form-mediathek-image-edit',
  'post'
);
$uplForm->form();

$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$licenceData = $uplForm->loadQuery( 'BuizContentLicence_Selectbox' );
$licenceData->fetchSelectbox();

?>


<fieldset>
  <legend>Edit Image</legend>
  
  <?php $uplForm->hidden
    ( 
      'objid', 
     $VAR->image->getId()
    ); ?>
  
  <table style="width:100%;" >
    <tr>
      <td colspan="2" >
        <?php $uplForm->input( 'Title', 'title', $VAR->image->title, [], array( 'size' => 'xlarge' ) ); ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" >
        <?php $uplForm->upload( 'File', 'file', $VAR->image->file, [], array( 'size' => 'large' ) ); ?>
      </td>
    </tr>
    <tr>
      <td valign="top" >
        <?php $uplForm->selectboxByKey
        ( 
        	'Licence', 
        	'licence', 
        	'BuizContentLicence_Selectbox', 
         $licenceData->getAll(),
         $VAR->image->id_licence  
        ); ?>
        
        <?php $uplForm->selectboxByKey
        ( 
        		'Confidentiality Level', 
        		'confidential', 
        		'BuizConfidentialityLevel_Selectbox', 
          $confidentialData->getAll()  ,
           $VAR->image->id_confidentiality  
        ); ?>
      </td>
      <td valign="top" >
      </td>
    </tr>
    <tr>
      <td>
        <?php $uplForm->textarea
        ( 
        	 'Description', 
        	 'description',
          $VAR->image->getSecure('description')
        ); ?>
      </td>
      <td valign="bottom" >
        <?php $uplForm->submit( 'Save Image', '$S.modal.close();' ); ?>
      </td>
    </tr>
  </table>

  
</fieldset>