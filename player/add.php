<?php


require_once '../includes/functions.php';
require_once DB_URL;
require_once 'countries.php';
/**
 * Incluir el archivo header.php, el cual contiene los metadatos de la página, titulo de la página 
 * y las importaciones de los archivos css
 */
include_template('header');

$db = db_connect();

if (empty($_GET['id'])) {
    header('Location: /');
}

$teamId = $_GET['id'];

$query = 'SELECT * FROM team WHERE id = ?';
$stmt = $db->prepare($query);
$stmt->bindParam(1, $teamId);
$stmt->execute();
if ($stmt->rowCount() === 0) {
    header('Location: /');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $errors = [];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $year_old = trim($_POST['year_old']);
    $countryid = $_POST['country'] ?? null;


    if (empty($first_name)) {
        $errors[] = 'El nombre es requerido';
    }

    if (strlen(trim($first_name)) < 3 || strlen(trim($first_name)) > 10) {
        $errors[] = 'El nombre debe de tener al menos 3 caracteres y máximo 10';
    }

    if (empty($last_name)) {
        $errors[] = 'El nombre es requerido';
    }

    if (strlen(trim($last_name)) < 3 || strlen(trim($last_name)) > 10) {
        $errors[] = 'El nombre debe de tener al menos 3 caracteres y máximo 10';
    }

    if (empty($year_old)) {
        $errors[] = 'La edad es requerida';
    }

    if ($year_old < 18 || $year_old > 36) {
        $errors[] = 'La edad minima debe ser de 18 y máximo 36';
    }

    if (empty($countryid)) {
        $errors[] = 'El pais es requerido';
    }
    if (empty($errors)) {
        $query = 'INSERT INTO player (first_name, last_name, country, year_old, teamid) VALUES (?,?,?,?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $first_name);
        $stmt->bindParam(2, $last_name);
        $stmt->bindParam(3, $countryid);
        $stmt->bindParam(4, $year_old);
        $stmt->bindParam(5, $teamId);
        $stmt->execute();
        header('Location: /');
    }
}


?>
<!--Inicio de Body -->

<div class="container addPlayer mt-5 justify-content-center col-12 d-flex">
    <form action="add.php?id=<?php echo $teamId ?>" method="POST" class="form card shadow p-3  col-12 col-lg-4" novalidate>
        <div>
            <a href="/" class="text-secondary" title="Regresar"><i class="fa-solid fa-arrow-left-long"></i></a>
        </div>
        <div class="d-flex flex-column gap-2 p-5 ">
            <h2 class="text-center text-primary">Agregar Jugador</h2>
            <div class="alert-container">
                <?php if (!empty($errors)) : ?>
                    <div class="alert alert-danger">
                        <span><?php echo $errors[0] ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label fw-bold">
                    Primer Nombre
                </label>
                <input required class="form-control" type="text" placeholder="Osmar" name="first_name" id="first_name" value="<?php echo empty($first_name) ? '' : $first_name  ?>" />
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label fw-bold">
                    Primer Apellido
                </label>
                <input required class="form-control" type="text" placeholder="Ortiz" name="last_name" id="last_name" value="<?php echo empty($last_name) ? '' : $last_name  ?>" />
            </div>
            <div class="mb-3">
                <label for="year_old" class="form-label fw-bold">
                    Edad
                </label>
                <input required class="form-control" type="number" placeholder="18" name="year_old" id="year_old" value="<?php echo empty($year_old) ? '' : $year_old  ?>" />
            </div>
            <div class="mb-3">
                <label for="country" class="form-label fw-bold">
                    Pais
                </label>
                <select class="form-select" name="country" id="country">
                    <option selected disabled value="">Selecciona un pais</option>
                    <?php foreach ($countries as $key => $country) : ?>
                        <option value="<?php echo $key ?>" <?php echo $key === intval($countryid ?? -1) ? 'selected' : '' ?>><?php echo $country ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-primary">Añadir</button>
        </div>
    </form>
</div>

<!--Fin del Body -->
<?php
/**
 * Incluir el archivo footer.php, el cual contiene el footer de la página y las importaciones de los archivos de javascript
 */
include_template('footer', false);
?>