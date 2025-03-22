<?php
$notesDir = "./pesan/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "add") {
        $judul = $_POST['judul'];
        $note = $_POST['note'];
        $timestamp = time();

        $uniqeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', $judul); 
        $filename = "{$uniqeTitle}_{$timestamp}.txt";

        $note_file = json_encode(["title" => $judul, "content" => $note]);
        file_put_contents($notesDir . $filename, $note_file, FILE_APPEND);
        header("Location: Note.php");
        exit();
    }

    if ($action == "edit") {
        $filename = basename($_POST['file']);
        $content = $_POST['content'];
        $filePath = $notesDir . "{$filename}.txt";

        if (file_exists($filePath)) {
            $data = json_decode(file_get_contents($filePath), true);
            $data['content'] = $newContent;
            file_put_contents($filePath, json_encode($data));
        }
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete'])) {
    $filename = basename($_GET['delete']);
    $filePath = $notesDir . $filename;

    if (file_exists($filePath)) {
        unlink($filePath);
        header("Location: Note.php");
        exit();
    }
}