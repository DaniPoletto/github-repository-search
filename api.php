<?php

// URL da API do GitHub para listar os repositórios do usuário
$url = 'https://api.github.com/users/DaniPoletto/repos?sort='.$_POST['searchOrder']
    .'&direction='.$_POST["searchDirection"];

// Configura a solicitação cURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Accept: application/vnd.github.v3+json'
));

// Faz a solicitação GET para a API do GitHub
$response = curl_exec($curl);

// Verifica se houve erros na solicitação cURL
if ($response === false) {
  echo "Erro na solicitação cURL: " . curl_error($curl);
  exit;
}

// Analisa a resposta da API como objeto JSON
$repositories = json_decode($response);

$i = 1;
// Exibe os nomes dos repositórios
foreach ($repositories as $repository) {
    // var_dump($repository);

    // Verifica se o nome do repositório contém a substring 
    if (!empty($_POST["searchTerm"]) && strpos($repository->name, $_POST["searchTerm"]) === false) {
        continue; // Pula para a próxima iteração do loop
    }

    if (!empty($_POST["searchLanguage"]) && strpos($repository->language, $_POST["searchLanguage"]) === false) {
        continue; // Pula para a próxima iteração do loop
    }

    echo $i++." - ".$repository->name . "<br>\n";
    echo " -- ".$repository->language . "<br><br>\n";
}

// Encerra a sessão cURL
curl_close($curl);
?>