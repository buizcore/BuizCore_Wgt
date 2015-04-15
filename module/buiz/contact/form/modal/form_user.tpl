<?php

// sicher stellen, dass die benötigten Resourcen vorhanden sind
$orm = $this->getOrm();
$user = $this->getUser();

$cntForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Buiz.ContactForm.sendUserMessage'
    .'&amp;ref_id='.$VAR->refId
    .'&amp;user_id='.$VAR->userId
    .'&amp;d_src='.$VAR->dataSrc
    .'&amp;element='.$VAR->elementKey,
  'wgt-form-wbf-contact_form-group',
  'post'
);
$cntForm->form();


$confidentialData = $cntForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$itemType = $cntForm->loadQuery( 'BuizContactItemType_Checklist' );
$itemType->fetch();



$defTextMsg = <<<HTML

<label>Subject</label>

<p>
Best regards<br />
{$user->getFullName()}
</p>


HTML;


?>

<section class="wgt-content_box form" style="width:725px;" >


<fieldset>
  <legend>Message</legend>

    <table style="width:100%" >
      <tr>
        <td colspan="2" >
          <?php $cntForm->input(
          	 'Subject',
          	 'subject',
            'Hi '.$VAR->userData['firstname'],
            [],
            array(
            	 'size'=>'xxlarge'
            )
          ); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" >
          <?php $cntForm->input(
          	'Receiver',
          	'receiver',
            $VAR->userData['user_name'].' <'.$VAR->userData['lastname'].', '.$VAR->userData['firstname'].'>',
            array('readonly'=>'readonly'),
            array('size'=>'xxlarge',)
          ); ?>
        </td>
      </tr>
      <tr>
        <td valign="top" >
        <?php $cntForm->multiSelectByKey
        (
          'Channels',
          'channels[]',
          'BuizContactItemType_Checklist',
          $itemType->getAll(),
          array('mail','message')
        ); ?>
        </td>
        <td valign="top" >
        <?php  $cntForm->selectboxByKey
        (
          'Confidentiality Level',
          'id_confidentiality',
          'BuizConfidentialityLevel_Selectbox',
          $confidentialData->getAll(),
          $orm->getIdByKey( 'BuizConfidentialityLevel', 'public' )
        ); ?>

        <?php  $cntForm->ratingbar(
          'Importance',
          'importance',
          2,
          array
          (
            1 => 'Low',
            2 => 'Medium',
            3 => 'High',
          ),
          [],
          array( 'starParts' => 1 )
        ); ?>
        </td>
      </td>
      <tr>
        <td colspan="2" >
          <?php $cntForm->wysiwyg( 'Message', 'message', $defTextMsg, [], array('plain'=>true)); ?>
        </td>
      </td>
      <tr>
        <td>
        </td>
        <td valign="bottom" align="right" >
          <?php $cntForm->submit( 'Send Message', '$S.modal.close();' ); ?>
        </td>
      </tr>
    </table>

</fieldset>

</section>