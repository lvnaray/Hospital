<div class="ps-5 pe-5 pt-3 my-container active-cont">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Rol</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
            <h1>Roles</h1>
            <a href="rol.php?action=create" class="btn btn-success"><i class="fa fa-plus p-1 icons"></i>
                Agregar
            </a>
            <div class="d-flex flex-row-reverse">
                <form action="roles.php" method="GET">
                    <input class="input-group-text pe-1" style="display:inline-block;" type="text" name="busqueda">
                    <button class="btn btn-outline-secondary" type="submit">
                        Buscar
                        <i class="fa fa-search p-1 icons"></i>
                    </button>
                </form>
            </div>
            <?php foreach ($datos as $key => $rol) : ?>
                <tr>
                    <td rowspan=2><?= $rol['id_rol'] ?></td>
                    <td><?= $rol['rol'] ?></td>
                    <td>
                        <a href="rol.php?action=show&id_rol=<?= $rol['id_rol'] ?>" class="btn btn-primary">
                            <i class="fa fa-arrow-up p-1 icons"></i>
                        </a>
                        <a href="rol.php?action=permiso&id_rol=<?= $rol['id_rol'] ?>" class="btn btn-secondary">
                            <i class="fa fa-user-friends p-1 icons"></i>
                        </a>
                        <a href="rol.php?action=delete&id_rol=<?= $rol['id_rol'] ?>" class="btn btn-danger">
                            <i class="fa fa-trash p-1 icons"></i>
                        </a>
                        <a href="rol.php?action=no_permiso&id_rol=<?= $rol['id_rol'] ?>" class="btn btn-danger">
                            <i class="fa fa-user-friends p-1 icons"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><b>Permisos:</b>
                        <?php
                        foreach ($permiso->getPermisosRol($rol['id_rol']) as $key => $permisos) :
                            print_r($permisos['permiso'] . ", ");
                        endforeach;
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php for ($i = 0, $k = 1; $i < $roles->total(); $i += 5, $k++) : ?>
                <li class="page-item"><a class="page-link" href="roles.php?<?php echo (isset($_GET['busqueda'])) ? 'busqueda=' . $_GET['busqueda'] . '&' : ''; ?>&desde=<?php echo ($i); ?>&limite=5"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
    echo "Filtrando " . count($datos) . " de un total del " . $roles->total() . " roles"
    ?>
</div>