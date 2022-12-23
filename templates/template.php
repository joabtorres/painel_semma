<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo NAME_PROJECT ?> </title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/fontawesome/css/regular.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/fontawesome/css/solid.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/fontawesome/css/brands.min.css" />
    <script src="<?php echo BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/css/style.css" />
    <script src="<?php echo BASE_URL ?>assets/js/jquery-3.6.3.min.js"></script>
</head>

<body>

    <div class="offcanvas offcanvas-start d-flex flex-column flex-shrink-0 p-3 bg-light" tabindex="-1" id="sidebar"
        aria-labelledby="offcanvasExampleLabel" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <img src="https://github.com/mdo.png" alt="" width="50" height="50" class="rounded-circle me-2">
            <span class="fs-5">Joab Torres</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="<?php BASE_URL ?>" class="nav-link" aria-current="page">
                    <i class="fa-solid fa-mug-hot me-1"></i>
                    Página Inícial
                </a>
            </li>
            <li>
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#colapseLegislacao"
                    aria-expanded="false" aria-controls="colapseLegislacao">
                    <i class="fa-solid fa-landmark me-1"></i>
                    Legislação
                </a>
                <ul class="collapse" id="colapseLegislacao">
                    <li> <a href="#"><i class="fa-regular fa-square-plus me-1 ms-3"></i> Cadastrar</a></li>
                    <li> <a href="#"><i class="fa-solid fa-magnifying-glass me-1 ms-3"></i>Consultar</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#colapseFormulario"
                    aria-expanded="false" aria-controls="colapseFormulario">
                    <i class="fa-solid fa-folder-tree me-1"></i>
                    Formulários
                </a>
                <ul class="collapse" id="colapseFormulario">
                    <li> <a href="#"><i class="fa-regular fa-square-plus me-1 ms-3"></i> Cadastrar</a></li>
                    <li> <a href="#"><i class="fa-solid fa-magnifying-glass me-1 ms-3"></i>Consultar</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#colapseLicenca"
                    aria-expanded="false" aria-controls="colapseLicenca">
                    <i class="fa-solid fa-file-circle-check  me-1"></i>
                    Licenças Emitidas
                </a>
                <ul class="collapse" id="colapseLicenca">
                    <li> <a href="#"><i class="fa-regular fa-square-plus me-1 ms-3"></i> Cadastrar</a></li>
                    <li> <a href="#"><i class="fa-solid fa-magnifying-glass me-1 ms-3"></i>Consultar</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#colapseTR" aria-expanded="false"
                    aria-controls="colapseTR">
                    <i class="fa-solid fa-file-pdf me-1"></i>
                    Termos de Refêrencias
                </a>
                <ul class="collapse" id="colapseTR">
                    <li> <a href="#"><i class="fa-regular fa-square-plus me-1 ms-3"></i> Cadastrar</a></li>
                    <li> <a href="#"><i class="fa-solid fa-magnifying-glass me-1 ms-3"></i>Consultar</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#colapseUsuarios"
                    aria-expanded="false" aria-controls="colapseUsuarios">
                    <i class="fa-solid fa-users me-1"></i>
                    Usuários
                </a>
                <ul class="collapse" id="colapseUsuarios">
                    <li> <a href="#"><i class="fa-regular fa-square-plus me-1 ms-3"></i> Cadastrar</a></li>
                    <li> <a href="#"><i class="fa-solid fa-magnifying-glass me-1 ms-3"></i>Consultar</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?php BASE_URL ?>sair" class="nav-link" aria-current="page">
                    <i class="fa-solid fa-arrow-right-from-bracket me-1"></i>
                    Sair
                </a>
            </li>
        </ul>
        <footer class="text-center ">
            <hr />
            <p class="text-muted">&copy; Copyright 2022 <br /> <a href="http://joabtorres.com.br" target="_blank"
                    class="text-decoration-none">Joab Torres Alencar</a></p>
        </footer>
    </div>
    <div id="content">
        <nav class="navbar navbar-expand-lg shadow bg-light rounded">
            <div class="container-fluid">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                    aria-controls="sidebar">
                    <i class="fa-solid fa-bars"></i> Menu
                </button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php template::getInstance()->loadViewInTemplate($viewName, $viewData); ?>
    </div>
    <script src="<?php echo BASE_URL ?>assets/js/script.js"></script>
</body>

</html>