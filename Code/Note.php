<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Note.css" />
    <title>Jajanan Bang Deva - Dashboard</title>
  </head>
  <body>
    <!-- Sidebar navigation -->
    <?php include 'sidebar.php'; ?>

    <div class="popup-container" id="popupContainer" onclick="closePopup(event)">
        <div class="popup" onclick="event.stopPropagation()">
            <span class="close-btn" onclick="closePopup(event)">x</span>
            <h2>Add Note</h2>
            <form action="save_note.php" method="POST">
                <label for="judul">Judul:</label>
                <input type="text" name="judul" required><br><br>
                <label for="note">Isi catatan:</label>
                <input type="text" name="note" required><br><br>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <div class="content">
      <h1>Catatan</h1>
      <p class="subtitle">Catatan tambahan usaha Jajanan Bang Deva</p>

      <div class="notes-grid">

        <?php
        $files = glob("./pesan/*.txt");


        foreach ($files as $file) {
            $filename = basename($file, ".txt");

            echo '<div class="note-card"><div class="note-header">';
            echo $filename;
            echo '<button class="edit-button" onclick="openModal(this)" title="Edit Catatan">✏️</button>';
            echo "</div>";
            echo '<p class="note-text">' . file_get_contents($file) . "</p>";
            // echo "<a href='delete.php?file=$filename'>Delete</a>";
            echo "</div>";
        }
        ?>

        
        <div class="note-card">
          <div class="note-header">
            Catatan 1
            <button class="edit-button" onclick="openModal(this)" title="Edit Catatan">✏️</button>
          </div>
          <p class="note-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed rutrum nibh ut volutpat molestie.</p>
        </div>


        <div class="note-card">
          <div class="note-header">
            Catatan 1
            <button class="edit-button" onclick="openModal(this)" title="Edit Catatan">✏️</button>
          </div>
          <p class="note-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed rutrum nibh ut volutpat molestie.</p>
        </div>


      </div>

      <button onclick="openPopup()" class="add-button">+</button>
    </div>
    <div class="modal" id="editModal">
      <div class="modal-content">
        <h3>Edit Catatan</h3>
        <textarea id="editText"></textarea>
        <div class="modal-buttons">
          <button onclick="saveEdit()">Simpan</button>
          <button onclick="closeModal()">Batal</button>
        </div>
      </div>
    </div>
    <div class="content" id="mainContent">
    <script>
        let currentNoteText = null;
      
        function openModal(button) {
          const noteText = button.closest('.note-card').querySelector('.note-text');
          currentNoteText = noteText;
      
          document.getElementById('editText').value = noteText.textContent;
          document.getElementById('editModal').style.display = 'flex';
          document.getElementById('mainContent').classList.add('blur');
        }
      
        function closeModal() {
          document.getElementById('editModal').style.display = 'none';
          document.getElementById('mainContent').classList.remove('blur');
        }
      
        function saveEdit() {
          const newText = document.getElementById('editText').value;
          if (currentNoteText) {
            currentNoteText.textContent = newText;
          }
          closeModal();
        }

        function openPopup() {
            document.getElementById("popupContainer").style.display = "flex";
        }
        function closePopup(event) {
            if (event.target.id === "popupContainer" || event.target.classList.contains("close-btn")) {
                document.getElementById("popupContainer").style.display = "none";
            }
        }
      </script>
          
  </body>
</html>
