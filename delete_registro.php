<?php

require('utils/conexao.php');
$id = $_POST['id'];

$query_remover = "DELETE FROM produtos where id = $id";
$query_result = mysqli_query($con, $query_remover);

?>