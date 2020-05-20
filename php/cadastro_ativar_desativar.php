<?php

$nome   = @$_POST['nome'];
$acao   = @$_POST['acao'];

if(!isset($nome))
{
    $nome = '';
}

if(!isset($acao))
{
    $acao = '';
}

// Campos vazios
if ( $nome == '' or $acao == '' )
{
	echo "erro-Preencher ao encontrar cadastro!";
	return;	
}

if ( $acao === 'ativar')
{
    $acao = 'ativo';
}
else
{
    $acao = 'inativo';
}

include('conexao_bd.php');

$query = " UPDATE usuarios SET ativo = ? where nome = ? ";
$querytratada = $conn->prepare($query); 
$querytratada->bind_param( "ss", $acao, $nome );

$querytratada->execute();

//var_dump($conn->info);
// [info] => Rows matched: 1  Changed: 1  Warnings: 0

preg_match_all ('/(\S[^:]+): (\d+)/', $conn->info, $querytratada);
$info = array_combine ($querytratada[1], $querytratada[2]);	

// Linhas encontradas com base na condição da where
$linhas_encontradas = $info['Rows matched'];

// Linhas que foram alteradas, quando os dados não forem alterados, mesmo o comando estando certo, não é retornado linhas afetadas
$linhas_afetadas = $info['Changed'];

// Avisos de problemas
$avisos_problemas = $info['Warnings'];

if ($linhas_encontradas == '1' and $avisos_problemas == '0')
{
    $resposta = 'ok';
    session_start();
    session_destroy();
} 
else 
{
	$resposta = 'erro-Problema ao inativar cadastro!';
}

// FECHA CONEXAO
mysqli_close($conn);

// RETORNA RESULTADO
echo $resposta;
return;

?>