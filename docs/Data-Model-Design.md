# [Implementation Plan](./Implementation-Plan.md) / Data Model Design

## Overview

This document outlines the complete data model design for Mad DnD Libs: The Chaotic Quest, defining all core entities, their relationships, and database schema requirements.

## Core Game Flow Review

1. **Madlibs Submission Phase**: Players submit words based on prompts
2. **Character & Loadout Selection**: Players select from generated characters, weapons, attacks
3. **Voting Phase**: Anonymous ranked voting on submissions
4. **Boss Battle**: Turn-based combat using selected items
5. **Post-Game Summary**: Results, calling cards, superlatives

## Core Data Models

### 1. Game Management

#### Games Table
- **Purpose**: Central game room/session management
- **Key Features**: Host management, room codes, configuration, state tracking

```sql
games:
  id (primary key)
  host_user_id (foreign key to users)
  room_code (unique, 6-8 character code)
  name (optional room name)
  status (waiting, in_progress, completed, abandoned)
  current_phase (submission, selection, voting, battle, summary)
  configuration (JSON: time limits, round structure, etc.)
  max_players (default 8)
  created_at
  updated_at
```

#### Game Participants Table
- **Purpose**: Track user participation in games with roles
- **Key Features**: Player roles, join timestamps, participation status

```sql
game_participants:
  id (primary key)
  game_id (foreign key to games)
  user_id (foreign key to users)
  role (host, player, spectator)
  status (active, disconnected, kicked)
  joined_at
  created_at
  updated_at
```

### 2. Madlibs System

#### Madlibs Templates Table
- **Purpose**: Predefined sentence templates with blanks
- **Key Features**: Different themes, configurable complexity

```sql
madlibs_templates:
  id (primary key)
  name
  category (bio, journey, battle)
  template_text (text with {adjective}, {noun} placeholders)
  required_word_types (JSON array: ["adjective", "noun", "verb"])
  difficulty_level (1-3)
  is_active (boolean)
  created_at
  updated_at
```

#### Madlibs Prompts Table
- **Purpose**: Individual word prompts for submissions
- **Key Features**: Word type specification, contextual hints

```sql
madlibs_prompts:
  id (primary key)
  game_id (foreign key to games)
  template_id (foreign key to madlibs_templates)
  word_type (noun, adjective, verb, adverb, etc.)
  prompt_text (e.g., "A scary adjective")
  position_in_template (integer)
  is_required (boolean)
  created_at
  updated_at
```

#### Madlibs Submissions Table
- **Purpose**: Player word submissions
- **Key Features**: Anonymous until reveal, validation status

```sql
madlibs_submissions:
  id (primary key)
  game_id (foreign key to games)
  user_id (foreign key to users)
  prompt_id (foreign key to madlibs_prompts)
  submitted_word
  is_validated (boolean)
  submitted_at
  created_at
  updated_at
```

### 3. Generated Content

#### Characters Table
- **Purpose**: Generated character combinations from madlibs
- **Key Features**: AI-generated descriptions, selection tracking

```sql
characters:
  id (primary key)
  game_id (foreign key to games)
  name (generated from madlibs)
  description (generated description)
  madlibs_source (JSON: which submissions were used)
  image_url (AI-generated image path)
  is_available (boolean)
  created_at
  updated_at
```

#### Weapons Table
- **Purpose**: Generated weapon combinations

```sql
weapons:
  id (primary key)
  game_id (foreign key to games)
  name (generated from madlibs)
  description (generated description)
  madlibs_source (JSON: which submissions were used)
  image_url (AI-generated image path)
  is_available (boolean)
  created_at
  updated_at
```

#### Attacks Table
- **Purpose**: Generated attack action combinations

```sql
attacks:
  id (primary key)
  game_id (foreign key to games)
  name (generated from madlibs)
  description (generated description)
  madlibs_source (JSON: which submissions were used)
  animation_type (slash, thrust, magic, etc.)
  is_available (boolean)
  created_at
  updated_at
```

### 4. Player Selections

#### Player Loadouts Table
- **Purpose**: Track player's selected character/weapon/attack combinations
- **Key Features**: Selection order, timestamps

```sql
player_loadouts:
  id (primary key)
  game_id (foreign key to games)
  user_id (foreign key to users)
  character_id (foreign key to characters, nullable)
  weapon_id (foreign key to weapons, nullable)
  attack_id (foreign key to attacks, nullable)
  selection_round (1, 2, 3, etc.)
  is_current (boolean)
  created_at
  updated_at
```

### 5. Voting System

#### Votes Table
- **Purpose**: Anonymous ranked voting on characters/weapons/attacks
- **Key Features**: Ranked voting, anonymous until reveal

```sql
votes:
  id (primary key)
  game_id (foreign key to games)
  voter_user_id (foreign key to users)
  category (character, weapon, attack)
  voted_item_id (polymorphic: character_id, weapon_id, attack_id)
  voted_item_type (character, weapon, attack)
  rank (1st, 2nd, 3rd place)
  created_at
  updated_at
```

#### Vote Results Table
- **Purpose**: Calculated vote results and multipliers
- **Key Features**: Aggregated scores, battle effectiveness multipliers

```sql
vote_results:
  id (primary key)
  game_id (foreign key to games)
  item_id (polymorphic)
  item_type (character, weapon, attack)
  total_score (calculated)
  effectiveness_multiplier (decimal: 0.5 - 2.0)
  rank_position (1st, 2nd, 3rd)
  created_at
  updated_at
```

### 6. Boss Battle System

#### Bosses Table
- **Purpose**: Boss characteristics and stats
- **Key Features**: Dynamic boss generation, health tracking

```sql
bosses:
  id (primary key)
  game_id (foreign key to games)
  name (generated or selected)
  description
  max_health (integer)
  current_health (integer)
  image_url
  special_abilities (JSON)
  created_at
  updated_at
```

#### Battle Rounds Table
- **Purpose**: Track battle progression and turns
- **Key Features**: Turn order, round results

```sql
battle_rounds:
  id (primary key)
  game_id (foreign key to games)
  round_number (integer)
  current_turn (integer)
  status (in_progress, completed)
  created_at
  updated_at
```

#### Battle Actions Table
- **Purpose**: Individual player attacks during battle
- **Key Features**: Dice rolls, damage calculation, animation data

```sql
battle_actions:
  id (primary key)
  game_id (foreign key to games)
  round_id (foreign key to battle_rounds)
  user_id (foreign key to users)
  loadout_id (foreign key to player_loadouts)
  dice_roll (integer 1-20)
  base_damage (integer)
  multiplier_bonus (decimal)
  total_damage (calculated)
  animation_data (JSON)
  success_level (critical, hit, miss)
  created_at
  updated_at
```

### 7. Game Results

#### Game Results Table
- **Purpose**: Final game outcomes and statistics
- **Key Features**: Win/loss, team performance metrics

```sql
game_results:
  id (primary key)
  game_id (foreign key to games)
  result (victory, defeat)
  total_damage_dealt (integer)
  rounds_completed (integer)
  mvp_user_id (foreign key to users, nullable)
  team_score (integer)
  created_at
  updated_at
```

#### Superlatives Table
- **Purpose**: Post-game awards and achievements
- **Key Features**: Various award categories, player recognition

```sql
superlatives:
  id (primary key)
  game_id (foreign key to games)
  user_id (foreign key to users)
  category (most_creative, highest_damage, funniest, etc.)
  title (string)
  description (text)
  created_at
  updated_at
```

#### Calling Cards Table
- **Purpose**: Player summary cards for sharing
- **Key Features**: Character summary, best moments

```sql
calling_cards:
  id (primary key)
  game_id (foreign key to games)
  user_id (foreign key to users)
  character_summary (JSON)
  best_attack_summary (JSON)
  image_url (generated card image)
  share_token (unique sharing identifier)
  created_at
  updated_at
```

## Model Relationships Summary

### User Model (Existing - Minor Updates)
- hasMany: games (as host)
- belongsToMany: games (as participant) through game_participants
- hasMany: madlibs_submissions
- hasMany: player_loadouts
- hasMany: votes
- hasMany: battle_actions
- hasMany: superlatives
- hasMany: calling_cards

### Core Relationships
1. **Games → Users**: Many-to-many (participants), One-to-many (host)
2. **Games → Madlibs**: One-to-many (templates, prompts, submissions)
3. **Games → Generated Content**: One-to-many (characters, weapons, attacks)
4. **Games → Voting**: One-to-many (votes, results)
5. **Games → Battle**: One-to-many (bosses, rounds, actions)
6. **Users → Selections**: One-to-many (loadouts, votes, actions)

## Implementation Priority

### Phase 1: Core Game Structure
1. Games and game_participants tables
2. Basic User model updates
3. Game state management

### Phase 2: Madlibs System
1. Madlibs templates, prompts, submissions
2. Content generation pipeline

### Phase 3: Selection and Voting
1. Characters, weapons, attacks tables
2. Player loadouts and voting system

### Phase 4: Battle System
1. Boss and battle management
2. Action tracking and results

### Phase 5: Results and Sharing
1. Game results and superlatives
2. Calling cards and sharing

## Database Schema Validation

### Indexes for Performance
- Games: room_code (unique), host_user_id, status, current_phase
- Game participants: game_id + user_id (composite), status
- Madlibs submissions: game_id + user_id, prompt_id
- Votes: game_id + voter_user_id, category
- Battle actions: game_id + round_id, user_id

### Data Integrity
- Foreign key constraints with appropriate cascade rules
- Unique constraints where necessary (room codes, share tokens)
- JSON validation for configuration and metadata fields
- Enum constraints for status and category fields

This design supports the complete game flow while maintaining data integrity and performance optimization.