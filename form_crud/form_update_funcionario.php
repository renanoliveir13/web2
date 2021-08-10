<?php
// Arquivo conexao.php
require_once '../conexao/conexao.php';
// Arquivo classe_usuario.php
require_once '../classe/classe_usuario.php';
// Inicio da sessao

$u = new Usuario();
$u->Verificar();


//Retorna para a listagem caso o parametro 'id' não existir ou estiver vazio
if (empty($_GET['id'])) {
	header('Location: /web/form_crud/form_select_funcionario.php');
}

try {
	// Query que seleciona os dados do registro
	$query = $conexao->prepare("SELECT * FROM funcionario WHERE cd_funcionario = :id");
	$query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
	// Executa a operacao
	$query->execute();
	// Resulta em uma matriz
	$dados = $query->fetch(PDO::FETCH_ASSOC);

	//Verifica se houve retorno na query, se não, o cadastro não é válido e retorna o usuário para tela de listagem
	if (empty($dados)) {
		header('Location: /web/form_crud/form_select_funcionario.php');
	}
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
	<title>Atualizar funcionário</title>
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
									<h4 class="card-title">Atualizar funcionário (Atalho = Alt + w)</h4>
								</div>
								<div class="card-body">
									<form method="POST" id="atu_forn" autocomplete="off" action="/web/crud/update_funcionario.php" onsubmit="exibirNome()">
										<div class="col-md-4 pl-1">
											<div class="form-group">
												<label>ID Funcionário *</label>
												<input id="cd_funcionario" readonly name="cd_funcionario" type="number" value="<?= $dados['cd_funcionario']; ?>" class="form-control" accesskey="w" title="Campo que mostra o registro do funcionário">
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label>Nome *</label>
													<input id="nome" name="nome" type="text" class="form-control" value="<?= $dados['nome']; ?>" placeholder="Ex: José da Silva" required title="Campo para atualizar o nome do funcionário">
												</div>
											</div>
											<div class="col-md-6 pl-1">
												<div class="form-group">
													<label for="exampleInputEmail1">CPF *</label>
													<input id="cpf" name="cpf" type="text" class="form-control" <?= $dados['cpf']; ?> placeholder="Ex: 123.123.123-30" required title="Campo para atualizar o CPF do funcionário">
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-md-6 pr-1">
												<div class="form-group">
													<label for="phone">Telefone *</label>
													<input type="text" class="form-control" id="telefone" name="telefone" <?= $dados['telefone']; ?> placeholder="Ex:(99) 9999-9999" pattern="(\([0-9]{2}\))\s([0-9]{0-9})?([0-9]{4})-([0-9]{4})" title="Campo para atualizar o telefone do funcionário" required="required" />
												</div>
											</div>
											<div class="col-md-6 pl-1">
												<div class="form-group">
													<label for="exampleInputEmail1">Email *</label>
													<input id="email" name="email" type="email" class="form-control" <?= $dados['email']; ?> placeholder="Ex: jose@gmail.com" required title="Campo para alterar o email do funcionário">
												</div>
											</div>
										</div>
										<?php if (!empty($_GET['error'])) { ?>

											<div class="alert alert-danger" role="alert">
												<?= $_GET['error']; ?>
											</div>
										<?php } ?>
										<a class="btn btn-danger pull-left" href="/web/form_crud/form_select_funcionario.php">Voltar</a>
										<button type="submit" name="Atualizar" class="btn btn-round btn-fill btn-info pull-right">Atualizar</button>

										<div class="clearfix"></div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>

				
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
		</form>

	</div>

</body>
<?php include(dirname(__FILE__) . '/../layout/js.php'); ?>
<script type="text/javascript" src="/web/js/funcionario/mascara_funcionario.js"></script>
<script type="text/javascript" src="/web/js/funcionario/requisicao_funcionario.js"></script>
<script type="text/javascript" src="/web/js/funcionario/senha_funcionario.js"></script>
<script type="text/javascript" src="/web/js/alerta/alerta_update.js" charset="UTF-8"></script>

</html>