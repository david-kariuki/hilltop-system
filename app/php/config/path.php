<?php
/**
 * This file provides paths for views and their helper files.
 * It does this by including all files included in a given view folder to include it.
 * It works together with the router file to achieve a seamless "View auto loader".
 * 
 * 
 */
  
define('PATH',
array(
  'Account' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/dashboard/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/dashboard/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/dashboard/control.php',
  ),
));