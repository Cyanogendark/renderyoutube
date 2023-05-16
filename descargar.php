<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = $_POST["url"];
    $formato = $_POST["formato"];
    
    if ($formato == "video") {
        // Descargar vídeo
        $cmd = "youtube-dl -f 'bestvideo[ext=mp4]+bestaudio[ext=m4a]/mp4' --merge-output-format mp4 " . escapeshellarg($url);
    } else {
        // Descargar audio
        $cmd = "youtube-dl -x --audio-format mp3 " . escapeshellarg($url);
    }
    
    exec($cmd, $output, $return);

    if ($return === 0) {
        // Descarga exitosa
        echo "Descarga completada. Haz clic <a href='" . $output[0] . "'>aquí</a> para descargar el archivo.";
    } else {
        // Descarga fallida
        echo "Hubo un error al descargar el archivo.";
    }
}
?>
