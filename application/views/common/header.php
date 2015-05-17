<!DOCTYPE html>
<body>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mesas | SG</title>
        <!-- Google Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
            <!-- Bootstrap -->
            <link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
            <!-- Bootstrap Datepicker -->
            <link href="<?=base_url('assets/css/bootstrap-datetimepicker.min.css')?>" rel="stylesheet">
            <!-- Custom Style -->
            <link rel="stylesheet" href="<?=base_url('assets/css/style.css')?>">

        </head>
        <body>
            <nav class="navbar navbar-inverse" role="navigation">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?=base_url('/')?>">Ordenes</a>
                    </li>
                    <div class="dropdown">
                      <button class="btn btn-custom-dropdown dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        Administrar
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?=base_url('productos')?>">
                                <span class="glyphicon glyphicon-glass"></span> Productos
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?=base_url('mesas')?>">
                                <span class="glyphicon glyphicon-th"></span> Mesas
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?=base_url('cuentas')?>">
                                <span class="glyphicon glyphicon-usd"></span> Cuentas
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?=base_url('categorias')?>">
                                <span class="glyphicon glyphicon-list"></span> Categorias
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?=base_url('descuento')?>">
                                <span class="glyphicon glyphicon-star"></span> Descuento
                            </a>
                        </li>
                      </ul>
                    </div>
                </ul>
            </nav>