docker stop swagger-instance
docker rm swagger-instance
docker run -d --name swagger-instance  -p 81:8080 -e SWAGGER_JSON=/var/www/html/swagger.yaml -v /bar:/foo swaggerapi/swagger-ui