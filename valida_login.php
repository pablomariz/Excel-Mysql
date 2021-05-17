<?php
    session_start();
    require 'utils/conexao.php';

    if(empty($_POST['usuario']) || empty($_POST['senha']))
    {
        header('Location: login.php');
        exit();
    }

    $usuario = mysqli_real_escape_string($con, $_POST['usuario']);
    $senha = mysqli_real_escape_string($con, $_POST['senha']);

    $query_login = "select * from usuario where usuario = '{$usuario}' and senha = md5('{$senha}')";
    $result = mysqli_query($con, $query_login);
    $row = mysqli_num_rows($result);

    if($row == 1)
    {
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
        exit();
    }
    else
    {
        header('Location: login.php');
        exit();
    }

?>