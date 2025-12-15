<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Notes Manager</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --secondary: #f8fafc;
            --accent: #f1f5f9;
            --text: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --radius: 12px;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Instrument Sans', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 0;
            border-bottom: 1px solid var(--border);
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header h1 i {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Search Bar */
        .search-container {
            position: relative;
            flex-grow: 1;
            max-width: 500px;
        }

        .search-bar {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            font-size: 1rem;
            background-color: white;
            transition: var(--transition);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .search-bar:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        /* Layout */
        .app-layout {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        @media (min-width: 992px) {
            .app-layout {
                flex-direction: row;
                align-items: flex-start;
            }
        }

        /* Form Section */
        .form-section {
            flex: 1;
            background-color: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            max-width: 100%;
        }

        @media (min-width: 992px) {
            .form-section {
                max-width: 400px;
                position: sticky;
                top: 30px;
            }
        }

        .form-section:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form Styles */
        .note-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-label {
            font-weight: 500;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
            line-height: 1.5;
        }

        .btn {
            padding: 14px 24px;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--accent);
            color: var(--text);
        }

        .btn-secondary:hover {
            background-color: var(--border);
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        /* Notes Section */
        .notes-section {
            flex: 2;
            background-color: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .notes-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .notes-count {
            background-color: var(--primary-light);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Notes Grid */
        .notes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .note-card {
            background-color: white;
            border-radius: var(--radius);
            padding: 25px;
            border: 1px solid var(--border);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .note-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-light);
        }

        .note-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .note-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 5px;
            word-break: break-word;
        }

        .note-content {
            color: var(--text);
            line-height: 1.6;
            margin-bottom: 20px;
            word-break: break-word;
        }

        .note-date {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .note-actions {
            display: flex;
            gap: 12px;
            opacity: 0;
            transition: var(--transition);
        }

        .note-card:hover .note-actions {
            opacity: 1;
        }

        .action-btn {
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
            border: none;
        }

        .edit-btn {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }

        .edit-btn:hover {
            background-color: rgba(99, 102, 241, 0.2);
        }

        .delete-btn {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .delete-btn:hover {
            background-color: rgba(239, 68, 68, 0.2);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--border);
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--text);
        }

        /* Loading State */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(99, 102, 241, 0.2);
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .toast {
            background-color: white;
            border-radius: var(--radius);
            padding: 18px 24px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 300px;
            transform: translateX(100%);
            opacity: 0;
            animation: slideIn 0.3s ease-out forwards;
            border-left: 5px solid var(--primary);
        }

        @keyframes slideIn {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .toast-success {
            border-left-color: var(--success);
        }

        .toast-error {
            border-left-color: var(--danger);
        }

        .toast-icon {
            font-size: 1.5rem;
        }

        .toast-success .toast-icon {
            color: var(--success);
        }

        .toast-error .toast-icon {
            color: var(--danger);
        }

        .toast-content h4 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .toast-content p {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .close-toast {
            margin-left: auto;
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            font-size: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-container {
                max-width: 100%;
            }
            
            .notes-grid {
                grid-template-columns: 1fr;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fas fa-sticky-note"></i>
                Notes Manager
            </h1>
            
            <!-- Search Bar -->
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input 
                    type="text" 
                    class="search-bar" 
                    id="searchBar" 
                    placeholder="Search notes by title or content..."
                >
            </div>
        </div>

        <!-- Main Layout -->
        <div class="app-layout">
            <!-- Form Section -->
            <section class="form-section">
                <h2 class="section-title">
                    <i class="fas fa-edit"></i>
                    <span id="formTitle">Create New Note</span>
                </h2>
                
                <form class="note-form" id="noteForm">
                    <input type="hidden" id="noteId" value="">
                    
                    <div class="form-group">
                        <label class="form-label" for="title">
                            <i class="fas fa-heading"></i>
                            Title
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            class="form-control" 
                            placeholder="Enter note title" 
                            required
                        >
                        <div class="error-message" id="titleError"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="content">
                            <i class="fas fa-align-left"></i>
                            Content
                        </label>
                        <textarea 
                            id="content" 
                            class="form-control" 
                            placeholder="Enter note content" 
                            rows="5"
                            required
                        ></textarea>
                        <div class="error-message" id="contentError"></div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-plus"></i>
                            <span id="submitText">Create Note</span>
                        </button>
                        
                        <button type="button" class="btn btn-secondary" id="cancelBtn" style="display: none;">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                    </div>
                </form>
            </section>

            <!-- Notes Section -->
            <section class="notes-section">
                <div class="notes-header">
                    <h2 class="section-title">
                        <i class="fas fa-list"></i>
                        My Notes
                    </h2>
                    <div class="notes-count">
                        <span id="notesCount">0</span> Notes
                    </div>
                </div>
                
                <!-- Loading State -->
                <div class="loading" id="loading">
                    <div class="spinner"></div>
                </div>
                
                <!-- Notes Grid -->
                <div class="notes-grid" id="notesGrid"></div>
                
                <!-- Empty State -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <i class="fas fa-clipboard"></i>
                    <h3>No notes found</h3>
                    <p>Create your first note using the form on the left!</p>
                </div>
            </section>
        </div>
        
        <!-- Toast Container -->
        <div class="toast-container" id="toastContainer"></div>
    </div>

    <script>
        // API Configuration
        const API_BASE_URL = '/api/notes';
        let notes = [];
        let isEditing = false;
        let currentNoteId = null;

        // DOM Elements
        const noteForm = document.getElementById('noteForm');
        const titleInput = document.getElementById('title');
        const contentInput = document.getElementById('content');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const cancelBtn = document.getElementById('cancelBtn');
        const formTitle = document.getElementById('formTitle');
        const notesGrid = document.getElementById('notesGrid');
        const loadingEl = document.getElementById('loading');
        const emptyState = document.getElementById('emptyState');
        const notesCount = document.getElementById('notesCount');
        const searchBar = document.getElementById('searchBar');
        const noteIdInput = document.getElementById('noteId');

        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            fetchNotes();
            setupEventListeners();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Form submission
            noteForm.addEventListener('submit', handleFormSubmit);
            
            // Cancel edit
            cancelBtn.addEventListener('click', cancelEdit);
            
            // Search functionality
            searchBar.addEventListener('input', handleSearch);
        }

        // Fetch all notes from API
        async function fetchNotes() {
            try {
                showLoading(true);
                const response = await fetch(API_BASE_URL);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                notes = await response.json();
                renderNotes(notes);
                updateNotesCount(notes.length);
            } catch (error) {
                console.error('Error fetching notes:', error);
                showToast('Error', 'Failed to load notes. Please try again.', 'error');
            } finally {
                showLoading(false);
            }
        }

        // Handle form submission
        async function handleFormSubmit(e) {
            e.preventDefault();
            
            // Get form data
            const title = titleInput.value.trim();
            const content = contentInput.value.trim();
            const noteId = noteIdInput.value;
            
            // Validation
            if (!title) {
                showToast('Validation Error', 'Title is required', 'error');
                titleInput.focus();
                return;
            }
            
            if (!content) {
                showToast('Validation Error', 'Content is required', 'error');
                contentInput.focus();
                return;
            }
            
            // Prepare data
            const noteData = { title, content };
            
            // Disable submit button
            submitBtn.disabled = true;
            submitText.textContent = isEditing ? 'Updating...' : 'Creating...';
            
            try {
                let response;
                
                if (isEditing) {
                    // Update existing note
                    response = await fetch(`${API_BASE_URL}/${noteId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(noteData)
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const updatedNote = await response.json();
                    
                    // Update in local array
                    const index = notes.findIndex(note => note.id == noteId);
                    if (index !== -1) {
                        notes[index] = updatedNote;
                    }
                    
                    showToast('Success', 'Note updated successfully', 'success');
                } else {
                    // Create new note
                    response = await fetch(API_BASE_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(noteData)
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const newNote = await response.json();
                    notes.unshift(newNote); // Add to beginning
                    
                    showToast('Success', 'Note created successfully', 'success');
                }
                
                // Reset form
                resetForm();
                
                // Re-render notes
                renderNotes(notes);
                updateNotesCount(notes.length);
                
            } catch (error) {
                console.error('Error saving note:', error);
                showToast('Error', `Failed to ${isEditing ? 'update' : 'create'} note. Please try again.`, 'error');
            } finally {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitText.textContent = isEditing ? 'Update Note' : 'Create Note';
            }
        }

        // Edit note
        function editNote(id) {
            const note = notes.find(note => note.id == id);
            
            if (!note) return;
            
            // Set form to edit mode
            isEditing = true;
            currentNoteId = id;
            
            // Populate form
            titleInput.value = note.title;
            contentInput.value = note.content;
            noteIdInput.value = note.id;
            
            // Update UI
            formTitle.textContent = 'Edit Note';
            submitText.textContent = 'Update Note';
            cancelBtn.style.display = 'flex';
            
            // Scroll to form
            document.querySelector('.form-section').scrollIntoView({ behavior: 'smooth' });
            
            // Focus on title
            titleInput.focus();
        }

        // Delete note
        async function deleteNote(id) {
            // Confirm deletion
            if (!confirm('Are you sure you want to delete this note?')) {
                return;
            }
            
            try {
                const response = await fetch(`${API_BASE_URL}/${id}`, {
                    method: 'DELETE'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                // Remove from local array
                notes = notes.filter(note => note.id != id);
                
                // Re-render notes
                renderNotes(notes);
                updateNotesCount(notes.length);
                
                // If we were editing this note, reset form
                if (currentNoteId == id) {
                    resetForm();
                }
                
                showToast('Success', 'Note deleted successfully', 'success');
            } catch (error) {
                console.error('Error deleting note:', error);
                showToast('Error', 'Failed to delete note. Please try again.', 'error');
            }
        }

        // Cancel edit mode
        function cancelEdit() {
            resetForm();
        }

        // Reset form to create mode
        function resetForm() {
            isEditing = false;
            currentNoteId = null;
            
            // Clear form
            noteForm.reset();
            noteIdInput.value = '';
            
            // Update UI
            formTitle.textContent = 'Create New Note';
            submitText.textContent = 'Create Note';
            cancelBtn.style.display = 'none';
        }

        // Render notes to the grid
        function renderNotes(notesToRender) {
            // Clear the grid
            notesGrid.innerHTML = '';
            
            if (notesToRender.length === 0) {
                emptyState.style.display = 'block';
                return;
            }
            
            emptyState.style.display = 'none';
            
            // Create note cards
            notesToRender.forEach((note, index) => {
                const noteCard = document.createElement('div');
                noteCard.className = 'note-card';
                noteCard.style.animationDelay = `${index * 0.05}s`;
                
                // Format date
                const createdAt = note.created_at ? new Date(note.created_at).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                }) : 'Recent';
                
                noteCard.innerHTML = `
                    <div class="note-header">
                        <div>
                            <h3 class="note-title">${escapeHtml(note.title)}</h3>
                        </div>
                    </div>
                    <div class="note-content">${escapeHtml(note.content.substring(0, 150))}${note.content.length > 150 ? '...' : ''}</div>
                    <div class="note-date">
                        <i class="far fa-calendar"></i>
                        Created: ${createdAt}
                    </div>
                    <div class="note-actions">
                        <button class="action-btn edit-btn" onclick="editNote(${note.id})">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="action-btn delete-btn" onclick="deleteNote(${note.id})">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                `;
                
                notesGrid.appendChild(noteCard);
            });
        }

        // Handle search
        function handleSearch() {
            const searchTerm = searchBar.value.toLowerCase().trim();
            
            if (!searchTerm) {
                renderNotes(notes);
                updateNotesCount(notes.length);
                return;
            }
            
            const filteredNotes = notes.filter(note => 
                note.title.toLowerCase().includes(searchTerm) || 
                note.content.toLowerCase().includes(searchTerm)
            );
            
            renderNotes(filteredNotes);
            updateNotesCount(filteredNotes.length);
        }

        // Update notes count
        function updateNotesCount(count) {
            notesCount.textContent = count;
        }

        // Show/hide loading state
        function showLoading(show) {
            loadingEl.style.display = show ? 'flex' : 'none';
        }

        // Show toast notification
        function showToast(title, message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            toast.innerHTML = `
                <i class="fas ${icon} toast-icon"></i>
                <div class="toast-content">
                    <h4>${title}</h4>
                    <p>${message}</p>
                </div>
                <button class="close-toast" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            toastContainer.appendChild(toast);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 5000);
        }

        // Helper function to escape HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Expose functions to global scope for inline event handlers
        window.editNote = editNote;
        window.deleteNote = deleteNote;
    </script>
</body>
</html>