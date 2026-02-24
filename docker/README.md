# Basic Docker Information

This folder contains the Docker configuration for the Alxarafe project.

## Container Management

In the `bin/` folder, there are scripts for removing, creating, and starting the necessary containers.

Once the containers are created, it may be necessary to run Composer to install dependencies.

### Accessing the Container

Running the following command allows you to access the container where the code is located:

```bash
docker exec -it alxarafe_php bash
```

From within the container, you can run:

```bash
composer install
npm install && gulp build
```

## MySQL Execution

### To run MySQL with the user 'dbuser' (password 'dbuser')

```bash
mysql -h alxarafe_db -P 3306 -u dbuser -p
```

### Managing the Database

You can remove the existing database and recreate it:

```sql
drop database alxarafe;
create database alxarafe;
use alxarafe;
```

The database to be imported should be copied to the `tmp/` folder to make it available inside the container. If the file is named `alxarafe_db.sql`:

```sql
source tmp/alxarafe_db.sql;
```

---
*Spanish version available in [README_es.md](./README_es.md)*
