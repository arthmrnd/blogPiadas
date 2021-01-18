<?php
    session_start();
    //Sair da sessão atual
    session_destroy();
    header("Location: index.php");
?>