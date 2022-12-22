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
    <div id="telaLogin" class="d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <img class="img-fluid mb-2" src="<?php echo BASE_URL ?>assets/image/logo-semma.png" />
                    <p class="text-center text-uppercase mb-3 mt-0"><?php echo NAME_PROJECT ?></p>
                    <form class="g-3 needs-validation" novalidat method="POST" name="nFormLogin">
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-primary text-white" for="iUsuario"><i
                                    class="fa fa-user"></i></span>
                            <input type="text" class="form-control border-primary" placeholder="Usuario" id="iUsuario"
                                name="nUsuario" required>
                            <div class="invalid-feedback text-end">
                                Informe o usuário
                            </div>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-primary text-white"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control border-primary" placeholder="Senha" name="nSenha"
                                id="iSenha" required>
                            <div class="invalid-feedback text-end">
                                Informe a senha
                            </div>
                        </div>
                        <?php $erro = true;
                        if (isset($erro)) { ?>
                        <div class="alert bg-danger text-white alert-dismissible fade show" role="alert">
                            Usuariio incorreto!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>
                        <div class="mb-2 text-end">
                            <button type="button" class="btn btn-link small text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#modalNovaSenha"> Gerar nova senha</button>
                        </div>
                        <div class="d-grid text-start">
                            <button class="btn btn-primary" name="nLogar" value="Sim" onclick="validarFormLogin()"><i
                                    class="fa-solid fa-arrow-right-to-bracket"></i> Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer id="rodape">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <p class="mt-5 mb-3 text-muted">&copy; Copyright 2022 <br /> <a
                            href="http://joabtorres.com.br" target="_blank" class="text-decoration-none">Joab Torres Alencar</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal -->
    <div class="modal fade" id="modalNovaSenha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa fa-user"></i> Esqueceu a senha?
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">Forneça o endereço de email usado em sua conta do <?php echo NAME_PROJECT ?>.
                            </p>
                            <p>Será enviado um e-mail que redefine a sua senha.</p>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" name="formNewPassword">
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-primary text-white" for="iEmail"><i
                                            class="fa-solid fa-envelope"></i></span>
                                    <input type="text" class="form-control border-primary" placeholder="Email"
                                        id="iEmail" name="nEmail" required>
                                    <div class="invalid-feedback">
                                        Informe o email
                                    </div>
                                </div>
                                <div class="mt-2 text-end">
                                    <button class="btn btn-primary" name="nNovaSenha" value="Sim"
                                        onclick="validarFormNewPassword()"><i class="fa-solid fa-check"></i> Gerar nova
                                        senha </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalEmailError" tabindex="-1" aria-labelledby="emodalEmailError" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="emodalEmailError"><i class="fa-solid fa-triangle-exclamation"></i> Aviso
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Não foi informado um email válido.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEmailSuccess" tabindex="-1" aria-labelledby="emodalEmailSuccess"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="emodalEmailSuccess"><i class="fa-solid fa-check-to-slot"></i>
                        Confirmação
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Uma nova senha foi gerada, confira na caixa postal do e-mail solicitado.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo BASE_URL ?>assets/js/script.js"></script>
</body>

</html>