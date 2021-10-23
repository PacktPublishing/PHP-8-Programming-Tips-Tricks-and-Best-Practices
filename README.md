# PHP-8-Programming-Tips-Tricks-and-Best-Practices
Help support a starving developer: please buy the book!!!
[PHP 8 Programming Tips, Tricks and Best Practices, published by Packt](https://www.amazon.com/Programming-Tips-Tricks-Best-Practices-ebook/dp/B0964DS7KN/ref=sr_1_1?dchild=1&keywords=9781801071871&qid=1622527379&sr=8-1)

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

## Windows Instructions
Please note that many of the command-line options mentioned here can also be accomplished from _Docker Desktop for Windows_
### Install the Docker containers associated with the book
You must first build the two docker containers associated with this book online, one that runs PHP 7.1, the other runs PHP 8.x.
Please note that the initial build might take up to 15 minutes to complete!
1. From your local computer, open a command prompt.
2. Change directory to `/path/to/repo`.
```
cd C:\path\to\repo
```
3. First time only, issue this command to build  the environment:
```
init build
```
### Bring the containers online
Once the container has been built, proceed as follows to bring the containers online:
1. From your local computer, open a command prompt.
2. Change directory to `/path/to/repo`.
```
cd C:\path\to\repo
```
3. Bring the docker container online in background mode:
```
init up
```
### Container access
#### Browser access
To access the docker containers from your browser, first make sure the containers are online (see previous).
1. Open the browser on your local computer.
2. Enter this URL to access the PHP 7 container: `http://localhost:7777`
    * Alternate URL: `http://172.16.0.77/`
3. Enter this URL to access the PHP 8 container: `http://localhost:8888`
    * Alternate URL: `http://172.16.0.88/`
#### Command line access
To access the containers from a command shell proceed as follows:
1. From your local computer, open a command prompt.
2. Change to `/path/to/repo` (use the appropriate drive letter if not drive C):
```
cd C:\path\to\repo
```
3. Execute the command to open a command shell:
* To open a shell into the PHP 7 container:
```
init shell 7
```
* To open a shell into the PHP 8 container:
```
init shell 8
```
### Bring container offline
It's a good idea to bring the container down (offline) when you're finished working with it.
This conserves resources.  Proceed as follows:
1. From your local computer, open a command prompt (terminal window).
2. Change to `/path/to/repo` (use the appropriate drive letter if not drive C):
```
cd C:\path\to\repo
```
3. Use `init.bat` to bring the containers offline:
```
init down
```
Please note that after the containers have been shut down, the ownership of all files in `/path/to/repo` are reset to the current user using the Windows `takeown` command.

## Linux and Mac Instructions
Please note that many of the command-line options mentioned here can also be accomplished from _Docker Desktop for Mac_ (Mac only!).
### Install the Docker containers associated with the book
You must first build the two docker containers associated with this book online, one that runs PHP 7.1, the other runs PHP 8.x.
Please note that the initial build might take up to 10 minutes to complete!
1. From your local computer, open a terminal window.
2. Change directory to `/path/to/repo`.
```
cd /path/to/repo
```
3. First time only, issue this command to build  the environment:
```
./init.sh build
```
### Bring the containers online
Once the container has been built, proceed as follows to bring the containers online:
1. From your local computer, open a terminal window.
2. Change directory to `/path/to/repo`.
```
cd /path/to/repo
```
3. Bring the docker container online in background mode:
```
./init.sh up
```

### Container access

#### Browser access
To access the docker containers from your browser, first make sure the containers are online (see previous).
1. Open the browser on your local computer.
2. Enter this URL to access the PHP 7 container: `http://localhost:7777`
    * Alternate URL: `http://172.16.0.77/`
3. Enter this URL to access the PHP 8 container: `http://localhost:8888`
    * Alternate URL: `http://172.16.0.88/`
If the web page doesn't come up right away you might need to restart the container web server:
1. From your local computer, open a terminal window.
2. Change to `/path/to/repo`:
3. Use the `init` option to initialize the web server:
* Windows
```
init init
```
* Linux/Mac
```
./init.sh init
```

#### Command line access
To access the containers from a command shell proceed as follows:
1. From your local computer, open a terminal window.
2. Change to `/path/to/repo`:
```
cd /path/to/repo
```
3. Execute the command to open a command shell:
* To open a shell into the PHP 7 container:
```
./init.sh shell 7
```
* To open a shell into the PHP 8 container:
```
./init.sh shell 8
```
### Bring container offline
It's a good idea to bring the container down (offline) when you're finished working with it.
This conserves resources.  Proceed as follows:
1. From your local computer, open a terminal window (terminal window).
2. Change to `/path/to/repo` (use the appropriate drive letter if not drive C):
```
cd /path/to/repo
```
3. Use `init.bat` to bring the containers offline:
```
./init.sh down
```
Please note that after the containers have been shut down, the ownership of all files in `/path/to/repo` are reset to the current user.

## Troubleshooting
One reader ran into this error:
```
standard_init_linux.go:228: exec user process caused: no such file or directory
```
* The suspected issue is when running under Windows, the Docker `*.sh` files might have been converted over to use CR/LF line endings instead of the expected LF only (i.e. Windows style line endings rather than Linux style).
* Directed the reader to this article: https://stackoverflow.com/questions/51508150/standard-init-linux-go190-exec-user-process-caused-no-such-file-or-directory
