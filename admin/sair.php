<?php
    //iniciar a sessao
    session_start();

    //apagar a sessao
    unset ($_SESSION["hqs"]);

    //redirecionar para a pagina inicial
    header("Location: index.php");