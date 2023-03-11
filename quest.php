<?php
include 'conect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtém os dados do formulário
  $pontos = 0; //variavel que determina se o usuario é elegivel atraves de uma soma de pontos
  $nome = $_POST["nome"];
  $email = $_POST["email"];
  $whatsapp = $_POST["whatsapp"];
  $doutorado = $_POST["doutorado"];
  $anosExperiencia = 0;
  $mestrado = $_POST["mestrado"];
  $anosmestrado = 0;
  $bacharel = $_POST["bacharel"];
  $anosbacharel = 0;
  $cursos = $_POST["curso"];
  $cartas = $_POST["cartas"];
  $contribuicao = $_POST["contribuicao"];
  $licensa = $_POST["licensa"];
  $classe = $_POST["classe"];
  $exp = $_POST["exp"];
  $prof = $_POST["prof"];
  $itens = $_POST["itens"];
  $itens_str = implode(", ", $itens);
  $area = $_POST["area"];
  $elegivel = "nao";

  if ($doutorado === "sim") {
    $anosExperiencia = $_POST["anos-experiencia"];
    $elegivel = "sim";

  }

  // Se a opção "Sim" for selecionada, define a variável $anosExperiencia com o valor do segundo select d se torna elegivel para o visto

  if ($mestrado === "sim") {
    $anosmestrado = $_POST["anos-mestrado"];
    $elegivel = "sim";
  }

  // Se a opção "Sim" for selecionada, define a variável $anosExperiencia com o valor do segundo select d se torna elegivel para o visto

  if ($bacharel === "sim") {
    $anosbacharel = $_POST["anos-bacharel"];
    $elegivel = "sim";
  }

  if ($_POST["pos"] == "sim") {
    $pontos += 1;
  }

  if ($_POST["curso"] == "sim") {
    $pontos += 1;
  }

  if ($_POST["cartas"] == "sim") {
    $pontos += 1;
  }

  if ($_POST["contribuicao"] == "sim") {
    $pontos += 1;
  }

  if ($_POST["licensa"] == "sim") {
    $pontos += 1;
  }

  if ($_POST["classe"] == "sim") {
    $pontos += 0.5;
  }

  if ($_POST["exp"] == "sim") {
    $pontos += 1;
  }

  if ($_POST["prof"] == "sim") {
    $pontos += 0.5;
  }

  // Verifique se pelo menos uma opção foi selecionada e adicione 1 ponto
  if (is_array($itens) && (in_array('artigos-publicados', $itens) || in_array('entrevistas', $itens) || in_array('reconhecimento-midia', $itens) || in_array('premios', $itens) || in_array('livros-publicados', $itens))) {
    $pontos += 1;
  }
  

  if (is_array($area) && (in_array('saude', $area) || in_array('educacao', $area) || in_array('ciencia', $area) || in_array('tecnologia', $area) || in_array('artes', $area) || in_array('negocios', $area) || in_array('empreendedorismo', $area) || in_array('engenharia', $area))) {
    $pontos += 0.5;
  }
  

  if ($pontos >= 3) {
    $elegivel = "sim";
  }
  if($elegivel === "sim"){
    echo "<script>window.location='obrigado.php'</script>";
  }else{
    echo "<script>window.location='espera.php'</script>";
  }
  
    // Prepara a consulta SQL para inserir os dados no banco de dados
  $sql = "INSERT INTO usuarios (nome, email, whatsapp, doutorado, anos_experiencia, mestrado, anos_mestrado, bacharel, anos_bacharel, cursos, recomendacao, contribuicao, licensa, associacao, experiencia, ganhos, itens, atuacao, elegivel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conexao, $sql);

    
    // Define os valores dos parâmetros na consulta SQL
  mysqli_stmt_bind_param($stmt, "sssssssssssssssssss", $nome, $email, $whatsapp, $doutorado, $anosExperiencia, $mestrado, $anosmestrado, $bacharel, $anosbacharel, $cursos, $cartas, $contribuicao, $licensa, $classe, $exp, $prof, $itens_str, $area, $elegivel);

    // Executa a consulta SQL
  mysqli_stmt_execute($stmt);

    // Verifica se a consulta foi executada com sucesso
  if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Dados inseridos com sucesso!";
  } else {
      echo "Erro ao inserir dados.";
  }
  
//   if ($pontos >= 3) {
//     $elegivel = "sim";
//   }
//   if($elegivel === "sim"){
//     include("obrigado.php");
//   }else{
//     include("espera.php");
//   }  
}
?>