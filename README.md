# Mad DnD Libs: The Chaotic Quest

## Overview

Mad DnD Libs: The Chaotic Quest is a multiplayer web-based party game where players collaboratively create absurd characters, weapons, and attacks using a madlibs-style input system. The game balances randomness and player agency, incorporating voting-based humor mechanics that impact battle effectiveness.

## Getting Started

### Prerequisites

- Node.js 18+ (for frontend)
- PHP 8.1+ (for backend)
- Composer (for backend dependencies)

### Quick Setup

Run the automated setup script:

```bash
git clone https://github.com/ChaDonSom/mad-dnd-libs.git
cd mad-dnd-libs
./setup.sh
```

### Manual Setup

If you prefer to set up manually:

1. **Backend Setup:**
   ```bash
   cd backend
   composer install
   cp .env.example .env
   php artisan key:generate
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed
   ```

2. **Frontend Setup:**
   ```bash
   cd frontend
   npm install
   ```

### Running the Application

Start both servers in separate terminals:

1. **Backend:**
   ```bash
   cd backend
   php artisan serve
   ```

2. **Frontend:**
   ```bash
   cd frontend
   npm run dev
   ```

Then visit:
- **Frontend:** http://localhost:3000
- **Backend API:** http://localhost:8000

### First Steps

1. Visit http://localhost:3000/register to create an account
2. Use the "Auto-fill test data" button for quick testing
3. Start exploring the game features!

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
