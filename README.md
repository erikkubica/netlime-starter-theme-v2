# NetLime Starter Theme v2
### Extensible WordPress Starter Theme

An primite working demo used for development and then push to git: http://netwpdev.netlime.eu/ 

#### Current features
- Extensible using "extensions" see functions php and app/lib/vendor/netlime-starter-theme/extensions directory
- Section oriented (or block, scrap,...)
- Section caching separately for each page and each section with possibility to clear cache from admin
- Multi wrapper support (wrapper = layout = wraps templates and sections)
- Fully hookable (still need to remake some hooks to filters)
- Mostly commented functionality, when there will be a stable version full php-doc will come
- Extension configuration can be overridden by file, in future maybe with filter.
- Comes with compiled bootstrap (sorry for that), bootstrap menu walker, bootstrap pagination, bootstrap comments
- Widgets are converted to bootstrap panels
- Create MegaMenu using shortcode. Just create new menu item, set "Is MegaMenu" to "Yes" add shortcode that renders 
your MegaMenu to "Shortcode" field. If these options is not visible, then enable them in "Screen options"

### Planned
- Creating a good README.md where everything is explained (in progress)
- Create some tutorials / documentation for usage and extension creation
- Comment everything + php doc
- Lot of tests to test extensibility and performance (it´s fast for now)
- Integrating ACF Pro. ( Who will buy me it? :D )
- Adding to composer repository
- And more cool stuff

### Quick how it works
- Check function.php
- Check app/lib/vendor/netlime-starter-theme/core/Theme.php
- Check app/lib/vendor/netlime-starter-theme/extensions/*
- Check app/etc/core/sections.yaml & wrappers.yaml
- Check wrappers/*.php
- Check templates/*/*.php
- Check index.php

## New feature 25.05.0217
### Added debug module (kind of debug toolbar to monitor render and load times)

In action: http://netwpdev.netlime.eu/?debug

Code: https://github.com/erikkubica/netlime-starter-theme-v2/tree/master/app/lib/vendor/netlime-starter-theme/extensions/debug

# Quick start guide
An documentation website is WIP

# Do you like it? You can support by BitCoin or Ethereum
- BTC: 17SoAmKeikpuW7BzLv9TQh7g9eYihp8XAo
- ETH: 0xb3694e6a98e5309bdbb86466202fa9be90d54e73