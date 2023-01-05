<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <h4 class="mb-1 ms-2">Cadastrar legislação</h4>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb p-2 rounded">
                    <li class="breadcrumb-item" aria-current="page"><a href="<?php echo BASE_URL ?>"> <i class="fa-solid fa-mug-hot me-1"></i>Página Inicial</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="<?php echo BASE_URL ?>legislacao"> <i class="fa-solid fa-landmark me-1"></i>
                            Legislações</a></li>
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
        <form method="POST" name="nFormLegislacao" enctype="multipart/form-data">
            <input type="hidden" id="iCod" value="<?php echo (!empty($arrayCad['cod'])) ? $arrayCad['cod'] : ''; ?>">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa-solid fa-landmark me-1"></i>
                            Legislações</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mt-1">
                                <label for="iCategoria" class="form-label">Categoria</label>
                                <select class="form-select" id="iCategoria" name="nCategoria" required>
                                    <option selected disabled value="">Selecione...</option>
                                    <?php if (isset($categoria) && !empty($categoria)) {
                                        foreach ($categoria as $index) {
                                            if (isset($arrayCad['categoria']) && $arrayCad['categoria'] == $index['categoria']) {
                                                echo '<option selected value="' . $index['categoria'] . '">' . $index['categoria'] . '</option>';
                                            } else {
                                                echo '<option value="' . $index['categoria'] . '">' . $index['categoria'] . '</option>';
                                            }
                                        }
                                    } ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecione a categoria
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <label for="iEsfera" class="form-label">Esfera</label>
                                <select class="form-select" id="iEsfera" name="nEsfera" required>
                                    <option selected disabled value="">Selecione...</option>
                                    <?php if (isset($esfera) && !empty($esfera)) {
                                        foreach ($esfera as $index) {
                                            if (isset($arrayCad['esfera']) && $arrayCad['esfera'] == $index['esfera']) {
                                                echo '<option selected value="' . $index['esfera'] . '">' . $index['esfera'] . '</option>';
                                            } else {
                                                echo '<option value="' . $index['esfera'] . '">' . $index['esfera'] . '</option>';
                                            }
                                        }
                                    } ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecione a esfera
                                </div>
                            </div>
                            <div class="col-md-2 mt-1">
                                <label for="iNumero" class="form-label">Número:</label>
                                <input type="text" class="form-control input-numero_lei" id="iNumero" name="nNumero" placeholder="Exemplo: 041" required value="<?php echo (!empty($arrayCad['numero'])) ? $arrayCad['numero'] : ''; ?>">
                                <div class="invalid-feedback">
                                    Informe o número
                                </div>
                            </div>
                            <div class="col-md-2 mt-1">
                                <label for="iAno" class="form-label">Ano:</label>
                                <input type="text" class="form-control input-ano" id="iAno" name="nAno" placeholder="Exemplo: 2015" required value="<?php echo (!empty($arrayCad['ano'])) ? $arrayCad['ano'] : ''; ?>">
                                <div class="invalid-feedback">
                                    Informe o ano
                                </div>
                            </div>
                            <div class="col-md-2 mt-1">
                                <label for="iData" class="form-label">Data:</label>
                                <input type="text" class="form-control date_serach input-data" id="iData" name="nData" placeholder="Exmplo: 02/10/2015" required value="<?php echo (!empty($arrayCad['data'])) ? $arrayCad['data'] : ''; ?>">
                                <div class="invalid-feedback">
                                    Informe a data
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="validationServer03" class="form-label">Ementa/Descrição:</label>
                                <textarea name="nEmenta" id="iEmenta" rows="5" class="form-control" required><?php echo (!empty($arrayCad['ementa'])) ? $arrayCad['ementa'] : ''; ?></textarea>
                                <div class="invalid-feedback">
                                    Informe a ementa/descrição
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <label for="iLinkDiario" class="form-label">Diário:</label>
                                <input type="text" class="form-control" id="iLinkDiario" name="nLinkDiario" placeholder="Exemplo: https://drive.google.com/file/d/1ClJTUgAh7EeBlDvoQxOYVAn7HCT72GI1/view" value="<?php echo (!empty($arrayCad['diario'])) ? $arrayCad['diario'] : ''; ?>">
                            </div>
                            <div class="col-md-12 mt-1">
                                <input type="file" class="form-control" name="nDiario">
                            </div>
                            <div class="col-md-12 mt-1">
                                <label for="iLinkAnexo" class="form-label">Anexo:</label>
                                <input type="text" class="form-control" id="iLinkAnexo" name="nLinkAnexo" placeholder="Exemplo: https://drive.google.com/file/d/1ClJTUgAh7EeBlDvoQxOYVAn7HCT72GI1/view" value="<?php echo (!empty($arrayCad['anexo'])) ? $arrayCad['anexo'] : ''; ?>">
                            </div>
                            <div class="col-md-12 mt-1">
                                <input type="file" class="form-control" name="nAnexo">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-outline-success me-2" name="nSalvar" value="Salvar" onclick="validarFormLegislacao()"><i class="fa-solid fa-check"></i> Salvar</button>
                            <a class="btn btn-outline-danger" href="<?php echo BASE_URL ?>"> <i class="fa-solid fa-xmark"></i> Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>