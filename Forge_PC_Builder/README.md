Forge PC Builder

### Build Your Dream PC.

Forge PC Builder is a dynamic web development project developed as part of the **Dynamic Web Development (DWD) module**. The project focuses on creating an interactive PC building platform where users can explore computer components, customise their own PC builds, and manage their configurations.

The website combines a modern gaming-inspired interface with dynamic functionality powered by PHP and MySQL.

---

## Project Overview

Building a custom PC can be challenging, especially when choosing compatible components within a specific budget.

### Forge PC Builder aims to simplify this process by providing a platform where users can:

- Browse and explore PC components.
- View detailed component specifications.
- Select components to create custom PC builds.
- Calculate the total cost of a selected configuration.
- Manage and save their PC builds.

The project demonstrates the practical application of front-end development, server-side programming, database integration, and dynamic web functionality.

## Key Features

| Feature | Description |
|---|---|
| Component Catalogue | Browse available PC components and specifications. |
| PC Builder | Select different components to create a custom PC. |
| Price Calculation | Dynamically calculate the total price of a build. |
| Component Details | Display specifications and information for each component. |
| User Accounts | User registration and login functionality. |
| Build Management | Save and manage custom PC configurations. |
| Database Integration | Store and retrieve component and user information using MySQL. |

*Feature availability may vary as development progresses.*

## 🛠️ Technologies Used

**Frontend**
- HTML5
- CSS3
- JavaScript

**Backend**
- PHP

**Database**
- MySQL

**Development Tools**
- Visual Studio Code
- Git & GitHub
- GitHub Codespaces
- phpMyAdmin

## Database Design

The project uses an existing relational database structure provided as part of the module requirements.

The database consists of **9 tables**:

| Table | Purpose |
|---|---|
| `components` | Stores general component information. |
| `cpu_specs` | Stores CPU specifications. |
| `gpu_specs` | Stores GPU specifications. |
| `motherboard_specs` | Stores motherboard specifications. |
| `ram_specs` | Stores RAM specifications. |
| `storage_specs` | Stores storage specifications. |
| `psu_specs` | Stores power supply specifications. |
| `users` | Stores registered user information. |
| `builds` | Stores custom PC build information. |
| `build_components` | Records components selected for each build. |

The component specification tables are linked to the main `components` table through `component_id`, while user builds are connected through relational database relationships.

## Design Concept

The website follows a modern gaming-inspired visual identity.

- Dark user interface.
- RGB-inspired accent colours.
- Modern typography and layouts.
- Interactive component cards.
- Clean and responsive navigation.
- Gaming hardware-inspired aesthetics.

The goal is to create an interface that feels familiar to PC enthusiasts while remaining easy to navigate.

## Project Structure

The project is organised around frontend pages, backend functionality, and database integration.

```text
Forge-PC-Builder/
│
├── assets/
│   ├── images/
│   ├── icons/
│   └── styles/
│
├── css/
│
├── js/
│
├── php/
│
├── database/
│
├── index.php
├── README.md
└── ...
```

*The structure above is an example and can be updated to reflect the actual repository.*

## Getting Started

To run the project locally:

1. Clone the repository.

   ```bash
   git clone YOUR_REPOSITORY_URL
   ```

2. Open the project using Visual Studio Code.

3. Set up a local PHP and MySQL environment using XAMPP or another compatible development environment.

4. Create a MySQL database and import the provided database structure.

5. Configure the database connection details in the PHP configuration file.

6. Start Apache and MySQL.

7. Open the project in your browser through your local server.

   ```text
   http://localhost/Forge-PC-Builder/
   ```

## Academic Context

**Module:** Dynamic Web Development (DWD)

**Project:** Forge PC Builder

**Developer:** Min Kyaw

This project is developed to demonstrate an understanding of dynamic web development concepts, including:

- Frontend website development.
- PHP server-side programming.
- MySQL database design and integration.
- CRUD (Create, Read, Update, Delete) operations.
- Dynamic content generation.
- User authentication.
- Database relationships and queries.

## Project Status

<code>In Development</code>

The project is being developed incrementally, with the aim of implementing the core PC building functionality and demonstrating the integration of frontend and backend technologies.

---

## Developer

**Min Kyaw**

---

