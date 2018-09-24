Woke-server
==========

A Symfony project created on September 26, 2017, 5:24 pm.

run `composer install` to install dependencies 

## Database
`php bin/console doctrine:schema:update --force`

## OAuth 2

Authentication is done via the OAuth2 protocol. 

run 
`php bin/console acme:oauth-server:client:create --redirect-uri="http://localhost:4200/" --grant-type="authorization_code" --grant-type="password" --grant-type="refresh_token" --grant-type="token" --grant-type="client_credentials"`
to generate token public id and secret 
