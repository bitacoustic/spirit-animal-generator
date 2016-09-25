# spirit-animal-generator
Find your spirit animal with this small, stylish one-page "oracle".

## Running the project
1. On the server from which you wish to run the application (or localhost), create a new MySQL database and important ```sql/db.sql```.
2. Populate ```public_html/index.php``` with the database name and an authorized user name and password.
3. Place the contents of the ```public_html``` directory in an appropriate location on your server.

## Test platform
- Server: PHP 5.6.25, MySQL 5.6.33
- Browsers on Windows 10: Chrome 53.0.x, Firefox 49.0.1, Edge 38.14393.0.0
- Browsers on Android 6.0.1: Chrome 53.0.x, Firefox 49.0

## Known issues
- Some elements (buttons, particularly) don't render correctly on Chrome for Android. Fortunately, this is a purely cosmetic issue.
