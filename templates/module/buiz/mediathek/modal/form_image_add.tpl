<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Buiz.Mediathek_Image.insert&amp;media='.$VAR->mediaId.'&amp;element='.$VAR->elementKey,
  'wgt-form-mediathek-image-add',
  'post'
);
$uplForm->form();


$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$licenceData = $uplForm->loadQuery( 'BuizContentLicence_Selectbox' );
$licenceData->fetchSelectbox();

?>

<fieldset>
  <legend>Upload File</legend>
  
  <table style="width:100%;" >
    <tr>
      <td colspan="2" ><?php $uplForm->input( 'Title', 'title', null,[], array( 'size' => 'xlarge' ) ); ?></td>
    </tr>
    <tr>
      <td colspan="2" ><?php $uplForm->upload( 'File', 'file', null,[], array( 'size' => 'large' ) ); ?></td>
    </tr>
    <tr>
      <td valign="top" >
        <?php $uplForm->selectboxByKey
        ( 
            'Licence', 
            'licence', 
            'BuizContentLicence_Selectbox', 
            $licenceData->getAll()  
        ); ?>
        <?php $uplForm->selectboxByKey
        ( 
        		'Confidentiality Level', 
        		'confidential', 
        		'BuizConfidentialityLevel_Selectbox', 
          $confidentialData->getAll(),
          $orm->getIdByKey( 'BuizConfidentialityLevel', 'public' )   
        ); ?>
      </td>
      <td valign="top" >
      </td>
    </tr>
    <tr>
      <td>
        <?php $uplForm->textarea( 'Description', 'description' ); ?>
      </td>
      <td valign="bottom" >
        <?php $uplForm->submit( 'Add Image', '$S.modal.close();' ); ?>
      </td>
    </tr>
  </table>

  
</fieldset>