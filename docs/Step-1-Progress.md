# [Implementation](./Implementation-Plan.md) Step 1: Project Setup Progress

## Nuxt.js Project Initialization

- [x] In the `frontend` directory:
- [x] Initialized Nuxt.js project using `npx nuxi init`
- [x] Configured basic project structure
- [x] Installed core dependencies (Vuetify, VueUse Motion)

## Laravel Backend Setup

- [ ] In the `backend` directory:
- [x] Created Laravel project using Composer
- [x] Configured database connection (MySQL; Defaulted to SQLite, let's try it for now)
- [x] Set up basic API routes (examples)
  - [x] GET /api/v1/examples/templates
  - [x] GET /api/v1/examples/story/{id}
- [ ] Implement basic authentication and authorization
  - [ ] Install and configure Laravel Sanctum
  - [ ] Create login/register endpoints
  - [ ] Set up authentication middleware
  - [ ] Create protected routes
  - [ ] Add user roles and permissions

## WebSocket Server Configuration

- [ ] Chose WebSocket server implementation (e.g., Laravel Echo Server - Laravel Reverb)
- [ ] Installed WebSocket server dependencies
- [ ] Configured WebSocket event broadcasting

## CI/CD Pipeline Setup

- [ ] Created repository on GitHub/GitLab
- [ ] Configured CI/CD pipeline (e.g., GitHub Actions)
- [ ] Set up automated build and deployment
- [ ] Added environment variables for CI/CD
- [ ] Conducted tests on CI/CD pipeline
  - [ ] Frontend tests
  - [ ] Backend tests

## Development Environment Configuration

- ~~Installed Docker and Docker Compose (if using)~~
- [ ] Configured local PHP development environment
- [ ] Ensured consistent environment across team members
