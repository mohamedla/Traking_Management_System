<h1 align='center'>Tracking</h1>

# Tracking Management System
Track employees activitty and projects progressing

# Features
- Admin Registeration
- Entering Employees, Departments, And Projects
- User Login
- Keep Track Employees Activity
- Add New Projects To Each Department And Keep Track Of Its Progress
- Assign New Tasks To Employee For Each Project And Keep Track Of Its Progress


# Preparation Steps:
##Windows users:

 Download wamp: http://www.wampserver.com/en/
 Download and extract cmder mini: https://github.com/cmderdev/cmder/releases/download/v1.1.4.1/cmder_mini.zip
 Update windows environment variable path to point to your php install folder (inside wamp installation dir) (here is how you can do this http://stackoverflow.com/questions/17727436/how-to-properly-set-php-environment-variable-to-run-commands-in-git-bash)
 cmder will be refered as console

##Mac Os, Ubuntu and windows users continue here:

 Create a database locally named homestead utf8_general_ci
 Download composer https://getcomposer.org/download/
 Pull Laravel/php project from git provider.
 Rename .env.example file to .envinside your project root and fill the database information. (windows wont let you do it, so you have to open your console cd your project root directory and run mv .env.example .env )
 Open the console and cd your project root directory
 Run composer install or php composer.phar install
 Run php artisan key:generate
 Run php artisan migrate
 Run php artisan db:seed to run seeders, if any.
 Run php artisan serve
#####You can now access your project at localhost:8000 :)

Signup :
 - First go to Web.php file and comment the 2 url (login,Register)
 - Then go to localhost:8000/register and register your admin account.
 - The Uncomment the firest step
 - Go To localhost:8000 and login using the admin account the add employee as you please

