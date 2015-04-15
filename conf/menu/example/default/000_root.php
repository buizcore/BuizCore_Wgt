<?php

$this->crumbs = array(
  array(
    'Dashboard',
    '',
    'fa fa-dashboard',
    null,
    'wgt-ui-desktop'
  ),
  array('Root',$this->interface.'?c=Buiz.Navigation.explorer','fa fa-desktop'),
  array('Daidalos',$this->interface.'?c=Daidalos.Base.menu','fa fa-folder-o'),
  array('Example',$this->interface.'?c=Example.Base.menu','fa fa-folder-o'),
);

if ($acl->hasRole('developer')) {

  $this->firstEntry = array(
    'menu_buiz_root',
    Wgt::MAIN_TAB,
    '..',
    'Buiz Root',
    'maintab.php?c=Daidalos.Base.menu',
    'fa fa-level-up',
  );

  $this->files[] = array(
    'menu_mod_example-wgt',
    Wgt::MAIN_TAB,
    'WGT',
    'WGT',
    'maintab.php?c=Example.Wgt.tree',
    'fa fa-laptop',
  );

  $this->files[] = array(
    'menu_mod_example-tech',
    Wgt::MAIN_TAB,
    'Tech &amp; Libs',
    'Tech &amp; Libs',
    'maintab.php?c=Example.Tech.tree',
    'fa fa-laptop',
  );

}
