<?php
echo '<div class="hero-unit">
            <h1>Fotoalbum</h1>
          <hr>';

$dir1 = "fotoalbums";
$dir_contents1 = scandir($dir1, 1);
$dir_contents1 = array_diff(scandir($dir1), array('..', '.'));

echo '<ul class="unstyled">';
foreach ($dir_contents1 as $file1) {
    echo '<li><a href="?page=fotoalbum&amp;album=' . $file1 . '"><i class="icon-music"></i> ' . $file1 . '</a></li>';
}
echo '</ul>';

if (isset($_GET['album'])) {
    $dirr = $_GET['album'];
    $dir2 = 'fotoalbums/' . $dirr . '';
    $fie_display = array('jpg', 'jpeg', 'png');

    if (file_exists($dir2) == false) {
        echo 'Directory \'', $dir2, '\' niet gevonden!';
    } else {
        $dir_contents = scandir($dir2);
        $counter = 0;
        echo '<ul class="thumbnails">';
        foreach ($dir_contents as $file) {
            echo '<li class="span2">';
            $value = explode('.', $file);
            $file_type = strtolower(array_pop($value));
            if ($file !== '.' && $file !== '..' && in_array($file_type, $fie_display) == true) {
                echo '<a href="#' . $counter . '"  role="button" class="thumbnail" data-toggle="modal">'
                        . '<img src="', $dir2, '/', $file, '" alt="', $file, '"/>'
                        . '</a>';
                echo''
                . '<!-- Modal -->
<div id="' . $counter . '" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">' . $file . '</h3>
  </div>
  <div class="modal-body">
    <p><img src="', $dir2, '/', $file, '" alt="', $file, '" width="" height=""/></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>';
                $counter++;
            }
            echo '</li>';
        }
        echo'</ul>';
    }
}
?>
</div>  


