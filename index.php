<?php 
include ('verifica_login.php'); 
require ('utils/conexao.php');
?>

<style>

    button
    {
        border-radius: 50%;
        border: 1px solid black;
    }

    .logout
    {
        position:absolute; 
        top:6%;
        left:88%;
        transform: translate(-50%, -50%);
    }

    #tabela_personalizada td, #tabela_personalizada th 
    {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #tabela_personalizada tr:nth-child(even)
    {
        background-color: #f2f2f2;
    }

</style>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <br>
<div class="container">
    <form action="code.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="import_file"  />
        <button type="submit" name="import_file_btn">enviar</button>
    </form>

<button onclick="window.location.href = 'logout.php'" class="logout">Logout</button>


<table id="tabela_personalizada"  style="width:100%">
    <tr>
      <th>AÇÃO</th>
      <th>EAN</th>
      <th>NOME PRODUTO</th>
      <th>PREÇO</th>
      <th>ESTOQUE</th>
      <th>DATA FABRICAÇÃO</th>
    </tr>


<?php

$query_produto = "select * from produtos";
$query_result = mysqli_query($con, $query_produto);

while ($row = mysqli_fetch_assoc($query_result))
{
    echo "<tr>";
    ?>

    <td><button type='button' onclick="deleteData(<?php echo $row['id']?>)">EXCLUIR</button></td>
    <?php
    echo "<td>". $row['EAN'] ."</td>";
    echo "<td>". $row['NOME_PRODUTO'] ."</td>";
    echo "<td>". $row['PRECO'] ."</td>";
    echo "<td>". $row['ESTOQUE'] ."</td>";
    echo "<td>". $row['DATA_FABRICACAO'] ."</td>";
    echo "</tr>";
}
?>

</table>
</div>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"> </script>
<script>

function deleteData(str){
    var id = str;
    $.ajax({
        type: "POST",
        url: "delete_registro.php",
        data: "id="+id,
        success: function(result) {
            alert("Excluido com sucesso");
            location.reload();
        },                
        error: function(result) {
            alert("Erro ao remover!");
        }
    });
    
};


</script>