<?php
session_start();
require 'vendor/autoload.php';
require 'utils/conexao.php';

$validacao = 1;
$cont = 0;
$aux = 0;
$i = -1;
$j = -1;
$EAN = [];
$NOME_PRODUTO = [];
$PRECO = [];
$ESTOQUE = [];
$index = -1;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_POST['import_file_btn']))
{
    $ext = ['xls', 'csv', 'xlsx'];

    $fileName = $_FILES['import_file']['name'];
    $checking = explode(".", $fileName);
    $file_ext = end($checking);

    if(in_array($file_ext, $ext))
    {
        $destino = $_FILES['import_file']['tmp_name'];
        $planilha = \PhpOffice\PhpSpreadsheet\IOFactory::load($destino);
        $data = $planilha->getActiveSheet()->toArray();


        foreach($data as $row)
        {
            $i += 1;
            $EAN[$i] = $row['0'];
            $NOME_PRODUTO[$i] = $row['1'];
            $PRECO[$i] = $row['2'];
            $ESTOQUE[$i] = $row['3'];
            $DATA_FABRICACAO = $row['4'];

            if($EAN[$i] != '')
            {
                $cont += 1;
            }
        }
        //verifica se os campos obrigatório tem algum dado vazio
        while($aux < $cont)
        {
            $j += 1;
            if(($EAN[$j] == '')||($NOME_PRODUTO[$j] == '')||($PRECO[$j] == '')||($ESTOQUE[$j] == ''))
            {
                $validacao = "0";
            }
            $aux += 1;
        }

        //verifica se EAN ta repetindo
        for($a = 0; $a < $cont; $a++)
        {
            for($b = 0; $b < $a; $b++)
            {
                if ($EAN[$a] == $EAN[$b])
                {
                    $validacao = "0";
                }
            }
        }


        if($validacao == '1')
        {
            foreach($data as $row)
            {
                $index += 1;
                $EAN = $row['0'];
                $NOME_PRODUTO = $row['1'];
                $PRECO = $row['2'];
                $ESTOQUE = $row['3'];
                $DATA_FABRICACAO = $row['4'];


                if($EAN != '')
                {
                    $verificacao = "SELECT EAN FROM produtos where EAN='$EAN' ";
                    $verificacao_result = mysqli_query($con, $verificacao);
                    if(mysqli_num_rows($verificacao_result) > 0)
                    {
                        $up_query = "UPDATE produtos set EAN='$EAN', NOME_PRODUTO='$NOME_PRODUTO', PRECO='$PRECO',
                        ESTOQUE='$ESTOQUE', DATA_FABRICACAO='$DATA_FABRICACAO' where EAN='$EAN' ";
                        $up_result = mysqli_query($con, $up_query);
                        $msg = 1;
                    }
                    else
                    {
                        $in_query = "INSERT INTO produtos (EAN, NOME_PRODUTO, PRECO, ESTOQUE, DATA_FABRICACAO) VALUES
                        ('$EAN', '$NOME_PRODUTO','$PRECO', '$ESTOQUE', '$DATA_FABRICACAO')";
                        $in_result = mysqli_query($con, $in_query);
                        $msg = 1;
                    }
                }
                    if($EAN == '')
                    {
                        break;
                    }

            }
        }

        if(isset($msg))
        {
            $_SESSION['status'] = "sucesso";
            header("Location: index.php");
        }
        else
        {
            $_SESSION['status'] = "erro";
            header("Location: index.php");
        }
    }
    else
    {
        $_SESSION['status'] = "erro";
        header("Location: index.php");
        exit(0);
    }
}


?>