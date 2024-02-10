if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then
    userdel -f www-data
    if [getent group www-data]; then
        groupdel www-data;
    fi
    groupadd -g ${GROUP_ID} www-data
    useradd -l -u ${USER_ID} -g www-data www-data
    install -d -m 0755 -o www-data -g www-data /home/www-data
    chown --changes --no-dereference --recursive --from=33:33 ${USER_ID}:${GROUP_ID} /var/www/ /home/www-data

    ## Directories what could not exist.
    if [ -d /.composer ]; then
        chown --changes --no-dereference --recursive --from=33:33 ${USER_ID}:${GROUP_ID} /.composer
    fi

    if [ -d /var/run/php-fpm ]; then
        chown --changes --no-dereference --recursive --from=33:33 ${USER_ID}:${GROUP_ID} /var/run/php-fpm
    fi

    if [ -d /var/lib/php/sessions ]; then
        chown --changes --no-dereference --recursive --from=33:33 ${USER_ID}:${GROUP_ID} /var/lib/php/sessions
    fi
fi
