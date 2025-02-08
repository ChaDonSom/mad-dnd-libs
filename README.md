# Mad DnD Libs: The Chaotic Quest

## Overview

Mad DnD Libs: The Chaotic Quest is a multiplayer web-based party game where players collaboratively create absurd characters, weapons, and attacks using a madlibs-style input system. The game balances randomness and player agency, incorporating voting-based humor mechanics that impact battle effectiveness.

## Getting Started

### Prerequisites

- Node.js (for frontend)
- PHP (for backend)
- Composer (for backend)
- MySQL (for database)

### Installation

1. **Clone the repository:**

   git clone https://github.com/yourusername/mad-dnd-libs.git

2. **Navigate to the project directory:**

   cd mad-dnd-libs

3. **Set up the frontend:**

   - Navigate to the frontend directory:
     cd frontend
   - Install dependencies:
     npm install

4. **Set up the backend:**

   - Navigate to the backend directory:
     cd ../backend
   - Install dependencies:
     composer install

5. **Configure the database:**

   - Create a new MySQL database for the project.
   - Update the `.env` file in the backend directory with your database credentials.

6. **Run the migrations:**

   php artisan migrate

### Running the Application

- **Frontend:**

  - Start the development server:
    npm run dev

- **Backend:**
  - Start the Laravel server:
    php artisan serve

## Gameplay

1. **Madlibs Submission Phase:** Players submit randomized words.
2. **Character & Loadout Selection:** Players select characters, weapons, and actions.
3. **Voting Phase:** Players vote on the funniest/most creative submissions.
4. **Boss Battle:** Players use their selections in a turn-based battle against a boss.
5. **Post-Game Summary:** Players receive a summary of their performance.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any enhancements or bug fixes.

Review the [Requirements](docs/MadDndLibs_Requirements.md) and [Implementation Plan](docs/Implementation-Plan.md) for more details.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
