# docker/nginx/Dockerfile

FROM nginx:alpine
WORKDIR /var/www
COPY ./sites/default.conf /etc/nginx/sites-available/
CMD ["nginx"]
EXPOSE 80