
# Alxarafe installation file



## JSON file template
This is the example to generate a JSON file to install Alxarafe in your system. Below you can read extra information about each field.

```json
{
  "language": "en_US",
  "check-prerequisites": "true",
  "upgrade": "false",
  "version": {
    "from": "3.0.*",
    "to": "latest"
  },
  "base-directory": "/var/www/dolibarr/htdocs",
  "document-directory": "/var/www/dolibarr/documents",
  "base-url": "http://localhost:8080",
  "database": {
    "db-name": "dolibarr",
    "driver": "mysql",
    "host": "localhost",
    "port": "3306",
    "table-prefix": "llx_",
    "create-database": "false",
    "username": "dbuser",
    "password": "dbuser",
    "create-user-account": "false"
  }
}
```
In general all directories must be writing without final slash or backslash (depends on the operative system).
- **language**: The language in which you will see all messages for the installation. It can be omitted in the CLI case. The language must be in __language-country__ form, like "en_US".
- **check-prerequisites**: True if you want the installation process to check the system to meet all PHP requisites to install Alxarafe, false otherwise 
- **upgrade**: This parameter sets if it is a fresh installation or an update, in this last case, you must specify which is the current version and which one is the target version
- **version**: 
  - **from**: The version must be in format "3.0.*", and you can use wildcards to replace a range of versions like the example, which covers all version 3.0. and all subversion.  You can use a special case `latest` to indicate that you want to upgrade to the latest version.
  - **to**: Same as the **from** case.
- **document-directory**: This option you must set a directory where the generated documents will go. We suggest that it should be outside of the web pages (so do not use a subdirectory of previous parameter).
- **database**  
  - **db-name**: The name of the database where Alxarafe will install the tables. It must be a valid database name.
  - **driver**: Alxarafe's driver to connect to the database could be `mysql` or `postgres`.
  - **host**: The address of the server hosting the database is required for establishing a connection. This can be specified in the following format:
    - **IP Address**: A numerical label assigned to each device connected to a computer network that uses the Internet Protocol for communication.
    - **Hostname**: A label that is assigned to a device connected to a computer network, and that is used to identify the device in various forms of electronic communication.
    - __Dockerized Solution__  
      If you are using a Dockerized solution, you will need to specify the container name instead of the IP address or hostname. This is because Docker containers have their own network stack and IP address, which may not be accessible from outside the container.
      To specify the container name, you can use the following format:
      Container Name: The name assigned to a Docker container during creation or runtime. This name can be used to refer to the container in various Docker commands and configurations.
  - **port**: The por which is assigned to the database server connection.
  - **table_prefix**: The tables could be prefixed with a set of characters, it can be ommited to leave the table as is.
  - **create-database**: Indicate if we need to create (true) or not the database to hold the tables.
  - **username**: The username defined to connect to the database
  - **password**: The password to authenticat against the database
  - **create-user-account**: if it is true, we need to create the user account, false if we already have one