# Dynamic Forms

## Problem statement
You need to create a module in which the following points must be covered.
* System will have two types of users
    * Admin
    * Normal User
* Admin should be able to create form definitions where admin will specify fields and
validation rules.
* User should be able to fill the forms with all specified validation rules
    * Min
    * Max
    * Required
    * Email
* Users can fill out forms only once.
* Admin should be able to access state of form
    * How many times it was submitted
    * How many times it was opened.
    * Which user submitted what answers
    
# Approach
## User Flows
Prerequisite: 1 Admin user is created by default
1. Admin Creates a Form
Steps:
    1. Admin Logs In 
    2. User is shown Form lists.
    3. Clicks on "New Form"
    4. Enter form fields and clicks "Preview".
    5. After Previewing (2 paths)
        1. Clicks on "Publish" => ~~Form created and form url shown~~ (OR Redirect to Form Stats)
        2. Clicks "Edit" => Goes back to Form Edit page
    6. Return backs to Form List Page
    
2. Admin Views Form Stats
Steps:
    1. Admin Logs In
    2. Shown Form Lists
    3. Selects 1 form and clicks the List item
    4. Views stats
        1. Opened vs Sumbmit 
        2. Responses
        
3. User fills Form
Steps:
    1. Visits the Form Link
    2. If Not Logged In
        1. redirected to Login Screen
        2. if has account
            1. Enters Credential
        3. Else Signs Up
        4. Redirected to Form Link
    3. Else if already logged in
        1. if Form Submitted shows message
        2. else Shows Form
        3. User Submits the Form

## Out of Scope:
- Stats per field based on responses
- Multi Page Form - Wizard Like (Admin should be able to configure it. The URL can be different and different DB tables)
- Limit of Fields;
- *Re-Edit form after Publish Option
- Form can be in state of draft, published, inactive/unpublished
- Delete the Form (draft, published / unpublished)
- *Session lifetime and re-login prompt

    *\* : Can be considered in Scope*

## Implementation Approach:
1. Pages Required:
    1. Log In
    2. Sign Up
    3. Admin Pages
        1. Form List
        2. Create Form
        3. Preview Form
        4. Form Stats (Form Link, Opened vs Closed, List of Responses with Pagination)
    4. Form View
2. Implementation
    1. Session managed by cookie and redis store
    2. Mysql for storing data
    3. Use session:
        - hold redirect url for destination form URL
        - hold form field data + validation data, until form creation complete.
        
 ## DB Consideration:
 Table: 
 1. User
    - id
    - (check Laravel default params)
    ... 
 2. Form:
   - id,
   - name/title
   - content (holds json value)
   - Opened
   - Submitted
   - Update time
   - Created at
   - Status: 0: Draft; 1: published; 2: Unpublished (Future Scope)
   - isDeleted (Future Scope)
   
Consideration for Stats data in Form Table: 
- Opened & Submitted can be stored as json under single column to give more flexibility and later on.
- Stats data can also be maintained in file base storage in json format. This can be used while caching the data for faster performance. If more stats need to maintained ideally a Queueing the request and batch processing can also be considered.
- User: Can separate Admin and User table; 

### Sample Form Data structure to be stored as JSON
```php
$data = [
    "name" => "string|not null",
    "count" => "int|>1",
    "version" => "string", // in case this format keeps updating with new values
    "fields" => [
        0 => [
            "label" => "",
            "input_type" => "text|number|email", //Out of Scope: radio|checkbox|submit|select|textarea||range|range, date, datetime-local, month, time and week", 
            "required" => "boolean",
            "min" => "int",
            "max" => "int",
            //"disabled" => "boolean", //Out of Scope
            //"placeholder" => "string", // Out of scope
        ],
        1 => [
                
        ],
    ]
];
```

#Deployment
Clone this Repo
Change the directory
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
sail up -d
sail php artisan migrate

php artisan breeze:install

npm install
npm run dev
php artisan migrate:fresh --seed
