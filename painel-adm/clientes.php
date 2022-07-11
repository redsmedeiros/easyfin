<?php 
require_once("../conexao.php");
require_once("verificar.php");
$pagina = 'clientes';

$data_atual = date('Y-m-d');
$hora_atual = date('H:i:s');

$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_mes = $ano_atual."-".$mes_atual."-01";
$data_ano = $ano_atual."-01-01";

if($mes_atual == '01' || $mes_atual == '03' || $mes_atual == '05' || $mes_atual == '07' || $mes_atual == '08' || $mes_atual == '10' || $mes_atual == '12'){
	$data_mes_fin = $ano_atual."-".$mes_atual."-31";
}else if($mes_atual == '02'){
	$data_mes_fin = $ano_atual."-".$mes_atual."-28";
}else{
	$data_mes_fin = $ano_atual."-".$mes_atual."-30";
}


$data_ano_fin = $ano_atual."-12-31";

require_once($pagina."/campos.php");

?>

<div class="col-md-12 my-3">
	<a href="#" onclick="inserir()" type="button" class="btn btn-dark btn-sm">Novo Cliente</a>

	<small class="mx-4">
			<a title="Todos" class="text-muted" href="#" onclick="listar()"><span>Todos</span></a> / 
			<a title="Débitos" class="text-muted" href="#" onclick="listarDebitos()"><span>Débitos</span></a> / 
			
		</small>
</div>

<small>
	<div class="tabela bg-light" id="listar">

	</div>
</small>



<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Inserir Registro</span></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form" method="post">
				<div class="modal-body">

					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button" role="tab" aria-controls="home" aria-selected="true">Dados Pessoais</a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#contas" type="button" role="tab" aria-controls="profile" aria-selected="false">Dados Bancários</a>
						</li>
						
					</ul>
					
					<hr>

					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="home-tab">

							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label"><?php echo $campo1 ?></label>
										<input type="text" class="form-control" name="<?php echo $campo1 ?>" placeholder="<?php echo $campo1 ?>" id="<?php echo $campo1 ?>" required>
									</div>
								</div>

								<div class="col-md-2 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label"><?php echo $campo2 ?></label>
										<select class="form-select" aria-label="Default select example" name="<?php echo $campo2 ?>" id="<?php echo $campo2 ?>">
											<option value="Física">Física</option>
											<option value="Jurídica">Jurídica</option>

										</select>
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">CPF / CNPJ</label>
										<input type="text" class="form-control" name="<?php echo $campo3 ?>" id="<?php echo $campo3 ?>" required>
									</div>
								</div>

								<div class="col-md-4 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label"><?php echo $campo11 ?></label>
										<input type="text" class="form-control" name="<?php echo $campo11 ?>" id="<?php echo $campo11 ?>" placeholder="<?php echo $campo11 ?>">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label"><?php echo $campo4 ?></label>
										<input type="text" class="form-control" name="<?php echo $campo4 ?>" placeholder="<?php echo $campo4 ?>" id="<?php echo $campo4 ?>" required>
									</div>
								</div>


								<div class="col-md-7 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label"><?php echo $campo5 ?></label>
										<input type="text" class="form-control" name="<?php echo $campo5 ?>" placeholder="<?php echo $campo5 ?>" id="<?php echo $campo5 ?>">
									</div>
								</div>


								<div class="col-md-2 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label"><?php echo $campo6 ?></label>
										<select class="form-select" aria-label="Default select example" name="<?php echo $campo6 ?>" id="<?php echo $campo6 ?>">
											<option value="Sim">Sim</option>
											<option value="Não">Não</option>

										</select>
									</div>
								</div>

							</div>

							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Observações</label>
								<textarea maxlength="100" class="form-control" name="<?php echo $campo7 ?>" id="<?php echo $campo7 ?>"></textarea>
							</div>


						</div>

						<div class="tab-pane fade" id="contas" role="tabpanel" aria-labelledby="profile-tab">

							<div class="row">
								<div class="col-md-4 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label"><?php echo $campo8 ?> </label>
										<select class="form-select" aria-label="Default select example" name="<?php echo $campo8 ?>" id="<?php echo $campo8 ?>">
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

								<div class="col-md-4 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label"><?php echo $campo9 ?></label>
										<input type="text" class="form-control" name="<?php echo $campo9 ?>" placeholder="<?php echo $campo9 ?> Traço e Dígito" id="<?php echo $campo9 ?>" >
									</div>
								</div>

								
								<div class="col-md-4 col-sm-12">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label"><?php echo $campo10 ?></label>
										<input type="text" class="form-control" name="<?php echo $campo10 ?>" id="<?php echo $campo10 ?>" placeholder="<?php echo $campo10 ?> Corrente 012356-1" >
									</div>
								</div>
							</div>

						</div>
						
					</div>

					
					
					<small><div id="mensagem" align="center"></div></small>

					<input type="hidden" class="form-control" name="id"  id="id">


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar">Fechar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>




<!-- Modal -->
<div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Excluir Registro</span></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-excluir" method="post">
				<div class="modal-body">

					Deseja Realmente excluir este Registro: <span id="nome-excluido"></span>?

					<small><div id="mensagem-excluir" align="center"></div></small>

					<input type="hidden" class="form-control" name="id-excluir"  id="id-excluir">


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-excluir">Fechar</button>
					<button type="submit" class="btn btn-danger">Excluir</button>
				</div>
			</form>
		</div>
	</div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cliente <span id="campo1"></span></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
				<div class="modal-body">
					<small>
					
					
						<span><b><?php echo $campo2 ?>:</b> <span id="campo2"></span></span>
						<span class="mx-4"><b>CPF / CNPJ:</b> <span id="campo3" ></span>
						</span>	
						<hr style="margin:6px;">

						<span><b><?php echo $campo4 ?>:</b> <span id="campo4"></span></span>
						<span class="mx-4"><b><?php echo $campo11 ?>:</b> <span id="campo11" ></span>
						</span>	
						<hr style="margin:6px;">

						<span><b><?php echo $campo5 ?>:</b> <span id="campo5" ></span>
						</span>	
						<hr style="margin:6px;">

						<span><b><?php echo $campo6 ?>:</b> <span id="campo6"></span></span>
						<span class="mx-4"><b><?php echo $campo7 ?>:</b> <span id="campo7" ></span>
						</span>	
						<hr style="margin:6px;">

						<span><b><?php echo $campo8 ?>:</b> <span id="campo8"></span></span>
						<span class="mx-4"><b><?php echo $campo9 ?>:</b> <span id="campo9" ></span>
						</span>	
						<span class="mx-4"><b><?php echo $campo10 ?>:</b> <span id="campo10"></span></span>
						<hr style="margin:6px;">


						
						
						

					</small>


				</div>
				
		</div>
	</div>
</div>








<div class="modal fade" id="modalRel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Relatório de Contas <small><small>(
										<a href="#" class="text-primary" onclick="datas('1980-01-01', '2100-01-01', 'tudo-fin', 'fin')">
											<span id="tudo-fin">Tudo</span>
										</a> / 
									<a href="#" class="text-dark" onclick="datas('<?php echo $data_atual ?>', '<?php echo $data_atual ?>', 'hoje-fin', 'fin')">
											<span id="hoje-fin">Hoje</span>
										</a> /
										<a href="#" class="text-dark" onclick="datas('<?php echo $data_mes ?>', '<?php echo $data_mes_fin ?>', 'mes-fin', 'fin')">
											<span id="mes-fin">Mês</span>
										</a> /
										<a href="#" class="text-dark" onclick="datas('<?php echo $data_ano ?>', '<?php echo $data_ano_fin ?>', 'ano-fin', 'fin')">
											<span id="ano-fin">Ano</span>
										</a> 
									)</small></small></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="post" action="../relatorios/contasCliente_class.php" target="_blank">
				<div class="modal-body">
					<div class="row">

						
						<div class="col-md-4">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Status Contas</label>
									<select class="form-select form-select-sm" aria-label="Default select example" name="status" id="status">  
										<option value="">Todas</option>
										<option value="Debitos">Débitos</option>
										<option value="Pendente">Pendentes</option>
										<option value="Paga">Pagas</option>
										
									</select>
								</div>
						</div>


					
						<div class="col-md-4">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Data Inicial (Vencimento)</label>
									<input type="date" class="form-control form-control-sm" name="dataInicial" id="dtInicial" value="1980-01-01">
								</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Data Final (Vencimento)</label>
									<input type="date" class="form-control form-control-sm"  name="dataFinal" id="dtFinal" value="2100-01-01">
								</div>
						</div>

						<input type="hidden" name="id-cli" id="id-cli">
					</div>

										
				</div>
			
			<small><div align="center" id="msg-config"></div></small>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-config">Fechar</button>
				<button type="submit" class="btn btn-primary">Gerar Relatório</button>
			</div>
		</form>
	</div>
</div>
</div>



<script type="text/javascript">var pag = "<?=$pagina?>"</script>
<script src="../js/ajax.js"></script>


<script>
	$(document).ready(function() {
		$('#<?=$campo3?>').mask('000.000.000-00');
		$('#<?=$campo3?>').attr('placeholder','CPF');

		$('#<?=$campo2?>').change(function(){
			if($(this).val() == 'Física'){
				$('#<?=$campo3?>').mask('000.000.000-00');
				$('#<?=$campo3?>').attr('placeholder','CPF');
			}else{
				$('#<?=$campo3?>').mask('00.000.000/0000-00');
				$('#<?=$campo3?>').attr('placeholder','CNPJ');
			}
		});


	});



	function listar(){
	    $.ajax({
	        url: pag + "/listar.php",
	        method: 'POST',
	        data: $('#form').serialize(),
	        dataType: "html",

	        success:function(result){
	            $("#listar").html(result);
	        }
	    });
	}


	function listarDebitos(){
		
	    $.ajax({
	        url: pag + "/listar-debitos.php",
	        method: 'POST',
	        data: $('#form').serialize(),
	        dataType: "html",

	        success:function(result){
	            $("#listar").html(result);
	        }
	    });
	}


	function relatorio(id){
	$('#id-cli').val(id);
    var myModal = new bootstrap.Modal(document.getElementById('modalRel'), {       });
    myModal.show();
    
	}
	
</script>



<script type="text/javascript">
	function datas(data, datafin, id, campo){
		var data_atual = "<?=$data_atual?>";
		$('#dtInicial').val(data);
		$('#dtFinal').val(datafin);

		document.getElementById('hoje-'+campo).style.color = "#000";
		document.getElementById('tudo-'+campo).style.color = "#000";
		document.getElementById('mes-'+campo).style.color = "#000";
		document.getElementById('ano-'+campo).style.color = "#000";
		document.getElementById(id).style.color = "blue";		
	}
</script>