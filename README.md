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
## The simple way for just a bootstrap blog
- Download this theme https://github.com/erikkubica/netlime-starter-theme-v2/archive/master.zip
- Unzip to /wp-content/themes directory of your WordPress installation
- Activate the theme
- Place widgets to right sidebar (set title to widget, without title html is bugged)

## Customization
First you need to follow first three steps in "The simple way for just a bootstrap blog".

### Creating a "Hello World" section in right sidebar before widgets is rendered
1. Create a php file templates/hello_world/hello.php with content "Hello World"
2. Open functions.php and find the "### Register sections" part
3. Anywhere inside the "on_theme_register_sections" type:

theme()->registerSection("hello", "templates/hello_world/hello.php", true);

4. Now you registered section with sectionKey "hello", with file "templates/hello_world/hello.php" and with caching set to true.
5. To place this section to index page, open index.php and place "hello" => "right" before the "sidebar_right" => "right"
 
 The array key is the sectionKey (or sectionName) you have registered and the array value is the locationKey (or locationInSomeWrapper) 
 in wrapper (will write about later).
 
 You can specify unlimited amount of sections to locations, these sections will be rendered at given location in the same order as 
 they are added to render method. So using this approach you can move section up and down on the page.
 
 index.php should look like this:
```
 theme()->render("2column-right", [
     // "sectionName" => "locationInSomeWrapper"
     "header" => "top",
     "post_list" => "content",
     "pagination" => "content",
     "hello" => "right",
     "sidebar_right" => "right",
     "footer" => "bottom"
 ]);
 ```
 
 That´s all.
 
 ### Creating a wrapper with header, left sidebar, content, right sidebar and footer
 1. Create php file wrappers/3column.php with content of 2column-right.php which looks like this:
```
 <!DOCTYPE html>
 <html lang="en">
     <head>
         <meta charset="utf-8">
         <meta http-equiv="x-ua-compatible" content="ie=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
         <?php wp_head() ?>
     </head>
     <body>
         <div id="wrapper">
             <?php theme()->getContent("top"); ?>
             <div id="main">
                 <main role="main" class="container">
                     <div class="row">
                         <div class="col-sm-12 col-md-8">
                             <?php theme()->getContent("content"); ?>
                         </div>
                         <div class="col-sm-12 col-md-4">
                             <?php theme()->getContent("right"); ?>
                         </div>
                     </div>
                 </main>
             </div>
             <?php theme()->getContent("bottom"); ?>
         </div>
         <?php wp_footer(); ?>
     </body>
 </html>
 ```
 
 Notice the theme()->getContent("top");  functions. The getContent function starts to render sections that are assigned to locationKey
 in this case it´s "top". Fine, if you red the how to create a hello world section you already know what is the location key.
 
 2. Modify the html to your needs, in this case we resize the content column from col-md-8 to col-md-6, and the right column from 
 col-md-4 to col-md-3 and we add an left column before the content column. Which will look like this:
```
<div class="col-sm-12 col-md-3">
     <?php theme()->getContent("left"); ?>
</div>
```

3. Register the wrapper.
- Open functions.php and find the "### Register wrappers" part
- Anywhere in the "on_theme_register_wrappers" hook place the following: theme()->registerWrapper("3column", "wrappers/3column.php");
- Done, your 3column wrapper is now registered.

#### Changing the wrapper of WordPress template
- Open for example index.php and change the first parameter of theme()->render to the wrapperKey you defined in the first parameter of theme()->registerWrapper

### Overriding theme module config
ToDo (for basic concept see "Registering assets")

### Registering assets
Registering assets forks on same principe like overriding theme module configs. This theme is shipped by already overridden ThemeAssets config.
1. Open app/etc/assets/config.json
2. Add your styles and javascript here as you can see on example in the file.

### Creating module
ToDo

## PFAQBTINFAQY (Possible FAQ because the is no FAQ yet)
 - How did you get the PFAQBTINFAQY short name? 
   - I am an genius inventor, it just came
 - Why is better to register section and then adding it into render method. Good question and the answer is simple. 
 There are at least 2 benefits:
   - This theme uses section caching, which means that you can globally set to cache section what is not possible with the simple get_template_part
   - When you decide to move the section template file into another directory, you just change the path in functions.php instead of changing it in all WordPress templates.
- Can I create custom locations in wrappers?
  - Yes, let´s say in your wrapper you will use theme()->getContent("FLDSMDFR")  then in the render method in WordPress template when you you define where to render the section you just set "FLDSMDFR"
- Why I need to define wrapper instead of just using file path in render?
   - For example to keep the logic of registering things.
   - Or just if you decide to change the folder structure or filename of wrapper, you just need to change it in functions.php instead of doing it in all template files.
- Why are all registering done in hooks?
  - This way it´s possible to gain control of things for example: when using theme modules which are doing overrides.
  - Or when you or any theme module needs to execute some action before modules/wrappers/sections are registered.
  - Or any other possible reasons.
- Why I need to register assets using config.json of theme assets?
  - It´s not needed but it´s good to keep the approach how this theme works, by extending modules you can change behaviour of things, and since Assets in theme is module
  it´s good to follow the approach.

# Do you like it? You can support by BitCoin or Ethereum
- BTC: 17SoAmKeikpuW7BzLv9TQh7g9eYihp8XAo
- ETH: 0xb3694e6a98e5309bdbb86466202fa9be90d54e73