FROM alpine:latest
RUN apk add --no-cache lighttpd php7-common php7-cgi php7-json
COPY . /srv/http
CMD ["lighttpd-angel", "-D", "-f", "/srv/http/server.conf"]
