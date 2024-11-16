**Stadium Booking API**
=======================

A simple and efficient API built with Laravel for managing stadium bookings. The API allows users to view available slots, book pitches, and prevent overbooking of the same slot.

**Table of Contents**
---------------------

1.  [Features](#features)
2.  [Prerequisites](#prerequisites)
3.  [Installation](#installation)
4.  [Database Seeding](#database-seeding)
5.  [Running the Project](#running-the-project)
6.  [API Endpoints](#api-endpoints)
7.  [Project Structure](#project-structure)
8.  [Contributing](#contributing)
9.  [License](#license)

* * * * *

**Features**
------------

-   List available slots for a stadium pitch on a specific date.
-   Book a pitch for a specific slot (60 or 90 minutes).
-   Prevents overbooking for the same slot.

* * * * *

**Prerequisites**
-----------------

Before running the project, ensure you have the following installed:

-   [PHP 8.2+](https://www.php.net/)
-   [Composer](https://getcomposer.org/)
-   [MySQL](https://www.mysql.com/) or another supported database
-   [Laravel 11+](https://laravel.com/)
-   [Node.js](https://nodejs.org/) and npm/yarn for front-end dependencies (if applicable)

* * * * *

**Installation**
----------------

1.  **Clone the Repository**

    bash

    Copy code

    `git clone https://github.com/amrashrafh1/Stadium.git
    cd stadium`

2.  **Install Dependencies**

    bash

    Copy code

    `composer install` 

3.  **Environment Configuration** Copy the `.env.example` file to `.env` and update the database credentials.

    bash

    Copy code

    `cp .env.example .env`

    Update these fields in `.env`:

    env

    Copy code

    `DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=stadium_booking
    DB_USERNAME=root
    DB_PASSWORD=your_password`

4.  **Generate Application Key**

    bash

    Copy code

    `php artisan key:generate`


5.  **Generate Passport keys**

    bash

    Copy code

    `php artisan passport:keys`
    `php artisan passport:client --personal`

* * * * *

**Database Seeding**
--------------------

1.  **Run Migrations** Run the migrations to set up the database structure.

    bash

    Copy code

    `php artisan migrate`

2.  **Run Seeders** Seed the database with sample data (stadiums, pitches, schedules, and slots).

    bash

    Copy code

    `php artisan db:seed`

    This will:

    -   Create 2 stadiums.
    -   Add 3 pitches per stadium.
    -   Generate schedules and slots for each pitch.

* * * * *

**Running the Project**
-----------------------

1.  **Start the Development Server**

    bash

    Copy code

    `php artisan serve`

2.  **Access the API** Visit the API at http://127.0.0.1:8000.

3.  **Testing the API** Use tools like [Postman](https://documenter.getpostman.com/view/27553073/2sAYBPku6f) to test the API endpoints.

* * * * *

**API Endpoints**
-----------------

### **1\. List Available Slots**

-   **GET** `/api/stadiums/{stadium_id}/pitches/{pitch_id}/available-slots?date={date}`
-   **Description**: Returns all available booking slots for a specific pitch on a specific date.
-   **Example Request**:

    http

    Copy code

    `GET /api/client/reservations/get-time-slots?pitch_id=1&date=2024-11-16`

### **2\. Book a Pitch**

-   **POST** `/api/client/reservations/book`
-   **Description**: Books a slot for a given pitch.
-   **Request Body**:

    json

    Copy code

    `{
      "pitch_id": 1,
      "date": "2024-11-16",
      "slot_id": 5,
    }`

* * * * *

**Project Structure**
---------------------

plaintext

Copy code

`├── app/                   # Application logic
│   ├── Models/            # Eloquent models (e.g., Stadium, Pitch, Schedule, Slot)
│   ├── Http/Controllers/  # API controllers
├── database/
│   ├── migrations/        # Database migrations
│   ├── seeders/           # Seeders (e.g., ScheduleSeeder)
├── routes/
│   ├── api.php            # API routes
├── tests/                 # Automated tests
└── ...`

* * * * *

**License**
-----------

This project is licensed under the MIT License.

* * * * *

**Contact**
-----------

For any questions or support, feel free to contact your-email@example.com.

* * * * *

This file gives a clear and concise overview of the project and guides users through setting it up, running it, and testing it. Replace placeholders (e.g., `your-username`, `your-email@example.com`) with your details.
