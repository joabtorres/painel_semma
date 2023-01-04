<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <h4 class="mb-1 ms-2">Cadastrar formulário</h4>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb p-2 rounded">
                    <li class="breadcrumb-item" aria-current="page"><a href="<?php echo BASE_URL ?>"> <i class="fa-solid fa-mug-hot me-1"></i>Página Inicial</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="<?php echo BASE_URL ?>formulario"> <i class="fa-solid fa-folder-tree me-1"></i>
                            Formulários</a></li>
                    <li class="breadcrumb-item " aria-current="page "><i class="fa-regular fa-square-plus me-1"></i>
                        Cadastrar </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <?php if (!empty($error)) { ?>
            <div class="col">
                <div class="alert <?php echo $error['class'] ?> text-white alert-dismissible fade show" role="alert">
                    <?php echo $error['msg'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php } ?>
        <form method="POST" name="nFormFormularios" enctype="multipart/form-data">
            <input type="hidden" id="iCod" value="<?php echo (!empty($arrayCad['cod'])) ? $arrayCad['cod'] : ''; ?>" name="nCod">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa-solid fa-folder-tree me-1"></i>
                            Formulários</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 mt-1">
                                        <label for="iCoordenacao" class="form-label">Coordenação:</label>
                                        <select class="form-select" id="iCoordenacao" name="nCoordenacao" required>
                                            <option selected disabled value="">Selecione...</option>
                                            <?php
                                            $coordenacao = formularioController::getInstance()->getCoordenacoes();
                                            foreach ($coordenacao as $index) {
                                                if (isset($arrayCad['coordenacao']) && $arrayCad['coordenacao'] == $index['sigla']) {
                                                    echo '<option selected value="' . $index['sigla'] . '">' . $index['nome'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $index['sigla'] . '">' . $index['nome'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Selecione a categoria
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <label for="iTipo" class="form-label">Tipo:</label>
                                        <input type="text" class="form-control" id="iTipo" name="nTipo" placeholder="Exemplo: Requerimento" required value="<?php echo (!empty($arrayCad['tipo'])) ? $arrayCad['tipo'] : ''; ?>">
                                        <div class="invalid-feedback">
                                            Informe o tipo
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <label for="iData" class="form-label">Data:</label>
                                        <input type="text" class="form-control" id="iData" name="nData" placeholder="Exmplo: Janeiro/2022" required value="<?php echo (!empty($arrayCad['data'])) ? $arrayCad['data'] : ''; ?>">
                                        <div class="invalid-feedback">
                                            Informe a data
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="col-md-12 mt-3">
                                    <label for="iDescricao" class="form-label">Descrição:</label>
                                    <textarea name="nDescricao" id="iDescricao" rows="7" class="form-control" required><?php echo (!empty($arrayCad['descricao'])) ? $arrayCad['descricao'] : ''; ?></textarea>
                                    <div class="invalid-feedback">
                                        Informe a descrição
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <label for="iLinkAnexo" class="form-label">Anexo:</label>
                                <input type="text" class="form-control" id="iLinkAnexo" name="nLinkAnexo" placeholder="Exemplo: https://drive.google.com/file/d/1ClJTUgAh7EeBlDvoQxOYVAn7HCT72GI1/view" value="<?php echo (!empty($arrayCad['anexo'])) ? $arrayCad['anexo'] : ''; ?>">
                            </div>
                            <div class="col-md-12 mt-1">
                                <input type="file" class="form-control" name="nAnexo">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-outline-success me-2" name="nSalvar" value="Salvar" onclick="validarFormFormularios()"><i class="fa-solid fa-check"></i> Salvar</button>
                            <a class="btn btn-outline-danger" href="<?php echo BASE_URL ?>"> <i class="fa-solid fa-xmark"></i> Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>