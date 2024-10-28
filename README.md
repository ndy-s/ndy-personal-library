# Ndy Personal Library

I created this project to manage my collection of digital resources tutorials, guides, and books that pique my curiosity. While some resources are free, others are hidden behind paywalls. I've discovered alternative sources for personal use, but keeping track of everything has become a challenge. My digital storage was cluttered, resembling a tangled web, making it hard to find anything.

To solve this, I developed a personal library management system to organize my resources efficiently.

## Project Overview
### Demo
Check out a glimpse of the website in action:

![ndyapp-demo](https://github.com/ndy-s/ndy-app-personal-library/assets/94002483/6a56d04a-9821-4e3b-b7cf-e2295b36b35f)

### Stack
Built with:
- **Laravel**: Backend framework
- **Vue.js**: Frontend framework
- **Inertia.js**: Enables seamless transitions
- **Tailwind CSS**: For styling

### Features
- **CRUD Operations**: Manage data through the backend.
- **Hierarchical Structure**: Supports sub-data for smooth navigation.
- **Infinite Scrolling**: Inspired by social media, users can scroll endlessly through their library, enhancing user experience.

## Getting Started
To set up the project locally:
1. Clone the repository.
2. Install dependencies using composer and npm:
    ```
    composer install
    npm install
    ```
3. Set up your environment:
    ```
    cp .env-example .env
    php artisan key:generate
    ```
4. Run migrations to set up the database:
    ```
    php artisan migrate
    ```
5. Start the development server:
    ```
    npm run dev
    ```

**Note:** Initially, there won't be any data, so you'll need to add it manually via the management section. This project serves as a starting point, feel free to customize it to suit your needs.

## License
MIT
