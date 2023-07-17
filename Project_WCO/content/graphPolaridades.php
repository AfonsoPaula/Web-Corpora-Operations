<?php
    require_once 'dbConfig.php';

    $palavra = $_POST['palavra'];
    $inicio_date = $_POST['inicio_date'];
    $fim_date = $_POST['fim_date'];

    // Pesquisar a palavra de dados usando PDO
    $query = $conn->prepare("SELECT CreatedAt, Post, Polarity, URL FROM SNCrawler.dbo.Post WHERE Post LIKE :palavra AND CreatedAt BETWEEN :inicio_date AND :fim_date ORDER BY CreatedAt");
    $query->bindValue(':palavra', "%$palavra%");
    $query->bindValue(':inicio_date', $inicio_date);
    $query->bindValue(':fim_date', $fim_date);
    $query->execute();
    $Table_Info = $query->fetchAll(PDO::FETCH_ASSOC);

    // Verificar se há linhas da base de dados com a palavra introduzida
    if($query->rowCount() == 0){
        echo '<script>
            Swal.fire({
                icon: "warning",
                title: "Não foram encontrados tweets!",
                text: "Não foi encontrado nenhum tweet relacionado com a palavra/frase introduzida. Sempre podes tentar mudar as datas da tua pesquisa.",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            });
        </script>';
    }else{
        // Processar os dados e contar as polaridades
        $polarities = array();
        foreach ($Table_Info as $row) {
            $polarity = $row['Polarity'];
            if (isset($polarities[$polarity])) {
                $polarities[$polarity]++;
            } else {
                $polarities[$polarity] = 1;
            }
        }

        // Função de comparação personalizada
        function comparePolarities($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        }

        // Ordenar as chaves (polaridades) com base nos valores usando a função de comparação personalizada
        uksort($polarities, 'comparePolarities');

        // Preparar os dados para o gráfico circular
        $polarityLabels = array_keys($polarities);
        $polarityCounts = array_values($polarities);

        // Converter os arrays para JSON
        $polarityLabelsJSON = json_encode($polarityLabels);
        $polarityCountsJSON = json_encode($polarityCounts);
    }
?>

<!-- Caso existam resultados -->
<?php if (!empty($Table_Info)) :?>
    <style>
        #chart-container {
        width: 100%;
        max-width: 480px; 
        height: auto; /* Para manter a proporção */
    }
    </style>
    <!-- Div que mostra o resumo dos dados obtidos -->
    <div id="sucessoGP" class="alert alert-success mx-auto text-center border mt-5 mb-4" style="width: 80%;" role="alert">
    <h5>Foram encontrados <u><strong><?php echo count($Table_Info)?></strong></u> resultados!</h5>
        <hr>
        <h5>Palavra(s) introduzida(s): <u><strong><?php echo ($palavra)?></strong></u>.</h5>
        <hr>
        <h5>Datas: <u><strong><?php echo ($inicio_date)?></strong></u>/<u><strong><?php echo ($fim_date)?></strong></u></h5> 
        <hr>
        <button id="verResultadosEst2" type="button" class="btn btn-primary">Ver Resultados</button>
    </div>
    <!-- Div que mostra o gráfico dos dados obtidos -->
    <div id="polGraph" class="mt-5 mb-3 p-3 mx-auto rounded" style="width: 80%; background-color: #E0E0E0">
        <h4 class="text-center pb-3 pt-3 mb-4 rounded " style="font-family: 'Secular One', sans-serif; background: linear-gradient(to right, #1c2331, #384f66); color: white; text-shadow: 2px 2px 4px #000000;">Distribuição de Polaridades</h4>
        <?php
        echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

        echo '<div id="chart-container" class="text-center mx-auto">
            <canvas id="doughnutChart"></canvas>
        </div>';
        
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var chartContainer = document.getElementById("chart-container");
                var canvas = document.getElementById("doughnutChart");

                canvas.width = chartContainer.offsetWidth;
                canvas.height = chartContainer.offsetHeight;

                // Configurar os dados para o gráfico de pizza
                var data = {
                    labels: ' . $polarityLabelsJSON . ',
                    datasets: [{
                        data: ' . $polarityCountsJSON . ',
                        backgroundColor: [
                            "rgba(204, 0, 51, 0.7)",     // Muito Negativo
                            "rgba(255, 159, 64, 0.7)",   // Negativo
                            "rgba(255, 206, 86, 0.7)",   // Neutro
                            "rgba(54, 162, 235, 0.7)",   // Positivo
                            "rgba(75, 192, 192, 0.7)",   // Muito Positivo                            
                        ],
                    }],
                };
                
                // Configurar as opções do gráfico de pizza
                var options = {
                    plugins: {
                        legend: {
                            display: true,
                            position: "bottom"
                        },
                        tooltips: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || "";
                                    var value = context.parsed || 0;
                                    var dataset = context.dataset || {};
                                    var total = dataset.data.reduce(function(acc, curr) {
                                        return acc + curr;
                                    });
                                    var percentage = total > 0 ? ((value / total) * 100).toFixed(2) + "%" : "0%";
                                    return label + ": " + percentage;
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 20 // Adicionar um espaçamento superior para acomodar o título
                        }
                    },
                    animation: {
                        duration: 1000 // Adicionar animação de 1 segundo
                    }                 
                };
                
                // Renderizar o gráfico de pizza
                var doughnutChart = new Chart(document.getElementById("doughnutChart"), {
                    type: "doughnut",
                    data: data,
                    options: options,
                });
            });
        </script>';?>
    </div>
<?php endif; ?>

<script>
    //--------------------------------------------------------------------------------------
    // Obtém as referências para as divs que será movida e para o elemento pai dela
    var div1 = document.getElementById("infoEst");
    var div3 = document.getElementById("formEst");
    var elementoPai = div1.parentNode;
    // Obtém a referência para a nova div que será inserida
    var sucesso = document.getElementById("sucessoGP");
    // Insere a nova div entre as outras
    elementoPai.insertBefore(sucesso, div3);

    // Obtém a referência para o botão e para a tabela
    var botao = document.getElementById("verResultadosEst2");
    var resultados = document.getElementById("polGraph");

    // Adiciona um manipulador de eventos ao botão
    botao.addEventListener("click", function() {
        // Usa o método scrollIntoView() para dar scroll até a tabela
        resultados.scrollIntoView();
    });
    //--------------------------------------------------------------------------------------
</script>