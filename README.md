# Track Courier
[Track Courier API - Postman Collection](https://www.postman.com/solar-rocket-959805/track-courier)

This project is a Laravel-based application with Vue 3 for the frontend. The backend is powered by Laravel and the frontend uses Vue 3 for a dynamic user interface. The application is containerized using Docker and includes various services like MySQL, Redis, PHPMyAdmin, and more.

## Services Overview

The application utilizes Docker to manage the following services:

- **PHPMyAdmin**: Web interface for MySQL database management.
- **Server**: The backend Laravel server.
- **MySQL**: MySQL database for the application.
- **Cron**: A cron job service to run scheduled tasks.
- **Redis**: In-memory data store used for caching and queues.
- **Vite**: Development server for Vue 3 with hot-reloading.
- **Worker**: Worker container to handle background jobs.

## Project Setup

### 1. Prerequisites

Make sure you have the following installed:

- Docker
- Docker Compose

### 2. Clone the Repository

Clone this repository to your local machine:

```bash
git clone https://github.com/oleksandr-antonian/track-courier.git
cd track-courier
```

### 3. Environment Configuration

Create a copy of the `.env.example` file and name it `.env`:
```bash
cp .env.example .env
```

### 4. Build the Docker Containers

Build the Docker containers using Docker Compose:

```bash
docker-compose up -d --build
```

### 5. Access the Application

You can now access the application in your browser at [http://localhost](http://localhost).
