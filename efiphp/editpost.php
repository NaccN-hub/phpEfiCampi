<?php
    require_once "./functions/conexion.php";
    session_start();

    $id_edit = $_GET['id'];

    $result = $conn->query("SELECT * FROM posts WHERE id= '$id_edit';");

    $post = $result->fetch_assoc();

    /* var_dump($post); */


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Grandstander:ital,wght@1,200&family=Roboto+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/estilos.css">

    <title>Editar post</title>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">

            <div class="card my-4">
            <h5 class="card-header">Edita el post:</h5>
            <div class="card-body">
                <form action="./functions/saveeditpost.php" method="POST">
                <div class="form-group">
                    <input type="hidden" name="id_post" value="<?php echo $post['id'];?>" placeholder="<?php echo $post['id'];?>">
                    <textarea name="texto" id="texto" class="form-control" rows="3" placeholder="<?php echo $post['post'];?>"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Finalizar edicion!</button>
                </form>
            </div>
            </div>

            </div>


        

        </div>

    </div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>