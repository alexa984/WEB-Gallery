# Authors:

Alexandra Yovkova FN. 62229
Elena Tuparova FN. 62196

# WEB-Gallery

This is the final version of our Image gallery project for the FMI WEB course.
The main idea is to have a web page with user registration and login. Each user is able to save his images in the page.
There are options for uploading image, splitting images to albums(also automatically on some criteria), merging albums and deleting images/albums.

# Project content

Project folder contains code and documentation(in ProjectDocumentation.docx).
The project is in client-server style. Client folder holds client-side files like html, js and css. Server folder holds server-side logic and images folder with already uploaded images.

# Prerequisites

- Installed XAMPP
- Pull this repo

# Restore DB from the web_gallery.sql script

1. Get to root dir of mysql in your command prompt
2. Login to mysql (ex. mysql -u root -p)
3. source {path_to_web_gallery.sql}

# Run project

Open {your_project_root_folder}/client/index.php in XAMPP with running Apache and MySQL

# Speifications on uploading image

1. Hash the image content
2. Check whether the hash is present on the server. For the check -> we have an image_map.json file storing the info in {image_hash: path_to_image} format

3.1. If image content is not present, upload the file to the server and take the path from the newly uploaded.
Parse the meta data so that we can give the information to the Image model
Create an Image and ImageInstance with the expected data

3.2. If image content is present, take the image path from the JSON by the hash key
Get the Image which has this path. Create new ImageInstance with FK to this Image.
Increase number_instances of the Image

# Test User credentials:

username: test_user
password: password123
