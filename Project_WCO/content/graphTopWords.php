<?php
    require_once 'dbConfig.php';

    $palavra = $_POST['palavra'];
    $inicio_date = $_POST['inicioDate'];
    $fim_date = $_POST['fimDate'];

    // Pesquisar a palavra de dados usando a classe PDO
    $query = $conn->prepare("SELECT [CreatedAt], [Post], [Polarity], [URL] FROM SNCrawler.dbo.Post WHERE Post LIKE :palavra AND CreatedAt BETWEEN :inicio_date AND :fim_date ORDER BY CreatedAt");
    $query->bindValue(':palavra', "%$palavra%");
    $query->bindValue(':inicio_date', $inicio_date);
    $query->bindValue(':fim_date', $fim_date);
    $query->execute();
    $Table_Info = $query->fetchAll(PDO::FETCH_ASSOC);

    // Verificar se há linhas da base de dados de acordo com a palavra introduzida
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
    }

    // Array que vai armazenar a contagem das palavras
    $wordCount = array();

    // Array com as 514 Stop Words
    $stopWords = array(
        $palavra,'a', 'à', 'adeus', 'agora', 'aí', 'ainda', 'além', 'algo', 'alguém', 'algum', 'alguma', 'algumas', 'alguns', 'ali',
        'ampla', 'amplas', 'amplo', 'amplos', 'ano', 'anos', 'ante', 'antes', 'ao', 'aos', 'apenas', 'apoio', 'após', 'aquela',
        'aquelas', 'aquele', 'aqueles', 'aqui', 'aquilo', 'área', 'as', 'às', 'assim', 'até', 'atrás', 'através', 'baixo', 
        'bastante', 'bem', 'boa', 'boas', 'bom', 'bons', 'breve', 'cá', 'cada', 'catorze', 'cedo', 'cento', 'certamente', 
        'certeza', 'cima', 'cinco', 'coisa', 'coisas', 'com', 'como', 'conselho', 'contra', 'contudo', 'custa', 'da', 'dá', 
        'dão', 'daquela', 'daquelas', 'daquele', 'daqueles', 'dar', 'das', 'de', 'debaixo', 'dela', 'delas', 'dele', 'deles', 
        'demais', 'dentro', 'depois', 'desde', 'dessa', 'dessas', 'desse', 'desses', 'desta', 'destas', 'deste', 'destes', 
        'deve', 'devem', 'devendo', 'dever', 'deverá', 'deverão', 'deveria', 'deveriam', 'devia', 'deviam', 'dez', 'dezanove', 
        'dezasseis', 'dezassete', 'dezoito', 'dia', 'diante', 'disse', 'disso', 'disto', 'dito', 'diz', 'dizem', 'dizer', 'do', 
        'dois', 'dos', 'doze', 'duas', 'dúvida', 'e', 'é', 'ela', 'elas', 'ele', 'eles', 'em', 'embora', 'enquanto', 'entre', 
        'era', 'eram', 'éramos', 'és', 'essa', 'essas', 'esse', 'esses', 'esta', 'está', 'estamos', 'estão', 'estar', 'estas', 
        'estás', 'estava', 'estavam', 'estávamos', 'este', 'esteja', 'estejam', 'estejamos', 'estes', 'esteve', 'estive', 
        'estivemos', 'estiver', 'estivera', 'estiveram', 'estivéramos', 'estiverem', 'estivermos', 'estivesse', 'estivessem', 
        'estivéssemos', 'estiveste', 'estivestes', 'estou', 'etc', 'eu', 'exemplo', 'faço', 'falta', 'favor', 'faz', 'fazeis', 
        'fazem', 'fazemos', 'fazendo', 'fazer', 'fazes', 'feita', 'feitas', 'feito', 'feitos', 'fez', 'fim', 'final', 'foi', 
        'fomos', 'for', 'fora', 'foram', 'fôramos', 'forem', 'forma', 'formos', 'fosse', 'fossem', 'fôssemos', 'foste', 'fostes', 
        'fui', 'geral', 'grande', 'grandes', 'grupo', 'há', 'haja', 'hajam', 'hajamos', 'hão', 'havemos', 'havia', 'hei', 'hoje', 
        'hora', 'horas', 'houve', 'houvemos', 'houver', 'houvera', 'houverá', 'houveram', 'houvéramos', 'houverão', 'houverei', 
        'houverem', 'houveremos', 'houveria', 'houveriam', 'houveríamos', 'houvermos', 'houvesse', 'houvessem', 'houvéssemos', 
        'isso', 'isto', 'já', 'la', 'lá', 'lado', 'lhe', 'lhes', 'lo', 'local', 'logo', 'longe', 'lugar', 'maior', 'maioria', 
        'mais', 'mal', 'mas', 'máximo', 'me', 'meio', 'menor', 'menos', 'mês', 'meses', 'mesma', 'mesmas', 'mesmo', 'mesmos', 
        'meu', 'meus', 'mil', 'minha', 'minhas', 'momento', 'muita', 'muitas', 'muito', 'muitos', 'na', 'nada', 'não', 'naquela', 
        'naquelas', 'naquele', 'naqueles', 'nas', 'nem', 'nenhum', 'nenhuma', 'nessa', 'nessas', 'nesse', 'nesses', 'nesta', 
        'nestas', 'neste', 'nestes', 'ninguém', 'nível', 'no', 'noite', 'nome', 'nos', 'nós', 'nossa', 'nossas', 'nosso', 'nossos', 
        'nova', 'novas', 'nove', 'novo', 'novos', 'num', 'numa', 'número', 'nunca', 'o', 'obra', 'obrigada', 'obrigado', 'oitava', 
        'oitavo', 'oito', 'onde', 'ontem', 'onze', 'os', 'ou', 'outra', 'outras', 'outro', 'outros', 'para', 'parece', 'parte', 
        'partir', 'paucas', 'pela', 'pelas', 'pelo', 'pelos', 'pequena', 'pequenas', 'pequeno', 'pequenos', 'per', 'perante', 
        'perto', 'pode', 'pude', 'pôde', 'podem', 'podendo', 'poder', 'poderia', 'poderiam', 'podia', 'podiam', 'põe', 'põem', 
        'pois', 'ponto', 'pontos', 'por', 'porém', 'porque', 'porquê', 'posição', 'possível', 'possivelmente', 'posso', 'pouca', 
        'poucas', 'pouco', 'poucos', 'primeira', 'primeiras', 'primeiro', 'primeiros', 'própria', 'próprias', 'próprio', 'próprios', 
        'próxima', 'próximas', 'próximo', 'próximos', 'pude', 'puderam', 'quais', 'quáis', 'qual', 'quando', 'quanto', 'quantos', 
        'quarta', 'quarto', 'quatro', 'que', 'quê', 'quem', 'quer', 'quereis', 'querem', 'queremas', 'queres', 'quero', 'questão', 
        'quinta', 'quinto', 'quinze', 'relação', 'sabe', 'sabem', 'são', 'se', 'segunda', 'segundo', 'sei', 'seis', 'seja', 'sejam', 
        'sejamos', 'sem', 'sempre', 'sendo', 'ser', 'será', 'serão', 'serei', 'seremos', 'seria', 'seriam', 'seríamos', 'sete', 
        'sétima', 'sétimo', 'seu', 'seus', 'sexta', 'sexto', 'si', 'sido', 'sim', 'sistema', 'só', 'sob', 'sobre', 'sois', 'somos', 
        'sou', 'sua', 'suas', 'tal', 'talvez', 'também', 'tampouco', 'tanta', 'tantas', 'tanto', 'tão', 'tarde', 'te', 'tem', 'tém', 
        'têm', 'temos', 'tendes', 'tendo', 'tenha', 'tenham', 'tenhamos', 'tenho', 'tens', 'ter', 'terá', 'terão', 'terceira', 
        'terceiro', 'terei', 'teremos', 'teria', 'teriam', 'teríamos', 'teu', 'teus', 'teve', 'ti', 'tido', 'tinha', 'tinham', 
        'tínhamos', 'tive', 'tivemos', 'tiver', 'tivera', 'tiveram', 'tivéramos', 'tiverem', 'tivermos', 'tivesse', 'tivessem', 
        'tivéssemos', 'tiveste', 'tivestes', 'toda', 'todas', 'todavia', 'todo', 'todos', 'trabalho', 'três', 'treze', 'tu', 'tua', 
        'tuas', 'tudo', 'última', 'últimas', 'último', 'últimos', 'um', 'uma', 'umas', 'uns', 'vai', 'vais', 'vão', 'vários', 
        'vem', 'vêm', 'vendo', 'vens', 'ver', 'vez', 'vezes', 'viagem', 'vindo', 'vinte', 'vir', 'você', 'vocês', 'vos', 'vós', 
        'vossa', 'vossas', 'vosso', 'vossos', 'zero', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '_', "i", "me", "my", 
        "myself", "we", "our", "ours", "ourselves", "you", "your", "yours", "yourself", "yourselves", "he", "him", "his", "himself", 
        "she", "her", "hers", "herself", "it", "its", "itself", "they", "them", "their", "theirs", "themselves", "what", "which", 
        "who", "whom", "this", "that", "these", "those", "am", "is", "are", "was", "were", "be", "been", "being", "have", "has", 
        "had", "having", "do", "does", "did", "doing", "a", "an", "the", "and", "but", "if", "or", "because", "as", "until", 
        "while", "of", "at", "by", "for", "with", "about", "against", "between", "into", "through", "during", "before", "after", 
        "above", "below", "to", "from", "up", "down", "in", "out", "on", "off", "over", "under", "again", "further", "then", 
        "once", "here", "there", "when", "where", "why", "how", "all", "any", "both", "each", "few", "more", "most", "other", 
        "some", "such", "no", "nor", "not", "only", "own", "same", "so", "than", "too", "very", "s", "t", "can", "will", "just", 
        "don", "should", "now", ".", ",", "!", "?", ";", "-", "_", "&", ":"
    );

    foreach ($Table_Info as $row) {
        $post = $row['Post'];
        // 'preg_split' é usada com a expressão regular '/\s+|\p{P}/u' para dividir a string em palavras.
        // Considera tanto os espaços em branco (\s+) quanto os caracteres de pontuação (\p{P}) como delimitadores  
        // A opção PREG_SPLIT_NO_EMPTY é usada para excluir os valores vazios resultantes da divisão.
        $words = preg_split('/\s+|\p{P}/u', $post, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($words as $word) {
            // Remover espaços em branco e converter para minúsculas
            $word = strtolower(trim($word));
            $palavra = strtolower($palavra);
            if (!empty($word) && !in_array($word, $stopWords) && $word != $palavra) {
                // Utilizar: strpos($palavra, $word) === false para conferir a última
                if (!isset($wordCount[$word])) {
                    $wordCount[$word] = 1;
                } else {
                    $wordCount[$word]++;
                }
            }
        }
    }
    // Ordenar o array pela contagem de palavras em ordem decrescente
    arsort($wordCount);
    // Selecionar as 10 palavras mais frequentes
    $topWords = array_slice($wordCount, 0, 10, true);
    // Obter todas as palavras do array de contagem
    $words = array_keys($wordCount);
    // Converter os dados das palavras filtradas em JSON para usar no gráfico
    $labels = array_keys($topWords);
    $data = array_values($topWords);
    $chartData = json_encode(array('labels' => $labels, 'data' => $data));
?>

<!-- Caso existam resultados -->
<?php if (!empty($Table_Info)) :?>
    <!-- Div que mostra o resumo dos dados obtidos -->
    <div id="sucessoTW" class="alert alert-success mx-auto text-center border mt-5 mb-4" style="width: 50%;" role="alert">
        <h5>Foram encontrados <u><strong><?php echo count($Table_Info)?></strong></u> resultados!</h5>
        <hr>
        <h5>Palavra(s) introduzida(s): <u><strong><?php echo ($palavra)?></strong></u>.</h5>
        <hr>
        <h5>Datas: <u><strong><?php echo ($inicio_date)?></strong></u>/<u><strong><?php echo ($fim_date)?></strong></u></h5> 
        <hr>
        <button id="verResultadosEst" type="button" class="btn btn-primary">Ver Resultados</button>
    </div>
    <!-- Div que mostra o gráfico dos dados obtidos -->
    <div id="topWordsGraph" class="mt-5 mb-3 p-3 mx-auto rounded" style="width: 80%; background-color: #E0E0E0">
        <h4 class="text-center pb-3 pt-3 mb-4 rounded " style="font-family: 'Secular One', sans-serif; background: linear-gradient(to right, #1c2331, #384f66); color: white; text-shadow: 2px 2px 4px #000000;">Palavras Mais Frequentes</h4>
        <?php 
            echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
            echo '<canvas id="chart"></canvas>';
            echo '<script>
                var ctx = document.getElementById("chart").getContext("2d");
                var chartData = ' . $chartData . ';

                new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: "Frequência",
                            data: chartData.data,
                            backgroundColor: "rgba(54, 124, 171, 0.8)",
                            borderColor: "rgba(75, 192, 192, 1)",
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }
                    }
                });
            </script>';
        ?>
    <?php endif; ?>
</div>

<script>
    //--------------------------------------------------------------------------------------
    // Obtém as referências para as divs que será movida e para o elemento pai dela
    var div1 = document.getElementById("infoEst");
    var div3 = document.getElementById("formEst");
    var elementoPai = div1.parentNode;
    // Obtém a referência para a nova div que será inserida
    var sucesso = document.getElementById("sucessoTW");
    // Insere a nova div entre as outras
    elementoPai.insertBefore(sucesso, div3);

    // Obtém a referência para o botão e para a tabela
    var botao = document.getElementById("verResultadosEst");
    var resultados = document.getElementById("topWordsGraph");

    // Adiciona um manipulador de eventos ao botão
    botao.addEventListener("click", function() {
        // Usa o método scrollIntoView() para rolar até a tabela
        resultados.scrollIntoView();
    });
    //--------------------------------------------------------------------------------------
</script>