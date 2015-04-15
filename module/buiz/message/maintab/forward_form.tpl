<?php 

// sicher stellen, dass die benötigten Resourcen vorhanden sind
$orm = $this->getOrm();
$user = $this->getUser();

$cntForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Buiz.Message.sendForward&amp;objid='.$VAR->msgNode->msg_id.'&amp;element='.$VAR->elementKey,
  'wbf-forward-message-form',
  'post'
);
$cntForm->form();


$confidentialData = $cntForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$itemType = $cntForm->loadQuery( 'BuizContactItemType_Checklist' );
$itemType->fetch();

$defTextMsg = <<<HTML

HTML;


?>

<div class="bw62 wgt-space" >
 
  <div class="left bw6" >
    <?php $cntForm->autocomplete
    ( 
    	 'Receiver', 
    	 'receiver', 
      '',
      'ajax.php?c=Buiz.Message.loadUser&key=', 
      [], 
      array('size'=>'xxlarge', 'entityMode' => true )  
    ); ?>
  </div>

  <div class="left bw3" >
    <?php $cntForm->multiSelectByKey
    ( 
      'Channels', 
      'channels[]', 
      'BuizContactItemType_Checklist', 
      $itemType->getAll(),
      array('mail','message')
    ); ?>
  </div>
  
  <div class="inline bw3" >
    <?php  $cntForm->selectboxByKey
    ( 
      'Confidentiality Level', 
      'id_confidentiality', 
      'BuizConfidentialityLevel_Selectbox', 
      $confidentialData->getAll(),
      $orm->getIdByKey( 'BuizConfidentialityLevel', 'public' ) 
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
  
  <div class="do-clear medium" >&nbsp;</div>
  
  <div class="wgt-content_box bw6 wgt-space" >
    <div class="head" ><?php echo $VAR->msgNode->title; ?></div>
    <div class="content" style="background:white;min-height:200px;"  >
    	<iframe 
    		src="plain.php?c=Buiz.Message.showMailContent&objid=<?php echo $VAR->msgNode->msg_id; ?>"
    		style="width:100%;height:500px;padding:0px;margin:0px;border:0px;" ></iframe>
    </div>
  </div>
   
  
  <div class="do-clear medium" >&nbsp;</div>

</div>
