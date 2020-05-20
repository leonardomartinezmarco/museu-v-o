<?php  
    session_start();

    if (isset($_SESSION['controle'])) 
    {
        echo 'Bem vindo! ' . $_SESSION['controle'];
    }
    else
    {
        echo '';
    }
?>