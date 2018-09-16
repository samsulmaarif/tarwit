FROM mysql:5.6

MAINTAINER Samsul Ma'arif <samsul@blankon.id>

ADD ./visitor.sql /docker-entrypoint-initdb.d
ENV MYSQL_DATABASE=tarwit \
    MYSQL_ROOT_PASSWORD=strongpassword

EXPOSE 3306
