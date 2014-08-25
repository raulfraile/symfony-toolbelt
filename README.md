THIS IS A PROOF OF CONCEPT
==========================

Symfony Toolbelt is a project that aims to develop a set of utilities for Symfony project management. **The only utility developed so far is a new Symfony installer**.

Symfony installer
-----------------

Currently, to start a new Symfony project in the `blog/` directory you must execute the following command:

```bash
$ composer create-project symfony/framework-standard-edition blog/
```

Then you have to wait up to several minutes (depending on your Composer cache, CPU power and network connection) and you'll see tens of lines of debug messages.

The **new Symfony installer** aims to drastically simplify this process. To start a new Symfony project in the `blog/` directory you must execute the following command:

```bash
$ symfony new blog/
```

The you have to wait a few seconds (usually less than 10) and you'll see a beautiful and helpful message as result. Here it is a recording of the actual working of this new installer.

![A proposed Symfony installer](doc/img/awesome_symfony_installer.gif)
