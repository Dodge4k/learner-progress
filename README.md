# Learner Progress Dashboard - Coding Challenge

A simple Laravel 12 application that displays a dashboard showing learners, their enrolled courses, and progress percentages. The dashboard supports filtering learners by course and dynamic sorting by progress.

## Features

- List all learners with full names
- Display each learner's enrolled courses and individual progress percentages
- Filter learners by course name
- Sort learners by progress:
  - When no filter is applied: sorted by average progress across all courses
  - When a course is filtered: sorted by progress in that specific course
- No authentication required

## Getting Started (Linux)

These instructions will get the project running on a Linux machine using SQLite as the database.

### Prerequisites

- PHP >= 8.2
- Composer
- Git

### Installation Steps

1. Clone the repository
   ---git bash
   git clone https://github.com/Dodge4k/learner-progress.git
   cd learner-progress

2. Run 'composer install --optimize-autoloader --no-dev'
3. Create SQLite database file 'touch database/database.sqlite'
4. Generate application key: 'php artisan key:generate'
5. Run migrations and seed the DB: Run 'php artisan migrate --force'  then run  'php artisan db:seed --force'
6. Start the development server: 'php artisan serve'

   Open your browser and go to:
http://localhost:8000/learner-progress
