<?php


require_once 'includes/functions.php';
require_once DB_URL;
/**
 * Incluir el archivo header.php, el cual contiene los metadatos de la página, titulo de la página 
 * y las importaciones de los archivos css
 */
include_template('header');
$db = db_connect();
$reports = [];
$teams_1 = [];
$query = 'SELECT team.id, team.name FROM team INNER JOIN region ON team.regionid = region.id WHERE region.id = 1';
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $teams_1[] = $row;
}


$teams_2 = [];
$query = 'SELECT team.id, team.name FROM team INNER JOIN region ON team.regionid = region.id WHERE region.id = 2';
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $teams_2[] = $row;
}

$teams_3 = [];
$query = 'SELECT team.id, team.name FROM team INNER JOIN region ON team.regionid = region.id WHERE region.id = 3';
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $teams_3[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if ($_POST['report'] === 'team') {
        $errors = [];
        $team_1 = $_POST['team1'] ?? null;
        $team_2 = $_POST['team2'] ?? null;
        $team_3 = $_POST['team3'] ?? null;

        if (empty($team_1)) {
            $errors[] = 'El equipo norteamericano es requerido';
        }

        if (empty($team_2)) {
            $errors[] = 'El equipo centroamericano es requerido';
        }

        if (empty($team_3)) {
            $errors[] = 'El equipo suramericano es requerido';
        }

        if (empty($errors)) {
            for ($i = 1; $i <= 3; $i++) {
                $query = 'SELECT *, team.name as team, region.name as region FROM player INNER JOIN team ON player.teamid = team.id INNER JOIN region ON team.regionid = region.id WHERE team.id = ?';
                $stmt = $db->prepare($query);
                $stmt->bindParam(1, $_POST['team' . $i]);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $reports[] = $row;
                }
            }
        }
    } else if ($_POST['report'] === 'player') {
        $errors = [];
        $team = $_POST['team'] ?? null;

        if (empty($team)) {
            $errors[] = 'El equipo norteamericano es requerido';
        }

        if (empty($errors)) {
            $query = 'SELECT player.first_name, player.last_name FROM player INNER JOIN team ON player.teamid = team.id INNER JOIN region ON team.regionid = region.id WHERE team.id = ? AND player.year_old < 30';
            $stmt = $db->prepare($query);
            $stmt->bindParam(1, $team);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $reports[] = $row;
            }
        }
    }
}


?>
<!--Inicio de Body -->

<div class="container h-auto">
    <div class="d-flex justify-content-between align-items-center">
        <div class="my-5 d-flex justify-content-center align-items-center gap-3">
            <a href="<?php echo empty($_POST['report']) ? '/' : '/reportes.php' ?>" class="text-secondary" title="Regresar"><i class="fa-solid fa-arrow-left-long"></i></a>
            <h2>Reportes</h2>
        </div>
    </div>
    <div>
        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <?php echo $errors[0] ?>
            </div>
        <?php endif; ?>
        <div class="mb-5 reportTeam <?php echo empty($_POST['report']) ? '' : ($_POST['report'] === 'player' ? 'd-none' : '') ?>">
            <h3>Reportes por equipos según su región</h3>
            <hr>
            <form action="reportes.php" class="d-flex flex-column flex-lg-row gap-3" method="POST">
                <div>
                    <label class="form-label" for="team1">Equipo Norteamericano</label>
                    <select class="form-select" name="team1" id="team1">
                        <option selected value="" disabled>Seleccione un equipo</option>
                        <?php foreach ($teams_1 as $team) : ?>
                            <option value="<?php echo $team["id"] ?>" <?php echo $team['id'] === intval($team_1 ?? '') ? 'selected' : ''  ?>><?php echo $team['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="report" value="team">
                </div>
                <div>
                    <label class="form-label" for="team2">Equipo Centroamericano</label>
                    <select class="form-select" name="team2" id="team2">
                        <option selected value="" disabled>Seleccione un equipo</option>
                        <?php foreach ($teams_2 as $team) : ?>
                            <option value="<?php echo $team["id"] ?>" <?php echo $team['id'] === intval($team_2 ?? '') ? 'selected' : ''  ?>><?php echo $team['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="team3">Equipo Suramericano</label>
                    <select class="form-select" name="team3" id="team3">
                        <option selected value="" disabled>Seleccione un equipo</option>
                        <?php foreach ($teams_3 as $team) : ?>
                            <option value="<?php echo $team["id"] ?>" <?php echo $team['id'] === intval($team_3 ?? '') ? 'selected' : ''  ?>><?php echo $team['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="report" value="team">
                </div>
                <div class="align-self-end">
                    <button class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
        <div class="mb-5 reportPlayer <?php echo empty($_POST['report']) ? '' : ($_POST['report'] === 'team' ? 'd-none' : '') ?>">
            <h3>Reportes por equipo suramericano con jugadores menor a 30 años</h3>
            <hr>
            <form action="reportes.php" class="d-flex flex-column flex-lg-row gap-3" method="POST">
                <div>
                    <label class="form-label" for="team">Equipo Suramericano</label>
                    <select class="form-select" name="team" id="team">
                        <option selected value="" disabled>Seleccione un equipo</option>
                        <?php foreach ($teams_3 as $team) : ?>
                            <option value="<?php echo $team["id"] ?>" <?php echo $team['id'] === intval($_POST['team'] ?? '') ? 'selected' : ''  ?>><?php echo $team['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="report" value="player">
                </div>
                <div class="align-self-end">
                    <button class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
        <div class="reportContainer <?php echo empty($_POST['report']) ? 'd-none' : '' ?>">
            <?php if ($_POST['report'] === 'team') : ?>
                <?php if (!empty($reports)) : ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Edad</th>
                                <th>Equipo</th>
                                <th>Región</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reports as $report) : ?>
                                <tr>
                                    <td><?php echo $report['first_name'] ?></td>
                                    <td><?php echo $report['last_name'] ?></td>
                                    <td><?php echo $report['year_old'] ?></td>
                                    <td><?php echo $report['team'] ?></td>
                                    <td><?php echo $report['region'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                <?php else : ?>
                    <div class="alert alert-info">
                        <span>Los equipos no tienen jugadores</span>
                    </div>
                <?php endif; ?>
            <?php elseif ($_POST['report'] === 'player') :  ?>

                <?php if (!empty($reports)) : ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reports as $report) : ?>
                                <tr>
                                    <td><?php echo $report['first_name'] ?></td>
                                    <td><?php echo $report['last_name'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="alert alert-info">
                        <span>Los equipos no tienen jugadores</span>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<!--Fin del Body -->
<?php
/**
 * Incluir el archivo footer.php, el cual contiene el footer de la página y las importaciones de los archivos de javascript
 */
include_template('footer');
?>