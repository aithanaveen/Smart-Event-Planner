🧾 README.md — Event Management Website
📌 Project Overview

This is a Dynamic Event Management Website built with
HTML, CSS, JavaScript (frontend) and PHP + MySQL (backend),
deployed on InfinityFree free hosting.

Users can:

Register and log in securely

Add and view events

Add items to cart and proceed to simulated payments

Have all user, event, and payment data stored in the MySQL database

Log in from multiple devices using the same credentials

🏗️ Technologies Used
Layer	Technology
Frontend	HTML5, CSS3, JavaScript
Backend	PHP (Procedural, JSON API endpoints)
Database	MySQL
Hosting	InfinityFree (Free PHP hosting)
⚙️ Setup Instructions
1️⃣ Host Setup (InfinityFree)

Go to https://infinityfree.net
 and create a free account.

Add a new website and note the subdomain (example: yourapp.infinityfreeapp.com).

Open the Control Panel → MySQL Databases.
2️⃣ Database Schema

Open phpMyAdmin from the control panel and run this SQL:
Create a new database and note the credentials, or use these (already configured):


3️⃣ Files to Upload

Upload the following files into your InfinityFree htdocs/ directory:

File	Purpose
backup.html	Main website frontend
config.php	Database connection file
register.php	User registration endpoint
login.php	User login endpoint
logout.php	Logout endpoint
add_event.php	Adds event details to DB
get_events.php	Fetches user events
add_payment.php	Records payment info
get_payments.php	(optional) Lists all payments
README.md	Documentation file

🧩 Tip: You can upload files via InfinityFree File Manager or FTP (FileZilla).

4️⃣ Configuration

Edit config.php with your database credentials if they differ:

$db_host = 'sql210.infinityfree.com';
$db_user = 'if0_40199430';
$db_pass = 'chennai93910';
$db_name = 'if0_40199430_eventdb';

🚀 How It Works

User Registration:

Data sent via AJAX (register.php)

Stored in users table (password hashed)

User Login:

Uses password_verify()

Stores session so the user stays logged in

Works across multiple devices if credentials are correct

Event Management:

After login, users can add events (add_event.php)

Data stored in events table linked to user ID

Cart & Payment:

Items added to cart via frontend JS

Payment simulated and recorded in payments table

Data Persistence:

localStorage keeps cart data until checkout

All user-related data saved in MySQL

🧑‍💻 API Endpoints Summary
Endpoint	Method	Description
register.php	POST	Create new user
login.php	POST	Log in existing user
logout.php	GET	Destroy current session
add_event.php	POST	Add a new event
get_events.php	GET	Fetch logged-in user’s events
add_payment.php	POST	Record payment info
get_payments.php	GET	Fetch user payments (optional)

All endpoints return JSON responses.

🔒 Security Notes

Uses password_hash() and password_verify() — passwords are never stored in plaintext.

Basic session-based authentication implemented.

HTTPS recommended (InfinityFree provides SSL by default).

Multi-device login allowed (no session restrictions).

Input sanitized to prevent SQL injection via prepared statements.

💡 Optional Enhancements

Add profile management (update_user.php).

Add event deletion & editing endpoints.

Integrate a real payment gateway (e.g., Razorpay, Stripe).

Use JWT tokens or OAuth for advanced authentication.

📸 Screenshots (if applicable)

(Add screenshots of your UI here when uploading to GitHub or project submission.)

👨‍💻 Authors
Aitha Venkata Naveen
Gunda Giridhar
Sai Kiran Reddy
Sasi Mohith Raj

📅 October 2025
📍 InfinityFree Deployment
