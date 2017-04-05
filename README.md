# DB Setup #
sqlite db/app.db

sqlite>.read db/create.sql


# Run the application #
composer install
composer run --timeout=0 serve

The application will run on localhost:8080
