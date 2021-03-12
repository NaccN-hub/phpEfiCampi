<?php
session_start();
include_once "./functions/conexion.php";

if(!isset($_SESSION['active'])){
  if($_SESSION['username']=="admin"){
    header("Location: /efiphp/admin/");
  }else{
    header("Location: /efiphp/login.php");
  }
}

    

function logout(){
    session_destroy();
    header('Location: login.php');
}

if(array_key_exists('logout',$_POST)){
    logout();
 }

$result = $conn->query("SELECT * FROM posts ORDER BY id;");

$result_categories = $conn->query("SELECT * FROM categories ORDER BY id;");

while ($row_category = $result_categories->fetch_assoc()){
  $dataCategories[] = [
    "id" => (string)$row_category['id'],
    "nombre" => (string)$row_category['name']
  ];
}
echo "datacategories";
var_dump($dataCategories);


$cant_resultados = mysqli_num_rows($result);
$cant_categories =  mysqli_num_rows($result_categories);
echo "categories";
echo $cant_categories;
echo "\n";
echo $cant_resultados;



$resultNombres = $conn->query("SELECT DISTINCT usuarios.nombre, usuarios.id, usuarios.id_fotoperfil FROM usuarios, posts WHERE usuarios.id = posts.id_user ;");

$cant_nombres = mysqli_num_rows($resultNombres);


while($row = $resultNombres->fetch_assoc()){
  $dataNombres[] =[
  "nombre" => (string)$row['nombre'],
  "id" => (string)$row['id'],
  "id_fotoperfil" => (string)$row['id_fotoperfil']
  ]; 
}


$datos = mysqli_fetch_array($result);
var_dump($datos);

$id_user = $_SESSION['idUser'];

$resultUser = $conn->query("SELECT * FROM usuarios WHERE id= '$id_user';");
$user = $resultUser->fetch_assoc();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Grandstander:ital,wght@1,200&family=Roboto+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/estilos.css">

    <title>Musiblog</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-white fixed-top">
        <div class="container text-center">
          <img src="././img/logoNavbar.png" class="logoNavbarConfig" alt="">
          <a class="navbar-brand text-dark text-center" href="#" style="margin-left: 40px"> Bienvenido al mundo de la musica, <?php echo $_SESSION["username"];?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <form method="POST">
                        <button name="logout" id="logout" class="btn btn-secondary" style="margin-right: 10px">Cerrar sesion</button>
                    </form>
                </li>
                <li class="nav-item active">
                    <a href="edituser.php?id=<?php echo $_SESSION['idUser']; ?>" class="btn btn-d
                    ark">Editar Datos</a>
                </li>
            </ul>
          </div>
        </div>
    </nav>

  <!-- Contenido -->
  <div class="container text-center tablaPostConfig" style="">

    <div class="">

      <!-- Post Content Column -->
      <div class="">

        <!-- Title -->
        <h1 class="mt-4 text-white text-center">Que estas pensando?</h1>

        <?php if(isset($user['estado'])&& $user['estado'] != "") : ?>

          <h3 class="bg-white text-center"><b class="text-dark">Tu ultima actualizacion:</b><br><small><?php echo $user['estado'];?></small></h3>
        <?php elseif($user['estado']==""): ?>
          <h3 class="bg-success rounded-lg"><b>Escribe tu estado, No pierdas el tiempo!:</b></h3>
        <?php else: ?>
          <h3 class="bg-success rounded-lg"><b>Escribe tu estado, No pierdas el tiempo!:</b></h3>
        <?php endif ?>

        <hr>
        
        <div class="card my-4">
          <h5 class="card-header text-center">Cuenta como estas hoy</h5>
          <div class="card-body">
            <form action="./functions/savestatus.php" method="POST">
              <div class="form-group">
                <input class="text-white" type="hidden" name="id_user" value="<?php echo $_SESSION['idUser'];?>">
                <textarea type="text" name="estado" id="estado" class="form-control" rows="1" maxlength="255" ></textarea>
                <button type="submit" class="btn btn-info btn-block">Actualizar</button>
              </div>
              
            </form>
          </div>
        </div>

        <!-- Comments Form -->
        <div class="card my-4">
          <h5 class="card-header text-center">Escribe tu post</h5>
          <div class="card-body">
            <form action="./functions/savepost.php" method="POST">
              <div class="form-group">
                <input type="hidden" name="id_user" value="<?php echo $_SESSION['idUser'];?>" placeholder="Escribelo">
                <textarea name="texto" id="texto" class="form-control" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label for="sel1">Selecciona la categoria:</label>
                <select class="form-control" id="category_id" name="category_id">
                  <?php foreach($dataCategories as $category) :?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['nombre']; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <button type="submit" class="btn btn-info">Publicar</button>
            </form>
          </div>
        </div>

        <!-- Single Comment -->

      <h2 class="text-center text-light">Otros posts</h2>

      <?php while($row = $result->fetch_assoc()): ?>
          <div class="media mb-4 text-center tablaPostConfig">
          <?php  for($i = 0; $i < $cant_nombres; $i++) : ?>
                <?php if($row["id_user"] == $dataNombres[$i]['id']) : ?>
                    <img class="d-flex mr-3 rounded-circle" src="<?php echo $dataNombres[$i]['id_fotoperfil']; ?>" width="60px">
                    <div class="media-body bg-info rounded-lg">
                    <h4  class="mt-0  "><b><?php echo $dataNombres[$i]['nombre']; ?></b></h4>
                    <?php foreach($dataCategories as $category): ?>
                      <?php if ($category["id"] == $row["id_category"] ) :?>
                        <p><b class="bg-info rounded-lg"> Categoria: <?php echo $dataCategories[$i]['nombre']; ?></b></p>
                      <?php endif  ?>
                    <?php endforeach  ?>
                <?php endif  ?>
          <?php endfor  ?>
              
                <small class="bg-info rounded-lg "><b>Posteo:</b></small>
                <p id = "post" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-dark rounded-pill" style="padding-left: 2%; color: white ;"><?php echo $row['post'];?> <?php if($row["id_user"] == $id_user) : ?><a href="editpost.php?id=<?php echo $row["id"]; ?>">EDITAR</a><?php endif  ?></p>
              
            
            </div>
          </div>
        
      <?php endwhile ?>
    
      </div>

      <!-- Sidebar Widgets Column -->
      
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-light">
    <div class="row">
      <div class="col-md-4 text-center">
                  <a href="https://twitter.com/" target="_blank">
                    <img class="d-inline-block logoFooterAjuste" src="././img/twitterLogo.png">
                  </a>
                  <a href="https://www.facebook.com/" target="_blank">
                    <img class="d-inline-block logoFooterAjuste" src="././img/facebookLogo.png">
                  </a>
                  <a href="https://www.instagram.com/" target="_blank">
                    <img class="d-inline-block logoFooterAjuste" src="././img/instagramLogo.png">
                  </a>  
      </div>
      <div class="col-md-4 text-center">
        <p class="m-0 text-center text-dark">MusiBlog - Río Cuarto│Tel:+543589999│Moreno 999│Copyright © 2021 MusiBlog - Natalio Campi</p></div>
      <div class="col-md-4 text-center">
        <img src="././img/logoNavbar.png" class="logoFooterAjuste">
        <img src="././img/logoNavbar.png" class="logoFooterAjuste">
        <img src="././img/logoNavbar.png" class="logoFooterAjuste">
        <img src="././img/logoNavbar.png" class="logoFooterAjuste">
      </div>
      
    </div>
    <!-- /.container -->
  </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>