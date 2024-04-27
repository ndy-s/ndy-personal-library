# NdyApp Personal Library

I usually looks for a collection of digital resources—tutorials, guides, and books—that feed my curiosity. While some of these resources are readily accessible, others are tucked behind paywalls. But, I've come across alternative sources that provide these materials for free (though I don’t recommend this approach, strictly for personal use, of course). To keep track of these valuable materials, I save them in my digital or cloud storage.

However, my digital storage resembles a cluttered attic. Folders upon folders, like a tangled web, make finding anything akin to a treasure hunt. So, I decided to create a solution—a personal library management project—to organize my data efficiently.

## Project Overview
### Demo
Check out a glimpse of the website in action:
~ DEMO [Tobe Added]

### Stack
The project is built using Laravel, Vue.js, and Inertia.js, complemented by Tailwind CSS. Additionally, I’ve incorporated other necessary stacks to ensure the project runs smoothly.

### Features
The project currently offers three distinct management sections, each statically created for now. Users can leverage the backend to perform CRUD operations on data, while the frontend provides a visually enhanced representation of the stored information. Additionally, the backend supports sub-data, enabling users to navigate smoothly through hierarchical structures.

One of the standout features of this project is the implementation of infinite scrolling using Vue.js. Inspired by social media platforms, this functionality allows users to scroll endlessly through their resource library, reducing initial page load times and enhancing overall user experience.

## Getting Started
To replicate this project:
1. Clone the GitHub repository.
2. Install dependencies using Composer and npm:
    ```
    composer install
    npm install
    ```
3. Copy the `.env-example` file and rename it to `.env`. Generate an application key:
    ```
    cp .env-example .env
    php artisan key:generate
    ```
4. Run migrations to set up the database schema:
    ```
    php artisan migrate
    ```
5. Finally, run the project:
    ```
    npm run dev
    ```

**Note:** 
- Initially, there won't be any data, so you'll need to add it manually through the management section.
- Keep in mind that this project is designed as a starting point. You may need to customize certain aspects to meet your specific needs and preferences.

## License
MIT