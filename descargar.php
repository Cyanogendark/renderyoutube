<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];
    $videoId = obtenerIdVideo($url);

    if ($videoId) {
        $videoUrl = "https://www.youtube.com/watch?v={$videoId}";
        $audioUrl = "https://www.youtube.com/watch?v={$videoId}";

        // Descarga del video
        descargarArchivo($videoUrl, 'video.mp4');

        // Descarga del audio
        descargarArchivo($audioUrl, 'audio.mp3');
    } else {
        echo "<p>Por favor, ingresa una URL válida de YouTube.</p>";
    }
}

function obtenerIdVideo($url) {
    $pattern =
        '%^# Match any YouTube URL
        (?:https?://)?    # Optional scheme. Either http or https
        (?:www\.)?        # Optional www subdomain
        (?:               # Group host alternatives
          youtu\.be/      # Either youtu.be,
        | youtube\.com    # or youtube.com
          (?:             # Group path alternatives
            /embed/       # Either /embed/
          | /v/           # or /v/
          | /watch\?v=    # or /watch\?v=
          )               # End path alternatives.
        )                 # End host alternatives.
        ([\w-]{11})       # The video ID.
        $%x';

    $result = preg_match($pattern, $url, $matches);

    if ($result) {
        return $matches[1];
    }

    return false;
}

function descargarArchivo($url, $nombreArchivo) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);

    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
    echo $data;
}
?>
