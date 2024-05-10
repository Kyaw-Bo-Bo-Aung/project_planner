
# Backend API for Project Planner App

This is the backapi project that includes endpoints for users and their related projects.

## Installation

### Running with Docker
1. Clone the repository:

```bash
git clone https://github.com/Kyaw-Bo-Bo-Aung/project_planner
```

2. Navigate to the project directory:
```bash
cd project_planner
```  

3. Install dependencies:
```bash
composer install
```

4. Set up your environment variables by renaming .env.example to .env and filling in the necessary configurations:

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations::
```bash
php artisan migrate
```

7. (Optional) Seed the database:
```bash
php artisan db:seed
```


## Usage

### Require Header

| Key | value   |
| ------- | --- |
| Accept  | application/json |
| Content-Type  | application/json |
|Authorization |  Bearer Token |

#### Endpoints


| Methods | Endpoints  |   |
| ------- | --- | --- |
| POST  | /api/register | Registers a new user.|
| POST  | /api/login | Authenticates a user and returns a JWT token |
| GET | /api/users | Retrieves all users.|
|GET | /api/users/{id} | Retrieves a specific user by ID. |
|POST | /api/users|  Creates a new user. |
|POST | /api/users/{id}/update | Updates an existing user. |
|POST | /api/users/{id}/delete|  Deletes a user by ID. |
|GET | /api/projects |Retrieves all projects. |
|GET | /api/projects/{id} |Retrieves a specific project by ID. |
|POST | /api/projects| Creates a new project. |
|POST | /api/projects/{id}/update |Updates an existing project. |
|POST | /api/projects/{id}/delete| Deletes a project by ID. |
|GET | /api/timesheets | Retrieves all timesheets. |
|GET | /api/timesheets/{id}| Retrieves a specific timesheet by ID. |
|POST | /api/timesheets| Creates a new timesheet. |
|POST | /api/timesheets/{id}/update| Updates an existing timesheet. |
|POST | /api/timesheets/{id}/delete| Deletes a timesheet by ID. |


## Authentication

Login and get the authentication token.

## Examples

### User

- For register and create request body:
```
{
    "first_name": "Custom",
    "last_name": "User",
    "password": "password",
    "date_of_birth": "2003-12-11",
    "gender": "male",
    "email": "custom@gmail.com"
}
```
- For update - ignore password field.

### Project

- For create and update request body (timesheets field is optional):
```
{
    "name": "The Line",
    "department": "miami",
    "start_date": "2024-04-27",
    "end_date": "2024-05-22",
    "status": 1,
    "timesheets": [
        {
        "task_name": "Design layout",
        "date": "2024-11-25",
        "hours": 8,
        "user_id": 1
        },
        {
        "task_name": "BIM modelt",
        "date": "2024-12-05",
        "hours": 8,
        "user_id": 1
        }
    ]
}
```

### Timesheet
- For create and request body 
```
{
    "task_name": "Recruiting Meeting",
    "date": "2024-05-10",
    "hours": 8,
    "user_id": 1,
    "project_id": 2
}
```
