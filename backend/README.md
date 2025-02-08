# Mad-DnD-Libs: The Chaotic Quest - Backend Documentation

## Overview

The backend for Mad DnD Libs: The Chaotic Quest is built using Laravel, a powerful PHP framework. This backend handles game state management, user interactions, and real-time updates for the multiplayer web-based party game.

## Setup Instructions

1. **Clone the Repository:**

   ```
   git clone https://github.com/yourusername/mad-dnd-libs.git
   cd mad-dnd-libs/backend
   ```

2. **Install Dependencies:**
   Ensure you have Composer installed, then run:

   ```
   composer install
   ```

3. **Environment Configuration:**
   Copy the `.env.example` file to `.env` and configure your database and other environment variables:

   ```
   cp .env.example .env
   ```

4. **Generate Application Key:**
   Run the following command to generate the application key:

   ```
   php artisan key:generate
   ```

5. **Migrate the Database:**
   Set up your database and run migrations:

   ```
   php artisan migrate
   ```

6. **Serve the Application:**
   You can serve the application using the built-in PHP server:
   ```
   php artisan serve
   ```

## Usage

- The backend provides APIs for managing game sessions, player interactions, and real-time updates.
- Ensure that WebSockets are configured for real-time voting and game state synchronization.

## Directory Structure

- **artisan**: Command-line interface for running various Laravel commands.
- **public/index.php**: Entry point for the application.
- **routes/web.php**: Defines the web routes for the application.
- **config/**: Contains configuration files for various aspects of the Laravel application.

## Contributing

Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.
