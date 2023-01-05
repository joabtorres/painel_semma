<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <h4 class="mb-1 ms-2">Editar licenças emitidas</h4>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb p-2 rounded">
                    <li class="breadcrumb-item" aria-current="page"><a href="<?php echo BASE_URL ?>"><i class="fa-solid fa-mug-hot me-1"></i>Página Inicial</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="<?php echo BASE_URL ?>licenca"> <i class="fa-solid fa-file-circle-check  me-1"></i>Licenças Emitidas</a></li>
                    <li class="breadcrumb-item " aria-current="page "><i class="fa fa-pencil-alt me-1"></i>
                        Editar </li>
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
        <form method="POST" name="nFormLicencaEmitida" enctype="multipart/form-data">
            <input type="hidden" id="iCod" value="<?php echo (!empty($arrayCad['cod'])) ? $arrayCad['cod'] : ''; ?>" name="nCod">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa-solid fa-file-circle-check  me-1"></i>
                            Licenças Emitidas</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="iLicenca" class="form-label">Licença:</label>
                                <select class="form-select" id="iLicenca" name="nLicenca" required>
                                    <option selected disabled value="">Selecione...</option>
                                    <?php
                                    $licenca = licencaController::getInstance()->getLicencas();
                                    foreach ($licenca as $index) {
                                        if (isset($arrayCad['licenca']) && $arrayCad['licenca'] == $index['licenca']) {
                                            echo '<option selected value="' . $index['licenca'] . '">' . $index['licenca'] . '</option>';
                                        } else {
                                            echo '<option value="' . $index['licenca'] . '">' . $index['licenca'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecione a licença
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mt-2">
                                <label for="iAno" class="form-label">Ano:</label>
                                <input type="text" class="form-control input-ano" id="iAno" name="nAno" placeholder="Exemplo: 2015" required value="<?php echo (!empty($arrayCad['ano'])) ? $arrayCad['ano'] : ''; ?>">
                                <div class="invalid-feedback">
                                    Informe o ano
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="iNumeroLicenca" class="form-label">Número da licença:</label>
                                <input type="text" class="form-control" id="iNumeroLicenca" name="nNumeroLicenca" placeholder="Exemplo: 0001/2022" required value="<?php echo (!empty($arrayCad['n_licenca'])) ? $arrayCad['n_licenca'] : ''; ?>">
                                <div class="invalid-feedback">
                                    Informe o número da licença
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="iNumeroProtocolo" class="form-label">Número do protocolo:</label>
                                <input type="text" class="form-control" id="iNumeroProtocolo" name="nNumeroProtocolo" placeholder="Exemplo: 00041/2022" required value="<?php echo (!empty($arrayCad['n_protocolo'])) ? $arrayCad['n_protocolo'] : ''; ?>">
                                <div class="invalid-feedback">
                                    Informe o número do protocolo
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="iDataEmissao" class="form-label">Data de emissão:</label>
                                <input type="text" class="form-control date_serach input-data" id="iDataEmissao" name="nDataEmissao" placeholder="Exmplo: 02/10/2015" value="<?php echo (!empty($arrayCad['data_emissao'])) ? $arrayCad['data_emissao'] : ''; ?>">
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="iDataValidade" class="form-label">Data de validade:</label>
                                <input type="text" class="form-control" id="iDataValidade" name="nDataValidade" placeholder="Exmplo: 02/10/2015" value="<?php echo (!empty($arrayCad['data_validade'])) ? $arrayCad['data_validade'] : ''; ?>">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="iEmpreendimento" class="form-label">Empreendimento:</label>
                                <input type="text" class="form-control" id="iEmpreendimento" name="nEmpreendimento" placeholder="Exemplo: PREFEITURA MUNICIPAL DE CASTANHAL" required value="<?php echo (!empty($arrayCad['empreendimento'])) ? $arrayCad['empreendimento'] : ''; ?>">
                                <div class="invalid-feedback">
                                    Informe o empreendimento
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="iTipologia" class="form-label">Tipologia:</label>
                                <input type="text" class="form-control" id="iTipologia" name="nTipologia" placeholder="Exemplo: CONSTRUÇÃO DE HABITAÇÃO URBANA" value="<?php echo (!empty($arrayCad['tipologia'])) ? $arrayCad['tipologia'] : ''; ?>">
                                <div class="invalid-feedback">
                                    Informe a tipologia
                                </div>
                            </div>
                            <div class="col-md-12  mt-2">
                                <label for="iDescricao" class="form-label">Observação:</label>
                                <textarea name="nDescricao" id="iDescricao" rows="2" class="form-control"><?php echo (!empty($arrayCad['observacao'])) ? $arrayCad['observacao'] : ''; ?></textarea>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-outline-success me-2" name="nSalvar" value="Salvar" onclick="validarFormLicenca()"><i class="fa-solid fa-check"></i> Salvar</button>
                            <a class="btn btn-outline-danger" href="<?php echo BASE_URL ?>"> <i class="fa-solid fa-xmark"></i> Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>