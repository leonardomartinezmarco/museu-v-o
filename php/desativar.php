<?php

$codigo = $_POST['codigo'];

if(!isset($codigo))
{
    $codigo = 0;
}

$status='inativo';
$resposta = '';

include('conexao_bd.php');

// Ver se já está inativo, se tiver então ativar
$query = "select ativo from obras where id = ?";
$querytratada = $conn->prepare($query); 
$querytratada->bind_param("i",$codigo);
$querytratada->execute();
$result = $querytratada->get_result();

if( $result->num_rows > 0 )
{
    $row           = $result->fetch_assoc();  
    $status_banco  = $row["ativo"];

    if($status_banco=='inativo')
    {
        $status = 'ativo';
    }
    else
    {
        $status = 'inativo';
    }
}

// Prevenção de injection
$query = " UPDATE obras SET ativo = ? WHERE id = ? ";

 $querytratada = $conn->prepare($query); 
 $querytratada->bind_param("si",$status,$codigo);

$querytratada->execute();

if ($querytratada->affected_rows > 0) 
{
    $resposta = $status;
} 
else 
{
    $resposta = 'erro';
}

// FECHA CONEXAO
mysqli_close($conn);

// RETORNA RESULTADO
echo $resposta;
return;


?>