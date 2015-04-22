<?php 

/* @var $model BuizMediathek_Model */
$model = $this->loadModel( 'BuizMediathek' );
$user = BuizCore::$env->getUser();

$userDomain = DomainNode::getNode( 'buiz_role_user' );

try
{
  
  $mediaNode = $model->loadMediathek( $userDomain, $user );

  $mediathek = new WgtElementMediathek( 'fuu', $this  );
  $mediathek->label = 'Mediathek';
  $mediathek->setMediaNode( $mediaNode );
  $mediathek->setIdKey( 'fubar' );

  $mediathek->dataAudio = $model->getAudioList( $model->mediaId );
  $mediathek->dataDocument = $model->getDocumentList( $model->mediaId );
  $mediathek->dataFile = $model->getFileList( $model->mediaId );
  $mediathek->dataImage = $model->getImageList( $model->mediaId );
  $mediathek->dataVideo = $model->getVideoList( $model->mediaId );

  echo $ELEMENT->fuu;

}
catch( Exception $e )
{
  echo $e->getMessage();
}

?>