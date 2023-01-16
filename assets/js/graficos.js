//gerarGrafico('grafico_tipo_protocolo', 'protocolo_tipo');
//gerarGrafico('grafico_tipo_fiscalizacoes', 'fiscalizazao_tipo');
//gerarGrafico('grafico_tipo_recursosnaturais', 'recursosnaturais_tipo');
//gerarGrafico('grafico_tipo_licenciamento', 'licenciamentos_tipo');

graficoObjetivo('grafico/visitantes', 'grafico_visitantes');
graficoObjetivo('grafico/licencas_emitidas', 'grafico_licencas');

function graficoObjetivo(url, id) {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            array = JSON.parse(this.responseText);
            geraGraficoBarraVertical(array, id);
        }
    };
    xhttp.open("GET", base_url + url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

/**
 * geraGraficoPizza função encarregada para gerar gráfico em pizza
 * @param {array} array -- array contendo os labels e valores
 * @param {string} id_grafico id do grafico
 * @returns {undefined}
 */
function geraGraficoPizza(array, id_grafico) {
    var titulo = [];
    var valores = [];
    var cores = [];

    for (var i = 0; i < array.length; i++) {
        titulo[i] = (array[i]['label']);
        valores[i] = array[i]['data'];
        cores[i] = cor(i);
    }
    var data = {
        datasets: [{
            data: valores,
            backgroundColor: cores,
            hoverBackgroundColor: cores
        }],
        labels: titulo
    };
    var option = {
        responsive: true,
        legend: {
            display: false,
            position: 'right'
        },
        title: {
            display: false,
            text: 'Modalidades Registrados'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };
    var ctx = document.getElementById(id_grafico);
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: option
    });
}

/**
 * geraGraficoBarraVertical função encarregada para gerar gráfico em barra vertical
 * @param {array} array -- array contendo os labels e valores
 * @param {string} id_grafico id do grafico
 * @returns {undefined}
 */


function geraGraficoBarraVertical(array, id_grafico) {
    var dataset = [];
    for (var i = 0; i < array.length; i++) {
        dataset[i] = {
            label: array[i]['label'],
            backgroundColor: cor(i),
            borderWidth: 1,
            data: [
                array[i]['data'], 0
            ]
        };
    }
    var horizontalBarChartData = {
        labels: [],
        datasets: dataset
    };
    var option = {
        elements: {
            rectangle: {
                borderWidth: 1
            }
        },
        responsive: true,
        legend: {
            display: true,
            position: 'right'
        },
        title: {
            display: false,
            text: 'Objetos de tramitação'
        }
    };
    var ctx = document.getElementById(id_grafico).getContext('2d');
    window.myHorizontalBar = new Chart(ctx, {
        type: 'bar',
        data: horizontalBarChartData,
        options: option
    });
}

function cor(num) {
    var cores = ['#00a65a', '#dd4b39', '#e89e29', '#6c5ae2', '#543324', '#ed6636', , '#121833', '#931a39', '#d9b557', '#1888b8', '#b6c353', '#0a441c', '#865b3f', '#6123a4'];
    return cores[num];
}

function gera_cor() {
    var hexadecimais = '0123456789ABCDEF';
    var cor = '#';

    // Pega um número aleatório no array acima
    for (var i = 0; i < 6; i++) {
        //E concatena à variável cor
        cor += hexadecimais[Math.floor(Math.random() * 16)];
    }
    return cor;
}