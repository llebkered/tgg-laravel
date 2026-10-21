# Local copy of hardevine/shoppingcart

This is hardevine/shoppingcart 3.4 (MIT), bundled because no upstream release
supports Laravel 13 yet. The only change is `^13` added to the `illuminate/*`
requirements in `composer.json`; `src/` is unchanged.

When upstream publishes a Laravel 13 release, remove the `repositories` entry
from the root `composer.json`, require that release, and delete this directory.
