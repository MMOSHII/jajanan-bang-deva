<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $note = $_POST['note'];

    $note_file = "$judul;$note;";
    file_put_contents("./pesan/{$judul}.txt", $note_file, FILE_APPEND);
    header("Location: Note.php");
    exit();
}