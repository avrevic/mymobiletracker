#!/bin/sh
docker stop swagger-instance
docker rm swagger-instance
docker build -t swagger .
docker run --name swagger-instance -d -p 81:8080 swagger
