## 📌 Vendor Klasörünü İndirme ve Kullanma

Bu projede kullanılan **vendor** klasörü, **Composer** bağımlılık yönetimi tarafından oluşturulur. Eğer **vendor** klasörünüz eksikse veya hata alıyorsanız, aşağıdaki yöntemlerle yeniden oluşturabilirsiniz:

1. **Bu dersin Eklerinden veya kaynaklardan indirin**
   - Eğer **vendor** klasörü dersi takip ettiğiniz platformda Ekler kısmında sunulmuşsa, buradan indirip proje kök dizinine kopyalayabilirsiniz.
   - Alternatif olarak, eğitmenin paylaştığı herhangi bir link üzerinden de indirebilirsiniz.

---

## 📌 Composer Dosyaları

### `composer.json` Dosyası
Bu dosya, projenin bağımlılıklarını ve proje yapılandırmasını içerir. **Bu dosyanın amacı:**
- Kullanılan **PHP paketlerini ve kütüphaneleri** tanımlar.
- PHP sürümü gibi **proje gereksinimlerini** belirler.
- Otomatik yükleme (**autoload**) ayarlarını içerir.

> **Not:** `composer.json` dosyasında hangi paketlerin tanımlı olduğu bu alana eklenecektir.

```Json
{
    "name": "emrahyuksel/mvc",
    "description": "Mvc Yapısı",
    "type": "project",
    "autoload": {
    "psr-4": {
      "App\\": "app/"
    }
  },
    "authors": [
        {
            "name": "Emrah Yüksel"
        }
    ],
    "require": {
        "vlucas/phpdotenv": "^5.6",
        "phpmailer/phpmailer": "^6.9",
        "iyzico/iyzipay-php": "^2.0"
    }
}

```

---

### `composer.lock` Dosyası
Bu dosya, `composer.json` tarafından tanımlanan bağımlılıkların **kesin sürümlerini** içerir. **Bu dosyanın amacı:**
- Projede kullanılan **kütüphanelerin sürüm bilgilerini** saklamak.
- Ekibinizdeki herkesin aynı bağımlılık sürümlerini kullanmasını sağlamak.
- **Güncelleme ve kurulum tutarlılığını** garanti etmek.

> **Not:** `composer.lock` dosyasında hangi bağımlılık sürümleri olduğu bu alana eklenecektir.

```Json
{
    "_readme": [
        "This file locks the dependencies of your project to a known state",
        "Read more about it at https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies",
        "This file is @generated automatically"
    ],
    "content-hash": "d72542cdf70db16670256b25465ac908",
    "packages": [
        {
            "name": "graham-campbell/result-type",
            "version": "v1.1.3",
            "source": {
                "type": "git",
                "url": "https://github.com/GrahamCampbell/Result-Type.git",
                "reference": "3ba905c11371512af9d9bdd27d99b782216b6945"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/GrahamCampbell/Result-Type/zipball/3ba905c11371512af9d9bdd27d99b782216b6945",
                "reference": "3ba905c11371512af9d9bdd27d99b782216b6945",
                "shasum": ""
            },
            "require": {
                "php": "^7.2.5 || ^8.0",
                "phpoption/phpoption": "^1.9.3"
            },
            "require-dev": {
                "phpunit/phpunit": "^8.5.39 || ^9.6.20 || ^10.5.28"
            },
            "type": "library",
            "autoload": {
                "psr-4": {
                    "GrahamCampbell\\ResultType\\": "src/"
                }
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Graham Campbell",
                    "email": "hello@gjcampbell.co.uk",
                    "homepage": "https://github.com/GrahamCampbell"
                }
            ],
            "description": "An Implementation Of The Result Type",
            "keywords": [
                "Graham Campbell",
                "GrahamCampbell",
                "Result Type",
                "Result-Type",
                "result"
            ],
            "support": {
                "issues": "https://github.com/GrahamCampbell/Result-Type/issues",
                "source": "https://github.com/GrahamCampbell/Result-Type/tree/v1.1.3"
            },
            "funding": [
                {
                    "url": "https://github.com/GrahamCampbell",
                    "type": "github"
                },
                {
                    "url": "https://tidelift.com/funding/github/packagist/graham-campbell/result-type",
                    "type": "tidelift"
                }
            ],
            "time": "2024-07-20T21:45:45+00:00"
        },
        {
            "name": "iyzico/iyzipay-php",
            "version": "v2.0.58",
            "source": {
                "type": "git",
                "url": "https://github.com/iyzico/iyzipay-php.git",
                "reference": "61089e8deb03977af3a1ff396b73dc01ad12fdb0"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/iyzico/iyzipay-php/zipball/61089e8deb03977af3a1ff396b73dc01ad12fdb0",
                "reference": "61089e8deb03977af3a1ff396b73dc01ad12fdb0",
                "shasum": ""
            },
            "require": {
                "ext-curl": "*",
                "php": ">=7.4.0"
            },
            "require-dev": {
                "phpunit/phpunit": "~9.6",
                "satooshi/php-coveralls": "~0.6.1"
            },
            "type": "library",
            "autoload": {
                "psr-4": {
                    "Iyzipay\\": "src/Iyzipay/"
                }
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "iyzico and contributors",
                    "homepage": "https://github.com/iyzico/iyzipay-php/contributors"
                }
            ],
            "description": "iyzipay api php client",
            "homepage": "https://www.iyzico.com",
            "keywords": [
                "iyzico",
                "iyzico.com",
                "iyzipay",
                "iyzipay api",
                "iyzipay api php",
                "iyzipay api php client",
                "iyzipay php",
                "payment processing"
            ],
            "support": {
                "issues": "https://github.com/iyzico/iyzipay-php/issues",
                "source": "https://github.com/iyzico/iyzipay-php/tree/v2.0.58"
            },
            "time": "2024-12-26T12:49:12+00:00"
        },
        {
            "name": "phpmailer/phpmailer",
            "version": "v6.9.3",
            "source": {
                "type": "git",
                "url": "https://github.com/PHPMailer/PHPMailer.git",
                "reference": "2f5c94fe7493efc213f643c23b1b1c249d40f47e"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/PHPMailer/PHPMailer/zipball/2f5c94fe7493efc213f643c23b1b1c249d40f47e",
                "reference": "2f5c94fe7493efc213f643c23b1b1c249d40f47e",
                "shasum": ""
            },
            "require": {
                "ext-ctype": "*",
                "ext-filter": "*",
                "ext-hash": "*",
                "php": ">=5.5.0"
            },
            "require-dev": {
                "dealerdirect/phpcodesniffer-composer-installer": "^1.0",
                "doctrine/annotations": "^1.2.6 || ^1.13.3",
                "php-parallel-lint/php-console-highlighter": "^1.0.0",
                "php-parallel-lint/php-parallel-lint": "^1.3.2",
                "phpcompatibility/php-compatibility": "^9.3.5",
                "roave/security-advisories": "dev-latest",
                "squizlabs/php_codesniffer": "^3.7.2",
                "yoast/phpunit-polyfills": "^1.0.4"
            },
            "suggest": {
                "decomplexity/SendOauth2": "Adapter for using XOAUTH2 authentication",
                "ext-mbstring": "Needed to send email in multibyte encoding charset or decode encoded addresses",
                "ext-openssl": "Needed for secure SMTP sending and DKIM signing",
                "greew/oauth2-azure-provider": "Needed for Microsoft Azure XOAUTH2 authentication",
                "hayageek/oauth2-yahoo": "Needed for Yahoo XOAUTH2 authentication",
                "league/oauth2-google": "Needed for Google XOAUTH2 authentication",
                "psr/log": "For optional PSR-3 debug logging",
                "symfony/polyfill-mbstring": "To support UTF-8 if the Mbstring PHP extension is not enabled (^1.2)",
                "thenetworg/oauth2-azure": "Needed for Microsoft XOAUTH2 authentication"
            },
            "type": "library",
            "autoload": {
                "psr-4": {
                    "PHPMailer\\PHPMailer\\": "src/"
                }
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "LGPL-2.1-only"
            ],
            "authors": [
                {
                    "name": "Marcus Bointon",
                    "email": "phpmailer@synchromedia.co.uk"
                },
                {
                    "name": "Jim Jagielski",
                    "email": "jimjag@gmail.com"
                },
                {
                    "name": "Andy Prevost",
                    "email": "codeworxtech@users.sourceforge.net"
                },
                {
                    "name": "Brent R. Matzelle"
                }
            ],
            "description": "PHPMailer is a full-featured email creation and transfer class for PHP",
            "support": {
                "issues": "https://github.com/PHPMailer/PHPMailer/issues",
                "source": "https://github.com/PHPMailer/PHPMailer/tree/v6.9.3"
            },
            "funding": [
                {
                    "url": "https://github.com/Synchro",
                    "type": "github"
                }
            ],
            "time": "2024-11-24T18:04:13+00:00"
        },
        {
            "name": "phpoption/phpoption",
            "version": "1.9.3",
            "source": {
                "type": "git",
                "url": "https://github.com/schmittjoh/php-option.git",
                "reference": "e3fac8b24f56113f7cb96af14958c0dd16330f54"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/schmittjoh/php-option/zipball/e3fac8b24f56113f7cb96af14958c0dd16330f54",
                "reference": "e3fac8b24f56113f7cb96af14958c0dd16330f54",
                "shasum": ""
            },
            "require": {
                "php": "^7.2.5 || ^8.0"
            },
            "require-dev": {
                "bamarni/composer-bin-plugin": "^1.8.2",
                "phpunit/phpunit": "^8.5.39 || ^9.6.20 || ^10.5.28"
            },
            "type": "library",
            "extra": {
                "bamarni-bin": {
                    "bin-links": true,
                    "forward-command": false
                },
                "branch-alias": {
                    "dev-master": "1.9-dev"
                }
            },
            "autoload": {
                "psr-4": {
                    "PhpOption\\": "src/PhpOption/"
                }
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "Apache-2.0"
            ],
            "authors": [
                {
                    "name": "Johannes M. Schmitt",
                    "email": "schmittjoh@gmail.com",
                    "homepage": "https://github.com/schmittjoh"
                },
                {
                    "name": "Graham Campbell",
                    "email": "hello@gjcampbell.co.uk",
                    "homepage": "https://github.com/GrahamCampbell"
                }
            ],
            "description": "Option Type for PHP",
            "keywords": [
                "language",
                "option",
                "php",
                "type"
            ],
            "support": {
                "issues": "https://github.com/schmittjoh/php-option/issues",
                "source": "https://github.com/schmittjoh/php-option/tree/1.9.3"
            },
            "funding": [
                {
                    "url": "https://github.com/GrahamCampbell",
                    "type": "github"
                },
                {
                    "url": "https://tidelift.com/funding/github/packagist/phpoption/phpoption",
                    "type": "tidelift"
                }
            ],
            "time": "2024-07-20T21:41:07+00:00"
        },
        {
            "name": "symfony/polyfill-ctype",
            "version": "v1.31.0",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/polyfill-ctype.git",
                "reference": "a3cc8b044a6ea513310cbd48ef7333b384945638"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/symfony/polyfill-ctype/zipball/a3cc8b044a6ea513310cbd48ef7333b384945638",
                "reference": "a3cc8b044a6ea513310cbd48ef7333b384945638",
                "shasum": ""
            },
            "require": {
                "php": ">=7.2"
            },
            "provide": {
                "ext-ctype": "*"
            },
            "suggest": {
                "ext-ctype": "For best performance"
            },
            "type": "library",
            "extra": {
                "thanks": {
                    "url": "https://github.com/symfony/polyfill",
                    "name": "symfony/polyfill"
                }
            },
            "autoload": {
                "files": [
                    "bootstrap.php"
                ],
                "psr-4": {
                    "Symfony\\Polyfill\\Ctype\\": ""
                }
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Gert de Pagter",
                    "email": "BackEndTea@gmail.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "https://symfony.com/contributors"
                }
            ],
            "description": "Symfony polyfill for ctype functions",
            "homepage": "https://symfony.com",
            "keywords": [
                "compatibility",
                "ctype",
                "polyfill",
                "portable"
            ],
            "support": {
                "source": "https://github.com/symfony/polyfill-ctype/tree/v1.31.0"
            },
            "funding": [
                {
                    "url": "https://symfony.com/sponsor",
                    "type": "custom"
                },
                {
                    "url": "https://github.com/fabpot",
                    "type": "github"
                },
                {
                    "url": "https://tidelift.com/funding/github/packagist/symfony/symfony",
                    "type": "tidelift"
                }
            ],
            "time": "2024-09-09T11:45:10+00:00"
        },
        {
            "name": "symfony/polyfill-mbstring",
            "version": "v1.31.0",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/polyfill-mbstring.git",
                "reference": "85181ba99b2345b0ef10ce42ecac37612d9fd341"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/symfony/polyfill-mbstring/zipball/85181ba99b2345b0ef10ce42ecac37612d9fd341",
                "reference": "85181ba99b2345b0ef10ce42ecac37612d9fd341",
                "shasum": ""
            },
            "require": {
                "php": ">=7.2"
            },
            "provide": {
                "ext-mbstring": "*"
            },
            "suggest": {
                "ext-mbstring": "For best performance"
            },
            "type": "library",
            "extra": {
                "thanks": {
                    "url": "https://github.com/symfony/polyfill",
                    "name": "symfony/polyfill"
                }
            },
            "autoload": {
                "files": [
                    "bootstrap.php"
                ],
                "psr-4": {
                    "Symfony\\Polyfill\\Mbstring\\": ""
                }
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Nicolas Grekas",
                    "email": "p@tchwork.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "https://symfony.com/contributors"
                }
            ],
            "description": "Symfony polyfill for the Mbstring extension",
            "homepage": "https://symfony.com",
            "keywords": [
                "compatibility",
                "mbstring",
                "polyfill",
                "portable",
                "shim"
            ],
            "support": {
                "source": "https://github.com/symfony/polyfill-mbstring/tree/v1.31.0"
            },
            "funding": [
                {
                    "url": "https://symfony.com/sponsor",
                    "type": "custom"
                },
                {
                    "url": "https://github.com/fabpot",
                    "type": "github"
                },
                {
                    "url": "https://tidelift.com/funding/github/packagist/symfony/symfony",
                    "type": "tidelift"
                }
            ],
            "time": "2024-09-09T11:45:10+00:00"
        },
        {
            "name": "symfony/polyfill-php80",
            "version": "v1.31.0",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/polyfill-php80.git",
                "reference": "60328e362d4c2c802a54fcbf04f9d3fb892b4cf8"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/symfony/polyfill-php80/zipball/60328e362d4c2c802a54fcbf04f9d3fb892b4cf8",
                "reference": "60328e362d4c2c802a54fcbf04f9d3fb892b4cf8",
                "shasum": ""
            },
            "require": {
                "php": ">=7.2"
            },
            "type": "library",
            "extra": {
                "thanks": {
                    "url": "https://github.com/symfony/polyfill",
                    "name": "symfony/polyfill"
                }
            },
            "autoload": {
                "files": [
                    "bootstrap.php"
                ],
                "psr-4": {
                    "Symfony\\Polyfill\\Php80\\": ""
                },
                "classmap": [
                    "Resources/stubs"
                ]
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Ion Bazan",
                    "email": "ion.bazan@gmail.com"
                },
                {
                    "name": "Nicolas Grekas",
                    "email": "p@tchwork.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "https://symfony.com/contributors"
                }
            ],
            "description": "Symfony polyfill backporting some PHP 8.0+ features to lower PHP versions",
            "homepage": "https://symfony.com",
            "keywords": [
                "compatibility",
                "polyfill",
                "portable",
                "shim"
            ],
            "support": {
                "source": "https://github.com/symfony/polyfill-php80/tree/v1.31.0"
            },
            "funding": [
                {
                    "url": "https://symfony.com/sponsor",
                    "type": "custom"
                },
                {
                    "url": "https://github.com/fabpot",
                    "type": "github"
                },
                {
                    "url": "https://tidelift.com/funding/github/packagist/symfony/symfony",
                    "type": "tidelift"
                }
            ],
            "time": "2024-09-09T11:45:10+00:00"
        },
        {
            "name": "vlucas/phpdotenv",
            "version": "v5.6.1",
            "source": {
                "type": "git",
                "url": "https://github.com/vlucas/phpdotenv.git",
                "reference": "a59a13791077fe3d44f90e7133eb68e7d22eaff2"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/vlucas/phpdotenv/zipball/a59a13791077fe3d44f90e7133eb68e7d22eaff2",
                "reference": "a59a13791077fe3d44f90e7133eb68e7d22eaff2",
                "shasum": ""
            },
            "require": {
                "ext-pcre": "*",
                "graham-campbell/result-type": "^1.1.3",
                "php": "^7.2.5 || ^8.0",
                "phpoption/phpoption": "^1.9.3",
                "symfony/polyfill-ctype": "^1.24",
                "symfony/polyfill-mbstring": "^1.24",
                "symfony/polyfill-php80": "^1.24"
            },
            "require-dev": {
                "bamarni/composer-bin-plugin": "^1.8.2",
                "ext-filter": "*",
                "phpunit/phpunit": "^8.5.34 || ^9.6.13 || ^10.4.2"
            },
            "suggest": {
                "ext-filter": "Required to use the boolean validator."
            },
            "type": "library",
            "extra": {
                "bamarni-bin": {
                    "bin-links": true,
                    "forward-command": false
                },
                "branch-alias": {
                    "dev-master": "5.6-dev"
                }
            },
            "autoload": {
                "psr-4": {
                    "Dotenv\\": "src/"
                }
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "BSD-3-Clause"
            ],
            "authors": [
                {
                    "name": "Graham Campbell",
                    "email": "hello@gjcampbell.co.uk",
                    "homepage": "https://github.com/GrahamCampbell"
                },
                {
                    "name": "Vance Lucas",
                    "email": "vance@vancelucas.com",
                    "homepage": "https://github.com/vlucas"
                }
            ],
            "description": "Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.",
            "keywords": [
                "dotenv",
                "env",
                "environment"
            ],
            "support": {
                "issues": "https://github.com/vlucas/phpdotenv/issues",
                "source": "https://github.com/vlucas/phpdotenv/tree/v5.6.1"
            },
            "funding": [
                {
                    "url": "https://github.com/GrahamCampbell",
                    "type": "github"
                },
                {
                    "url": "https://tidelift.com/funding/github/packagist/vlucas/phpdotenv",
                    "type": "tidelift"
                }
            ],
            "time": "2024-07-20T21:52:34+00:00"
        }
    ],
    "packages-dev": [],
    "aliases": [],
    "minimum-stability": "stable",
    "stability-flags": {},
    "prefer-stable": false,
    "prefer-lowest": false,
    "platform": {},
    "platform-dev": {},
    "plugin-api-version": "2.6.0"
}

```

---

📌 **Sonuç olarak:** Eğer projenizde **vendor** klasörü eksikse veya bağımlılıklar eksik çalışıyorsa, yukarıdaki adımları takip ederek **composer.json** ve **composer.lock** dosyalarını kullanarak bağımlılıkları yükleyebilirsiniz.