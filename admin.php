<?php
require_once 'config.php';
session_start();

if (!isset($_COOKIE['logado']))
    header('location: login.php');

if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'delete')
    @deleta($_REQUEST['uid']);

$result = @procura("ou=People,dc=intranet,dc=cm,dc=net", "uid=*");
array_shift($result);
//var_dump($result);
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Email</th>
                        <th class="text-center" width="100">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($result as $pessoa) { ?>
                    <tr>
                        <td><?= $pessoa['cn'][0] ?></td>
                        <td><?= $pessoa['uid'][0] ?></td>
                        <td>
                            <a href="view.php?uid=<?= $pessoa['uid'][0] ?>"><img src="img/view.png" alt="" width="24"></a>
                            <a href="admin.php?uid=<?= $pessoa['uid'][0] ?>&act=delete"><img src="img/delete.png" alt="" width="24"></a>

                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
