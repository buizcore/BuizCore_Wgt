<?php

if ($user->hasRole(array('admin', 'developer'))) {
  $this->folders[] = array
  (
    'menu-mod-buiz-maintenance',
    Wgt::MAIN_TAB,
    I18n::s('System', 'maintenance.label'  ),
    I18n::s('System', 'maintenance.label'  ),
    'maintab.php?c=Buiz.Base.menu&amp;menu=maintenance',
    'fa fa-cog',
  );

}