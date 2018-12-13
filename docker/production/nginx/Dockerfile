FROM nginx:alpine

ADD docker/production/nginx/nginx.conf /etc/nginx/
ADD docker/production/nginx/default.conf /etc/nginx/conf.d/

ADD public /usr/share/nginx/html

WORKDIR /usr/share/nginx/html