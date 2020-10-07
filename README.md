# PHP-8-Programming-Tips-Tricks-and-Best-Practices
PHP 8 Programming Tips, Tricks and Best Practices, published by Packt
The source code for this chapter is located here:
[https://github.com/PacktPublishing/PHP-8-Programming-Tips-Tricks-and-Best-Practices](https://github.com/PacktPublishing/PHP-8-Programming-Tips-Tricks-and-Best-Practices).

## To set up a test environment to run the code examples, proceed as follows:
1. Install Docker
	* If you are running Windows, start here: [https://docs.docker.com/docker-for-windows/install/](https://docs.docker.com/docker-for-windows/install/).
	* If you are on a Mac, start here: [https://docs.docker.com/docker-for-mac/install/](https://docs.docker.com/docker-for-mac/install/).
	* If you are on Linux, have a look here: [https://docs.docker.com/engine/install/](https://docs.docker.com/engine/install/).
2. Install Docker Compose.  For all operating systems, start here: [https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/).
3. Install the source code associated with this book onto your local computer.
	* If you have installed git, use the following command:
```
git clone https://github.com/PacktPublishing/PHP-8-Programming-Tips-Tricks-and-Best-Practices.git /path/to/repo
```
	* Otherwise, you can simply download and unzip from this URL: [https://github.com/PacktPublishing/PHP-8-Programming-Tips-Tricks-and-Best-Practices/archive/main.zip](https://github.com/PacktPublishing/PHP-8-Programming-Tips-Tricks-and-Best-Practices/archive/main.zip)
	* And then unzip into a folder you create which we refer to as `/path/to/repo` in this book.
4. Build docker container associated with this book online:
	* From your local computer, open a command prompt (terminal window).
	* Change directory to `/path/to/repo`.
	* First time only, issue this command to build  the environment:
```
docker-compose build
```
    * Please note that the initial build might take several minutes to complete!
5. Once the container has been built, issue this command the bring the container up:
	* From your local computer, open a command prompt (terminal window).
	* Change directory to `/path/to/repo`.
	* Bring the docker container online in background mode:
```
docker-compose up -d.
```
6. To access the running docker container web server:
	* Open the browser on your local computer
	* Enter this URL: `http://localhost:8888`
7. To open a command shell into the running docker container:
	* From your local computer, open a command prompt (terminal window).
	* Issue this command:
```
docker exec -it php8_tips /bin/bash
```
8. When you are finished working with the container, bring it offline using the following commands:
	* From your local computer, open a command prompt (terminal window).
	* Issue this command:
```
docker-compose down
```
