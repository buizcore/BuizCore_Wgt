<?php 

$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Buiz.Mediathek_Document.update&amp;media='.$VAR->mediaId.'&amp;element='.$VAR->elementId,
  'wgt-form-mediathek-document-edit',
  'post'
);
$uplForm->form();

$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$licenceData = $uplForm->loadQuery( 'BuizContentLicence_Selectbox' );
$licenceData->fetchSelectbox();

?>


<fieldset>
  <legend>Edit Document</legend>
  
  <?php $uplForm->hidden
    ( 
      'objid', 
     $VAR->document->getId()
    ); ?>
  
  <table style="width:100%;" >
    <tr>
      <td colspan="2" >
        <?php $uplForm->upload( 'File', 'file', $VAR->document->name, [], array('size'=>'large')  ); ?>
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
          $VAR->document->id_licence  
        ); ?>
        
        <?php $uplForm->selectboxByKey
        ( 
        	 'Confidentiality Level', 
        	 'confidential', 
        	 'BuizConfidentialityLevel_Selectbox', 
          $confidentialData->getAll()  ,
          $VAR->document->id_confidentiality  
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
          $VAR->document->getSecure('description')
        ); ?>
      </td>
      <td valign="bottom" >
        <?php $uplForm->submit( 'Save Document', '$S.modal.close();' ); ?>
      </td>
    </tr>
  </table>

  
</fieldset>