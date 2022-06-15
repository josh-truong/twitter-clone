# twitter-clone


#### Build
```
sudo docker-compose build
```

#### Run
```
docker-compose up -d
```
or
```
docker-compose up
```

#### Shut Down
```
docker-compose down -v --remove-orphans
```

#### Access Database Container
```
docker exec -it mysql bash -l
mysql -u root -ppasswd
```

#### Access Php-Apache Container
```
docker exec -it php-apache bash -l
```

#### Issues
- move_uploaded_files()
```
sudo chmod 777 /src/uploads
```

![twitter](https://github.com/josh-truong/twitter-clone/blob/main/demo.png)
