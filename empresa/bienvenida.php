<?php

    require_once('../classes/DatabasePDOInstance.function.php');
    $db = DatabasePDOInstance();

    if (isset($_GET['id']) && isset($_GET['c'])){
        session_start();

        $id = $_GET['id'];

        $db->query("UPDATE empresas SET confirmar = 1 WHERE id = $id");
        
        header('Location: ./');

        
    } else {
        header('Location: ./');
    }

?>