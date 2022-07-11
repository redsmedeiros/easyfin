<?php 

$nome_sistema = 'Financeiro Freitas';

$url_sistema = "http://$_SERVER[HTTP_HOST]/";
$url = explode("//", $url_sistema);
if($url[1] == 'localhost/'){
	$url_sistema = "http://$_SERVER[HTTP_HOST]/financeiro/";
}

$email_adm = '';
$nome_admin = '';

$endereco_site = 'Rua X, Número 50, Bairro Centro - Belo Horizonte - MG CEP 30214-850';
$telefone_fixo = '(33) 3333-3333';
$telefone_whatsapp = '(33) 93333-3333';
$telefone_whatsapp_link = '5531933333333';
$cnpj_site = '10.301.706/0001-08';

$rodape_relatorios = 'Desenvolvido por Rodolpho Araujo Medeiros!!';

/*
//DADOS PARA O BANCO DADOS LOCAL
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'financeiro';
*/


//DADOS PARA O BANCO DADOS HOSPEDADO
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "financeiroteste";


//VARIAVEIS GLOBAIS
$nivel_minimo_estoque = 10;  // a partir de 10 produtos ele vai colocar o produto em alerta com estoque baixo.

//VARIAVEIS PARA CONTAS A RECEBER   OBS NAO COLOQUE % NOS VALORES
$valor_multa = 2; // esse valor de 2 corresponde a 2% sobre o valor da venda
$valor_juros_dia = 0.15; // aqui será 0.15 % ao dia sobre o valor da venda;
$dias_carencia = 0;

$frequencia_automatica = 'Não'; //Caso você utilize sim e tenha uma conta que foi lançada como mensal, todo mês será gerado uma nova conta independentemente se a anterior foi paga.


$relatorio_pdf = 'Sim'; //Se estiver sim o relatório vai sair em pdf, caso contrário será um relatório html.
 ?>