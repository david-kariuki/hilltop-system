<?php
/**
 * This file acts as a class auto-loader.
 * no input is needed.
 * no visible output
 */
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});