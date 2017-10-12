# Domain Checker and Whois with Ajax

Complete Domain Checker and Whois with Ajax.

## Installation

Whoiskomplit has two main settings, it is in the autoselect.

### Main Settings

Default for autoselect is true. By doing so, will bring up a select dropdown.

```
$konfigurasi['autoselect'] = true;
```

You can also change it to false value, like this.

```
$konfigurasi['autoselect'] = false;
```

It allows you to enter your domain name completely.

### Extensions Settings

If you want to restrict access, you can set the extension that only allowed

```
$konfigurasi['domainsupport'] = array('.com','.net','.org','.info','.biz');
```

or you can allow all domain extensions.

```
$konfigurasi['domainsupport'] = array('-');
```

### Extensions Settings on Select Tag

If you set autoselect to 'false', then ignore it. It works to bring up the extensions when autoselect is true.

```
$konfigurasi['domainonindexpage'] = array('.com','.net','.org','.info','.biz');
```

## Authors

* **Mohammed Helmy** - [helmio](https://github.com/helmio)

## License

* This application can be freely used and developed.
