# Watcher

[![Latest Stable Version](https://poser.pugx.org/jdecool/watcher/v/stable.png)](https://packagist.org/packages/jdecool/watcher)

## Work in Progress

Please note that this project is currently under active development. We encourage everyone to try it and give feedback, but we don't recommend it for production use yet.

## Intro

This tool watches a resource (filesystem, API resources, ...) and notify a listener of any changes.

## Installation

You can install it by running [Composer](https://getcomposer.org):

```bash
$ composer require jdecool/watcher
```

## Usage

First you need configure the tool by creating a `watcher.yaml` file:

```yaml
watcher: Vendor\Package\MyWatcher
storage: JDecool\Watcher\Storage\JsonStorage
listeners:
    - Vendor\Package\Lister1
    - Vendor\Package\Lister2
```

The `watch` class is an instance of `JDecool\Watcher\Watcher` and it is an implementation of a watcher. It will watch content to detect some change.

The class need to contain a method `public function getObjects(): array` to returns objects.

Information about data can be stored with different strategies and you need to define how you want to store those data with the `storage` key.

Finally, you need to register `listeners` that can be triggered. A listener class is an `Symfony\Component\EventDispatcher\EventSubscriberInterface` implementation.

Then you can run your watcher with `vendor/bin/watcher`.
