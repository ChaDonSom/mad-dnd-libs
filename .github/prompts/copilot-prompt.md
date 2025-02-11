See [readme](README.md) for more information on how to use this repository.

## Tech stack

- **Frontend:** Nuxt.js (Vue 3-based)
- **UI Framework:** Vuetify
- **Animations:** VueUse Motion (for path and transform animations)
- **Real-time Updates:** WebSockets for game state synchronization: Laravel Reverb
- **Backend:** Laravel (PHP)
- **Hosting:** Forge-provisioned DigitalOcean droplet
- **Database:** MySQL (planned) / SQLite (for now)

### Conventions

- **Vue 3 Composition API:**

  - TS for Vue components
  - use `setup` for component logic
  - `script` tag above `template`
  - **Pinia** for state management
    - `defineStore` for store creation: create a 'use' function that functions on its own and use it in the `defineStore` function with a store name and the function as arguments

- **Vuetify:**

  - Rounded corners
  - Use tailwind when possible, vuetify when necessary
  - Use Vuetify for components, Tailwind for utility classes

- **General:**
  - Use `kebab-case` for file names
  - Use `PascalCase` for component names
  - Use `camelCase` for variables and functions
  - Use `UPPER_CASE` for constants
  - Use `snake_case` for database columns and frontend reflections of them (e.g. in a form or frontend model)
  - File size: break larger files into smaller ones
    - Use `@/` alias for imports
  - Use `// TODO:` for future improvements
    - Use `// FIXME:` for bugs
  - Use Vue file naming conventions: `GeneralSpecific.vue`
    - Organize components into folders when more than 3-4 components with shared general names exist
  - For this specific project, reference the [readme](../../README.md), [requirements](../../docs/MadDndLibs_Requirements.md), and [design](../../docs/Implementation-Plan.md) documents, which have further links to more documents, for work in progress
  - Try to work from a md document with a checklist, if possible, to ensure all tasks are completed. The checklist document should link back to the implementation plan or a checklist/implementation-plan document that is directly or indirectly linked to it. We just want to ensure the document is linked to the implementation plan in some way. Also there should be links coming down to your checklist document from above as well. Update the checklist document as you go along. This will help us keep track of progress and ensure we are on the right track.
