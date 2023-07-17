<main class="pt-5 pb-5">
    <!-- estilos para o botão 'Procurar/Loading' -->
    <style>
        .fa {
            margin-left: -12px;
            margin-right: 8px;
        }
        .hide {
            display: none;
        }
    </style>
    <!-- 1º  D I V -->
    <div id="inicioPol" class="pt-1">
        <!-- I N F O R M A Ç Ã O-->
        <div id="infoPol" class="rounded mt-4 mb-4 p-1 pt-4 mx-auto" style="width: 80%; background-color: #E0E0E0;">
            <div class="pt-3 pl-5 pr-5 text-center">
                <h2 class="text-center pb-3 pt-3 mb-4 rounded " style="font-family: 'Secular One', sans-serif; background: linear-gradient(to right, #3e6375, #043755); color: white; text-shadow: 2px 2px 4px #000000;">POLARIDADE</h2>
                <hr>
                <p class="pt-2" style="font-family: 'Montserrat', sans-serif;">
                    Nesta página, oferecemos-te uma experiência única. Além de poderes pesquisar por frases ou palavras-chave específicas, podes também ter acesso à polaridade de cada tweet encontrado. 
                </p><p class="pt-2" style="font-family: 'Montserrat', sans-serif;">
                    Isto significa que podes descobrir o sentimento associado a cada um deles. Através de uma escala de -2 a 2, cada tweet é associado a um número que representa o sentimento expresso na mensagem. Para tornar a identificação do sentimento ainda mais intuitiva, cada valor da escala é acompanhado por um emoji correspondente. Assim, podes facilmente identificar se um tweet é negativo, neutro ou positivo apenas olhando para o emoji exibido na coluna correspondente, o que desta forma permite que consigas analisar e entender melhor as emoções expressas nos tweets relacionados com a tua pesquisa. 
                </p><p class="pt-2" style="font-family: 'Montserrat', sans-serif;">
                    Esta funcionalidade adicional permite uma compreensão mais profunda das conversas e opiniões compartilhadas na rede social Twitter. Explora a polaridade dos tweets e mergulha nas nuances emocionais que permeiam os tópicos que mais te interessam!
                </p>
            </div>
        </div>
        <!-- P R O C U R A R   P O L-->
        <form id="formPol" class="form-inline text-center" action="" method="POST">
            <div class="procurar rounded mx-auto p-4 mt-3" style="width: 80%; background-color: #E0E0E0;">
                <!-- Input p/ palavras -->
                <div class='row d-flex justify-content-center'>
                    <div class='col'>
                        <input id="campoPol" class="form-control mr-sm-2 border border-dark text-center" style="width: 100%" type="search" name="palavra" placeholder="Digite a palavra a ser pesquisada" required>
                    </div>
                </div>
                <!-- Datas -->
                <div class='row d-flex justify-content-center'>
                    <div class='col pt-4 d-flex justify-content-center'>
                        <label for="inicio_date" class="font-weight-bold border border-dark rounded p-1 mr-3">Desde: </label>
                        <input type="date" name="inicio_date" class="form-control" value="<?php echo date("d-m-Y");?>" required>
                    </div>
                    <div class='col pt-4 d-flex justify-content-center'>
                        <label for="fim_date" class="font-weight-bold border border-dark rounded p-1 mr-3">Até: </label>
                        <input type="date" name="fim_date" class="form-control" value="<?php echo date("d-m-Y");?>" required>
                    </div>
                </div>
                <hr>
                <!-- botão de procurar -->
                <div class='row'>
                    <div class='col pt-2 text-center'>
                        <button id="procurarPol" class="btn btn-info pr-4 pl-4 ml-2 my-2 my-sm-0" type="submit">Procurar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- 2ª D I V  -  R E S U L T A D O S -->
    <div id="polaridade">
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                include("pesquisas_pol.php");
            }
        ?>
    </div>

    <script>
        //------------------------------------------------------------------------------------
        // Script para o Botão de Procurar possuir uma animação de 'loading'
        document.getElementById('formPol').addEventListener('submit', function(event){
            var button = document.getElementById('procurarPol');
            var div = document.getElementById('polaridade');
            var hasContent = div.innerHTML.trim().length > 0;
            // Alterar o conteúdo do botão para "Loading"
            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>A carregar...';
            // Desabilitar o botão 
            button.disabled = true; 
            // Tempo de espera com base no número de palavras:
            // ajuste o multiplicador para adequar ao tempo desejado
            var loadingTime = words * 500; 

            setTimeout(function() {
                // Alterar o conteúdo do botão para "Procurar"
                button.innerHTML = 'Procurar';
                // Habilitar o botão
                button.disabled = false;
            }, loadingTime);
        });
        //------------------------------------------------------------------------------------
        // Script para smooth scroll (voltar a pesquisar -> para o campo de inserir palavra)
        document.addEventListener('DOMContentLoaded', function() {
            // Obtém uma referência para o botão
            var botaoTentar = document.getElementById('tentarAgain2');

            // Obtém uma referência para o campo do formulário que deseja selecionar
            var campo = document.getElementById('campoPol');

            // Adiciona um evento de clique ao botão
            botaoTentar.addEventListener('click', function() {
                // Seleciona o campo do formulário
                campo.select();
                // scroll até o formulário
                campo.scrollIntoView({ behavior: 'smooth' });
            });
        });
        //------------------------------------------------------------------------------------
        // Alterar o posicionamento da div que mostra a mensagem q não foram encontrados result:
            var divA = document.getElementById("infoPol");
            var divB = document.getElementById("formPol");
            var elementoPai = div1.parentNode;
            // Obtém a referência para a nova div que será inserida
            var msgAlerta = document.getElementById("msgErroPol");
            
            // Insere a div entre as outras
            elementoPai.insertBefore(msgAlerta, divB);
        //------------------------------------------------------------------------------------
    </script>
</main>