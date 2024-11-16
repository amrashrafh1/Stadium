Stadium Booking API

A simple and efficient API built with Laravel for managing stadium bookings. The API allows users to view available slots, book pitches, and prevent overbooking of the same slot.

Table of Contents

Features
Prerequisites
Installation
Database Seeding
Running the Project
API Endpoints
Project Structure
Contributing
License
Features

List available slots for a stadium pitch on a specific date.
Book a pitch for a specific slot (60 or 90 minutes).
Prevents overbooking for the same slot.
Prerequisites

Before running the project, ensure you have the following installed:

PHP 8.2+
Composer
MySQL or another supported database
Laravel 11
Node.js and npm/yarn for front-end dependencies (if applicable)
Installation

Clone the Repository
git clone https://github.com/your-username/stadium-booking-api.git
cd stadium-booking-api
Install Dependencies
composer install
npm install
Environment Configuration Copy the .env.example file to .env and update the database credentials.
cp .env.example .env
Update these fields in .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stadium
DB_USERNAME=root
DB_PASSWORD=your_password
Generate Application Key
php artisan key:generate
Database Seeding

Run Migrations Run the migrations to set up the database structure.
php artisan migrate
Run Seeders Seed the database with sample data (stadiums, pitches, schedules, and slots).
php artisan db:seed
This will:

Create 2 stadiums.
Add 3 pitches per stadium.
Generate schedules and slots for each pitch.
Running the Project

Start the Development Server
php artisan serve
Access the API Visit the API at http://127.0.0.1:8000.
Testing the API Use tools like Postman or cURL to test the API endpoints.
API Endpoints

1. List Available Slots
GET /api/stadiums/{stadium_id}/pitches/{pitch_id}/available-slots?date={date}
Description: Returns all available booking slots for a specific pitch on a specific date.
Example Request:
GET /api/stadiums/1/pitches/2/available-slots?date=2024-11-16
2. Book a Pitch
POST /api/bookings
Description: Books a slot for a given pitch.
Request Body:
{
  "slot_id": 10,
  "user_id": 1
}
Example Response:
{
  "message": "Slot successfully booked.",
  "data": {
    "booking_id": 42
  }
}
Project Structure

├── app/                   # Application logic
│   ├── Models/            # Eloquent models (e.g., Stadium, Pitch, Schedule, Slot)
│   ├── Http/Controllers/  # API controllers
├── database/              
│   ├── migrations/        # Database migrations
│   ├── seeders/           # Seeders (e.g., ScheduleSeeder)
├── routes/                
│   ├── api.php            # API routes
├── tests/                 # Automated tests
└── ...
Contributing

Fork the repository.
Create a new feature branch.
git checkout -b feature/your-feature-name
Commit your changes.
git commit -m "Add your message here"
Push to your branch.
git push origin feature/your-feature-name
Open a pull request.
License

This project is licensed under the MIT License.

Contact

For any questions or support, feel free to contact your-email@example.com.

This file gives a clear and concise overview of the project and guides users through setting it up, running it, and testing it. Replace placeholders (e.g., your-username, your-email@example.com) with your details.
