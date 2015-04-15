<?php

$this->crumbs = array(
  array(
    'Dashboard',
    '',
    'fa fa-dashboard',
    null,
    'wgt-ui-desktop'
  ),
  array('Root', $this->interface.'?c=Buiz.Navigation.explorer','fa fa-desktop'),
  array('System', $this->interface.'?c=Buiz.Base.menu&amp;menu=maintenance','fa fa-folder-o'),
  array('Masterdata', $this->interface.'?c=Buiz.Base.menu&amp;menu=masterdata','fa fa-folder-o'),
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
  'menu-system-cache',
  Wgt::MAIN_TAB,
  $this->view->i18n->l
  (
    'Cache',
    'wbf.label'
  ),
  $this->view->i18n->l
  (
    'Cache',
    'wbf.label'
  ),
  'maintab.php?c=Buiz.Cache.stats',
  'fa fa-hdd',
);

