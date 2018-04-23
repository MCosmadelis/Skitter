FROM nginx:latest

RUN apt-get update && apt-get -y install openssl
COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ca/ca.key /etc/ssl/private/ca.key
COPY ca/ca.crt /etc/ssl/certs/ca.crt

