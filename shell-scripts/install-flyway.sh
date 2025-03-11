#!/bin/bash

if [ -f database/flyway/flyway ]
then
    # Es necesario wget para descargar Flyway
    # Si no lo encuentra, lo instala
    wget_existe=`which wget 1>/dev/null`
    if [ $? != 0 ]
    then
        echo "[i] Instalación de wget"
        apt update -y && apt install -y wget        
    fi

    export VERSION_FLYWAY=10.13.0
    export LINK_FLYWAY=https://repo1.maven.org/maven2/org/flywaydb/flyway-commandline/$VERSION_FLYWAY/flyway-commandline-$VERSION_FLYWAY-linux-x64.tar.gz
    
    wget -qO- $LINK_FLYWAY | tar xvz
    
    if [ ! -d $(pwd)/database/flyway ]
    then
        mkdir -p $(pwd)/database/flyway
    fi

    cp -R `pwd`/flyway-$VERSION_FLYWAY/* $(pwd)/database/flyway

    if [ ! -f /usr/local/bin/flyway ]
    then
        ln -s $(pwd)/database/flyway/flyway /usr/local/bin
    fi

    rm -rf `pwd`/flyway-$VERSION_FLYWAY

    echo "Flyway $VERSION_FLYWAY ha sido instalado en el sistema"
else
    echo "Flyway ya está instalado en el sistema"
fi