###Up & Running With Symfony

Nothing much here, 
this is just a simple CRUD app with Symfony 5 PHP Framework and 
Bootstrap 5 for the User Interface.

####Create database
First Copy .env.example to .env and update db credentials.

Create the database

``php bin/console doctrine:database:create``

Make migrations

``php bin/console make:migration``

Migrate and create tables

``php bin/console make:migration:diff``

Credits Brad Traversy (https://www.youtube.com/watch?v=t5ZedKnWX9E)