# BloodLink
Blood donor website built with PHP, MySQL and Apache on Ubuntu (Linux).

## Features
Signup, login, logout (sessions), dashboard, donor registration, donor search by blood group and city, blood requests.

## Setup
1. `sudo apt install apache2 php libapache2-mod-php php-mysql mysql-server`
2. Copy this folder to `/var/www/html/bloodlink`
3. `sudo mysql < database.sql`
4. `sudo service apache2 start && sudo service mysql start`
5. Open http://localhost/bloodlink/

## Creating an admin
Sign up normally, then run:
`sudo mysql bloodlink -e "UPDATE users SET is_admin=1 WHERE email='your@email.com';"`
Log out and log in again to see the Admin link.

## Extras
Donors can switch their availability on or off, and unavailable donors are hidden from search. Requesters can mark a request as fulfilled. Phone numbers are tap-to-call links.
