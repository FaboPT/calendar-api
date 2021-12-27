I created 5 tables

- users
- roles
- model_has_roles
- availabilities
- events
- events_users

The code are structured in 3 parts

- Abstract class BaseRepository where are all repositories inherent this class
- Abstract class BaseService where are all services inherent this class
- The controller calls the services and the services call the repository and repository make changes in DB
- I create a middlewares to check is possible create a event or create a availability
