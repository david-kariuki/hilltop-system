<?php
require_once "../Modal.php";
/**
 * This file deals with routing request to the their handlers
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if($_REQUEST['action'] ==  'renderMainView'){
    $view = $_REQUEST['data'];
    $views = PATH;

    foreach ($views as $key => $value) {
        if ($key == $_REQUEST['data']) {
            require_once(PATH[$view]['view']);
            break;
        }else{
            
        }
    }
    exit();
} else {
    echo "echo action is not allowed";
}


// if(
//     /*TODO: update session management*/
//     true
// ){
//     //get the sent data
//     $data = $_REQUEST['data'];

//     $view = $data[0];
//     $token = $data[1];

//     $variables = isset($data[2]) ? $data[2] : null;
//     $parent = '';
//     $mode = null;

//     if(isset($variables)){
//         $parent = $variables[0];
//         $mode = $variables[1];
//     }
//     $System = new System();
//     //verify user
//     /**
//      * @todo remove the line below and verify user
//      */
//     $verified = true;

   
//     if($verified){
//         if($_REQUEST['action'] ==  'routing'){
//             $views = PATH;
//             foreach ($views as $key => $value) {
//                 if ($key == $view) {
//                     require_once(PATH[$view]['view']);
//                     break;
//                 }
//             }
//             exit();
//         } elseif($_REQUEST['action'] ==  'open'){

//             $parents = PATH;
//             foreach ($parents as $key => $value) {
//                 if ($key == $parent) {
//                     foreach ($value as $key => $value) {
//                         if($key == $view){                            
//                             if($mode == "update"){
//                                 $_SESSION['mode'] = "update";
//                                 $_SESSION['itemVariable'] = $_REQUEST['id'];
//                             }else{
//                                 $_SESSION['mode'] = "add";
//                                 unset($_SESSION['itemVariable']);
//                             }
//                             require_once(PATH[$parent][$view]);
//                             break;
//                         } 
//                     }
//                 }
//             }
//             exit();
//         } else {
//             echo "other";
//         }
//     }else{
//         echo "unverified";
//     }
// }else{
//     echo "not set";
// }