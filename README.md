# Campus Skill Exchange — Raw PHP (JSON)

Run the app with PHP's built-in server **from inside the `App` folder**:

```bash
cd App
php -S localhost:8000 router.php
```

Then open: **http://localhost:8000**

## Default admin login

- **URL:** http://localhost:8000/login?admin=1  
- **Username:** `admin`  
- **Password:** `password`

## Features

- **Users:** Sign up, log in, browse courses, enroll (simulated payment), view enrolled courses, open topics, mark topics complete, view progress in profile.
- **Admin:** Log in at `/login?admin=1`, manage courses (CRUD), set price in BDT, manage topics (CRUD) per course, view users, view enrolled users per course, view progress.

## Data

All data is stored in JSON files under `App/data/`:

- `users.json`, `admins.json`, `courses.json`, `topics.json`, `enrollments.json`, `progress.json`

No MySQL required; replace with MySQL later by swapping the `JsonDb` implementation for a DB layer.
