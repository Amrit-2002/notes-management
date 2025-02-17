<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notes</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.0.0/ckeditor5.css" crossorigin>

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

  <!-- Include Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <script src="https://cdn.ckeditor.com/ckeditor5/44.0.0/ckeditor5.umd.js" crossorigin></script>
</head>

<body>

<!-- title, description and content area of edit page  -->
  <div class="page" style="margin-top:40px;">

    <div class="container notes shadow p-3 mb-5 bg-body-tertiary rounded">

      <form action="<?= base_url('notes/update/' . $note->id) ?>" method="POST">

        <input type="text" class="mb-3 form-control" id="title" name="title" placeholder="*Title" value="<?= $note->title ?>" required>
        <input type="text" class="mb-3 form-control" id="desc" name="desc" placeholder="*Description" value="<?= $note->desc ?>" required>
        <textarea id="editor" name="content" data-parsley-required="true"><?= $note->content ?></textarea>

        <?php if ($permissions_write[$note->id]): ?>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-dark" type="submit" id="add_note" style="margin-top: 15px; margin-bottom: 0px">
              Update</button>
          </div>
        <?php endif; ?>
      </form>
    </div>

  </div>

  <!-- form to set collaborators for note  -->
  <div class="container">
    <?php if ($note->user_id == $this->session->userdata('user_id')): ?>
        <form action="<?= base_url('notes/update_collaborators/' . $note->id . '/' . $note->user_id) ?>" method="POST">
          <!-- Collaborators -->
          <div class="form-group">
              <label class="fw-bolder text-dark" for="collaborators"><h4>Add Collaborators</h4></label>
              <select class="js-example-basic-multiple form-control" name="collaborators[]" multiple="multiple" style="width: 101%;">
                  <?php foreach ($users as $user): ?>
                      <?php if ($user->id !== $this->session->userdata('user_id')): ?>
                          <option value="<?= $user->id ?>" <?= in_array($user->id, $current_collaborators) ? 'selected' : '' ?>>
                              <?= htmlspecialchars($user->username) ?> (<?= htmlspecialchars($user->email) ?>)
                          </option>
                      <?php endif; ?>
                  <?php endforeach; ?>
              </select>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>
    <?php endif; ?>
  </div>

  <!-- form to set permissions for a collaborator to give write and delete access  -->
  <div class="container">
    <?php if ($note->user_id == $this->session->userdata('user_id')): ?>
        <form action="<?= base_url('notes/update_collaborator_permissions/' . $note->id . '/' . $note->user_id) ?>" method="POST">
            <!-- Collaborator Selection -->
            <div class="form-group">
                <label class="fw-bolder text-dark" for="collaborator"><h4>Select Collaborator to Set permissions</h4></label>
                <select id="collaboratorDropdown" class="form-control" name="collaborator_id" style="width: 101%;">
                    <option value="" disabled selected>Select a collaborator</option>
                    <?php foreach ($current_collaborators_users as $user): ?>
                        <?php if ($user->id !== $this->session->userdata('user_id')): ?>
                            <option value="<?= $user->id ?>">
                                <?= htmlspecialchars($user->username) ?> (<?= htmlspecialchars($user->email) ?>)
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Permission Checkboxes -->
            <div id="permissionsContainer" class="mt-4" style="display: none;">
                <h5 class="fw-bolder text-dark">Set Permissions</h5>
                <!-- <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="canRead" name="can_read" value="1" disabled>
                    <label class="form-check-label" for="canRead">Can Read</label>
                </div> -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="canWrite" name="can_write" value="1" disabled>
                    <label class="form-check-label" for="canWrite">Can Write</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="canDelete" name="can_delete" value="1" disabled>
                    <label class="form-check-label" for="canDelete">Can Delete</label>
                </div>
            </div>

            <!-- Submit Button -->
            <button id="saveButton" type="submit" class="btn btn-primary mt-3" style="display: none;">Save Permissions</button>
        </form>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const collaboratorDropdown = document.getElementById('collaboratorDropdown');
        const permissionsContainer = document.getElementById('permissionsContainer');
        const saveButton = document.getElementById('saveButton');

        // const canRead = document.getElementById('canRead');
        const canWrite = document.getElementById('canWrite');
        const canDelete = document.getElementById('canDelete');

        // Pass the permissions from PHP to JavaScript
        const permissionsWrite = <?php echo json_encode($permissions_write_by_userid); ?>;
        const permissionsDelete = <?php echo json_encode($permissions_delete_by_userid); ?>;

        collaboratorDropdown.addEventListener('change', function () {
            if (this.value) {
                // Enable checkboxes and show the permissions container
                permissionsContainer.style.display = 'block';
                saveButton.style.display = 'inline-block';

                // canRead.disabled = false;
                canWrite.disabled = false;
                canDelete.disabled = false;

                if (permissionsWrite[this.value]) {
                    canWrite.checked = true; // Pre-check "Can Write"
                } else {
                    canWrite.checked = false; // Uncheck "Can Write"
                }

                if (permissionsDelete[this.value]) {
                    canDelete.checked = true; // Pre-check "Can Delete"
                } else {
                    canDelete.checked = false; // Uncheck "Can Delete"
                }
                
            } else {
                // Disable checkboxes and hide the permissions container
                permissionsContainer.style.display = 'none';
                saveButton.style.display = 'none';

                // canRead.disabled = true;
                canWrite.disabled = true;
                canDelete.disabled = true;
            }
        });
    });
</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


  <script src="<?php echo base_url(); ?>assets/js/script.js"></script>


  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Include Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Initialize Select2 -->
  <script>
      $(document).ready(function() {
          $('.js-example-basic-multiple').select2({
              placeholder: "Select collaborators",
              allowClear: true,
          });
      });

      document.getElementById('add_note').addEventListener('click', function(evt) {
                  const editorData = window.editor.getData();
                  
                  if (!editorData.trim()) {
                    alert('Title, Description and Content are required fields.');
                    evt.preventDefault(); // Cancel the form submission
                  }
              });  
  </script>


</body>

</html>

