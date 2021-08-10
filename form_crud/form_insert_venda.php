<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
// Inicio da sessao

$u = new Usuario();
$u->Verificar();

// Se a selecao for possivel de realizar
try {
	// Query que seleciona chave e nome do produto
	$seleciona_produto = $conexao->query("SELECT cd_produto, nome, quantidade FROM compra_produto ORDER BY cd_produto");
	// Resulta em uma matriz
	$resultado_produto = $seleciona_produto->fetchAll();

	// Query que seleciona chave e nome do cliente
	$seleciona_cliente = $conexao->query("SELECT cd_cliente, nome FROM cliente ORDER BY cd_cliente");
	// Resulta em uma matriz
	$resultado_cliente = $seleciona_cliente->fetchAll();

	// Se a selecao nao for possivel de realizar
} catch (PDOException $falha_selecao) {
	echo "A listagem de dados não foi feita" . $falha_selecao->getMessage();
	die;
} catch (Exception $falha) {
	echo "Erro não característico do PDO" . $falha->getMessage();
	die; 
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Cadastrar venda</title>
	 <link rel="stylesheet" href="/web/css/estiloBotao.css"/>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<?php include(dirname(__FILE__) . '/../layout/css.php'); ?>

</head>

<body>
	<div class="wrapper">
		<?php include(dirname(__FILE__) . '/../layout/menu.php'); ?>
		<div class="main-panel">
			<!-- Navbar -->
			<nav class="navbar navbar-expand-lg " color-on-scroll="500" style="background-color: #DCDCDC">
				<div class="container-fluid">

					<div class="collapse navbar-collapse justify-content-end" id="navigation">
						<ul class="nav navbar-nav mr-auto">
						</ul>
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span class="no-icon">SysRoupas</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<!-- fim Navbar -->
			<div class="content">

				<div class="container-fluid">
					<div class="row">
						<div class="col-md-8">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Cadastrar venda (Atalho = Alt + w)</h4>
								</div>
								<div class="card-body">
									<form method="POST" id="cad_ven" autocomplete="off" action="/web/crud/insert_venda.php" onsubmit="exibirNome()">
										<fieldset>
											<div class="campos">
												<div class="row">
													<div class="col-md-6">
													<label>Escolha o funcionário *</label>
															<select name="cd_funcionario[]" class="cd_funcionario form-control" required="" title="Caixa de seleção para escolher o funcionário" accesskey="w">
																<option title="<?= $_SESSION['nome_usuario'] ?>" value="<?= $_SESSION['id_usuario'] ?>"><?= $_SESSION['nome_usuario'] ?></option>
															</select>
													</div>
													<div class="col-md-6">
													<label> Escolha o cliente *</label>
															<select name="cd_cliente[]" class="cd_cliente form-control" required="" title="Caixa de seleção para escolher o cliente">
																<option value="" title="Por padrão a opção é vazia, escolha abaixo o cliente"> Nenhum </option>
																<?php foreach ($resultado_cliente as $v3) : ?>
																	<option title="<?= $v3['nome'] ?>" value="<?= $v3['cd_cliente'] ?>"><?= $v3['nome'] ?></option>
																<?php endforeach ?>
															</select>
													</div>
												</div>


												<div class="campo_0">
													<hr>
													<div class="produto">
														<div class="relative" style="position: relative;">
														    <label>Escolha o produto *</label>
																<select onclick="buscaDados(this)" name="cd_produto[]" class="cd_produto form-control" required="" title="Caixa de seleção para escolher o produto">
																	<option value="" title="Por padrão a opção é vazia, escolha abaixo o produto desejado"> Nenhum </option>
																	<?php foreach ($resultado_produto as $v1) : ?>
																		<option title="<?= $v1['nome'] ?>" value="<?= $v1['cd_produto'] ?>"><?= $v1['nome'] ?></option>
																	<?php endforeach ?>
																</select>
															<div class="btn btn-danger" style="position: absolute;right: 0px;top:23px">X</div>
														</div>

														<div class="row">
															<div class="col-md-6">
															    <label> Valor do item *</label>
																<input type="number" step="any" placeholder="R$0.00" pattern="\d+" name="valor_item[]" class="valor_item form-control" title="Campo para inserir o valor do produto" required="" readonly="readonly">
															</div>
															<div class="col-md-6">
															    <label> Quantidade *</label>
																<input type="number" name="quantidade[]" class="quantidade form-control" title="Campo para inserir a quantidade de produtos para venda" min="0" required="">
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php if (!empty($_GET['error'])) { ?>

												<div class="alert alert-danger" role="alert">
													<?= $_GET['error']; ?>
												</div>
											<?php } ?>
											<button class="btn btn-success btn-round btn-fill pull-left" type="button" id="adicionar">Adicionar Produto</button>

											<button class="btn btn-info btn-fill btn-round pull-right" name="Inserir" title="Botão para cadastrar a venda" onclick=""> Realizar Venda </button>

										</fieldset>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
				</form>
				
			</div>
			<footer class="footer" style="background-color: #DCDCDC">
				<div class="container-fluid">
					<nav>

						<p class="copyright text-center">
							©WEB 2
						</p>
					</nav>
				</div>
			</footer>
		</div>
		
	</div>

</body>
<?php include(dirname(__FILE__) . '/../layout/js.php'); ?>
<script type="text/javascript" src="/web/js/venda/mascara_venda.js"></script>
<script type="text/javascript" src="/web/js/venda/requisicao_produto.js"></script>

<script type="text/javascript" src="/web/js/script.js"></script>

</html>