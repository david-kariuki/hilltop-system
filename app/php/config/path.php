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
  'Dashboard' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/dashboard/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/dashboard/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/dashboard/control.php',
  ),
  'Catalogue' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/catalogue/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/catalogue/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/catalogue/control.php',
    'catalogueForm' => $_SERVER['DOCUMENT_ROOT'] . '/Views/catalogue/catalogueForm.php',
  ),
  'Customers' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/customers/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/customers/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/customers/control.php',
  ),
  'Sales' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/sales/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/sales/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/sales/control.php',
    'salesForm' => $_SERVER['DOCUMENT_ROOT'] . '/Views/sales/salesForm.php',
  ),
  'Transactions' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/transactions/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/transactions/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/transactions/control.php',
  ),
  'Vendors' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/vendors/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/vendors/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/vendors/control.php',
  ),
  'Moderators' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/moderators/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/moderators/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/moderators/control.php',
  ),
  'PointOfSale' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/PointOfSale/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/PointOfSale/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/PointOfSale/control.php',
  ),
  'Account' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/accounts/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/accounts/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/account/control.php',
  ),
  'Orders' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/Views/orders/',
    'view' => $_SERVER['DOCUMENT_ROOT'] . '/Views/orders/view.php',
    'control' => $_SERVER['DOCUMENT_ROOT'] . '/Views/orders/control.php',
  ),
));