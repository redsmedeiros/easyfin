<?php 
include('../conexao.php');

$id = $_GET['id'];

//BUSCAR AS INFORMAÇÕES DO PEDIDO
$query = $pdo->query("SELECT * from compras where id = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

		$id = $res[0]['id'];
		$cp1 = $res[0]['valor'];
		$cp2 = $res[0]['usuario'];
		$cp3 = $res[0]['pagamento'];
		$cp4 = $res[0]['lancamento'];
		$cp5 = $res[0]['data_lanc'];
		$cp6 = $res[0]['data_pgto'];
		
		$cp10 = $res[0]['parcelas'];
		$cp11 = $res[0]['status'];
		$cp12 = $res[0]['cliente'];

$data2 = implode('/', array_reverse(explode('-', $cp5)));


$res = $pdo->query("SELECT * from usuarios where id = '$cp2' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = $dados[0]['nome'];


$query1 = $pdo->query("SELECT * from fornecedores where id = '$cp12' ");
		$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
		if(@count($res1) > 0){
			$nome_cliente = $res1[0]['nome'];
						
		}else{
			$nome_cliente = 'Sem Fornecedor';
		}

?>


<style type="text/css">
	*{
	margin:0px;
	padding:5px;
	background-color:#f7fccc;

}
.text {
	&-center { text-align: center; }
}
.ttu { text-transform: uppercase;
	font-weight: bold;
	font-size: 1.2em;
 }

.printer-ticket {
	display: table !important;
	width: 100%;
	max-width: 400px;
	font-weight: light;
	line-height: 1.3em;
	padding: 5px;
	font-family: Tahoma, Geneva, sans-serif; 
	font-size: 12px; 
	
	
	
	}
	
	th { 
		font-weight: inherit;
		padding:5px;
		text-align: center;
		border-bottom: 1px dashed #BCBCBC;
	}

	

	
	
		
	.cor{
		color:#BCBCBC;
	}
	
	
	.title { font-size: 1.5em;  }

	.margem-superior{
		padding-top:25px;
	}
	
	
}
</style>



<table class="printer-ticket">

	<tr>
		<th class="title" colspan="3"><?php echo $nome_sistema ?></th>

	</tr>
	<tr>
		<th colspan="3">Compra <?php echo $id ?> - Fornecedor <?php echo $nome_cliente ?> - Data: <?php echo $data2 ?> - Compra : <?php echo $cp11 ?></th>
	</tr>
	<tr>
		<th colspan="3">
			Endereço <?php echo $endereco_site ?> <br />
			Telefone <?php echo $telefone_fixo ?> CNPJ <?php echo $cnpj_site ?>
		</th>
	</tr>
	<tr>
		<th class="ttu margem-superior" colspan="3">
			Comprovante de Compra <?php if($cp11 == 'Cancelada'){ echo ' Cancelada';} ?>
			
		</th>
	</tr>
	<tr>
		<th colspan="3">
			CUMPOM NÃO FISCAL
			
		</th>
	</tr>
	
	<tbody>

		<?php 

		$res = $pdo->query("SELECT * from itens_compra where id_compra = '$id' order by id asc");
		$dados = $res->fetchAll(PDO::FETCH_ASSOC);
		$linhas = count($dados);

		$sub_tot;
		for ($i=0; $i < count($dados); $i++) { 
			foreach ($dados[$i] as $key => $value) {
			}

			$id_produto = $dados[$i]['produto']; 
			$quantidade = $dados[$i]['quantidade'];
			$valor = $dados[$i]['valor'];
			$total= $dados[$i]['total'];

			
			$res_p = $pdo->query("SELECT * from produtos where id = '$id_produto' ");
				$dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
				$nome_produto = $dados_p[0]['nome'];  
				$valor = $dados_p[0]['valor_compra'];
			
				$total_item = $valor * $quantidade;
	

			?>

			<tr>
				
					<td colspan="2" width="50%"><?php echo $quantidade ?> - <?php echo $nome_produto ?> 
						
					</td>
				

				<td align="right">R$ <?php

				@$total_item;
				@$sub_tot = @$sub_tot + @$total_item;
				@$sub_total = $cp1;
				
				$sub_tot2 = number_format( $sub_tot , 2, ',', '.');
				$sub_total = number_format( $sub_total , 2, ',', '.');
				$total_item = number_format( $total_item , 2, ',', '.');
				//$total = number_format( $cp1 , 2, ',', '.');
				

				echo $total_item ;
				?></td>
			</tr>

		<?php } ?>

				
	</tbody>
	<tfoot>

		<tr>
			<td colspan="3" class="cor">
				--------------------------------------------------------------------------------------------------------------------------------------------------------------
			</td>
		</tr>

		
		
		
		<tr>
			<td colspan="2">Total</td>
			<td align="right">R$ <?php echo $sub_tot2 ?></td>
		</tr>

				
		</tr>

			<tr>
			<td colspan="2">SubTotal</td>
			<td align="right">R$ <?php echo $sub_total ?></td>
		</tr>

			
		

		

		<tr>
			<td colspan="3" class="cor">
				--------------------------------------------------------------------------------------------------------------------------------------------------------------
			</td>
		</tr>
		
		<tr>
			<td colspan="3" align="center">
				www.hugocursos.com.br
			</td>
		</tr>
	</tfoot>
</table>