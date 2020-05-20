<?php

$nome		    = @$_POST['nome'];
$senhaAtual		= @$_POST['senhaAtual'];
$senhaNova 		= @$_POST['senhaNova'];
$senhaConfirmar	= @$_POST['senhaConfirmar'];

if(!isset($nome))
{
    $nome = '';
}

if(!isset($senhaAtual))
{
    $senhaAtual = '';
}

if(!isset($senhaNova))
{
    $senhaNova = '';
}

if(!isset($senhaConfirmar))
{
    $senhaConfirmar = '';
}

include('funcoes.php');

// Campos vazios
if ( $nome == '' or $senhaAtual == '' or $senhaNova == '' or $senhaConfirmar == '' )
{
	echo "erro-Preencher todos os campos!";
	return;	
}

// Tamanho mínimo da senha
if ( strlen($senhaNova) < 6 )
{
	echo "erro-Tamanho mínimo da senha é de 6 caracteres!";
	return;
}

// Espaço
if ( valida_espaco($senhaNova) or valida_espaco($senhaConfirmar) )
{
	echo "erro-Não é permitido o uso espaço! Nem entre ou dentro das palavras!";
	return;	
}

// Senhas iguais
if ($senhaNova !== $senhaConfirmar) 
{
	echo "erro-Senhas digitadas têm que ser iguais!";
	return;	
}

$senhaAtual = md5($senhaAtual . "Mutato Muzika");

include('conexao_bd.php');

$query = " select id from usuarios where nome = ? and senha = ? ";
$querytratada = $conn->prepare($query); 
$querytratada->bind_param( "ss", $nome, $senhaAtual );
$querytratada->execute();
$result = $querytratada->get_result();

if( $result->num_rows == 0 )
{
    echo 'erro-Senha atual não confere!';
    return;
}

// criptografia da senha com chave
$senhaNova = md5($senhaNova . "Mutato Muzika");

$query = " UPDATE usuarios SET senha = ? where nome = ? ";
$querytratada = $conn->prepare($query); 
$querytratada->bind_param( "ss", $senhaNova, $nome );

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
} 
else 
{
	$resposta = 'erro-Problema ao atualizar senha!';
}

// FECHA CONEXAO
mysqli_close($conn);

// RETORNA RESULTADO
echo $resposta;
return;

?>