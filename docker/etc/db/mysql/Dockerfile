FROM mariadb:10.5

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y nano

ADD etc/db/mysql/init/create.sql /docker-entrypoint-initdb.d
#ADD etc/db/mysql/init/mifactura_FS_xnet-20230403-115825.sql.gz /docker-entrypoint-initdb.d
