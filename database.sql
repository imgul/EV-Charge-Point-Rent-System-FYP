-- create user table

CREATE TABLE
    IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `email` varchar(255) NOT NULL,
        `name` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `owner` tinyint(1) NOT NULL DEFAULT '0',
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT = 1;

-- create charge points table

CREATE TABLE
    IF NOT EXISTS `charge_points` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `name` varchar(255) NOT NULL,
        `address` varchar(255) NOT NULL,
        `latitude` varchar(255) NOT NULL,
        `longitude` varchar(255) NOT NULL,
        `price` varchar(255) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT = 1;

-- populate users table

INSERT INTO
    `users` (
        `id`,
        `email`,
        `name`,
        `password`,
        `owner`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        'abc@d.com',
        'abc',
        '123',
        1,
        '2019-01-01 00:00:00',
        '2019-01-01 00:00:00'
    ), (
        2,
        'sdg@ds.com',
        'sdg',
        '123',
        0,
        '2019-01-01 00:00:00',
        '2019-01-01 00:00:00'
    );

-- populate charge points table

INSERT INTO
    `charge_points` (
        `id`,
        `user_id`,
        `name`,
        `address`,
        `latitude`,
        `longitude`,
        `price`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        1,
        'abc',
        'abc',
        'abc',
        'abc',
        'abc',
        '2019-01-02 00:00:00',
        '2019-01-02 00:00:00'
    ), (
        2,
        1,
        'abc',
        'abc',
        'abc',
        'abc',
        'abc',
        '2019-01-02 00:00:00',
        '2019-01-02 00:00:00'
    ), (
        3,
        1,
        'abc',
        'abc',
        'abc',
        'abc',
        'abc',
        '2019-01-5 00:00:00',
        '2019-01-5 00:00:00'
    ), (
        4,
        1,
        'abc',
        'abc',
        'abc',
        'abc',
        'abc',
        '2019-01-5 00:00:00',
        '2019-01-5 00:00:00'
    ), (
        5,
        1,
        'abc',
        'abc',
        'abc',
        'abc',
        'abc',
        '2019-01-4 00:00:00',
        '2019-01-4 00:00:00'
    );