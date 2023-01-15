# PHP User Auth
A simple user authentication system built with [PHP Basic Framework](https://github.com/connorabbas/basic-framework) as an example project.

Not intended for production use.

## About
- User registration 
- Login / Logout functionality
- Basic CRUD operations
- Page access restrictions for users or guests

## Table Schema
```SQL
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `role` int(1) NOT NULL DEFAULT 0,
    `name` varchar(128) NOT NULL,
    `email` varchar(128) NOT NULL,
    `username` varchar(128) NOT NULL,
    `password` varchar(128) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
```
