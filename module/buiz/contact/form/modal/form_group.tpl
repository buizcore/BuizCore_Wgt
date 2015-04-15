<?php 

$orm = $this->getOrm();
$cntForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Buiz.ContactForm.sendGroupMessage&amp;refid='.$VAR->refId.'&amp;element='.$VAR->elementKey,
  'wgt-form-wbf-contact_form-group',
  'post'
);
$cntForm->form();


$confidentialData = $cntForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$itemType = $cntForm->loadQuery( 'BuizContactItemType_Checklist' );
$itemType->fetch();


?>
<div class="wgt-panel title" ><h2>Group Message</h2></div>

<div class="wgt-layout-grid" >

  <?php $cntForm->input( 'Subject', 'subject', null, [], array('size'=>'xxlarge')  ); ?>
  <?php // $cntForm->input( 'Receiver', 'receiver', null, [], array('size'=>'xxlarge')  ); ?>
  <div class="wgt-input-list" >
    <label>Receivers</label>
    <ul 
      class="wgt-input-list" 
      style="margin-left:0px;" >
      <?php foreach( $VAR->groupData as $user ){ ?>
      <li id="wgt-contact_form-user-<?php echo $user->id ?>" >
        <label><?php echo $user->nickname ?> &lt;<?php echo $user->lastname ?>, <?php echo $user->firstname ?>&gt;</label>
        <div><button 
          class="wgt-button"
          onclick="$S('#wgt-contact_form-user-<?php echo $user->id ?>').remove();" ><i class="fa fa-times" ></i></button></div>
        <input 
          type="hidden" 
          class="<?php echo $cntForm->asgd() ?>" 
          name="user[]" 
          value="<?php echo $user->id ?>" />
      </li>
      <?php } ?>
    </ul>
    <div class="do-clear" >&nbsp;</div>
  </div>
  
  <div>
    <div class="left bw25" >
    <?php $cntForm->multiSelectByKey
    ( 
      'Channels', 
      'channels[]', 
      'BuizContactItemType_Checklist', 
      $itemType->getAll(),
      array('mail','message')
    ); ?>
    </div>
    <div  class="inline bw3"  >
    <?php  $cntForm->selectboxByKey
    ( 
      'Confidentiality Level', 
      'id_confidentiality', 
      'BuizConfidentialityLevel_Selectbox', 
      $confidentialData->getAll(),
      $orm->getIdByKey( 'BuizConfidentialityLevel', 'restricted' ) 
    ); ?>
    
    <?php  $cntForm->ratingbar
    ( 
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
    </div>
  </div>
  
  <div class="left" > 
    <?php $cntForm->wysiwyg( 'Message', 'message', null, [], array('plain'=>true)); ?>
  </div>
  
  <div class="do-clear medium" >&nbsp;</div>
  
  <div class="left bw4" >
    <!--  Attachments -->
  </div>
  
  <div class="right" >
    <?php $cntForm->submit( 'Send Message', '$S.modal.close();' ); ?>
  </div>
  
  <div class="do-clear" >&nbsp;</div>
  
</div>

