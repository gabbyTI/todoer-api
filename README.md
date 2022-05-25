This API exposes endpoints for a Todo Task recorder application. The features of this application are as follows: `User Authentication`, `Tasks`, `Sub-Tasks`, `Projects`, `Invitation`.

## Postman Documentaion

Read the postman documentation here: [API DOCUMENTATION](https://documenter.getpostman.com/view/9638778/Uz59NzKQ)

## Endpoints

    ROUTE | ENDPOINT | DESCRIPTION | REQUEST BODY
    GET | Me | Returns the user data of currently logged in user(returns null if no user is logged in)  |   null
    Authentication Endpoints
        POST    |    register        |   Register a user(email verification link will be sent to user on registeration)  |   name,email,password,password_confirmation
        POST    |    verification/verify/{user}  | Email verification link with parameter(token & expires)   |   email
        POST    |    verification/resend     | Resend Email verification link    |   email
        POST    |    login   | Login a user (every user is assigned a bearer token which is used to send requests) | email,password
        POST    |    password/email  |   Send password reset link to user (for Forgot Password feature)  |   email
        POST    |    password/reset  |   password reset link |   token, email, password, password_confirmation
        POST    |    logout  |   Logout  | null
        POST    |    account/delete  |   delete profile from database    |   null

    Task Endpoints

        GET     |       tasks                |  Get all users tasks                 | null
        GET     |       tasks/today          |  Get all users tasks for today       | null
        GET     |       tasks/completed      |  Get all users completed tasks       | null
        GET     |       tasks/{task}         |  Find task by id                       | body,task_start_date,priority,is_completed,task_end_date
        POST    |       tasks                |  Create a task                       | body,task_start_date,priority,is_completed,task_end_date
        PUT     |       tasks/{task}         |  Update a Task                       | body,task_start_date,priority,is_completed,task_end_date
        PUT     |       tasks/{task}/project/{project} | move task into project     | null
        POST    |       tasks/{task}/mark    |  mark a task as completed (when called again it unmarks the task as completed ) | null
        DELETE  |       tasks/{task}         |  Delete a task                       | null


    Sub Tasks Endpoints
        POST    |       sub-tasks                |  Create a sub-task                       | body,task_start_date,priority,is_completed,task_end_date
        GET     |       sub-tasks/{task}         |  Find a sub-Task by id                      | body,task_start_date,priority,is_completed,task_end_date
        PUT     |       sub-tasks/{task}         |  Update a sub-Task                       | body,task_start_date,priority,is_completed,task_end_date
        POST    |       sub-tasks/{task}/mark    |  mark a sub-task as completed (when called again it unmarks the task as completed ) | null
        DELETE  |       sub-tasks/{task}         |  Delete a sub-task                       | null


    Project Endpoints
        POST    |       projects            |   create a project            | name
        GET     |       projects/user       |   fetch User Projects         | null
        GET     |       projects/{project}  |   find by id                  | null
        PUT     |       projects/{project}  |   update                      | name
        DELETE  |       projects/{project}  |   delete project              | name
        DELETE  |       projects/{project}/user/{user}  |   Remove user from a project  | null

    Invitation Endpoints
        POST    |       invitation/{project}    |   send invitation from a particular project to a users email (registered or unregistered)   | email
        POST    |       invitation/{invitation}/resend  |   resend a pending invitation |   null
        POST    |       invitation/{invitation}/respond |   respond to the invitation   |   token, decision('accept' or 'deny')
        DELETE  |       invitation/{invitation}     |   Delete pending invitation   | null
