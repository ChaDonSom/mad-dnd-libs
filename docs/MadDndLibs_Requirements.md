# [Readme](../README.md) / Mad-DnD-Libs: The Chaotic Quest - Design Requirements Document

## 1. Overview

Mad DnD Libs: The Chaotic Quest is a multiplayer web-based party game where players collaboratively create absurd characters, weapons, and attacks using a madlibs-style input system. The game balances randomness and player agency, incorporating voting-based humor mechanics that impact battle effectiveness. This document outlines the complete technical and gameplay requirements necessary to implement the game.

## 2. Core Game Loop

1. **Madlibs Submission Phase:**

   - Players submit randomized words (nouns, adjectives, verbs, etc.)
   - Guided prompts, themes, and structured sentence blanks make submission engaging.
   - Configurable timer for submissions.

2. **Character & Loadout Selection:**

   - The game generates character, weapon, and attack-action combinations from madlibs submissions.
   - Players pick from a limited, randomized selection of characters, weapons, and attacks (snake-draft style: character → weapon → action).
   - Selection is time-limited (configurable by host).

3. **Voting Phase:**

   - Players vote on the funniest/most creative characters, weapons, and actions (ranked voting: 1st, 2nd, 3rd, etc., optional beyond 1st).
   - Votes are anonymous until the results are revealed.
   - Voting results generate multipliers for boss battle effectiveness.

4. **Boss Battle:**

   - Players use their selected character, weapon, and action in a turn-based attack sequence.
   - Attack effectiveness is determined by previous voting results + dice rolls.
   - Animations reflect success/failure with variation in movement paths, exaggerated effects, and unique action styles.
   - Boss retaliates dynamically.
   - If players fail to defeat the boss after their first round of attacks, they enter another round of selection where they pick only new weapons and attack-actions (characters remain unless a character dies, in which case the player picks a new one).

5. **Post-Game Summary:**

   - Players receive a ‘calling card’ summarizing their character and best attack.
   - Superlatives (e.g., “Most Creative Attack”) awarded.
   - Configurable option for saving/sharing session highlights.

---

## 3. Technical Requirements

### 3.1 Frontend

- **Framework:** Nuxt.js (Vue 3-based)
- **Component Library:** Vuetify
- **Animations:** VueUse Motion (for path and transform animations)
- **Real-time Updates:** WebSockets for game state synchronization
- **UI Requirements:**
  - Mobile-first design, with optional TV-style game overview.
  - Players can join from mobile and play without needing a separate streamed view.
  - Running score display and cinematic attack sequences.
  - Dice visualization, multiplier visualization

### 3.2 Backend

- **Framework:** Laravel (PHP)
- **Hosting:** Forge-provisioned DigitalOcean droplet
- **Database:** MySQL
- **Game State Management:**
  - Sessions persist for game history tracking.
  - Temporary data storage for active sessions.
- **AI-Generated Content:**
  - AI-generated images for characters, weapons, and attacks based on randomized inputs.
  - AI-generated storytelling elements incorporating player decisions.

### 3.3 Multiplayer & Hosting

- **Game Rooms:**
  - Hosted by a single player, guests join via ephemeral links/passcodes.
  - Hosts can optionally share host privileges. The player given the host privileges will have the room until they sign out, but are also encouraged to (if they haven’t) sign up for a ‘host’-level account with email + password, and, if they do, the signed-up account gains ownership of the room.
- **Real-Time Voting System:**
  - WebSocket-based ranked voting.
  - Anonymous voting until results are revealed.
- **Game Configuration Options:**
  - Round structure (e.g., bio, journey, boss battle). Preset options ‘bio’, ‘journey’, and ‘battle’, which hosts can pick from for each of the 3 rounds.
  - Submission time limits. Min 30 seconds, max 5 minutes
  - Selection time limits. Min 30 seconds, max 5 minutes
  - Event linking (optional feature). Does each round build its theme somehow on the last round?

---

## 4. Open Questions

1\. Madlibs Input UX:

- Default Approach: Implement a combination of sentence templates with blanks, standalone prompts with descriptive cues, and story prompts for free-form, short submissions.

&#x9;2\. Boss Battle Flow:

- Default Approach: Players will vote on the boss’s characteristics and attacks to enhance engagement and influence battle dynamics.

&#x9;3\. Attack Animation Variation:

- Default Approach: Introduce a mechanic where players can rapidly press a button to assist their teammate in defeating the boss, providing an additional multiplier. Further enhancements can be considered in future iterations.

&#x9;4\. Progression & Rewards:

- Default Approach: This aspect will remain open for future development, with potential features to be added based on player feedback and game evolution.

5. Event Linking:

- How do events ‘build’ on previous events?

\---

This document serves as a starting point for implementation. We should refine and expand it as more details emerge during development.

## [Implementation Plan](./Implementation-Plan.md)
