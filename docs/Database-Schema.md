# [Data Model Design](./Data-Model-Design.md) / Database Schema

## Entity Relationship Diagram

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│      users      │    │      roles      │    │   permissions   │
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │    │ id (PK)         │
│ name            │◄──┐│ name            │◄──┐│ name            │
│ email           │   ││ slug            │   ││ slug            │
│ password        │   ││ description     │   ││ description     │
│ created_at      │   │└─────────────────┘   │└─────────────────┘
│ updated_at      │   │         ▲             │         ▲
└─────────────────┘   │         │             │         │
         ▲             │    ┌─────────────┐    │    ┌─────────────┐
         │             └────┤ role_user   │    └────┤permission_  │
         │                  │ (junction)  │         │role         │
         │                  └─────────────┘         │(junction)   │
         │                                          └─────────────┘
         │
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│      games      │    │game_participants│    │madlibs_templates│
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │◄───┤ id (PK)         │    │ id (PK)         │
│ host_user_id(FK)├──┐ │ game_id (FK)    │    │ name            │
│ room_code       │  │ │ user_id (FK)    ├─┐  │ category        │
│ name            │  │ │ role            │ │  │ template_text   │
│ status          │  │ │ status          │ │  │ required_word_  │
│ current_phase   │  │ │ joined_at       │ │  │ types           │
│ configuration   │  │ └─────────────────┘ │  │ difficulty_level│
│ max_players     │  │                     │  │ is_active       │
│ created_at      │  │                     │  └─────────────────┘
│ updated_at      │  │                     │           │
└─────────────────┘  │                     │           ▼
         │            │                     │  ┌─────────────────┐
         ▼            │                     │  │madlibs_prompts  │
┌─────────────────┐   │                     │  ├─────────────────┤
│madlibs_         │   │                     │  │ id (PK)         │
│submissions      │   │                     │  │ game_id (FK)    ├─┐
├─────────────────┤   │                     │  │ template_id(FK) │ │
│ id (PK)         │   │                     │  │ word_type       │ │
│ game_id (FK)    ├───┘                     │  │ prompt_text     │ │
│ user_id (FK)    ├─────────────────────────┘  │ position_in_    │ │
│ prompt_id (FK)  ├────────────────────────────┤ template        │ │
│ submitted_word  │                            │ is_required     │ │
│ is_validated    │                            └─────────────────┘ │
│ submitted_at    │                                         ▲      │
└─────────────────┘                                         └──────┘

┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   characters    │    │     weapons     │    │     attacks     │
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │    │ id (PK)         │
│ game_id (FK)    │    │ game_id (FK)    │    │ game_id (FK)    │
│ name            │    │ name            │    │ name            │
│ description     │    │ description     │    │ description     │
│ madlibs_source  │    │ madlibs_source  │    │ madlibs_source  │
│ image_url       │    │ image_url       │    │ animation_type  │
│ is_available    │    │ is_available    │    │ is_available    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                    player_loadouts                              │
├─────────────────────────────────────────────────────────────────┤
│ id (PK)                                                         │
│ game_id (FK)                                                    │
│ user_id (FK)                                                    │
│ character_id (FK) ──────────────┘                               │
│ weapon_id (FK) ─────────────────────────────┘                   │
│ attack_id (FK) ────────────────────────────────────────────┘    │
│ selection_round                                                 │
│ is_current                                                      │
└─────────────────────────────────────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│      votes      │    │  vote_results   │    │     bosses      │
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │    │ id (PK)         │
│ game_id (FK)    │    │ game_id (FK)    │    │ game_id (FK)    │
│ voter_user_id   │    │ item_id         │    │ name            │
│ category        │    │ item_type       │    │ description     │
│ voted_item_id   │    │ total_score     │    │ max_health      │
│ voted_item_type │    │ effectiveness_  │    │ current_health  │
│ rank            │    │ multiplier      │    │ image_url       │
└─────────────────┘    │ rank_position   │    │ special_        │
                       └─────────────────┘    │ abilities       │
                                              └─────────────────┘
                                                       │
                                                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│ battle_rounds   │    │ battle_actions  │    │ game_results    │
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │    │ id (PK)         │
│ game_id (FK)    │    │ game_id (FK)    │    │ game_id (FK)    │
│ round_number    │◄───┤ round_id (FK)   │    │ result          │
│ current_turn    │    │ user_id (FK)    │    │ total_damage_   │
│ status          │    │ loadout_id (FK) │    │ dealt           │
└─────────────────┘    │ dice_roll       │    │ rounds_completed│
                       │ base_damage     │    │ mvp_user_id(FK) │
                       │ multiplier_bonus│    │ team_score      │
                       │ total_damage    │    └─────────────────┘
                       │ animation_data  │
                       │ success_level   │    ┌─────────────────┐
                       └─────────────────┘    │  superlatives   │
                                              ├─────────────────┤
┌─────────────────┐                          │ id (PK)         │
│ calling_cards   │                          │ game_id (FK)    │
├─────────────────┤                          │ user_id (FK)    │
│ id (PK)         │                          │ category        │
│ game_id (FK)    │                          │ title           │
│ user_id (FK)    │                          │ description     │
│ character_      │                          └─────────────────┘
│ summary         │
│ best_attack_    │
│ summary         │
│ image_url       │
│ share_token     │
└─────────────────┘
```

## Key Relationships

### 1. User Management
- **Users ↔ Roles**: Many-to-many through `role_user`
- **Roles ↔ Permissions**: Many-to-many through `permission_role`

### 2. Game Core
- **Games ↔ Users (Host)**: One-to-many (one user can host multiple games)
- **Games ↔ Users (Participants)**: Many-to-many through `game_participants`

### 3. Madlibs System
- **Games → Madlibs Submissions**: One-to-many
- **Users → Madlibs Submissions**: One-to-many
- **Madlibs Templates → Prompts**: One-to-many
- **Prompts → Submissions**: One-to-many

### 4. Generated Content
- **Games → Characters/Weapons/Attacks**: One-to-many
- **Generated Content → Player Loadouts**: Many-to-many (through foreign keys)

### 5. Selection & Voting
- **Users → Player Loadouts**: One-to-many
- **Users → Votes**: One-to-many
- **Games → Vote Results**: One-to-many (calculated)

### 6. Battle System
- **Games → Boss**: One-to-one
- **Games → Battle Rounds**: One-to-many
- **Battle Rounds → Battle Actions**: One-to-many
- **Player Loadouts → Battle Actions**: One-to-many

### 7. Results & Sharing
- **Games → Game Results**: One-to-one
- **Games → Superlatives**: One-to-many
- **Games → Calling Cards**: One-to-many

## Indexes and Performance

### Primary Indexes
- All tables have auto-incrementing `id` primary keys
- Unique constraints on business keys (room_code, share_token, etc.)

### Foreign Key Indexes
- All foreign keys have indexes for join performance
- Composite indexes on frequently queried combinations

### Query Optimization Indexes
- `games`: (status, current_phase), (host_user_id)
- `game_participants`: (game_id, status)
- `votes`: (game_id, category), (voter_user_id, category)
- `battle_actions`: (game_id, round_id), (user_id, round_id)

## Data Integrity

### Cascade Rules
- **ON DELETE CASCADE**: Remove dependent records when parent is deleted
  - Game deletion removes all related game data
  - User deletion removes their participation records
- **ON DELETE SET NULL**: Preserve records but null foreign keys
  - Character/weapon/attack deletion preserves loadout structure
  - MVP user deletion preserves game results

### Validation Rules
- **Enums**: Status fields use predefined values for consistency
- **JSON Fields**: Configuration and metadata stored as validated JSON
- **Unique Constraints**: Business keys enforced at database level

## Sample Queries

### Game Statistics
```sql
-- Get user's game win rate
SELECT 
    u.name,
    COUNT(gp.game_id) as total_games,
    COUNT(CASE WHEN gr.result = 'victory' THEN 1 END) as wins,
    (COUNT(CASE WHEN gr.result = 'victory' THEN 1 END) * 100.0 / COUNT(gp.game_id)) as win_rate
FROM users u
JOIN game_participants gp ON u.id = gp.user_id
JOIN games g ON gp.game_id = g.id
LEFT JOIN game_results gr ON g.id = gr.game_id
WHERE u.id = ?
GROUP BY u.id, u.name;
```

### Vote Tallying
```sql
-- Calculate vote results for characters in a game
SELECT 
    c.id,
    c.name,
    COUNT(v.id) as vote_count,
    SUM(CASE WHEN v.rank = 1 THEN 3 WHEN v.rank = 2 THEN 2 WHEN v.rank = 3 THEN 1 ELSE 0 END) as total_score
FROM characters c
LEFT JOIN votes v ON c.id = v.voted_item_id AND v.voted_item_type = 'character'
WHERE c.game_id = ?
GROUP BY c.id, c.name
ORDER BY total_score DESC;
```

### Battle Damage Summary
```sql
-- Get total damage by player in a game
SELECT 
    u.name,
    SUM(ba.total_damage) as total_damage,
    COUNT(ba.id) as attack_count,
    AVG(ba.total_damage) as avg_damage
FROM users u
JOIN battle_actions ba ON u.id = ba.user_id
WHERE ba.game_id = ?
GROUP BY u.id, u.name
ORDER BY total_damage DESC;
```

This schema supports the complete Mad DnD Libs game flow while maintaining data integrity, performance, and scalability.