# PHP User Authentication System 
### using: [PHP Mini Framework](https://github.com/connorabbas/php-mini-framework)

- User registration with validation
- User login/logout with session
- Middleware to limit page/route access for guests and users
 
---
``` SQL
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `role` int(1) NOT NULL DEFAULT 0,
    `name` varchar(128) NOT NULL,
    `email` varchar(128) NOT NULL,
    `username` varchar(128) NOT NULL,
    `password` varchar(128) NOT NULL,
    PRIMARY KEY (`id`)
)
```