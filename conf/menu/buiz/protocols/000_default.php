<?php

$this->crumbs = array(
  array('Root', $this->interface.'?c=Buiz.Navigation.explorer','fa fa-desktop'),
  array('System', $this->interface.'?c=Buiz.Base.menu&amp;menu=maintenance','fa fa-folder-o'),
  array('Protocols', $this->interface.'?c=Buiz.Base.menu&amp;menu=protocols','fa fa-folder-o'),
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
  'menu-system-protocols-login',
  Wgt::MAIN_TAB,
  'Logon Protocol',
  'Logon Protocol',
  'maintab.php?c=Buiz.ProtocolUsage.listing',
  'fa fa-list',
);

$this->files[] = array
(
  'menu-system-protocols-messages',
  Wgt::MAIN_TAB,
  'Mesage Protocol',
  'Mesage Protocol',
  'maintab.php?c=Buiz.MessageLog.listing',
  'fa fa-list',
);

$this->files[] = array
(
  'menu-system-protocols-usage',
  Wgt::MAIN_TAB,
  'Usage Protocol',
  'Usage Protocol',
  'maintab.php?c=Buiz.ProtocolMessage.listing',
  'fa fa-list',
);

$this->files[] = array
(
  'menu-system-protocols-error',
  Wgt::MAIN_TAB,
  'Error Protocol',
  'Error Protocol',
  'maintab.php?c=Buiz.ProtocolMessage.listing',
  'fa fa-list',
);

$this->files[] = array
(
  'menu-system-protocols-deploment',
  Wgt::MAIN_TAB,
  'Deployment Protocol',
  'Deployment Protocol',
  'maintab.php?c=Buiz.ProtocolMessage.listing',
  'fa fa-list',
);

$this->files[] = array
(
  'menu-system-protocols-security',
  Wgt::MAIN_TAB,
  'Attack Protocol',
  'Attack Protocol',
  'maintab.php?c=Buiz.ProtocolMessage.listing',
  'fa fa-list',
);

$this->files[] = array
(
  'menu-system-protocols-apache',
  Wgt::MAIN_TAB,
  'Apache Logs',
  'Apache Logs',
  'maintab.php?c=Buiz.Log_Apache.listing',
  'fa fa-list',
);

$this->files[] = array
(
  'menu-system-protocols-php',
  Wgt::MAIN_TAB,
  'PHP Error Log',
  'PHP Error Log',
  'maintab.php?c=Buiz.Log_Php.listing',
  'fa fa-list',
);

$this->files[] = array
(
  'menu-system-protocols-postgresql',
  Wgt::MAIN_TAB,
  'PostgreSQL Error Log',
  'PostgreSQL Error Log',
  'maintab.php?c=Buiz.Log_Postgresql.listing',
  'fa fa-list',
);