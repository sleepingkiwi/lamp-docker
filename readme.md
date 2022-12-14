# a basic docker-compose.yml file for local LAMP installs without WordPress

For WordPress dev take a look at [this repo instead](https://github.com/sleepingkiwi/wordpress-docker)

## what

a starting point for local PHP/MySQL installs.

Requires our [nginx-proxy](https://github.com/sleepingkiwi/nginx-proxy-docker) container to be running for the ssl functionality etc.

## usage

- put it in to a directory
- run `docker-compose up` or `docker-compose up -d` (`docker-compose stop` to stop that one)
- run `docker-compose down` to clean up everything that hasn't been saved to a volume specified in `docker-compose.yml`

See below for specifics

## Talking to the database

This example is in the index.php file.

You just have to update the db host

``` php
// The MySQL service name from docker-compose.yml.
$host = 'db_example_site';

$user = 'local';
$pass = 'local';

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo("Connected to MySQL server successfully!");
}
```

## Rename volumes and services

Because we now run these images on a shared network we would run in to issues with the same db service being shared by multiple containers.

To resolve this we give each service it's own name keyed to the current project

Find and replace `example_site` with `your_site_name`

## local domain name and ssl certs for dev

### set up a local domain for development

``` bash
# on local machine (not the Docker Image)
sudo nano /etc/hosts
# add line like:
# 127.0.0.1 example-site.local
# 127.0.0.1 db.example-site.local
```

Now you also need to add your local URL under VIRTUAL_HOST: for the php and database images. Replace `example-site.local` in both places with the name you just added to /etc/hosts

Now if you run docker-compose up (and the proxy is running) you should be able to access your image (when it's running) on `http://example-site.local` and phpmyadmin for the database at `http://db.example-site.local`

### Set up an ssl cert for that local domain

> If this is the first time setting up a cert:

#### Set up a local Cerificate Authority (CA)

_You only need to do this step once_ - if you already have one then you don't need another for each site.

- install `mkcert`
  - on macos that's `brew install mkcert` and `brew install nss`
- run `mkcert -install`

> If yoy already have a local CA set up:

#### Make self signed SSL certs for your local domain and give them to local proxy

These need to go into the `./certs` directory at the root of your local [nginx-proxy](https://github.com/sleepingkiwi/nginx-proxy-docker) (should be `~/dev/nginx-proxy/certs`)

``` bash
# cd into the /certs dir at the root of the nginx-proxy dir (should be ~/dev/nginx-proxy/certs)
mkcert -cert-file example-site.local.crt -key-file example-site.local.key example-site.local
mkcert -cert-file db.example-site.local.crt -key-file db.example-site.local.key db.example-site.local
```
