<!doctype html> 
<html lang="en">

<head>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css" />
  
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

  <script src="https://cdn.jsdelivr.net/npm/fuse.js/dist/fuse.min.js"></script>

  <style>

    h3 {
      font-weight: bolder;
      color: black;
    }

    .search-container {
        margin-bottom: 10px;
    }

    #search-box {
        /* width: calc(100% - 80px); */
        height: 25px;
        width: 180px;
        padding: 10px;
        margin-right: 10px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    input[type="submit"] {
        /* padding: 10px 15px; */
        background-color:rgb(7, 7, 7);
        height: 25px;
        width: 80px;
        color: white;
        border: none;
        border-radius: 15px;
        cursor: pointer;
        margin-right: 60px;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }
  </style>

</head>

<body>

    <!-- Flashdata Alert -->

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" style="margin-top:56px;"  role="alert">
          <?= $this->session->flashdata('success'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('update')): ?>
      <div class="alert alert-success alert-dismissible fade show" style="margin-top:56px;"  role="alert">
          <?= $this->session->flashdata('update'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('delete')): ?>
      <div class="alert alert-success alert-dismissible fade show" style="margin-top:56px;"  role="alert">
          <?= $this->session->flashdata('delete'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>


  <div class="page" style="margin-top:40px;">

    <div class="container notes shadow p-3 mb-5 bg-body-tertiary rounded">

      <form action="<?= base_url('notes/add') ?>" method="POST" >

        <input type="text" class="mb-3 form-control" id="title" name="title" placeholder="*Title" required>
        <input type="text" class="mb-3 form-control" id="desc" name="desc" placeholder="*Description" required>
        <textarea id="editor" name="content" data-parsley-required="true"></textarea>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <button class="btn btn-dark" type="submit" id="add_note" style="margin-top: 15px; margin-bottom: 0px">
            <span id="plus">＋</span> Add Note</button>
        </div>
      </form>

    </div>


    <div class="btns container p-3 mb-5" style="display: flex; ">

      <div>
        <h4 style="margin-left: 2px;">Your Notes</h4>

        <div class="m-0" >
          <input type="text" id="search" class="form-control mb-3 float-end" placeholder="Search notes..." style="width:400px; "> 
        </div>
      </div>

      <div style="display: flex; gap: 5px; margin-right: 14px;" id="toggle">

        <div id="grid"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-grid-3x3-gap-fill" viewBox="0 0 16 16">
            <path
              d="M1 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zM1 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zM1 12a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z" />
          </svg>
        </div>

        <div><label class="switch" id="toggle-btn">
            <input type="checkbox" checked>
            <span class="slider round"></span>
          </label>
        </div>

        <div id="list"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
            class="bi bi-list-ul" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
          </svg>
        </div>

      </div>
    </div>

  </div>


    <div id="grid-view" class="grid-container container p-3 mb-5 bg-body-tertiary rounded" >
              <!-- Notes will be dynamically rendered here -->
    </div>
  
    <script>
          document.addEventListener('DOMContentLoaded', function () {

              document.getElementById('add_note').addEventListener('click', function(evt) {
                  const editorData = window.editor.getData();
                  
                  if (!editorData.trim()) {
                    alert('Title, Description and Content are required fields.');
                    evt.preventDefault(); // Cancel the form submission
                  }
              });  


              const notes = <?= $json_notes ?>;
              const users = <?= $json_users ?>;

              const current_user_id = <?= $this->session->userdata('user_id') ?>;
              const base_url = "<?= base_url(); ?>";

              const options = {
                  keys: ['title', 'desc'], // Fields to search in
                  weights: [0.7, 0.3],
                  threshold: 0.4, 
                  // findAllMatches: true,
                  isCaseSensitive: false,
                  includeScore: true,
                  shouldSort: true,
                  location: 0,
                  distance: 638,
              };

              const fuse = new Fuse(notes, options); // Initialization of Fuse.js
              const notesContainer = document.getElementById('grid-view');
              const searchInput = document.getElementById('search');
              const toggle = document.querySelector('#toggle-btn input');

              let isListView = false; // Track whether we're in list view or grid view

              const permissions_delete = <?php echo json_encode($permissions_delete); ?>;


              function renderNotes(notes) {
                  notesContainer.innerHTML = ''; // Clear current notes
                  if (notes.length === 0) {
                      notesContainer.innerHTML = '<p class="text-center">No notes found.</p>';
                      return;
                  }
                  notes.forEach(note => {
                      let createdByBadge = '';
                      let updatedByBadge = '';
                      let deletebtn = '';

                      if (note.user_id != current_user_id) {
                          users.forEach(user => {
                              if (note.user_id == user.id) {
                                  createdByBadge = `
                                      <span class="badge bg-light text-success ms-2 float-end">
                                          <i class="bi bi-person-fill"></i> Created By: ${user.name}
                                      </span>
                                  `;
                              }
                          });
                      }else{
                        createdByBadge = `
                                      <span class="badge bg-light text-success ms-2 float-end">
                                          <i class="bi bi-person-fill"></i> Created By: You
                                      </span>
                                  `;
                      }

                      users.forEach(user => {
                        if (note.updated_by != current_user_id) {
                              if (note.updated_by == user.id) {
                                  updatedByBadge = `
                                      <span class="badge bg-light text-success ms-2 float-end">
                                          <i class="bi bi-person-fill"></i> Last Updated at: ${note.updated_at} by ${user.name} 
                                      </span>
                                  `;
                              }
                            }else{
                              updatedByBadge = `
                                      <span class="badge bg-light text-success ms-2 float-end">
                                          <i class="bi bi-person-fill"></i> Last Updated at: ${note.updated_at} by You
                                      </span>
                                  `;
                            }
                      });
                        
                      if (permissions_delete[note.id]){
                        deletebtn = `<a style="text-decoration:none;" href="javascript:void(0);" onclick="confirmDelete('<?= base_url('notes/delete/${note.id}') ?>')">
                                        <img src="<?php echo base_url();?>assets/images/trash.svg" alt="trash_image">
                                      </a>`;
                      }

                      // to adjust title and description length based on view type
                      const titleLength = isListView ? 255 : 40;
                      const descLength = isListView ? 255 : 47;

                      let title = note.title.substring(0, titleLength);
                      let description = note.desc.substring(0, descLength);

                      if (!isListView && note.title.length > 40 && note.desc.length > 47) {
                          title += '...';
                          description += '...';
                      }else if(!isListView && note.title.length <= 40 && note.desc.length > 47){
                          description += '...';
                      }else if(!isListView && note.title.length > 40 && note.desc.length <= 47){
                          title += '...';
                      }
                      
                      notesContainer.innerHTML += `
                                  <div class="note" data-id="${note.id}" style="cursor: pointer;">
                                      <h3>${title}</h3>
                                      <h6>${description}</h6>
                                      <a style="text-decoration:none;" href="notes/edit/${note.id}"><img src="<?php echo base_url();?>assets/images/edit.svg " alt=edit_image"></a>
                                      ${deletebtn}
                                      ${createdByBadge} ${updatedByBadge}
                                  </div>
                      `;
                    });

                    function editnote() {
                    const notes = document.querySelectorAll('.note');

                      notes.forEach(note => {
                          note.addEventListener('click', function(event) {
                              if (!event.target.closest('a') || event.target.closest('a').getAttribute('href') !== 'javascript:void(0);') {
                                  const noteId = note.getAttribute('data-id');
                                  window.location.href = `${baseUrl}notes/edit/${noteId}`;
                              }
                          });
                      });
                    }

                    editnote();
              }

              // Render all notes initially
              renderNotes(notes);

              toggle.addEventListener('change', function () {
                  isListView = !this.checked; // Update view state
                  if (this.checked) {
                      notesContainer.style.gridTemplateColumns = '32% 32% 32%';
                      list.classList.add("text-secondary");
                      grid.classList.remove("text-secondary");
                  } else {
                      notesContainer.style.gridTemplateColumns = '100%';
                      grid.classList.add("text-secondary");
                      list.classList.remove("text-secondary");
                  }
                  renderNotes(notes); // Re-render notes with updated view type
              });

              searchInput.addEventListener('input', (e) => {
                  const searchTerm = e.target.value.trim(); // Get the search term and trim any extra spaces

                  if (searchTerm.length === 0) {
                      // If the search term is empty, show all notes
                      renderNotes(notes);
                  } else {
                      // Perform the search with Fuse.js
                      const result = fuse.search(searchTerm);
                      const filteredNotes = result.map(r => r.item);
                      renderNotes(filteredNotes); // Render filtered notes
                  }
              });
          });
    </script>


  <script>
      document.addEventListener('DOMContentLoaded', () => {
      const toggle = document.querySelector('#toggle-btn input');
      const gridContainer = document.getElementById('grid-view'); 
      const grid = document.getElementById('grid'); 
      const list = document.getElementById('list'); 

      toggle.addEventListener('change', function () {
        if (this.checked) {
          gridContainer.style.gridTemplateColumns = '32% 32% 32%';
          list.classList.add("text-secondary");
          grid.classList.remove("text-secondary");
        } else {
          gridContainer.style.gridTemplateColumns = '100%';
          grid.classList.add("text-secondary");
          list.classList.remove("text-secondary");
        }
      });
    });
  </script>  

  <script>
    document.addEventListener('DOMContentLoaded', function() {
    const notes = document.querySelectorAll('.note');

      notes.forEach(note => {
          note.addEventListener('click', function(event) {
              if (!event.target.closest('a') || event.target.closest('a').getAttribute('href') !== 'javascript:void(0);') {
                  const noteId = note.getAttribute('data-id');
                  window.location.href = `${baseUrl}notes/edit/${noteId}`;
              }
          });
      });
    });

    function confirmDelete(url) {

        if (confirm("Are you sure you want to delete this note?")) {
            window.location.href = url;
        } else {
            return false;
        }
    }

    const baseUrl = '<?php echo base_url(); ?>';
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.0.0"></script>

  <script src="<?php echo base_url(); ?>assets/js/script.js"></script>

</body>

</html>
