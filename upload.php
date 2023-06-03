<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'multipart/form-data') {
  // Processar o upload do arquivo aqui
  if (isset($_FILES['image'])) {
// Diretório de destino para o upload
$targetDir = 'uploads/';

// Verificar se o diretório de destino existe, caso contrário, criar
if (!file_exists($targetDir)) {
  mkdir($targetDir, 0777, true);
}

// Verificar se foi enviado um arquivo
if ($_FILES['image']) {
  $targetFile = $targetDir . basename($_FILES['image']['name']);
  $uploadOk = true;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Verificar se o arquivo é uma imagem
  $check = getimagesize($_FILES['image']['tmp_name']);
  if ($check === false) {
    echo 'O arquivo enviado não é uma imagem.';
    $uploadOk = false;
  }

  // Verificar se o arquivo já existe
  if (file_exists($targetFile)) {
    echo 'O arquivo já existe.';
    $uploadOk = false;
  }

  // Verificar o tamanho máximo do arquivo (aqui definido para 5MB)
  if ($_FILES['image']['size'] > 5000000) {
    echo 'O tamanho máximo permitido para upload é de 5MB.';
    $uploadOk = false;
  }

  // Permitir apenas determinados formatos de arquivo (aqui definido para JPG, JPEG, PNG e GIF)
  $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
  if (!in_array($imageFileType, $allowedFormats)) {
    echo 'Apenas são permitidos arquivos JPG, JPEG, PNG e GIF.';
    $uploadOk = false;
  }

  // Verificar se houve algum erro durante o upload
  if ($uploadOk === false) {
    echo 'O arquivo não pôde ser enviado.';
  } else {
    // Mover o arquivo para o diretório de destino
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
      echo 'O arquivo foi enviado com sucesso.';
    } else {
      echo 'Houve um erro durante o envio do arquivo.';
    }
  }
}
?>
