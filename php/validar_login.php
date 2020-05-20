<?php

$login = @$_POST['login'];

if(!isset($login))
{
    $login = '';
}

$senha = @$_POST['senha'];

if(!isset($senha))
{
    $senha = '';
}

include('conexao.php');

$senha = md5($senha . "Mutato Muzika");

// Verificar se login e senha estão corretos
$query = " select id,ativo from usuarios where nome = ? and senha = ? ";
$querytratada = $conn->prepare($query); 
$querytratada->bind_param( "ss", $login, $senha );
$querytratada->execute();
$result = $querytratada->get_result();

// Verifica se login e senha existem
if( $result->num_rows > 0 )
{
	$resposta = 'ok';
}
else
{
	$resposta = 'erro-Usuário ou senha incorretos!';
}

if ($resposta == 'ok')
{
	// Verifica se registro está inativo
	$row = $result->fetch_assoc(); 
	$status = $row["ativo"];

	if($status=='inativo')
	{
		$resposta = 'inat-Usuário está inativo!';
	}
}

// FECHA CONEXAO
mysqli_close($conn);

// Se login estiver correto, cria a sessão
if($resposta == 'ok')
{
	session_start();
	$_SESSION['controle'] = ucwords($login);
}

// RETORNA RESULTADO
echo $resposta;
return;

?>

