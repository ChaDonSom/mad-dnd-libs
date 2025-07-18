#!/bin/bash

# Mad DnD Libs - Quick Setup Script
# This script sets up both backend and frontend for development

set -e  # Exit on any error

echo "🎲 Setting up Mad DnD Libs: The Chaotic Quest..."
echo ""

# Backend Setup
echo "📦 Setting up Backend (Laravel)..."
cd backend

echo "  ├─ Installing PHP dependencies..."
composer install --quiet

echo "  ├─ Setting up environment file..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "    ✓ Created .env from .env.example"
else
    echo "    ✓ .env already exists"
fi

echo "  ├─ Generating application key..."
php artisan key:generate --quiet

echo "  ├─ Setting up database..."
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    echo "    ✓ Created SQLite database file"
else
    echo "    ✓ Database file already exists"
fi

echo "  ├─ Running migrations..."
php artisan migrate --quiet

echo "  ├─ Seeding database with roles and permissions..."
php artisan db:seed --quiet

echo "  ✓ Backend setup complete!"
echo ""

# Frontend Setup
echo "🎨 Setting up Frontend (Nuxt.js)..."
cd ../frontend

echo "  ├─ Installing Node.js dependencies..."
npm install --silent

echo "  ✓ Frontend setup complete!"
echo ""

# Final Instructions
echo "🚀 Setup Complete! Ready to start development:"
echo ""
echo "To start the application:"
echo "  1. Backend:  cd backend && php artisan serve"
echo "  2. Frontend: cd frontend && npm run dev"
echo ""
echo "Then visit:"
echo "  • Frontend: http://localhost:3000"
echo "  • Backend API: http://localhost:8000"
echo ""
echo "🎯 Try registering a new account at: http://localhost:3000/register"
echo ""