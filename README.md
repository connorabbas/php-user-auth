# PHP User Auth
A simple user authentication system built with [PHP Basic Framework](https://github.com/connorabbas/basic-framework) as an example project.

Not intended for production use.

## About
- User registration 
- Basic Login / Logout functionality use native `$_SESSION` super global
- CRUD operations
- Page access restrictions for users/guests

## Database Schema
```SQL
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    `email` varchar(128) NOT NULL,
    `password` varchar(128) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1
```