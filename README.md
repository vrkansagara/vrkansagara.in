# vrkansagara
This is the code behind vrkansagara.in


#### Performance Statistics.
![image](https://github.com/vrkansagara/vrkansagara.in/blob/master/screenshots/2020-11-03%2009-21-35.png)



## Built using
- Laminas MVC Framework (Formaly known as Zend Framework)
- Bootstrap5
- jQuery
- VueJs


### Application module(s)
- Application.
- [PhlyBlog](!https://github.com/phly/PhlyBlog) for blog generation.
- [PhlySimplePage](!https://github.com/phly/PhlySimplePage) for static page.


### How to setup this project ###

-[]
docker run --rm --interactive --tty \
--volume $PWD:/app \
--volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp \
--user $(id -u):$(id -g) \
composer install