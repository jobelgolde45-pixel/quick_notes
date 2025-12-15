<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $notes = [
            [
                'title' => 'Welcome to QuickNotes',
                'content' => 'This is your first note. You can create, edit, search, and delete notes.'
            ],
            [
                'title' => 'Laravel API',
                'content' => 'This project uses Laravel RESTful API routes for managing notes.'
            ],
            [
                'title' => 'CRUD Operations',
                'content' => 'Create, Read, Update, and Delete are fully implemented.'
            ],
            [
                'title' => 'Modern UI',
                'content' => 'The frontend is built with vanilla JavaScript and Fetch API.'
            ],
            [
                'title' => 'Reactive Search',
                'content' => 'Search notes instantly as you type.'
            ],
            [
                'title' => 'Capstone Project',
                'content' => 'This notes system can be extended for a school capstone project.'
            ],
            [
                'title' => 'API Testing',
                'content' => 'You can test the API using Postman or Insomnia.'
            ],
            [
                'title' => 'Database Migration',
                'content' => 'Notes table includes title, content, and timestamps.'
            ],
            [
                'title' => 'Authentication',
                'content' => 'User authentication can be added using Laravel Sanctum.'
            ],
            [
                'title' => 'Pagination',
                'content' => 'Large note lists can be paginated using Laravel built-in pagination.'
            ],
            [
                'title' => 'Validation Rules',
                'content' => 'Title and content are validated before saving.'
            ],
            [
                'title' => 'Deployment',
                'content' => 'This project can be deployed on free hosting platforms.'
            ],
            [
                'title' => 'Error Handling',
                'content' => 'Proper HTTP response codes are returned by the API.'
            ],
            [
                'title' => 'JSON Responses',
                'content' => 'All API endpoints return JSON formatted responses.'
            ],
            [
                'title' => 'Frontend Fetch API',
                'content' => 'JavaScript Fetch API handles HTTP requests.'
            ],
            [
                'title' => 'Edit Mode',
                'content' => 'The form automatically switches to update mode.'
            ],
            [
                'title' => 'Delete Confirmation',
                'content' => 'Users must confirm before deleting a note.'
            ],
            [
                'title' => 'Search Optimization',
                'content' => 'Client-side filtering keeps search fast.'
            ],
            [
                'title' => 'Extensibility',
                'content' => 'This system can be extended to support users and categories.'
            ],
            [
                'title' => 'Next Steps',
                'content' => 'Add authentication, roles, and cloud storage.'
            ],
        ];

        foreach ($notes as $note) {
            Note::create($note);
        }
    }
}
