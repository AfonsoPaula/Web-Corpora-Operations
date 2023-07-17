<main class="pt-5 pb-1">

    <style>
        /* Style para o botão de 'procurar/loading' */
        .fa {
            margin-left: -12px;
            margin-right: 8px;
        }
        .hide {
            display: none;
        }
    </style>

    <!-- 1º  D I V -->
    <div id="inicioProc" class="pt-1">
        <!-- I N F O R M A Ç Ã O-->
        <div id="infoProc" class="rounded mt-4 mb-4 p-1 pt-4 mx-auto" style="width: 80%; background-color: #E0E0E0;">
            <img src="img/logo.png" style="max-width:100%;" class="img-fluid w-25 mt-1 mx-auto d-block">
            <div class="pt-3 pl-5 pr-5 text-center">
                <p style="font-family: 'Montserrat', sans-serif;">
                    Bem-vind@ à nossa página!
                </p><p style="font-family: 'Montserrat', sans-serif;">
                    Agradecemos por visitares o nosso site. Aqui conseguirás encontrar uma ferramenta incrível para explorares dados relacionados 
                    com as tuas palavras-chave ou frases que tenhas interesse. A nossa plataforma permite que pesquises por termos específicos de 
                    modo a obteres resultados relevantes.
                </p><p style="font-family: 'Montserrat', sans-serif;">
                    Utilizamos a poderosa rede social Twitter como fonte de dados, o que significa que terás acesso aos tweets mais recentes e 
                    relevantes relacionados com a tua pesquisa. É uma maneira fantástica de ficar por dentro das conversas e opiniões que estão
                    a ocorrer no Twitter sobre assuntos que aches pertinentes.
                </p><p style="font-family: 'Montserrat', sans-serif;">
                    Mas espera, isso não é tudo! Queremos que conheças ainda mais sobre a nossa página e todas as ferramentas úteis que oferecemos.
                    Aventura-te mais e descobre o que mais temos a oferecer!
                </p>
            </div>
        </div>
        <!-- F O R M U L Á R I O  -  P R O C U R A R   P A L A V R A -->
        <form id="formProc" class="form-inline text-center mb-5" action="" method="POST">
            <div class="procurar rounded mx-auto p-4 mt-3" style="width: 80%; background-color: #E0E0E0;">
                <!-- Input p/ palavras -->
                <div class='row d-flex justify-content-center'>
                    <div class='col'>
                        <input id="campoProcurar" class="form-control mr-sm-2 border border-dark text-center" style="width: 100%" type="search" name="palavra" placeholder="Digite a palavra/frase a ser pesquisada..." required>
                    </div>
                </div>
                <!-- Datas -->
                <div id='datasProcurar' class='row d-flex justify-content-center'>
                    <div class='col pt-4 d-flex justify-content-center'>
                        <label for="inicio_date" class="font-weight-bold border border-dark rounded p-1 mr-3">Desde: </label>
                        <input type="date" name="inicio_date" classe="form-control" value="<?php echo date("d-m-Y");?>" required>
                    </div>
                    <div class='col pt-4 d-flex justify-content-center'>
                        <label for="fim_date" class="font-weight-bold border border-dark rounded p-1 mr-3">Até: </label>
                        <input type="date" name="fim_date" classe="form-control" value="<?php echo date("d-m-Y");?>" required>
                    </div>
                </div>
                <hr id='divisaoProcurar'>
                <!-- botão de procurar -->
                <div class='row'>
                    <div class='col pt-2 text-center'>
                        <button id="procurar_index" class="btn btn-info pr-4 pl-4 ml-2 my-2 my-sm-0" type="submit">Procurar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- 2º  D I V  -  R E S U L T A D O S -->
    <div id="procurar">
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                include("pesquisas.php");
            }
        ?>
    </div>

    <script>
        //------------------------------------------------------------------------------------
        // Script para o Botão de Procurar possuir uma animação de 'loading'
        document.getElementById('formProc').addEventListener('submit', function(event){
            var button = document.getElementById('procurar_index');
            var div = document.getElementById('procurar');
            var hasContent = div.innerHTML.trim().length > 0;
            // Alterar o conteúdo do botão para "Loading"
            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>A carregar...';
            // Desabilitar o botão 
            button.disabled = true; 
            // Tempo de espera com base no número de palavras:
            //  - ajustar o multiplicador para adequar ao tempo desejado
            var loadingTime = words * 500; 

            setTimeout(function() {
                // Altera o conteúdo do botão para "Procurar"
                button.innerHTML = 'Procurar';
                // Habilita o botão 
                button.disabled = false; 
            }, loadingTime);
        });
        //------------------------------------------------------------------------------------
        // Script para smooth scroll (voltar a pesquisar -> para o campo de inserir palavra)
        document.addEventListener('DOMContentLoaded', function() {
            // Obtém a referência para o botão
            var botaoTentar = document.getElementById('tentarAgain');

            // Obtém a referência para o campo do formulário que se deseja selecionar
            var campo = document.getElementById('campoProcurar');

            // Adiciona um evento de clique ao botão
            botaoTentar.addEventListener('click', function() {
                // Seleciona o campo do formulário
                campo.select();
                // Rola suavemente até o formulário
                campo.scrollIntoView({ behavior: 'smooth' });
            });
        });
        //------------------------------------------------------------------------------------
        // Alterar o posicionamento da div que mostra a mensagem q não foram encontrados result:
            var divA = document.getElementById("infoProc");
            var divB = document.getElementById("formProc");
            var elementoPai = div1.parentNode;
            // Obtém a referência para a nova div que será inserida
            var msgAlerta = document.getElementById("msgErroProcurar");
            // Insere a nova div entre as outras
            elementoPai.insertBefore(msgAlerta, divB);
        //------------------------------------------------------------------------------------
        // Animação para o logo da ubi
        const imagem = document.querySelector('img');
        imagem.addEventListener('mouseover', () => {
            imagem.style.transform = 'scale(1.2)';
            imagem.style.transition = 'transform 0.3s';
            imagem.style.cursor = 'pointer';
        });
        imagem.addEventListener('mouseout', () => {
            imagem.style.transform = 'scale(1)';
            imagem.style.transition = 'transform 0.3s';
            imagem.style.cursor = 'default';
        });
        imagem.addEventListener('click', () => {
            window.open('https://www.ubi.pt', '_blanck');
        });
        //------------------------------------------------------------------------------------
    </script>
</main>