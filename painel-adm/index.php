<?php 
@session_start();
require_once("../conexao.php");
require_once("verificar.php");
$id_usuario = $_SESSION['id_usuario'];
$niv_usuario = $_SESSION['nivel_usuario'];

if($niv_usuario != 'Administrador'){
	$ocultar_menu = 'd-none';
}else{
	$ocultar_menu = 'd-block';
}
//RECUPERAR DADOS DO USUÁRIO
$query = $pdo->query("SELECT * from usuarios where id = '$id_usuario' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_usuario = $res[0]['nome'];
$email_usuario = $res[0]['email'];
$senha_usuario = $res[0]['senha'];
$nivel_usuario = $res[0]['nivel'];


//MENUS DO PAINEL
$menu1 = 'home';
$menu2 = 'clientes';
$menu3 = 'niveis';
$menu4 = 'usuarios';
$menu5 = 'bancos';
$menu6 = 'bancarias';
$menu7 = 'cat_despesas';
$menu8 = 'despesas';
$menu9 = 'frequencias';
$menu10 = 'formas_pgtos';
$menu11 = 'produtos';
$menu12 = 'cat_produtos';
$menu13 = 'fornecedores';
$menu14 = 'estoques';
$menu15 = 'caixa';
$menu16 = 'contas_pagar';
$menu17 = 'contas_receber';
$menu18 = 'contas_despesa';
$menu19 = 'movimentacoes';
$menu20 = 'vendas';
$menu21 = 'compras';
$menu22 = 'lista_vendas';
$menu23 = 'lista_compras';

if(@$_GET['pag'] == ""){
	$pag = $menu1;
}else{
	$pag = $_GET['pag'];
}

$data_atual = date('Y-m-d');
$dataOntem = date('Y-m-d', strtotime("-1 day",strtotime($data_atual)));

$mes_atual = Date("m");
$ano_atual = Date("Y");
$data_inicial_mes_atual = $ano_atual."-".$mes_atual."-01";

$data_inicial_mes_ant = date('Y-m-d', strtotime("-1 month",strtotime($data_inicial_mes_atual)));

$separar_data = explode("-", $data_inicial_mes_ant);
$mes_ant = $separar_data[1];

if($mes_ant == '4' || $mes_atual == '6' || $mes_atual == '9' || $mes_atual == '11'){
	$data_final_mes_atual = $ano_atual."-".$mes_atual."-30";
}else if($mes_ant == '2'){
	$data_final_mes_atual = $ano_atual."-".$mes_atual."-28";
}else{
	$data_final_mes_atual = $ano_atual."-".$mes_atual."-31";
}

$data_final_mes_ant = date('Y-m-d', strtotime("-1 month",strtotime($data_final_mes_atual)));

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Hugo Vasconcelos">
	<title>Easy Finanças</title>

	<link href="../img/logo.ico" rel="shortcut icon" type="image/x-icon">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="../css/style.css"/>

	<script type="text/javascript" src="../DataTables/datatables.min.js"></script>

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Easy Financeiro</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="index.php?pag=<?php echo $menu1 ?>">Home</a>
					</li>
					
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Cadastros
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu2 ?>">Clientes</a></li>
							<li><a class="dropdown-item <?php echo $ocultar_menu ?>" href="index.php?pag=<?php echo $menu4 ?>">Usuários</a></li>
							<li><a class="dropdown-item <?php echo $ocultar_menu ?>" href="index.php?pag=<?php echo $menu5 ?>">Bancos</a></li>
							<li><a class="dropdown-item <?php echo $ocultar_menu ?>" href="index.php?pag=<?php echo $menu3 ?>">Níveis de Usuários</a></li>
							<li><a class="dropdown-item <?php echo $ocultar_menu ?>" href="index.php?pag=<?php echo $menu6 ?>">Contas Bancárias</a></li>
							<li><a class="dropdown-item <?php echo $ocultar_menu ?>" href="index.php?pag=<?php echo $menu7 ?>">Categoria Despesas</a></li>
							<li><a class="dropdown-item <?php echo $ocultar_menu ?>" href="index.php?pag=<?php echo $menu8 ?>">Despesas</a></li>
							<li><a class="dropdown-item <?php echo $ocultar_menu ?>" href="index.php?pag=<?php echo $menu9 ?>">Frequências</a></li>
							<li><a class="dropdown-item <?php echo $ocultar_menu ?>" href="index.php?pag=<?php echo $menu10 ?>">Formas PGTO</a></li>
						</ul>
					</li>
					
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Produtos
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu11 ?>">Produtos</a></li>
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu12 ?>">Categorias</a></li>
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu13 ?>">Fornecedores</a></li>
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu11 ?>&estoque=sim">Estoque Baixo</a></li>
							
						</ul>
					</li>


					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Movimentações
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu19?>">Caixa - Movimentações</a></li>
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu16 ?>">Contas à Pagar</a></li>
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu17 ?>">Contas à Receber</a></li>
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu18 ?>">Lançar Despesas</a></li>
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu15 ?>">Caixa por Período</a></li>
							
							
						</ul>
					</li>


					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Vendas / Compras
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu22?>">Vendas</a></li>
							<li><a class="dropdown-item" href="index.php?pag=<?php echo $menu23 ?>">Compras</a></li>
							
							
						</ul>
					</li>



					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Relatórios
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">

							<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalRelMov">Movimentações</a></li>

							<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalRelLucro">Lucro Vendas (Demonstrativo Comercial)</a></li>

							<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalRelLucroPagas">Demonstrativo Comercial (Lucro Vendas Pagas)</a></li>

							<li><a class="dropdown-item" href="../relatorios/produtos_class.php" target="_blank">Produtos</a>

								


							</ul>
						</li>



					</ul>
					<div class="d-flex mr-4">
						<img class="img-profile rounded-circle" src="../img/user.jpg" width="40px" height="40px">

						<ul class="navbar-nav">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<?php echo @$nome_usuario; ?>
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
									<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPerfil">Editar Dados</a></li>

									<li><hr class="dropdown-divider"></li>
									<li><a class="dropdown-item" href="../logout.php">Sair</a></li>
								</ul>
							</li>
						</ul>

					</div>
				</div>
			</div>
		</nav>







		<div class="container-fluid mb-4 mx-4">
			<?php 		
			require_once($pag.'.php');
			?>
		</div>





	</body>
	</html>




	<!-- Modal -->
	<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Editar Dados</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="form-perfil" method="post">
					<div class="modal-body">

						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Nome</label>
							<input type="text" class="form-control" name="nome-usuario" placeholder="Nome" value="<?php echo $nome_usuario ?>">
						</div>

						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Email</label>
							<input type="email" class="form-control" name="email-usuario" placeholder="Email" value="<?php echo $email_usuario ?>">
						</div>

						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Senha</label>
							<input type="text" class="form-control" name="senha-usuario" placeholder="Senha" value="<?php echo $senha_usuario ?>">
						</div>

						<small><div id="mensagem-perfil" align="center"></div></small>

						<input type="hidden" class="form-control" name="id-usuario"  value="<?php echo $id_usuario ?>">


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-perfil">Fechar</button>
						<button type="submit" class="btn btn-primary">Salvar</button>
					</div>
				</form>
			</div>
		</div>
	</div>





	<!-- Modal Rel Mov -->
	<div class="modal fade" id="modalRelMov" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Relatório de Movimentações 
						<span class="mx-4"><small><small><small><b>Período:</b>

							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $dataOntem ?>', '<?php echo $dataOntem ?>')" class="text-dark"> Ontem </a> /
							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $data_inicial_mes_atual ?>', '<?php echo $data_atual ?>')" class="text-dark"> Mês Atual</a> / 
							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $data_inicial_mes_ant ?>', '<?php echo $data_final_mes_ant ?>')" class="text-dark">Mês Anterior</a> /
							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $data_atual ?>', '<?php echo $data_atual ?>')" class="text-dark">Hoje</a>

						</small></small></small></span></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post" action="../relatorios/mov_class.php" target="_blank">
						<div class="modal-body">

							<div class="row">
								<div class="col-md-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Tipo <small><small>(Despesas, Contas, etc)</small></small></label>
										<select class="form-select form-select-sm" aria-label="Default select example" name="tipo-rel" id="tipo-rel">
											<option value="">Todas</option>
											<option value="Conta à Pagar">Contas à Pagar</option>
											<option value="Conta à Receber">Contas à Receber</option>
											<option value="Venda">Venda</option>
											<option value="Compra">Compra</option>
											<option value="Despesa">Despesa</option>
											<option value="Transferência">Transferência</option>
											<option value="Receita">Receita</option>

										</select>
									</div>
								</div>

								<div class="col-md-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Data Inicial </label>
										<input type="date" class="form-control form-control-sm" name="data-inicial-rel"  id="data-inicial-rel" value="<?php echo date('Y-m-d') ?>">
									</div>
								</div>

								<div class="col-md-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Data Final </label>
										<input type="date" class="form-control form-control-sm" name="data-final-rel"  id="data-final-rel" value="<?php echo date('Y-m-d') ?>">
									</div>
								</div>


								<div class="col-md-3 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Local Movimentação</label>
										<select class="form-select" aria-label="Default select example" name="local-mov" id="local-mov">
											<option value="Caixa">Caixa (Movimento)</option>
											<option value="Cartão de Débito">Cartão de Débito</option>
											<option value="Cartão de Crédito">Cartão de Crédito</option>
											
											<?php 
											$query = $pdo->query("SELECT * FROM bancos order by nome asc");
											$res = $query->fetchAll(PDO::FETCH_ASSOC);
											for($i=0; $i < @count($res); $i++){
												foreach ($res[$i] as $key => $value){	}
													$id_item = $res[$i]['id'];
												$nome_item = $res[$i]['nome'];
												?>
												<option value="<?php echo $nome_item ?>"><?php echo $nome_item ?></option>

											<?php } ?>


										</select>
									</div>
								</div>


							</div>




							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Plano de Conta</label>
										<select class="form-select form-select-sm" aria-label="Default select example" name="cat-despesas-rel" id="cat-despesas-rel">
											<option value="">Todas</option>
											<?php 
											$query = $pdo->query("SELECT * FROM cat_despesas order by nome asc");
											$res = $query->fetchAll(PDO::FETCH_ASSOC);
											for($i=0; $i < @count($res); $i++){
												foreach ($res[$i] as $key => $value){	}
													$id_item = $res[$i]['id'];
												$nome_item = $res[$i]['nome'];
												?>
												<option value="<?php echo $nome_item ?>"><?php echo $nome_item ?></option>

											<?php } ?>


										</select>
									</div>
								</div>


								<div class="col-md-3 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Sub Cat Plano Conta</label>
										<div id="listar-despesas-rel">

										</div>
										
									</div>
								</div>


								<div class="col-md-3 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Forma de Pagamento</label>
										<select class="form-select form-select-sm" aria-label="Default select example" name="pgto-rel" id="pgto-rel">
											<option value="">Todas</option>
											<option value="Dinheiro">Dinheiro</option>
											<option value="Boleto">Boleto</option>
											<option value="Cheque">Cheque</option>
											<option value="Conta Corrente">Conta Corrente</option>
											<option value="Conta Poupança">Conta Poupança</option>
											<option value="Carnê">Carnê</option>
											<option value="DARF">DARF</option>
											<option value="Depósito">Depósito</option>
											<option value="Transferência">Transferência</option>
											<option value="Pix">Pix</option>

										</select>
									</div>
								</div>


								<div class="col-md-3 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Entrada / Saída</label>
										<select class="form-select form-select-sm" aria-label="Default select example" name="tipo-mov" id="tipo-mov">
											<option value="">Todas</option>
											<option value="Entrada">Entradas</option>
											<option value="Saída">Saídas</option>
										</select>
									</div>
								</div>



							</div>




						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-perfil">Fechar</button>
							<button type="submit" class="btn btn-primary">Gerar</button>
						</div>
					</form>
				</div>
			</div>
		</div>







	<!-- Modal Rel Mov -->
	<div class="modal fade" id="modalRelLucro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Relatório de Lucro de Vendas 
						<span class="mx-4"><small><small><small><b>Período:</b>

							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $dataOntem ?>', '<?php echo $dataOntem ?>')" class="text-dark"> Ontem </a> /
							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $data_inicial_mes_atual ?>', '<?php echo $data_atual ?>')" class="text-dark"> Mês Atual</a> / 
							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $data_inicial_mes_ant ?>', '<?php echo $data_final_mes_ant ?>')" class="text-dark">Mês Anterior</a> /
							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $data_atual ?>', '<?php echo $data_atual ?>')" class="text-dark">Hoje</a>

						</small></small></small></span></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post" action="../relatorios/lucro_class.php" target="_blank">
						<div class="modal-body">

							<div class="row">
								
								<div class="col-md-6">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Data Inicial </label>
										<input type="date" class="form-control form-control-sm" name="data-inicial-rel-lucro"  id="data-inicial-rel-lucro" value="<?php echo date('Y-m-d') ?>">
									</div>
								</div>

								<div class="col-md-6">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Data Final </label>
										<input type="date" class="form-control form-control-sm" name="data-final-rel-lucro"  id="data-final-rel-lucro" value="<?php echo date('Y-m-d') ?>">
									</div>
								</div>
								

							</div>



						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-perfil">Fechar</button>
							<button type="submit" class="btn btn-primary">Gerar</button>
						</div>
					</form>
				</div>
			</div>
		</div>








	<!-- Modal Rel Mov -->
	<div class="modal fade" id="modalRelLucroPagas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Relatório de Lucro de Vendas 
						<span class="mx-4"><small><small><small><b>Período:</b>

							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $dataOntem ?>', '<?php echo $dataOntem ?>')" class="text-dark"> Ontem </a> /
							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $data_inicial_mes_atual ?>', '<?php echo $data_atual ?>')" class="text-dark"> Mês Atual</a> / 
							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $data_inicial_mes_ant ?>', '<?php echo $data_final_mes_ant ?>')" class="text-dark">Mês Anterior</a> /
							<a class="text-dark" href="#" onclick="mudarDataRel('<?php echo $data_atual ?>', '<?php echo $data_atual ?>')" class="text-dark">Hoje</a>

						</small></small></small></span></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post" action="../relatorios/lucroPagas_class.php" target="_blank">
						<div class="modal-body">

							<div class="row">
								
								<div class="col-md-6">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Data Inicial </label>
										<input type="date" class="form-control form-control-sm" name="data-inicial-rel-lucro"  id="data-inicial-rel-lucroP" value="<?php echo date('Y-m-d') ?>">
									</div>
								</div>

								<div class="col-md-6">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Data Final </label>
										<input type="date" class="form-control form-control-sm" name="data-final-rel-lucro"  id="data-final-rel-lucroP" value="<?php echo date('Y-m-d') ?>">
									</div>
								</div>
								

							</div>



						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-perfil">Fechar</button>
							<button type="submit" class="btn btn-primary">Gerar</button>
						</div>
					</form>
				</div>
			</div>
		</div>






		<!-- Mascaras JS -->
		<script type="text/javascript" src="../js/mascaras.js"></script>

		<!-- Ajax para funcionar Mascaras JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 


		<!-- Ajax para inserir ou editar dados -->
		<script type="text/javascript">


			$(document).ready(function() {
				var cat = $('#cat-despesas-rel').val();
				console.log(cat)
				listarDespesasRel(cat, '');

				$('#cat-despesas-rel').change(function(){
					var cat = $(this).val();
					listarDespesasRel(cat);
				});

			});


			$("#form-perfil").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);

				$.ajax({
					url: "editar-perfil.php",
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem-perfil').removeClass()
						if (mensagem.trim() == "Salvo com Sucesso") {
                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar-perfil').click();
                    window.location = "index.php";
                } else {
                	$('#mensagem-perfil').addClass('text-danger')
                }

                $('#mensagem-perfil').text(mensagem)
            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

			});




			function mudarDataRel(data, data2){
				$("#data-inicial-rel").val(data);
				$("#data-final-rel").val(data2);

				$("#data-inicial-rel-lucro").val(data);
				$("#data-final-rel-lucro").val(data2);

				$("#data-inicial-rel-lucroP").val(data);
				$("#data-final-rel-lucroP").val(data2);
			}





			function listarDespesasRel(cat, despesa){

				$.ajax({
					url: "listar-despesas.php",
					method: 'POST',
					data: {cat, despesa},
					dataType: "text",

					success:function(result){
						$("#listar-despesas-rel").html(result);
					}

				});
			}

		</script>


