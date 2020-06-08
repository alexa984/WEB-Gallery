# WEB-Gallery
Image gallery project for the FMI WEB course.
The main idea is to have a web page with user registration and login. Each user is able to save his images in the page.
There are options for uploading image, splitting images to albums(also automatically on some criteria), merging albums and deleting images/albums.

# Restore DB from the web_gallery.sql script
1. Get to bin dir of mysql in your command prompt
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

# Speifications on deleting image(for specific user = ImageInstance)
1. Get the selected ImageInstance
2. Get the Image for this ImageInstance
3.1. If Image has `number_instances == 1`:
      1) Remove the record for this image from the JSON file
      2) Delete the Image. ImageInstance and all AlbumImages will be deleted by the CASCADE. 
      3) Delete the image itself from the server `/images` folder
3.2. If Image `has num_instances > 1`:
      1) Delete selected ImageInstance
      2) Decrease num_instances with 1

# Speifications on removing image from specific Album
We want the image to live in `All Images` even after removing from the Album.
That's why the only thing we delete when removing from an album is the AlbumImage.
TODO: Think about whether we should delete the whole album if there are no images in it or leave it empty
