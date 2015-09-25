<?php
require_once 'config.php';




if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $result = procura("ou=People,dc=intranet,dc=cm,dc=net","uid={$_REQUEST['email']}");



    if ($result['count'] == 0) {
//        var_dump($result['count']); exit;
        $data['objectClass'][0] = 'userControl';
        $data['objectClass'][1] = 'inetOrgPerson';
//        $data['objectClass'][2] = 'PosixAccount';

        $data['cn'] = $data['sn'] = $_REQUEST['nome'];
        $data['uid'] = $data['mail'] = $_REQUEST['email'];

        $data['mobile'] = $_REQUEST['telefone'];
        $data['homePhone'] = $_REQUEST['telefone2'];
        $data['homePostalAddress'] = $_REQUEST['endereco'];
        $data['postalCode'] = $_REQUEST['cep'];
        $data['senha'] = md5($_REQUEST['senha']);
        $data['birthdate'] = $_REQUEST['nascimento'];

        $data['categoria'] = $_REQUEST['categoria'];
        if ($_REQUEST['categoria'] != 'nenhuma') {
            $data['serie'] = $_REQUEST['serie'];
            $data['escola'] = $_REQUEST['escola'];
        }

        $add = adiciona($data);
        email($data);
    } else
        $erro = 1;

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login Único CM</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <style>
        body {
            padding-top: 50px;
        }
        .starter-template {
            padding: 40px 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Login Único CM</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="cadastro.php">Cadastro</a></li>
                <li><a href="login.php">Admin</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="starter-template">
        <?php if (isset($erro)) { ?>
            <div class="alert alert-danger">
                <strong>Erro!</strong> Este e-mail já foi cadastrado anteriormente
            </div>
        <?php } ?>

        <?php if (isset($add) && $add == true) { ?>
            <div class="alert alert-success">
                <strong>Sucesso!</strong> Você receberá um e-mail em instantes para ativar sua conta.
            </div>
        <?php } ?>

        <form class="form-horizontal" action="#" method="post">
            <fieldset>
                <!-- Nome Completo -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nome">Nome</label>
                    <div class="col-md-4">
                        <input name="nome" class="form-control input-md" id="nome" required="" type="text">
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="email">E-mail</label>
                    <div class="col-md-4">
                        <input name="email" class="form-control input-md" id="email" required="" type="text">
                        <span class="help-block">Somente letras e digitos</span>
                    </div>
                </div>

                <!-- Senha -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="senha">Senha</label>
                    <div class="col-md-4">
                        <input name="senha" class="form-control input-md" id="senha" required="" type="password">

                    </div>
                </div>

                <!-- Telefone 1 -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="telefone">Telefone</label>
                    <div class="col-md-4">
                        <input data-mask="000000000" name="telefone" class="form-control input-md" id="telefone" required="" type="text">
                        <span class="help-block">Apenas dígitos</span>
                    </div>
                </div>

                <!-- Telefone 2 -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="telefone2">Telefone 2</label>
                    <div class="col-md-4">
                        <input data-mask="000000000" name="telefone2" class="form-control input-md" id="telefone2" type="text">
                        <span class="help-block">Apenas dígitos</span>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="endereco">Endereço</label>
                    <div class="col-md-4">
                        <input name="endereco" class="form-control input-md" id="endereco" type="text">
                        <span class="help-block">Ex.: Rua Teodoro Sampaio, 88</span>
                    </div>
                </div>

                <!-- CEP -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="cep">CEP</label>
                    <div class="col-md-4">
                        <input data-mask="00000-000" name="cep" class="form-control input-md" id="cep" type="text">
                        <span class="help-block">Apenas dígitos</span>
                    </div>
                </div>

                <!-- Data de Nascimento -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nascimento">Data de Nascimento</label>
                    <div class="col-md-4">
                        <input data-mask="00/00/0000" name="nascimento" class="form-control input-md" id="nascimento" required="" type="text">
                        <span class="help-block">Apenas dígitos</span>
                    </div>
                </div>

                <!-- É estudante? -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="categoria">Categoria</label>
                    <div class="col-md-4">
                        <select name="categoria" id="categoria">
                            <option value="estudante">Estudante</option>
                            <option value="professor">Professor</option>
                            <option value="nenhuma" selected="selected">Nenhuma</option>
                        </select>
                    </div>
                </div>

                <!-- Escola -->
                <div class="form-group escola">
                    <label class="col-md-4 control-label" for="escola">Nome da escola</label>
                    <div class="col-md-4">
                        <input name="escola" class="form-control input-md" id="escola" type="text">
                    </div>
                </div>

                <!-- Serie -->
                <div class="form-group serie">
                    <label class="col-md-4 control-label" for="serie">Qual série?</label>
                    <div class="col-md-4">
                        <select name="serie" id="">
                            <option value="1">1ª Série</option>
                            <option value="2">2ª Série</option>
                            <option value="3">3ª Série</option>
                            <option value="4">4ª Série</option>
                            <option value="5">5ª Série</option>
                            <option value="6">6ª Série</option>
                            <option value="7">7ª Série</option>
                            <option value="8">8ª Série</option>
                            <option value="9">9ª Série</option>
                            <option value="10">1º Colegial</option>
                            <option value="11">2º Colegial</option>
                            <option value="12">3º Colegial</option>
                        </select>
                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="submit"></label>
                    <div class="col-md-4">
                        <button name="submit" class="btn btn-primary" id="submit">Enviar</button>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/mask.js"></script>
<script type="text/javascript">

    $('#categoria').change(function() {
        if ($(this).val() == 'nenhuma') {
            $('.escola, .serie').hide();
        }
        else if($(this).val() == 'estudante') {
            $('.escola, .serie').show();
        }
        else if($(this).val() == 'professor') {
            $('.escola').show();
            $('.serie').hide();
        }
    }).change();
</script>
</body>
</html>