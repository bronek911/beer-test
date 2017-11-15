# Distilled SCH Beer Application

A Symfony project created on November 9, 2017, 10:33 am.

## Instalation

To install you have to download/pull repository and then install vendor libraries by running "composer install" in repository directory.

## Running symfony server

Type "php bin/console server:run" in root directory. Server is listening on http://127.0.0.1:8000.

## Parameter

To set your own API-key, change 'homepage.api_key' parameter in app/config/config.yml.

## Comments

* The view layer is raw. I didn't have time to write it properly. I would use SASS for the styles.

* The searching form is written by myself in html. I prepared a class with buildForm() method, but I didn't have time to configure the view parameters for it (e.g. displaing the form in one line).

* I added another button in random beer section 'About brewery'. It will show you name of brewery (which is a link to their website), description and list of all their beers in different form than in search results.

* After clicking on a search result, you'll be redirected to the page with details of beer or brewery, depending on search values.