<?php

// define critical path here
define('FCPATH', getcwd() . DIRECTORY_SEPARATOR);
define('ROOTPATH', realpath(FCPATH . '..') . DIRECTORY_SEPARATOR);

// load bootstrap and go away
require ROOTPATH . 'app/System/Bootstrap.php';