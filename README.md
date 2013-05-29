# Name

BgvSessionDoctrine is a ZF2 module.

# Overview

BgvSessionDoctrine allow sessions to be stored in the database (via DoctrineORM).
Use [G403SessionDb](https://github.com/gabriel403/G403SessionDb) module if you use Zend\Db for database access.

# Install

Use `composer` to install this module.

    {
        ...
        "repositories": [
            ...
            {
                "type": "vcs",
                "url": "https://github.com/h15/bgv-session-doctrine.git"
            },
            ...
        ],
        ...
        "require": {
            ...
            "bugov/bgv-session-doctrine": "1.*",
            ...
        },
        ...
    }

Create `session` table into database by command

    ./path/to/bin/doctrine-module orm:schema-tool:update --force

# Copyright and license

Copyright (C) 2013, Georgy Bazhukov.

This program is free software, you can redistribute it and/or modify it
under the terms of the Artistic License version 2.0.