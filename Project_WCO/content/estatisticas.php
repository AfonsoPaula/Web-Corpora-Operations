<main class="pt-5 pb-5"> 
    <!-- Estilos para o botão 'Procurar/Loading' -->
    <style>
        .fa {
            margin-left: -12px;
            margin-right: 8px;
        }
        .hide {
            display: none;
        }
    </style>
    <!-- 1ª  D I V -->
    <div id="inicioEst" class="pt-1">
        <!-- I N F O R M A Ç Ã O-->
        <div id="infoEst" class="rounded mt-4 mb-4 p-1 pt-4 mx-auto" style="width: 80%; background-color: #E0E0E0;">
            <div class="pt-3 pl-5 pr-5 text-center">
                <h2 class="text-center pb-3 pt-3 mb-4 rounded " style="font-family: 'Secular One', sans-serif; background: linear-gradient(to right, #1c2331, #384f66); color: white; text-shadow: 2px 2px 4px #000000;">ESTATÍSTICAS</h2>
                <hr>
                <p style="font-family: 'Montserrat', sans-serif;">Nesta página oferecemos-te uma nova funcionalidade que te permite visualizar alguns gráficos para uma análise mais aprofundada das palavras ou frases que desejas pesquisar.</p>
                <div class="pr-5 pl-5 pb-3 text-justify">
                    <p style="font-family: 'Montserrat', sans-serif;"><u><strong>Top Palavras</strong></u>: gráfico de barras com as 10 palavras mais associadas à frase ou palavra em questão. É um gráfico que te permite identificar quais são as palavras mais frequentes e relevantes em relação ao tema pesquisado.</p>
                    <p style="font-family: 'Montserrat', sans-serif;"><u><strong>Distribuição de Polaridades</strong></u>: gráfico circular que exibe a distribuição dos sentimentos associados à tua pesquisa. Este gráfico proporciona uma visão das polaridades dos tweets, o que te permite identificar a proporção dos 5 tipos de sentimentos que podem estar presentes.</p>
                </div>
            </div>
        </div>
        <!-- P R O C U R A R  P/  G R Á F I C O S -->
        <form id="formEst" class="form-inline text-center" action="" method="POST">
            <div class="procurar rounded mx-auto p-4 mt-3" style="width: 80%; background-color: #E0E0E0;">
                <!-- Input p/ palavras -->
                <div class='row d-flex justify-content-center'>
                    <div class='col'>
                        <input class="form-control mr-sm-2 border border-dark text-center bg-light" style="width: 100%" type="search" name="palavra" placeholder="Digite a palavra a ser pesquisada" required>
                    </div>
                </div>
                <!-- Opções -->
                <div class="input-group mt-4">
                    <div class="input-group-append border">
                        <label class="input-group-text border border-dark rounded text-center" for="inputGroupSelect02">Opções : </label>
                    </div>
                    <select class="custom-select bg-light border border-dark rounded ml-1" id="inputGroupSelect02" name="opcao" required>
                        <option value="1" selected>Top Palavras</option>
                        <option value="2">Polaridades</option>
                    </select>
                </div>
                <!-- Datas -->
                <div class='row d-flex justify-content-center'>
                    <div class='col pt-4 d-flex justify-content-center'>
                        <label for="inicio_date" class="font-weight-bold border border-dark rounded p-1 mr-3">Desde: </label>
                        <input type="date" name="inicio_date" class="form-control bg-light" value="<?php echo date("d-m-Y");?>" required>
                    </div>
                    <div class='col pt-4 d-flex justify-content-center'>
                        <label for="fim_date" class="font-weight-bold border border-dark rounded p-1 mr-3">Até: </label>
                        <input type="date" name="fim_date" class="form-control bg-light" value="<?php echo date("d-m-Y");?>" required>
                    </div>
                </div>
                <hr>
                <!-- Procurar -->
                <div class='row'>
                    <div class='col pt-2 text-center'>
                        <button id="procurarEst" class="btn btn-info pr-4 pl-4 ml-2 my-2 my-sm-0" type="submit" style="background-color: #384f66;">Procurar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- 2ª D I V  -  R E S U L T A D O S -->
    <div id="estatisticas">
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $opcao = $_POST['opcao'];
                if ($opcao === '1') {
                    include("graphTopWords.php");
                } elseif ($opcao === '2') {
                    include("graphPolaridades.php");
                }  
            }
        ?>
    </div>

    <script>
        // ----------------------------------------------------------------------------------
        // script que permite exibir um alerta ao utilizador com o principal objetivo de o
        // informar que a pesquisa pode levar alguns segundos
        document.getElementById('formEst').addEventListener('submit', function(event) {
            // Impedir o envio imediato do formulário
            event.preventDefault(); 
            
            Swal.fire({
            icon: 'info',
            title: 'A pesquisa pode levar alguns segundos...',
            text: 'Por favor, aguarde.',
            showCancelButton: false,
            showConfirmButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false
            }).then(function() {
                // Enviar o formulário após o clique no botão "OK"
                event.target.submit();
            });
        });
        // ----------------------------------------------------------------------------------
    </script>
</main>