<?php


require_once '../includes/functions.php';
require_once DB_URL;
/**
 * Incluir el archivo header.php, el cual contiene los metadatos de la página, titulo de la página 
 * y las importaciones de los archivos css
 */
include_template('header');

$db = db_connect();
$regions = [];

$query = 'SELECT * FROM region';
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $regions[] = $row;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $errors = [];
    $name = trim($_POST['name']);
    $regionid = $_POST['region'] ?? null;


    if (empty($name)) {
        $errors[] = 'El nombre es requerido';
    }

    if (strlen(trim($name)) < 3 || strlen(trim($name)) > 50) {
        $errors[] = 'El nombre debe de tener al menos 3 caracteres y máximo 50';
    }

    if (empty($regionid)) {
        $errors[] = 'La region es requerido';
    }

    $query = 'SELECT name FROM team WHERE name = ?';
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $name);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $errors[] = 'El nombre del equipo ya existe';
    }


    if (empty($errors)) {

        $query = 'INSERT INTO team (name, regionid) VALUES (?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $regionid);
        $stmt->execute();
        header('Location: /');
    }
}


?>
<!--Inicio de Body -->
<div class="container addTeam  h-80">
    <div class="mt-5 justify-content-center col-12 d-flex">
        <form action="add.php" method="POST" class="form card shadow p-3  col-12 col-lg-4" novalidate>
            <div>
                <a href="/" class="text-secondary" title="Regresar"><i class="fa-solid fa-arrow-left-long"></i></a>
            </div>
            <div class="d-flex flex-column gap-2 p-5 ">
                <h2 class="text-center text-primary">Agregar Equipo</h2>
                <div class="alert-container">
                    <?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger">
                            <span><?php echo $errors[0] ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">
                        Nombre del equipo
                    </label>
                    <input required class="form-control" type="text" placeholder="Real Madrid" name="name" id="name" value="<?php echo empty($name) ? '' : $name  ?>" />
                </div>
                <div class="mb-3">
                    <label for="region" class="form-label fw-bold">
                        Región del equipo
                    </label>
                    <select class="form-select" name="region" id="region">
                        <option selected disabled value="">Selecciona una region</option>
                        <?php foreach ($regions as $region) : ?>
                            <option value="<?php echo $region['id'] ?>" <?php echo $region['id'] === intval($regionid ?? '') ? 'selected' : '' ?>><?php echo $region['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn btn-primary">Añadir</button>
            </div>
        </form>
    </div>
</div>

<!--Fin del Body -->
<?php
/**
 * Incluir el archivo footer.php, el cual contiene el footer de la página y las importaciones de los archivos de javascript
 */
include_template('footer', false);
?>