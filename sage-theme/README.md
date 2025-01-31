## Sage Theme Information

### Steps for installation

-   Install sage theme in themes dir by running command in docs
-   yarn / npm install
-   update the config file bud / vite (sage 10.8+)
-   Install acorn inside theme dir / plugin
    -   Add Acorn's post autoload dump function
    -   composer.json

```json
"scripts": {
  //...
  "post-autoload-dump": [
    "Roots\\Acorn\\ComposerScripts::postAutoloadDump"
  ]
}

```

### Basics of Sage Theme

#### 📁 App

Brain of the theme, setup anything we need to have avaliable under any templates

-   #### 📁 Components

```go
wp acorn make:component ExampleComponent
```
    - Data to be passed into said component

-   #### 📁 Composers

    -   #### App.php
    -   Data to be passed into view before rendering

-   ##### filters.php

    -   this will contain all the filters and actions for the different wordpress hooks. -examples in [filters.php](filters/readme.md)

-   ##### setup.php
    -   this will have all the handling of enqueueing all the scripts and styles, theme support, and all theme related things. (usually found in regular functions.php)

### 📁 public

built assets in correspoinding folder (dont change anything in this folder)

#### 📁css

-   css/editor (editor)
-   css/app (frontend)

#### 📁Js

-   js/editor(editor)
-   js/app (app)
-   js/manifest (to break the cache for css and js)
-   js/entrypoint (enqueue all files we need)

### 📁 resources

is the file that will be spending the most time in and creating all views components

#### 📁 fonts

Where theme default fonts are placed

#### 📁 Images

Where theme default images are place

#### 📁 scripts

theme default JS files

-   ##### editor
    -   editor.js (to be built)
-   ##### app
    -   app.js (to be built)

#### 📁 styles

theme default CSS files

-   ##### editor
    -   editor.css (to be built)
-   ##### app
    -   app.css (to be built)

#### 📁 views

PHP blade view templates

-   ##### 📁 components

-   ##### 📁 forms

-   ##### 📁 layouts

    -   Has the layout of the whole theme, it is possble to create other layouts increase a page has a different layout

-   ##### 📁 partials

-   ##### 📁 sections
    -   Has all sections being using inside of the layout or that will be used through mutiple files

Bootstraping means, loading all minimum necessary depenedencies for a system to operate and be functional

# Examples

-   [ServiceProvider](service-providers/readme.md)
-   [filters.php](filters/readme.md)

# Other Links

-   [ACF Composer](https://github.com/Log1x/acf-composer)
-   [ACF Builder Cheatsheet](https://github.com/Log1x/acf-builder-cheatsheet)
-   [Sage Directives](https://log1x.github.io/sage-directives-docs/)
-   [Blade Templating and Directives](https://laravel.com/docs/11.x/blade#blade-directives)
