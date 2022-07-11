<?php 
require_once("../../conexao.php");
require_once("campos.php");
@session_start();
$id_usuario = $_SESSION['id_usuario'];

$id = @$_POST['id-comprar'];
$quantidade = @$_POST['quantidade'];
$cp5 = $_POST[$campo5];
$cp5 = str_replace(',', '.', $cp5);
$cp7 = $_POST[$campo7];
$cp11 = $_POST[$campo11];
$alterar = @$_POST['alterar'];
$total_compra = $cp5 * $quantidade;

$total_estoque = 0;
$query_con = $pdo->query("SELECT * FROM $pagina WHERE id = '$id'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res_con[0]['estoque'];
$valor_venda = $res_con[0]['valor_venda'];

$query_con = $pdo->query("SELECT * FROM fornecedores WHERE id = '$cp7'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
$nome_forn = $res_con[0]['nome'];


if($cp11 != "" and $alterar == 'true'){
	$novo_vlr_venda = $cp5 + ($cp5 * $cp11 / 100);
}else{
	$novo_vlr_venda = $valor_venda;
}

$total_estoque = $estoque + $quantidade;

$query = $pdo->prepare("UPDATE $pagina SET estoque = :estoque, valor_compra = :valor_compra, fornecedor = :fornecedor, valor_venda = :valor_venda, lucro = :lucro where id = '$id'");
$query->bindValue(":estoque", "$total_estoque");
$query->bindValue(":valor_compra", "$cp5");
$query->bindValue(":fornecedor", "$cp7");
$query->bindValue(":valor_venda", "$novo_vlr_venda");
$query->bindValue(":lucro", "$cp11");
$query->execute();


//LANÇAR NAS CONTAS A PAGAR
$query = $pdo->prepare("INSERT INTO contas_pagar SET descricao = 'Fornecedor - $nome_forn', plano_conta = 'Compra de Produtos - Empresa', data_emissao = curDate(), vencimento = curDate(), valor = :valor_compra, frequencia = 'Uma Vez', saida = 'Caixa', documento = 'Dinheiro', usuario_lanc = '$id_usuario', status = 'Pendente', arquivo = 'sem-foto.jpg'");


$query->bindValue(":valor_compra", "$total_compra");
$query->execute();

echo 'Comprado com Sucesso';

 ?>