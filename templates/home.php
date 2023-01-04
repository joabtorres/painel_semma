<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <h4 class="mb-1 ms-2">Página Inicial</h4>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb p-2 rounded">
                    <li class="breadcrumb-item active" aria-current="page"> <i class="fa-solid fa-mug-hot me-1"></i>Página Inicial</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fa-solid fa-landmark me-1"></i> Legislação</h4>
                </div>
                <div class="card-body">
                    <p class="m-0">
                        <?php if (!empty($legislacoes)) {
                            echo $legislacoes['qtd'] . ' Registros encontrados';
                        } else {
                            echo 'Nenhum registro encontrado';
                        } ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fa-solid fa-folder-tree me-1"></i> Formulários</h4>
                </div>
                <div class="card-body">
                    <p class="m-0">
                        <?php if (!empty($formularios)) {
                            echo $formularios['qtd'] . ' Registros encontrados';
                        } else {
                            echo 'Nenhum registro encontrado';
                        } ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fa-solid fa-file-circle-check  me-1"></i>
                        Licenças Emitidas</h4>
                </div>
                <div class="card-body">
                    <p class="m-0">
                        <?php if (!empty($licencas)) {
                            echo $licencas['qtd'] . ' Registros encontrados';
                        } else {
                            echo 'Nenhum registro encontrado';
                        } ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fa-solid fa-file-pdf me-1"></i>
                        Termos de Refêrencias
                </div>
                <div class="card-body">
                    <p class="m-0">
                        <?php if (!empty($trs)) {
                            echo $trs['qtd'] . ' Registros encontrados';
                        } else {
                            echo 'Nenhum registro encontrado';
                        } ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mt-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fa-solid fa-chart-line me-1"></i>Gráfico de acesso ao site</h4>
                </div>
                <div class="card-body">
                    <div><canvas id="grafico_visitantes"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fa-solid fa-chart-line me-1"></i>Gráfico de Licenças Emitidas</h4>
                </div>
                <div class="card-body">
                    <div><canvas id="grafico_licencas"></canvas></div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo BASE_URL ?>assets/js/chart.min.js"></script>
    <script src="<?php echo BASE_URL ?>assets/js/graficos.js"></script>
</div>