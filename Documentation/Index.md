# mst/mst-reloadtrigger

add a trigger where e.g. browsersync can watch

> [!NOTE]
> This documentation guide was automatically created by the init command of
> the TYPO3 Documentation Rendering Container. See
> `Rendering container <https://docs.typo3.org/permalink/h2document:rendering>`_
> for details.

## Installation

Install the extension via Composer:

```
composer req mst/mst-reloadtrigger --dev
```

Or download the extension from https://www.michaelstein-itb.de/projekte/mst-reloadtrigger and install it in
the Extension Manager.

See also [Installing extensions, TYPO3 Getting started](https://docs.typo3.org/permalink/t3start:installing-extensions)

## Configuration

For the extension itself, no configuration is needed.

You have to configure you browsersync to watch the file typo3temp/ReloadFrontend.now.

### Configuration with ddev

#### Install browsersync in ddev

```bash
ddev add-on get ddev/ddev-browsersync
ddev restart
```

#### Setup the watcher

modify **.ddev/browser-sync.cjs** like this:
```javascript
let filesdir = process.env.DDEV_FILES_DIR;
let url = process.env.DDEV_HOSTNAME;
let nonSslUrl = process.env.DDEV_PRIMARY_URL.replace( /^https:/, 'http:' )

if (filesdir === "") {
    filesdir = null
}

module.exports = {
  // watch whatever you are interessted
	files: [
        "public/typo3temp/ReloadFrontend.now",
        "packages/sitepackage/Classes/**/*",
        "packages/sitepackage/Configuration/**/*",
        "packages/sitepackage/ContentBlocks/**/*",
        "packages/sitepackage/Resources/Private/**/*.html",
        "packages/sitepackage/Resources/Public/**/*.js",
        "packages/sitepackage/Resources/Public/**/*.css"],
	],
	ignore: ["node_modules", filesdir, "vendor"],
	open: false,
	ui: false,
	server: false,
	proxy: {
		target: nonSslUrl,
		proxyReq: [
      // Send TYPO3 a message that this browsersync request
			function(proxyReq) {
				proxyReq.setHeader('X-Browser-Sync', '1');
			}
		]
	},
	host: url,
}
```

#### Disable TYPO3 cache

As your Browsersync is not logged into the backend, we need to disable the cache.
Add the following to your **config/system/additional.php** file:
```php
use \TYPO3\CMS\Core\Cache\Backend\NullBackend;
use \TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend;

// this is the signal from above
if (getenv('HTTP_X_BROWSER_SYNC') == '1') {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['core']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['hash']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pages']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pagesection']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['phpcode']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['runtime']['backend'] = TransientMemoryBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['rootline']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['imagesizes']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['l10n']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_object']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_reflection']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_datamapfactory_datamap']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['typoscript']['backend'] = NullBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['fluid_template']['backend'] = NullBackend::class;
}
```

#### Setup you site config

The ddev-browsersync component communicates directly with your web server inside your DDEV container, bypassing the proxy server that manages the certificate.

Somehow it manages the certificate by itself.

(I would appreciate it if someone could explain this correctly.)

Anyway.

You need to set up your TYPO3 instance so that it is not stuck to HTTPS.

Edit your **config/sites/your-projekt/config.yaml** like this:

```yaml
base: https://your-projekt.com
baseVariants:
  -
    # use the base without protocoll
    base: 'your-projekt.ddev.site'
    condition: 'applicationContext == "Development/Local"'
```

#### Start browsersync

```bash
ddev browsersync
```


## Report issues

You can report issues at https://github.com/mxsteini/mst_reloadtrigger/issues.
