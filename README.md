# NetLime Starter Theme v2
### Extensible WordPress Starter Theme

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

### Planned
- Adding to composer repos
- Creating a good README.md where everything is explained
- Create some tutorials / documentation for usage and extension creation
- Comment everything + php doc
- Lot of tests to test extensibility and performance (it´s fast for now)
- Get rid of yaml for main config and use json instead for optimal performance (yaml is nice,but json is faster)
- Integrating ACF Pro. ( Who will buy me it? :D )
- And more cool stuff

### Quick how it works
- Check function.php
- Check app/lib/vendor/netlime-starter-theme/core/Theme.php
- Check app/lib/vendor/netlime-starter-theme/extensions/*
- Check app/etc/core/sections.yaml & wrappers.yaml
- Check wrappers/*.php
- Check templates/*/*.php
- Check index.php