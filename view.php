<?php
require_once 'config.php';
session_start();

if (!isset($_COOKIE['logado']))
    header('location: login.php');

$email = $_REQUEST['uid'];
$result = procura("uid=$email,ou=People,dc=intranet,dc=cm,dc=net", "cn=*");
array_shift($result);
$keys = array_keys($result[0]);
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
                <li><a href="cadastro.php">Cadastro</a></li>
                <li class="active"><a href="login.php">Admin</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="starter-template">
        <?php if (isset($result[0]['validado'][0])) { ?>
            <div class="alert alert-success">
                <strong>Conta ativada!</strong>
            </div>
        <?php } else {?>
            <div class="alert alert-warning">
                <strong>Essa conta ainda não foi ativada!</strong>
            </div>
        <?php }?>
        <ul class="list-unstyled">
            <li><strong>Ativo: </strong><?= isset($result[0]['validado'][0])?'Sim' : 'Não' ?></li>
            <li><strong>Nome: </strong><?= $result[0]['cn'][0] ?></li>
            <li><strong>Email: </strong><?= $result[0]['mail'][0] ?></li>
            <li><strong>Telefone 1: </strong><?= isset($result[0]['mobile'][0])?$result[0]['mobile'][0] : '' ?></li>
            <li><strong>Telefone 2: </strong><?= isset($result[0]['homephone'][0])?$result[0]['homephone'][0] : '' ?></li>
            <li><strong>Endereço: </strong><?= isset($result[0]['homepostaladdress'][0])?$result[0]['homepostaladdress'][0] : '' ?></li>
            <li><strong>CEP: </strong><?= isset($result[0]['postalcode'][0])?$result[0]['postalcode'][0] : '' ?></li>
            <li><strong>Data de Nascimento: </strong><?= $result[0]['birthdate'][0] ?></li>
            <li><strong>Categoria: </strong><?= $result[0]['categoria'][0] ?></li>
            <li><strong>Escola: </strong><?= isset($result[0]['escola'][0])?$result[0]['escola'][0] : '' ?></li>
            <li><strong>Série: </strong><?= isset($result[0]['serie'][0])?$result[0]['serie'][0] : '' ?></li>
        </ul>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>

</html>
