<?php 
require_once('config.php');

// get path
$parent = isset($_GET['p']) ? $_GET['p'] : (isset($_POST['p']) ? $_POST['p'] : '');

// clean path
$parent = clean_path($parent);

$parent_path = get_parent_path($parent);
$path = clean_path(getRootPath());
if(isset($_GET['p']) && $_GET['p'] !== ''){
    $path .= '/'.$_GET['p'];
}

$objects = is_readable($path) ? scandir($path) : array();
$folders = array();
$files = array();
if (is_array($objects)) {
    foreach ($objects as $file) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        if (substr($file, 0, 1) === '.') {
            continue;
        }
        $new_path = $path . '/' . $file;
        if (@is_file($new_path)) {
            $files[] = $file;
        } elseif (@is_dir($new_path) && $file != '.' && $file != '..') {
            $folders[] = $file;
        }
    }
}
if (!empty($files)) {
    natcasesort($files);
}
if (!empty($folders)) {
    natcasesort($folders);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/logo-mini.png" type="image/png">
    <title><?php echo APP_TITLE; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="css/manager.css">
</head>

<body>
    <div class="container-fluid">

        <header class="mb-4">
            <nav class="navbar navbar-expand-sm navbar-light fixed-top bg-light main-nav mb-4">
                <a class="navbar-brand"><strong>File Manager</strong></a>
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                    data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <form class="form-inline ml-auto my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="text" id="search-addon" placeholder="Search">
                    </form>
                    <ul class="navbar-nav mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle"></i>
                                <?php echo ucfirst($_SESSION['userdata']['username']); ?></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <a class="dropdown-item" href="/index.php?logout=1">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

<?php
$num_files = count($files);
$num_folders = count($folders);
$all_files_size = 0;
?>

        <div class="pt-5">
            <table id="datatable" class="table table-bordered table-hover table-sm bg-white ">
                <thead>
                    <tr>
                        <th width="50px">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="js-select-all-items"
                                    onclick="checkbox_toggle()">
                                <label class="custom-control-label" for="js-select-all-items"></label>
                            </div>
                        </th>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Modified</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                    if ($parent_path !== false) {
                        ?>
                        <tr>
                            <td class="nosort"></td>
                            <td class="border-0"><a href="?p=<?php echo urlencode($parent_path) ?>"><i class="fa fa-chevron-circle-left go-back"></i> ..</a></td>
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                        </tr>
                        <?php
                    }
                    
                    foreach ($folders as $f) {
                        $is_link = is_link($path . '/' . $f);
                        $img = $is_link ? 'fa fa-file-text-o' : 'fa fa-folder-o';
                        ?>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="js-select-all-items"
                                    onclick="checkbox_toggle()">
                                <label class="custom-control-label" for="js-select-all-items"></label>
                            </div>
                        </td>
                        <td><a href="?p=<?php echo urlencode(trim($parent.'/'. $f, '/')); ?>"><i class="<?php echo $img ?>"></i> <?php echo $f; ?></a></td>
                        <td>Folder</td>
                        <td><?php echo date(DATETIME_FORMAT, filemtime($path . '/' . $f)); ?></td>
                        <td></td>
                    </tr>
                    <?php }?>

                    <?php 
                    
                    foreach ($files as $f) {
                        $is_link = is_link($path . '/' . $f);
                        $img = $is_link ? 'fa fa-file-text-o' : get_file_icon_class($path . '/' . $f);
                        $filesize_raw = fm_get_size($path . '/' . $f);
                        $filesize = fm_get_filesize($filesize_raw);
                        $filelink = 'view.php?p=' . urlencode($parent) . '&amp;view=' . urlencode($f);
                        $all_files_size += $filesize_raw;
                        ?>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="js-select-all-items"
                                    onclick="checkbox_toggle()">
                                <label class="custom-control-label" for="js-select-all-items"></label>
                            </div>
                        </td>
                        <td><a href="<?php echo $filelink; ?>"><i class="<?php echo $img ?>"></i> <?php echo $f; ?></a></td>
                        <td><span title="<?php printf('%s bytes', $filesize_raw) ?>"><?php echo $filesize ?></span></td>
                        <td><?php echo date(DATETIME_FORMAT, filemtime($path . '/' . $f)); ?></td>
                        <td><a href="<?php echo $filelink; ?>"><i class="<?php echo 'fa fa-eye' ?>"></i></a></td>
                    </tr>
                    <?php }?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="gray" colspan="5">
                            Full size: <span title="<?php printf('%s bytes', $all_files_size) ?>"><?php echo '<span class="badge badge-light">'.fm_get_filesize($all_files_size).'</span>' ?></span>
                            <?php echo 'File'.': <span class="badge badge-light">'.$num_files.'</span>' ?>
                            <?php echo 'Folder'.': <span class="badge badge-light">'.$num_folders.'</span>' ?>
                            <?php echo 'MemoryUsed'.': <span class="badge badge-light">'.fm_get_filesize(@memory_get_usage(true)).'</span>' ?>

                            <?php if(getUserType() == 'A') {echo 'PartitionSize'.': <span class="badge badge-light">'.fm_get_filesize(@disk_free_space($path)) .'</span> free of <span class="badge badge-light">'.fm_get_filesize(@disk_total_space($path)).'</span>'; } ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        var $table = $('#datatable'),
            tableLng = $table.find('th').length,
            _targets = (tableLng && tableLng == 7) ? [0, 4, 5, 6] : tableLng == 5 ? [0, 4] : [3],
            mainTable = $('#datatable').DataTable({
                "paging": false,
                "info": false,
                "columnDefs": [{
                    "targets": _targets,
                    "orderable": false,
                }]
            });
        $('#search-addon').on('keyup', function () { //Search using custom input box
            mainTable.search(this.value).draw();
        });
    </script>
</body>

</html>