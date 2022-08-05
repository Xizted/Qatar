<?php


require_once 'includes/functions.php';
require_once DB_URL;
/**
 * Incluir el archivo header.php, el cual contiene los metadatos de la página, titulo de la página 
 * y las importaciones de los archivos css
 */
include_template('header');
$db = db_connect();

$teams_1 = [];
$query = 'SELECT team.id, team.name, region.name as region FROM team INNER JOIN region ON team.regionid = region.id WHERE region.id = 1';
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $teams_1[] = $row;
}


$teams_2 = [];
$query = 'SELECT team.id, team.name, region.name as region FROM team INNER JOIN region ON team.regionid = region.id WHERE region.id = 2';
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $teams_2[] = $row;
}

$teams_3 = [];
$query = 'SELECT team.id, team.name, region.name as region FROM team INNER JOIN region ON team.regionid = region.id WHERE region.id = 3';
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $teams_3[] = $row;
}



?>
<!--Inicio de Body -->

<div class="container h-auto">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="my-5">Equipos</h2>
        <a href="/team/add.php" class="btn btn-outline-primary">Agregar Equipo</a>
    </div>
    <div style="overflow: auto;">
        <?php if (!empty($teams_1) && !empty($teams_2) && !empty($teams_3)) : ?>
            <div class="mb-3">
                <h2>Equipos Norteamericanos</h2>
                <hr>
                <div class="d-flex flex-column flex-lg-row flex-wrap gap-5">
                    <?php foreach ($teams_1 as $team) : ?>
                        <a href="player/index.php?id=<?php echo $team['id'] ?>" class="text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <h5><?php echo $team['name'] ?></h5>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="mb-3">
                <h2>Equipos Centroamericano</h2>
                <hr>
                <div class="d-flex flex-column flex-lg-row flex-wrap gap-5">
                    <?php foreach ($teams_2 as $team) : ?>
                        <a href="player/index.php?id=<?php echo $team['id'] ?>" class="text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <h5><?php echo $team['name'] ?></h5>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="mb-3">
                <h2>Equipos Suramericano</h2>
                <hr>
                <div class="d-flex flex-column flex-lg-row flex-wrap gap-5">
                    <?php foreach ($teams_3 as $team) : ?>
                        <a href="player/index.php?id=<?php echo $team['id'] ?>" class="text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <h5><?php echo $team['name'] ?></h5>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-info">
                <span>No Hay equipos registrado</span>
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