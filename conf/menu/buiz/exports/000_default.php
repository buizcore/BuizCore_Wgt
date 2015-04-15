<?php

$this->crumbs = array(
  array('Root', $this->interface.'?c=Buiz.Navigation.explorer','fa fa-desktop'),
  array('System', $this->interface.'?c=Buiz.Base.menu&amp;menu=maintenance','fa fa-folder-o'),
  array('Exports', $this->interface.'?c=Buiz.Base.menu&amp;menu=exports','fa fa-folder-o'),
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

