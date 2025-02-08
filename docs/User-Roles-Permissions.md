# [Step 1](./Step-1-Progress.md) / User Roles and Permissions

## 1. Overview

This document outlines the user roles and permissions for the Mad DnD Libs: The Chaotic Quest game. It defines the different roles within the system and the specific actions each role is authorized to perform.

## 2. Roles

### 2.1 Guest

- **Description:** A user who has not logged in or created an account.
- **Permissions:**
  - `view_public_content`: Can view public content like the landing page and game instructions.
  - `join_game`: Can join a game room using a link or passcode.

### 2.2 Player

- **Description:** A user who is participating in a game.
- **Permissions:**
  - `view_game_content`: Can view the game room and its content.
  - `play_game`: Can participate in the game and view the post-game summary.
  - `participate_voting`: Can participate in voting.
  - `view_post_game_summary`: Can view the post-game summary.

### 2.3 Host

- **Description:** A user who has created a game room and has administrative privileges over it.
- **Permissions:**
  - All Player permissions.
  - `host_game`: Can create a new game room and start the game.
  - `configure_game`: Can configure game settings (e.g., time limits, round structure).
  - `manage_players`: Can manage players in the game room (e.g., kick players).
  - `assign_host_privileges`: Can transfer host privileges to another player.

### 2.4 Admin

- **Description:** A user with full administrative access to the entire system.
- **Permissions:**
  - All Host permissions.
  - `manage_users`: Can create, edit, and delete user accounts.
  - `manage_roles`: Can create, edit, and delete roles.
  - `manage_permissions`: Can create, edit, and delete permissions.
  - `access_server_settings`: Can access and modify server settings.

## 3. Permission Details

- `view_public_content`: Allows the user to view public pages such as the landing page, game rules, and other informational content.
- `join_game`: Allows the user to join an existing game room using a valid link or passcode.
- `view_game_content`: Allows the user to see the contents of the game room, including other players and game progress.
- `play_game`: Allows the user to fully participate in the game (submit madlibs, select items, interact in battle).
- `participate_voting`: Allows the user to participate in voting for characters, weapons, and actions.
- `view_post_game_summary`: Allows the user to view the post-game summary, including results and superlatives.
- `host_game`: Allows the user to create and start new game rooms.
- `configure_game`: Allows the user to configure game settings such as time limits and round structure.
- `manage_players`: Allows the user to manage players in the game room, including the ability to kick players if necessary.
- `assign_host_privileges`: Allows the user to transfer host privileges to another player in the game room.
- `manage_users`: Allows the user to create, edit, and delete user accounts in the system.
- `manage_roles`: Allows the user to create, edit, and delete roles in the system.
- `manage_permissions`: Allows the user to create, edit, and delete permissions in the system.
- `access_server_settings`: Allows the user to access and modify server settings.

## 4. Implementation Notes

- User roles and permissions should be implemented using a Role-Based Access Control (RBAC) system.
- Permissions should be checked at each relevant point in the application to ensure that users only have access to authorized features and data.
- Regular audits of user roles and permissions should be conducted to ensure that they are up-to-date and appropriate.

## 5. Temporary Users

### Temporary User Accounts:

When a user joins via an ephemeral link/passcode, create a temporary user account.  
Generate a unique identifier stored in their browser's localStorage.  
This ID allows them to reconnect to the same session if they disconnect.  
Temporary accounts expire after the game session ends.

### Optional Account Conversion:

During or after the game, offer temporary users the option to convert to permanent accounts.  
If they choose to convert, they can provide email/password to keep their game history.  
If they decline, their temporary account data is cleaned up after session expiry.
