# News Aggregator Backend

## Data Sources
Below are the data sources that i have used
- NewsAPI.org
- The New York Times
- The Guardian

## Getting Started
To start the backend, follow the steps below:

### Prerequisites
- Docker
- Docker Composer

### Installation

1. Clone the repository to your local machine:
```bash
    git clone https://github.com/anand-bhagat/innoscripta_backend.git
```

2. Navigate to the project directory:
```bash
    cd innoscripta_backend
```

3. Open the docker-compose.yml file and ensure that the ports and environment variables are correctly set:
```bash
    version: "3.8"

    services:
        php: 
            build: 
                context: .
                target: php
            environment:
                - APP_ENV=${APP_ENV}
                - CONTAINER_ROLE=app
                - NEWS_API_KEY=<NEWS_API_KEY>
                - NEW_YORK_TIMES_KEY=<NEW_YORK_TIMES_KEY>
                - THE_GUARDIAN_KEY=<THE_GUARDIAN_KEY>
                - NEWS_API_URL="https://newsapi.org/"
                - NEW_YORK_TIMES_URL="https://api.nytimes.com/svc/"
                - THE_GUARDIAN_URL="https://content.guardianapis.com/"
            working_dir: /var/www
            volumes:
                - ./:/var/www
            ports:
                - 8000:8000
            depends_on:
                - database

        database:
            image: mysql:latest
            ports:
                - 3306:3306
            environment:
                - MYSQL_DATABASE=${DB_DATABASE}
                - MYSQL_PASSWORD=${DB_PASSWORD}
                - MYSQL_ROOT_PASSWORD=${DB_PASSWORD}
                - MYSQL_ALLOW_EMPTY_PASSWORD=true
            volumes:
                - db-data:/var/lib/mysql
    volumes:
        db-data: ~

```

4. Save the changes to the docker-compose.yml file.

### Starting the Application
To start the Laravel backend with Docker, run the following command in the project directory:

```bash
    docker-compose up --build
```

This command will build the Docker image for the Laravel application and start the containers. The backend will be accessible at http://localhost:8000.

Run below command to migrate the tables. Run only if the migrations were failed in the above command.

```bash
    docker-compose exec php php artisan migrate
```