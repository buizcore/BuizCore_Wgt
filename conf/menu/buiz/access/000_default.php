<?php

$this->crumbs = array(
  array('Root', $this->interface.'?c=Buiz.Navigation.explorer','fa fa-desktop'),
  array('System', $this->interface.'?c=Buiz.Base.menu&amp;menu=maintenance','fa fa-folder-o'),
  array('Access', $this->interface.'?c=Buiz.Base.menu&amp;menu=access','fa fa-folder-o'),
);

$this->firstEntry = array
(
  'menu_mod_root',
   Wgt::MAIN_TAB,
  '..',
  I18n::s('Root', 'wbf.label'  ),
  'maintab.php?c=Buiz.Base.menu&amp;menu=maintenance',
  'fa fa-level-up',
);

$this->files[] = array
(
  'menu-system-access-users',
  Wgt::MAIN_TAB,
  $this->view->i18n->l
  (
    'Users',
    'wbf.label'
  ),
  $this->view->i18n->l
  (
    'Users',
    'wbf.label'
  ),
  'maintab.php?c=Buiz.RoleUser_Listing.mask',
  'fa fa-user',
);

$this->files[] = array
(
  'menu-system-access-groups',
  Wgt::MAIN_TAB,
  $this->view->i18n->l
  (
    'Groups',
    'wbf.label'
  ),
  $this->view->i18n->l
  (
    'Groups',
    'wbf.label'
  ),
  'maintab.php?c=Buiz.RoleGroup_Listing.mask',
  'fa fa-group',
);

$this->files[] = array
(
  'menu-system-access-profiles',
  Wgt::MAIN_TAB,
  $this->view->i18n->l
  (
    'Profiles',
    'wbf.label'
  ),
  $this->view->i18n->l
  (
    'Profiles',
    'wbf.label'
  ),
  'maintab.php?c=Buiz.Profile_Listing.mask',
  'fa fa-envelope',
);

$this->files[] = array
(
  'menu-system-acl',
  Wgt::MAIN_TAB,
  'ACLs',
  'ACLs',
  'maintab.php?c=Daidalos.Acl.form',
  'fa fa-shield',
);

