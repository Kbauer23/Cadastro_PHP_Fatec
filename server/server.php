<?php
// Funções utilizadas: 
//  -md5()
//  -gettimeofday()
//  -move_uploaded_file();
//  -date_diff()

// Recebendo valores via POST
$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$email = $_POST['email'];
$password = md5($_POST['password']); // Aqui a senha é criptografada com o hash md5
$repassword = md5($_POST['re-password']);
$birthDate = new DateTime($_POST['birth-date']);

$todayDate = new DateTime(date('y-m-d'));

// A função date_diff() é usada para obter a diferença em dias, meses ou anos entre duas data. Neste caso, usamos para definir a idade do usuário com base em sua data de nascimento
$intervall = date_diff($birthDate, $todayDate);
$age = $intervall->format('%y anos');

if (isset($_FILES['image'])) {
  $imageTmpName = $_FILES['image']['tmp_name'];
  $destination = "../src/";

  // Usando a função gettimeofday() em conjunto com a função md5() para gerar um nome aleatório e diferente para cada arquivo
  $imageName = md5(gettimeofday(true)) . ".jpg";

  // move_uploaded_file()
  if (move_uploaded_file($imageTmpName, $destination . $imageName)) {
    $statusMove = 1;
  } else {
    $statusMove = "Infelizmente houve um erro ao mover o arquivo";
  }
} else {
  $statusMove = "Neste caso, nenhuma imagem foi selecionada";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../style/response.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet" />
  <title>Cadastro</title>
</head>

<body>
  <section>
  <div class="container">
    <div>
      <p>
        Esta é uma resposta gerada pelo servidor. Normalmente, esta pagina não existiria, os dados recebidos pelo
        servidor atraves da requisição <b><i>POST</i></b> serião validados, tratados e persistidos em um banco de dados.
        Porém, para fins academicos, aqui vai um breve resumo do que ocorreu no server side.
      </p><br>
      <p>
        O usuário de nome <b>
          <?php echo $firstName . " " . $lastName ?>
        </b> informou o endereço de email <b>
          <?php echo $email ?>
        </b>
      </p><br>
      <p>
        Graças a função <b>md5()</b>, foi possível criptografar sua senha, e este é o resultado: <b>
          <?php echo $password ?>
        </b>.
      </p><br>
      <p>
        A data de nascimento informada foi <b>
          <?php echo $birthDate->format('d/m/y') ?>
        </b> e, a partir da função <b>date_diff()</b>, pudemos definir sua idade de <b>
          <?php echo $age ?>
        </b>, já que a função retorna o intervalo entre duas datas.
      </p><br>
      <p>
        Uma função muito útil do php é a <b>move_uploaded_file()</b>, que permite mover um arquivo que tenha sido
        enviado pelo mecanismo PHP de envio por POST HTTP, caso seja um arquivo válido.
        <?php
        if ($statusMove == 1) {
          echo "</p><br><p>O usuário selecionou uma imagem valida e, por meio da função <b>gettimeofday()</b>, em conjunto com a função <b>md5()</b>, pudemos gerar um nome aleatório para a identificarmos o arquivo no servidor. A imagem foi movida com sucesso e nesce caso seu novo nome <b>\" $imageName\"</b> seria persistido no banco de dados.</p><br><p>A imagem que vemos ao lado foi carregada diretamente do servidor, no caminho <b>$destination.$imageName</b>";
        } else {
          echo $statusMove . ", porém por meio da função gettimeofday(), em conjunto com a função md5(), poderiamos gerar um nome aleatório para a identificarmos o arquivo no servidor. Deste modo evitamos sobrecarregar o banco de dados com arquivos, persistindo nele somente o caminho da imagem no servidor.";
        }
        ?>
      </p>
    </div>
      </div>
  <div class="section-img">
    <img src="<?php echo $destination . $imageName ?>" alt="">
      </div>
      </section>
  <footer>
    <div class="copy">
      <p>&copy;Copyrigth by:
      </p>
    </div>
    <div>
      <div>
        <p>Kayke Bauer Santana Marins
        </p>
      </div>
      <div>
        <p>
          Lucas da Silva Oliveira
        </p>
      </div>
      <div>
        <p> Thomas Pavin Capello</p>
      </div>
    </div>
  </footer>
</body>

</html>
