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

$query = 'SELECT id,name FROM team WHERE id = ?';
$stmt = $db->prepare($query);
$stmt->bindParam(1, $teamId);
$stmt->execute();
$team = $stmt->fetch(PDO::FETCH_ASSOC);
if ($stmt->rowCount() === 0) {
    header('Location: /');
}

$players = [];
$query = 'SELECT * FROM player WHERE teamid = ?';
$stmt = $db->prepare($query);
$stmt->bindParam(1, $teamId);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $players[] = $row;
}

?>
<!--Inicio de Body -->
<div class="container h-100">
    <div class="d-flex justify-content-between align-items-center">
        <div class="my-5 d-flex justify-content-center align-items-center gap-3">
            <a href="/" class="text-secondary" title="Regresar"><i class="fa-solid fa-arrow-left-long"></i></a>
            <h2>Jugadores del equipo <?php echo $team['name'] ?></h2>
        </div>
        <a href="add.php?id=<?php echo $teamId ?>" class="btn btn-outline-primary">Agregar Jugador</a>
    </div>
    <div style="overflow: auto;">
        <?php if (!empty($players)) : ?>
            <div style="overflow-x: auto;">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Edad</th>
                            <th>Pais</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($players as $key => $player) : ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $player['first_name'] ?></td>
                                <td><?php echo $player['last_name'] ?></td>
                                <td><?php echo $player['year_old'] ?></td>
                                <td><?php echo $countries[$player['country']] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="alert alert-info">
                <span>No Hay jugadores registrado en este equipo</span>
            </div>
        <?php endif; ?>
    </div>
</div>

<!--Fin del Body -->
<?php
/**
 * Incluir el archivo footer.php, el cual contiene el footer de la página y las importaciones de los archivos de javascript
 */
include_template('footer');
?>