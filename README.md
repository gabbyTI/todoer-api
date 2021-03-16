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
        POST    |       tasks                |  Create a task                       | body,task_start_date,priority,is_completed,task_end_date
        POST    |       tasks/{task}         |  Update a Task                       | body,task_start_date,priority,is_completed,task_end_date
        POST    |       tasks/{task}/mark    |  mark a task as completed (when called again it unmarks the task as completed ) | null
        DELETE  |       tasks/{task}         |  Delete a task                       | null

