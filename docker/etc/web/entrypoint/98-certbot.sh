#!/bin/sh

openssl req -x509 -out /etc/letsencrypt/live/localhost/fullchain.pem -keyout /etc/letsencrypt/live/localhost/privkey.pem \                                                                                                   ✔
  -newkey rsa:2048 -nodes -sha256 \
  -subj '/CN=localhost' -extensions EXT -config <( \
   printf "[dn]\nCN=localhost\n[req]\ndistinguished_name = dn\n[EXT]\nsubjectAltName=DNS:localhost\nkeyUsage=digitalSignature\nextendedKeyUsage=serverAuth")
