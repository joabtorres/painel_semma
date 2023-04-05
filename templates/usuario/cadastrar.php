<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <h4 class="mb-1 ms-2">Cadastrar usuário</h4>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb p-2 rounded">
                    <li class="breadcrumb-item" aria-current="page"><a href="<?php echo BASE_URL ?>"> <i class="fa-solid fa-mug-hot me-1"></i>Página Inicial</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="<?php echo BASE_URL ?>usuario/1"> <i class="fa-solid fa-users me-1"></i> Usuários</a></li>
                    <li class="breadcrumb-item " aria-current="page "><i class="fa-regular fa-square-plus me-1"></i>
                        Cadastrar </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <?php if (!empty($arrayError))
            for ($i = 0; $i < count($arrayError['msg']); $i++) { { ?>
                <div class="col-md-12">
                    <div class="alert <?php echo $arrayError['class'] ?> text-white alert-dismissible fade show" role="alert">
                        <?php echo $arrayError['msg'][$i] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
        <?php }
            } ?>
        <form method="POST" name="nFormUsuario" enctype="multipart/form-data" id="usuario-form" autocomplete="off">
            <input type="hidden" id="iCod" value="<?php echo (!empty($arrayCad['cod'])) ? $arrayCad['cod'] : ''; ?>" name="nCod">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> <i class="fa-solid fa-users me-1"></i> Usuários</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mt-1">
                                        <label for="iNome" class="form-label">Nome: <span class="text-bg-danger"><?php echo (!empty($arrayCad['nome']['error'])) ? $arrayCad['nome']['error'] : ''; ?></span></label>
                                        <input type="text" class="form-control" id="iNome" name="nNome" placeholder="Exemplo: Joab" required value="<?php echo (!empty($arrayCad['nome'])) ? $arrayCad['nome'] : ''; ?>">
                                        <div class="invalid-feedback">
                                            Informe o nome
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <label for="iNomeCompleto" class="form-label">Nome completo:</label>
                                        <input type="text" class="form-control" id="iNomeCompleto" name="nNomeCompleto" placeholder="Exemplo: Joab Torres Alencar" required value="<?php echo (!empty($arrayCad['nome_completo'])) ? $arrayCad['nome_completo'] : ''; ?>">
                                        <div class="invalid-feedback">
                                            Informe o nome completo
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <label for="iEmail" class="form-label">Email: <span class="text-bg-danger"><?php echo (!empty($arrayCad['email']['error'])) ? $arrayCad['email']['error'] : ''; ?></span></label>
                                        <input type="email" class="form-control" id="iEmail" name="nEmail" placeholder="Exemplo: joab.alencar@hotmail.com" required value="<?php echo (!empty($arrayCad['email'])) ? $arrayCad['email'] : ''; ?>">
                                        <div class="invalid-feedback">
                                            Informe o email
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1 csenha">
                                        <label for="iSenha" class="form-label">Senha:</label>
                                        <input type="password" class="form-control" id="iSenha" name="nSenha" placeholder="Exemplo: **********" minlength="8" required>
                                        <div class="invalid-feedback">
                                            Informe a senha, com no minimo 8 digitos
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1 crsenha">
                                        <label for="iRSenha" class="form-label">Repetir Senha:</label>
                                        <input type="password" class="form-control" id="iRSenha" name="nRSenha" placeholder="Exemplo: **********" minlength="8" required>
                                        <div class="invalid-feedback">
                                            Repita a senha, igual ao campo senha
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2 mb-2">
                                        <label for="istatus">Status: </label><br />
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nStatus" id="iStatus1" required value="1" <?php echo (isset($arrayCad['status']) && empty($arrayCad['status'])) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="iStatus1">Ativo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nStatus" id="iStatus2" required value="0" <?php echo (isset($arrayCad['status']) && empty($arrayCad['status'])) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="iStatus2">Inativo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 align-align-middle">
                                <div class="row">
                                    <div class="col-md-12 mt-1 text-center">
                                        <div class="img-thumbnail rounded-circle mt-1 mt-md-5" id="imageUser" style="
                                        <?php echo (!empty($arrayCad['anexo'])) ? 'background-image: url(' . BASE_URL . $arrayCad['anexo'] . ');' : ''; ?>"></div>
                                        <div class="m-auto mt-2 mb-2 btn btn-outline-primary" id="imagemPadrao">Imagem padrão</div>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <label for="iLinkAnexo" class="form-label">Anexo imagem:</label>
                                        <input type="hidden" class="form-control" id="iLinkAnexo" name="nLinkAnexo" placeholder="" value="<?php echo (!empty($arrayCad['anexo'])) ? $arrayCad['anexo'] : ''; ?>">
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <input type="file" class="form-control" name="nAnexo" id="iAnexo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-outline-success me-2" name="nSalvar" value="Salvar" onclick="validarFormUsuario()"><i class="fa-solid fa-check"></i> Salvar</button>
                            <a class="btn btn-outline-danger" href="<?php echo BASE_URL ?>"> <i class="fa-solid fa-xmark"></i> Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>