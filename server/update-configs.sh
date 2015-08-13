#!/usr/bin/env bash

# nginx
cp nginx/nginx.conf /etc/nginx/nginx.conf
cp nginx/fastcgi.conf /etc/nginx/fastcgi.conf
cp nginx/conf.d/yiiframework.conf /etc/nginx/conf.d/yiiframework.conf
service nginx reload

