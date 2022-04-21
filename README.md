# Read And Enjoy It

This project is for a FullStack Challenge to Maniak a Butchershop Company. 

The challenge consists of create system to manage a library with the following user stories.

- Create a book
- Edit a book
- Delete a book
- Show a paginated list/table with all the books
- Filter the list/table mentioned above
- Consult if the book has been borrowed, or if it is available
- Change the status of a book from available to not available (use a modal for this feature)

### *Extras*
- Select a book categort with a autocomplete select
- See the user who has a book


## Before starting

You need to install the following technologies in order to setup the project

* PHP: >= 8.0.17
* MYSQL: 5.7
* Composer
* NPM
* Node Js
* Vue CLI
* Git

>  **Note**: Create a database in MySQL, it use to configure the API of the project.


## Setup Project

Clone the project

```bash
  git clone https://github.com/Juliovazquezc/ReadAndEnjoyIt.git
  cd ReadAndEnjoyIt
```

The project is divided in two parts, frontend and backend, to run the backend follow the next instructions.

### Backend
*The backend wass developed using Laravel in its last version (9.2).*

Go to the backend folder
```bash
  cd backend/
```
Renames **env.example** to **.env

- For **Linux/Unix** enviroments
```bash
  cp .env.example .env
```

- For **Windows** enviroments
```bash
  copy .env.example .env
```
Into the **.env** file configure your enviroment variables as following:
```bash
APP_NAME=ReadAndEnjoyIt
APP_ENV=local
APP_KEY=<It will be generated later>
APP_DEBUG=true
APP_URL=http://localhost:8000

#Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<Your database>
DB_USERNAME=<Your username>
DB_PASSWORD=<Your password>
```
Install all project dependencies with composer
```bash
  composer install
```
Once the dependencies are downloaded,  you can start use the **artisan** tool
Create the key of the project

```bash
  php artisan key:generate
```
Run the migrations and seeders
```bash
  php artisan migrate:fresh --seed
```

And finally run the application
```bash
  php artisan serve
```


> **Note:** By default the backend runs in the port 8000
> **To test the API, in the root of repository there is a Postman collection ready to be used**
> By default the API create a user, this are the credentials
> **user**: user@user.com
> **password**: useruser


### Frontend
*The fronted was developed with Vue and uses the components library Vuetify.*

Go to the **frontend** folder
```bash
  cd frontend/
```

Install project dependencies
```bash
  npm install
```
And run the project
```bash
  npm run start
```

> **By default the frontend runs in the port 8080**

## Demo
If you want to use the system without setup all the project you can click the next link: [Demo](https://readandenjoyit.herokuapp.com/).

> **The user to enter is the same to test the API**
