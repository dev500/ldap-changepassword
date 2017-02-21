#!/bin/bash

echo "<?php
return [
    'ldapServer' => '${LDAP_SERVER:-}',
    'prefixUserDn' => '${PREFIX_USER_DN:-}',
    'baseDn' => '${BASE_DN:-}',
];" > /usr/src/config/app.php

exec "$@"
